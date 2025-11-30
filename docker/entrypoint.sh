#!/bin/bash
set -e

echo "--- ENTRYPOINT INITIALIZATION ---"
echo "Time: $(date)"

# 1. Configure PORT
# Railway provides $PORT. We default to 80 if not set.
PORT=${PORT:-80}
echo "Binding to PORT: ${PORT}"

# 2. Laravel Setup
echo "Running Laravel setup commands..."
# Run migrations (ignore failure if database is not ready yet, though ideal to wait)
php artisan migrate --force || echo "Migration failed or skipped."

# Optimize caches
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Fix permissions
echo "Fixing storage permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

# 3. Apache Configuration
# Instead of using brittle 'sed' replacements, we explicitly write the configuration.
echo "Configuring Apache..."

# Set the Listen port
echo "Listen ${PORT}" > /etc/apache2/ports.conf

# Configure the VirtualHost
# We explicitly set DocumentRoot and the directory permissions.
cat <<EOF > /etc/apache2/sites-available/000-default.conf
<VirtualHost *:${PORT}>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html/public

    <Directory /var/www/html/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF

# Ensure the site is enabled
a2ensite 000-default

# 4. Start Apache
echo "Starting Apache in foreground..."
exec apache2-foreground

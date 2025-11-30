#!/bin/bash
set -e

# Ensure PORT has a sensible default (Railway provides $PORT at runtime)
PORT=${PORT:-80}

# Run Laravel migrations (optional, safe if none)
php artisan migrate --force || true

# Clear and cache config/routes/views (errors shouldn't stop startup)
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Ensure storage and cache directories are writable
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

# If you want Apache:
if [ "$USE_APACHE" = "true" ]; then
  # Patch Apache to listen on Railway's dynamic $PORT
  sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf || true

  # Also update VirtualHost definitions so they bind to the selected port
  sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/g" /etc/apache2/sites-available/*.conf /etc/apache2/sites-enabled/*.conf || true
  sed -i "s/:80\b/:${PORT}/g" /etc/apache2/sites-available/*.conf /etc/apache2/sites-enabled/*.conf || true

  echo "Starting Apache on port ${PORT}..."
  exec apache2-foreground
else
  # Simpler: use Laravel's built-in server
  echo "Starting Laravel server on port ${PORT}..."
  exec php artisan serve --host=0.0.0.0 --port=${PORT}
fi

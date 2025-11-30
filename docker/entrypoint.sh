#!/bin/bash
set -e

# Run Laravel migrations (optional, safe if none)
php artisan migrate --force || true

# Clear and cache config/routes/views
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ensure storage and cache directories are writable
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# If you want Apache:
if [ "$USE_APACHE" = "true" ]; then
  # Patch Apache to listen on Railway's dynamic $PORT
  sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
  echo "Starting Apache on port ${PORT}..."
  exec apache2-foreground
else
  # Simpler: use Laravel's built-in server
  echo "Starting Laravel server on port ${PORT}..."
  exec php artisan serve --host=0.0.0.0 --port=${PORT}
fi

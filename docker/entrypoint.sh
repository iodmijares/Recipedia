#!/bin/bash
set -e

echo "🚀 Running Laravel setup tasks..."

# Run migrations (safe if none)
php artisan migrate --force || true

# Clear and rebuild caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ensure storage and cache directories are writable
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

echo "✅ Laravel setup complete."

# Decide how to start the app
if [ "$USE_APACHE" = "true" ]; then
  echo "🔧 Configuring Apache to listen on port ${PORT}..."
  sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
  echo "🚀 Starting Apache on port ${PORT}..."
  exec apache2-foreground
else
  echo "🚀 Starting Laravel's built-in server on port ${PORT}..."
  exec php artisan serve --host=0.0.0.0 --port=${PORT}
fi

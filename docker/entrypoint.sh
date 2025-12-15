#!/bin/bash

# Exit on fail
set -e

# [FIX] Ensure only mpm_prefork is loaded (prevents "More than one MPM loaded" error)
echo "🔧 Ensuring correct Apache MPM configuration..."
rm -f /etc/apache2/mods-enabled/mpm_event.* /etc/apache2/mods-enabled/mpm_worker.* 2>/dev/null || true
if [ ! -L /etc/apache2/mods-enabled/mpm_prefork.load ]; then
    ln -sf ../mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load
    ln -sf ../mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf
fi

# 1. Run Setup Tasks (Keep these, they are working great!)
echo "🚀 Running Laravel setup tasks..."
php artisan migrate --force
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Laravel setup complete."

# 2. Fix Permissions (Safety check)
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 3. Start Apache (THE FIX)
# Do NOT use 'php artisan serve' here.
echo "🚀 Starting Apache..."
exec apache2-foreground
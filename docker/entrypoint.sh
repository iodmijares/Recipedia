#!/bin/bash
set -e

# Wait for database connection (optional but recommended if DB is in same stack, though Railway usually handles this)
# You might need a wait-for-it script if strictly necessary, but Laravel usually just fails and restarts.

echo "🚀 Starting deployment tasks..."



echo "📦 Running migrations..."
php artisan migrate --force

echo "🔥 Optimizing..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🚀 Starting Apache..."
exec apache2-foreground

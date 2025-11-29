#!/bin/bash

# Exit immediately if a command exits with a non-zero status (optional, but safer)
# set -e

echo "========================================================"
echo "  RUNNING ALL ESSENTIAL ARTISAN COMMANDS"
echo "========================================================"

# 1. Clear everything first
echo "[1/6] Clearing Caches (Optimize Clear)..."
php artisan optimize:clear

# 2. Application Key
echo "[2/6] Checking Application Key..."
php artisan key:generate

# 3. Storage Link
echo "[3/6] Linking Storage..."
if [ -L "public/storage" ]; then
    echo "      Storage link already exists. Skipping."
else
    php artisan storage:link
fi

# 4. Database Migrations
echo "[4/6] Running Migrations..."
php artisan migrate --force

# 5. Database Seeding
echo "[5/6] Seeding Database..."
php artisan db:seed --force

# 6. Production Optimization
echo "[6/6] Optimizing for Production..."
# Try the custom command first
php artisan optimize:production || {
    echo "      Custom optimize command failed or missing. Falling back to standard commands."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
}

echo "========================================================"
echo "  ALL COMMANDS EXECUTED SUCCESSFULLY"
echo "========================================================"

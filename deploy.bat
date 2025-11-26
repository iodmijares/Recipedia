@echo off
REM Simple Windows deployment helper for Recipedia
REM Edit environment variables on the server before running this script.

SET ROOT=%~dp0
cd /d "%ROOT%"

echo Installing PHP dependencies (production)...
composer install --no-dev --optimize-autoloader --classmap-authoritative

echo Building front-end assets...
npm ci
npm run build

echo Clearing config and cache to ensure current DB settings are used...
php artisan config:clear
php artisan cache:clear

echo Running database migrations (will use DB settings from .env)...
php artisan migrate --force

echo Creating storage symlink and optimizing caches...
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo Deployment steps complete. Review the output for errors.
pause

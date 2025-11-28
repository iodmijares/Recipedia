@echo off
REM Simple Windows deployment helper for Recipedia
REM Edit environment variables on the server before running this script.

SET ROOT=%~dp0
cd /d "%ROOT%"

echo Running database migrations...
php artisan migrate --force



echo Installing PHP dependencies (production)...
composer install --no-dev --optimize-autoloader --classmap-authoritative

echo Building front-end assets...
npm ci
npm run build

echo Optimizing application for production...
php artisan optimize:production

echo Creating storage symlink...
php artisan storage:link

echo Deployment steps complete. Review the output for errors.
pause

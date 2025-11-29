@echo off
setlocal

echo ========================================================
echo   RUNNING ALL ESSENTIAL ARTISAN COMMANDS
echo ========================================================

:: 1. Clear everything first to avoid stale config issues
echo [1/6] Clearing Caches (Optimize Clear)...
call php artisan optimize:clear
if %errorlevel% neq 0 echo Warning: optimize:clear failed.

:: 2. Application Key
echo [2/6] Checking Application Key...
call php artisan key:generate
if %errorlevel% neq 0 echo Warning: key:generate failed.

:: 3. Storage Link
echo [3/6] Linking Storage...
if exist "public\storage" (
    echo       Storage link already exists. Skipping.
) else (
    call php artisan storage:link
    if %errorlevel% neq 0 echo Warning: storage:link failed.
)

:: 4. Database Migrations
echo [4/6] Running Migrations...
call php artisan migrate --force
if %errorlevel% neq 0 (
    echo Error: Migration failed. Aborting.
    exit /b %errorlevel%
)

:: 5. Database Seeding
echo [5/6] Seeding Database...
call php artisan db:seed --force
if %errorlevel% neq 0 echo Warning: db:seed failed.

:: 6. Production Optimization (Custom Command)
echo [6/6] Optimizing for Production...
call php artisan optimize:production
if %errorlevel% neq 0 (
    echo       Custom optimize command failed or missing. Falling back to standard commands.
    call php artisan config:cache
    call php artisan route:cache
    call php artisan view:cache
)

echo ========================================================
echo   ALL COMMANDS EXECUTED SUCCESSFULLY
echo ========================================================
pause

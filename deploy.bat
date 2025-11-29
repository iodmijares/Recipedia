@echo off
setlocal enabledelayedexpansion

REM Deployment script for Recipedia (Windows)
REM - Run from project root
REM - Edit environment variables on the server before running

set ROOT=%~dp0
cd /d "%ROOT%"

REM Log file
set TIMESTAMP=%DATE:~-4%%DATE:~4,2%%DATE:~7,2%_%TIME:~0,2%%TIME:~3,2%%TIME:~6,2%
set LOG=%ROOT%deploy_%TIMESTAMP%.log
echo Deploy started at %DATE% %TIME% > "%LOG%"

REM Helper to run commands and fail on error
:run
echo. >> "%LOG%"
echo Running: %* >> "%LOG%"
%* >> "%LOG%" 2>&1
if ERRORLEVEL 1 (
  echo ERROR: command failed: %* >> "%LOG%"
  goto :failure
)
goto :eof

REM 0) Basic checks
where php >nul 2>&1 || (echo php not found & goto :failure)
where composer >nul 2>&1 || (echo composer not found & goto :failure)
where npm >nul 2>&1 || (echo npm not found & goto :failure)

REM 1) Put app into maintenance mode
call :run php artisan down --message="Maintenance - deploying" --retry=60 --no-interaction

REM 2) Install PHP dependencies (production)
call :run composer install --no-dev --optimize-autoloader --classmap-authoritative --no-interaction

REM 3) Build frontend assets (only if package.json exists)
if exist package.json (
  call :run npm ci --silent
  call :run npm run build --silent
) else (
  echo No package.json found - skipping frontend build >> "%LOG%"
)

REM 4) Run database migrations (force)
call :run php artisan migrate --force

REM 5) Create storage symlink if missing
if exist public\storage (
  echo public\storage exists - skipping link creation >> "%LOG%"
) else (
  call :run php artisan storage:link
)

REM 6) Cache/optimize (confirm `optimize:production` exists; otherwise use cache commands)
REM Prefer explicit cache commands — safer
call :run php artisan config:cache
call :run php artisan route:cache
call :run php artisan view:cache

REM 7) Bring app back up
call :run php artisan up

echo Deployment finished successfully at %DATE% %TIME% >> "%LOG%"
echo Done. See logfile: %LOG%
pause
exit /b 0

:failure
echo Deployment failed at %DATE% %TIME% >> "%LOG%"
echo See logfile: %LOG%
pause
exit /b 1
# Production Checklist for Recipedia

This document contains a concise checklist and commands to prepare the application for production.

Important: never commit secrets or the real `.env` file to the repo. Use environment variables on the server.

1) Build assets

Windows (cmd.exe):
```cmd
cd /d C:\laragon\www\web-app
npm ci
npm run build
```

Linux/macOS:
```bash
cd /var/www/recipedia
npm ci
npm run build
```

2) Install PHP dependencies (production)

```cmd
cd /d C:\laragon\www\web-app
composer install --no-dev --optimize-autoloader --classmap-authoritative
```

3) Application setup

```cmd
php artisan key:generate
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

4) Recommended production configuration
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_KEY` must be set
- Use a managed database (MySQL/Postgres) and set DB credentials in the server environment
- Use Redis for cache/session/queue if available
- Use HTTPS and set `SESSION_SECURE_COOKIE=true`

5) Security hardening suggestions
- Use a webserver reverse proxy (nginx) with HTTPS and HSTS
- Add Content-Security-Policy, X-Frame-Options, X-Content-Type-Options headers
- Limit file upload types and sizes, and validate uploaded files server-side

6) Backups and monitoring
- Schedule DB backups and storage backups
- Add error monitoring (Sentry, Logflare) and alerting

7) CI/CD
- Use the included GitHub Actions workflow to run tests and build assets on PR/push.

If you want, I can also add a deploy script for Linux or help create an automated pipeline.

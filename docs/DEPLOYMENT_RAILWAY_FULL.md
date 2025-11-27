# Full Deployment Guide: Railway (App + Database)

This guide explains how to deploy the **entire** Recipedia application (Laravel App + MySQL Database) on Railway.

**Why use this method?**
Unlike Vercel, Railway provides a persistent filesystem (if configured with volumes) or simply a more standard server environment where temporary file writes (like session files or cache) work out-of-the-box without complex configuration. It is generally easier for Laravel applications than Vercel.

## Step 1: Prepare Railway Project

1.  **Sign Up/Login:** Go to [railway.app](https://railway.app).
2.  **New Project:** Click "New Project" > "Provision MySQL".
    *   This creates a database container immediately.
3.  **Add Your Code:**
    *   Click "New" > "GitHub Repo".
    *   Select the `web-app` repository.
    *   It will deploy immediately, but it will likely fail or show a default page because environment variables are missing.

## Step 2: Configure Environment Variables

1.  Click on your **Laravel App Service** in the Railway graph.
2.  Go to the **Variables** tab.
3.  Add the following variables:

| Variable | Value / Instruction |
| :--- | :--- |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_KEY` | Run `php artisan key:generate --show` locally and copy the value. |
| `APP_URL` | The `https://...railway.app` domain provided by Railway (Settings > Networking). |
| `DB_CONNECTION`| `mysql` |
| `DB_HOST` | `${{MySQL.MYSQLHOST}}` (Railway auto-fills this variable from the linked DB) |
| `DB_PORT` | `${{MySQL.MYSQLPORT}}` |
| `DB_DATABASE` | `${{MySQL.MYSQLDATABASE}}` |
| `DB_USERNAME` | `${{MySQL.MYSQLUSER}}` |
| `DB_PASSWORD` | `${{MySQL.MYSQLPASSWORD}}` |
| `NIXPACKS_PHP_ROOT_DIR` | `.` (Optional, usually auto-detected) |

*Note: Railway allows you to reference other services' variables using the `${{Service.VAR}}` syntax. This keeps credentials safe and automatic.*

## Step 3: Build & Deploy

1.  Railway uses **Nixpacks** by default for PHP. It should automatically detect `composer.json` and build the app.
2.  **Build Command:** Railway usually infers this, but if you need to customize it (Settings > Build):
    ```bash
    npm ci && npm run build && composer install --no-dev --optimize-autoloader
    ```
3.  **Start Command:**
    **CRITICAL:** Do NOT use `php artisan serve` in production. It is single-threaded and slow.
    
    *   **Recommended:** Leave the Start Command **empty**. Railway's Nixpacks will automatically set up Nginx/Apache with PHP-FPM, which is much faster.
    *   **Custom (if needed):** `php artisan migrate --force && php artisan optimize:production && apache2-foreground`
    
    **Note:** If you leave it empty, you might need to run migrations manually or use a "Deploy Command".

## Step 4: Performance Tuning (New!)

We have added a `php.ini` file to the project root to enable **Opcache**. Railway should pick this up automatically.
*   **Action:** Ensure your Railway build includes this file.
*   **Code Optimization:** The application now uses Eager Loading to prevent database lag.

## Step 5: Credential Safety

*   **NEVER** commit your `.env` file. It is already in `.gitignore`.
*   **NEVER** share your Railway project link publicly if it has "Guest" permissions.
*   **Rotate Secrets:** If you suspect a leak, generate a new `APP_KEY` and update the Railway variable.

## Step 5: Storage (Images)

Even on Railway, the filesystem inside the container is ephemeral (reset on redeploy).
1.  **Use S3/R2:** Recommended for production.
2.  **Railway Volumes:** You can mount a Volume to `/app/storage/app/public` to persist uploaded files across deployments.

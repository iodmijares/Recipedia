# Deploying Recipedia to Railway 🚀

This guide details how to deploy the full Recipedia stack (Laravel App + MySQL Database) to [Railway](https://railway.app/).

## Prerequisites

1.  **Railway Account:** Sign up at [railway.app](https://railway.app/).
2.  **Railway CLI:** Installed on your machine.
    ```bash
    npm install -g @railway/cli
    ```

## Step-by-Step Deployment

### 1. Login to Railway
Open your terminal and log in:
```bash
railway login
```
*Follow the browser prompt to authenticate.*

### 2. Initialize Project
Navigate to your project root and initialize a new Railway project:
```bash
railway init
```
*Select "Empty Project" when prompted.*

### 3. Add a Database (MySQL)
Since Laravel requires a database, add MySQL to your Railway project:
1.  Run:
    ```bash
    railway add
    ```
2.  Select **Database** -> **MySQL**.

### 4. Configure Environment Variables
Your app needs to know how to connect to the database and other settings.

1.  Run `railway variables` to open the dashboard, OR set them via CLI.
2.  **Essential Variables** to set in Railway:
    *   `APP_NAME`: `Recipedia`
    *   `APP_ENV`: `production`
    *   `APP_DEBUG`: `false`
    *   `APP_URL`: `https://<your-railway-url>.up.railway.app` (You'll get this after first deploy, or set a custom domain)
    *   `APP_KEY`: (Generate one via `php artisan key:generate --show` locally and paste it)
    *   `DB_CONNECTION`: `mysql`
    *   **Database Variables** (Railway provides these automatically, but Laravel needs specific names):
        *   `DB_HOST`: `${MYSQLHOST}`
        *   `DB_PORT`: `${MYSQLPORT}`
        *   `DB_DATABASE`: `${MYSQLDATABASE}`
        *   `DB_USERNAME`: `${MYSQLUSER}`
        *   `DB_PASSWORD`: `${MYSQLPASSWORD}`
    *   `SESSION_DRIVER`: `cookie` (or `database` if you ran migrations)
    *   `LOG_CHANNEL`: `stderr` (Important for viewing logs in Railway)

### 5. Deploy
Deploy the application using the included `Dockerfile`.
```bash
railway up
```

### 6. Verify
1.  Railway will build the Docker image (installing Node dependencies, building assets, installing PHP dependencies).
2.  Once the build finishes, it will deploy.
3.  The `docker/entrypoint.sh` script will automatically run:
    *   `php artisan migrate --force` (Sets up your DB tables)
    *   `php artisan config:cache` (Optimizes configuration)
    *   Apache Server start.

## Troubleshooting

-   **Logs:** Use `railway logs` to see if startup failed.
-   **Migrations Failed:** Ensure the `DB_*` variables are correctly mapped to Railway's `${MYSQL*}` variables.
-   **White Screen/500 Error:** Check `APP_KEY` is set and `APP_DEBUG=true` temporarily to see the error.

## Deployment Command (Quick Reference)
After setup, for future deployments, just run:
```bash
railway up
```

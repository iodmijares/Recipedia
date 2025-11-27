# Deployment Guide: Vercel + Railway

This guide explains how to deploy the Recipedia Laravel application using **Vercel** for the application (web server) and **Railway** for the database.

## ⚠️ Important Limitations

**Read this before proceeding:**
Running Laravel on Vercel (Serverless) has one major limitation: **The filesystem is read-only and ephemeral.**
-   **Problem:** Files uploaded to `storage/app/public` (like recipe images or avatars) will **disappear** after a few minutes or a new deployment.
-   **Solution:** You must use an external storage service like **AWS S3**, **Cloudflare R2**, or **DigitalOcean Spaces** for file uploads.
-   **Alternative:** If you want simple local file storage, deploy the *entire* application to Railway instead of splitting it.

---

## Step 1: Database Setup (Railway)

1.  Create an account at [railway.app](https://railway.app).
2.  Create a **New Project**.
3.  Add a **MySQL** service.
4.  Click on the MySQL service and go to the **Variables** (or Connect) tab.
5.  Copy the following values (you will need them for Vercel):
    -   `MYSQLHOST` (DB_HOST)
    -   `MYSQLPORT` (DB_PORT)
    -   `MYSQLUSER` (DB_USERNAME)
    -   `MYSQLPASSWORD` (DB_PASSWORD)
    -   `MYSQLDATABASE` (DB_DATABASE)

## Step 2: Application Setup (Vercel)

1.  Create an account at [vercel.com](https://vercel.com).
2.  Install the Vercel CLI or connect your GitHub/GitLab repository.
3.  Import the project `web-app`.
4.  **Build Settings:**
    -   Framework Preset: `Other` (or Vercel may auto-detect, but ensure it uses the `vercel.json` configuration).
    -   Build Command: `npm run build` (Vercel usually detects this).
    -   Output Directory: `public` (or leave default, Vercel usually handles this with `vercel.json`).

5.  **Environment Variables:**
    Go to the **Settings > Environment Variables** section of your Vercel project and add the following:

    | Variable | Value |
    | :--- | :--- |
    | `APP_ENV` | `production` |
    | `APP_DEBUG` | `false` |
    | `APP_KEY` | (Generate one locally using `php artisan key:generate --show` and copy it here) |
    | `APP_URL` | `https://your-vercel-project.vercel.app` (Update this after deploy) |
    | `DB_CONNECTION` | `mysql` |
    | `DB_HOST` | (From Railway) |
    | `DB_PORT` | (From Railway) |
    | `DB_DATABASE` | (From Railway) |
    | `DB_USERNAME` | (From Railway) |
    | `DB_PASSWORD` | (From Railway) |
    | `SESSION_DRIVER` | `cookie` (Recommended for serverless) or `database` |
    | `CACHE_STORE` | `array` (if no Redis) or `database` |
    | `LOG_CHANNEL` | `stderr` |

    **If using S3 for file uploads (Highly Recommended):**
    -   `FILESYSTEM_DISK`: `s3`
    -   `AWS_ACCESS_KEY_ID`: ...
    -   `AWS_SECRET_ACCESS_KEY`: ...
    -   `AWS_DEFAULT_REGION`: ...
    -   `AWS_BUCKET`: ...

## Step 3: Deploy

1.  Push your code to your git repository.
2.  Vercel will automatically detect the commit and start building.
3.  Once deployed, check the logs in Vercel dashboard if you see any 500 errors.

## Step 4: Post-Deployment (Migrations)

Since Vercel is serverless, you cannot easily "SSH in" to run migrations.
You have two options:
1.  **Connect locally:** Connect your local machine to the Railway database (update your local `.env` with Railway credentials temporarily) and run `php artisan migrate --force`.
2.  **Migration Route:** (Not recommended for strict security, but possible) Create a temporary route in your code to trigger migrations.
3.  **Vercel Build Command:** You technically *can* run migrations during the build, but it's risky if the DB isn't reachable during build time. The **Connect locally** method is safest.

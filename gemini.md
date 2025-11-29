# Recipedia - Project Context & AI Notes

This file serves as a context reference for the Gemini AI agent regarding the **Recipedia** project.

## ⚠️ Core Agent Rules
- **Git Actions:** Do NOT commit or push changes to git unless **explicitly** asked/stated by the user.

## 🛠 Project Architecture
- **Framework:** Laravel 12.x
- **Language:** PHP 8.4+
- **Frontend:** 
  - Blade Templates
  - Tailwind CSS (configured via `tailwind.config.js`)
  - Bootstrap 5 (CSS/JS for specific components like Toasts/Modals)
  - Vanilla JavaScript
- **Database:**
  - Local: SQLite (`database/database.sqlite`)
  - Production: MySQL (via Railway)
- **Build Tool:** Vite (`npm run build`)

## 🚀 Deployment Strategy (Vercel + Railway)
- **Web Server:** Vercel (Serverless Function)
  - Config: `vercel.json` (using `vercel-php@0.7.2` runtime)
  - Entry Point: `public/index.php`
- **Database:** Railway (MySQL)
- **Critical Configs:**
  - `bootstrap/app.php`: Configured with `TrustProxies` to handle Vercel load balancers correctly.
  - `SESSION_DRIVER`: set to `cookie` or `database` for stateless environments.
  - **Limitations:** Vercel filesystem is read-only. Image uploads require S3/R2 drivers in production.

## 📝 Recent Changes Log (Nov 27, 2025)

### 1. Deployment Configuration
- **File:** `vercel.json`
  - Update: Upgraded version to 2, set runtime to `vercel-php@0.7.2`.
- **File:** `bootstrap/app.php`
  - Update: Added `TrustProxies` middleware configuration.
- **Documentation:** Created `docs/DEPLOYMENT_VERCEL_RAILWAY.md` with step-by-step deployment instructions.

### 2. Frontend Fixes
- **Login Page (`resources/views/auth/login.blade.php`)**
  - **Issue:** Blade `@foreach` loop inside `<script>` tag causing IDE syntax errors and potential runtime race conditions.
  - **Fix:** Refactored to pass all errors as a single JSON object (`@json($errors->all())`) and iterate using client-side JavaScript.
  
- **Toast Notifications (`resources/views/components/flash-messages.blade.php`)**
  - **Issue:** `showBootstrapToast` was not globally available, causing `ReferenceError` in other views.
  - **Fix:** 
    - Attached `showBootstrapToast` to `window` object.
    - Added safety checks for DOM elements and Bootstrap library presence.
    - Consolidated session message handling into a single `DOMContentLoaded` listener.

## 📂 Key Directory Structure
- `app/`: Core PHP logic (Models, Controllers).
- `resources/views/`: Blade templates.
- `public/`: Web root (assets, index.php).
- `routes/`: Web and API route definitions.
- `tests/`: Feature and Unit tests.
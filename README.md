# 🍽️ Recipedia - Community Recipe Book

A Laravel-based community recipe sharing platform where users can submit, browse, and manage recipes with email verification and admin moderation.

## ✨ Features

### 🔐 **Authentication System**
- User registration with OTP email verification
- Secure login/logout functionality
- Role-based access control (Admin/User)

### 📧 **Email Notifications**
- OTP verification emails for new users
- Admin notifications for new recipe submissions
- Recipe approval/rejection notifications

### 🍳 **Recipe Management**
- Submit recipes with images, ingredients, and instructions
- Browse approved recipes with search functionality
- Download recipes as text files
- Admin dashboard for recipe moderation

### 👨‍💼 **Admin Features**
- Review and approve/reject submitted recipes
- User role management
- Recipe statistics dashboard
- Email notifications for submissions

## 🚀 Installation

### Prerequisites
- PHP 8.2+
- MySQL/MariaDB
- Composer
- Node.js & NPM

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/recipedia.git
   cd recipedia
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   - Update `.env` with your database credentials
   - Create database: `community-recipe_db`

5. **Run migrations and seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Create storage link**
   ```bash
   php artisan storage:link
   ```

7. **Build assets**
   ```bash
   npm run build
   ```

8. **Start development server**
   ```bash
   php artisan serve
   ```

## ⚙️ Configuration

### Email Setup
Update `.env` with your email provider settings:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_FROM_ADDRESS=your_email@gmail.com
ADMIN_EMAIL=admin@example.com
```

### Admin User
Create an admin user:
```bash
php artisan user:set-role admin@example.com admin
```

## 🎯 Usage

### For Users
1. Register with email verification
2. Browse approved recipes
3. Submit new recipes for review
4. Download recipes as text files

### For Admins
1. Access admin dashboard at `/admin/dashboard`
2. Review pending recipe submissions
3. Approve or reject recipes with email notifications
4. Manage user roles

## 🏗️ Project Structure

```
app/
├── Http/Controllers/
│   ├── Auth/           # Authentication controllers
│   ├── AdminController.php
│   └── RecipeController.php
├── Mail/               # Email classes
├── Models/
│   ├── User.php
│   └── Recipe.php
└── ...

resources/views/
├── auth/               # Authentication views
├── admin/              # Admin dashboard
├── recipes/            # Recipe views
└── layouts/            # Layout templates
```

## 🔧 Commands

Generate dummy recipes:
```bash
php artisan recipe:generate 20
```

Set user role:
```bash
php artisan user:set-role user@example.com admin
```

List users and roles:
```bash
php artisan user:list-roles
```

## 📝 License

This project is open-source and available under the [MIT License](LICENSE).

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## 👨‍💻 Author

**Ivan Mijares**
- Email: iodmijares@usm.edu.ph
- GitHub: [@yourusername](https://github.com/yourusername)

---
Built with ❤️ using Laravel 12 and Tailwind CSS

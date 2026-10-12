# Sistem Manajemen Stok Barang (Laravel 12)

A clean, modern, and professional Stock Management System built with Laravel 12.

## Features
- **Admin Dashboard**: Visual analytics with Chart.js.
- **Inventory Management**: Master material data, stock logs, and dynamic units.
- **Order System**: Request-approval flow between Users and Admins.
- **Role-Based Access**: Secure separation between Admin and User functionalities.
- **Clean Light Mode**: A high-contrast, professional UI across all pages.

## Installation Tutorial (How to install on another device)

Follow these steps to set up the project on a new machine:

### 1. Prerequisites
Ensure you have the following installed:
- **XAMPP** (with PHP 8.2 or higher)
- **Composer**
- **Node.js & NPM**

### 2. Prepare the Database
1. Open XAMPP Control Panel and start **Apache** and **MySQL**.
2. Go to `phpMyAdmin` (usually `http://localhost/phpmyadmin`).
3. Create a new database named: `menejeman_barang`.

### 3. Setup Project Files
1. Copy the project folder to your new device (e.g., inside `C:\xampp\htdocs\`).
2. Open your terminal/command prompt inside the project folder.

### 4. Install Dependencies
Run these commands one by one:
```bash
# Install PHP dependencies
composer install

# Install Frontend dependencies
npm install
```

### 5. Environment Configuration
1. Find `.env.example` in the root folder.
2. Duplicate it and rename the copy to `.env`.
3. Open `.env` and ensure the database settings match your local setup:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=menejeman_barang
DB_USERNAME=root
DB_PASSWORD=
```
4. Generate the application key:
```bash
php artisan key:generate
```

### 6. Database Migration & Seeding
Run this command to create tables and add initial admin/user accounts:
```bash
php artisan migrate:fresh --seed
```

### 7. Compile Assets
```bash
npm run build
```

### 8. Run the Application
You can run it using:
```bash
php artisan serve
```
Then visit `http://127.0.0.1:8000` in your browser.

---

## Default Login Accounts
- **Admin**: `admin@example.com` / `password123`
- **User**: `user@example.com` / `password123`

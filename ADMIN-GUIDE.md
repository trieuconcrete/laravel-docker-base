# Admin Portal - Quick Start Guide

## 🚀 Access URLs

### Login Page
```
http://localhost:8000/login
```

### Admin Dashboard
```
http://localhost:8000/admin/dashboard
```

## 🔐 Default Login Credentials

### Admin Account
- **Email:** `admin@admin.com`
- **Password:** `password`

### Demo Account
- **Email:** `demo@demo.com`
- **Password:** `password`

### Test Account
- **Email:** `test@test.com`
- **Password:** `password`

## 📋 Available Admin Routes

### Dashboard & Profile
- `/admin/dashboard` - Main dashboard
- `/admin/profile` - User profile
- `/admin/settings` - Settings

### CMS Module
- `/admin/cms/posts` - Posts management
- `/admin/cms/categories` - Categories
- `/admin/cms/media` - Media library
- `/admin/cms/pages` - Pages

### E-commerce Module
- `/admin/products` - Products list
- `/admin/products/create` - Create product
- `/admin/orders` - Orders
- `/admin/customers` - Customers
- `/admin/inventory` - Inventory
- `/admin/analytics` - Analytics

### Job Portal Module
- `/admin/jobs/postings` - Job postings
- `/admin/jobs/applications` - Applications
- `/admin/jobs/employers` - Employers
- `/admin/jobs/workflow` - Workflow

### User Management
- `/admin/users` - Users list
- `/admin/users/create` - Create user
- `/admin/users/roles` - Roles
- `/admin/users/logs` - Activity logs

## 🛠️ Useful Commands

### Database
```bash
# Run migrations
make artisan cmd="migrate"

# Run seeders
make artisan cmd="db:seed"

# Fresh migration with seeding
make artisan cmd="migrate:fresh --seed"

# Rollback migration
make artisan cmd="migrate:rollback"
```

### Clear Cache
```bash
make artisan cmd="cache:clear"
make artisan cmd="config:clear"
make artisan cmd="route:clear"
make artisan cmd="view:clear"
```

### Create New Resources
```bash
# Create controller
make artisan cmd="make:controller Admin/ProductController --resource"

# Create model with migration
make artisan cmd="make:model Product -m"

# Create seeder
make artisan cmd="make:seeder ProductSeeder"
```

## 🎨 Features

✅ Responsive design (mobile, tablet, desktop)
✅ Dark mode support
✅ Multi-module admin panel
✅ User authentication & authorization
✅ Form validation
✅ Flash messages
✅ Search functionality
✅ Profile management
✅ Logout functionality

## 📝 Notes

- All routes are protected with authentication middleware
- CSRF protection is enabled on all forms
- Session-based authentication
- Password hashing with bcrypt
- Remember me functionality

## ⚠️ Security Reminder

**Change default passwords in production!**

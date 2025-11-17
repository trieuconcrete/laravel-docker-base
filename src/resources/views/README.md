# Laravel Admin Portal Templates

This directory contains Laravel Blade templates converted from the original HTML files.

## Structure

```
resources/views/
├── auth/
│   └── login.blade.php          # Login & Registration page
├── admin/
│   ├── dashboard.blade.php      # Main dashboard content
│   └── modules/                 # Module-specific views (to be created)
├── layouts/
│   └── admin.blade.php          # Main admin layout
└── partials/
    └── sidebar-menu.blade.php   # Sidebar navigation menu
```

## Features

### Login Page (`auth/login.blade.php`)
- Combined login and registration forms
- Dark mode support
- Social login integration (Google, Facebook)
- Laravel form validation integration
- CSRF protection
- Flash message support

### Admin Layout (`layouts/admin.blade.php`)
- Responsive sidebar navigation
- Dark mode toggle
- Search functionality
- Notifications
- User profile dropdown
- Flash message display
- Alpine.js for interactivity

### Dashboard (`admin/dashboard.blade.php`)
- KPI cards with dynamic data
- Recent activity feed
- Quick action buttons
- Responsive grid layout

### Sidebar Menu (`partials/sidebar-menu.blade.php`)
- Collapsible menu sections
- Active state highlighting
- Route-based navigation
- Support for:
  - CMS module
  - E-commerce module
  - Job Portal module
  - User Management
  - Settings

## Usage

### Controller Setup

```php
// app/Http/Controllers/Admin/DashboardController.php
public function index()
{
    $stats = [
        'total_users' => User::count(),
        'new_orders' => Order::today()->count(),
        'job_postings' => JobPosting::active()->count(),
        'posts' => Post::published()->count(),
    ];

    $recent_activities = Activity::latest()->take(10)->get();

    return view('admin.dashboard', compact('stats', 'recent_activities'));
}
```

### Routes

All admin routes are defined in `routes/web.php` with the following structure:
- `/admin/dashboard` - Main dashboard
- `/admin/cms/*` - CMS module routes
- `/admin/ecommerce/*` - E-commerce routes
- `/admin/jobs/*` - Job portal routes
- `/admin/users/*` - User management routes

## Customization

### Changing Colors

Edit the Tailwind config in the `<head>` section:

```javascript
tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: {
                    // Your custom color palette
                }
            }
        }
    }
}
```

### Adding New Menu Items

Edit `partials/sidebar-menu.blade.php`:

```blade
<a href="{{ route('admin.new-module') }}" 
   class="flex items-center px-4 py-3 rounded-lg transition-all">
    <i class="fas fa-icon-name w-5"></i>
    <span class="ml-3 font-medium">New Module</span>
</a>
```

### Creating New Module Views

Create new views in `resources/views/admin/modules/`:

```blade
@extends('layouts.admin')

@section('title', 'Module Name')

@section('content')
    <!-- Your module content -->
@endsection
```

## Dependencies

- **TailwindCSS**: Via CDN (consider installing via npm for production)
- **Font Awesome 6.4.0**: Icon library
- **Alpine.js 3.x**: Lightweight JavaScript framework
- **Laravel 11+**: Backend framework

## Notes

- All forms include CSRF protection
- Routes use named routes for easier maintenance
- Dark mode preference is stored in localStorage
- Mobile-responsive design included
- All external assets loaded via CDN (consider self-hosting for production)

## Next Steps

1. Install Laravel authentication (Breeze/Jetstream)
2. Create module-specific controllers and views
3. Implement actual database queries
4. Add form validation rules
5. Set up middleware for role-based access
6. Replace CDN assets with local assets
7. Implement actual social login functionality

# Database Seeder Setup

## Overview
User seeder has been created with default admin accounts for testing.

## Running Seeders

### Run all seeders:
```bash
make artisan cmd="db:seed"
```

Or using docker-compose directly:
```bash
docker-compose exec app php artisan db:seed
```

### Run specific seeder:
```bash
make artisan cmd="db:seed --class=UserSeeder"
```

### Fresh migration with seeding:
```bash
make artisan cmd="migrate:fresh --seed"
```

## Default User Accounts

### Admin Account
- **Email:** admin@admin.com
- **Password:** password

### Demo Account
- **Email:** demo@demo.com
- **Password:** password

### Test Account
- **Email:** test@test.com
- **Password:** password

## Login URL
After running the seeder, you can login at:
```
http://localhost:8000/login
```

## Security Note
⚠️ **Important:** Change these default passwords in production environment!

## Files Created
- `database/seeders/UserSeeder.php` - User seeder with default accounts
- `database/seeders/DatabaseSeeder.php` - Updated to call UserSeeder
- `database/migrations/2024_11_17_000001_add_phone_to_users_table.php` - Added phone field
- `app/Models/User.php` - Updated fillable fields to include phone

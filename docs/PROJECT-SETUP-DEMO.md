# 🎯 Command project:setup - Demo Workflow

## ✅ Đã Sửa Xong!

Command `project:setup` hiện đã có đầy đủ chức năng:
- ✅ **Hỏi và nhập tên database mới**
- ✅ **Tự động update file .env**
- ✅ **Reload database config trong Laravel**
- ✅ **Hiển thị thông tin database sau khi tạo**

---

## 🚀 Cách Sử Dụng

### Option 1: Interactive Mode (Khuyến nghị)

```bash
make project-setup
```

hoặc

```bash
docker-compose exec app php artisan project:setup
```

### Option 2: Quick Mode với Database Name

```bash
docker-compose exec app php artisan project:setup \
    --create-database \
    --db-name="my_project_db"
```

---

## 📝 Demo Workflow - Interactive Mode

```bash
$ make project-setup

🚀 Starting interactive project setup...
This will help you create a new database and admin user

🚀 Laravel Project Setup Wizard

✓ .env file exists

📊 Database Configuration
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

Current database: laravel
Do you want to create a new database? (yes/no) [no]:
> yes

Enter new database name [laravel_new]:
> my_project_db

Creating database: my_project_db...
   Creating database: my_project_db
   ✓ Database created successfully
   ✓ Updated .env file: DB_DATABASE=my_project_db

   Database configuration:
   • Host: mysql
   • Database: my_project_db
   • Username: laravel
   ✓ Database configuration reloaded

✓ Application key exists

Run database migrations? (yes/no) [yes]:
> yes

📦 Running migrations...
   ✓ Migrations completed

👤 Admin User Setup
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Create admin user now? (yes/no) [yes]:
> yes

Admin name [Administrator]:
> Super Admin

Admin email [admin@admin.com]:
> admin@mycompany.com

Generate random password? (yes/no) [no]:
> yes

   ✓ Admin user created successfully
   ⚠️  Save the password shown in summary below!

✓ Storage link exists

⚡ Optimizing application...
   ✓ Configuration cached
   ✓ Routes cached

🏥 Running health check...

[Health check output...]

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
✅ Project Setup Completed Successfully!
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

🌐 Application URL: http://localhost:8000
💾 Database: my_project_db

👤 Admin Login Credentials:
   📧 Email: admin@mycompany.com
   🔒 Password: k8Lm2Xp9QwRt5YzA

   ⚠️  IMPORTANT: Save this password now! It won't be shown again.

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

💡 Next steps:
   • Start development server: php artisan serve
   • Create more users: php artisan user:create
   • Check system health: php artisan project:health
   • Backup database: php artisan db:backup --compress

✅ New project setup completed!
```

---

## 🔍 Verify Database Update

Sau khi chạy command, kiểm tra file `.env` đã được update:

```bash
# Xem database name trong .env
docker-compose exec app grep "DB_DATABASE" .env

# Kết quả:
DB_DATABASE=my_project_db
```

Kiểm tra connection:

```bash
make project-health
# hoặc
make db-status
```

---

## 🎯 Use Cases

### Case 1: Setup Project Mới Với Database Riêng

```bash
make project-setup

# Interactive prompts:
# - Create new database? Yes
# - Database name: project_2026
# - Create admin? Yes
# - Admin email: admin@company.com
# - Random password? Yes

# Result:
# ✅ Database: project_2026 created
# ✅ .env updated: DB_DATABASE=project_2026
# ✅ Admin: admin@company.com / [random-password]
```

### Case 2: Quick Setup Với Tên Database Cụ Thể

```bash
docker-compose exec app php artisan project:setup \
    --create-database \
    --db-name="production_db" \
    --quick

# Result:
# ✅ Database: production_db created tự động
# ✅ .env updated
# ✅ Admin created với random password
```

### Case 3: Không Tạo Database Mới (Dùng DB Hiện Tại)

```bash
make project-setup

# Interactive prompts:
# - Create new database? No
# - Migrations? Yes
# - Create admin? Yes
# [... nhập thông tin admin ...]

# Result:
# ⏭️ Using existing database: laravel
# ✅ Migrations completed
# ✅ Admin created
```

---

## 🔧 Features Mới

### 1. ✅ Interactive Database Name Input

```php
Enter new database name [laravel_20260215_143052]:
> my_custom_db_name
```

- Default name: `laravel_YYYYMMDD_HHMMSS` nếu không nhập
- Tự động sanitize (loại bỏ ký tự đặc biệt)
- Validate tên database hợp lệ

### 2. ✅ Auto Update .env File

```php
✓ Updated .env file: DB_DATABASE=my_custom_db_name

Database configuration:
• Host: mysql
• Database: my_custom_db_name
• Username: laravel
```

- Update hoặc thêm mới `DB_DATABASE` trong .env
- Hiển thị full database config để verify

### 3. ✅ Reload Database Config

```php
✓ Database configuration reloaded
```

- Clear config cache
- Purge connection cũ
- Reconnect với database mới
- Laravel nhận database name mới ngay

### 4. ✅ Show Current Database

```php
Current database: laravel
Do you want to create a new database? (yes/no) [no]:
```

- Hiển thị database hiện tại trước khi hỏi
- Giúp quyết định có cần tạo mới không

---

## 📊 Database Name Validation

Command tự động validate và sanitize tên database:

```bash
Enter new database name [default]:
> my-special@db#name

Database name can only contain letters, numbers and underscores!
Using sanitized name: my_special_db_name
```

**Quy tắc:**
- Chỉ cho phép: `a-z`, `A-Z`, `0-9`, `_`
- Tự động thay thế ký tự không hợp lệ bằng `_`

---

## 🆘 Troubleshooting

### Lỗi: "Access denied for user 'laravel'@'%' to database"

```bash
✗ Failed to create database: SQLSTATE[42000]: Syntax error or access violation: 
1044 Access denied for user 'laravel'@'%' to database 'laravel_db'
```

**Nguyên nhân:**
- User `laravel` không có quyền CREATE DATABASE
- Chỉ MySQL root user mới có quyền tạo database mới

**✅ ĐÃ SỬA - Command tự động xử lý:**
Command giờ sẽ:
1. Tự động thử connect với root user (password: `root`)
2. Tạo database bằng root user
3. Grant quyền cho user `laravel` trên database mới
4. Nếu vẫn lỗi, thử tạo qua Docker MySQL command

**Không cần làm gì thêm - chạy lại command:**
```bash
make project-setup
```

**Nếu vẫn gặp lỗi, manual workaround:**

**Option 1: Tạo database qua Docker (Khuyến nghị)**
```bash
# Tạo database
docker-compose exec mysql mysql -u root -proot \
    -e "CREATE DATABASE IF NOT EXISTS laravel_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"

# Grant quyền cho user laravel
docker-compose exec mysql mysql -u root -proot \
    -e "GRANT ALL PRIVILEGES ON laravel_db.* TO 'laravel'@'%'; FLUSH PRIVILEGES;"

# Verify
docker-compose exec mysql mysql -u root -proot \
    -e "SHOW DATABASES LIKE 'laravel_db'"

# Sau đó update .env manually
docker-compose exec app sed -i 's/DB_DATABASE=.*/DB_DATABASE=laravel_db/g' .env

# Chạy migrations
docker-compose exec app php artisan migrate
```

**Option 2: Grant CREATE privilege cho user laravel (Không khuyến nghị)**
```bash
docker-compose exec mysql mysql -u root -proot \
    -e "GRANT CREATE ON *.* TO 'laravel'@'%'; FLUSH PRIVILEGES;"

# Sau đó chạy lại
make project-setup
```

---

### Lỗi: "Failed to create database"

```bash
✗ Failed to create database: Access denied
```

**Solution:**
- Kiểm tra user MySQL có quyền CREATE DATABASE
- Hoặc tạo database manually trước:

```bash
docker-compose exec mysql mysql -u root -p -e "CREATE DATABASE my_db"
```

### Database tạo thành công nhưng .env không update

**Solution:**
- File .env có thể read-only
- Kiểm tra permissions:

```bash
chmod 644 src/.env
```

### Laravel vẫn dùng database cũ sau khi update .env

**Solution:**
- Command đã tự động reload, nhưng nếu vẫn lỗi:

```bash
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan db:status
```

---

## 💡 Tips

1. **Backup trước khi setup:**
   ```bash
   make db-backup
   ```

2. **Verify database sau setup:**
   ```bash
   make db-status --detailed
   ```

3. **Test admin login:**
   - URL: http://localhost:8000
   - Email: (được hiển thị sau setup)
   - Password: (được hiển thị sau setup - save ngay!)

4. **Tạo thêm users:**
   ```bash
   make user-create
   ```

---

## 📚 Related Commands

```bash
# Setup commands
make project-setup              # Setup với interactive wizard
make project-setup-new          # Reset hoàn toàn (drop tables + setup)
make setup-fresh                # Alias của project-setup-new

# Database commands
make db-status                  # Xem thông tin database
make db-backup                  # Backup database
make db-restore                 # Restore từ backup

# User commands
make user-create                # Tạo user mới
make user-list                  # List tất cả users
make user-password email="..."  # Reset password

# Project commands
make project-health             # Health check services
make project-reset              # Reset project (fresh + seed)
```

---

**Updated**: 2026-02-15  
**Version**: 1.1.0  
**Status**: ✅ Fully Functional

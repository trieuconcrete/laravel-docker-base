# Custom Artisan Commands Documentation

## 📚 Available Commands

### User Management Commands

#### `user:create` - Tạo User Mới
Tạo user mới với các tùy chọn linh hoạt.

**Cách sử dụng:**
```bash
# Interactive mode (được khuyến nghị)
php artisan user:create --interactive

# Với các options
php artisan user:create --name="John Doe" --email="john@example.com" --password="SecurePass123"

# Tạo admin với password tự động
php artisan user:create --name="Admin" --email="admin@example.com" --random-password --admin --verified

# Qua Makefile
make user-create
```

**Options:**
- `--name` : Tên user
- `--email` : Email address
- `--password` : Password (nếu không cung cấp sẽ tạo random)
- `--admin` : Đánh dấu là admin
- `--verified` : Đánh dấu email đã verified
- `--random-password` : Tự động tạo password ngẫu nhiên
- `--interactive` : Chế độ tương tác với prompts

---

#### `user:password` - Reset Password
Reset password cho user hiện có.

**Cách sử dụng:**
```bash
# Interactive mode
php artisan user:password user@example.com

# Với password cụ thể
php artisan user:password user@example.com --password="NewPass123"

# Random password
php artisan user:password user@example.com --random

# Qua Makefile
make user-password email="user@example.com"
```

---

#### `user:list` - Liệt Kê Users
Hiển thị danh sách tất cả users trong hệ thống.

**Cách sử dụng:**
```bash
# Liệt kê tất cả users
php artisan user:list

# Chỉ users đã verified
php artisan user:list --verified

# Chỉ users chưa verified
php artisan user:list --unverified

# Giới hạn kết quả
php artisan user:list --limit=10

# Qua Makefile
make user-list
```

---

#### `user:delete` - Xóa User
Xóa user khỏi hệ thống (có confirmation).

**Cách sử dụng:**
```bash
# Xóa với confirmation
php artisan user:delete user@example.com

# Xóa không cần confirm
php artisan user:delete user@example.com --force

# Qua Makefile
make user-delete email="user@example.com"
```

---

### Project Management Commands

#### `project:reset` - Reset Project
Reset toàn bộ project (fresh migration + seed + clear cache).

**Cách sử dụng:**
```bash
# Reset với confirmation
php artisan project:reset

# Reset không cần confirm
php artisan project:reset --force

# Reset không seed
php artisan project:reset --no-seed

# Qua Makefile
make project-reset
```

**Các bước thực hiện:**
1. Drop all tables và migrate fresh
2. Seed database (nếu không dùng --no-seed)
3. Clear all caches
4. Optimize application

---

#### `project:health` - Health Check
Kiểm tra tình trạng của tất cả services.

**Cách sử dụng:**
```bash
# Basic health check
php artisan project:health

# Detailed information
php artisan project:health --detailed

# Qua Makefile
make project-health
```

**Kiểm tra:**
- ✅ Database connection & version
- ✅ Redis connection & memory
- ✅ Storage permissions
- ✅ Environment configuration

---

#### `project:setup` - Setup Wizard
Interactive setup wizard cho project mới với khả năng tạo database và admin user.

**Cách sử dụng:**
```bash
# Interactive setup (khuyến nghị)
php artisan project:setup

# Quick setup với defaults
php artisan project:setup --quick

# Setup với tạo database mới
php artisan project:setup --create-database

# Setup với tên database tùy chỉnh
php artisan project:setup --create-database --db-name="my_new_database"

# Qua Makefile
make project-setup
```

**Options:**
- `--quick` : Bỏ qua prompts và dùng defaults
- `--create-database` : Tạo database mới
- `--db-name` : Tên database tùy chỉnh (kết hợp với --create-database)

**Các bước thực hiện:**
1. Kiểm tra và tạo .env file
2. **Tạo database mới (optional)** - Có thể chọn tạo database riêng với tên tùy chỉnh
3. Generate APP_KEY
4. Run migrations
5. **Tạo Admin User** - Interactive tạo admin với email/password tùy chỉnh hoặc random
6. Create storage link
7. Cache configuration
8. Run health check

**Admin User Creation:**
- Chế độ interactive: Nhập name, email, password tùy chỉnh
- Chế độ quick: Tự động tạo với random password
- Password được hiển thị sau khi setup (lưu lại!)
- Không cần chạy seeder riêng

**Example Workflow:**
```bash
# Setup project mới với database và admin riêng
php artisan project:setup

# Trả lời các câu hỏi:
# - Create new database? Yes
# - Database name: my_project_db
# - Run migrations? Yes
# - Create admin user? Yes
# - Admin name: John Administrator
# - Admin email: john@company.com
# - Generate random password? Yes

# Kết quả:
# ✅ Database created: my_project_db
# ✅ Admin created: john@company.com
# 🔒 Password: AbC123XyZ (shown once!)
```

---

### Database Management Commands

#### `db:status` - Database Status
Hiển thị thông tin database và connection status.

**Cách sử dụng:**
```bash
# Basic status
php artisan db:status

# Detailed với table info
php artisan db:status --detailed

# Qua Makefile
make db-status
```

**Hiển thị:**
- Connection status
- Database driver & version
- Table count & rows
- Migration information

---

#### `db:backup` - Database Backup
Tạo backup của database.

**Cách sử dụng:**
```bash
# Backup cơ bản
php artisan db:backup

# Backup với compression
php artisan db:backup --compress

# Custom backup name
php artisan db:backup --name="manual_backup_$(date +%Y%m%d).sql"

# Custom path
php artisan db:backup --path="/custom/backup/path" --compress

# Qua Makefile
make db-backup
```

**Features:**
- ✅ Automatic compression (with --compress)
- ✅ Timestamped filenames
- ✅ Auto-cleanup (giữ 10 backups mới nhất)
- ✅ File size reporting
- 📁 Mặc định lưu tại: `storage/backups/`

---

#### `db:restore` - Database Restore
Restore database từ backup file.

**Cách sử dụng:**
```bash
# Restore latest backup
php artisan db:restore --latest

# Restore specific file
php artisan db:restore backup_file.sql

# Restore với full path
php artisan db:restore /path/to/backup.sql.gz

# No confirmation
php artisan db:restore --latest --force

# Interactive selection
php artisan db:restore

# Qua Makefile
make db-restore
```

**Features:**
- ✅ Interactive backup selection
- ✅ Hỗ trợ compressed files (.gz)
- ✅ Safety confirmation
- ✅ File size & date display

---

## 🎯 Quick Reference - Makefile Commands

```bash
# User Management
make user-create              # Tạo user mới (interactive)
make user-password email="user@example.com"
make user-list
make user-delete email="user@example.com"

# Project Management
make project-reset            # Reset toàn bộ project
make project-health          # Health check
make project-setup           # Setup wizard

# Database Management
make db-status               # Database info
make db-backup               # Backup database
make db-restore              # Restore database
```

---

## 🔧 Environment Variables for UserSeeder

Thêm vào file `.env` để tùy chỉnh passwords khi seeding:

```env
# Default password cho development (mặc định: "password")
SEEDER_DEFAULT_PASSWORD=YourSecurePassword123

# Sử dụng random passwords (production)
SEEDER_USE_RANDOM_PASSWORDS=true
```

**Khuyến nghị:**
- 🔐 Development: Sử dụng `SEEDER_DEFAULT_PASSWORD` để dễ test
- 🔐 Production: Bật `SEEDER_USE_RANDOM_PASSWORDS=true` và lưu passwords được generate

---

## 📝 Notes

1. **Laravel auto-discovery**: Tất cả commands tự động được phát hiện từ `app/Console/Commands/`
2. **Permissions**: Database backup/restore cần `mysqldump` và `mysql` CLI tools
3. **Docker**: Sử dụng Makefile commands khi chạy trong Docker environment
4. **Production**: Luôn sử dụng `--force` flag trong automation scripts

---

## 🚀 Examples - Common Workflows

### Setup Project Lần Đầu
```bash
# Trong Docker
make project-setup

# Hoặc trực tiếp
docker-compose exec app php artisan project:setup
```

### Tạo Admin User Mới
```bash
make user-create
# Chọn interactive mode và điền thông tin
```

### Reset Development Environment
```bash
make project-reset
# Database sẽ được reset về trạng thái clean
```

### Backup Trước Khi Deploy
```bash
make db-backup
# Backup được lưu tại storage/backups/
```

### Restore Sau Khi Có Vấn Đề
```bash
make db-restore
# Chọn backup file từ danh sách
```

---

## 🐛 Troubleshooting

### Command không tìm thấy
```bash
# Clear cache và reload
php artisan optimize:clear
php artisan list
```

### Database backup/restore failed
```bash
# Kiểm tra MySQL client tools
which mysqldump
which mysql

# Test database connection
php artisan db:status
```

### Permission errors
```bash
# Fix storage permissions
make perm

# Hoặc
chmod -R 775 storage bootstrap/cache
```

---

**Version**: 1.0.0  
**Laravel**: 12.x  
**Created**: 2026-02-15

# 🚀 Project Setup Guide

Hướng dẫn setup project Laravel Docker từ đầu với database và admin user mới.

---

## 📋 Table of Contents

1. [Setup Project Mới Hoàn Toàn](#setup-project-mới-hoàn-toàn)
2. [Setup Project Hiện Tại](#setup-project-hiện-tại)
3. [Setup Commands So Sánh](#setup-commands-so-sánh)
4. [Workflow Examples](#workflow-examples)

---

## 🆕 Setup Project Mới Hoàn Toàn

### Option 1: Interactive Setup (Khuyến nghị) ⭐

Setup hoàn chỉnh với wizard, tạo database mới và admin user tùy chỉnh:

```bash
make project-setup
```

**Workflow:**
1. 📝 Kiểm tra và tạo `.env` file
2. 📊 **Hỏi: "Tạo database mới?"** → Nhập tên database (vd: `my_project_db`)
3. 🔑 Generate `APP_KEY`
4. 🗄️ Run migrations
5. 👤 **Hỏi: "Tạo admin user?"** → Nhập thông tin admin
   - Name: Administrator
   - Email: admin@company.com
   - Password: (tự nhập hoặc generate random)
6. 🔗 Create storage link
7. ⚡ Optimize & cache
8. 🏥 Health check
9. ✅ Hiển thị thông tin login admin (kể cả password nếu random)

**Ưu điểm:**
- ✅ Interactive, dễ customize
- ✅ Tạo database riêng với tên tùy chỉnh
- ✅ Tạo admin user với thông tin tùy chỉnh
- ✅ Password được hiển thị ngay (save lại!)
- ✅ Không cần chạy seeder

---

### Option 2: Setup Mới Với Drop Tables (Nguy hiểm!) ⚠️

Setup project hoàn toàn mới, **xóa tất cả tables hiện tại** trước:

```bash
make project-setup-new
```

hoặc

```bash
make setup-fresh
```

**⚠️ WARNING:** Command này sẽ:
1. 🗑️ **Drop ALL existing tables** (db:wipe)
2. 🔄 Chạy setup wizard để tạo database + admin mới

**Khi nào dùng:**
- Reset project về trạng thái hoàn toàn mới
- Development environment cần làm sạch
- Sau khi thay đổi lớn về database schema

**Không dùng khi:**
- Production environment
- Có data quan trọng cần giữ

---

## 🔧 Setup Project Hiện Tại

### Setup Với Database Có Sẵn

Nếu đã có database và chỉ cần setup Laravel:

```bash
# Old method (deprecated, sẽ hỏi confirm)
make setup

# Recommended: Dùng project-setup không tạo DB mới
docker-compose exec app php artisan project:setup
# → Trả lời "No" khi hỏi create database
```

---

## 📊 Setup Commands So Sánh

| Command | Mục đích | Tạo DB mới | Tạo Admin | Drop tables | Interactive |
|---------|----------|------------|-----------|-------------|-------------|
| `make project-setup` | **Setup mới (khuyến nghị)** | ✅ Tùy chọn | ✅ Yes | ❌ No | ✅ Yes |
| `make project-setup-new` | **Reset hoàn toàn** | ✅ Tùy chọn | ✅ Yes | ✅ Yes | ✅ Yes |
| `make setup-fresh` | Alias của setup-new | ✅ Tùy chọn | ✅ Yes | ✅ Yes | ✅ Yes |
| `make setup` | Setup cũ (deprecated) | ❌ No | ❌ No | ❌ No | ❌ No |
| `make project-reset` | Reset DB + seed | ❌ No | ❌ Seed | ✅ Yes | ⚠️ Prompt |

---

## 🎯 Workflow Examples

### Workflow 1: Setup Project Mới Lần Đầu

```bash
# 1. Clone repository
git clone <repo-url>
cd laravel-docker-base

# 2. Start Docker containers
docker-compose up -d

# 3. Chạy setup wizard
make project-setup
```

**Interactive Questions & Answers:**
```
🚀 Laravel Project Setup Wizard

✓ .env file exists

📊 Database Configuration
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Do you want to create a new database? (yes/no) [no]: 
> yes

Database name [laravel_xxxx]: 
> my_project_2026

   Creating database: my_project_2026
   ✓ Database created successfully
   ✓ Updated .env with new database name

🔑 Generating application key...
   ✓ Application key generated

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

[... storage, cache, health check ...]

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
✅ Project Setup Completed Successfully!
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

🌐 Application URL: http://localhost:8000
💾 Database: my_project_2026

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
```

**💾 Save ngay:**
- Email: `admin@mycompany.com`
- Password: `k8Lm2Xp9QwRt5YzA`

---

### Workflow 2: Reset Project Về Trạng Thái Mới

Khi cần xóa tất cả và bắt đầu lại:

```bash
# Backup trước (optional)
make db-backup

# Reset hoàn toàn
make project-setup-new

# Sẽ hỏi confirm vì nguy hiểm:
# Continue? [y/N]: y

# Sau đó chạy interactive setup để tạo DB + admin mới
```

---

### Workflow 3: Setup Nhanh (Quick Mode)

Không muốn trả lời câu hỏi, dùng defaults:

```bash
docker-compose exec app php artisan project:setup --quick

# Tự động:
# - Dùng database hiện tại
# - Tạo admin với random password
# - Hiển thị password để save
```

---

### Workflow 4: Setup Với Tên Database Cụ Thể

Chỉ định tên database trước:

```bash
docker-compose exec app php artisan project:setup \
    --create-database \
    --db-name="production_db_2026"

# Vẫn interactive cho phần admin user
```

---

## 🔐 Security Best Practices

### Development Environment

```env
# .env for development
SEEDER_DEFAULT_PASSWORD=password123
SEEDER_USE_RANDOM_PASSWORDS=false
```

**Dùng `make project-setup`:**
- ✅ Nhập password đơn giản để dễ nhớ khi dev
- ✅ Hoặc dùng random và save vào password manager

---

### Production Environment

```env
# .env for production
SEEDER_USE_RANDOM_PASSWORDS=true
# Không set SEEDER_DEFAULT_PASSWORD
```

**Dùng `make project-setup`:**
- ✅ **Bắt buộc** chọn random password
- ✅ Save password ngay vào password manager
- ✅ Không dùng password mặc định như "password"

---

## 📁 File Structure After Setup

```
laravel-docker-base/
├── src/
│   ├── .env                          # Đã được config với DB mới
│   ├── app/
│   │   └── Console/Commands/         # Custom commands
│   │       ├── User/
│   │       ├── Project/
│   │       └── Database/
│   ├── database/
│   │   ├── migrations/               # Đã migrate
│   │   └── seeders/                  # Không cần chạy (admin tạo bằng command)
│   └── storage/
│       ├── backups/                  # Sẽ tạo khi backup
│       └── logs/
└── docker-compose.yml
```

---

## 🆘 Troubleshooting

### Lỗi: "Database connection failed"

```bash
# Kiểm tra containers đang chạy
docker-compose ps

# Kiểm tra MySQL ready
docker-compose logs mysql

# Test connection
make project-health
```

### Lỗi: "Database already exists"

```bash
# Option 1: Dùng database hiện tại
docker-compose exec app php artisan project:setup
# → Chọn "No" khi hỏi create database

# Option 2: Drop và tạo mới
make project-setup-new
```

### Lỗi: "Admin user already exists"

```bash
# Tạo user khác
docker-compose exec app php artisan user:create --interactive

# Hoặc reset password user hiện tại
docker-compose exec app php artisan user:password admin@admin.com --random
```

### Quên Password Admin

```bash
# Reset password
docker-compose exec app php artisan user:password admin@mycompany.com --random

# Hoặc set password cụ thể
docker-compose exec app php artisan user:password admin@mycompany.com
# → Nhập password mới
```

---

## 📚 Related Documentation

- [COMMANDS.md](COMMANDS.md) - Chi tiết tất cả custom commands
- [README.md](README.md) - Project overview
- [DEPLOYMENT.md](DEPLOYMENT.md) - Production deployment guide
- [Makefile](Makefile) - All available make commands

---

## 🎉 Quick Reference

**Setup project mới lần đầu:**
```bash
make project-setup
```

**Reset project hoàn toàn:**
```bash
make project-setup-new
```

**Tạo thêm users:**
```bash
make user-create
```

**Backup trước khi làm gì đó:**
```bash
make db-backup
```

**Kiểm tra health:**
```bash
make project-health
```

---

**Version**: 1.0.0  
**Updated**: 2026-02-15  
**Laravel**: 12.x

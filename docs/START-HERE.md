# 🚀 START HERE - Laravel 12 Docker Project

## ⚡ TL;DR - Cài Đặt Nhanh

```bash
cd laravel-docker-base
chmod +x setup.sh
./setup.sh
```

✅ Xong! Truy cập: http://localhost:8000

---

## ✅ Đã Fix Port Conflict

**Lỗi ban đầu:**
```
Error: Ports are not available: listen tcp 0.0.0.0:3306: bind: address already in use
```

**Đã được fix:** MySQL giờ sử dụng port **3307** (thay vì 3306)

---

## 📋 Bạn Có Gì?

### ✨ Docker Stack Hoàn Chỉnh
- ✅ Nginx (Web server)
- ✅ PHP 8.3 (Laravel 12)
- ✅ MySQL 8.0 (Port: 3307)
- ✅ Redis (Cache/Sessions)
- ✅ Mailhog (Email testing)

### 📚 Tài Liệu (9 files - 45K+)
1. **QUICKSTART.md** ← Bắt đầu đây! ⭐
2. **README.md** - Hướng dẫn đầy đủ
3. **INSTALL.md** - 4 cách cài đặt
4. **DEPLOYMENT.md** - Deploy production
5. **PORT-CONFLICTS.md** - Fix port issues
6. **CHEATSHEET.md** - Lệnh hay dùng
7. **INDEX.md** - Tổng hợp
8. **CHANGELOG.md** - Lịch sử
9. **SUMMARY.md** - Tóm tắt

### 🛠️ Tools (5 scripts)
- `setup.sh` - Auto setup
- `healthcheck.sh` - Kiểm tra health
- `backup.sh` - Backup DB
- `restore.sh` - Restore DB
- `Makefile` - 20+ lệnh

---

## 🎯 Bạn Muốn Làm Gì?

### 1️⃣ Cài Laravel 12 mới
```bash
./setup.sh
# Hoặc
make install-laravel
```

### 2️⃣ Đã có source Laravel
```bash
# Copy source vào src/
cp -r /path/to/laravel/* ./src/

# Setup
make setup
```

### 3️⃣ Clone từ Git
```bash
git clone <repo>
cd laravel-docker-base
make setup
```

### 4️⃣ Deploy production
👉 Đọc **DEPLOYMENT.md**

### 5️⃣ Fix port conflicts
👉 Đọc **PORT-CONFLICTS.md**

### 6️⃣ Xem lệnh thường dùng
👉 Đọc **CHEATSHEET.md**

---

## 📊 Thông Tin Quan Trọng

### URLs
- **Web**: http://localhost:8000
- **Mailhog**: http://localhost:8025

### Database (⚠️ Port đã đổi)
```
Host: localhost
Port: 3307          ← Thay đổi từ 3306
Database: laravel
Username: laravel
Password: secret
```

### Laravel .env
```env
DB_HOST=mysql       ← Service name
DB_PORT=3306        ← Internal port
```

---

## 🚦 Lệnh Cơ Bản

```bash
make help            # Xem tất cả lệnh
make up              # Khởi động
make down            # Dừng
make shell           # Vào container
make logs            # Xem logs
make migrate         # Run migration
./healthcheck.sh     # Check health
./backup.sh          # Backup DB
```

---

## 📖 Nên Đọc Gì?

### Mới bắt đầu?
1. **QUICKSTART.md** (1-2 phút)
2. **README.md** (5 phút)
3. **CHEATSHEET.md** (tham khảo)

### Đã biết Docker?
1. **README.md**
2. Xem `docker-compose.yml`
3. **DEPLOYMENT.md** (nếu cần)

### Laravel Developer?
1. **QUICKSTART.md**
2. **CHEATSHEET.md**
3. Copy source vào `src/`
4. `make setup`

---

## ⚠️ Lưu Ý Quan Trọng

1. **MySQL port đã đổi**: 3307 (thay vì 3306)
2. **Source phải ở**: `src/` folder
3. **File .env ở**: `src/.env` (không phải root)
4. **Từ container**: Dùng `mysql:3306`
5. **Từ host**: Dùng `localhost:3307`

---

## 🎁 Bonus Features

- ✅ Auto setup script
- ✅ Health check
- ✅ Database backup/restore
- ✅ 20+ Makefile commands
- ✅ Production config
- ✅ OPcache enabled
- ✅ Redis cache/sessions
- ✅ Mailhog for testing
- ✅ Complete documentation

---

## 🆘 Gặp Vấn Đề?

1. Chạy: `./healthcheck.sh`
2. Xem: `make logs`
3. Đọc: **INSTALL.md** (Troubleshooting)
4. Port conflict? → **PORT-CONFLICTS.md**

---

## ⚡ Quick Actions

| Muốn | Làm Gì |
|------|--------|
| Bắt đầu ngay | `./setup.sh` |
| Xem lệnh | `make help` |
| Check health | `./healthcheck.sh` |
| Vào container | `make shell` |
| Backup DB | `./backup.sh` |
| Fix port 3306 | Đọc PORT-CONFLICTS.md |
| Deploy | Đọc DEPLOYMENT.md |

---

## 📁 File Structure

```
laravel-docker-base/
├── 📂 docker/          Docker configs
├── 📂 src/             ⭐ Laravel code (đặt ở đây)
├── 📂 backups/         DB backups
├── 🐳 docker-compose.yml
├── 📝 [9 MD files]     Documentation
├── 🔧 [5 scripts]      Tools
└── ⚙️  Makefile        Commands
```

---

## ✨ What's Next?

```bash
# 1. Setup
./setup.sh

# 2. Truy cập
http://localhost:8000

# 3. Làm việc
make shell
php artisan make:model Product -mcr
php artisan migrate

# 4. Test email
# Gửi từ app → Xem tại http://localhost:8025

# 5. Done!
make down
```

---

## 🎉 Ready?

**Chạy ngay:**
```bash
./setup.sh
```

**Hoặc tìm hiểu thêm:**
```bash
cat QUICKSTART.md
cat README.md
make help
```

---

**Have fun building with Laravel! 🚀**

*Tất cả đã sẵn sàng. Chỉ cần bắt đầu!* ✨

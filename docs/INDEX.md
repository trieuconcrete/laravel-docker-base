# 📚 Tài liệu Laravel Docker

## Cấu trúc Project

```
laravel-docker-base/
├── docker/                    # Docker configurations
│   ├── nginx/
│   │   └── default.conf      # Nginx config
│   └── php/
│       ├── Dockerfile        # PHP-FPM image
│       └── php.ini           # PHP settings
├── src/                      # ⭐ Laravel source code
├── backups/                  # Database backups (auto-generated)
├── docker-compose.yml        # Docker config
├── docker-compose.prod.yml   # Production config
├── Makefile                  # Utility commands
├── setup.sh                  # Auto setup script
├── backup.sh                 # Database backup
├── restore.sh                # Database restore
├── healthcheck.sh            # Health check
└── [Tài liệu]
```

---

## 📖 Hướng dẫn

### 🚀 Bắt đầu nhanh
- **QUICKSTART.md** - Hướng dẫn cài đặt nhanh trong 3 bước

### 📝 Chi tiết
- **README.md** - Tổng quan đầy đủ về project
- **INSTALL.md** - 4 phương pháp cài đặt chi tiết
- **DEPLOYMENT.md** - Hướng dẫn deploy production
- **PORT-CONFLICTS.md** - 🔧 Xử lý xung đột ports (MySQL 3306→3307)

### 💰 Google API & Tích hợp
- **GOOGLE-API-PRICING-REPORT.md** - 📊 Báo cáo chi phí Google Maps API
- **FIX-GOOGLE-API-ERROR.md** - 🔧 Hướng dẫn fix lỗi API Not Activated
- **GOOGLE-DISTANCE-INTEGRATION.md** - 📍 Tích hợp tính khoảng cách
- **OPENSTREETMAP-INTEGRATION.md** - 🗺️ Phương án thay thế miễn phí

### 📄 File này
- **INDEX.md** - Tổng hợp tài liệu (file này)

---

## ⚡ Quick Commands

```bash
# Xem tất cả lệnh
make help

# Cài Laravel mới
make install-laravel

# Setup với source có sẵn
make setup

# Khởi động
make up

# Dừng
make down

# Xem logs
make logs

# Vào container
make shell

# Migration
make migrate

# Clear cache
make cache-clear

# Health check
./healthcheck.sh

# Backup database
./backup.sh

# Restore database
./restore.sh backups/file.sql.gz
```

---

## 🌐 URLs

- **Application**: http://localhost:8000
- **Mailhog**: http://localhost:8025

---

## 🗄️ Database

- **Host**: localhost:3307 (từ host) hoặc mysql:3306 (từ container)
- **Database**: laravel
- **Username**: laravel
- **Password**: secret

---

## 🎯 Các Tình Huống Thường Gặp

### 1. Cài Laravel mới hoàn toàn
👉 Đọc: **QUICKSTART.md**

### 2. Đã có source Laravel, muốn chạy
👉 Đọc: **INSTALL.md** - Phương pháp 1

### 3. Clone từ Git về
👉 Đọc: **INSTALL.md** - Phương pháp 4

### 4. Deploy lên production
👉 Đọc: **DEPLOYMENT.md**

### 5. Gặp lỗi khi cài đặt
👉 Đọc: **INSTALL.md** - Phần Troubleshooting

### 6. Backup và restore database
👉 Chạy `./backup.sh` và `./restore.sh`

### 7. Kiểm tra health
👉 Chạy `./healthcheck.sh`

---

## 📦 Services

| Service | Port | Container Name |
|---------|------|----------------|
| Nginx | 8000 | laravel_nginx |
| PHP-FPM | - | laravel_app |
| MySQL | 3307 → 3306 | laravel_mysql |
| Redis | 6379 | laravel_redis |
| Mailhog UI | 8025 | laravel_mailhog |
| Mailhog SMTP | 1025 | laravel_mailhog |

---

## 🔧 Makefile Commands

| Command | Description |
|---------|-------------|
| `make help` | Hiển thị tất cả lệnh |
| `make install-laravel` | Cài Laravel 12 mới |
| `make setup` | Setup với source có sẵn |
| `make up` | Khởi động containers |
| `make down` | Dừng containers |
| `make restart` | Restart containers |
| `make logs` | Xem logs |
| `make ps` | Xem status |
| `make shell` | Vào app container |
| `make composer cmd="..."` | Chạy composer |
| `make artisan cmd="..."` | Chạy artisan |
| `make migrate` | Chạy migrations |
| `make fresh` | Fresh migrate + seed |
| `make test` | Chạy tests |
| `make cache-clear` | Clear all cache |
| `make optimize` | Optimize app |
| `make perm` | Fix permissions |

---

## 🛠️ Scripts

| Script | Description |
|--------|-------------|
| `./setup.sh` | Cài đặt tự động |
| `./healthcheck.sh` | Kiểm tra health |
| `./backup.sh` | Backup database |
| `./restore.sh <file>` | Restore database |

---

## 📚 Workflow Thông Thường

### Development

```bash
# 1. Khởi động
make up

# 2. Vào container
make shell

# 3. Làm việc với Laravel
php artisan make:model Post -mcr
php artisan migrate

# 4. Xem logs khi cần
make logs

# 5. Dừng khi xong
make down
```

### Git Workflow

```bash
# 1. Clone project
git clone <repository>
cd laravel-docker-base

# 2. Setup (nếu src/ đã có Laravel)
make setup

# 3. Hoặc cài Laravel mới
make install-laravel

# 4. Làm việc
make shell

# 5. Commit changes
git add .
git commit -m "Your message"
git push
```

### Production Deployment

```bash
# 1. Trên server, clone project
git clone <repository>
cd laravel-docker-base

# 2. Copy source vào src/
cp -r /path/to/laravel/* ./src/

# 3. Cấu hình .env production

# 4. Deploy
docker-compose -f docker-compose.yml -f docker-compose.prod.yml up -d

# 5. Setup
docker-compose exec app composer install --no-dev
docker-compose exec app php artisan migrate --force
docker-compose exec app php artisan config:cache
```

---

## 🆘 Cần Trợ Giúp?

1. Chạy `make help` để xem lệnh
2. Chạy `./healthcheck.sh` để kiểm tra
3. Xem logs: `make logs`
4. Đọc **INSTALL.md** phần Troubleshooting
5. Đọc **README.md** để hiểu rõ hơn

---

## ✅ Checklist Sau Khi Cài Đặt

- [ ] Containers đang chạy (`docker-compose ps`)
- [ ] Application truy cập được (http://localhost:8000)
- [ ] Database kết nối được (`make migrate`)
- [ ] Redis hoạt động
- [ ] Mailhog hoạt động (http://localhost:8025)
- [ ] Permissions đúng (`make perm`)

---

## 🎓 Learning Path

### Người mới bắt đầu
1. Đọc **QUICKSTART.md**
2. Chạy `make install-laravel`
3. Truy cập http://localhost:8000
4. Khám phá với `make help`

### Có kinh nghiệm Docker
1. Đọc **README.md**
2. Xem `docker-compose.yml`
3. Tùy chỉnh theo nhu cầu
4. Đọc **DEPLOYMENT.md** cho production

### Laravel Developer
1. Copy source vào `src/`
2. Chạy `make setup`
3. Làm việc như bình thường
4. Sử dụng `make artisan cmd="..."`

---

## 🔗 Links Hữu Ích

- Laravel Documentation: https://laravel.com/docs
- Docker Documentation: https://docs.docker.com
- Nginx Documentation: https://nginx.org/en/docs/
- MySQL Documentation: https://dev.mysql.com/doc/
- Redis Documentation: https://redis.io/documentation

---

## 📝 Notes

- Source Laravel **phải** đặt trong thư mục `src/`
- Mọi thay đổi code trong `src/` sẽ sync tức thì
- Database data lưu trong Docker volumes
- Backup tự động lưu trong `backups/`
- Logs có thể xem bằng `make logs`

---

## 💡 Tips

- Dùng `make` thay vì gõ lệnh `docker-compose` dài
- Chạy `./healthcheck.sh` thường xuyên
- Backup database trước khi migrate: `./backup.sh`
- Dùng `make perm` nếu gặp permission issues
- Xem `.env` trong `src/.env` chứ không phải root

---

Chúc bạn phát triển thành công! 🚀

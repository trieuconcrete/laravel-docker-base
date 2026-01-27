# Laravel 12 với Docker

Môi trường phát triển Laravel 12 hoàn chỉnh với Docker bao gồm Nginx, MySQL, Redis và Mailhog.

## 📁 Cấu trúc thư mục

```
laravel-docker-base/
├── docker/                        # Docker configurations
│   ├── nginx/
│   │   └── default.conf          # Nginx configuration
│   └── php/
│       ├── Dockerfile            # PHP-FPM Dockerfile
│       └── php.ini               # Custom PHP settings
├── src/                          # Laravel source code (đặt code ở đây)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── public/
│   └── ...
├── docker-compose.yml            # Docker Compose configuration
├── docker-compose.prod.yml       # Production configuration
├── Makefile                      # Các lệnh tiện ích
├── setup.sh                      # Script setup tự động
├── .env.example                  # Environment variables mẫu
└── README.md
```

## 🚀 Services

- **Nginx** - Web server (port 8000)
- **PHP-FPM 8.3** - PHP với Laravel 12
- **MySQL 8.0** - Database (port 3307, internal: 3306)
- **Redis** - Cache & Session (port 6379)
- **Mailhog** - Mail testing (Web UI: 8025, SMTP: 1025)

## 📋 Yêu cầu

- Docker
- Docker Compose

## ⚡ Quick Start

### Cách 1: Cài đặt Laravel mới

```bash
# Khởi động containers và cài Laravel 12 tự động
make install-laravel
```

### Cách 2: Sử dụng source Laravel có sẵn

```bash
# 1. Copy source code Laravel vào thư mục src/
cp -r /path/to/your/laravel/* ./src/

# 2. Chạy setup
make setup
```

### Cách 3: Sử dụng script tự động

```bash
chmod +x setup.sh
./setup.sh
```

## 🌐 Truy cập ứng dụng

- **Application**: http://localhost:8000
- **Mailhog UI**: http://localhost:8025

## 🛠️ Các lệnh thường dùng

### Quản lý Containers

```bash
make up              # Khởi động containers
make down            # Dừng containers
make restart         # Restart containers
make ps              # Xem status containers
make logs            # Xem logs
```

### Làm việc với Laravel

```bash
make shell           # Truy cập vào container
make composer cmd="install"       # Chạy composer
make artisan cmd="migrate"        # Chạy artisan
make migrate         # Chạy migrations
make fresh           # Fresh migrate với seed
make test            # Chạy tests
```

### Cache & Optimization

```bash
make cache-clear     # Clear all cache
make optimize        # Optimize application
make perm            # Fix permissions
```

### Xem tất cả lệnh

```bash
make help
```

## 📝 Cấu hình Database

Thông tin kết nối database (đã cấu hình sẵn trong `.env`):

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret
```

### Kết nối từ bên ngoài (GUI client)

- **Host**: localhost
- **Port**: 3307
- **Database**: laravel
- **Username**: laravel
- **Password**: secret

> **Lưu ý**: Từ bên trong container Laravel, MySQL vẫn sử dụng port 3306. Chỉ kết nối từ host machine mới dùng port 3307.

## 🔴 Cấu hình Redis

```env
REDIS_HOST=redis
REDIS_PORT=6379

CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

## 📧 Cấu hình Email (Mailhog)

```env
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
```

Tất cả email gửi từ Laravel sẽ được Mailhog bắt lại. Xem tại: http://localhost:8025

## 🐚 Truy cập vào containers

```bash
# PHP-FPM container
docker-compose exec app bash

# Nginx container
docker-compose exec nginx sh

# MySQL
docker-compose exec mysql mysql -u laravel -psecret laravel

# Redis CLI
docker-compose exec redis redis-cli
```

## 🔧 Các tình huống thường gặp

### 1. Cài Laravel vào project mới

```bash
make install-laravel
```

### 2. Đã có source Laravel, muốn chạy

```bash
# Copy source vào src/
cp -r /path/to/laravel/* ./src/

# Setup
make setup
```

### 3. Clone từ Git về

```bash
git clone <repository>
cd laravel-docker-base

# Source Laravel đã có trong src/
make setup
```

### 4. Thêm package mới

```bash
make composer cmd="require laravel/sanctum"
```

### 5. Tạo Model, Controller, Migration

```bash
make artisan cmd="make:model Post -mcr"
make artisan cmd="make:controller API/PostController --api"
make artisan cmd="make:migration create_posts_table"
```

### 6. Chạy Queue Worker

```bash
make artisan cmd="queue:work"
```

### 7. Clear cache khi gặp lỗi

```bash
make cache-clear
```

### 8. Permission issues

```bash
make perm
```

## 🔍 Troubleshooting

### Containers không khởi động

```bash
# Xem logs chi tiết
make logs

# Rebuild containers
make down
make build
make up
```

### Database connection refused

```bash
# Restart MySQL
docker-compose restart mysql

# Đợi 10 giây
sleep 10

# Thử lại
make migrate
```

### Permission denied

```bash
make perm
```

### Port đã được sử dụng

Chỉnh sửa ports trong `docker-compose.yml`:

```yaml
ports:
  - "8001:80"  # Thay vì 8000
```

## 📦 Cài đặt thêm packages

### Laravel Authentication (Breeze)

```bash
make composer cmd="require laravel/breeze --dev"
make artisan cmd="breeze:install"
make npm cmd="install"
make npm cmd="run dev"
```

### Laravel Sanctum (API Authentication)

```bash
make composer cmd="require laravel/sanctum"
make artisan cmd="vendor:publish --provider='Laravel\Sanctum\SanctumServiceProvider'"
make migrate
```

### Laravel Telescope (Debug)

```bash
make composer cmd="require laravel/telescope --dev"
make artisan cmd="telescope:install"
make migrate
```

## 🔐 Security Best Practices

### Development

- Sử dụng passwords đơn giản (như đã cấu hình)
- `APP_DEBUG=true`
- Sử dụng Mailhog

### Production

- Đổi tất cả passwords thành mật khẩu mạnh
- `APP_DEBUG=false`
- `APP_ENV=production`
- Sử dụng HTTPS
- Sử dụng email service thật (không dùng Mailhog)
- Xem file `DEPLOYMENT.md` để biết chi tiết

## 📚 Tài liệu

- **README.md** (file này) - Hướng dẫn cơ bản
- **INSTALL.md** - Hướng dẫn cài đặt chi tiết
- **DEPLOYMENT.md** - Hướng dẫn deploy production
- **QUICKSTART.md** - Hướng dẫn nhanh

## 🔄 Update Laravel

```bash
make composer cmd="update"
make migrate
make cache-clear
```

## 🗑️ Xóa và reset

```bash
# Dừng và xóa containers + volumes
docker-compose down -v

# Xóa source Laravel (nếu muốn)
rm -rf src/*

# Cài lại
make install-laravel
```

## 🆘 Cần trợ giúp?

```bash
make help
```

## 📄 License

Open-sourced software licensed under the MIT license.

# Hướng dẫn cài đặt Laravel 12 với Docker

## 📁 Cấu trúc thư mục

```
laravel-docker-base/
├── docker/                    # Docker configurations
│   ├── nginx/
│   │   └── default.conf      # Nginx config
│   └── php/
│       ├── Dockerfile        # PHP-FPM image
│       └── php.ini           # PHP settings
├── src/                      # ⭐ Laravel source code ở đây
├── docker-compose.yml
├── Makefile
├── setup.sh
└── README.md
```

---

## Phương pháp 1: Tự động với Makefile (Khuyến nghị)

### Cài đặt Laravel mới

```bash
cd laravel-docker-base
make install-laravel
```

Script này sẽ tự động:
1. Khởi động Docker containers
2. Cài đặt Laravel 12 vào `src/`
3. Cấu hình `.env`
4. Generate app key
5. Chạy migrations
6. Fix permissions

### Sử dụng source Laravel có sẵn

```bash
# 1. Copy source Laravel vào thư mục src/
cp -r /path/to/your/laravel/* ./src/

# 2. Chạy setup
make setup
```

---

## Phương pháp 2: Tự động với Script

```bash
cd laravel-docker-base
chmod +x setup.sh
./setup.sh
```

Script sẽ:
- Kiểm tra Docker
- Khởi động containers
- Cài Laravel 12 (nếu chưa có)
- Cấu hình environment
- Chạy migrations

---

## Phương pháp 3: Thủ công từng bước

### Bước 1: Khởi động containers

```bash
docker-compose up -d
```

Đợi vài giây cho containers khởi động.

### Bước 2A: Cài Laravel mới (nếu chưa có)

```bash
# Truy cập container
docker-compose exec app bash

# Cài Laravel 12
composer create-project laravel/laravel .

# Thoát container
exit
```

### Bước 2B: Hoặc copy source có sẵn

```bash
# Copy Laravel source vào thư mục src/
cp -r /path/to/your/laravel/* ./src/

# Cài dependencies
docker-compose exec app composer install
```

### Bước 3: Cấu hình .env

```bash
# Truy cập container
docker-compose exec app bash

# Copy .env
cp .env.example .env

# Generate key
php artisan key:generate
```

Chỉnh sửa file `src/.env`:

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret

REDIS_HOST=redis
REDIS_PORT=6379

CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
```

### Bước 4: Chạy migrations

```bash
docker-compose exec app php artisan migrate
```

### Bước 5: Fix permissions

```bash
docker-compose exec app chown -R www:www /var/www/html/storage
docker-compose exec app chown -R www:www /var/www/html/bootstrap/cache
docker-compose exec app chmod -R 775 /var/www/html/storage
docker-compose exec app chmod -R 775 /var/www/html/bootstrap/cache
```

### Bước 6: Hoàn tất

Truy cập:
- Application: http://localhost:8000
- Mailhog: http://localhost:8025

---

## Phương pháp 4: Clone từ Git repository

Nếu project đã có trên Git và source Laravel đã có trong `src/`:

```bash
# Clone project
git clone <repository-url>
cd laravel-docker-base

# Setup
make setup
```

---

## ✅ Kiểm tra cài đặt

### 1. Kiểm tra containers

```bash
docker-compose ps
```

Phải thấy 5 containers đang chạy:
- laravel_nginx
- laravel_app
- laravel_mysql
- laravel_redis
- laravel_mailhog

### 2. Kiểm tra Laravel

```bash
docker-compose exec app php artisan --version
```

Phải hiển thị: `Laravel Framework 12.x.x`

### 3. Kiểm tra database

```bash
docker-compose exec app php artisan migrate:status
```

### 4. Test application

Mở trình duyệt: http://localhost:8000

Phải thấy trang Laravel mặc định.

### 5. Test Mailhog

```bash
docker-compose exec app php artisan tinker
```

Trong tinker:

```php
Mail::raw('Test', function($msg) {
    $msg->to('test@example.com')->subject('Test');
});
exit
```

Kiểm tra email tại: http://localhost:8025

---

## 🔧 Các tình huống đặc biệt

### Đã có Laravel trong src/ nhưng chưa có .env

```bash
docker-compose up -d
docker-compose exec app cp .env.example .env
docker-compose exec app php artisan key:generate
make configure-env
make migrate
```

### Đã có database data cũ, muốn reset

```bash
make fresh
# Hoặc
docker-compose exec app php artisan migrate:fresh --seed
```

### Muốn sử dụng Laravel version cụ thể

```bash
docker-compose exec app composer create-project laravel/laravel . "11.*"
```

### Port 8000 đã được sử dụng

Chỉnh file `docker-compose.yml`:

```yaml
nginx:
  ports:
    - "8001:80"  # Đổi thành port khác
```

Sau đó:

```bash
docker-compose down
docker-compose up -d
```

Truy cập: http://localhost:8001

---

## 🐛 Troubleshooting

### Permission denied errors

```bash
make perm
```

### Database connection refused

```bash
# Kiểm tra MySQL đã sẵn sàng chưa
docker-compose logs mysql

# Restart MySQL
docker-compose restart mysql

# Đợi 10 giây
sleep 10

# Thử lại
make migrate
```

### Composer install failed

```bash
# Clear cache
docker-compose exec app composer clear-cache

# Thử lại
docker-compose exec app composer install
```

### Nginx 502 Bad Gateway

```bash
# Kiểm tra PHP-FPM
docker-compose logs app

# Restart app container
docker-compose restart app
```

### Container không khởi động

```bash
# Xem logs
docker-compose logs

# Rebuild
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

### Redis connection issues

```bash
# Test Redis
docker-compose exec redis redis-cli ping
# Phải trả về: PONG

# Restart Redis
docker-compose restart redis
```

---

## 📦 Cài thêm packages

### Authentication (Breeze)

```bash
make composer cmd="require laravel/breeze --dev"
make artisan cmd="breeze:install"
docker-compose exec app npm install
docker-compose exec app npm run dev
```

### API Authentication (Sanctum)

```bash
make composer cmd="require laravel/sanctum"
make artisan cmd="vendor:publish --provider='Laravel\Sanctum\SanctumServiceProvider'"
make migrate
```

### Debugging (Telescope)

```bash
make composer cmd="require laravel/telescope --dev"
make artisan cmd="telescope:install"
make migrate
```

### Queue (Horizon)

```bash
make composer cmd="require laravel/horizon"
make artisan cmd="horizon:install"
```

---

## 🗑️ Xóa và cài lại

### Xóa containers và data

```bash
docker-compose down -v
```

### Xóa source Laravel

```bash
rm -rf src/*
```

### Cài lại từ đầu

```bash
make install-laravel
```

---

## 🔄 Update Laravel

```bash
# Update tất cả packages
make composer cmd="update"

# Chạy migrations mới (nếu có)
make migrate

# Clear cache
make cache-clear
```

---

## 🚀 Next Steps

Sau khi cài đặt thành công:

1. **Tạo Models, Controllers**
```bash
make artisan cmd="make:model Post -mcr"
make artisan cmd="make:controller API/PostController --api"
```

2. **Thiết lập Authentication**
```bash
make composer cmd="require laravel/breeze --dev"
```

3. **Cấu hình Queue Workers**
```bash
make artisan cmd="queue:work"
```

4. **Install frontend dependencies**
```bash
docker-compose exec app npm install
docker-compose exec app npm run dev
```

---

## 📚 Xem thêm

- **README.md** - Tổng quan
- **DEPLOYMENT.md** - Deploy production
- **QUICKSTART.md** - Hướng dẫn nhanh

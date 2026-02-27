# 🚀 Laravel Docker Cheat Sheet

## 📦 Quick Start

```bash
# Setup tự động (khuyến nghị)
./setup.sh

# Hoặc dùng Makefile
make setup
```

---

## 🐳 Docker Commands

### Container Management
```bash
make up              # Khởi động containers
make down            # Dừng containers
make restart         # Restart containers
make ps              # Xem status
make logs            # Xem logs (all)
make logs-app        # Logs PHP-FPM
make logs-nginx      # Logs Nginx
make logs-mysql      # Logs MySQL
```

### Shell Access
```bash
make shell           # Vào PHP container
make nginx-shell     # Vào Nginx container
make mysql-shell     # MySQL CLI
make redis-shell     # Redis CLI
```

---

## 🎨 Laravel Commands

### Artisan
```bash
make artisan cmd="migrate"
make artisan cmd="make:model Post -mcr"
make artisan cmd="cache:clear"
make artisan cmd="queue:work"
make artisan cmd="tinker"

# Hoặc shortcuts
make migrate         # = artisan migrate
make fresh           # = artisan migrate:fresh --seed
make seed            # = artisan db:seed
```

### Composer
```bash
make composer cmd="install"
make composer cmd="require laravel/sanctum"
make composer cmd="update"
make composer cmd="dump-autoload"
```

### Cache
```bash
make cache-clear     # Clear all cache
make optimize        # Cache config/routes/views
make config-cache    # Cache config only
make route-cache     # Cache routes only
```

---

## 🗄️ Database

### Connection Info
```bash
# Từ host machine (GUI tools)
Host: localhost
Port: 3307          # ⚠️ Changed from 3306
Database: laravel
Username: laravel
Password: secret

# Từ Laravel container (.env)
DB_HOST=mysql       # Service name
DB_PORT=3306        # Internal port
```

### MySQL Commands
```bash
make mysql-shell                    # Vào MySQL CLI
docker-compose exec mysql mysql -u laravel -psecret laravel

# Direct queries
docker-compose exec mysql mysql -u laravel -psecret -e "SHOW TABLES"
docker-compose exec mysql mysql -u laravel -psecret -e "SELECT * FROM users"
```

### Backup & Restore
```bash
./backup.sh                         # Backup database
./restore.sh backups/file.sql.gz    # Restore database

# Xem backups
ls -lh backups/
```

---

## 📧 Mailhog

```bash
# Web UI
http://localhost:8025

# Test email từ Laravel
make artisan cmd="tinker"
>>> Mail::raw('Test', function($msg) { $msg->to('test@test.com')->subject('Test'); });
```

---

## 🔧 Troubleshooting

### Health Check
```bash
./healthcheck.sh                    # Kiểm tra all services
```

### Permissions
```bash
make perm                           # Fix permissions
docker-compose exec app chmod -R 775 storage bootstrap/cache
docker-compose exec app chown -R www:www storage bootstrap/cache
```

### Rebuild
```bash
docker-compose down                 # Dừng
docker-compose build --no-cache     # Rebuild
docker-compose up -d                # Khởi động
```

### Clear Everything
```bash
docker-compose down -v              # Dừng + xóa volumes
docker system prune -a              # Clean Docker
```

### Port Conflicts
```bash
# Xem PORT-CONFLICTS.md để biết chi tiết

# Check ports
sudo lsof -i :3307                  # Mac/Linux
netstat -ano | findstr :3307        # Windows

# Stop MySQL on host
sudo systemctl stop mysql           # Linux
brew services stop mysql            # Mac
```

---

## 📂 File Structure

```bash
src/                    # Laravel source code ⭐
├── app/
├── config/
├── database/
├── public/
└── .env               # Laravel config (DB_HOST=mysql)

docker/
├── nginx/
│   └── default.conf
└── php/
    ├── Dockerfile
    └── php.ini

backups/               # Auto-generated DB backups
```

---

## 🌐 URLs

```bash
Application:    http://localhost:8000
Mailhog UI:     http://localhost:8025
MySQL:          localhost:3307
Redis:          localhost:6379
```

---

## 💻 Development Workflow

```bash
# 1. Khởi động
make up

# 2. Cài packages
make composer cmd="require laravel/sanctum"

# 3. Tạo model
make artisan cmd="make:model Product -mcr"

# 4. Chỉnh sửa migration
# Edit file trong src/database/migrations/

# 5. Chạy migration
make migrate

# 6. Xem logs
make logs

# 7. Test
make test

# 8. Dừng khi xong
make down
```

---

## 🚀 Deployment Workflow

```bash
# 1. Trên server
git clone <repo>
cd laravel-docker-base

# 2. Copy source
cp -r /path/to/laravel/* ./src/

# 3. Config production
nano src/.env
# Set APP_ENV=production, APP_DEBUG=false

# 4. Deploy
docker-compose -f docker-compose.yml -f docker-compose.prod.yml up -d

# 5. Setup
docker-compose exec app composer install --no-dev --optimize-autoloader
docker-compose exec app php artisan migrate --force
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
```

---

## 🔑 Environment Variables

### Laravel (.env)
```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=mysql           # ⚠️ Service name, not localhost
DB_PORT=3306            # ⚠️ Internal port, not 3307
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret

REDIS_HOST=redis
REDIS_PORT=6379

CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

MAIL_HOST=mailhog
MAIL_PORT=1025
```

---

## 📊 Performance

### OPcache
```bash
# Check OPcache status
docker-compose exec app php -i | grep opcache
```

### Redis
```bash
# Check Redis
make redis-shell
> INFO stats
> DBSIZE
```

### MySQL
```bash
# Slow query log
docker-compose exec mysql mysql -u laravel -psecret -e "SHOW VARIABLES LIKE 'slow_query_log'"

# Connections
docker-compose exec mysql mysql -u laravel -psecret -e "SHOW PROCESSLIST"
```

---

## 🧪 Testing

```bash
make test                           # PHPUnit
make artisan cmd="test --filter=UserTest"

# Code coverage
docker-compose exec app php artisan test --coverage
```

---

## 📝 Logs

```bash
# Container logs
make logs                           # All
docker-compose logs -f app          # PHP-FPM
docker-compose logs -f nginx        # Nginx
docker-compose logs -f mysql        # MySQL

# Laravel logs
docker-compose exec app tail -f storage/logs/laravel.log

# Nginx logs
docker-compose exec nginx tail -f /var/log/nginx/error.log
```

---

## ⚡ Quick Fixes

```bash
# 500 Error
make cache-clear
make perm
make restart

# Database connection failed
make restart-mysql
make logs-mysql

# Composer issues
make composer cmd="clear-cache"
make composer cmd="install"

# Permission denied
make perm

# Port already in use
# Xem PORT-CONFLICTS.md
```

---

## 🎯 Common Tasks

```bash
# Create controller
make artisan cmd="make:controller API/UserController --api"

# Create model with migration
make artisan cmd="make:model Product -m"

# Create seeder
make artisan cmd="make:seeder ProductSeeder"

# Run specific seeder
make artisan cmd="db:seed --class=ProductSeeder"

# Generate key
make artisan cmd="key:generate"

# Clear all cache
make cache-clear

# Optimize for production
make optimize

# Create symbolic link
make artisan cmd="storage:link"
```

---

## 💡 Tips

- ✅ Dùng `make` thay vì `docker-compose`
- ✅ Backup trước khi migrate: `./backup.sh`
- ✅ Chạy `./healthcheck.sh` thường xuyên
- ✅ Dùng `make perm` nếu có permission issues
- ✅ Source code phải ở `src/`
- ✅ `.env` ở `src/.env`, không phải root
- ⚠️ MySQL port: 3307 từ host, 3306 từ container

---

## 📚 Documentation

- **QUICKSTART.md** - Cài đặt nhanh
- **README.md** - Tổng quan
- **INSTALL.md** - Cài đặt chi tiết
- **DEPLOYMENT.md** - Deploy production
- **PORT-CONFLICTS.md** - Xử lý port conflicts
- **INDEX.md** - Tổng hợp tài liệu

---

## 🆘 Help

```bash
make help              # Xem tất cả Makefile commands
./healthcheck.sh       # Kiểm tra health
docker-compose ps      # Xem container status
```

---

**Happy Coding! 🚀**

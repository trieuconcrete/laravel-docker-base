# 🚗 Hướng dẫn Deploy Production - Xế Hộ 24/7 Đà Nẵng

## 📋 Thông tin Server

- **IP**: `103.82.132.130`
- **Port**: `8081` (internal), `80/443` (public)
- **Domain**: `xeho247.vn` và `www.xeho247.vn`
- **Technology**: Laravel + PHP-FPM + Nginx + MySQL + Redis
- **OS**: Ubuntu 20.04+ hoặc Debian 11+
- **Project Path**: `/var/www/webroot/xeho247danang`

---

## 📝 Yêu cầu Server

- Ubuntu 20.04+ hoặc Debian 11+
- PHP 8.2+
- Nginx 1.18+
- MySQL 8.0+
- Redis 6.0+
- Composer 2.0+
- RAM: Tối thiểu 2GB (khuyến nghị 4GB)
- Disk: Tối thiểu 20GB
- Port mở: 22, 80, 443

---

## ✅ BƯỚC 1: Chuẩn bị Server

### 1.1. Kết nối SSH

```bash
ssh root@103.82.132.130
```

### 1.2. Update hệ thống

```bash
# Update packages
sudo apt update && sudo apt upgrade -y

# Install essential tools
sudo apt install -y curl wget git vim nano ufw
```

### 1.3. Cấu hình Firewall

```bash
# Enable firewall
sudo ufw allow 22/tcp      # SSH
sudo ufw allow 80/tcp      # HTTP
sudo ufw allow 443/tcp     # HTTPS
sudo ufw enable
sudo ufw status
```

---

## ✅ BƯỚC 2: Cài đặt PHP 8.2

### 2.1. Thêm PHP Repository

```bash
# Add Ondřej Surý's PPA
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
```

### 2.2. Cài đặt PHP và Extensions

```bash
# Install PHP 8.2 and required extensions
sudo apt install -y php8.2 php8.2-fpm php8.2-cli php8.2-common \
  php8.2-mysql php8.2-zip php8.2-gd php8.2-mbstring \
  php8.2-curl php8.2-xml php8.2-bcmath php8.2-intl \
  php8.2-redis php8.2-opcache

# Verify PHP installation
php -v
php -m | grep -E 'pdo|mysql|redis|curl|mbstring|xml'
```

### 2.3. Cấu hình PHP-FPM

```bash
# Edit PHP-FPM configuration
sudo nano /etc/php/8.2/fpm/php.ini
```

**Cập nhật các giá trị sau:**

```ini
upload_max_filesize = 20M
post_max_size = 20M
max_execution_time = 300
memory_limit = 256M
opcache.enable = 1
opcache.memory_consumption = 128
opcache.interned_strings_buffer = 8
opcache.max_accelerated_files = 10000
opcache.revalidate_freq = 60
```

```bash
# Restart PHP-FPM
sudo systemctl restart php8.2-fpm
sudo systemctl enable php8.2-fpm
sudo systemctl status php8.2-fpm
```Cài đặt MySQL 8.0

### 3.1. Cài đặt MySQL Server

```bash
# Install MySQL
sudo apt install -y mysql-server

# Verify installation
mysql --version

# Enable MySQL
sudo systemctl enable mysql
sudo systemctl start mysql
sudo systemctl status mysql
```

### 3.2. Bảo mật MySQL

```bash
# Run security script
sudo mysql_secure_installation

# Follow prompts:
# - Set root password: Yes (use strong password)
# - Remove anonymous users: Yes
# - Disallow root login remotely: Yes
# - Remove test database: Yes
# - Reload privilege tables: Yes
```

### 3.3. Tạo Database và User

```bash
# Login to MySQL
sudo mysql -u root -p
```

**Trong MySQL console:**

```sql
-- Create database
CREATE DATABASE xeho247_prod CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create user
CREATE USER 'xeho247_user'@'localhost' IDENTIFIED BY 'StrongPassword123!';

-- Grant privileges
GRANT ALL PRIVILEGES ON xeho247_prod.* TO 'xeho247_user'@'localhost';

-- Flush privileges
FLUSH PRIVILEGES;

-- Verify
SHOW DATABASES;
SELECT User, Host FROM mysql.user WHERE User = 'xeho247_user';

-- Exit
EXIT;
```

```bash
# Test connection
mysql -u xeho247_user -p xeho247_prod
```

---

## ✅ BƯỚC 4: Cài đặt Redis

### 4.1. Cài đặt Redis Server

```bash
# Install Redis
sudo apt install -y redis-server

# Verify installation
redis-server --version
```

### 4.2. Cấu hình Redis

```bash
# Edit Redis configuration
sudo nano /etc/redis/redis.conf
```

**Cập nhật các giá trị sau:**

```conf
# Bind to localhost only
bind 127.0.0.1 ::1

# Set password
requirepass RedisPassword123!

# Set max memory
maxmemory 256mb
maxmemory-policy allkeys-lru

# Enable persistence
save 900 1
save 300 10
save 60 10000
```

```bash
# Restart Redis
sudo systemctl restart redis-server
sudo systemctl enable redis-server
sudo systemctl status redis-server

# Test Redis
redis-cli -a RedisPassword123! PING
# Should return: PONG
```

---

## ✅ BƯỚC 5: Cài đặt Composer

```bash
# Download Composer installer
curl -sS https://getcomposer.org/installer -o composer-setup.php

# Verify installer (optional)
HASH="$(curl -sS https://composer.github.io/installer.sig)"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"

# Install Composer globally
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer

# Clean up
rm composer-setup.php

# Verify installation
composer --version
```

---

## ✅ BƯỚC 6: 

---

## ✅ BƯỚC 3: Setup Project

### 3.1. Tạo thư mục project

```bash
sudo mkdir -p /var/www/webroot/xeho247danang
sudo chown -R $USER:$USER /var/www/webroot/xeho247danang
cd /var/www/webroot/xeho247danang
```

### 6.2. Clone source code

**Option A: Từ Git repository (khuyến nghị)**

```bash
cd /var/www/webroot/xeho247danang

# Clone từ repository
git clone <your-git-repository-url> .

# Hoặc nếu đã có SSH key
git clone git@github.com:your-username/xeho247danang.git .
```

**Option B: Upload từ local**

```bash
# Từ máy local, upload lên server (chỉ upload thư mục src)
scp -r /path/to/laravel-docker-base/src/* root@103.82.132.130:/var/www/webroot/xeho247danang/
```

### 6.3. Install Composer Dependencies

```bash
cd /var/www/webroot/xeho247danang

# Install dependencies (production)
composer install --optimize-autoloader --no-dev

# Verify i7: Cấu hình Environment

### 7.1. Tạo file .env cho Production

```bash
cd /var/www/webroot/xeho247danang
```bash
cd /var/www/webroot/xeho247danang

# Set ownership
sudo chown -R www-data:www-data .
sudo chown -R $USER:www-data storage bootstrap/cache

# Set permissions
sudo chmod -R 755 .
sudo chmod -R 775 storage bootstrap/cache

# Create public uploads directory
sudo mkdir -p public/uploads
sudo chown -R www-data:www-data public/uploads
sudo chmod -R 775 public/uploads
```

---

## ✅ BƯỚC 4: Cấu hình Environment

### 4.1. Tạo file .env cho Production

```bash
cd /var/www/webroot/xeho247danang/src
cp .env.example .env
nano .env
```

**Cấu hình .env Production:**

```env
# Application
APP_NAME="Xế Hộ 24/7 Đà Nẵng"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://xeho247.vn

# Locale
APP_LOCALE=vi
APP_FALLBACK_LOCALE=vi
APP_FAKER_LOCALE=vi_VN

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=error

# Database (MySQL)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=xeho247_prod
DB_USERNAME=xeho247_user
DB_PASSWORD=StrongPassword123!

# Cache & Session
CACHE_STORE=redis
SESSION_DRIVER=redis
SESSION_LIFETIME=120

# Redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=RedisPassword123!
REDIS_PORT=6379

# Queue
QUEUE_CONNECTION=redis

# Mail (Gmail Production)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=trieunb.dev@gmail.com
MAIL_PASSWORD=your_app_password_here
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@xeho247danang.vn"
MAIL_FROM_NAME="Xế Hộ 24/7 Đà Nẵng"
ADMIN_EMAIL="admin@xeho247danang.vn"

# Google Maps API
GOOGLE_MAPS_API_KEY=AIzaSyAsge53SQbz9daHn50tcgngIAVUjhDEFxQ

# URLs
FRONTEND_URL=https://xeho247.vn
```

### 7.2. Generate Application Key

```bash
cd /var/www/webroot/xeho247danang

# Generate application key
php artisan key:generate

# Verify .env has APP_KEY
cat .env | grep APP_KEY
```

---

## ✅ BƯỚC 5: Build và Start Docker Containers

### 5.1. Build images

```bash
cd /var/www/webroot/xeho247danang

# Build with production config
docker compose -f docker-compose.yml -f docker-compose.prod.yml build --no-cache
```

### 5.2. Start containers

```bash
# Start all services
docker compose -f docker-compose.yml -f docker-compose.prod.yml up -d

# Verify containers are running
docker com8: Setup Laravel Application

### 8.1. Run database migrations

```bash
cd /var/www/webroot/xeho247danang

# Run migrations
php artisan migrate --force

# (Optional) Run seeders nếu cần
php artisan db:seed --force

# Verify tables
mysql -u xeho247_user -p xeho247_prod -e "SHOW TABLES;"
```

### 8.2. Optimize Laravel

```bash
cd /var/www/webroot/xeho247danang

# Clear caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Cache everything for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize autoloader
composer dump-autoload --optimize

# Generate storage link (if needed)
php artisan storage:link
```

### 8.3. Test application

```bash
cd /var/www/webroot/xeho247danang

# Test artisan
php artisan --version

# Test database connection
php artisan tinker
>>> DB::connection()->getPdo();
>>> exit

# Test Redis connection
php artisan tinker
>>> Cache::put('test', 'value', 60);
>>> Cache::get('test');
>>> exit
**Nội dung config:**

```nginx
# HTTP - Redirect to HTTPS
server {
    listen 80;
    listen [::]:80;
    server_name xeho247.vn www.xeho247.vn;

    # Certbot challenge
    location /.well-known/acme-challenge/ {
        root /var/www/certbot;
    }

    # Redirect all HTTP to HTTPS
    location / {
        return 301 https://$server_name$request_uri;
    }
}

# HTTPS
server {
    listen 443 ssl http2;
    listen9: Cấu hình Nginx

### 9.1. Cài đặt Nginx

```bash
# Install Nginx
sudo apt install -y nginx
webroot/xeho247danang/public;
    }

    # Redirect all HTTP to HTTPS
    location / {
        return 301 https://$server_name$request_uri;
    }
}

# HTTPS
server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name xeho247.vn www.xeho247.vn;

    # Document root - Laravel public directory
    root /var/www/webroot/xeho247danang/public;
    index index.php index.html;

    # SSL certificates (sẽ được tạo bởi Certbot)
    ssl_certificate /etc/letsencrypt/live/xeho247.vn/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/xeho247.vn/privkey.pem;
    
    # SSL configuration
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_prefer_server_ciphers on;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512:ECDHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-SHA384;
    ssl_session_cache shared:SSL:10m;
    ssl_session_timeout 10m;

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;

    # Logs
    access_log /var/log/nginx/xeho247.vn.access.log;
    error_log /var/log/nginx/xeho247.vn.error.log;

    # Max upload size
    client_max_body_size 20M;

    # Laravel routes
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP-FPM configuration
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
        fastcgi_hide_header X-Powered-By;
        
        # Timeouts
        fastcgi_connect_timeout 300;
        fastcgi_send_timeout 300;
        fastcgi_read_timeout 300;
  Remove default config
sudo rm -f /etc/nginx/sites-enabled/default

# Create symlink
sudo ln -sf /etc/nginx/sites-available/xeho247.vn /etc/nginx/sites-enabled/

# Test config
sudo nginx -t

# Restart nginx
sudo systemctl restart nginx
sudo systemctl status nginx
```

---

## ✅ BƯỚC 10n ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        access_log off;
    }

    # Deny access to sensitive files
    10.1. Cài đặt Certbot

```bash
sudo apt install -y certbot python3-certbot-nginx
```

### 10.2. Tạo SSL certificate

```bash
# Obtain certificate
sudo certbot --nginx -d xeho247.vn -d www.xeho247.vn

# Follow the prompts:
# - Enter email address
# - Agree to terms
# - Choose redirect HTTP to HTTPS (recommended: Yes)

# Certbot sẽ tự động cập nhật Nginx config
```

### 10.3. Test auto-renewal

```bash
# Dry run
sudo certbot renew --dry-run

# Certbot sẽ tự động renew certificate trước khi hết hạn
# Auto-renewal được setup via systemd timer

# Check renewal timer
sudo systemctl list-timers | grep certbot
```

---

## ✅ BƯỚC 11
# Tạo thư mục cho certbot challenge
sudo mkdir -p /var/www/certbot

# Obtain certificate
sudo certbot --nginx -d xeho247.vn -d www.xeho247.vn

# Follow the prompts:
# - Enter email address
# - Agree to terms
# - Choose redirect HTTP to HTTPS (recommended: Yes)
```

### 8.3. Test auto-renewal

```bash
# Dry run
sudo certbot renew --dry-run

# Certbot sẽ tự động renew certificate trước khi hết hạn
```

---

## ✅ BƯỚC 92: Setup Queue Worker (Optional)

### 12.1. Tạo Supervisor Config

```bash
# Install Supervisor
sudo apt install -y supervisor

# Create worker config
sudo nano /etc/supervisor/conf.d/xeho247-worker.conf
```

**Nội dung config:**

```ini
[program:xeho247-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/webroot/xeho247danang/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=4.1. Tạo deploy script

```bash
cd /var/www/webroot/xeho247danang
nano deploy.sh
```

**Nội dung deploy.sh:**

```bash
#!/bin/bash

set -e

echo "🚗 Deploying Xế Hộ 24/7..."

# Navigate to project directory
cd /var/www/webroot/xeho247danang

# Pull latest code (if using git)
echo "📥 Pulling latest code..."
git pull origin main

# Enable maintenance mode
echo "🔧 Enabling maintenance mode..."
php artisan down || true

# Install/update dependencies
echo "📦 Installing dependencies..."
composer install --optimize-autoloader --no-dev

# Run migrations
echo "🗄️ Running migrations..."
php artisan migrate --force

# Clear and cache
echo "🧹 Optimizing application..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize autoloader
composer dump-autoload --optimize

# Fix permissions
echo "🔐 Setting permissions..."
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Restart services
echo "🔄 Restarting services..."
sudo systemctl reload php8.2-fpm
sudo systemctl reload nginx

# Restart queue workers (if using supervisor)
if command -v supervisorctl &> /dev/null; then
    echo "🔄 Restarting queue workers..."
    sudo supervisorctl restart xeho247-worker:* || true
fi

# Disable maintenance mode
echo "✅ Disabling maintenance mode..."
php artisan up

echo ""
echo "✅ Deployment completed!"
echo "🌐 Application is live at: https://xeho247.vn"
```

### 14.2. Phân quyền cho script

```bash
chmod +x deploy.sh
```

### 14h
cd /var/www/webroot/xeho247danang
nano deploy.sh
```

**Nội dung deploy.sh:**

```bash5: Setup Backup Script

### 15.1. Tạo backup script

```bash
cd /var/www/webroot/xeho247danang
nano backup.sh
```

**Nội dung backup.sh:**

```bash
#!/bin/bash

set -e

# Configuration
BACKUP_DIR="/var/backups/xeho247danang"
DATE=$(date +%Y%m%d_%H%M%S)
PROJECT_DIR="/var/www/webroot/xeho247danang"
DB_NAME="xeho247_prod"
DB_USER="xeho247_user"
DB_PASS="StrongPassword123!"

echo "💾 Starting backup..."

# Create backup directory
mkdir -p $BACKUP_DIR

# Backup database
echo "🗄️ Backing up database..."
mysqldump -u $DB_USER -p"$DB_PASS" $DB_NAME > $BACKUP_DIR/db_backup_$DATE.sql

# Compress database backup
gzip $BACKUP_DIR/db_backup_$DATE.sql

# Backup storage files
echo "📁 Backing up storage files..."
tar -czf $BACKUP_DIR/storage_backup_$DATE.tar.gz -C $PROJECT_DIR storage/app

# Backup public uploads
if [ -d "$PROJECT_DIR/public/uploads" ]; then
    echo "📁 Backing up uploads..."
    tar -czf $BACKUP_DIR/uploads_backup_$DATE.tar.gz -C $PROJECT_DIR/public uploads
fi

# Backup .env
echo "⚙️ Backing up configuration..."
cp $PROJECT_DIR/.env $BACKUP_DIR/env_backup_$DATE

# Remove old backups (keep last 7 days)
echo "🧹 Cleaning old backups..."
find $BACKUP_DIR -type f -mtime +7 -delete

# Show backup info
echo "✅ Backup completed!"
echo "📊 Backup location: $BACKUP_DIR"
du -sh $BACKUP_DIR
ls -lh $BACKUP_DIR | tail -5
```

### 15.2. Phân quyền

```bash
chmod +x backup.sh
```

### 15.3. Setup Cron job cho auto backup

```bash
# Edit crontab
crontab -e

# Add line để backup hàng ngày lúc 2:00 AM
0 2 * * * /var/www/webroot/xeho247danang/backup.sh >> /var/log/xeho247-backup.log 2>&1
```
# Laravel logs
sudo tail -f /var/www/webroot/xeho247danang/storage/logs/laravel.log

# Nginx access logs
sudo tail -f /var/log/nginx/xeho247.vn.access.log

# Nginx error logs
sudo tail -f /var/log/nginx/xeho247.vn.error.log

# PHP-FPM logs
sudo tail -f /var/log/php8.2-fpm.log

# MySQL error logs
sudo tail -f /var/log/mysql/error.log

# Queue worker logs (if using supervisor)
sudo tail -f /var/www/webroot/xeho247danang/storage/logs/worker.log
```

### Check services status

```bash
# Check all services
sudo systemctl status nginx
sudo systemctl status php8.2-fpm
sudo systemctl status mysql
sudo systemctl status redis-server

# Check supervisor (if installed)
sudo supervisorctl status

# Check disk usage
df -h

# Check memory usage
free -h

# Check CPU usage
top
```

### Check database

```bash
# Access MySQL
mysql -u xeho247_user -p xeho247_prod

# Or as root
sudo mysql -u root -p

# In MySQL console:
SHOW DATABASES;
USE xeho247_prod;
SHOW TABLES;

# Check bookings
SELECT * FROM driver_bookings ORDER BY created_at DESC LIMIT 10;

# Check database size
SELECT 
    table_schema AS 'Database',
    ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS 'Size (MB)'
FROM information_schema.tables 
WHERE table_schema = 'xeho247_prod'
GROUP BY table_schema;

EXIT;
```

### Check Redis

```bash
# Access Redis CLI
redis-cli -a RedisPassword123!

# Redis commands
PING        services

```bash
# Restart PHP-FPM
sudo systemctl restart php8.2-fpm

# Restart Nginx
sudo systemctl restart nginx

# Restart MySQL
sudo systemctl restart mysql

# Restart Redis
sudo systemctl restart redis-server

# Restart all services
sudo systemctl restart php8.2-fpm nginx mysql redis-server

# Reload services (no downtime)
sudo systemctl reload php8.2-fpm
sudo systemctl reload nginx
```

### Clear Laravel cache

```bash
cd /var/www/webroot/xeho247danang

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Clear specific cache
php artisan cache:forget cache_key
```

### Run artisan commands

```bash
cd /var/www/webroot/xeho247danang

# Artisan commands
php artisan [command]

# Examples:
php artisan tinker                  # Interactive shell
php artisan migrate                 # Run migrations
php artisan migrate:rollback        # Rollback migrations
php artisan db:seed                 # Run seeders
php artisan queue:work              # Start queue worker
php artisan queue:restart           # Restart queue workers
php artisan schedule:run            # Run scheduled tasks
php artisan down                    # Enable maintenance mode
php artisan up                      # Disable maintenance mode
```

### Manage queue workers

```bash
# Check supervisor status
sudo supervisorctl status

# Restart all workers
sudo supervisorctl restart xeho247-worker:*

# Stop all workers
sudo supervisorctl stop xeho247-worker:*

# Start all workers
sudo supervisorctl start xeho247-worker:*

# View worker logs
sudo supervisorctl tail xeho247-worker:xeho247-worker_00

# Reload supervisor config
sudo supervisorctl reread
sudo supervisorctl update
```

### Maintenance mode

```bash
cd /var/www/webroot/xeho247danang

# Enable maintenance mode
php artisan down

# Enable with secret bypass
php artisan down --secret="your-secret-key"
# Access: https://xeho247.vn/your-secret-key

# Enable with custom message
php artisan down --message="We are upgrading the system"

# Disable maintenance mode
php artisan up
```

**Nội dung backup.sh:**

```bash
#!/bin/bash

set -e

# Configuration
BACKUP_DIR="/var/backups/xeho247danang"
DATE=$(date +%Y%m%d_%H%M%S)
PROJECT_DIR="/var/www/webroot/xeho247danang"

echo "💾 Starting backup..."

# Create backup directory
mkdir -p $BACKUP_DIR

# Backup database
echo "🗄️ Backing up database..."
docker compose -f $PROJECT_DIR/docker-compose.yml -f $PROJECT_DIR/docker-compose.prod.yml exec -T mysql \
  mysqldump -u root -p"StrongRootPassword123!" xeho247_prod > $BACKUP_DIR/db_backup_$DATE.sql

# Backup storage files
echo "📁 Backing up storage files..."
tar -czf $BACKUP_DIR/storage_backup_$DATE.tar.gz -C $PROJECT_DIR/src storage/app

# Backup .env
echo "⚙Services không start

```bash
# Check service status
sudo systemctl status php8.2-fpm
sudo systemctl status nginx
sudo systemctl status mysql
sudo systemctl status redis-server

# Check logs
sudo journalctl -u php8.2-fpm -n 50
sudo journalctl -u nginx -n 50
sudo journalctl -u mysql -n 50

# Restart services
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx

```bash
chmod +x backup.sh
```

### 11.3PHP-FPM status
sudo systemctl status php8.2-fpm

# Check PHP-FPM logs
sudo tail -f /var/log/php8.2-fpm.log

# Check PHP-FPM socket
ls -la /var/run/php/php8.2-fpm.sock

# Restart PHP-FPM
sudo systemctl restart php8.2-fpm

# Check nginx config
sudo nginx -t

# Check nginx logs
sudo tail -f /var/log/nginx/xeho247.vn.error.log

## 📊 Monitoring và Maintenance

### Kiểm tra logs

```bashstatus
sudo systemctl status mysql

# Check MySQL logs
sudo tail -f /var/log/mysql/error.log

# Verify .env database credentials
cd /var/www/webroot/xeho247danang
cat .env | grep DB_

# Test MySQL connection
mysql -u xeho247_user -p xeho247_prod

# Test from Laravel
php artisan tinker
>>> DB::connection()->getPdo();
>>> exit

# Check MySQL is listening
sudo netstat -tulpn | grep mysql
# All logs
docker compose -f docker-compose.yml -f docker-compose.prod.yml logs -f

# Host Nginx logs
sudo tail -f /var/log/nginx/xeho247.vn.access.log
sudo tail -f /var/log/nginx/xeho247.vn.error.log
```
storage permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Fix all permissions
sudo chown -R www-data:www-data .
sudo chown -R $USER:www-data storage bootstrap/cache
sudo chmod -R 755 .
sudo chmod -R 775 storage bootstrap/cache

# Verify permissions
ls -la storage/
ls -la bootstrap/cache/
# Container status
docker compose -f docker-compose.yml -f docker-compose.prod.yml ps

# Resource usage
docker stats
cd /var/www/webroot/xeho247danang

# Check mail configuration
cat .env | grep MAIL_

# Test email
php artisan tinker
>>> Mail::raw('Test email', function($msg) { $msg->to('test@example.com')->subject('Test'); });
>>> exit

# Check logs
tail -f storage/logs/laravel.log

# Clear config cache
php artisan config:clear
php artisan config:cache

# Access MySQL
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec mysql mysql -u root -p

# Show databases
SHOW DATABASES;

# Use database
USE xeho247_prod;

# Show tables
SHOW TABLES;

# Check bookings
SELECT * FROM driver_bookings ORDER BY created_at DESC LIMIT 10;
```

### Check Redis
already in use

```bash
# Check port 80
sudo lsof -i :80
sudo netstat -tulpn | grep :80

# Check port 443
sudo lsof -i :443

# Check which process is using the port
sudo fuser -v 80/tcp

# Kill the process if needed
sudo kill -9 [PID]

# Restart nginx if needed
sudo systemctl restart nginx
```

---

## 🔧 Common Commands

### Restart application
du -sh /var/www/webroot/xeho247danang/*

# Check largest directories
du -h /var | sort -rh | head -20

# Clean Laravel logs
cd /var/www/webroot/xeho247danang
truncate -s 0 storage/logs/laravel.log

# Clean old logs
sudo journalctl --vacuum-time=7d

# Clean apt cache
sudo apt clean
sudo apt autoclean

# Clean old backups
find /var/backups/xeho247danang -type f -mtime +30 -delete

# Remove old log files
sudo find /var/log -type f -name "*.log.*"
cd /var/www/webroot/xeho247danang
docker compose -f docker-compose.yml -f docker-compose.prod.yml restart
```

### Stop application
status
sudo systemctl status redis-server

# Check Redis logs
sudo tail -f /var/log/redis/redis-server.log

# Test Redis connection
redis-cli -a RedisPassword123! PING

# Check Redis config
sudo nano /etc/redis/redis.conf

# Restart Redis
sudo systemctl restart redis-server

# Clear Redis cache
redis-cli -a RedisPassword123! FLUSHALL

# Test from Laravel
cd /var/www/webroot/xeho247danang
php artisan tinker
>>> Cache::put('test', 'value');
>>> Cache::get('test');
>>> exit
```

### Rebuild and restart

```bash
cd /var/www/webroot/xeho247danang

# Check API key in .env
cat .env | grep GOOGLE_MAPS_API_KEY

# Clear config cache
php artisan config:clear
php artisan config:cache

# Test API key
curl "https://maps.googleapis.com/maps/api/geocode/json?address=Danang&key=$(grep GOOGLE_MAPS_API_KEY .env | cut -d '=' -f2)"

# Check browser console for API errors
# Verify API is enabled in Google Cloud Console:
# - Maps JavaScript API
# - Places API
# - Distance Matrix API
# - Geocoding API
cd /var/www/webroot/xeho247danang
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec app php artisan cache:clear
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec app php artisan config:clear
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec app php artisan route:clear
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec app php artisan view:clear
```

### Run artisan commands

```bash
cd /var/www/webroot/xeho247danang
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec app php artisan [command]

# Examples:
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec app php artisan tinker
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec app php artisan queue:work
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec app php artisan schedule:run
```

---

## 🔧 Troubleshooting

### 1. Container không start

```bash
# Check logs
docker compose -f docker-compose.yml -f docker-compose.prod.yml logs

# Check specific service
docker compose -f docker-compose.yml -f docker-compose.prod.yml logs app
docker compose -f docker-compose.yml -f docker-compose.prod.yml logs nginx

# Rebuild
docker compose -f docker-compose.yml -f docker-compose.prod.yml down
docker compose -f docker-compose.yml -f docker-compose.prod.yml build --no-cache
docker compose -f docker-compose.yml -f docker-compose.prod.yml up -d
```

### 2. 502 Bad Gateway

```bash
# Check app container status
docker compose -f docker-compose.yml -f docker-compose.prod.yml ps

# Check app logs
docker compose -f docker-compose.yml -f docker-compose.prod.yml logs app

# Restart app
docker compose -f docker-compose.yml -f docker-compose.prod.yml restart app

# Check nginx config
sudo nginx -t
```

### 3. Database connection error

```bash
# Check MySQL container
docker compose -f docker-compose.yml -f docker-compose.prod.yml ps mysql

# Check MySQL logs
docker compose -f docker-compose.yml -f docker-compose.prod.yml logs mysql

# Verify .env database credentials
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec app cat .env | grep DB_

# Test connection
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec app php artisan tinker
>>> DB::connection()->getPdo();
```

### 4. Permission denied errors

```bash
cd /var/www/webroot/xeho247danang

# Fix permissions
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec app chmod -R 775 storage bootstrap/cache
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec app chown -R www-data:www-data storage bootstrap/cache

# On host
sudo chown -R $USER:$USER /var/www/webroot/xeho247danang
```

### 5. Email not sending

```bash
# Check mail configuration
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec app cat .env | grep MAIL_

# Test email
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec app php artisan tinker
>>> Mail::raw('Test email', function($msg) { $msg->to('test@example.com')->subject('Test'); });

# Check logs
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec app tail -f storage/logs/laravel.log
```

### 6. SSL certificate issues

```bash
# Check certificate
sudo certbot certificates

# Renew certificate manually
sudo certbot renew --force-renewal

# Test nginx config
sudo nginx -t

# Reload nginx
sudo systemctl reload nginx
```

### 7. Port 8081 already in use

```bash
# Check what's using the port
sudo lsof -i :8081
sudo netstat -tulpn | grep 8081

# Kill the process
sudo kill -9 [PID]

# Or change port in .env.production and docker-compose.yml
```

### 8. Disk space full

```bash
# Check disk usage
df -h

# Clean Docker resources
docker system prune -a --volumes

# Clean old logs
sudo journalctl --vacuum-time=7d

# Clean old backups
find /var/backups/xeho247danang -type f -mtime +30 -delete
```

### 9. Redis connection error

```bash
# Check Redis container
docker compose -f docker-compose.yml -f docker-compose.prod.yml ps redis

# Check Redis logs
docker compose -f docker-compose.yml -f docker-compose.prod.yml logs redis

# Test Redis connection
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec redis redis-cli -a RedisPassword123! PING

# Clear Redis cache
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec redis redis-cli -a RedisPassword123! FLUSHALL
```

### 10. Google Maps API not working

```bash
# Check API key in .env
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec app cat .env | grep GOOGLE_MAPS_API_KEY

# Clear config cache
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec app php artisan config:clear
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec app php artisan config:cache

# Check browser console for API errors
# Verify API is enabled in Google Cloud Console
```

---

## 📝 Checklist Deploy

- [ ] Server đã chuẩn bị (Ubuntu/Debian)
- [ ] PHP 8.2 và extensions đã cài đặt
- [ ] Composer đã cài đặt
- [ ] MySQL đã cài và database đã tạo
- [ ] Redis đã cài và cấu hình
- [ ] Nginx đã cài đặt
- [ ] Source code đã upload/clone
- [ ] Composer dependencies đã install
- [ ] File .env đã cấu hình đúng
- [ ] Application key đã generate
- [ ] Database migrations đã chạy
- [ ] Laravel đã optimize (config, route, view cache)
- [ ] File permissions đã set đúng
- [ ] Nginx config đã tạo và enable
- [ ] DNS đã trỏ về server IP
- [ ] SSL certificate đã cài đặt
- [ ] Firewall đã cấu hình
- [ ] Supervisor đã setup (nếu dùng queue)
- [ ] Cron jobs đã setup
- [ ] Deploy script đã tạo và test
- [ ] Backup script đã cấu hình
- [ ] Cron job backup đã setup
- [ ] Application accessible tại https://xeho247.vn
- [ ] Booking form hoạt động
- [ ] Email notification hoạt động
- [ ] Google Maps API hoạt động

---

## 🔐 Security Best Practices

### 1. Update hệ thống thường xuyên

```bash
# Weekly updates
sudo apt update && sudo apt upgrade -y

# Update Composer
composer self-update
```

### 2. Secure MySQL

```bash
# Run security script if not done
sudo mysql_secure_installation

# Đổi default passwords
# Disable remote root login
# Verify requirepass is set
sudo grep "requirepass" /etc/redis/redis.conf

# Bind to localhost only
sudo grep "bind" /etc/redis/redis.conf
# Should be: bind 127.0.0.1 ::1

# Restart if changed
sudo systemctl restart redis-server
```

### 4. Firewall rules

```bash
# Check firewall status
sudo ufw status

# Only open necessary ports
sudo ufw allow 22/tcp      # SSH
sudo ufw allow 80/tcp      # HTTP
sudo ufw allow 443/tcp     # HTTPS
# Use requirepass (đã config trong .env.production)
# Không expose Redis port ra ngoài
```
crontab -l | grep backup

# Test backup manually
cd /var/www/webroot/xeho247danang
./backup.sh

# Test restore process monthly
./restore.sh <backup_date>
```

### 6. Monitor logs

```bash
# Check logs regularly
sudo tail -f /var/log/nginx/xeho247.vn.error.log
sudo tail -f /var/log/php8.2-fpm.log
sudo tail -f /var/www/webroot/xeho247danang/storage/logs/laravel.log

# Setup log rotation for Laravel logs
sudo nano /etc/logrotate.d/laravel
```

**Content for /etc/logrotate.d/laravel:**

```
/var/www/webroot/xeho247danang/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    delaycompress
    notifempty
    create 0644 www-data www-data
}
### 5. Regular backups

```bash
# Daily automated backups via cron
# Test restore process monthly
```

### 6. Monitor logs

```bash
# Check logs regularly
cd /var/www/webroot/xeho247danang

# Cache everything
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Enable OPcache (already configured in php.ini)
php -i | grep opcache

# Queue jobs with Supervisor
sudo supervisorctl status

# Use Redis for cache and sessions (already configured)
```

### 2. Database optimizations

```bash
# Index important columns
# Optimize queries with explain
# Use pagination for large datasets
# Regular ANALYZE TABLE

# MySQL optimization
sudo mysql -u root -p
ANALYZE TABLE driver_booki (already configured)

# Monitor Redis
redis-cli -a RedisPassword123! INFO stats
redis-cli -a RedisPassword123! INFO memory
```

### 4. CDN for static assets

```bash
# Use CDN for images, CSS, JS
# Enable browser caching (already configured in Nginx)
# Minify assets

# Laravel Mix/Vite for asset compilation
cd /var/www/webroot/xeho247danang
npm run build
```

### 5. Nginx optimizations

```bash
# Already configured:
# - Gzip compression
# - Browser caching
# - FastCGI caching (can be added)

# Add FastCGI cache (optional)
sudo nano /etc/nginx/nginx.conf
# Add in http block:
# fastcgi_cache_path /var/cache/nginx levels=1:2 keys_zone=MYAPP:100m inactive=60m;
# fastcgi_cache_key "$scheme$request_method$host$request_uri";

# Create cache directory
sudo mkdir -p /var/cache/nginx
sudo chown -R www-data:www-data /var/cache/nginx
```

### 6. PHP-FPM optimization

```bash
# Edit PHP-FPM pool config
sudo nano /etc/php/8.2/fpm/pool.d/www.conf

# Optimize for traffic:
# pm = dynamic
# pm.max_children = 50
# pm.start_servers = 10
# pm.min_spare_servers = 5
# pm.max_spare_servers = 20
# pm.max_requests = 500

sudo systemctl restart php8.2-fpm
```bash
# Cache everything
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Use OPcache
# Enable in php.ini

# Queue jobs
php artisan queue:work --daemon
```

### 2. Database optimizations

```bash
# Index important columns
# Optimize queries
# Use pagination
# Regular ANALYZE TABLE
tail -f storage/logs/laravel.log

# Run commands
cd /var/www/webroot/xeho247danang
php artisan [command]

# Check services
sudo systemctl status nginx php8.2-fpm mysql redis-server
```bash
# Cache database queries
# Cache API responses
# Session storage in Redis
```

### 4. CDN for static assets

```bash
# Use CDN for images, CSS, JS
# Enable browser caching
# Minify assets
```

### 5. Nginx optimizations

```bash
# Enable gzip compression (đã config)
# Browser caching (đã config)
# Rate limiting
```

---, `/var/log/php8.2-fpm.log`, Laravel logs
2. Verify DNS: `dig xeho247.vn`
3. Check SSL: `sudo certbot certificates`
4. Test services: `sudo systemctl status nginx php8.2-fpm mysql redis-server`
5. Review configuration: `.env` và nginx config
6. Check permissions: `ls -la storage/ bootstrap/cache/`
- 🌐 **https://xeho247.vn**
- 🌐 **https://www.xeho247.vn**

### Test website

```bash
# Health check
curl -I https://xeho247.vn

# Test booking form
# Open browser: https://xeho247.vn
# Fill form and submit
# Check email notification
```

### Access services

```bash
# SSH to server
ssh root@103.82.132.130

# View logs
cd /var/www/webroot/xeho247danang
docker compose -f docker-compose.yml -f docker-compose.prod.yml logs -f

# Run commands
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec app php artisan [command]
```

---

## 📞 Support

**Nếu gặp vấn đề:**

1. Check logs: `/var/log/nginx/` và Docker logs
2. Verify DNS: `dig xeho247.vn`
3. Check SSL: `sudo certbot certificates`
4. Test containers: `docker compose ps`
5. Review configuration: `.env` và nginx config

**Contact:**
- Email: admin@xeho247danang.vn
- Phone: [Your phone number]

---

**Happy Deploying! 🚀🚗**

*Xế Hộ 24/7 - Dịch vụ thuê tài xế chuyên nghiệp tại Đà Nẵng*

# FLOWGRAM - Deployment Guide (Ubuntu 24)

## Server Information

| Item | Value |
|------|-------|
| Server IP | 43.206.238.223 |
| OS | Ubuntu 24.04 LTS |
| Web Server | Nginx |
| PHP | 8.3 |
| Database | MySQL 8 |
| Project Path | /var/www/flowgram |

---

## 1. Server Setup - Cài đặt packages

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install PHP 8.3 + extensions
sudo apt install php8.3-fpm php8.3-mysql php8.3-mbstring php8.3-xml \
    php8.3-bcmath php8.3-curl php8.3-zip php8.3-gd php8.3-intl -y

# Install Nginx
sudo apt install nginx -y

# Install MySQL
sudo apt install mysql-server -y

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Git
sudo apt install git -y

# Install htpasswd utility
sudo apt install apache2-utils -y
```

---

## 2. User Setup - Tạo user deploy

```bash
# Tạo user deploy (không password)
sudo adduser deploy --disabled-password --gecos ""

# Thêm vào groups
sudo usermod -aG sudo deploy
sudo usermod -aG www-data deploy

# Cho phép sudo không cần password
echo "deploy ALL=(ALL) NOPASSWD:ALL" | sudo tee /etc/sudoers.d/deploy
sudo chmod 440 /etc/sudoers.d/deploy

# Setup SSH key
sudo mkdir -p /home/deploy/.ssh
sudo chmod 700 /home/deploy/.ssh
sudo touch /home/deploy/.ssh/authorized_keys
sudo chmod 600 /home/deploy/.ssh/authorized_keys
sudo chown -R deploy:deploy /home/deploy/.ssh

# Thêm public key (thay bằng key thực)
echo "YOUR_PUBLIC_KEY" | sudo tee /home/deploy/.ssh/authorized_keys
```

---

## 3. Database Setup - Tạo MySQL database

```bash
# Đăng nhập MySQL
sudo mysql

# Chạy các lệnh sau:
CREATE DATABASE flowgram CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'flowgram'@'localhost' IDENTIFIED BY 'YOUR_DB_PASSWORD';
GRANT ALL PRIVILEGES ON flowgram.* TO 'flowgram'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Database Credentials

| Item | Value |
|------|-------|
| Host | 127.0.0.1 |
| Port | 3306 |
| Database | flowgram |
| Username | flowgram |
| Password | YOUR_DB_PASSWORD |

---

## 4. Project Setup - Clone và cài đặt

```bash
# Tạo thư mục project
sudo mkdir -p /var/www/flowgram
sudo chown -R deploy:www-data /var/www/flowgram
cd /var/www/flowgram

# Clone repo (Option A: Git)
git clone git@github.com:YOUR_USERNAME/YOUR_REPO.git .

# Hoặc upload từ local (Option B: rsync)
# rsync -avz --exclude 'vendor' --exclude '.env' ./src/ deploy@43.206.238.223:/var/www/flowgram/

# Cài đặt dependencies
composer install --no-dev --optimize-autoloader
```

---

## 5. Environment Setup - Cấu hình .env

```bash
cd /var/www/flowgram

# Copy .env
cp .env.example .env

# Generate APP_KEY
php artisan key:generate

# Edit .env
nano .env
```

### .env Production Config

```env
APP_NAME=FLOWGRAM
APP_ENV=production
APP_KEY=base64:xxxxx
APP_DEBUG=false
APP_TIMEZONE=Asia/Tokyo
APP_URL=http://43.206.238.223

APP_LOCALE=ja
APP_FALLBACK_LOCALE=ja

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=flowgram
DB_USERNAME=flowgram
DB_PASSWORD=YOUR_DB_PASSWORD

SESSION_DRIVER=database
SESSION_LIFETIME=120
CACHE_STORE=file
QUEUE_CONNECTION=database
```

---

## 6. Database Migration

```bash
cd /var/www/flowgram

# Run migrations
php artisan migrate --force

# Seed data
php artisan db:seed --force

# Create storage link
php artisan storage:link
```

---

## 7. Permissions

```bash
cd /var/www/flowgram

# Set ownership
sudo chown -R deploy:www-data .

# Set directory permissions
sudo find . -type d -exec chmod 755 {} \;

# Set file permissions
sudo find . -type f -exec chmod 644 {} \;

# Writable directories
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache

# Create upload directories
mkdir -p storage/app/private/downloads
mkdir -p storage/framework/{cache/data,sessions,views}
mkdir -p storage/logs

# Reset permissions
sudo chown -R deploy:www-data storage bootstrap/cache
```

---

## 8. Nginx Configuration

### Basic Auth Password

```bash
# Create password file
sudo htpasswd -c /etc/nginx/.htpasswd admin
# Enter password when prompted
```

### Nginx Config File

```bash
sudo nano /etc/nginx/sites-available/flowgram
```

```nginx
server {
    listen 80;
    listen [::]:80;
    
    server_name 43.206.238.223;
    root /var/www/flowgram/public;
    
    index index.php index.html;
    charset utf-8;
    
    # Basic Authentication
    auth_basic "Restricted Access";
    auth_basic_user_file /etc/nginx/.htpasswd;
    
    # Logs
    access_log /var/log/nginx/flowgram-access.log;
    error_log /var/log/nginx/flowgram-error.log;
    
    # Max upload size
    client_max_body_size 100M;
    
    # Gzip
    gzip on;
    gzip_types text/plain text/css application/json application/javascript text/xml application/xml;
    
    # Static HTML folder: /html
    location /html/ {
        alias /var/www/html/;
        index index.html;
        try_files $uri $uri/ =404;
        
        location ~* \.(jpg|jpeg|png|gif|ico|css|js|woff|woff2|svg)$ {
            expires 30d;
            add_header Cache-Control "public, immutable";
        }
    }
    
    # Laravel App
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
    
    error_page 404 /index.php;
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
    
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|woff|woff2)$ {
        expires 30d;
        add_header Cache-Control "public, immutable";
    }
}
```

### Enable Site

```bash
# Enable site
sudo ln -sf /etc/nginx/sites-available/flowgram /etc/nginx/sites-enabled/

# Disable default
sudo rm -f /etc/nginx/sites-enabled/default

# Create HTML folder
sudo mkdir -p /var/www/html
sudo chown -R deploy:www-data /var/www/html

# Test & reload
sudo nginx -t
sudo systemctl reload nginx
```

---

## 9. Laravel Optimization

```bash
cd /var/www/flowgram

# Clear all cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## 10. Firewall (UFW)

```bash
# Enable UFW
sudo ufw enable

# Allow ports
sudo ufw allow 22/tcp    # SSH
sudo ufw allow 80/tcp    # HTTP
sudo ufw allow 443/tcp   # HTTPS

# Check status
sudo ufw status
```

---

## Access URLs

| URL | Description |
|-----|-------------|
| http://43.206.238.223/ | Laravel App (Login page) |
| http://43.206.238.223/html/ | Static HTML files |
| http://43.206.238.223/admin | Admin Dashboard |
| http://43.206.238.223/mypage | User MyPage |

---

## Default Accounts

### Basic Auth (Nginx)

| Username | Password |
|----------|----------|
| admin | (your htpasswd password) |

### Application Accounts

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@admin.com | password |
| User (Premium) | premium@demo.com | password |
| User (Basic) | basic@demo.com | password |
| User (Free) | free@demo.com | password |

---

## Useful Commands

### Deployment Update

```bash
cd /var/www/flowgram

# Pull latest code
git pull origin main

# Update dependencies
composer install --no-dev --optimize-autoloader

# Run migrations
php artisan migrate --force

# Clear & rebuild cache
php artisan optimize:clear
php artisan optimize

# Restart PHP-FPM
sudo systemctl restart php8.3-fpm
```

### View Logs

```bash
# Laravel logs
tail -f /var/www/flowgram/storage/logs/laravel.log

# Nginx access logs
tail -f /var/log/nginx/flowgram-access.log

# Nginx error logs
tail -f /var/log/nginx/flowgram-error.log
```

### Service Management

```bash
# Nginx
sudo systemctl status nginx
sudo systemctl restart nginx
sudo systemctl reload nginx

# PHP-FPM
sudo systemctl status php8.3-fpm
sudo systemctl restart php8.3-fpm

# MySQL
sudo systemctl status mysql
sudo systemctl restart mysql
```

### Database Backup

```bash
# Backup
mysqldump -u flowgram -p flowgram > backup_$(date +%Y%m%d_%H%M%S).sql

# Restore
mysql -u flowgram -p flowgram < backup_file.sql
```

---

## Troubleshooting

### 500 Internal Server Error

```bash
# Check Laravel logs
tail -50 /var/www/flowgram/storage/logs/laravel.log

# Check Nginx logs
tail -50 /var/log/nginx/flowgram-error.log

# Check permissions
ls -la /var/www/flowgram/storage/
```

### Permission Denied

```bash
sudo chown -R deploy:www-data /var/www/flowgram
sudo chmod -R 775 /var/www/flowgram/storage
sudo chmod -R 775 /var/www/flowgram/bootstrap/cache
```

### PHP-FPM Socket Error

```bash
# Check PHP-FPM status
sudo systemctl status php8.3-fpm

# Check socket exists
ls -la /var/run/php/php8.3-fpm.sock

# Restart PHP-FPM
sudo systemctl restart php8.3-fpm
```

---

## Security Notes

1. **Change default passwords** before going to production
2. **Enable SSL** when you have a domain (use Let's Encrypt)
3. **Disable APP_DEBUG** in production
4. **Use strong passwords** for database and Basic Auth
5. **Regular backups** of database and uploaded files
6. **Keep packages updated** with `sudo apt update && sudo apt upgrade`

---

*Last updated: {{ date }}*

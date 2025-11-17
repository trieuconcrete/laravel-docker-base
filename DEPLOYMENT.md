# Hướng dẫn Deploy Production

## 🚀 Deploy lên Server

### 1. Chuẩn bị Server

**Yêu cầu:**
- Ubuntu 20.04/22.04
- Docker & Docker Compose
- Domain đã trỏ về server
- SSL certificate (Let's Encrypt)

### 2. Clone Project

```bash
git clone <repository-url>
cd laravel-docker-base
```

### 3. Cấu hình Production

Copy source Laravel vào `src/`:
```bash
cp -r /path/to/your/laravel/* ./src/
```

Chỉnh sửa `src/.env`:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_PASSWORD=StrongDatabasePassword
REDIS_PASSWORD=StrongRedisPassword

# Cấu hình mail thật
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
```

### 4. Deploy

```bash
# Build và khởi động
docker-compose -f docker-compose.yml -f docker-compose.prod.yml up -d

# Cài dependencies
docker-compose exec app composer install --no-dev --optimize-autoloader

# Migrations
docker-compose exec app php artisan migrate --force

# Cache
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
```

---

## 🔒 SSL với Nginx Reverse Proxy

### Cài Nginx trên host

```bash
sudo apt install nginx certbot python3-certbot-nginx
```

### Cấu hình Nginx

File `/etc/nginx/sites-available/yourdomain.com`:

```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name yourdomain.com www.yourdomain.com;

    ssl_certificate /etc/letsencrypt/live/yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/yourdomain.com/privkey.pem;

    location / {
        proxy_pass http://localhost:8000;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

Enable:
```bash
sudo ln -s /etc/nginx/sites-available/yourdomain.com /etc/nginx/sites-enabled/
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
sudo nginx -t
sudo systemctl reload nginx
```

---

## 📊 Queue Workers với Supervisor

```bash
sudo apt install supervisor
```

File `/etc/supervisor/conf.d/laravel-worker.conf`:

```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=docker-compose -f /path/to/project/docker-compose.yml exec -T app php artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=root
numprocs=4
redirect_stderr=true
stdout_logfile=/var/log/laravel-worker.log
```

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
```

---

## ⏰ Task Scheduler

```bash
crontab -e
```

Thêm:
```
* * * * * cd /path/to/project && docker-compose exec -T app php artisan schedule:run >> /dev/null 2>&1
```

---

## 💾 Backup Tự động

```bash
crontab -e
```

Thêm:
```
0 2 * * * cd /path/to/project && ./backup.sh >> /var/log/laravel-backup.log 2>&1
```

---

## 🔥 Firewall

```bash
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw allow 22/tcp
sudo ufw enable
```

---

## 📈 Monitoring

### Container Logs

```bash
docker-compose logs -f
docker-compose logs -f app
docker-compose logs -f nginx
```

### Laravel Logs

```bash
docker-compose exec app tail -f storage/logs/laravel.log
```

---

## 🔄 Update Application

```bash
cd /path/to/project

# Pull latest code
git pull origin main

# Copy to src/
cp -r /path/to/updated/laravel/* ./src/

# Update
docker-compose exec app composer install --no-dev
docker-compose exec app php artisan migrate --force
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache

# Restart
docker-compose restart app
```

---

## 🛡️ Security

### 1. Environment
```env
APP_ENV=production
APP_DEBUG=false
```

### 2. Strong Passwords
- Database password mạnh
- Redis password mạnh
- Thay đổi root passwords

### 3. Firewall
Chỉ mở ports cần thiết: 80, 443, 22

### 4. Regular Updates
```bash
docker-compose pull
docker-compose up -d --build
```

### 5. Backup
Backup database hàng ngày

---

## 🔧 Performance

### 1. OPcache
Đã cấu hình trong `docker/php/php.ini`

### 2. Cache
```bash
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
```

### 3. Database Indexing
Optimize queries và thêm indexes

### 4. CDN
Sử dụng CDN cho assets

---

## 📞 Troubleshooting

### High CPU
```bash
docker stats
docker-compose restart
```

### High Memory
```bash
docker-compose exec app php artisan cache:clear
docker-compose restart
```

### Database Issues
```bash
docker-compose logs mysql
docker-compose restart mysql
```

---

## 🆘 Rollback

```bash
# Stop
docker-compose down

# Checkout previous version
git checkout <previous-commit>

# Restore database
./restore.sh backups/laravel_backup_YYYYMMDD.sql.gz

# Start
docker-compose up -d
```

---

## 📚 Xem thêm

- **README.md** - Tổng quan
- **INSTALL.md** - Cài đặt
- **QUICKSTART.md** - Quick start

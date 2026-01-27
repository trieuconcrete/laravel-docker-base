# 🏗️ Architecture Overview

## 📐 System Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                         HOST MACHINE                         │
│                                                              │
│  Browser ──────────► http://localhost:8000                  │
│  MySQL Client ─────► localhost:3307                         │
│  Email UI ─────────► http://localhost:8025                  │
│                                                              │
└──────────────────────────┬───────────────────────────────────┘
                          │
                          │ Docker Network: laravel
                          │
┌──────────────────────────▼───────────────────────────────────┐
│                    DOCKER CONTAINERS                         │
│                                                              │
│  ┌──────────────┐      ┌──────────────┐                    │
│  │    Nginx     │◄─────┤  PHP-FPM 8.3 │                    │
│  │   (Alpine)   │      │  (Laravel 12)│                    │
│  │  Port: 80    │      │  Port: 9000  │                    │
│  │  → 8000      │      │              │                    │
│  └──────┬───────┘      └──────┬───────┘                    │
│         │                     │                             │
│         │                     ├────────► MySQL 8.0          │
│         │                     │          Port: 3306→3307    │
│         │                     │          Volume: mysql_data │
│         │                     │                             │
│         │                     ├────────► Redis              │
│         │                     │          Port: 6379         │
│         │                     │          Volume: redis_data │
│         │                     │                             │
│         │                     └────────► Mailhog            │
│         │                                Port: 1025, 8025   │
│         │                                                    │
│         └────────► /var/www/html/public                     │
│                    (Volume Mount)                            │
│                                                              │
└──────────────────────────────────────────────────────────────┘
                          │
                          ▼
                    Volume Mounts
                          │
┌──────────────────────────▼───────────────────────────────────┐
│                     HOST FILESYSTEM                          │
│                                                              │
│  ./src ──────────────────► /var/www/html (all containers)   │
│  ./docker/nginx/default.conf ──► /etc/nginx/conf.d/         │
│  mysql_data (volume) ──────────► MySQL data persistence     │
│  redis_data (volume) ──────────► Redis data persistence     │
│                                                              │
└──────────────────────────────────────────────────────────────┘
```

---

## 🔄 Request Flow

### Web Request Flow

```
1. Browser Request
   ↓
2. http://localhost:8000
   ↓
3. Host Machine Port 8000
   ↓
4. Docker Network → Nginx Container (Port 80)
   ↓
5. Nginx forwards to PHP-FPM (Port 9000)
   ↓
6. PHP-FPM executes Laravel
   ↓
7. Laravel connects to services:
   ├─► MySQL (mysql:3306)
   ├─► Redis (redis:6379)
   └─► Mailhog (mailhog:1025)
   ↓
8. Response back through Nginx
   ↓
9. Browser receives response
```

### Database Connection Flow

```
┌─────────────────────────────────────────────────┐
│          From Laravel Container                  │
│                                                 │
│  .env:                                          │
│  DB_HOST=mysql          ← Service name         │
│  DB_PORT=3306           ← Internal port        │
│                                                 │
│  Container → Docker Network → MySQL Container  │
│             (mysql:3306)                        │
└─────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────┐
│          From Host Machine                      │
│          (TablePlus, DBeaver, etc.)            │
│                                                 │
│  Host: localhost                                │
│  Port: 3307             ← Mapped port          │
│                                                 │
│  Host → Port Mapping → MySQL Container         │
│        (3307:3306)                             │
└─────────────────────────────────────────────────┘
```

---

## 📦 Container Details

### Nginx Container

```yaml
Name: laravel_nginx
Image: nginx:alpine
Ports: 8000:80
Volumes:
  - ./src:/var/www/html
  - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
Network: laravel
Purpose: Web server, reverse proxy to PHP-FPM
```

**Configuration:**
- Document root: `/var/www/html/public`
- FastCGI pass to: `app:9000`
- Security headers enabled
- Gzip compression

### PHP-FPM Container

```yaml
Name: laravel_app
Image: Custom (PHP 8.3)
Build: ./docker/php/Dockerfile
Volumes: ./src:/var/www/html
Network: laravel
Purpose: Run Laravel application
```

**Installed Extensions:**
- PDO, PDO_MySQL
- Mbstring, XML, BCMath
- GD (with JPEG, FreeType)
- Redis
- Zip, Exif, PCNTL

**Additional Software:**
- Composer 2.x
- Git, Curl, Unzip

### MySQL Container

```yaml
Name: laravel_mysql
Image: mysql:8.0
Ports: 3307:3306          ← Changed from 3306
Volume: mysql_data
Network: laravel
Environment:
  - MYSQL_DATABASE=laravel
  - MYSQL_USER=laravel
  - MYSQL_PASSWORD=secret
  - MYSQL_ROOT_PASSWORD=root
```

**Why port 3307?**
- Avoids conflict with host MySQL on 3306
- Internal communication still uses 3306
- External tools connect via 3307

### Redis Container

```yaml
Name: laravel_redis
Image: redis:alpine
Ports: 6379:6379
Volume: redis_data
Network: laravel
Purpose: Cache, Sessions, Queue
```

**Used for:**
- Application cache
- Session storage
- Queue driver (optional)
- Broadcasting (optional)

### Mailhog Container

```yaml
Name: laravel_mailhog
Image: mailhog/mailhog:latest
Ports:
  - 8025:8025  # Web UI
  - 1025:1025  # SMTP
Network: laravel
Purpose: Email testing
```

**Features:**
- Catches all outgoing emails
- Web UI for viewing emails
- No actual emails sent
- Great for development

---

## 💾 Data Persistence

### Docker Volumes

```
mysql_data/           # MySQL database files
  ├── mysql/          # System databases
  ├── laravel/        # Application database
  └── [binary files]

redis_data/           # Redis persistence
  └── dump.rdb        # Redis snapshot
```

### File Mounts

```
./src/                          → /var/www/html
├── app/                        Laravel application
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/                     Nginx document root
├── resources/
├── routes/
├── storage/                    Writable
│   ├── app/
│   ├── framework/
│   └── logs/
├── tests/
├── vendor/                     Composer packages
├── .env                        Environment config
└── artisan                     CLI tool

./docker/nginx/default.conf    → /etc/nginx/conf.d/
./docker/php/php.ini           → /usr/local/etc/php/conf.d/
```

---

## 🌐 Network Configuration

### Docker Network: `laravel`

```
Type: Bridge
Driver: bridge

Connected Containers:
├── laravel_nginx      (nginx)
├── laravel_app        (app)
├── laravel_mysql      (mysql)
├── laravel_redis      (redis)
└── laravel_mailhog    (mailhog)
```

### Service Discovery

Containers can communicate using service names:

```php
// From Laravel
DB_HOST=mysql          // Not localhost!
REDIS_HOST=redis       // Service name
MAIL_HOST=mailhog      // Service name
```

### Port Mapping

| Service | Container Port | Host Port | Protocol |
|---------|----------------|-----------|----------|
| Nginx   | 80             | 8000      | HTTP     |
| PHP-FPM | 9000           | -         | FastCGI  |
| MySQL   | 3306           | **3307**  | TCP      |
| Redis   | 6379           | 6379      | TCP      |
| Mailhog SMTP | 1025      | 1025      | SMTP     |
| Mailhog UI | 8025        | 8025      | HTTP     |

---

## 🔐 Security Layers

### Container Level
- Non-root user (www:www) in PHP container
- Read-only mounts where possible
- Limited network exposure
- Volume permissions

### Application Level
- Laravel built-in security
- CSRF protection
- XSS prevention
- SQL injection prevention (Eloquent)

### Network Level
- Isolated Docker network
- Only necessary ports exposed
- Internal service communication

### Nginx Level
- Security headers
- Request size limits
- Hidden PHP version
- Access restrictions

---

## 📊 Performance Optimization

### OPcache (PHP)
```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=10000
```

### Redis Cache
```env
CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

### Nginx
- Gzip compression
- Static file caching
- FastCGI caching (optional)

---

## 🔄 Development Workflow

```
Developer
   ↓
Edit files in ./src/
   ↓
Changes synced instantly (volume mount)
   ↓
Browser refresh
   ↓
Nginx → PHP-FPM → Laravel
   ↓
See changes immediately
```

### No rebuild needed for:
- PHP code changes
- View changes
- Config changes (after cache clear)
- Migration files
- Route changes (after cache clear)

### Rebuild needed for:
- PHP extensions
- PHP version change
- System packages
- Dockerfile changes
- Nginx config changes

---

## 🚀 Scaling Strategies

### Horizontal Scaling

```bash
# Scale PHP-FPM containers
docker-compose up -d --scale app=3

# Update Nginx upstream
upstream laravel_backend {
    server app:9000;
    server app:9001;
    server app:9002;
}
```

### Vertical Scaling

```yaml
# docker-compose.yml
services:
  app:
    deploy:
      resources:
        limits:
          cpus: '2.0'
          memory: 2G
```

### Database Scaling
- Master-slave replication
- Read replicas
- Connection pooling

### Cache Scaling
- Redis Cluster
- Redis Sentinel
- Multiple Redis instances

---

## 🎯 Production Differences

### Development
- Debug mode enabled
- Mailhog for emails
- Hot reload
- Verbose logging
- Exposed ports

### Production
- Debug mode disabled
- Real mail service
- Optimized autoloader
- Cached config/routes/views
- Minimal exposed ports
- SSL/TLS
- Stronger passwords
- Resource limits
- Health checks
- Auto-restart policies

---

## 📈 Monitoring Points

### Container Health
```bash
docker-compose ps
./healthcheck.sh
```

### Application Logs
```bash
docker-compose logs -f app
tail -f src/storage/logs/laravel.log
```

### Database
```bash
docker-compose exec mysql mysqladmin status
docker-compose exec mysql mysql -e "SHOW PROCESSLIST"
```

### Cache
```bash
docker-compose exec redis redis-cli INFO stats
```

### Web Server
```bash
docker-compose logs nginx
```

---

## 🔧 Maintenance

### Backups
```bash
./backup.sh              # Database
tar -czf src.tar.gz src/ # Code
```

### Updates
```bash
docker-compose pull      # Update images
docker-compose up -d     # Recreate containers
```

### Cleanup
```bash
docker-compose down -v   # Remove everything
docker system prune      # Clean Docker
```

---

## 💡 Best Practices Applied

1. ✅ Separation of concerns (each service in container)
2. ✅ Volume mounts for development
3. ✅ Named volumes for data persistence
4. ✅ Environment-based configuration
5. ✅ Service discovery via Docker network
6. ✅ Health checks
7. ✅ Logging strategy
8. ✅ Resource limits
9. ✅ Security hardening
10. ✅ Documentation

---

This architecture provides:
- 🚀 Fast development workflow
- 📦 Easy deployment
- 🔄 Horizontal scalability
- 🔐 Security by default
- 📊 Observable and maintainable
- 🎯 Production-ready

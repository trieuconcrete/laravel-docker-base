# Changelog

## [Fixed] Port Conflict Issues - 2025-01-17

### ✅ Đã fix

**Vấn đề**: MySQL port 3306 conflict với MySQL đã cài trên máy
```
Error: Ports are not available: exposing port TCP 0.0.0.0:3306 -> 0.0.0.0:0: 
listen tcp 0.0.0.0:3306: bind: address already in use
```

**Giải pháp**: 
- Đổi MySQL port mapping từ `3306:3306` → `3307:3306`
- Container MySQL vẫn chạy ở port 3306 bên trong
- Từ host machine kết nối qua port 3307

### 📝 Files đã cập nhật

1. **docker-compose.yml**
   - MySQL ports: `3307:3306`

2. **README.md**
   - Services section: MySQL port 3307
   - Database connection info: localhost:3307
   - Thêm lưu ý về internal vs external port

3. **QUICKSTART.md**
   - Database info: localhost:3307

4. **INDEX.md**
   - Database section: localhost:3307
   - Services table: MySQL 3307 → 3306
   - Thêm link PORT-CONFLICTS.md

5. **healthcheck.sh**
   - Output: localhost:3307

6. **setup.sh**
   - Output message: localhost:3307

### 📄 Files mới

7. **PORT-CONFLICTS.md** (NEW)
   - Hướng dẫn xử lý port conflicts
   - Cách kiểm tra ports đang sử dụng
   - Cách dừng services chiếm port
   - Best practices cho port mapping
   - Troubleshooting guide

### 🔍 Kiểm tra

Sau khi fix, kiểm tra bằng:

```bash
# Khởi động containers
docker-compose up -d

# Kiểm tra MySQL port
docker-compose ps

# Kết nối MySQL từ host
mysql -h localhost -P 3307 -u laravel -p

# Health check
./healthcheck.sh
```

### ⚙️ Cấu hình Laravel

**Không cần thay đổi** `.env` của Laravel:
```env
DB_HOST=mysql        # Service name, không phải localhost
DB_PORT=3306         # Port BÊN TRONG container
```

**Chỉ cần thay đổi** khi kết nối từ GUI tools (TablePlus, DBeaver, etc.):
- Host: `localhost`
- Port: `3307` ← Đây là port từ host machine

### 📊 Port Summary

| Service | Host → Container | Note |
|---------|------------------|------|
| Nginx   | 8000 → 80       | Web application |
| MySQL   | **3307** → 3306 | Changed from 3306 |
| Redis   | 6379 → 6379     | No change |
| Mailhog UI | 8025 → 8025  | No change |
| Mailhog SMTP | 1025 → 1025 | No change |

### 🛡️ Tương thích ngược

Nếu bạn muốn dùng lại port 3306 (sau khi dừng MySQL trên máy):

```bash
# Dừng MySQL trên máy
sudo systemctl stop mysql    # Linux
brew services stop mysql     # Mac

# Sửa docker-compose.yml
mysql:
  ports:
    - "3306:3306"  # Đổi lại từ 3307

# Restart containers
docker-compose down
docker-compose up -d
```

### ℹ️ Additional Info

- Container name: `laravel_mysql`
- Network: `laravel`
- Volume: `mysql_data`
- Root password: `root`
- Database: `laravel`
- User: `laravel`
- Password: `secret`

---

## Previous Changes

### [Initial Release] - 2025-01-17

- ✅ Docker Compose setup with Nginx, PHP-FPM, MySQL, Redis, Mailhog
- ✅ PHP 8.3 with all Laravel required extensions
- ✅ Makefile with 20+ utility commands
- ✅ Auto setup script
- ✅ Health check script
- ✅ Database backup/restore scripts
- ✅ Complete documentation (README, INSTALL, DEPLOYMENT, QUICKSTART)
- ✅ Production-ready configuration

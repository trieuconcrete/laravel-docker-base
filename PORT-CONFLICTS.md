# 🔧 Xử lý Port Conflicts

## Vấn đề thường gặp

Khi khởi động Docker containers, bạn có thể gặp lỗi:
```
Ports are not available: exposing port TCP 0.0.0.0:XXXX -> 0.0.0.0:0: listen tcp 0.0.0.0:XXXX: bind: address already in use
```

## Giải pháp

### 1. MySQL Port Conflict (Port 3306)

**Nguyên nhân**: Bạn đã có MySQL đang chạy trên máy.

**Giải pháp đã áp dụng**: Project này đã sử dụng port 3307 thay vì 3306.

```yaml
# docker-compose.yml
mysql:
  ports:
    - "3307:3306"  # Host:Container
```

**Kết nối từ host machine**:
```bash
mysql -h localhost -P 3307 -u laravel -p
```

**Kết nối từ Laravel** (bên trong container vẫn dùng port 3306):
```env
DB_HOST=mysql
DB_PORT=3306
```

### 2. Nginx/Apache Port Conflict (Port 80 hoặc 8000)

**Nguyên nhân**: Port 8000 đang được sử dụng.

**Giải pháp**: Thay đổi port trong `docker-compose.yml`:

```yaml
nginx:
  ports:
    - "8080:80"  # Thay 8000 thành 8080
```

Sau đó truy cập: http://localhost:8080

### 3. Redis Port Conflict (Port 6379)

**Giải pháp**: Thay đổi port Redis:

```yaml
redis:
  ports:
    - "6380:6379"
```

### 4. Mailhog Port Conflict (Port 8025)

**Giải pháp**: Thay đổi port Mailhog:

```yaml
mailhog:
  ports:
    - "8026:8025"  # Web UI
    - "1025:1025"  # SMTP không cần đổi
```

## Cách kiểm tra port đang được sử dụng

### Linux/Mac:
```bash
# Kiểm tra port cụ thể
sudo lsof -i :3306
sudo lsof -i :8000

# Hoặc dùng netstat
netstat -tuln | grep 3306
```

### Windows:
```cmd
# PowerShell
Get-Process -Id (Get-NetTCPConnection -LocalPort 3306).OwningProcess

# Command Prompt
netstat -ano | findstr :3306
```

## Dừng service đang chiếm port

### MySQL trên Ubuntu/Debian:
```bash
sudo systemctl stop mysql
sudo systemctl disable mysql  # Ngăn tự khởi động
```

### MySQL trên Mac:
```bash
brew services stop mysql
```

### MySQL trên Windows:
```cmd
net stop MySQL80
```

## Tùy chỉnh tất cả ports

Tạo file `docker-compose.override.yml`:

```yaml
version: '3.8'

services:
  nginx:
    ports:
      - "8080:80"
  
  mysql:
    ports:
      - "3307:3306"
  
  redis:
    ports:
      - "6380:6379"
  
  mailhog:
    ports:
      - "8026:8025"
      - "1026:1025"
```

File này sẽ tự động override `docker-compose.yml` mà không cần sửa file gốc.

## Không cần expose ports

Nếu bạn chỉ truy cập từ bên trong Docker network (không cần kết nối từ host), có thể bỏ phần `ports`:

```yaml
mysql:
  # ports:
  #   - "3307:3306"  # Comment hoặc xóa dòng này
  environment:
    MYSQL_DATABASE: laravel
```

Laravel vẫn kết nối được vì cùng Docker network, nhưng bạn không thể kết nối từ TablePlus, MySQL Workbench, v.v.

## Best Practices

1. **Development**: Expose ports để dễ debug và kiểm tra
2. **Production**: Chỉ expose port cần thiết (80/443 cho web)
3. **Sử dụng `.env`**: Định nghĩa ports trong file `.env`:

```bash
# .env
NGINX_PORT=8000
MYSQL_PORT=3307
REDIS_PORT=6379
MAILHOG_PORT=8025
```

```yaml
# docker-compose.yml
nginx:
  ports:
    - "${NGINX_PORT:-8000}:80"
mysql:
  ports:
    - "${MYSQL_PORT:-3307}:3306"
```

## Troubleshooting

### Lỗi vẫn còn sau khi đổi port?

```bash
# Dừng và xóa containers
docker-compose down

# Xóa networks
docker network prune

# Khởi động lại
docker-compose up -d
```

### Container không kết nối được sau khi đổi port?

Kiểm tra file `.env` của Laravel có đúng không:
```env
DB_HOST=mysql        # Tên service, không phải localhost
DB_PORT=3306         # Port BÊN TRONG container
```

### Cần kết nối từ nhiều nơi?

Sử dụng port forwarding hoặc reverse proxy thay vì expose trực tiếp.

## Port Summary cho Project này

| Service | Host Port | Container Port | URL/Connection |
|---------|-----------|----------------|----------------|
| Nginx   | 8000      | 80             | http://localhost:8000 |
| MySQL   | **3307**  | 3306           | localhost:3307 |
| Redis   | 6379      | 6379           | localhost:6379 |
| Mailhog UI | 8025   | 8025           | http://localhost:8025 |
| Mailhog SMTP | 1025 | 1025          | localhost:1025 |

> **Lưu ý**: MySQL đã được đổi từ 3306 → 3307 để tránh conflict với MySQL cài sẵn trên máy.

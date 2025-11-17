#!/bin/bash

echo "=========================================="
echo "Laravel 12 Docker Setup Script"
echo "=========================================="
echo ""

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Kiểm tra Docker
if ! command -v docker &> /dev/null; then
    echo -e "${RED}❌ Docker không được cài đặt. Vui lòng cài Docker trước.${NC}"
    exit 1
fi

if ! command -v docker-compose &> /dev/null; then
    echo -e "${RED}❌ Docker Compose không được cài đặt. Vui lòng cài Docker Compose trước.${NC}"
    exit 1
fi

echo -e "${GREEN}✅ Docker và Docker Compose đã được cài đặt${NC}"
echo ""

# Kiểm tra thư mục src
if [ ! -d "src" ]; then
    mkdir -p src
    echo -e "${YELLOW}📁 Đã tạo thư mục src/${NC}"
fi

# Khởi động containers
echo -e "${GREEN}🚀 Khởi động Docker containers...${NC}"
docker-compose up -d

echo ""
echo "⏳ Đợi containers khởi động hoàn tất..."
sleep 10

# Kiểm tra xem đã có Laravel source chưa
if [ ! -f "src/artisan" ]; then
    echo ""
    echo -e "${GREEN}📦 Cài đặt Laravel 12...${NC}"
    docker-compose exec -T app composer create-project laravel/laravel . --prefer-dist
    
    if [ $? -ne 0 ]; then
        echo -e "${RED}❌ Lỗi khi cài đặt Laravel${NC}"
        exit 1
    fi
else
    echo ""
    echo -e "${YELLOW}✅ Laravel đã tồn tại trong src/${NC}"
    echo -e "${GREEN}📦 Cài đặt dependencies...${NC}"
    docker-compose exec -T app composer install
fi

# Copy .env file
echo ""
echo "⚙️  Cấu hình environment..."
if [ ! -f "src/.env" ]; then
    docker-compose exec -T app cp .env.example .env
    if [ $? -ne 0 ]; then
        # Fallback nếu lệnh trên fail
        cp .env.example src/.env 2>/dev/null || true
    fi
fi

# Generate key
echo -e "${GREEN}🔑 Generate application key...${NC}"
docker-compose exec -T app php artisan key:generate

# Update .env với database credentials
echo -e "${GREEN}🗄️  Cập nhật database configuration...${NC}"
docker-compose exec -T app sed -i 's/DB_HOST=127.0.0.1/DB_HOST=mysql/g' .env 2>/dev/null || \
    sed -i 's/DB_HOST=127.0.0.1/DB_HOST=mysql/g' src/.env 2>/dev/null

docker-compose exec -T app sed -i 's/DB_DATABASE=laravel/DB_DATABASE=laravel/g' .env 2>/dev/null || \
    sed -i 's/DB_DATABASE=laravel/DB_DATABASE=laravel/g' src/.env 2>/dev/null

docker-compose exec -T app sed -i 's/DB_USERNAME=root/DB_USERNAME=laravel/g' .env 2>/dev/null || \
    sed -i 's/DB_USERNAME=root/DB_USERNAME=laravel/g' src/.env 2>/dev/null

docker-compose exec -T app sed -i 's/DB_PASSWORD=/DB_PASSWORD=secret/g' .env 2>/dev/null || \
    sed -i 's/DB_PASSWORD=/DB_PASSWORD=secret/g' src/.env 2>/dev/null

# Update Redis config
docker-compose exec -T app sed -i 's/REDIS_HOST=127.0.0.1/REDIS_HOST=redis/g' .env 2>/dev/null || \
    sed -i 's/REDIS_HOST=127.0.0.1/REDIS_HOST=redis/g' src/.env 2>/dev/null

docker-compose exec -T app sed -i 's/CACHE_STORE=.*/CACHE_STORE=redis/g' .env 2>/dev/null || \
    sed -i 's/CACHE_STORE=.*/CACHE_STORE=redis/g' src/.env 2>/dev/null

docker-compose exec -T app sed -i 's/SESSION_DRIVER=.*/SESSION_DRIVER=redis/g' .env 2>/dev/null || \
    sed -i 's/SESSION_DRIVER=.*/SESSION_DRIVER=redis/g' src/.env 2>/dev/null

docker-compose exec -T app sed -i 's/QUEUE_CONNECTION=.*/QUEUE_CONNECTION=redis/g' .env 2>/dev/null || \
    sed -i 's/QUEUE_CONNECTION=.*/QUEUE_CONNECTION=redis/g' src/.env 2>/dev/null

# Update Mail config
docker-compose exec -T app sed -i 's/MAIL_HOST=.*/MAIL_HOST=mailhog/g' .env 2>/dev/null || \
    sed -i 's/MAIL_HOST=.*/MAIL_HOST=mailhog/g' src/.env 2>/dev/null

docker-compose exec -T app sed -i 's/MAIL_PORT=.*/MAIL_PORT=1025/g' .env 2>/dev/null || \
    sed -i 's/MAIL_PORT=.*/MAIL_PORT=1025/g' src/.env 2>/dev/null

# Chạy migrations
echo ""
echo -e "${GREEN}🗃️  Chạy database migrations...${NC}"
docker-compose exec -T app php artisan migrate --force

if [ $? -ne 0 ]; then
    echo -e "${YELLOW}⚠️  Migrations failed. Có thể database chưa sẵn sàng.${NC}"
    echo "Bạn có thể chạy lại sau bằng: make migrate"
fi

# Set permissions
echo ""
echo -e "${GREEN}🔐 Thiết lập permissions...${NC}"
docker-compose exec -T app chown -R www:www /var/www/html/storage 2>/dev/null || true
docker-compose exec -T app chown -R www:www /var/www/html/bootstrap/cache 2>/dev/null || true
docker-compose exec -T app chmod -R 775 /var/www/html/storage 2>/dev/null || true
docker-compose exec -T app chmod -R 775 /var/www/html/bootstrap/cache 2>/dev/null || true

echo ""
echo "=========================================="
echo -e "${GREEN}✅ Setup hoàn tất!${NC}"
echo "=========================================="
echo ""
echo -e "🌐 Application: ${GREEN}http://localhost:8000${NC}"
echo -e "📧 Mailhog UI: ${GREEN}http://localhost:8025${NC}"
echo -e "🗄️  MySQL: ${GREEN}localhost:3307${NC} (internal: 3306)"
echo "   - Database: laravel"
echo "   - Username: laravel"
echo "   - Password: secret"
echo ""
echo "📝 Các lệnh hữu ích:"
echo "   - make help          : Xem tất cả lệnh"
echo "   - make shell         : Truy cập container"
echo "   - make logs          : Xem logs"
echo "   - make artisan cmd=\"migrate\" : Chạy artisan command"
echo ""

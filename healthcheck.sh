#!/bin/bash

# Healthcheck script for Laravel application

echo "=========================================="
echo "Laravel Docker Health Check"
echo "=========================================="
echo ""

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if containers are running
echo "1. Checking containers..."
if docker-compose ps | grep -q "Up"; then
    echo -e "${GREEN}✓ Containers are running${NC}"
else
    echo -e "${RED}✗ Some containers are not running${NC}"
    docker-compose ps
    exit 1
fi
echo ""

# Check Nginx
echo "2. Checking Nginx..."
if curl -s -o /dev/null -w "%{http_code}" http://localhost:8000 | grep -q "200\|302"; then
    echo -e "${GREEN}✓ Nginx is responding${NC}"
else
    echo -e "${RED}✗ Nginx is not responding${NC}"
fi
echo ""

# Check PHP-FPM
echo "3. Checking PHP-FPM..."
if docker-compose exec -T app php -v &> /dev/null; then
    echo -e "${GREEN}✓ PHP-FPM is running${NC}"
    php_version=$(docker-compose exec -T app php -v | head -n 1)
    echo "  $php_version"
else
    echo -e "${RED}✗ PHP-FPM is not running${NC}"
fi
echo ""

# Check MySQL
echo "4. Checking MySQL..."
if docker-compose exec -T mysql mysql -u laravel -psecret -e 'SELECT 1' &> /dev/null; then
    echo -e "${GREEN}✓ MySQL is responding${NC}"
else
    echo -e "${RED}✗ MySQL is not responding${NC}"
fi
echo ""

# Check Redis
echo "5. Checking Redis..."
if docker-compose exec -T redis redis-cli ping &> /dev/null; then
    echo -e "${GREEN}✓ Redis is responding${NC}"
else
    echo -e "${RED}✗ Redis is not responding${NC}"
fi
echo ""

# Check Mailhog
echo "6. Checking Mailhog..."
if curl -s -o /dev/null -w "%{http_code}" http://localhost:8025 | grep -q "200"; then
    echo -e "${GREEN}✓ Mailhog is responding${NC}"
else
    echo -e "${YELLOW}⚠ Mailhog is not responding${NC}"
fi
echo ""

# Check Laravel
echo "7. Checking Laravel..."
if [ -f "src/artisan" ]; then
    echo -e "${GREEN}✓ Laravel is installed${NC}"
    
    # Check Laravel version
    version=$(docker-compose exec -T app php artisan --version 2>/dev/null)
    if [ $? -eq 0 ]; then
        echo "  Version: $version"
    fi
    
    # Check database connection
    echo -n "  Database connection... "
    if docker-compose exec -T app php artisan migrate:status &> /dev/null; then
        echo -e "${GREEN}✓ OK${NC}"
    else
        echo -e "${RED}✗ FAILED${NC}"
    fi
    
    # Check cache
    echo -n "  Cache connection... "
    if docker-compose exec -T app php artisan cache:clear &> /dev/null; then
        echo -e "${GREEN}✓ OK${NC}"
    else
        echo -e "${YELLOW}⚠ WARNING${NC}"
    fi
else
    echo -e "${YELLOW}⚠ Laravel not installed yet${NC}"
    echo "  Run: make install-laravel"
fi
echo ""

# Summary
echo "=========================================="
echo "Health Check Complete"
echo "=========================================="
echo ""
echo "URLs:"
echo "  Application: http://localhost:8000"
echo "  Mailhog UI:  http://localhost:8025"
echo ""
echo "Database:"
echo "  Host: localhost:3307"
echo "  Database: laravel"
echo "  Username: laravel"
echo "  Password: secret"
echo ""

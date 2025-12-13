#!/bin/bash

#===========================================
# FLOWGRAM First-time Deployment Script
# Ubuntu 24.04 + Nginx + PHP 8.3 + MySQL
#===========================================

set -e  # Exit on error

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# Configuration - EDIT THESE
APP_DIR="/var/www/flowgram/src"
GIT_REPO="git@github.com:YOUR_USERNAME/YOUR_REPO.git"
BRANCH="project/flowgram-ld"
DB_NAME="flowgram"
DB_USER="flowgram"
DB_PASS="YOUR_DB_PASSWORD"
SERVER_IP="43.206.238.223"
PHP_VERSION="8.3"
HTPASSWD_USER="admin"
HTPASSWD_PASS="YOUR_HTPASSWD_PASSWORD"

#===========================================
# Functions
#===========================================

print_header() {
    echo ""
    echo -e "${BLUE}============================================${NC}"
    echo -e "${BLUE}  $1${NC}"
    echo -e "${BLUE}============================================${NC}"
    echo ""
}

print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_info() {
    echo -e "${BLUE}→ $1${NC}"
}

#===========================================
# 1. Install System Packages
#===========================================

print_header "1. Installing System Packages"

sudo apt update
sudo apt upgrade -y

# PHP 8.3
sudo apt install -y php${PHP_VERSION}-fpm php${PHP_VERSION}-mysql php${PHP_VERSION}-mbstring \
    php${PHP_VERSION}-xml php${PHP_VERSION}-bcmath php${PHP_VERSION}-curl php${PHP_VERSION}-zip \
    php${PHP_VERSION}-gd php${PHP_VERSION}-intl

# Nginx, MySQL, Git
sudo apt install -y nginx mysql-server git apache2-utils unzip

# Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

print_success "Packages installed"

#===========================================
# 2. Setup MySQL Database
#===========================================

print_header "2. Setting up MySQL Database"

sudo mysql -e "CREATE DATABASE IF NOT EXISTS ${DB_NAME} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
sudo mysql -e "CREATE USER IF NOT EXISTS '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASS}';"
sudo mysql -e "GRANT ALL PRIVILEGES ON ${DB_NAME}.* TO '${DB_USER}'@'localhost';"
sudo mysql -e "FLUSH PRIVILEGES;"

print_success "Database created"

#===========================================
# 3. Clone Project
#===========================================

print_header "3. Cloning Project"

REPO_DIR="/var/www/flowgram"
sudo mkdir -p $REPO_DIR
sudo chown -R $USER:www-data $REPO_DIR
cd $REPO_DIR

if [ -d ".git" ]; then
    print_info "Git repo exists, pulling latest..."
    git fetch origin
    git checkout $BRANCH
    git pull origin $BRANCH
else
    print_info "Cloning repository..."
    git clone -b $BRANCH $GIT_REPO .
fi

cd $APP_DIR
print_success "Project cloned"

#===========================================
# 4. Install Dependencies
#===========================================

print_header "4. Installing Dependencies"

composer install --no-dev --optimize-autoloader --no-interaction

print_success "Dependencies installed"

#===========================================
# 5. Configure Environment
#===========================================

print_header "5. Configuring Environment"

if [ ! -f ".env" ]; then
    cp .env.example .env
    php artisan key:generate
fi

# Update .env values
sed -i "s|APP_ENV=.*|APP_ENV=production|g" .env
sed -i "s|APP_DEBUG=.*|APP_DEBUG=false|g" .env
sed -i "s|APP_URL=.*|APP_URL=http://${SERVER_IP}|g" .env
sed -i "s|DB_DATABASE=.*|DB_DATABASE=${DB_NAME}|g" .env
sed -i "s|DB_USERNAME=.*|DB_USERNAME=${DB_USER}|g" .env
sed -i "s|DB_PASSWORD=.*|DB_PASSWORD=${DB_PASS}|g" .env

print_success "Environment configured"

#===========================================
# 6. Run Migrations & Seed
#===========================================

print_header "6. Running Migrations"

php artisan migrate --force
php artisan db:seed --force
php artisan storage:link

print_success "Migrations completed"

#===========================================
# 7. Set Permissions
#===========================================

print_header "7. Setting Permissions"

sudo chown -R $USER:www-data /var/www/flowgram
sudo find $APP_DIR -type d -exec chmod 755 {} \;
sudo find $APP_DIR -type f -exec chmod 644 {} \;
sudo chmod -R 775 $APP_DIR/storage
sudo chmod -R 775 $APP_DIR/bootstrap/cache

cd $APP_DIR
mkdir -p storage/app/private/downloads
mkdir -p storage/framework/{cache/data,sessions,views}
mkdir -p storage/logs

print_success "Permissions set"

#===========================================
# 8. Configure Nginx
#===========================================

print_header "8. Configuring Nginx"

# Create htpasswd
echo "${HTPASSWD_PASS}" | sudo htpasswd -ci /etc/nginx/.htpasswd ${HTPASSWD_USER}

# Create Nginx config
sudo tee /etc/nginx/sites-available/flowgram > /dev/null <<EOF
server {
    listen 80;
    listen [::]:80;
    
    server_name ${SERVER_IP};
    root ${APP_DIR}/public;
    
    index index.php index.html;
    charset utf-8;
    
    auth_basic "Restricted Access";
    auth_basic_user_file /etc/nginx/.htpasswd;
    
    access_log /var/log/nginx/flowgram-access.log;
    error_log /var/log/nginx/flowgram-error.log;
    
    client_max_body_size 100M;
    
    gzip on;
    gzip_types text/plain text/css application/json application/javascript text/xml application/xml;
    
    location /html/ {
        alias /var/www/html/;
        index index.html;
        try_files \$uri \$uri/ =404;
    }
    
    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }
    
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
    
    error_page 404 /index.php;
    
    location ~ \.php\$ {
        fastcgi_pass unix:/var/run/php/php${PHP_VERSION}-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
    
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|woff|woff2)\$ {
        expires 30d;
        add_header Cache-Control "public, immutable";
    }
}
EOF

# Enable site
sudo ln -sf /etc/nginx/sites-available/flowgram /etc/nginx/sites-enabled/
sudo rm -f /etc/nginx/sites-enabled/default

# Create HTML folder
sudo mkdir -p /var/www/html
sudo chown -R $USER:www-data /var/www/html

# Test & reload
sudo nginx -t
sudo systemctl reload nginx

print_success "Nginx configured"

#===========================================
# 9. Optimize Laravel
#===========================================

print_header "9. Optimizing Laravel"

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

print_success "Laravel optimized"

#===========================================
# 10. Setup Firewall
#===========================================

print_header "10. Configuring Firewall"

sudo ufw --force enable
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp

print_success "Firewall configured"

#===========================================
# Summary
#===========================================

print_header "Deployment Complete!"

echo -e "  ${GREEN}Server:${NC}      ${SERVER_IP}"
echo -e "  ${GREEN}App URL:${NC}     http://${SERVER_IP}/"
echo -e "  ${GREEN}HTML URL:${NC}    http://${SERVER_IP}/html/"
echo ""
echo -e "  ${YELLOW}Basic Auth:${NC}"
echo -e "    Username:  ${HTPASSWD_USER}"
echo -e "    Password:  ${HTPASSWD_PASS}"
echo ""
echo -e "  ${YELLOW}App Accounts:${NC}"
echo -e "    Admin:     admin@admin.com / password"
echo -e "    User:      premium@demo.com / password"
echo ""


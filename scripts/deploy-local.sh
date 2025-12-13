#!/bin/bash

#===========================================
# FLOWGRAM Deploy from Local Machine
# Run this script from your local computer
#===========================================

set -e

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# Configuration
SERVER_IP="43.206.238.223"
SERVER_USER="deploy"
REMOTE_DIR="/var/www/flowgram"
APP_DIR="/var/www/flowgram/src"
BRANCH="project/flowgram-ld"

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
# Menu
#===========================================

echo ""
echo -e "${BLUE}FLOWGRAM Deployment${NC}"
echo ""
echo "  1) Full Deploy (git pull + all steps)"
echo "  2) Quick Deploy (git pull + cache only)"
echo "  3) Sync Local Files (rsync)"
echo "  4) Run Migrations Only"
echo "  5) Clear Cache Only"
echo "  6) View Logs"
echo "  7) SSH to Server"
echo "  0) Exit"
echo ""

read -p "Select option: " OPTION

case $OPTION in
    1)
        #===========================================
        # Full Deploy
        #===========================================
        print_header "Full Deploy"
        
        ssh ${SERVER_USER}@${SERVER_IP} << 'ENDSSH'
            cd /var/www/flowgram/src
            
            echo "→ Enabling maintenance mode..."
            php artisan down --retry=60 || true
            
            echo "→ Pulling latest code..."
            cd /var/www/flowgram
            git fetch origin
            git reset --hard origin/project/flowgram-ld
            cd /var/www/flowgram/src
            
            echo "→ Installing dependencies..."
            composer install --no-dev --optimize-autoloader --no-interaction
            
            echo "→ Running migrations..."
            php artisan migrate --force
            
            echo "→ Optimizing..."
            php artisan cache:clear
            php artisan config:cache
            php artisan route:cache
            php artisan view:cache
            php artisan optimize
            
            echo "→ Setting permissions..."
            sudo chown -R deploy:www-data /var/www/flowgram
            sudo chmod -R 775 storage bootstrap/cache
            
            echo "→ Restarting services..."
            sudo systemctl restart php8.3-fpm
            sudo systemctl reload nginx
            
            echo "→ Going live..."
            php artisan up
            
            echo ""
            echo "✓ Deploy complete!"
            echo "  Commit: $(git log -1 --format='%h - %s')"
ENDSSH
        
        print_success "Full deploy completed!"
        ;;
        
    2)
        #===========================================
        # Quick Deploy
        #===========================================
        print_header "Quick Deploy"
        
        ssh ${SERVER_USER}@${SERVER_IP} << 'ENDSSH'
            cd /var/www/flowgram
            
            echo "→ Pulling latest code..."
            git fetch origin
            git reset --hard origin/project/flowgram-ld
            
            cd /var/www/flowgram/src
            
            echo "→ Clearing cache..."
            php artisan cache:clear
            php artisan config:cache
            php artisan route:cache
            php artisan view:cache
            
            echo ""
            echo "✓ Quick deploy complete!"
ENDSSH
        
        print_success "Quick deploy completed!"
        ;;
        
    3)
        #===========================================
        # Sync Local Files
        #===========================================
        print_header "Sync Local Files"
        
        print_info "Syncing src/ folder to server..."
        
        # Get script directory
        SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
        PROJECT_DIR="$(dirname "$SCRIPT_DIR")"
        
        rsync -avz --progress \
            --exclude 'vendor' \
            --exclude 'node_modules' \
            --exclude '.env' \
            --exclude 'storage/logs/*' \
            --exclude 'storage/framework/cache/*' \
            --exclude 'storage/framework/sessions/*' \
            --exclude 'storage/framework/views/*' \
            --exclude '.git' \
            "${PROJECT_DIR}/src/" \
            ${SERVER_USER}@${SERVER_IP}:${APP_DIR}/
        
        print_info "Running post-sync commands..."
        
        ssh ${SERVER_USER}@${SERVER_IP} << 'ENDSSH'
            cd /var/www/flowgram/src
            
            composer install --no-dev --optimize-autoloader --no-interaction
            php artisan cache:clear
            php artisan config:cache
            php artisan route:cache
            php artisan view:cache
            
            sudo chown -R deploy:www-data /var/www/flowgram
            sudo chmod -R 775 storage bootstrap/cache
            
            echo "✓ Sync complete!"
ENDSSH
        
        print_success "Files synced!"
        ;;
        
    4)
        #===========================================
        # Run Migrations
        #===========================================
        print_header "Run Migrations"
        
        ssh ${SERVER_USER}@${SERVER_IP} << 'ENDSSH'
            cd /var/www/flowgram/src
            php artisan migrate --force
            echo "✓ Migrations complete!"
ENDSSH
        
        print_success "Migrations completed!"
        ;;
        
    5)
        #===========================================
        # Clear Cache
        #===========================================
        print_header "Clear Cache"
        
        ssh ${SERVER_USER}@${SERVER_IP} << 'ENDSSH'
            cd /var/www/flowgram/src
            php artisan cache:clear
            php artisan config:clear
            php artisan route:clear
            php artisan view:clear
            echo "✓ Cache cleared!"
ENDSSH
        
        print_success "Cache cleared!"
        ;;
        
    6)
        #===========================================
        # View Logs
        #===========================================
        print_header "View Logs"
        
        echo "  1) Laravel Log"
        echo "  2) Nginx Access Log"
        echo "  3) Nginx Error Log"
        echo ""
        read -p "Select log: " LOG_OPTION
        
        case $LOG_OPTION in
            1)
                ssh ${SERVER_USER}@${SERVER_IP} "tail -100 /var/www/flowgram/src/storage/logs/laravel.log"
                ;;
            2)
                ssh ${SERVER_USER}@${SERVER_IP} "sudo tail -100 /var/log/nginx/flowgram-access.log"
                ;;
            3)
                ssh ${SERVER_USER}@${SERVER_IP} "sudo tail -100 /var/log/nginx/flowgram-error.log"
                ;;
            *)
                echo "Invalid option"
                ;;
        esac
        ;;
        
    7)
        #===========================================
        # SSH to Server
        #===========================================
        print_header "Connecting to Server"
        
        ssh ${SERVER_USER}@${SERVER_IP}
        ;;
        
    0)
        echo "Goodbye!"
        exit 0
        ;;
        
    *)
        echo -e "${RED}Invalid option${NC}"
        exit 1
        ;;
esac

echo ""


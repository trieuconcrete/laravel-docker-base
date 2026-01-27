#!/bin/bash

###############################################################################
# Xế Hộ 24/7 - Đà Nẵng Deployment Script
# Domain: xeho247.vn
# Server: 103.82.132.130
# Project: Laravel-based Driver Booking Service
# Author: Nguyen Trieu
# Date: 2026-01-27
###############################################################################

set -uo pipefail  # Unset vars and pipeline issues (removed -e for better error control)

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
CYAN='\033[0;36m'
MAGENTA='\033[0;35m'
NC='\033[0m' # No Color

# Configuration
SSH_HOST="cloudfly-hpl"
SSH_PASSWORD="36z0zCaWXsk2wGdS"
SERVER_PATH="/var/www/webroot/xeho247danang/src"
REPO_URL="git@github.com:trieuconcrete/laravel-docker-base.git"
REPO_BRANCH="project/xeho247danang"
PHP_VERSION="8.4"
DEPLOY_TIMEOUT=300  # 5 minutes timeout
BACKUP_DIR="/var/www/backups/xeho247danang"

# SSH function wrapper with auto password
ssh_exec() {
    sshpass -p "${SSH_PASSWORD}" ssh -o ConnectTimeout=10 -o StrictHostKeyChecking=no -o PreferredAuthentications=password -o PubkeyAuthentication=no "${SSH_HOST}" "$@"
}

# Functions

print_header() {
    echo -e "${BLUE}================================================${NC}"
    echo -e "${BLUE}$1${NC}"
    echo -e "${BLUE}================================================${NC}"
}

print_success() {
    echo -e "${GREEN}✅ $1${NC}"
}

print_error() {
    echo -e "${RED}❌ $1${NC}"
}

print_info() {
    echo -e "${YELLOW}ℹ️  $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

log_deployment() {
    local message="$1"
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $message" >> deploy.log
}

# Check if SSH connection works
check_ssh() {
    print_info "Checking SSH connection to $SSH_HOST..."
    
    # Check if sshpass is installed
    if ! command -v sshpass &> /dev/null; then
        print_error "sshpass is not installed. Installing..."
        if [[ "$OSTYPE" == "darwin"* ]]; then
            # macOS
            if command -v brew &> /dev/null; then
                brew install hudochenkov/sshpass/sshpass
            else
                print_error "Homebrew not found. Please install sshpass manually: brew install hudochenkov/sshpass/sshpass"
                return 1
            fi
        else
            # Linux
            sudo apt-get install -y sshpass || sudo yum install -y sshpass
        fi
    fi
    
    if ssh_exec "echo 'SSH OK'" 2>/dev/null; then
        print_success "SSH connection OK"
        return 0
    else
        print_error "SSH connection failed. Please check your credentials."
        return 1
    fi
}

# Show deployment menu
show_menu() {
    clear
    echo ""
    echo -e "${MAGENTA}╔══════════════════════════════════════════════════════════════╗${NC}"
    echo -e "${MAGENTA}║          🚗 XẾ HỘ 24/7 - DEPLOYMENT OPTIONS                 ║${NC}"
    echo -e "${MAGENTA}╠══════════════════════════════════════════════════════════════╣${NC}"
    echo -e "${MAGENTA}║                                                              ║${NC}"
    echo -e "${MAGENTA}║${NC}  ${CYAN}1)${NC} 🚀 Full Deploy            ${YELLOW}(Git + Composer + Cache)${NC}  ${MAGENTA}║${NC}"
    echo -e "${MAGENTA}║${NC}  ${CYAN}2)${NC} 📦 Install Dependencies   ${YELLOW}(Composer Install)${NC}        ${MAGENTA}║${NC}"
    echo -e "${MAGENTA}║${NC}  ${CYAN}3)${NC} 🗄️  Run Migrations         ${YELLOW}(Database Migration)${NC}     ${MAGENTA}║${NC}"
    echo -e "${MAGENTA}║${NC}  ${CYAN}4)${NC} 🧹 Clear Cache            ${YELLOW}(Laravel Cache Clear)${NC}    ${MAGENTA}║${NC}"
    echo -e "${MAGENTA}║${NC}  ${CYAN}5)${NC} 🔄 Restart Services       ${YELLOW}(PHP-FPM + Nginx)${NC}        ${MAGENTA}║${NC}"
    echo -e "${MAGENTA}║${NC}  ${CYAN}6)${NC} 📊 Check Status           ${YELLOW}(Server Health)${NC}          ${MAGENTA}║${NC}"
    echo -e "${MAGENTA}║${NC}  ${CYAN}7)${NC} 📝 View Logs              ${YELLOW}(Laravel Logs)${NC}           ${MAGENTA}║${NC}"
    echo -e "${MAGENTA}║${NC}  ${CYAN}8)${NC} 💾 Backup Database        ${YELLOW}(MySQL Dump)${NC}             ${MAGENTA}║${NC}"
    echo -e "${MAGENTA}║${NC}  ${CYAN}9)${NC} ⏪ Rollback Deploy       ${YELLOW}(Git Reset)${NC}              ${MAGENTA}║${NC}"
    echo -e "${MAGENTA}║                                                              ║${NC}"
    echo -e "${MAGENTA}║${NC}  ${RED}0)${NC} ❌ Exit                                                  ${MAGENTA}║${NC}"
    echo -e "${MAGENTA}║                                                              ║${NC}"
    echo -e "${MAGENTA}╚══════════════════════════════════════════════════════════════╝${NC}"
    echo ""
    echo -e "${YELLOW}Server: ${CYAN}$SSH_HOST${NC}"
    echo -e "${YELLOW}Path: ${CYAN}$SERVER_PATH${NC}"
    echo -e "${YELLOW}Branch: ${CYAN}$REPO_BRANCH${NC}"
    echo -e "${YELLOW}PHP: ${CYAN}$PHP_VERSION${NC}"
    echo ""
    echo -n "Select option [0-9]: "
}

# Full deployment
deploy_full() {
    print_header "🚀 FULL DEPLOYMENT - XẾ HỘ 24/7"
    log_deployment "Starting full deployment"
    
    local start_time=$(date +%s)
    
    # Enable maintenance mode
    print_info "Step 1/7: Enabling maintenance mode..."
    ssh_exec "cd $SERVER_PATH && php artisan down --retry=60" || print_warning "Maintenance mode failed (continuing...)"
    
    print_info "Step 2/7: Pulling latest code from Git..."
    if ! ssh_exec "cd /var/www/webroot/xeho247danang && git pull origin $REPO_BRANCH"; then
        print_error "Git pull failed!"
        ssh_exec "cd $SERVER_PATH && php artisan up"
        return 1
    fi
    print_success "Code updated"
    
    print_info "Step 3/7: Installing Composer dependencies..."
    ssh_exec "cd $SERVER_PATH && composer install --no-dev --optimize-autoloader --no-interaction"
    print_success "Dependencies installed"
    
    print_info "Step 4/7: Running database migrations..."
    ssh_exec "cd $SERVER_PATH && php artisan migrate --force"
    print_success "Migrations completed"
    
    print_info "Step 5/7: Clearing & caching (optimized)..."
    ssh_exec "cd $SERVER_PATH && php artisan optimize:clear && php artisan optimize"
    print_success "Cache optimized"
    
    print_info "Step 6/7: Setting permissions..."
    ssh_exec "cd $SERVER_PATH && chown -R www-data:www-data storage bootstrap/cache && chmod -R 775 storage bootstrap/cache"
    print_success "Permissions set"
    
    print_info "Step 7/7: Restarting services..."
    ssh_exec "systemctl restart php${PHP_VERSION}-fpm && systemctl restart nginx"
    print_success "Services restarted"
    
    local end_time=$(date +%s)
    local duration=$((end_time - start_time))
    
    print_success "🎉 Deployment completed in ${duration}s!"
    log_deployment "Deployment completed successfully in ${duration}s"
    echo ""
    
    # Ask to disable maintenance mode
    echo ""
    print_warning "Website is currently in MAINTENANCE MODE"
    echo -n "Do you want to disable maintenance mode and make site live? (yes/no): "
    read enable_site
    
    if [[ "$enable_site" == "yes" || "$enable_site" == "y" ]]; then
        print_info "Disabling maintenance mode..."
        ssh_exec "cd $SERVER_PATH && php artisan up"
        print_success "Site is now LIVE! ✨"
        echo ""
        echo -e "${GREEN}Website: ${CYAN}https://xeho247.vn${NC}"
    else
        print_info "Site remains in maintenance mode"
        echo -e "${YELLOW}To enable later, run: ${CYAN}php artisan up${NC}"
    fi
}

# Install dependencies only
install_dependencies() {
    print_header "📦 INSTALLING DEPENDENCIES"
    
    print_info "Installing Composer packages..."
    ssh_exec "cd $SERVER_PATH && composer install --no-dev --optimize-autoloader"
    print_success "Dependencies installed"
}

# Run migrations
run_migrations() {
    print_header "🗄️  RUNNING DATABASE MIGRATIONS"
    
    print_info "Running migrations..."
    ssh_exec "cd $SERVER_PATH && php artisan migrate --force"
    print_success "Migrations completed"
}

# Clear cache
clear_cache() {
    print_header "🧹 CLEARING CACHE"
    
    print_info "Clearing all caches..."
    ssh_exec "cd $SERVER_PATH && php artisan cache:clear && php artisan config:clear && php artisan route:clear && php artisan view:clear"
    print_success "All caches cleared"
}

# Restart services
restart_services() {
    print_header "🔄 RESTARTING SERVICES"
    
    print_info "Restarting PHP-FPM..."
    ssh_exec "systemctl restart php${PHP_VERSION}-fpm"
    print_success "PHP-FPM restarted"
    
    print_info "Restarting Nginx..."
    ssh_exec "systemctl restart nginx"
    print_success "Nginx restarted"
}

# Check server status
check_status() {
    print_header "📊 SERVER STATUS CHECK"
    
    echo -e "${CYAN}=== PHP-FPM Status ===${NC}"
    ssh_exec "systemctl status php${PHP_VERSION}-fpm --no-pager | head -10"
    echo ""
    
    echo -e "${CYAN}=== Nginx Status ===${NC}"
    ssh_exec "systemctl status nginx --no-pager | head -10"
    echo ""
    
    echo -e "${CYAN}=== Disk Usage ===${NC}"
    ssh_exec "df -h | grep -E '(Filesystem|/dev/)'"
    echo ""
    
    echo -e "${CYAN}=== Memory Usage ===${NC}"
    ssh_exec "free -h"
    echo ""
}

# View Laravel logs
view_logs() {
    print_header "📝 VIEWING LARAVEL LOGS"
    
    print_info "Last 50 lines of Laravel log..."
    ssh_exec "tail -50 $SERVER_PATH/storage/logs/laravel.log"
}

# Backup database
backup_database() {
    print_header "💾 BACKING UP DATABASE"
    
    local backup_file="xeho247_$(date +%Y%m%d_%H%M%S).sql"
    
    print_info "Creating database backup: $backup_file"
    ssh_exec "cd $SERVER_PATH && php artisan db:backup --filename=$backup_file" || \
    ssh_exec "mkdir -p $BACKUP_DIR && mysqldump -u\$(grep DB_USERNAME .env | cut -d '=' -f2) -p\$(grep DB_PASSWORD .env | cut -d '=' -f2) \$(grep DB_DATABASE .env | cut -d '=' -f2) > $BACKUP_DIR/$backup_file"
    
    print_success "Database backed up to: $BACKUP_DIR/$backup_file"
}

# Rollback deployment
rollback_deploy() {
    print_header "⏪ ROLLBACK DEPLOYMENT"
    
    print_warning "This will reset to the previous commit!"
    echo -n "Are you sure? (yes/no): "
    read confirm
    
    if [[ "$confirm" != "yes" ]]; then
        print_info "Rollback cancelled"
        return 0
    fi
    
    print_info "Rolling back to previous commit..."
    ssh_exec "cd /var/www/webroot/xeho247danang && git reset --hard HEAD~1"
    
    print_info "Updating dependencies..."
    ssh_exec "cd $SERVER_PATH && composer install --no-dev --optimize-autoloader"
    
    print_info "Clearing cache..."
    ssh_exec "cd $SERVER_PATH && php artisan optimize:clear"
    
    print_info "Restarting services..."
    ssh_exec "systemctl restart php${PHP_VERSION}-fpm && systemctl restart nginx"
    
    print_success "Rollback completed!"
}

# Main execution
main() {
    # Check SSH connection first
    if ! check_ssh; then
        exit 1
    fi
    
    while true; do
        show_menu
        read choice
        
        case $choice in
            1)
                deploy_full
                ;;
            2)
                install_dependencies
                ;;
            3)
                run_migrations
                ;;
            4)
                clear_cache
                ;;
            5)
                restart_services
                ;;
            6)
                check_status
                ;;
            7)
                view_logs
                ;;
            8)
                backup_database
                ;;
            9)
                rollback_deploy
                ;;
            0)
                print_info "Exiting deployment script. Goodbye!"
                exit 0
                ;;
            *)
                print_error "Invalid option. Please select 0-9."
                ;;
        esac
        
        if [ $? -eq 0 ]; then
            echo ""
            echo -e "${GREEN}✨ Operation completed successfully!${NC}"
            echo ""
            echo -e "${YELLOW}Options:${NC}"
            echo -e "  ${CYAN}[Enter]${NC} - Return to menu"
            echo -e "  ${CYAN}[q]${NC} - Quit"
            echo ""
            echo -n "Your choice: "
            read continue_choice
            
            if [[ "$continue_choice" == "q" || "$continue_choice" == "Q" ]]; then
                print_info "Exiting deployment script. Goodbye!"
                exit 0
            fi
        else
            echo ""
            echo -e "${RED}⚠️  Operation completed with errors${NC}"
            echo ""
            echo -e "${YELLOW}Press Enter to return to menu...${NC}"
            read
        fi
    done
}

# Run main function
main

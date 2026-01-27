#!/bin/bash

###############################################################################
# Xế Hộ 24/7 - Đà Nẵng Deployment Script
# Domain: xeho247.vn
# Server: 103.82.132.130
# Project: Laravel-based Driver Booking Service
# Author: Nguyen Trieu
# Date: 2026-01-27
###############################################################################

set -euo pipefail  # Fail fast on errors, unset vars, or pipeline issues

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
# pass: 36z0zCaWXsk2wGdS
SERVER_PATH="/var/www/webroot/xeho247danang/src"
REPO_URL="git@github.com:trieuconcrete/laravel-docker-base.git"  # Update with actual repo URL
REPO_BRANCH="project/xeho247danang"
PHP_VERSION="8.2"

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

trap 'print_error "Deployment failed at line $LINENO"' ERR

# Check if SSH connection works
check_ssh() {
    print_info "Checking SSH connection to $SSH_HOST..."
    if ssh -o ConnectTimeout=10 ${SSH_HOST} "echo 'SSH OK'" 2>/dev/null; then
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
    echo -e "${MAGENTA}║${NC}  ${CYAN}1)${NC} 🚀 Full Deploy            ${YELLOW}(Git Pull + Dependencies)${NC}  ${MAGENTA}║${NC}"
    echo -e "${MAGENTA}║${NC}  ${CYAN}2)${NC} 📦 Install Dependencies   ${YELLOW}(Composer Install)${NC}        ${MAGENTA}║${NC}"
    echo -e "${MAGENTA}║${NC}  ${CYAN}3)${NC} 🗄️  Run Migrations         ${YELLOW}(Database Migration)${NC}     ${MAGENTA}║${NC}"
    echo -e "${MAGENTA}║${NC}  ${CYAN}4)${NC} 🧹 Clear Cache            ${YELLOW}(Laravel Cache Clear)${NC}    ${MAGENTA}║${NC}"
    echo -e "${MAGENTA}║${NC}  ${CYAN}5)${NC} 🔄 Restart Services       ${YELLOW}(PHP-FPM + Nginx)${NC}        ${MAGENTA}║${NC}"
    echo -e "${MAGENTA}║${NC}  ${CYAN}6)${NC} 📊 Check Status           ${YELLOW}(Server Health)${NC}          ${MAGENTA}║${NC}"
    echo -e "${MAGENTA}║${NC}  ${CYAN}7)${NC} 📝 View Logs              ${YELLOW}(Laravel Logs)${NC}           ${MAGENTA}║${NC}"
    echo -e "${MAGENTA}║                                                              ║${NC}"
    echo -e "${MAGENTA}║${NC}  ${RED}0)${NC} ❌ Exit                                                  ${MAGENTA}║${NC}"
    echo -e "${MAGENTA}║                                                              ║${NC}"
    echo -e "${MAGENTA}╚══════════════════════════════════════════════════════════════╝${NC}"
    echo ""
    echo -e "${YELLOW}Server: ${CYAN}$SSH_HOST${NC}"
    echo -e "${YELLOW}Path: ${CYAN}$SERVER_PATH${NC}"
    echo -e "${YELLOW}Branch: ${CYAN}$REPO_BRANCH${NC}"
    echo ""
    echo -n "Select option [0-7]: "
}

# Full deployment
deploy_full() {
    print_header "🚀 FULL DEPLOYMENT - XẾ HỘ 24/7"
    
    print_info "Step 1/7: Pulling latest code from Git..."
    ssh ${SSH_HOST} "cd /var/www/webroot/xeho247danang && git pull origin $REPO_BRANCH"
    print_success "Code updated"
    
    print_info "Step 2/7: Installing Composer dependencies..."
    ssh ${SSH_HOST} "cd $SERVER_PATH && composer install --no-dev --optimize-autoloader"
    print_success "Dependencies installed"
    
    print_info "Step 3/7: Running database migrations..."
    ssh ${SSH_HOST} "cd $SERVER_PATH && php artisan migrate --force"
    print_success "Migrations completed"
    
    print_info "Step 4/7: Clearing application cache..."
    ssh ${SSH_HOST} "cd $SERVER_PATH && php artisan cache:clear && php artisan config:clear && php artisan route:clear && php artisan view:clear"
    print_success "Cache cleared"
    
    print_info "Step 5/7: Optimizing application..."
    ssh ${SSH_HOST} "cd $SERVER_PATH && php artisan config:cache && php artisan route:cache && php artisan view:cache"
    print_success "Application optimized"
    
    print_info "Step 6/7: Setting permissions..."
    ssh ${SSH_HOST} "cd $SERVER_PATH && chown -R www-data:www-data storage bootstrap/cache && chmod -R 775 storage bootstrap/cache"
    print_success "Permissions set"
    
    print_info "Step 7/7: Restarting services..."
    ssh ${SSH_HOST} "systemctl restart php${PHP_VERSION}-fpm && systemctl restart nginx"
    print_success "Services restarted"
    
    print_success "🎉 Deployment completed successfully!"
    echo ""
    echo -e "${GREEN}Website: ${CYAN}https://xeho247.vn${NC}"
}

# Install dependencies only
install_dependencies() {
    print_header "📦 INSTALLING DEPENDENCIES"
    
    print_info "Installing Composer packages..."
    ssh ${SSH_HOST} "cd $SERVER_PATH && composer install --no-dev --optimize-autoloader"
    print_success "Dependencies installed"
}

# Run migrations
run_migrations() {
    print_header "🗄️  RUNNING DATABASE MIGRATIONS"
    
    print_info "Running migrations..."
    ssh ${SSH_HOST} "cd $SERVER_PATH && php artisan migrate --force"
    print_success "Migrations completed"
}

# Clear cache
clear_cache() {
    print_header "🧹 CLEARING CACHE"
    
    print_info "Clearing all caches..."
    ssh ${SSH_HOST} "cd $SERVER_PATH && php artisan cache:clear && php artisan config:clear && php artisan route:clear && php artisan view:clear"
    print_success "All caches cleared"
}

# Restart services
restart_services() {
    print_header "🔄 RESTARTING SERVICES"
    
    print_info "Restarting PHP-FPM..."
    ssh ${SSH_HOST} "systemctl restart php${PHP_VERSION}-fpm"
    print_success "PHP-FPM restarted"
    
    print_info "Restarting Nginx..."
    ssh ${SSH_HOST} "systemctl restart nginx"
    print_success "Nginx restarted"
}

# Check server status
check_status() {
    print_header "📊 SERVER STATUS CHECK"
    
    echo -e "${CYAN}=== PHP-FPM Status ===${NC}"
    ssh ${SSH_HOST} "systemctl status php${PHP_VERSION}-fpm --no-pager | head -10"
    echo ""
    
    echo -e "${CYAN}=== Nginx Status ===${NC}"
    ssh ${SSH_HOST} "systemctl status nginx --no-pager | head -10"
    echo ""
    
    echo -e "${CYAN}=== Disk Usage ===${NC}"
    ssh ${SSH_HOST} "df -h | grep -E '(Filesystem|/dev/)'"
    echo ""
    
    echo -e "${CYAN}=== Memory Usage ===${NC}"
    ssh ${SSH_HOST} "free -h"
    echo ""
}

# View Laravel logs
view_logs() {
    print_header "📝 VIEWING LARAVEL LOGS"
    
    print_info "Last 50 lines of Laravel log..."
    ssh ${SSH_HOST} "tail -50 $SERVER_PATH/storage/logs/laravel.log"
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
            0)
                print_info "Exiting deployment script. Goodbye!"
                exit 0
                ;;
            *)
                print_error "Invalid option. Please select 0-7."
                ;;
        esac
        
        echo ""
        echo -e "${YELLOW}Press Enter to continue...${NC}"
        read
    done
}

# Run main function
main

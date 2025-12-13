#!/bin/bash

#===========================================
# FLOWGRAM Deployment Script
# Ubuntu 24.04 + Nginx + PHP 8.3 + MySQL
#===========================================

set -e  # Exit on error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
APP_DIR="/var/www/flowgram/src"
BRANCH="project/flowgram-ld"
PHP_VERSION="8.3"

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

print_warning() {
    echo -e "${YELLOW}⚠ $1${NC}"
}

print_error() {
    echo -e "${RED}✗ $1${NC}"
}

print_info() {
    echo -e "${BLUE}→ $1${NC}"
}

#===========================================
# Pre-deployment checks
#===========================================

print_header "Pre-deployment Checks"

# Check if running as deploy user
if [ "$(whoami)" != "deploy" ]; then
    print_warning "Not running as 'deploy' user. Current user: $(whoami)"
fi

# Check if directory exists
if [ ! -d "$APP_DIR" ]; then
    print_error "Directory $APP_DIR does not exist!"
    exit 1
fi

print_success "All checks passed"

#===========================================
# Enable Maintenance Mode
#===========================================

print_header "Enabling Maintenance Mode"

cd $APP_DIR

if [ -f "artisan" ]; then
    php artisan down --retry=60 --refresh=5 || true
    print_success "Maintenance mode enabled"
else
    print_warning "artisan file not found, skipping maintenance mode"
fi

#===========================================
# Pull Latest Code
#===========================================

print_header "Pulling Latest Code"

print_info "Fetching from origin..."
git fetch origin

print_info "Resetting to origin/$BRANCH..."
git reset --hard origin/$BRANCH

print_info "Current commit:"
git log -1 --oneline

print_success "Code updated"

#===========================================
# Install Dependencies
#===========================================

print_header "Installing Dependencies"

print_info "Running composer install..."
composer install --no-dev --optimize-autoloader --no-interaction

print_success "Dependencies installed"

#===========================================
# Run Migrations
#===========================================

print_header "Running Migrations"

php artisan migrate --force

print_success "Migrations completed"

#===========================================
# Clear & Rebuild Cache
#===========================================

print_header "Optimizing Application"

print_info "Clearing cache..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

print_info "Rebuilding cache..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

print_success "Application optimized"

#===========================================
# Set Permissions
#===========================================

print_header "Setting Permissions"

sudo chown -R deploy:www-data $APP_DIR
sudo chmod -R 755 $APP_DIR
sudo chmod -R 775 $APP_DIR/storage
sudo chmod -R 775 $APP_DIR/bootstrap/cache

print_success "Permissions set"

#===========================================
# Restart Services
#===========================================

print_header "Restarting Services"

print_info "Restarting PHP-FPM..."
sudo systemctl restart php${PHP_VERSION}-fpm

print_info "Reloading Nginx..."
sudo systemctl reload nginx

print_success "Services restarted"

#===========================================
# Disable Maintenance Mode
#===========================================

print_header "Disabling Maintenance Mode"

php artisan up

print_success "Application is live!"

#===========================================
# Deployment Summary
#===========================================

print_header "Deployment Complete!"

echo -e "  ${GREEN}Branch:${NC}    $BRANCH"
echo -e "  ${GREEN}Commit:${NC}    $(git log -1 --format='%h - %s')"
echo -e "  ${GREEN}Time:${NC}      $(date '+%Y-%m-%d %H:%M:%S')"
echo ""
echo -e "  ${BLUE}URL:${NC}       http://43.206.238.223/"
echo ""


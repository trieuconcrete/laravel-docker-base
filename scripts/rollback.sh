#!/bin/bash

#===========================================
# FLOWGRAM Rollback Script
#===========================================

set -e

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

APP_DIR="/var/www/flowgram/src"
PHP_VERSION="8.3"

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
# Show available commits
#===========================================

print_header "Available Commits to Rollback"

cd $APP_DIR

echo "Recent commits:"
echo ""
git log --oneline -10
echo ""

read -p "Enter commit hash to rollback to: " COMMIT_HASH

if [ -z "$COMMIT_HASH" ]; then
    echo -e "${RED}No commit hash provided. Aborting.${NC}"
    exit 1
fi

#===========================================
# Confirm rollback
#===========================================

echo ""
echo -e "${YELLOW}You are about to rollback to:${NC}"
git log -1 --format="  %h - %s (%cr)" $COMMIT_HASH
echo ""

read -p "Are you sure? (y/N): " CONFIRM

if [ "$CONFIRM" != "y" ] && [ "$CONFIRM" != "Y" ]; then
    echo "Rollback cancelled."
    exit 0
fi

#===========================================
# Enable Maintenance Mode
#===========================================

print_header "Enabling Maintenance Mode"

php artisan down --retry=60 || true
print_success "Maintenance mode enabled"

#===========================================
# Rollback
#===========================================

print_header "Rolling Back"

print_info "Checking out commit $COMMIT_HASH..."
git checkout $COMMIT_HASH

print_info "Installing dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

print_info "Running migrations..."
php artisan migrate --force

#===========================================
# Optimize
#===========================================

print_header "Optimizing"

php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

#===========================================
# Restart Services
#===========================================

print_header "Restarting Services"

sudo systemctl restart php${PHP_VERSION}-fpm
sudo systemctl reload nginx

#===========================================
# Disable Maintenance Mode
#===========================================

print_header "Going Live"

php artisan up
print_success "Rollback complete!"

echo ""
echo -e "  ${GREEN}Rolled back to:${NC} $(git log -1 --format='%h - %s')"
echo ""


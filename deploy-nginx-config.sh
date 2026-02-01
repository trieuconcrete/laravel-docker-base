#!/bin/bash

###############################################################################
# Deploy Nginx Security Configuration for XeHo247.vn
# Author: Nguyen Trieu
# Date: 2026-01-31
###############################################################################

set -e

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# Configuration
SSH_HOST="cloudfly-hpl"
SSH_PASSWORD="36z0zCaWXsk2wGdS"
CONFIG_FILE="nginx-secure.config"
REMOTE_CONFIG="/etc/nginx/sites-available/xeho247.config"
REMOTE_BACKUP="/etc/nginx/sites-available/xeho247.config.backup.$(date +%Y%m%d_%H%M%S)"

# SSH wrapper
ssh_exec() {
    sshpass -p "${SSH_PASSWORD}" ssh -o ConnectTimeout=10 -o StrictHostKeyChecking=no -o PreferredAuthentications=password -o PubkeyAuthentication=no "${SSH_HOST}" "$@"
}

echo -e "${BLUE}╔══════════════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║  🔒 Deploy Nginx Security Configuration         ║${NC}"
echo -e "${BLUE}╠══════════════════════════════════════════════════╣${NC}"
echo -e "${BLUE}║  Domain: xeho247.vn                              ║${NC}"
echo -e "${BLUE}║  Server: $SSH_HOST                               ║${NC}"
echo -e "${BLUE}╚══════════════════════════════════════════════════╝${NC}"
echo ""

# Step 1: Check local config file
echo -e "${YELLOW}[1/7]${NC} Checking local config file..."
if [ ! -f "$CONFIG_FILE" ]; then
    echo -e "${RED}❌ Error: $CONFIG_FILE not found!${NC}"
    exit 1
fi
echo -e "${GREEN}✅ Local config file found${NC}"
echo ""

# Step 2: Backup current config
echo -e "${YELLOW}[2/7]${NC} Backing up current nginx config..."
ssh_exec "sudo cp $REMOTE_CONFIG $REMOTE_BACKUP"
echo -e "${GREEN}✅ Backup created: $REMOTE_BACKUP${NC}"
echo ""

# Step 3: Upload new config
echo -e "${YELLOW}[3/7]${NC} Uploading new config to server..."
sshpass -p "${SSH_PASSWORD}" scp -o StrictHostKeyChecking=no -o PreferredAuthentications=password -o PubkeyAuthentication=no "$CONFIG_FILE" "${SSH_HOST}:/tmp/xeho247.config.new"
echo -e "${GREEN}✅ Config uploaded to /tmp/xeho247.config.new${NC}"
echo ""

# Step 4: Move config to nginx directory
echo -e "${YELLOW}[4/7]${NC} Installing new config..."
ssh_exec "sudo mv /tmp/xeho247.config.new $REMOTE_CONFIG"
echo -e "${GREEN}✅ Config installed${NC}"
echo ""

# Step 5: Test nginx configuration
echo -e "${YELLOW}[5/7]${NC} Testing nginx configuration..."
TEST_OUTPUT=$(ssh_exec "nginx -t 2>&1")
echo "$TEST_OUTPUT"

if echo "$TEST_OUTPUT" | grep -q "test is successful"; then
    echo -e "${GREEN}✅ Nginx config test passed${NC}"
else
    echo -e "${RED}❌ Nginx config test failed!${NC}"
    echo -e "${YELLOW}Rolling back to previous config...${NC}"
    ssh_exec "sudo cp $REMOTE_BACKUP $REMOTE_CONFIG"
    echo -e "${YELLOW}Backup restored. Please check the config file.${NC}"
    exit 1
fi
echo ""

# Step 6: Reload nginx
echo -e "${YELLOW}[6/7]${NC} Reloading nginx..."
ssh_exec "sudo systemctl reload nginx"
echo -e "${GREEN}✅ Nginx reloaded successfully${NC}"
echo ""

# Step 7: Verify security headers
echo -e "${YELLOW}[7/7]${NC} Verifying security headers..."
echo ""
echo -e "${BLUE}Checking headers:${NC}"

# Check HSTS
if ssh_exec "curl -sI https://xeho247.vn" | grep -q "Strict-Transport-Security"; then
    echo -e "${GREEN}✓${NC} HSTS: Enabled"
else
    echo -e "${RED}✗${NC} HSTS: Missing"
fi

# Check X-Frame-Options
if ssh_exec "curl -sI https://xeho247.vn" | grep -q "X-Frame-Options"; then
    echo -e "${GREEN}✓${NC} X-Frame-Options: Enabled"
else
    echo -e "${RED}✗${NC} X-Frame-Options: Missing"
fi

# Check X-Content-Type-Options
if ssh_exec "curl -sI https://xeho247.vn" | grep -q "X-Content-Type-Options"; then
    echo -e "${GREEN}✓${NC} X-Content-Type-Options: Enabled"
else
    echo -e "${RED}✗${NC} X-Content-Type-Options: Missing"
fi

# Check CSP
if ssh_exec "curl -sI https://xeho247.vn" | grep -q "Content-Security-Policy"; then
    echo -e "${GREEN}✓${NC} Content-Security-Policy: Enabled"
else
    echo -e "${RED}✗${NC} Content-Security-Policy: Missing"
fi

echo ""
echo -e "${GREEN}╔══════════════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║  ✅ DEPLOYMENT COMPLETED SUCCESSFULLY!          ║${NC}"
echo -e "${GREEN}╠══════════════════════════════════════════════════╣${NC}"
echo -e "${GREEN}║  Website: https://xeho247.vn                     ║${NC}"
echo -e "${GREEN}║  Backup: $REMOTE_BACKUP${NC}"
echo -e "${GREEN}╚══════════════════════════════════════════════════╝${NC}"
echo ""

# Test online
echo -e "${YELLOW}📊 Test your security online:${NC}"
echo -e "  • https://securityheaders.com/?q=https://xeho247.vn"
echo -e "  • https://www.ssllabs.com/ssltest/analyze.html?d=xeho247.vn"
echo -e "  • https://observatory.mozilla.org/analyze/xeho247.vn"
echo ""

echo -e "${YELLOW}To rollback if needed:${NC}"
echo -e "  ssh $SSH_HOST"
echo -e "  sudo cp $REMOTE_BACKUP $REMOTE_CONFIG"
echo -e "  sudo systemctl reload nginx"
echo ""

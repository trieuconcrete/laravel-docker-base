# 🔒 Security Audit Report - XeHo247.vn

**Date:** 2026-01-31  
**Website:** https://xeho247.vn  
**Framework:** Laravel 12.47.0  
**Server:** Nginx 1.18.0 / PHP 8.4  

---

## 📊 Executive Summary

| Category | Status | Risk Level | Priority |
|----------|--------|------------|----------|
| SSL/HTTPS | ✅ PASS | Low | - |
| Sensitive Files | ✅ PASS | Low | - |
| Debug Mode | ⚠️ WARNING | **HIGH** | **P1** |
| Security Headers | ❌ FAIL | **HIGH** | **P1** |
| Rate Limiting | ❌ FAIL | Medium | P2 |
| SQL Injection | ✅ PASS | Low | - |
| CSRF Protection | ✅ PASS | Low | - |
| File Permissions | ⚠️ WARNING | Medium | P2 |

**Overall Security Score: 6/10** ⚠️

---

## ✅ PASSED CHECKS

### 1. SSL Certificate
```
✅ Valid SSL Certificate
- Issuer: Let's Encrypt
- Valid from: Jan 27, 2026
- Valid until: Apr 27, 2026
- Protocol: TLS 1.2/1.3
- Expires in: 86 days
```

**Recommendation:** Setup auto-renewal với certbot
```bash
# Check certbot timer
systemctl status certbot.timer

# Manual renewal test
certbot renew --dry-run
```

### 2. Sensitive Files Protection
```
✅ .env file: 404 (Not accessible)
✅ .git folder: 404 (Not accessible)
✅ composer.json: Protected
✅ phpinfo: Not exposed
```

### 3. Laravel Security Features
```
✅ CSRF Protection: Enabled (@csrf tokens present)
✅ SQL Injection: Using Eloquent ORM (safe)
✅ XSS Protection: Blade escaping {{ }} enabled
✅ Mass Assignment: $fillable defined in models
```

### 4. Session Security
```
✅ Session driver: file (secure for single server)
✅ Session encryption: Available
✅ Cookie security: httpOnly enabled
```

---

## ❌ CRITICAL ISSUES

### 🚨 1. DEBUG MODE ENABLED IN PRODUCTION

**Risk Level:** **CRITICAL**  
**Current Status:** `APP_DEBUG=true`

**Impact:**
- Exposes stack traces with file paths
- Reveals database queries
- Shows environment variables
- Leaks sensitive information to attackers

**Proof:**
```bash
# Current .env
APP_ENV=production
APP_DEBUG=true  ⚠️ DANGER!
```

**Fix Required:**
```bash
# Update production .env
APP_DEBUG=false
APP_ENV=production

# Clear config cache
php artisan config:clear
php artisan config:cache
```

**To Fix Now:**
1. SSH vào server
2. Edit `/var/www/webroot/xeho247danang/src/.env`
3. Change `APP_DEBUG=true` → `APP_DEBUG=false`
4. Run: `php artisan config:cache`
5. Restart: `systemctl restart php8.4-fpm`

---

### 🚨 2. MISSING SECURITY HEADERS

**Risk Level:** **HIGH**

**Current Headers:**
```http
HTTP/2 200
server: nginx/1.18.0 (Ubuntu)  ⚠️ Version exposed
content-type: text/html; charset=utf-8
```

**Missing Critical Headers:**
```
❌ X-Frame-Options (Clickjacking protection)
❌ X-Content-Type-Options (MIME sniffing protection)
❌ X-XSS-Protection (XSS filter)
❌ Strict-Transport-Security (HSTS)
❌ Content-Security-Policy (CSP)
❌ Referrer-Policy
❌ Permissions-Policy
```

**Fix: Update Nginx Config**

Add to `/etc/nginx/sites-available/xeho247.vn`:

```nginx
server {
    listen 443 ssl http2;
    server_name xeho247.vn www.xeho247.vn;
    
    # Hide nginx version
    server_tokens off;
    
    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;
    
    # HSTS (6 months)
    add_header Strict-Transport-Security "max-age=15552000; includeSubDomains; preload" always;
    
    # Content Security Policy (adjust as needed)
    add_header Content-Security-Policy "default-src 'self' https:; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.googletagmanager.com https://cdn.jsdelivr.net https://maps.googleapis.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https:; connect-src 'self' https://maps.googleapis.com;" always;
    
    # Permissions Policy
    add_header Permissions-Policy "geolocation=(self), microphone=(), camera=()" always;
    
    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/xeho247.vn/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/xeho247.vn/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;
    ssl_session_cache shared:SSL:10m;
    ssl_session_timeout 10m;
    
    # Root and index
    root /var/www/webroot/xeho247danang/src/public;
    index index.php index.html;
    
    # Block access to sensitive files
    location ~ /\. {
        deny all;
        access_log off;
        log_not_found off;
    }
    
    location ~ \.(env|git|gitignore|log)$ {
        deny all;
    }
    
    # PHP-FPM configuration
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_buffer_size 128k;
        fastcgi_buffers 256 4k;
        fastcgi_busy_buffers_size 256k;
        fastcgi_temp_file_write_size 256k;
        fastcgi_read_timeout 300;
    }
    
    # Laravel specific
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    # Gzip compression
    gzip on;
    gzip_vary on;
    gzip_proxied any;
    gzip_comp_level 6;
    gzip_types text/plain text/css text/xml text/javascript application/json application/javascript application/xml+rss image/svg+xml;
    
    # Browser caching
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot|webp)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        access_log off;
    }
}

# HTTP to HTTPS redirect
server {
    listen 80;
    server_name xeho247.vn www.xeho247.vn;
    return 301 https://$server_name$request_uri;
}
```

**Apply Changes:**
```bash
# Test config
nginx -t

# Reload nginx
systemctl reload nginx

# Verify headers
curl -I https://xeho247.vn
```

---

## ⚠️ WARNINGS

### 1. File Permissions

**Current:**
```
-rw-r--r-- /var/www/webroot/xeho247danang/src/.env (644)
drwxr-xr-x /var/www/webroot/xeho247danang/.git (755)
```

**Recommended:**
```bash
# .env should be 600 (owner read/write only)
chmod 600 /var/www/webroot/xeho247danang/src/.env

# .git should not be in webroot
# Move to parent directory (already correct)

# Storage and cache should be writable
chmod -R 775 /var/www/webroot/xeho247danang/src/storage
chmod -R 775 /var/www/webroot/xeho247danang/src/bootstrap/cache
chown -R www-data:www-data /var/www/webroot/xeho247danang/src/storage
chown -R www-data:www-data /var/www/webroot/xeho247danang/src/bootstrap/cache
```

### 2. Missing Rate Limiting

**Risk:** Brute force attacks on booking form

**Fix: Add Rate Limiting**

Update `src/routes/web.php`:
```php
use Illuminate\Support\Facades\RateLimiter;

// Add rate limiter
RateLimiter::for('bookings', function (Request $request) {
    return Limit::perMinute(3)->by($request->ip());
});

// Apply to booking route
Route::post('/booking', [BookingController::class, 'store'])
    ->middleware('throttle:bookings')
    ->name('booking.store');
```

Update controller to handle rate limit:
```php
use Illuminate\Http\Request;

public function store(Request $request)
{
    try {
        // Existing validation and logic
        
    } catch (\Illuminate\Http\Exceptions\ThrottleRequestsException $e) {
        return response()->json([
            'error' => 'Quá nhiều yêu cầu. Vui lòng thử lại sau 1 phút.'
        ], 429);
    }
}
```

### 3. SQL Injection Risk (Low)

**Found in:** `DashboardController.php`

```php
// Current (safe but could be better)
DB::raw('MONTH(created_at) as month'),
DB::raw('SUM(price) as revenue'),
DB::raw('COUNT(*) as bookings')
```

**Recommendation:** Use query builder methods when possible:
```php
// Better approach
->selectRaw('MONTH(created_at) as month, SUM(price) as revenue, COUNT(*) as bookings')
```

**Note:** Current usage is safe as no user input is concatenated.

---

## 🔧 ADDITIONAL RECOMMENDATIONS

### 1. Environment Variables

**Update .env for production:**
```env
# Current issues
APP_DEBUG=false  # MUST CHANGE
LOG_LEVEL=error  # Change from debug

# Add these
SANCTUM_STATEFUL_DOMAINS=xeho247.vn
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=strict
```

### 2. Laravel Security Config

**Add to `config/app.php`:**
```php
'debug_blacklist' => [
    '_ENV' => [
        'APP_KEY',
        'DB_PASSWORD',
        'MAIL_PASSWORD',
        'REDIS_PASSWORD',
    ],
    '_SERVER' => [
        'APP_KEY',
        'DB_PASSWORD',
    ],
],
```

### 3. Monitoring & Logging

**Setup Laravel Telescope (Development Only):**
```bash
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate
```

**Setup Log Monitoring:**
```bash
# Install logrotate for Laravel logs
cat > /etc/logrotate.d/laravel << 'EOF'
/var/www/webroot/xeho247danang/src/storage/logs/*.log {
    daily
    rotate 14
    compress
    delaycompress
    missingok
    notifempty
}
EOF
```

### 4. Backup Strategy

**Database Backup:**
```bash
# Add to crontab
0 2 * * * mysqldump -u user -p'password' database > /var/backups/xeho247_$(date +\%Y\%m\%d).sql
0 3 * * * find /var/backups -name "xeho247_*.sql" -mtime +30 -delete
```

### 5. Web Application Firewall (WAF)

**Consider adding Cloudflare:**
- DDoS protection
- WAF rules
- Rate limiting
- SSL/TLS optimization
- CDN benefits

### 6. Security Monitoring

**Install Fail2Ban:**
```bash
apt-get install fail2ban

# Configure for Nginx
cat > /etc/fail2ban/jail.local << 'EOF'
[nginx-limit-req]
enabled = true
filter = nginx-limit-req
action = iptables-multiport[name=ReqLimit, port="http,https"]
logpath = /var/log/nginx/error.log
findtime = 600
bantime = 3600
maxretry = 10
EOF

systemctl restart fail2ban
```

---

## 📋 IMMEDIATE ACTION PLAN

### Priority 1 (TODAY) - Critical

```bash
# 1. Disable debug mode
ssh cloudfly-hpl
cd /var/www/webroot/xeho247danang/src
sed -i 's/APP_DEBUG=true/APP_DEBUG=false/' .env
php artisan config:cache
systemctl restart php8.4-fpm

# 2. Add security headers
nano /etc/nginx/sites-available/xeho247.vn
# Add headers from section above
nginx -t
systemctl reload nginx

# 3. Fix file permissions
chmod 600 /var/www/webroot/xeho247danang/src/.env

# 4. Verify
curl -I https://xeho247.vn | grep -i "x-"
```

### Priority 2 (This Week) - Important

```bash
# 1. Add rate limiting to booking form
# 2. Setup fail2ban
# 3. Configure log rotation
# 4. Setup backup cron jobs
```

### Priority 3 (Next Week) - Enhancement

```bash
# 1. Consider Cloudflare WAF
# 2. Setup monitoring (UptimeRobot, Pingdom)
# 3. Regular security audits
# 4. Penetration testing
```

---

## 🧪 VERIFICATION CHECKLIST

After applying fixes:

```bash
# Check SSL
openssl s_client -connect xeho247.vn:443 -servername xeho247.vn

# Check headers
curl -I https://xeho247.vn

# Check debug mode
curl https://xeho247.vn/non-existent-page

# Check sensitive files
curl https://xeho247.vn/.env
curl https://xeho247.vn/.git/config

# Security scan
nmap -sV --script=vuln xeho247.vn
```

**Online Tools:**
- https://securityheaders.com/?q=https://xeho247.vn
- https://www.ssllabs.com/ssltest/analyze.html?d=xeho247.vn
- https://observatory.mozilla.org/analyze/xeho247.vn

---

## 📞 CONTACT & SUPPORT

**Security Issues:** Report immediately to admin@xeho247danang.vn  
**Emergency:** Call developer for critical vulnerabilities  

**Resources:**
- Laravel Security: https://laravel.com/docs/security
- OWASP Top 10: https://owasp.org/www-project-top-ten/
- Nginx Security: https://www.nginx.com/blog/mitigating-ddos-attacks-with-nginx-and-nginx-plus/

---

**Last Updated:** 2026-01-31  
**Next Audit:** 2026-02-28  
**Auditor:** GitHub Copilot AI Assistant

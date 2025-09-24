# 🔒 Security Configuration Guide - V2 Consolidation

## 🛡️ Essential Security Checklist

### 1. Environment Configuration

#### ✅ Production Environment Settings

**`.env` file security:**
```env
# CRITICAL: Set these for production
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:your-32-character-random-key-here

# Use HTTPS in production
APP_URL=https://your-domain.com
SESSION_SECURE_COOKIE=true
SANCTUM_STATEFUL_DOMAINS=your-domain.com,www.your-domain.com

# Secure logging
LOG_LEVEL=error
LOG_DEPRECATIONS_CHANNEL=null
```

#### ✅ File Permissions
```bash
# Set proper file permissions
sudo chown -R www-data:www-data /var/www/v2-consolidation
sudo chmod -R 755 /var/www/v2-consolidation
sudo chmod -R 775 /var/www/v2-consolidation/storage
sudo chmod -R 775 /var/www/v2-consolidation/bootstrap/cache

# Secure .env file
chmod 600 .env
chown www-data:www-data .env
```

### 2. Web Server Security (Nginx)

#### ✅ Secure Nginx Configuration

Create `/etc/nginx/sites-available/v2-consolidation-secure`:

```nginx
server {
    listen 80;
    server_name your-domain.com www.your-domain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name your-domain.com www.your-domain.com;
    root /var/www/v2-consolidation/public;

    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/your-domain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/your-domain.com/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;
    ssl_session_cache shared:SSL:10m;
    ssl_session_timeout 10m;

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;
    add_header Content-Security-Policy "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; img-src 'self' data: https:; font-src 'self' data:; connect-src 'self'; media-src 'self'; object-src 'none'; child-src 'none'; frame-src 'none'; worker-src 'none'; frame-ancestors 'self'; form-action 'self'; base-uri 'self';" always;
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains; preload" always;

    # Hide server information
    server_tokens off;

    # Rate limiting
    limit_req_zone $binary_remote_addr zone=login:10m rate=5r/m;
    limit_req_zone $binary_remote_addr zone=admin:10m rate=10r/m;

    index index.php;
    charset utf-8;

    # Main location
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Admin panel rate limiting
    location /admin {
        limit_req zone=admin burst=20 nodelay;
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Login rate limiting
    location /admin/login {
        limit_req zone=login burst=5 nodelay;
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Deny access to sensitive files
    location ~ /\.(env|git|svn) {
        deny all;
        return 404;
    }

    location ~ /(storage|bootstrap/cache) {
        deny all;
        return 404;
    }

    # PHP handling
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        
        # Security parameters
        fastcgi_param HTTP_PROXY "";
        fastcgi_param SERVER_NAME $host;
        fastcgi_param HTTPS on;
    }

    # Static files
    location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        add_header X-Content-Type-Options "nosniff";
    }

    # Block common attack patterns
    location ~* (eval\(|base64_decode|gzinflate|rot13|str_rot13) {
        deny all;
        return 444;
    }

    # Deny access to common files
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;
}
```

### 3. Firewall Configuration (UFW)

#### ✅ Basic Firewall Setup
```bash
# Reset UFW to defaults
sudo ufw --force reset

# Default policies
sudo ufw default deny incoming
sudo ufw default allow outgoing

# Allow SSH (replace 22 with your SSH port if changed)
sudo ufw allow 22/tcp

# Allow HTTP and HTTPS
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp

# Allow MySQL only from localhost (if needed)
sudo ufw allow from 127.0.0.1 to any port 3306

# Enable firewall
sudo ufw enable

# Check status
sudo ufw status verbose
```

## ✅ Security Checklist

### Pre-Deployment
- [ ] APP_DEBUG=false
- [ ] APP_ENV=production
- [ ] Strong APP_KEY generated
- [ ] HTTPS configured
- [ ] File permissions set correctly
- [ ] Database user has minimal privileges
- [ ] .env file secured (600 permissions)

### Server Security
- [ ] Firewall configured and enabled
- [ ] SSH secured (key-based auth, non-standard port)
- [ ] SSL certificate installed and auto-renewing
- [ ] Security headers configured
- [ ] Rate limiting implemented
- [ ] Server information hidden

### Application Security
- [ ] Laravel security middleware enabled
- [ ] Admin access restricted to admin users only
- [ ] Input validation implemented
- [ ] CSRF protection enabled
- [ ] SQL injection protection (using Eloquent)
- [ ] XSS protection enabled

Remember: Security is an ongoing process, not a one-time setup!
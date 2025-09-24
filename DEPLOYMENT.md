# Laravel V2-Consolidation - Ubuntu Deployment Guide

## 🖥️ Server Requirements

### System Requirements
- **OS**: Ubuntu 20.04 LTS or 22.04 LTS (recommended)
- **RAM**: Minimum 1GB, recommended 2GB+
- **Storage**: Minimum 10GB free space
- **PHP**: 8.1+ (your app uses 8.3)

---

## 📋 Step-by-Step Deployment

### 1. Initial Server Setup

```bash
# Update system packages
sudo apt update && sudo apt upgrade -y

# Install essential packages
sudo apt install -y curl wget git unzip software-properties-common
```

### 2. Install PHP 8.3 and Extensions

```bash
# Add PHP repository
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update

# Install PHP 8.3 and required extensions
sudo apt install -y php8.3 php8.3-fpm php8.3-cli php8.3-mysql php8.3-xml php8.3-curl php8.3-zip php8.3-mbstring php8.3-intl php8.3-gmp php8.3-gd php8.3-redis php8.3-common

# Verify PHP installation
php -v
```

### 3. Install Composer

```bash
# Download and install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

# Verify installation
composer --version
```

### 4. Install and Configure MySQL

```bash
# Install MySQL
sudo apt install -y mysql-server

# Secure MySQL installation
sudo mysql_secure_installation

# Create database and user
sudo mysql -u root -p
```

```sql
-- In MySQL shell:
CREATE DATABASE v2_consolidation;
CREATE USER 'laravel_user'@'localhost' IDENTIFIED BY 'your_strong_password';
GRANT ALL PRIVILEGES ON v2_consolidation.* TO 'laravel_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

-- Alternative: You can use any username you prefer:
-- CREATE USER 'v2_app_user'@'localhost' IDENTIFIED BY 'your_strong_password';
-- CREATE USER 'consolidation_db'@'localhost' IDENTIFIED BY 'your_strong_password';
-- CREATE USER 'your_preferred_name'@'localhost' IDENTIFIED BY 'your_strong_password';
```

### 5. Install and Configure Nginx

```bash
# Install Nginx
sudo apt install -y nginx

# Start and enable Nginx
sudo systemctl start nginx
sudo systemctl enable nginx

# Create Nginx configuration for your Laravel app
sudo nano /etc/nginx/sites-available/v2-consolidation
```

**Nginx Configuration** (`/etc/nginx/sites-available/v2-consolidation`):

⚠️ **IMPORTANT**: Replace `your-domain.com` with your actual domain name!

```nginx
server {
    listen 80;
    server_name your-domain.com www.your-domain.com;  # ← CHANGE THIS!
    # For your Hostinger server, use one of these:
    # server_name srv1026176.hstgr.cloud;  (recommended - use hostname)
    # server_name 72.60.198.8;  (alternative - use IP address)
    # 
    # Examples for custom domains:
    # server_name myapp.com www.myapp.com;
    # server_name localhost;  (for testing)
    
    root /var/www/v2-consolidation/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

```bash
# Enable the site
sudo ln -s /etc/nginx/sites-available/v2-consolidation /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### 6. Deploy Laravel Application

```bash
# Create web directory
sudo mkdir -p /var/www/v2-consolidation
sudo chown -R $USER:www-data /var/www/v2-consolidation

# Clone or upload your repository
cd /var/www
# Option 1: If using Git
git clone https://github.com/rsedilla/V1---Consolidation.git v2-consolidation
cd v2-consolidation
git checkout 06-New-Resource

# Option 2: If uploading files, use SCP/SFTP to upload your project files

# Install dependencies
composer install --optimize-autoloader --no-dev

# Set permissions
sudo chown -R www-data:www-data /var/www/v2-consolidation
sudo chmod -R 755 /var/www/v2-consolidation
sudo chmod -R 775 /var/www/v2-consolidation/storage
sudo chmod -R 775 /var/www/v2-consolidation/bootstrap/cache
```

### 7. Configure Environment

```bash
# Copy environment file
cp .env.example .env
nano .env
```

**Update `.env` file**:
```env
APP_NAME="V2 Consolidation"
APP_ENV=production
APP_KEY=  # Will be generated
APP_DEBUG=false
APP_URL=https://your-domain.com

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=v2_consolidation
DB_USERNAME=laravel_user
DB_PASSWORD=your_strong_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Add your mail configuration
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
```

```bash
# Generate application key
php artisan key:generate

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations and seeders
php artisan migrate --force
php artisan db:seed --force
```

### 8. Install SSL Certificate (Let's Encrypt)

```bash
# Install Certbot
sudo apt install -y certbot python3-certbot-nginx

# Obtain SSL certificate
sudo certbot --nginx -d your-domain.com -d www.your-domain.com

# Verify auto-renewal
sudo certbot renew --dry-run
```

### 9. Configure Firewall

```bash
# Install and configure UFW
sudo ufw allow OpenSSH
sudo ufw allow 'Nginx Full'
sudo ufw enable
sudo ufw status
```

### 10. Set Up Process Monitoring (Optional but recommended)

```bash
# Install Supervisor for queue workers
sudo apt install -y supervisor

# Create supervisor configuration
sudo nano /etc/supervisor/conf.d/laravel-worker.conf
```

**Supervisor Configuration**:
```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/v2-consolidation/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/v2-consolidation/storage/logs/worker.log
stopwaitsecs=3600
```

```bash
# Update supervisor
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
```

---

## 🔧 Post-Deployment Checklist

### Essential Checks
- [ ] Application loads at your domain
- [ ] Admin panel accessible at `/admin`
- [ ] Database connections working
- [ ] File permissions correct
- [ ] SSL certificate installed
- [ ] Email sending functional
- [ ] G12 Leaders resource visible to admins only

### Performance Optimization
- [ ] PHP OPcache enabled
- [ ] Laravel caching configured
- [ ] Database indexes optimized
- [ ] Static assets compressed

### Security Verification
- [ ] Debug mode disabled (`APP_DEBUG=false`)
- [ ] Strong passwords used
- [ ] Firewall configured
- [ ] Regular backups scheduled
- [ ] Error logging configured

---

## 🚨 Troubleshooting

### Common Issues

**Permission Errors:**
```bash
sudo chown -R www-data:www-data /var/www/v2-consolidation
sudo chmod -R 755 /var/www/v2-consolidation
sudo chmod -R 775 /var/www/v2-consolidation/storage /var/www/v2-consolidation/bootstrap/cache
```

**500 Internal Server Error:**
```bash
# Check Laravel logs
tail -f /var/www/v2-consolidation/storage/logs/laravel.log

# Check Nginx error logs
sudo tail -f /var/log/nginx/error.log
```

**Database Connection Issues:**
```bash
# Test database connection
php artisan tinker
# In tinker: DB::connection()->getPdo();
```

---

## 📞 Support

If you encounter issues during deployment, check:
1. Laravel logs: `storage/logs/laravel.log`
2. Nginx logs: `/var/log/nginx/error.log`
3. PHP-FPM logs: `/var/log/php8.3-fpm.log`

Remember to replace `your-domain.com` with your actual domain name throughout this guide.
#!/bin/bash

# Laravel Production Optimization Script
# This script optimizes your Laravel application for production performance

echo "🔧 Optimizing Laravel application for production..."

# Colors for output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

print_status() {
    echo -e "${BLUE}[OPTIMIZING]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[COMPLETED]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

# Clear all caches first
print_status "Clearing existing caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear
print_success "Caches cleared"

# Optimize Composer autoloader
print_status "Optimizing Composer autoloader..."
composer dump-autoload --optimize --classmap-authoritative --no-dev
print_success "Composer autoloader optimized"

# Cache configuration
print_status "Caching configuration files..."
php artisan config:cache
print_success "Configuration cached"

# Cache routes
print_status "Caching routes..."
php artisan route:cache
print_success "Routes cached"

# Cache views
print_status "Caching Blade views..."
php artisan view:cache
print_success "Views cached"

# Cache events
print_status "Caching events..."
php artisan event:cache
print_success "Events cached"

# Optimize for production (if using Laravel 9+)
if php artisan --version | grep -q "Laravel Framework [9-9]"; then
    print_status "Running Laravel optimization..."
    php artisan optimize
    print_success "Laravel optimization completed"
fi

# Create opcache configuration recommendation
print_status "Creating PHP OPcache configuration recommendation..."
cat > opcache-config.txt << 'EOF'
# Add these settings to your PHP configuration (php.ini) for better performance:

# OPcache settings
opcache.enable=1
opcache.enable_cli=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=20000
opcache.max_wasted_percentage=10
opcache.validate_timestamps=0
opcache.revalidate_freq=0
opcache.save_comments=1
opcache.enable_file_override=1

# Additional PHP optimizations
realpath_cache_size=4096K
realpath_cache_ttl=600
memory_limit=512M
max_execution_time=300
upload_max_filesize=20M
post_max_size=20M
EOF
print_success "OPcache configuration created in opcache-config.txt"

# Performance recommendations
print_status "Performance optimization completed!"
echo
echo "📋 Additional recommendations for production:"
echo "1. Enable PHP OPcache (see opcache-config.txt)"
echo "2. Use Redis or Memcached for session/cache storage"
echo "3. Enable Gzip compression in your web server"
echo "4. Use a CDN for static assets"
echo "5. Set up Laravel Horizon for queue processing (if using queues)"
echo "6. Configure proper database indexes"
echo "7. Use Laravel Telescope for monitoring (but disable in production)"
echo
print_success "🚀 Your Laravel application is now optimized for production!"
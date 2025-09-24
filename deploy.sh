#!/bin/bash

# Laravel V2-Consolidation Deployment Script
# Run this script after uploading your files to the server

echo "🚀 Starting Laravel V2-Consolidation deployment..."

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    print_error "artisan file not found. Please run this script from your Laravel project root."
    exit 1
fi

# Check if production env file exists
if [ ! -f ".env" ]; then
    if [ -f ".env.production" ]; then
        print_status "Copying production environment file..."
        cp .env.production .env
    else
        print_error "No .env file found. Please create one from .env.example"
        exit 1
    fi
fi

# Install/update composer dependencies
print_status "Installing/updating Composer dependencies..."
if command -v composer &> /dev/null; then
    composer install --optimize-autoloader --no-dev --no-interaction
    print_success "Composer dependencies installed"
else
    print_error "Composer not found. Please install Composer first."
    exit 1
fi

# Generate application key if not set
print_status "Checking application key..."
if grep -q "APP_KEY=$" .env; then
    print_status "Generating application key..."
    php artisan key:generate --force
    print_success "Application key generated"
fi

# Clear and cache configuration
print_status "Optimizing application..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache
print_success "Application optimized"

# Run database migrations
print_status "Running database migrations..."
read -p "Do you want to run database migrations? (y/N): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan migrate --force
    print_success "Database migrations completed"
    
    read -p "Do you want to run database seeders? (y/N): " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        php artisan db:seed --force
        print_success "Database seeders completed"
    fi
fi

# Set proper permissions
print_status "Setting file permissions..."
find storage -type f -exec chmod 664 {} \;
find storage -type d -exec chmod 775 {} \;
find bootstrap/cache -type f -exec chmod 664 {} \;
find bootstrap/cache -type d -exec chmod 775 {} \;
print_success "File permissions set"

# Create symbolic link for storage
print_status "Creating storage symbolic link..."
php artisan storage:link
print_success "Storage link created"

# Final checks
print_status "Running final checks..."

# Check if .env is properly configured
if grep -q "APP_DEBUG=true" .env; then
    print_warning "APP_DEBUG is set to true. Consider setting it to false for production."
fi

if grep -q "APP_ENV=local" .env; then
    print_warning "APP_ENV is set to local. Consider setting it to production."
fi

# Check database connection
print_status "Testing database connection..."
if php artisan migrate:status &> /dev/null; then
    print_success "Database connection successful"
else
    print_error "Database connection failed. Please check your .env database settings."
fi

print_success "🎉 Deployment completed!"
print_status "Your Laravel application should now be ready."
print_status ""
print_status "Next steps:"
print_status "1. Configure your web server (Nginx/Apache) to point to the public/ directory"
print_status "2. Set up SSL certificate"
print_status "3. Configure firewall"
print_status "4. Set up monitoring and backups"
print_status ""
print_status "Access your admin panel at: https://your-domain.com/admin"
# Database Setup Guide for V2-Consolidation

## 📊 Database Requirements

Your Laravel application requires MySQL 8.0+ or MariaDB 10.3+ for optimal performance.

## 🔧 Production Database Setup

### 1. Create Database and User

```sql
-- Connect to MySQL as root
mysql -u root -p

-- Create database
CREATE DATABASE v2_consolidation CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create dedicated user
CREATE USER 'laravel_user'@'localhost' IDENTIFIED BY 'your_secure_password_here';

-- Grant privileges
GRANT ALL PRIVILEGES ON v2_consolidation.* TO 'laravel_user'@'localhost';

-- Apply changes
FLUSH PRIVILEGES;

-- Verify database creation
SHOW DATABASES;

-- Exit MySQL
EXIT;
```

### 2. Configure Laravel Database Connection

Update your `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=v2_consolidation
DB_USERNAME=laravel_user
DB_PASSWORD=your_secure_password_here
```

### 3. Test Database Connection

```bash
# Test connection using Laravel
php artisan tinker

# In tinker, run:
DB::connection()->getPdo();
# Should return PDO object if successful

# Exit tinker
exit
```

## 🗃️ Database Migrations & Seeding

### Current Database Schema

Your application includes these main tables:

1. **users** - User accounts and authentication
2. **g12_leaders** - G12 leadership hierarchy  
3. **vip_members** - VIP member records
4. **consolidator_members** - Consolidator member records
5. **lifeclass_candidates** - Lifeclass candidate records
6. **start_up_your_new_lives** - SUYNL lesson tracking
7. **sunday_services** - Sunday service attendance
8. **cell_groups** - Cell group attendance

### Run Migrations

```bash
# Check migration status
php artisan migrate:status

# Run all pending migrations
php artisan migrate --force

# If you need to reset and rebuild (⚠️ WARNING: This will delete all data)
# php artisan migrate:fresh --seed --force
```

### Database Seeding

Your application includes seeders for:

```bash
# Run all seeders
php artisan db:seed --force

# Or run specific seeders
php artisan db:seed --class=G12LeaderSeeder --force
php artisan db:seed --class=UserSeeder --force
```

### Important Seeder Information

The application includes these seeders:

1. **UserSeeder** - Creates admin and test users
2. **G12LeaderSeeder** - Creates G12 leadership hierarchy
3. **VipMemberSeeder** - Sample VIP member data
4. **StartUpYourNewLifeSeeder** - SUYNL lesson data

## 🔐 Database Security

### 1. Secure Database User

```sql
-- Create user with minimal required permissions
CREATE USER 'laravel_prod'@'localhost' IDENTIFIED BY 'very_secure_password_123!';

-- Grant only necessary privileges
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, INDEX, ALTER 
ON v2_consolidation.* TO 'laravel_prod'@'localhost';

FLUSH PRIVILEGES;
```

### 2. Database Configuration Optimization

Add these settings to your MySQL configuration (`/etc/mysql/my.cnf`):

```ini
[mysqld]
# Connection settings
max_connections = 100
connect_timeout = 60
wait_timeout = 120

# Buffer settings for performance
innodb_buffer_pool_size = 256M
innodb_log_file_size = 64M
innodb_flush_method = O_DIRECT

# Character set
character-set-server = utf8mb4
collation-server = utf8mb4_unicode_ci

# Binary logging for backups
log-bin = mysql-bin
binlog_format = mixed
expire_logs_days = 7
```

### 3. Regular Backups

Create automated backup script:

```bash
#!/bin/bash
# backup-db.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backups/mysql"
DB_NAME="v2_consolidation"
DB_USER="laravel_user"
DB_PASS="your_password"

# Create backup directory if it doesn't exist
mkdir -p $BACKUP_DIR

# Create backup
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/v2_consolidation_$DATE.sql

# Compress backup
gzip $BACKUP_DIR/v2_consolidation_$DATE.sql

# Remove backups older than 7 days
find $BACKUP_DIR -name "*.sql.gz" -mtime +7 -delete

echo "Database backup completed: v2_consolidation_$DATE.sql.gz"
```

Make it executable and add to cron:

```bash
chmod +x backup-db.sh

# Add to crontab (daily backup at 2 AM)
crontab -e
# Add: 0 2 * * * /path/to/backup-db.sh
```

## 🚨 Troubleshooting

### Common Database Issues

**Connection Refused:**
```bash
# Check if MySQL is running
sudo systemctl status mysql

# Start MySQL if stopped
sudo systemctl start mysql
```

**Access Denied:**
```bash
# Reset MySQL root password if needed
sudo mysql_secure_installation

# Check user privileges
mysql -u root -p
SELECT User, Host FROM mysql.user;
SHOW GRANTS FOR 'laravel_user'@'localhost';
```

**Migration Errors:**
```bash
# Check detailed error
php artisan migrate --force -v

# Rollback last migration if needed
php artisan migrate:rollback

# Reset migrations (⚠️ WARNING: Deletes all data)
php artisan migrate:fresh
```

**Performance Issues:**
```bash
# Check slow queries
mysql -u root -p -e "SHOW FULL PROCESSLIST;"

# Analyze table performance
mysql -u root -p v2_consolidation -e "SHOW TABLE STATUS;"

# Check indexes
mysql -u root -p v2_consolidation -e "SHOW INDEX FROM users;"
```

## 📊 Database Monitoring

Monitor your database performance:

```sql
-- Check database size
SELECT 
    table_schema AS "Database",
    ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS "Size (MB)"
FROM information_schema.tables 
WHERE table_schema = 'v2_consolidation'
GROUP BY table_schema;

-- Check table sizes
SELECT 
    table_name AS "Table",
    ROUND(((data_length + index_length) / 1024 / 1024), 2) AS "Size (MB)"
FROM information_schema.TABLES 
WHERE table_schema = 'v2_consolidation'
ORDER BY (data_length + index_length) DESC;
```

## ✅ Database Setup Checklist

- [ ] MySQL 8.0+ installed and running
- [ ] Database `v2_consolidation` created
- [ ] Dedicated database user created with proper permissions
- [ ] Laravel `.env` configured with database credentials
- [ ] Database connection tested successfully
- [ ] All migrations run without errors
- [ ] Seeders executed if needed
- [ ] Database backup script configured
- [ ] MySQL optimized for production
- [ ] Monitoring set up

Remember to never commit your actual database passwords to version control!
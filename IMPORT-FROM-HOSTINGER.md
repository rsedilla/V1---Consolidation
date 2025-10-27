# Import Hostinger Database to Local

## Quick Method (Recommended)

### Step 1: Export from Hostinger via phpMyAdmin

1. **Access phpMyAdmin on Hostinger:**
   - Go to your Hostinger control panel
   - Find phpMyAdmin
   - Or visit: https://srv1026176.hstgr.cloud/phpmyadmin (if available)

2. **Export the database:**
   - Select database: `consolidation`
   - Click "Export" tab
   - Choose "Quick" export method
   - Format: SQL
   - Click "Go"
   - Save the file (e.g., `consolidation.sql`)

### Step 2: Import to Local Database

1. **Open phpMyAdmin locally:**
   - In Laragon, click "Database" or go to `http://localhost/phpmyadmin`

2. **Import the database:**
   - Select database: `consolidation`
   - Click "Import" tab
   - Click "Choose File" and select the downloaded `consolidation.sql`
   - Click "Go"
   - Wait for import to complete

### Step 3: Clear Laravel Cache

```bash
php artisan optimize:clear
php artisan config:clear
```

---

## Alternative: SSH Method (Advanced)

### Step 1: Connect to Hostinger via SSH

```bash
ssh hstgr-srv1026176@srv1026176.hstgr.cloud
```

### Step 2: Export Database on Hostinger

```bash
cd /home/hstgr-srv1026176/htdocs/srv1026176.hstgr.cloud

# Create backup
mysqldump -u root -p consolidation > backup_$(date +%Y%m%d).sql

# Check file was created
ls -lh backup_*.sql
```

### Step 3: Download to Your Computer

**Option A: Using SCP (if you have it)**
```bash
# Run this on your local machine
scp hstgr-srv1026176@srv1026176.hstgr.cloud:/home/hstgr-srv1026176/htdocs/srv1026176.hstgr.cloud/backup_*.sql .
```

**Option B: Using WinSCP or FileZilla**
1. Connect to `srv1026176.hstgr.cloud`
2. Navigate to `/home/hstgr-srv1026176/htdocs/srv1026176.hstgr.cloud/`
3. Download the `backup_*.sql` file

### Step 4: Import to Local MySQL

```bash
# In your local machine (Windows)
cd C:\laragon\www\V2-Consolidation

# Import (replace backup_20251027.sql with your actual filename)
C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysql.exe -u root consolidation < backup_20251027.sql
```

### Step 5: Verify Import

```bash
php artisan tinker --execute="echo 'Members: ' . DB::table('members')->count() . PHP_EOL; echo 'Users: ' . DB::table('users')->count() . PHP_EOL;"
```

---

## Troubleshooting

### Error: "Access denied for user"
- Make sure MySQL is running in Laragon
- Check your local database credentials in `.env`

### Error: "Unknown database"
- Create the database first:
  ```bash
  C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysql.exe -u root -e "CREATE DATABASE IF NOT EXISTS consolidation"
  ```

### Import is very slow
- This is normal for large databases
- Don't close the window, wait for it to complete

### Error: "Table already exists"
- Drop all tables first, then import:
  ```bash
  php artisan db:wipe
  # Then import again
  ```

---

## After Import Complete

1. **Clear all caches:**
   ```bash
   php artisan optimize:clear
   php artisan config:cache
   php artisan route:cache
   ```

2. **Test login:**
   - Visit: http://127.0.0.1:8000/admin
   - Use your Hostinger credentials

3. **Verify data:**
   - Check if members, leaders, and SOL data are present
   - Test the SOL Graduate feature

---

## Important Notes

- ✅ Your Hostinger production data is safe
- ✅ This only imports data, doesn't affect production
- ✅ You can repeat this process anytime
- ⚠️ Remember to backup before making major local changes

---

**Need help? The batch script `import-from-hostinger.bat` can guide you through this process step-by-step!**

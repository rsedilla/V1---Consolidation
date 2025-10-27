@echo off
REM ====================================================================
REM Quick Database Import from Hostinger
REM ====================================================================

echo.
echo ==========================================
echo   Database Import Helper
echo ==========================================
echo.
echo This script will help you import your Hostinger database.
echo.
echo STEP 1: Download the database backup from Hostinger
echo -------------------------------------------------------
echo.
echo Please follow these steps:
echo.
echo 1. Login to Hostinger control panel (hpanel.hostinger.com)
echo 2. Go to "Databases" section
echo 3. Find your "consolidation" database
echo 4. Click "Manage" or "phpMyAdmin"
echo 5. Click "Export" tab
echo 6. Click "Go" button
echo 7. Save the file as: consolidation_backup.sql
echo 8. Move it to: C:\laragon\www\V2-Consolidation\
echo.

pause

echo.
echo STEP 2: Checking if backup file exists...
echo.

if not exist "consolidation_backup.sql" (
    echo [ERROR] File not found: consolidation_backup.sql
    echo.
    echo Please download the backup file and place it in:
    echo %cd%
    echo.
    echo Then run this script again.
    pause
    exit /b 1
)

echo [OK] Backup file found!
echo.

echo STEP 3: Importing to local database...
echo.
echo This may take a few minutes. Please wait...
echo.

REM Drop all tables first to ensure clean import
echo Preparing database...
C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysql.exe -u root -e "DROP DATABASE IF EXISTS consolidation; CREATE DATABASE consolidation;"

if %errorlevel% neq 0 (
    echo [ERROR] Failed to prepare database
    echo Make sure MySQL is running in Laragon
    pause
    exit /b 1
)

echo Importing data...
C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysql.exe -u root consolidation < consolidation_backup.sql

if %errorlevel% equ 0 (
    echo.
    echo ==========================================
    echo   SUCCESS! Database imported!
    echo ==========================================
    echo.
    echo Your local database now has all the production data.
    echo.
    echo NEXT STEPS:
    echo 1. Clear Laravel cache
    echo.
    
    C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.exe artisan optimize:clear
    
    echo.
    echo 2. Test your application at: http://127.0.0.1:8000/admin
    echo.
    echo Done!
    echo.
) else (
    echo.
    echo [ERROR] Import failed!
    echo.
    echo Please check:
    echo - MySQL is running in Laragon
    echo - Backup file is not corrupted
    echo.
)

pause

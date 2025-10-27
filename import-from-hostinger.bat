@echo off
REM ============================================================================
REM Import Database from Hostinger to Local
REM This script helps you download and import production data to local dev
REM ============================================================================

echo ==========================================
echo   Import Data from Hostinger
echo ==========================================
echo.

REM Configuration
set HOSTINGER_USER=hstgr-srv1026176
set HOSTINGER_HOST=srv1026176.hstgr.cloud
set HOSTINGER_DB=consolidation
set LOCAL_DB=consolidation
set BACKUP_FILE=hostinger_backup_%date:~-4,4%%date:~-10,2%%date:~-7,2%_%time:~0,2%%time:~3,2%%time:~6,2%.sql
set BACKUP_FILE=%BACKUP_FILE: =0%

echo Step 1: Create backup on Hostinger...
echo.
echo Please run this command on Hostinger via SSH:
echo.
echo ssh %HOSTINGER_USER%@%HOSTINGER_HOST%
echo cd /home/%HOSTINGER_USER%/htdocs/srv1026176.hstgr.cloud
echo mysqldump -u root -p %HOSTINGER_DB% ^> %BACKUP_FILE%
echo.
echo This will create a backup file: %BACKUP_FILE%
echo.

pause

echo.
echo Step 2: Download the backup file from Hostinger...
echo.
echo Please use one of these methods:
echo.
echo A) Using SCP (if installed):
echo    scp %HOSTINGER_USER%@%HOSTINGER_HOST%:/home/%HOSTINGER_USER%/htdocs/srv1026176.hstgr.cloud/%BACKUP_FILE% .
echo.
echo B) Using FTP/SFTP client (FileZilla, WinSCP):
echo    - Connect to %HOSTINGER_HOST%
echo    - Navigate to /home/%HOSTINGER_USER%/htdocs/srv1026176.hstgr.cloud/
echo    - Download %BACKUP_FILE%
echo    - Save it to: %cd%
echo.

pause

echo.
echo Step 3: Import to local database...
echo.

REM Check if backup file exists
if not exist "%BACKUP_FILE%" (
    echo ERROR: Backup file not found!
    echo Please download %BACKUP_FILE% to this directory first.
    pause
    exit /b 1
)

echo Found backup file: %BACKUP_FILE%
echo.
echo Importing to local database: %LOCAL_DB%
echo This may take a few minutes...
echo.

C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysql.exe -u root %LOCAL_DB% < "%BACKUP_FILE%"

if %errorlevel% equ 0 (
    echo.
    echo ==========================================
    echo   SUCCESS! Data imported successfully!
    echo ==========================================
    echo.
    echo Your local database now has the production data.
    echo.
    echo Next steps:
    echo 1. Clear Laravel caches: php artisan optimize:clear
    echo 2. Test your application: http://127.0.0.1:8000/admin
    echo.
) else (
    echo.
    echo ==========================================
    echo   ERROR: Import failed!
    echo ==========================================
    echo.
    echo Please check:
    echo 1. MySQL is running in Laragon
    echo 2. Database 'consolidation' exists
    echo 3. Backup file is not corrupted
    echo.
)

pause

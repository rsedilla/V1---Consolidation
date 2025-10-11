@echo off
echo ========================================
echo Running SOL 1 Migrations and Seeders
echo ========================================
echo.

echo Step 1: Running migrations...
php artisan migrate
if %errorlevel% neq 0 (
    echo ERROR: Migration failed!
    pause
    exit /b %errorlevel%
)
echo ✓ Migrations completed successfully!
echo.

echo Step 2: Running SOL 1 Lessons Seeder...
php artisan db:seed --class=Sol1LessonsTableSeeder
if %errorlevel% neq 0 (
    echo ERROR: Seeder failed!
    pause
    exit /b %errorlevel%
)
echo ✓ Seeder completed successfully!
echo.

echo ========================================
echo SOL 1 Setup Complete!
echo ========================================
echo.
echo Next steps:
echo 1. Access your Filament admin panel
echo 2. Look for "SOL 1" and "SOL 1 Progress" in navigation
echo 3. Test creating SOL 1 students and tracking progress
echo.
pause

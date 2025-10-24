@echo off
cls
echo ========================================
echo   Laravel Application Server
echo   Starting...
echo ========================================
echo.

cd /d "%~dp0"

echo Checking PHP installation...
php -v >nul 2>&1
if errorlevel 1 (
    echo ERROR: PHP is not installed or not in PATH!
    echo Please install PHP or add it to your PATH
    pause
    exit /b 1
)

echo PHP Version:
php -v | findstr /C:"PHP"
echo.

echo Checking if vendor directory exists...
if not exist "vendor\" (
    echo Installing Composer dependencies...
    composer install
    echo.
)

echo Checking APP_KEY...
findstr /C:"APP_KEY=" .env | findstr /C:"APP_KEY=base64:" >nul
if errorlevel 1 (
    echo Generating APP_KEY...
    php artisan key:generate
    echo.
)

echo Clearing caches...
php artisan config:clear
php artisan cache:clear
echo.

echo Starting Laravel Server on http://127.0.0.1:8080
echo Press Ctrl+C to stop the server
echo.
php artisan serve --port=8080

pause

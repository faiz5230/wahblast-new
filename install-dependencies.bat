@echo off
cls
echo ========================================
echo   Installing All Dependencies
echo ========================================
echo.

cd /d "%~dp0"

echo [1/2] Installing Node.js dependencies for WhatsApp Server...
echo.
cd anywhatzap\anywhatzap
if exist "package.json" (
    npm install
    echo.
    echo Node.js dependencies installed successfully!
) else (
    echo ERROR: package.json not found!
)
echo.

cd /d "%~dp0"

echo [2/2] Installing PHP dependencies for Laravel...
echo.
if exist "composer.json" (
    composer install
    echo.
    echo PHP dependencies installed successfully!
) else (
    echo ERROR: composer.json not found!
)
echo.

echo ========================================
echo   Installation Complete!
echo ========================================
echo.
echo You can now run the servers using:
echo   - start-whatsapp-server.bat
echo   - start-laravel-server.bat
echo   - start-both-servers.bat
echo.
pause

@echo off
cls
echo ========================================
echo   WhatsApp Server (Baileys)
echo   Starting...
echo ========================================
echo.

cd /d "%~dp0anywhatzap\anywhatzap"

echo Checking Node.js installation...
node --version >nul 2>&1
if errorlevel 1 (
    echo ERROR: Node.js is not installed!
    echo Please install Node.js from https://nodejs.org/
    pause
    exit /b 1
)

echo Node.js Version:
node --version
echo.

echo Checking if node_modules exists...
if not exist "node_modules\" (
    echo Installing dependencies...
    npm install
    echo.
)

echo Starting WhatsApp Server...
echo Press Ctrl+C to stop the server
echo.
node app.js

pause

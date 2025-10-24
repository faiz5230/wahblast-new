@echo off
cls
echo ========================================
echo   Starting BOTH Servers
echo   1. WhatsApp Server (Node.js)
echo   2. Laravel Server (PHP)
echo ========================================
echo.

echo Starting WhatsApp Server in new window...
start "WhatsApp Server" cmd /k "%~dp0start-whatsapp-server.bat"

timeout /t 3 /nobreak >nul

echo Starting Laravel Server in new window...
start "Laravel Server" cmd /k "%~dp0start-laravel-server.bat"

echo.
echo Both servers are starting in separate windows!
echo.
echo WhatsApp Server: Check the first window
echo Laravel Server:  http://192.168.0.252:8080
echo.
echo Press any key to close this window...
pause >nul

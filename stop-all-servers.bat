@echo off
cls
echo ========================================
echo   Stopping All Servers
echo ========================================
echo.

echo Stopping PHP processes...
taskkill /F /IM php.exe >nul 2>&1
if errorlevel 1 (
    echo No PHP processes found
) else (
    echo PHP processes stopped
)
echo.

echo Stopping Node.js processes...
taskkill /F /IM node.exe >nul 2>&1
if errorlevel 1 (
    echo No Node.js processes found
) else (
    echo Node.js processes stopped
)
echo.

echo ========================================
echo   All servers stopped!
echo ========================================
echo.
pause

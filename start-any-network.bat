@echo off
setlocal
cd /d "%~dp0"
set "DB_DATABASE=%~dp0database\database.sqlite"

set "PHP_BIN=%~dp0.tools\php-8.5\php.exe"
set "TUNNEL_BIN=%~dp0.tools\cloudflared.exe"
set "NPM_BIN=C:\Program Files\nodejs\npm.cmd"

if not exist "%PHP_BIN%" (
    echo Bundled PHP 8.5 was not found: %PHP_BIN%
    pause
    exit /b 1
)
if not exist "%TUNNEL_BIN%" (
    if not exist "%~dp0.tools" mkdir "%~dp0.tools"
    echo Downloading the official Cloudflare Tunnel executable...
    powershell -NoProfile -ExecutionPolicy Bypass -Command "$ProgressPreference='SilentlyContinue'; Invoke-WebRequest -Uri 'https://github.com/cloudflare/cloudflared/releases/latest/download/cloudflared-windows-amd64.exe' -OutFile '%TUNNEL_BIN%'"
    if errorlevel 1 (
        echo Could not download Cloudflare Tunnel. Check the internet connection and try again.
        pause
        exit /b 1
    )
)

"%PHP_BIN%" -r "exit(PHP_VERSION_ID >= 80401 ? 0 : 1);"
if errorlevel 1 (
    echo This project requires PHP 8.4.1 or newer.
    pause
    exit /b 1
)

rem Keep debug stack traces off while the development app is publicly reachable.
set "APP_DEBUG=false"

echo Starting the local Laravel server and temporary public HTTPS tunnel.
echo Keep the Laravel server, queue worker, asset watcher, and tunnel windows open.
echo The tunnel window will show the temporary HTTPS URL and save it for seller delivery-boy links.
echo Anyone with the HTTPS URL can reach pages that are not behind login.
echo Blade and PHP edits are used on the next page load. CSS and JavaScript edits rebuild automatically.
echo XAMPP/MySQL is not required because the project currently uses SQLite.
echo.

start "Smart Basket Laravel Server" cmd /k ""%PHP_BIN%" artisan serve --host=127.0.0.1 --port=8000"
start "Smart Basket Queue Worker" cmd /k ""%PHP_BIN%" artisan queue:work --sleep=2 --tries=3 --timeout=120"
if exist "%NPM_BIN%" (
    start "Smart Basket Asset Watcher" cmd /k ""%NPM_BIN%" run build -- --watch"
) else (
    echo Node.js/npm was not found at %NPM_BIN%. CSS/JavaScript auto-build is unavailable.
)
timeout /t 3 /nobreak >nul
start "Smart Basket HTTPS Tunnel" powershell -NoExit -NoProfile -ExecutionPolicy Bypass -File "%~dp0start-cloudflare-tunnel.ps1" -Cloudflared "%TUNNEL_BIN%"

echo The public link changes each time the tunnel is started. Use the current link shown in its window.
pause

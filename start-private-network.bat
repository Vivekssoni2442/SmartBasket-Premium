@echo off
setlocal
cd /d "%~dp0"
set "DB_DATABASE=%~dp0database\database.sqlite"

set "PHP_BIN=%~dp0.tools\php-8.5\php.exe"
set "TAILSCALE_BIN=%ProgramFiles%\Tailscale\tailscale.exe"
set "NPM_BIN=C:\Program Files\nodejs\npm.cmd"

if not exist "%PHP_BIN%" (
    echo Bundled PHP 8.5 was not found: %PHP_BIN%
    pause
    exit /b 1
)
if not exist "%TAILSCALE_BIN%" (
    echo Tailscale is required for private access from other networks.
    echo Install Tailscale on this PC and every phone, then sign them into the same account.
    pause
    exit /b 1
)

"%PHP_BIN%" -r "exit(PHP_VERSION_ID >= 80401 ? 0 : 1);"
if errorlevel 1 (
    echo Smart Basket needs PHP 8.4.1 or newer.
    pause
    exit /b 1
)

for /f "usebackq delims=" %%U in (`powershell -NoProfile -ExecutionPolicy Bypass -File "%~dp0get-private-server-url.ps1" -Tailscale "%TAILSCALE_BIN%"`) do set "PRIVATE_URL=%%U"
if not defined PRIVATE_URL (
    echo Could not read this PC's Tailscale DNS name.
    echo Sign in to Tailscale, enable MagicDNS and HTTPS certificates, then retry.
    pause
    exit /b 1
)

"%TAILSCALE_BIN%" serve --bg 8000
if errorlevel 1 (
    echo Tailscale Serve could not start. Enable HTTPS certificates for your tailnet and retry.
    pause
    exit /b 1
)

if not exist "%~dp0storage\app" mkdir "%~dp0storage\app"
>"%~dp0storage\app\driver-public-url.txt" echo %PRIVATE_URL%
set "APP_DEBUG=false"
"%PHP_BIN%" artisan config:clear
echo Smart Basket private URL: %PRIVATE_URL%
echo This URL is reachable only by devices signed into your Tailscale network.
echo Keep the server and Tailscale running. Sign every phone into that same Tailscale account.
echo.

start "Smart Basket Laravel Server" cmd /k ""%PHP_BIN%" artisan serve --host=127.0.0.1 --port=8000"
start "Smart Basket Queue Worker" cmd /k ""%PHP_BIN%" artisan queue:work --sleep=2 --tries=3 --timeout=120"
if exist "%NPM_BIN%" (
    start "Smart Basket Asset Watcher" cmd /k ""%NPM_BIN%" run build -- --watch"
) else (
    echo Node.js/npm was not found at %NPM_BIN%. CSS and JavaScript changes will not rebuild automatically.
)
timeout /t 4 /nobreak >nul
start "Smart Basket Private Website" "%PRIVATE_URL%"
echo Open the URL above on each Tailscale-connected phone. Copy fresh driver links from Seller - Delivery partners.
echo Blade/PHP updates appear after refresh. CSS/JavaScript rebuild automatically; refresh the page to load them.
pause

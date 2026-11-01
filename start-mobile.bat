@echo off
setlocal
cd /d "%~dp0"
set "DB_DATABASE=%~dp0database\database.sqlite"

set "PHP_BIN=%~dp0.tools\php-8.5\php.exe"
if not exist "%PHP_BIN%" (
    echo Smart Basket needs PHP 8.4.1 or newer.
    echo The bundled PHP runtime was not found at:
    echo %PHP_BIN%
    echo Install PHP 8.4.1+ and add php.exe to PATH, then run this file again.
    pause
    exit /b 1
)

"%PHP_BIN%" -r "exit(PHP_VERSION_ID >= 80401 ? 0 : 1);"
if errorlevel 1 (
    echo Smart Basket needs PHP 8.4.1 or newer.
    pause
    exit /b 1
)

set "MOBILE_IP="
for /f "usebackq delims=" %%I in (`powershell -NoProfile -Command "$ip=$null; ipconfig | Select-String 'IPv4 Address' | ForEach-Object { if ($_.Line -match '(\d{1,3}(?:\.\d{1,3}){3})' -and $Matches[1] -notlike '127.*' -and $Matches[1] -notlike '169.254*' -and -not $ip) { $ip=$Matches[1] } }; Write-Output $ip"`) do set "MOBILE_IP=%%I"

if not defined MOBILE_IP (
    echo Could not find this computer's network IP address.
    echo Connect this computer to Wi-Fi or Ethernet and try again.
    pause
    exit /b 1
)

echo.
echo Smart Basket is starting for phone access.
echo On a phone connected to the same Wi-Fi, open:
echo http://%MOBILE_IP%:8000
echo.
echo Keep this window and the queue worker window open. If Windows Firewall asks, allow access on Private networks.
echo This project uses SQLite, so XAMPP MySQL is not needed for the local app.
echo Local HTTP can open the app, but browser GPS sharing requires HTTPS.
echo.

start "Smart Basket Queue Worker" cmd /k ""%PHP_BIN%" artisan queue:work --sleep=2 --tries=3 --timeout=120"
"%PHP_BIN%" artisan serve --host=0.0.0.0 --port=8000
pause

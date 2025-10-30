@echo off
echo Stopping any running servers...
taskkill /F /IM php.exe 2>nul

echo Clearing all Laravel caches...
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo.
echo All caches cleared! Now you can run:
echo php artisan serve
pause

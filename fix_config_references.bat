@echo off
REM Batch script to replace config.php with config_secure.php in all PHP files

echo Fixing config.php references...

cd /d c:\xampp\htdocs\bakery

REM Use PowerShell to do the replacement
powershell -Command "(Get-Content 'cart.php') -replace \"require_once\('config\.php'\)\", \"require_once('config_secure.php')\" | Set-Content 'cart.php'"
powershell -Command "(Get-Content 'index.php') -replace \"require_once\('config\.php'\)\", \"require_once('config_secure.php')\" | Set-Content 'index.php'"
powershell -Command "(Get-Content 'about.php') -replace \"require_once\('config\.php'\)\", \"require_once('config_secure.php')\" | Set-Content 'about.php'"
powershell -Command "(Get-Content 'contact.php') -replace \"require_once\('config\.php'\)\", \"require_once('config_secure.php')\" | Set-Content 'contact.php'"
powershell -Command "(Get-Content 'single_product.php') -replace \"require_once\('config\.php'\)\", \"require_once('config_secure.php')\" | Set-Content 'single_product.php'"
powershell -Command "(Get-Content 'account_users.php') -replace \"require_once\('config\.php'\)\", \"require_once('config_secure.php')\" | Set-Content 'account_users.php'"
powershell -Command "(Get-Content 'login_check_users.php') -replace \"require_once\('config\.php'\)\", \"require_once('config_secure.php')\" | Set-Content 'login_check_users.php'"
powershell -Command "(Get-Content 'insert_users.php') -replace \"require_once\('config\.php'\)\", \"require_once('config_secure.php')\" | Set-Content 'insert_users.php'"
powershell -Command "(Get-Content 'search.php') -replace \"require_once\('config\.php'\)\", \"require_once('config_secure.php')\" | Set-Content 'search.php'"

echo Done! All config.php references updated to config_secure.php
pause

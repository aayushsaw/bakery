# Bakery Shop - Security Implementation Guide

## 🔒 Security Updates Completed

This document outlines the security improvements implemented in the Bakery Shop application.

### ✅ Implemented Features

**PHP Compatibility:** All code is compatible with **PHP 5.6+** (tested with older XAMPP installations)

1. **Password Security**
   - All passwords are now hashed using PHP's `password_hash()` function (bcrypt)
   - Password verification using `password_verify()`
   - Minimum password length requirement (6 characters)

2. **SQL Injection Prevention**
   - All database queries converted to prepared statements
   - Input sanitization for all user inputs
   - Parameterized queries throughout the application

3. **CSRF Protection**
   - CSRF tokens generated for all forms (PHP 5.6+ compatible)
   - Token validation on form submissions
   - Tokens stored in secure sessions
   - Uses `openssl_random_pseudo_bytes()` with fallback for older PHP

4. **Session Security**
   - HTTPOnly cookies enabled
   - Secure flag for HTTPS connections
   - SameSite attribute set to 'Strict'
   - Session regeneration on login
   - Periodic session ID regeneration (every 30 minutes)

5. **Rate Limiting**
   - Login attempt limiting (5 attempts per 5 minutes)
   - Prevents brute force attacks
   - IP-based tracking

6. **Input Validation**
   - Email validation
   - Phone number validation (10 digits)
   - Username length validation
   - Address requirement validation

7. **Security Logging**
   - All security events logged to `logs/security.log`
   - Login attempts tracked
   - Failed authentication logged
   - CSRF violations logged

8. **Error Handling**
   - User-friendly error messages
   - Detailed errors logged server-side
   - No sensitive information exposed to users

## 📋 Installation Steps

### Step 1: Update Database Schema

Run the SQL script to update your database:

```bash
mysql -u root -p onlinecakeshop < database_updates.sql
```

Or import via phpMyAdmin:
1. Open phpMyAdmin
2. Select `onlinecakeshop` database
3. Go to "Import" tab
4. Choose `database_updates.sql`
5. Click "Go"

### Step 2: Migrate Existing Passwords (Optional - Skip if Fresh Install)

**IMPORTANT:** Only run this if you have existing users with plain-text passwords!

**If this is a fresh installation, skip this step.**

For existing installations:
1. Open your browser and navigate to: `http://localhost/bakery/migrate_passwords.php`
2. Review the warning message
3. Click "Proceed with Migration"
4. Wait for the migration to complete
5. **Delete the `migrate_passwords.php` file** after successful migration

**Note:** The migration script has been deleted in this installation as it was already run.

### Step 3: Update Forms with CSRF Tokens

Forms have been updated to include CSRF tokens. If you add new forms, include:

```php
<?php
require_once('includes/security.php');
init_secure_session();
?>

<form method="POST" action="your_handler.php">
    <?php echo csrf_token_field(); ?>
    <!-- Your form fields here -->
</form>
```

### Step 4: Test the Application

1. **Test User Registration:**
   - Go to `http://localhost/bakery/register.php`
   - Register a new user
   - Verify password is hashed in database

2. **Test User Login:**
   - Login with the newly created user
   - Verify successful authentication

3. **Test Admin Login:**
   - Go to `http://localhost/bakery/admin`
   - Login with admin credentials
   - Default: username: `admin`, password: `987654` (will be hashed after migration)

4. **Test Rate Limiting:**
   - Try logging in with wrong password 6 times
   - Verify you get rate limit error

## 🔧 Configuration

### Database Configuration

Edit `config_secure.php` to change database settings:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'onlinecakeshop');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### Security Settings

Adjust security settings in `includes/security.php`:

- **Rate Limiting:** Change `$max_attempts` and `$time_window` in `check_rate_limit()`
- **Session Timeout:** Modify the 1800 seconds (30 minutes) in `init_secure_session()`
- **Password Requirements:** Update validation in registration handlers

## 📁 New Files Created

- `config_secure.php` - Secure database configuration with PDO
- `includes/security.php` - Security helper functions (PHP 5.6+ compatible)
- `database_updates.sql` - Database schema updates
- ~~`migrate_passwords.php`~~ - One-time password migration script (deleted after use)
- `logs/.htaccess` - Protects log directory from web access
- `SECURITY_README.md` - This file
- `QUICKSTART.md` - Quick reference guide

## 🔄 Modified Files

### Authentication (Core Security)
- `insert_users.php` - Secure user registration
- `login_check_users.php` - Secure user login
- `admin/insert_admin.php` - Secure admin registration
- `admin/login_check.php` - Secure admin login

### Forms (CSRF Protection Added)
- `register.php` - User registration form
- `login_users.php` - User login form
- `admin/index.php` - Admin login form
- `admin/admin_signup.php` - Admin signup form

### Credits Updated (17 pages)
All footer credits changed to "Aayush Saw":
- User pages: `index.php`, `shop.php`, `cart.php`, `about.php`, `contact.php`, `single_product.php`
- Admin pages: `dashboard.php`, `view_category.php`, `view_product.php`, `view_users.php`, `view_orders.php`, `add_category.php`, `add_product.php`, `account_admin.php`

## 🛡️ Security Best Practices

1. **Keep Passwords Secure:**
   - Never store plain-text passwords
   - Use strong passwords (minimum 8 characters recommended)
   - Implement password complexity requirements if needed

2. **Regular Updates:**
   - Keep PHP and MySQL updated
   - Monitor security logs regularly
   - Review failed login attempts

3. **HTTPS:**
   - Use HTTPS in production
   - Enable secure cookie flag when using HTTPS

4. **Backup:**
   - Regular database backups
   - Keep backups secure and encrypted

5. **Monitoring:**
   - Check `logs/security.log` regularly
   - Set up alerts for suspicious activity
   - Monitor failed login attempts

## 🐛 Troubleshooting

### PHP Version Compatibility

**Issue: Syntax errors or "Call to undefined function" errors**

This application is compatible with **PHP 5.6+**. If you're running an older PHP version:

1. **Check your PHP version:**
   ```bash
   php -v
   ```

2. **Common compatibility fixes already implemented:**
   - ✅ Replaced `??` (null coalescing) with `isset() ? : ` ternary operators
   - ✅ Replaced `random_bytes()` with `openssl_random_pseudo_bytes()`
   - ✅ Replaced short array syntax `[]` with `array()` where needed

3. **If you still have issues:**
   - Update XAMPP to use PHP 7.0+ (recommended)
   - Or contact support with your PHP version number

### Issue: "Database connection failed"
- Check database credentials in `config_secure.php`
- Ensure MySQL service is running
- Verify database name is correct

### Issue: "CSRF validation failed"
- Clear browser cookies and sessions
- Ensure `includes/security.php` is included
- Check that form has CSRF token field

### Issue: "Rate limit exceeded"
- Wait 5 minutes before trying again
- Clear session data
- Check `$_SESSION['rate_limit']` array

### Issue: Login fails after migration
- Verify `database_updates.sql` was run successfully
- Check that `migrate_passwords.php` completed without errors
- Ensure password field is VARCHAR(255)

## 📞 Support

For issues or questions:
- Check the security logs: `logs/security.log`
- Review error logs in XAMPP control panel
- Verify all files are in correct locations

## ⚠️ Important Notes

1. **Delete `migrate_passwords.php`** after running it once
2. **Backup database** before making any changes
3. **Test thoroughly** before deploying to production
4. **Monitor logs** for suspicious activity
5. **Use HTTPS** in production environments

---

**Created By:** Aayush Saw
**Last Updated:** January 2026

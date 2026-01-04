# Bakery Shop - Complete Project Overview

## 📋 Project Information

**Project Name:** Online Cake Shop  
**Created By:** Aayush Saw  
**Technology Stack:** PHP, MySQL, Bootstrap, jQuery  
**PHP Compatibility:** PHP 5.6+ (tested and working)  
**Status:** Production-Ready (Authentication Layer)

---

## 🎯 What This Project Does

A full-featured online bakery e-commerce platform with:
- User registration and authentication
- Admin panel for management
- Product catalog with categories
- Shopping cart functionality
- Order management system
- Secure payment processing

---

## ✅ Recent Updates (January 2026)

### 1. Credits Update
All 17 pages updated with footer

### 2. Security Overhaul
- ✅ Password hashing (bcrypt)
- ✅ SQL injection prevention (prepared statements)
- ✅ CSRF protection (all forms)
- ✅ Session security (HTTPOnly, Secure, SameSite)
- ✅ Rate limiting (brute force protection)
- ✅ Input validation
- ✅ Security logging
- ✅ PHP 5.6+ compatibility

---

## 🚀 Quick Start

### Prerequisites
- XAMPP installed
- MySQL running
- PHP 5.6 or higher

### Installation (3 Steps)

**Step 1: Import Database**
```bash
# Via command line
mysql -u root -p onlinecakeshop < database_updates.sql

# Or via phpMyAdmin - Import database_updates.sql
```

**Step 2: Configure (Optional)**
Edit `config_secure.php` if needed (default works with XAMPP)

**Step 3: Access Application**
- **User Site:** `http://localhost/bakery`
- **Admin Panel:** `http://localhost/bakery/admin`

**Default Admin Credentials:**
- Username: `admin`
- Password: `987654`

---

## 📁 Project Structure

```
bakery/
├── admin/              # Admin panel (31 files)
│   ├── dashboard.php   # Admin dashboard
│   ├── view_*.php      # View management pages
│   ├── add_*.php       # Add new items
│   └── ...
├── includes/           # Security & helper functions
│   └── security.php    # CSRF, validation, logging
├── css/                # Stylesheets
├── js/                 # JavaScript files
├── logs/               # Security logs (protected)
├── uploads/            # Product images
├── index.php           # Home page
├── shop.php            # Product catalog
├── cart.php            # Shopping cart
├── register.php        # User registration
├── login_users.php     # User login
├── config_secure.php   # Database configuration
└── database_updates.sql # Schema updates
```

---

## 🔒 Security Features

| Feature | Status | Description |
|---------|--------|-------------|
| **Password Hashing** | ✅ | Bcrypt with `password_hash()` |
| **SQL Injection** | ✅ | Prepared statements (auth layer) |
| **CSRF Protection** | ✅ | Token-based validation |
| **Session Security** | ✅ | HTTPOnly, Secure, SameSite |
| **Rate Limiting** | ✅ | 5 attempts / 5 minutes |
| **Input Validation** | ✅ | Email, phone, password checks |
| **Security Logging** | ✅ | All events logged |
| **PHP Compatibility** | ✅ | Works with PHP 5.6+ |

---

## 📖 Documentation Files

- **`README.md`** - This file (project overview)
- **`SECURITY_README.md`** - Detailed security documentation
- **`QUICKSTART.md`** - Quick reference guide
- **`database_updates.sql`** - Database schema updates

---

## 🗄️ Database Schema

**Database Name:** `onlinecakeshop`

**Tables:**
1. `cake_shop_users_registrations` - Customer accounts
2. `cake_shop_admin_registrations` - Admin accounts
3. `cake_shop_category` - Product categories (Cakes, Pastries, Desserts, Cookies)
4. `cake_shop_product` - Product catalog
5. `cake_shop_orders` - Customer orders
6. `cake_shop_orders_detail` - Order line items

---

## 🎨 Features

### Customer Features
- Browse products by category
- View product details with image gallery
- Add to cart (session-based)
- User registration & login
- Place orders with delivery date
- Choose payment method (Cash/Card)

### Admin Features
- Dashboard with statistics
- User management (view, edit, delete)
- Category management (CRUD)
- Product management (CRUD with multi-image upload)
- Order management (view, edit, delete)
- Secure admin authentication

---

## 🔧 Configuration

### Database Settings
Edit `config_secure.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'onlinecakeshop');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### Security Settings
Edit `includes/security.php`:
- Rate limiting: Change `check_rate_limit()` parameters
- Session timeout: Modify 1800 seconds in `init_secure_session()`
- Password requirements: Update validation in auth handlers

---

## 🧪 Testing

### Test User Registration
1. Go to `http://localhost/bakery/register.php`
2. Fill in all fields
3. Submit form
4. Check database - password should be hashed

### Test User Login
1. Go to `http://localhost/bakery/login_users.php`
2. Login with registered credentials
3. Verify successful authentication

### Test Admin Access
1. Go to `http://localhost/bakery/admin`
2. Login with admin credentials
3. Access dashboard and management pages

### Test Security Features
- Try 6 failed login attempts → Should get rate limit error
- Try submitting form without CSRF token → Should fail
- Check `logs/security.log` for event logging

---

## ⚠️ Important Notes

1. **PHP Version:** Requires PHP 5.6 or higher
2. **HTTPS:** Use HTTPS in production for secure cookies
3. **Backup:** Always backup database before updates
4. **Logs:** Monitor `logs/security.log` regularly
5. **Passwords:** All passwords are now hashed (bcrypt)

---

## 🐛 Common Issues

**Issue:** "Call to undefined function"
- **Solution:** Check PHP version (must be 5.6+)

**Issue:** "Database connection failed"
- **Solution:** Verify MySQL is running and credentials in `config_secure.php`

**Issue:** "CSRF validation failed"
- **Solution:** Clear browser cookies and try again

**Issue:** Registration/Login not working
- **Solution:** Check that `includes/security.php` exists and is included

---

## 📞 Support

For detailed troubleshooting, see:
- `SECURITY_README.md` - Security implementation details
- `logs/security.log` - Security event logs
- XAMPP error logs - PHP/MySQL errors

---

## 🚀 Future Enhancements

Potential improvements (not yet implemented):
- Email verification for registration
- Password reset functionality
- Two-factor authentication
- Payment gateway integration
- Product search functionality
- Customer reviews and ratings
- Order tracking system
- Email notifications

---

## 📜 License

This is an educational/academic project.

---

**Last Updated:** January 2026  
**Version:** 2.0 (Security Hardened)  
**Maintained By:** Aayush Saw

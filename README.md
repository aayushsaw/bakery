# Bakery Shop - Main README

## 📋 Project Overview

**Online Cake Shop** - A fully-featured e-commerce platform for bakery products

**Created By:** Aayush Saw  
**Technology:** PHP, MySQL, Bootstrap 4  
**Version:** 2.0 (Production Ready)  
**GitHub:** https://github.com/aayushsaw/bakery

---

## ✨ Features

### Customer Features
- 🛍️ Browse products by category
- 🔍 Advanced product search with filters
- 🛒 Shopping cart management
- 👤 User registration & login
- ✉️ Email verification
- 🔐 Password reset functionality
- ⭐ Product reviews & ratings
- 📦 Order tracking with timeline
- 📜 Order history

### Admin Features
- 📊 Dashboard with statistics
- 👥 User management
- 📁 Category management (CRUD)
- 🍰 Product management (CRUD with images)
- 📋 Order management
- ✅ Review moderation
- 📈 Order status updates

### Security Features
- 🔒 Password hashing (bcrypt)
- 🛡️ SQL injection prevention (prepared statements)
- 🎫 CSRF protection on all forms
- 🔐 Secure session management
- ⏱️ Rate limiting (brute force protection)
- ✅ Input validation & sanitization
- 📝 Security event logging
- 🔑 PHP 5.6+ compatible

---

## 🚀 Quick Start

### Prerequisites
- XAMPP (or similar PHP/MySQL environment)
- PHP 5.6 or higher
- MySQL 5.6 or higher

### Installation (5 Steps)

**1. Clone Repository**
```bash
git clone https://github.com/aayushsaw/bakery.git
cd bakery
```

**2. Import Database**
```bash
# Via command line
mysql -u root -p onlinecakeshop < onlinecakeshop.sql
mysql -u root -p onlinecakeshop < database_updates.sql
mysql -u root -p onlinecakeshop < database_enhancements.sql

# Or via phpMyAdmin - Import all three SQL files
```

**3. Configure Database**
Edit `config_secure.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'onlinecakeshop');
define('DB_USER', 'root');
define('DB_PASS', '');
```

**4. Configure Email (Optional)**
Edit `includes/email_config.php`:
```php
define('MAIL_FROM_EMAIL', 'your-email@gmail.com');
define('APP_URL', 'http://localhost/bakery');
```

**5. Access Application**
- **User Site:** `http://localhost/bakery`
- **Admin Panel:** `http://localhost/bakery/admin`
  - Username: `admin`
  - Password: `987654`

---

## 📁 Project Structure

```
bakery/
├── admin/                  # Admin panel
│   ├── dashboard.php       # Admin dashboard
│   ├── view_*.php          # Management pages
│   ├── add_*.php           # Add new items
│   └── moderate_reviews.php # Review moderation
├── includes/               # Core functions
│   ├── security.php        # Security helpers
│   ├── email_config.php    # Email system
│   └── email_templates.php # Email templates
├── css/                    # Stylesheets
├── js/                     # JavaScript
├── logs/                   # Security logs (protected)
├── uploads/                # Product images
├── index.php               # Homepage
├── shop.php                # Product catalog
├── cart.php                # Shopping cart
├── search.php              # Product search
├── single_product.php      # Product details
├── register.php            # User registration
├── login_users.php         # User login
├── forgot_password.php     # Password reset
├── track_order.php         # Order tracking
├── order_history.php       # Order history
├── account_users.php       # User account
└── config_secure.php       # Database config
```

---

## 🗄️ Database Schema

**Database:** `onlinecakeshop`

**Tables:**
- `cake_shop_users_registrations` - Customer accounts
- `cake_shop_admin_registrations` - Admin accounts
- `cake_shop_category` - Product categories
- `cake_shop_product` - Products
- `cake_shop_orders` - Orders
- `cake_shop_orders_detail` - Order items
- `cake_shop_reviews` - Product reviews
- `cake_shop_payments` - Payment transactions
- `cake_shop_email_log` - Email logs

---

## 🧪 Testing

### Test User Registration
1. Go to `http://localhost/bakery/register.php`
2. Fill in registration form
3. Check email for verification link
4. Verify email and login

### Test Features
- ✅ Search for products
- ✅ Add products to cart
- ✅ Place an order
- ✅ Track order status
- ✅ Submit product review
- ✅ Admin: Approve reviews
- ✅ Admin: Update order status

---

## 📚 Documentation

### Available Guides
- **QUICKSTART.md** - Quick reference guide
- **SECURITY_README.md** - Security documentation
- **INTEGRATION_GUIDE.md** - Feature integration guide
- **DEPLOYMENT.md** - Production deployment guide
- **COMPLETE_SUMMARY.md** - Feature summary

### Code Documentation
- All functions are commented
- Security features documented
- Email templates customizable

---

## 🔐 Security

### Implemented Security Features
- Password hashing using bcrypt
- Prepared statements for SQL queries
- CSRF token validation
- Session security (HTTPOnly, SameSite)
- Rate limiting (5 attempts/5 minutes)
- Input validation & sanitization
- Security event logging
- Protected log directory

### Security Best Practices
- Never commit sensitive credentials
- Use HTTPS in production
- Regular security audits
- Keep dependencies updated
- Monitor security logs

---

## 🚀 Deployment

See `DEPLOYMENT.md` for complete production deployment guide.

### Quick Deployment Steps
1. Set up production server (HTTPS required)
2. Import database
3. Update configuration files
4. Configure email SMTP
5. Set file permissions
6. Test all features
7. Monitor logs

---

## 🐛 Troubleshooting

### Common Issues

**Database Connection Failed**
- Check MySQL is running
- Verify credentials in `config_secure.php`

**Emails Not Sending**
- Check SMTP configuration
- Verify email credentials
- Check spam folder

**CSRF Token Errors**
- Clear browser cookies
- Check session is started
- Verify `includes/security.php` is included

**PHP Compatibility**
- Requires PHP 5.6+
- Check `php -v`
- All code is backward compatible

---

## 📈 Features Roadmap

### Implemented ✅
- Email verification
- Password reset
- Product search
- Reviews & ratings
- Order tracking
- Admin moderation

### Future Enhancements (Optional)
- Payment gateway integration (Razorpay/Stripe)
- Two-factor authentication
- Email notifications (templates ready)
- Advanced analytics
- Inventory management
- Discount codes/coupons

---

## 🤝 Contributing

This is an educational project. Feel free to:
- Report bugs
- Suggest features
- Submit pull requests
- Improve documentation

---

## 📞 Support

### Getting Help
1. Check documentation files
2. Review `logs/security.log`
3. Check GitHub issues
4. Contact: aayushsaw13@gmail.com

---

## 📄 License

This project is for educational purposes.

---

## 🙏 Acknowledgments

- Bootstrap 4 for UI framework
- Font Awesome for icons
- PHP community for security best practices

---

## 📊 Project Statistics

- **Total Files:** 100+
- **Lines of Code:** 5,000+
- **Features:** 15+
- **Security Features:** 7
- **Database Tables:** 9
- **Documentation Pages:** 6

---

## 🎉 Version History

### Version 2.0 (January 2026) - Current
- Complete security overhaul
- Email verification system
- Password reset functionality
- Product search with filters
- Reviews & ratings system
- Order tracking
- Admin review moderation
- Comprehensive documentation

### Version 1.0 (Original)
- Basic e-commerce functionality
- Product catalog
- Shopping cart
- Order management

---

**Created By:** Aayush Saw  
**Last Updated:** January 2026  
**Status:** ✅ Production Ready  
**GitHub:** https://github.com/aayushsaw/bakery

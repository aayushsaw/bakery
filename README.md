# 🍰 Online Cake Shop - Bakery E-Commerce Platform

[![Live Demo](https://img.shields.io/badge/Live-Demo-success)](http://bakeryshop.infinityfreeapp.com/)
[![PHP](https://img.shields.io/badge/PHP-5.6%2B-blue)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-5.6%2B-orange)](https://www.mysql.com/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-4-purple)](https://getbootstrap.com/)

> A fully-featured e-commerce platform for bakery products with admin panel, user authentication, shopping cart, and order management.

**🌐 Live Demo:** [http://bakeryshop.infinityfreeapp.com/](http://bakeryshop.infinityfreeapp.com/)

**Created By:** Aayush Saw  
**GitHub:** [https://github.com/aayushsaw/bakery](https://github.com/aayushsaw/bakery)

---

## ✨ Features

### 🛍️ Customer Features
- **Product Browsing** - Browse products by category with beautiful UI
- **Advanced Search** - Search products with filters (price, category, rating)
- **Shopping Cart** - Smart cart with quantity management
- **User Authentication** - Secure registration & login with bcrypt
- **Email Verification** - Verify email addresses for security
- **Password Reset** - Forgot password functionality
- **Product Reviews** - Rate and review products (1-5 stars)
- **Order Tracking** - Track order status with timeline
- **Order History** - View past orders and details
- **User Profile** - Manage account information

### 👨‍💼 Admin Features
- **Dashboard** - Statistics and analytics overview
- **User Management** - View and manage customer accounts
- **Category Management** - CRUD operations for categories
- **Product Management** - Add, edit, delete products with images
- **Order Management** - View and update order status
- **Review Moderation** - Approve/reject customer reviews
- **Order Status Updates** - Update delivery status

### 🔐 Security Features
- **Password Hashing** - Bcrypt encryption for passwords
- **SQL Injection Prevention** - Prepared statements
- **CSRF Protection** - Token validation on all forms
- **Secure Sessions** - HTTPOnly and SameSite cookies
- **Rate Limiting** - Brute force protection (5 attempts/5 min)
- **Input Validation** - Sanitization of all user inputs
- **Security Logging** - Event logging for monitoring

---

## 🚀 Quick Start

### Prerequisites
- XAMPP (or LAMP/WAMP)
- PHP 5.6 or higher
- MySQL 5.6 or higher

### Installation

**1. Clone Repository**
```bash
git clone https://github.com/aayushsaw/bakery.git
cd bakery
```

**2. Import Database**
```bash
# Via MySQL command line
mysql -u root -p onlinecakeshop < onlinecakeshop.sql
mysql -u root -p onlinecakeshop < database_updates.sql
mysql -u root -p onlinecakeshop < database_enhancements.sql

# Or use phpMyAdmin - Import all three SQL files
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
│   └── moderate_reviews.php
├── includes/               # Core functions
│   ├── security.php        # Security helpers
│   ├── email_config.php    # Email configuration
│   └── email_templates.php # Email templates
├── css/                    # Stylesheets
│   ├── bootstrap.min.css
│   ├── style.css
│   └── toast.css           # Toast notifications
├── js/                     # JavaScript files
├── uploads/                # Product images
├── index.php               # Homepage
├── shop.php                # Product catalog
├── cart.php                # Shopping cart
├── single_product.php      # Product details
├── register.php            # User registration
├── login_users.php         # User login
├── insert_orders.php       # Order processing
└── config_secure.php       # Database config
```

---

## 🗄️ Database Schema

**Database:** `onlinecakeshop`

**Tables:**
- `cake_shop_users_registrations` - Customer accounts
- `cake_shop_admin_registrations` - Admin accounts
- `cake_shop_category` - Product categories
- `cake_shop_product` - Products with images
- `cake_shop_orders` - Customer orders
- `cake_shop_orders_detail` - Order line items
- `cake_shop_reviews` - Product reviews & ratings
- `cake_shop_payments` - Payment transactions
- `cake_shop_email_log` - Email activity logs

---

## 🎯 Future Scope & Enhancements

### 💳 Payment Integration (High Priority)
- **Razorpay Integration** - Indian payment gateway
- **Stripe Integration** - International payments
- **PayPal Support** - Global payment option
- **Cash on Delivery** - COD option with verification
- **Payment Status Tracking** - Real-time payment updates
- **Refund Management** - Automated refund processing

### 📱 Mobile & PWA
- **Progressive Web App** - Offline support
- **Mobile App** - React Native/Flutter app
- **Push Notifications** - Order updates via push
- **Mobile-First UI** - Optimized mobile experience

### 🎨 UI/UX Enhancements
- **Dark Mode** - Theme switcher
- **Product Zoom** - Image zoom on hover
- **360° Product View** - Interactive product images
- **Wishlist Feature** - Save favorite products
- **Product Comparison** - Compare multiple products
- **Quick View** - Product preview modal

### 📊 Analytics & Reporting
- **Sales Dashboard** - Revenue analytics
- **Customer Insights** - Behavior analysis
- **Inventory Reports** - Stock management
- **Popular Products** - Trending items
- **Revenue Forecasting** - Predictive analytics

### 🎁 Marketing Features
- **Discount Coupons** - Promotional codes
- **Flash Sales** - Limited time offers
- **Loyalty Program** - Reward points system
- **Referral System** - Refer & earn
- **Email Marketing** - Newsletter campaigns
- **SMS Notifications** - Order updates via SMS

### 🔔 Notification System
- **Real-time Notifications** - WebSocket integration
- **Email Notifications** - Order confirmations, shipping updates
- **SMS Alerts** - Delivery notifications
- **Admin Alerts** - New order notifications

### 🛡️ Advanced Security
- **Two-Factor Authentication (2FA)** - Enhanced login security
- **OAuth Integration** - Google/Facebook login
- **IP Whitelisting** - Admin panel protection
- **Advanced Rate Limiting** - DDoS protection
- **Security Audit Logs** - Detailed activity tracking

### 📦 Inventory & Logistics
- **Inventory Management** - Stock tracking
- **Low Stock Alerts** - Automated notifications
- **Supplier Management** - Vendor tracking
- **Shipping Integration** - Courier API integration
- **Delivery Tracking** - Real-time GPS tracking
- **Multi-warehouse Support** - Multiple locations

### 🌍 Internationalization
- **Multi-language Support** - i18n implementation
- **Multi-currency** - Currency conversion
- **Regional Pricing** - Location-based pricing
- **Tax Calculation** - GST/VAT automation

### 🤖 AI & Automation
- **Product Recommendations** - ML-based suggestions
- **Chatbot Support** - AI customer service
- **Demand Forecasting** - Predictive ordering
- **Automated Pricing** - Dynamic pricing algorithm

### 📈 Business Features
- **Vendor Dashboard** - Multi-vendor support
- **Subscription Plans** - Recurring orders
- **Gift Cards** - Digital gift certificates
- **Bulk Orders** - Corporate ordering
- **Invoice Generation** - Automated PDF invoices

---

## 🧪 Testing

### Test User Registration
1. Visit registration page
2. Fill in all required fields
3. Verify email (check inbox)
4. Login with credentials

### Test Features
- ✅ Browse products by category
- ✅ Search products with filters
- ✅ Add multiple items to cart
- ✅ Update cart quantities
- ✅ Place an order
- ✅ Track order status
- ✅ Submit product reviews
- ✅ Admin: Moderate reviews
- ✅ Admin: Update order status

---

## 🚀 Deployment

### Production Deployment (InfinityFree)
The live demo is hosted on InfinityFree: [http://bakeryshop.infinityfreeapp.com/](http://bakeryshop.infinityfreeapp.com/)

**Deployment Steps:**
1. Upload all files via FTP/File Manager
2. Import database via phpMyAdmin
3. Update `config_secure.php` with production credentials
4. Set proper file permissions
5. Test all features thoroughly

### Recommended Hosting
- **Shared Hosting:** InfinityFree, 000webhost
- **VPS:** DigitalOcean, Linode, AWS EC2
- **Managed:** Cloudways, Kinsta

---

## 🐛 Troubleshooting

### Common Issues

**Database Connection Failed**
- Check MySQL service is running
- Verify credentials in `config_secure.php`
- Ensure database exists

**Cart Not Working**
- Check `fetch_cart.php` is uploaded
- Verify session is started
- Clear browser cookies

**Registration Errors**
- Check field names match server expectations
- Verify `insert_users.php` is uploaded
- Check database table exists

**Login Issues**
- Verify `login_check_users.php` exists
- Check password hash in database
- Clear browser cache

---

## 📊 Project Statistics

- **Total Files:** 100+
- **Lines of Code:** 5,000+
- **Features:** 20+
- **Security Features:** 7
- **Database Tables:** 9
- **Admin Pages:** 15+

---

## 🤝 Contributing

Contributions are welcome! Please feel free to:
- Report bugs via GitHub Issues
- Suggest new features
- Submit pull requests
- Improve documentation

---

## 📄 License

This project is for educational purposes.

---

## 🙏 Acknowledgments

- Bootstrap 4 for responsive UI
- Font Awesome for icons
- jQuery for AJAX functionality
- PHP community for security best practices

---

## 📞 Contact

**Aayush Saw**  
📧 Email: aayushsaw13@gmail.com  
🔗 GitHub: [@aayushsaw](https://github.com/aayushsaw)  
🌐 Live Demo: [http://bakeryshop.infinityfreeapp.com/](http://bakeryshop.infinityfreeapp.com/)

---

## 🎉 Version History

### Version 2.0 (January 2026) - Current ✅
- Complete security overhaul
- Email verification system
- Password reset functionality
- Product search with filters
- Reviews & ratings system
- Order tracking with timeline
- Admin review moderation
- Smart cart with quantities
- Toast notifications
- **Live deployment on InfinityFree**

### Version 1.0 (Original)
- Basic e-commerce functionality
- Product catalog
- Shopping cart
- Order management

---

**⭐ Star this repository if you found it helpful!**

**Last Updated:** January 2026  
**Status:** ✅ Production Ready & Live  
**Live URL:** [http://bakeryshop.infinityfreeapp.com/](http://bakeryshop.infinityfreeapp.com/)

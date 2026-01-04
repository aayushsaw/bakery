# 🚀 Deployment & Production Checklist

## Overview

This guide helps you deploy your Bakery Shop to production with all security features enabled.

**Created By:** Aayush Saw  
**Last Updated:** January 2026

---

## ✅ Pre-Deployment Checklist

### 1. Database Preparation
- [ ] Backup current database
- [ ] Run `database_enhancements.sql` on production database
- [ ] Verify all tables created successfully
- [ ] Check indexes are in place
- [ ] Test database connection

### 2. Security Configuration
- [ ] Change database credentials in `config_secure.php`
- [ ] Update `APP_URL` in `includes/email_config.php`
- [ ] Enable HTTPS (SSL certificate required)
- [ ] Update session cookie settings for production
- [ ] Review and update SMTP settings

### 3. Email Configuration
- [ ] Set up production SMTP server (Gmail, SendGrid, etc.)
- [ ] Update email credentials in `includes/email_config.php`
- [ ] Test email sending
- [ ] Verify all email templates work

### 4. File Permissions
```bash
# Set proper permissions
chmod 755 /path/to/bakery
chmod 644 /path/to/bakery/*.php
chmod 755 /path/to/bakery/uploads
chmod 755 /path/to/bakery/logs
chmod 644 /path/to/bakery/logs/.htaccess
```

### 5. Remove Development Files
- [ ] Delete `migrate_passwords.php` (if not already deleted)
- [ ] Delete `test_email.php` (if created)
- [ ] Remove any debug code
- [ ] Disable error display (set `display_errors = Off` in php.ini)

---

## 🔐 Production Security Settings

### Update `config_secure.php`
```php
// Production database credentials
define('DB_HOST', 'your-production-host');
define('DB_NAME', 'your-production-db');
define('DB_USER', 'your-production-user');
define('DB_PASS', 'your-strong-password');
```

### Update `includes/email_config.php`
```php
// Production email settings
define('MAIL_FROM_EMAIL', 'noreply@yourdomain.com');
define('APP_URL', 'https://yourdomain.com');

// SMTP Configuration (example for Gmail)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'your-email@gmail.com');
define('SMTP_PASSWORD', 'your-app-password');
```

### Enable HTTPS
```php
// In includes/security.php - already configured
// Session cookies will automatically use Secure flag when HTTPS is detected
```

---

## 🧪 Production Testing

### Test All Features
1. **Registration Flow**
   - [ ] Register new user
   - [ ] Receive verification email
   - [ ] Click verification link
   - [ ] Login successfully

2. **Password Reset**
   - [ ] Request password reset
   - [ ] Receive reset email
   - [ ] Reset password
   - [ ] Login with new password

3. **Product Search**
   - [ ] Search for products
   - [ ] Apply filters
   - [ ] View results

4. **Shopping & Orders**
   - [ ] Add products to cart
   - [ ] Place order
   - [ ] Track order
   - [ ] View order history

5. **Reviews**
   - [ ] Submit product review
   - [ ] Admin approves review
   - [ ] Review appears on product page

6. **Admin Functions**
   - [ ] Login to admin panel
   - [ ] Manage products
   - [ ] Manage orders
   - [ ] Moderate reviews
   - [ ] Update order status

---

## 📊 Performance Optimization

### Database Optimization
```sql
-- Optimize tables
OPTIMIZE TABLE cake_shop_users_registrations;
OPTIMIZE TABLE cake_shop_product;
OPTIMIZE TABLE cake_shop_orders;
OPTIMIZE TABLE cake_shop_reviews;

-- Analyze tables
ANALYZE TABLE cake_shop_users_registrations;
ANALYZE TABLE cake_shop_product;
```

### Enable Caching
```php
// Add to config_secure.php
ini_set('opcache.enable', 1);
ini_set('opcache.memory_consumption', 128);
```

### Image Optimization
- Compress product images before upload
- Use appropriate image formats (WebP, JPEG)
- Implement lazy loading for images

---

## 🔒 Security Hardening

### 1. File Upload Security
```php
// Already implemented in product upload
// Verify file types
// Limit file sizes
// Sanitize filenames
```

### 2. Rate Limiting
```php
// Already implemented in includes/security.php
// 5 login attempts per 5 minutes
// Adjust if needed for production
```

### 3. HTTPS Enforcement
```apache
# Add to .htaccess
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### 4. Security Headers
```apache
# Add to .htaccess
Header set X-Content-Type-Options "nosniff"
Header set X-Frame-Options "SAMEORIGIN"
Header set X-XSS-Protection "1; mode=block"
Header set Referrer-Policy "strict-origin-when-cross-origin"
```

---

## 📧 Email Service Setup

### Option 1: Gmail SMTP
1. Enable 2-factor authentication
2. Generate app password
3. Use in `email_config.php`

### Option 2: SendGrid
1. Sign up at sendgrid.com
2. Get API key
3. Update email configuration

### Option 3: Mailgun
1. Sign up at mailgun.com
2. Verify domain
3. Get SMTP credentials

---

## 🗄️ Backup Strategy

### Database Backup
```bash
# Daily backup script
mysqldump -u username -p database_name > backup_$(date +%Y%m%d).sql

# Automated with cron
0 2 * * * /path/to/backup-script.sh
```

### File Backup
```bash
# Backup uploads directory
tar -czf uploads_backup_$(date +%Y%m%d).tar.gz /path/to/uploads

# Backup entire application
tar -czf bakery_backup_$(date +%Y%m%d).tar.gz /path/to/bakery
```

---

## 📈 Monitoring

### Log Monitoring
```bash
# Check security logs
tail -f /path/to/bakery/logs/security.log

# Check email logs
SELECT * FROM cake_shop_email_log WHERE status = 'Failed' ORDER BY sent_at DESC LIMIT 10;
```

### Performance Monitoring
- Monitor database query performance
- Check server resource usage
- Monitor email delivery rates
- Track user registration/login patterns

---

## 🚨 Incident Response

### If Security Issue Detected
1. Check `logs/security.log`
2. Identify affected accounts
3. Force password reset if needed
4. Block suspicious IPs
5. Review and patch vulnerability

### If Email Issues
1. Check `cake_shop_email_log` table
2. Verify SMTP credentials
3. Check spam folder
4. Test with different email provider

---

## 🎯 Go-Live Checklist

### Final Steps Before Launch
- [ ] All features tested
- [ ] SSL certificate installed
- [ ] Email sending verified
- [ ] Database backed up
- [ ] Admin account secured
- [ ] Default passwords changed
- [ ] Error logging enabled
- [ ] Monitoring set up
- [ ] Backup strategy in place
- [ ] Documentation reviewed

### Post-Launch
- [ ] Monitor logs for first 24 hours
- [ ] Test all critical features
- [ ] Verify email delivery
- [ ] Check database performance
- [ ] Monitor user feedback

---

## 📞 Support & Maintenance

### Regular Maintenance Tasks
- **Daily:** Check security logs
- **Weekly:** Review email logs, check disk space
- **Monthly:** Database optimization, backup verification
- **Quarterly:** Security audit, dependency updates

### Update Strategy
1. Test updates in staging environment
2. Backup production database
3. Deploy during low-traffic hours
4. Monitor for issues
5. Rollback if needed

---

## 🎉 You're Ready!

Your Bakery Shop is production-ready with:
- ✅ Enterprise-level security
- ✅ All modern e-commerce features
- ✅ Complete documentation
- ✅ Monitoring and logging
- ✅ Backup strategy

**Good luck with your launch!** 🚀

---

**Created By:** Aayush Saw  
**Version:** 2.0 Production  
**Date:** January 2026

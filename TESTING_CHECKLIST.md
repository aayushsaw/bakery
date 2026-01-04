# 🧪 Complete Testing Checklist

## Overview
This checklist ensures all features are working correctly before deployment.

**Created By:** Aayush Saw  
**Date:** January 2026  
**Test Environment:** http://localhost/bakery

---

## ✅ Pre-Testing Setup

### 1. Database Verification
```sql
-- Check all tables exist
SHOW TABLES LIKE 'cake_shop_%';

-- Verify new columns
DESCRIBE cake_shop_users_registrations;
DESCRIBE cake_shop_orders;
DESCRIBE cake_shop_reviews;

-- Check sample data
SELECT COUNT(*) FROM cake_shop_product;
SELECT COUNT(*) FROM cake_shop_users_registrations;
```

### 2. File Verification
- [ ] All PHP files have no syntax errors
- [ ] `config_secure.php` has correct database credentials
- [ ] `includes/email_config.php` is configured
- [ ] `logs/` directory exists and is writable
- [ ] `uploads/` directory exists and is writable

---

## 🔐 Security Features Testing

### Test 1: User Registration with Email Verification
**URL:** `http://localhost/bakery/register.php`

**Steps:**
1. Fill registration form with test data
   - Username: `testuser1`
   - Email: `test@example.com`
   - Password: `Test123!`
   - Mobile: `1234567890`
   - Address: `Test Address`

2. Submit form

**Expected Results:**
- ✅ Form submits successfully
- ✅ Redirected to login page with success message
- ✅ Check database: User created with `email_verified = 0`
- ✅ Check database: `email_verification_token` is set
- ✅ Email sent (check logs if mail() doesn't work locally)

**Verification:**
```sql
SELECT users_id, users_username, users_email, email_verified, email_verification_token 
FROM cake_shop_users_registrations 
WHERE users_email = 'test@example.com';
```

**Status:** [ ] PASS / [ ] FAIL

---

### Test 2: Email Verification
**URL:** `http://localhost/bakery/verify_email.php?token=YOUR_TOKEN`

**Steps:**
1. Get token from database (from Test 1)
2. Visit verification URL with token
3. Check result

**Expected Results:**
- ✅ Success message displayed
- ✅ Redirected to login page
- ✅ Database updated: `email_verified = 1`
- ✅ Token cleared from database

**Verification:**
```sql
SELECT email_verified, email_verified_at, email_verification_token 
FROM cake_shop_users_registrations 
WHERE users_email = 'test@example.com';
```

**Status:** [ ] PASS / [ ] FAIL

---

### Test 3: User Login
**URL:** `http://localhost/bakery/login_users.php`

**Steps:**
1. Enter username: `testuser1`
2. Enter password: `Test123!`
3. Submit form

**Expected Results:**
- ✅ Login successful
- ✅ Redirected to homepage
- ✅ Session created
- ✅ Username displayed in navigation
- ✅ Security log entry created

**Verification:**
```sql
SELECT * FROM cake_shop_email_log ORDER BY sent_at DESC LIMIT 5;
```

**Check:** `logs/security.log` for login event

**Status:** [ ] PASS / [ ] FAIL

---

### Test 4: Password Reset Flow
**URL:** `http://localhost/bakery/forgot_password.php`

**Steps:**
1. Click "Forgot Password" on login page
2. Enter email: `test@example.com`
3. Submit form
4. Check database for reset token
5. Visit reset link with token
6. Enter new password: `NewPass123!`
7. Submit and try logging in

**Expected Results:**
- ✅ Reset email sent
- ✅ Token saved in database
- ✅ Reset form displays
- ✅ Password updated successfully
- ✅ Can login with new password
- ✅ Old password doesn't work

**Verification:**
```sql
SELECT reset_token, reset_token_expires 
FROM cake_shop_users_registrations 
WHERE users_email = 'test@example.com';
```

**Status:** [ ] PASS / [ ] FAIL

---

## 🛍️ E-Commerce Features Testing

### Test 5: Product Search
**URL:** `http://localhost/bakery/`

**Steps:**
1. Use search bar in navigation
2. Search for "cake"
3. Apply category filter
4. Apply price range filter

**Expected Results:**
- ✅ Search bar visible on all pages
- ✅ Search returns relevant results
- ✅ Category filter works
- ✅ Price filter works
- ✅ Results display correctly

**Test Queries:**
- "cake"
- "chocolate"
- "birthday"

**Status:** [ ] PASS / [ ] FAIL

---

### Test 6: Shopping Cart & Checkout
**URL:** `http://localhost/bakery/shop.php`

**Steps:**
1. Browse products
2. Add 2-3 products to cart
3. View cart
4. Update quantities
5. Proceed to checkout
6. Fill delivery details
7. Place order

**Expected Results:**
- ✅ Products added to cart
- ✅ Cart count updates
- ✅ Can update quantities
- ✅ Total calculated correctly
- ✅ Order placed successfully
- ✅ Order saved in database

**Verification:**
```sql
SELECT * FROM cake_shop_orders ORDER BY created_at DESC LIMIT 1;
SELECT * FROM cake_shop_orders_detail WHERE orders_id = LAST_INSERT_ID();
```

**Status:** [ ] PASS / [ ] FAIL

---

### Test 7: Order Tracking
**URL:** `http://localhost/bakery/account_users.php`

**Steps:**
1. Login as user
2. Go to "My Account"
3. View order history
4. Click "Track" button on an order
5. View order timeline

**Expected Results:**
- ✅ Order history displays
- ✅ Track button visible
- ✅ Tracking page shows order details
- ✅ Timeline displays current status
- ✅ Status badge shows correct color

**Status:** [ ] PASS / [ ] FAIL

---

### Test 8: Product Reviews
**URL:** `http://localhost/bakery/single_product.php?product_id=1`

**Steps:**
1. Login as user
2. Go to any product page
3. Scroll to review section
4. Submit a review with:
   - Rating: 5 stars
   - Title: "Excellent product!"
   - Review: "This cake was amazing!"
5. Check review status

**Expected Results:**
- ✅ Review form displays for logged-in users
- ✅ Review submits successfully
- ✅ Message shows "pending approval"
- ✅ Review saved in database with `approved = 0`
- ✅ Can't submit duplicate review

**Verification:**
```sql
SELECT * FROM cake_shop_reviews ORDER BY created_at DESC LIMIT 1;
```

**Status:** [ ] PASS / [ ] FAIL

---

## 👨‍💼 Admin Features Testing

### Test 9: Admin Login
**URL:** `http://localhost/bakery/admin/index.php`

**Steps:**
1. Enter username: `admin`
2. Enter password: `987654`
3. Submit form

**Expected Results:**
- ✅ Login successful
- ✅ Redirected to dashboard
- ✅ Admin session created

**Status:** [ ] PASS / [ ] FAIL

---

### Test 10: Review Moderation
**URL:** `http://localhost/bakery/admin/moderate_reviews.php`

**Steps:**
1. Login as admin
2. Click "Moderate Reviews" in sidebar
3. View pending reviews
4. Approve a review
5. Check product page

**Expected Results:**
- ✅ Link visible in admin sidebar
- ✅ Pending reviews display
- ✅ Can approve reviews
- ✅ Approved review appears on product page
- ✅ Average rating updates

**Verification:**
```sql
SELECT * FROM cake_shop_reviews WHERE approved = 1;
SELECT product_id, average_rating, total_reviews FROM cake_shop_product WHERE product_id = 1;
```

**Status:** [ ] PASS / [ ] FAIL

---

### Test 11: Order Management
**URL:** `http://localhost/bakery/admin/view_orders.php`

**Steps:**
1. Login as admin
2. Go to "View Orders"
3. Find an order
4. Change status dropdown (Pending → Processing)
5. Verify update

**Expected Results:**
- ✅ Orders display in table
- ✅ Status dropdown visible
- ✅ Status updates on change
- ✅ Page reloads with new status
- ✅ Status badge color changes

**Verification:**
```sql
SELECT orders_id, order_status, updated_at FROM cake_shop_orders ORDER BY updated_at DESC LIMIT 5;
```

**Status:** [ ] PASS / [ ] FAIL

---

## 🔒 Security Testing

### Test 12: CSRF Protection
**Steps:**
1. Try submitting any form without CSRF token
2. Try submitting with invalid token

**Expected Results:**
- ✅ Form rejected without token
- ✅ Form rejected with invalid token
- ✅ Error message displayed

**Status:** [ ] PASS / [ ] FAIL

---

### Test 13: SQL Injection Prevention
**Steps:**
1. Try login with: `admin' OR '1'='1`
2. Try search with: `'; DROP TABLE users; --`

**Expected Results:**
- ✅ No SQL errors
- ✅ Invalid login message
- ✅ No data returned
- ✅ Tables still exist

**Status:** [ ] PASS / [ ] FAIL

---

### Test 14: Rate Limiting
**Steps:**
1. Try logging in with wrong password 6 times
2. Check if blocked

**Expected Results:**
- ✅ After 5 attempts, account locked
- ✅ Error message displayed
- ✅ Must wait 5 minutes

**Verification:**
Check `logs/security.log` for rate limit entries

**Status:** [ ] PASS / [ ] FAIL

---

### Test 15: Session Security
**Steps:**
1. Login
2. Check browser cookies
3. Try accessing admin without login

**Expected Results:**
- ✅ Session cookie has HTTPOnly flag
- ✅ Session cookie has SameSite attribute
- ✅ Redirected to login when not authenticated

**Status:** [ ] PASS / [ ] FAIL

---

## 📧 Email System Testing

### Test 16: Email Logging
**Steps:**
1. Trigger any email (registration, password reset)
2. Check email log table

**Expected Results:**
- ✅ Email logged in database
- ✅ Status recorded (sent/failed)
- ✅ Timestamp recorded

**Verification:**
```sql
SELECT * FROM cake_shop_email_log ORDER BY sent_at DESC LIMIT 10;
```

**Status:** [ ] PASS / [ ] FAIL

---

## 📱 UI/UX Testing

### Test 17: Responsive Design
**Steps:**
1. Test on different screen sizes
2. Check mobile view
3. Check tablet view

**Expected Results:**
- ✅ Navigation collapses on mobile
- ✅ Search bar works on mobile
- ✅ Forms are usable
- ✅ Images scale properly

**Status:** [ ] PASS / [ ] FAIL

---

### Test 18: Navigation
**Steps:**
1. Test all navigation links
2. Test breadcrumbs
3. Test back buttons

**Expected Results:**
- ✅ All links work
- ✅ No 404 errors
- ✅ Breadcrumbs accurate
- ✅ Back navigation works

**Status:** [ ] PASS / [ ] FAIL

---

## 🗄️ Database Integrity

### Test 19: Foreign Keys
**Steps:**
1. Try deleting a user with orders
2. Try deleting a product with reviews

**Expected Results:**
- ✅ Foreign key constraints enforced
- ✅ Cannot delete referenced records
- ✅ Error message displayed

**Verification:**
```sql
SHOW CREATE TABLE cake_shop_orders;
SHOW CREATE TABLE cake_shop_reviews;
```

**Status:** [ ] PASS / [ ] FAIL

---

### Test 20: Data Validation
**Steps:**
1. Try registering with invalid email
2. Try submitting review with 0 stars
3. Try ordering with negative quantity

**Expected Results:**
- ✅ Invalid data rejected
- ✅ Validation messages displayed
- ✅ No invalid data in database

**Status:** [ ] PASS / [ ] FAIL

---

## 📊 Performance Testing

### Test 21: Page Load Times
**Steps:**
1. Clear browser cache
2. Load homepage
3. Load shop page
4. Load product page

**Expected Results:**
- ✅ Homepage loads < 2 seconds
- ✅ Shop page loads < 3 seconds
- ✅ Product page loads < 2 seconds
- ✅ No console errors

**Status:** [ ] PASS / [ ] FAIL

---

### Test 22: Database Queries
**Steps:**
1. Enable MySQL slow query log
2. Browse site
3. Check for slow queries

**Expected Results:**
- ✅ No queries > 1 second
- ✅ Indexes being used
- ✅ No N+1 query problems

**Status:** [ ] PASS / [ ] FAIL

---

## 🎯 Final Verification

### GitHub Repository
- [ ] All files committed
- [ ] No uncommitted changes
- [ ] README.md updated
- [ ] Documentation complete

**Verify:**
```bash
git status
git log --oneline -10
```

### File Structure
- [ ] All feature files present
- [ ] No test files in production
- [ ] Logs directory protected
- [ ] Uploads directory writable

### Configuration
- [ ] Database credentials correct
- [ ] Email settings configured
- [ ] APP_URL set correctly
- [ ] Error reporting appropriate

---

## 📋 Test Summary

**Total Tests:** 22  
**Passed:** ___  
**Failed:** ___  
**Skipped:** ___  

**Critical Issues:** ___  
**Minor Issues:** ___  

---

## 🚀 Deployment Readiness

### Before Going Live
- [ ] All tests passed
- [ ] Database backed up
- [ ] SSL certificate installed
- [ ] SMTP configured
- [ ] Error logging enabled
- [ ] Security headers set
- [ ] Performance optimized

### Post-Deployment
- [ ] Monitor logs for 24 hours
- [ ] Test all features in production
- [ ] Verify email delivery
- [ ] Check database performance
- [ ] Monitor user feedback

---

## 🐛 Known Issues

Document any issues found during testing:

1. **Issue:** _______________
   **Severity:** High / Medium / Low
   **Status:** Open / Fixed
   **Notes:** _______________

---

**Tested By:** _______________  
**Date:** _______________  
**Environment:** Local / Staging / Production  
**Status:** ✅ Ready / ⚠️ Issues Found / ❌ Not Ready

---

**Created By:** Aayush Saw  
**Version:** 2.0  
**Last Updated:** January 2026

# 🚀 InfinityFree Deployment Guide

## Your Domain
**URL:** https://bakeryshop.infinityfreeapp.com

---

## 📋 Step-by-Step Deployment

### **Step 1: Prepare Your Files** (5 minutes)

1. **Create a ZIP file:**
   - Go to: `c:\xampp\htdocs\bakery`
   - Select ALL files and folders
   - Right-click → "Send to" → "Compressed (zipped) folder"
   - Name it: `bakery.zip`

2. **Files to include:**
   - ✅ All `.php` files
   - ✅ `css/`, `js/`, `uploads/` folders
   - ✅ `includes/` folder
   - ✅ `admin/` folder
   - ❌ **EXCLUDE:** `logs/` folder (will create new)
   - ❌ **EXCLUDE:** `.git/` folder

---

### **Step 2: Login to InfinityFree** (2 minutes)

1. Go to: https://infinityfree.net
2. Click "Client Area" (top right)
3. Login with your credentials
4. Click on your account: `bakeryshop.infinityfreeapp.com`

---

### **Step 3: Upload Files** (10 minutes)

1. **Open File Manager:**
   - In control panel, click "Online File Manager"
   - Or click "File Manager" icon

2. **Navigate to htdocs:**
   - Click on `htdocs` folder
   - This is where your website files go

3. **Upload ZIP:**
   - Click "Upload" button
   - Select `bakery.zip`
   - Wait for upload to complete (may take 5-10 minutes)

4. **Extract ZIP:**
   - Right-click on `bakery.zip`
   - Click "Extract"
   - Wait for extraction
   - Delete `bakery.zip` after extraction

5. **Move files to root:**
   - Open the `bakery` folder
   - Select ALL files inside
   - Click "Move"
   - Move to `/htdocs/` (one level up)
   - Delete empty `bakery` folder

**Your structure should be:**
```
htdocs/
  ├── index.php
  ├── admin/
  ├── includes/
  ├── css/
  ├── js/
  ├── uploads/
  └── ... (all other files)
```

---

### **Step 4: Create Database** (5 minutes)

1. **Go to MySQL Databases:**
   - In control panel, click "MySQL Databases"

2. **Create Database:**
   - Database Name: `bakery_db` (or any name)
   - Click "Create Database"
   - **IMPORTANT:** Note these details:
     ```
     Database Name: epiz_XXXXXXXX_bakery_db
     Username: epiz_XXXXXXXX
     Password: [your password]
     Hostname: sqlXXX.infinityfree.com
     ```

3. **Save these credentials** - you'll need them!

---

### **Step 5: Import Database** (5 minutes)

1. **Open phpMyAdmin:**
   - In control panel, click "phpMyAdmin"
   - Login automatically

2. **Select Database:**
   - Click on your database name (left sidebar)
   - Example: `epiz_XXXXXXXX_bakery_db`

3. **Import SQL files:**
   
   **First file:**
   - Click "Import" tab
   - Click "Choose File"
   - Select: `c:\xampp\htdocs\bakery\onlinecakeshop.sql`
   - Click "Go" (bottom)
   - Wait for success message

   **Second file:**
   - Click "Import" tab again
   - Click "Choose File"
   - Select: `c:\xampp\htdocs\bakery\database_enhancements.sql`
   - Click "Go"
   - Wait for success message

4. **Verify:**
   - Click on your database name
   - You should see tables like:
     - `cake_shop_users_registrations`
     - `cake_shop_product`
     - `cake_shop_reviews`
     - `cake_shop_orders`
     - etc.

---

### **Step 6: Update Configuration** (3 minutes)

1. **Edit config file:**
   - In File Manager, navigate to `htdocs/`
   - Find `config_secure.php`
   - Right-click → "Edit" or "Code Edit"

2. **Update these lines:**
   ```php
   <?php
   // Database Configuration
   $db_host = "sqlXXX.infinityfree.com";  // Change this
   $db_user = "epiz_XXXXXXXX";             // Change this
   $db_pass = "your_password";             // Change this
   $db_name = "epiz_XXXXXXXX_bakery_db";   // Change this
   
   // Connect to database
   $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
   
   if (!$conn) {
       die("Connection failed: " . mysqli_connect_error());
   }
   ?>
   ```

3. **Save the file**

---

### **Step 7: Update Email Configuration** (2 minutes)

1. **Edit email config:**
   - In File Manager, go to `htdocs/includes/`
   - Find `email_config.php`
   - Right-click → "Edit"

2. **Update APP_URL:**
   ```php
   define('APP_URL', 'https://bakeryshop.infinityfreeapp.com');
   ```

3. **Save the file**

---

### **Step 8: Create Logs Directory** (1 minute)

1. **In File Manager:**
   - Navigate to `htdocs/`
   - Click "New Folder"
   - Name: `logs`
   - Create it

2. **Set permissions:**
   - Right-click on `logs` folder
   - Click "Permissions" or "Change Permissions"
   - Set to: `755` or `777`

---

### **Step 9: Test Your Website** (5 minutes)

1. **Visit your site:**
   - Open browser
   - Go to: https://bakeryshop.infinityfreeapp.com

2. **Check homepage:**
   - ✅ Should load without errors
   - ✅ Should show products
   - ✅ Navigation should work

3. **Test registration:**
   - Click "Register"
   - Create a test account
   - Check if it works

4. **Test admin:**
   - Go to: https://bakeryshop.infinityfreeapp.com/admin
   - Login: `admin` / `987654`
   - Check dashboard

---

### **Step 10: Change Admin Password** (2 minutes)

**IMPORTANT:** Change default password!

1. **Login as admin**
2. Go to admin account settings
3. Change password from `987654` to something secure
4. Save

---

## ✅ **Deployment Checklist**

- [ ] Files uploaded to `htdocs/`
- [ ] Database created
- [ ] SQL files imported
- [ ] `config_secure.php` updated
- [ ] `email_config.php` updated
- [ ] `logs/` folder created
- [ ] Website loads at https://bakeryshop.infinityfreeapp.com
- [ ] Registration works
- [ ] Admin login works
- [ ] Admin password changed

---

## 🐛 **Troubleshooting**

### **Problem: Website shows "Database connection error"**
**Solution:**
- Check `config_secure.php` credentials
- Make sure database name, username, password are correct
- Verify hostname (sqlXXX.infinityfree.com)

### **Problem: "404 Not Found" errors**
**Solution:**
- Make sure files are in `htdocs/` (not in `htdocs/bakery/`)
- Check file names are correct (case-sensitive)

### **Problem: Images not loading**
**Solution:**
- Check `uploads/` folder exists
- Verify image files are uploaded
- Check file permissions

### **Problem: Email not sending**
**Solution:**
- InfinityFree has email limitations
- Emails may go to spam
- Consider using SMTP (Gmail, SendGrid)

---

## 📊 **What's Working**

After deployment, these features work:
- ✅ User registration (email verification may be limited)
- ✅ Login/Logout
- ✅ Product browsing
- ✅ Search functionality
- ✅ Shopping cart
- ✅ Order placement
- ✅ Order tracking
- ✅ Product reviews
- ✅ Admin panel
- ✅ Review moderation

---

## ⚠️ **InfinityFree Limitations**

**Be aware:**
- 📧 Email sending is limited (use SMTP for production)
- ⏱️ May have occasional downtime
- 🚀 Performance may be slower than paid hosting
- 💾 Storage: 5GB (should be enough)
- 📊 Bandwidth: Unlimited

**For better performance, consider upgrading to paid hosting later.**

---

## 🎉 **Congratulations!**

Your bakery shop is now **LIVE** at:
**https://bakeryshop.infinityfreeapp.com**

Share it with friends and family! 🎂🍰

---

## 📞 **Need Help?**

If you get stuck:
1. Check the troubleshooting section above
2. Verify all steps were completed
3. Check InfinityFree documentation
4. Ask me for help!

---

**Created By:** Aayush Saw  
**Deployed:** January 2026  
**Hosting:** InfinityFree  
**Status:** 🚀 LIVE

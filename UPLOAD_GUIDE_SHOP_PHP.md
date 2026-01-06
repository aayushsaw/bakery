# 📤 UPLOAD SHOP.PHP - Step-by-Step Guide

## 🎯 What We're Fixing

**Problem:** Categories not showing in Shop dropdown  
**Cause:** Line 58 in `shop.php` has wrong config file reference  
**Fix:** Already applied locally - now need to upload!

---

## 📋 Upload Instructions

### Step 1: Login to InfinityFree
1. Go to: **https://dash.infinityfree.com/login**
2. Enter your credentials
3. Click "Login"

![InfinityFree Login](file:///C:/Users/ASUS/.gemini/antigravity/brain/fbbbc988-64a1-40f6-835a-3fea8c1b6a3e/infinityfree_login_page_1767682806474.png)

---

### Step 2: Access File Manager
1. Select your hosting account from dashboard
2. Click **"Control Panel"** button
3. Scroll to **"Files"** section
4. Click **"Online File Manager"**

---

### Step 3: Navigate to htdocs
1. In File Manager, double-click **`htdocs`** folder
2. You should see your website files (index.php, shop.php, etc.)

---

### Step 4: Upload Fixed shop.php
1. Click **"Upload"** button (usually blue arrow or cloud icon)
2. Click **"Upload File"** or **"Choose File"**
3. Browse to: `C:\xampp\htdocs\bakery\shop.php`
4. Select the file and upload
5. **Confirm overwrite** when prompted

---

### Step 5: Verify Categories Appear
1. Visit: **https://bakeryshop.infinityfreeapp.com/shop.php**
2. Click **"Shop"** in the navigation menu
3. **You should now see 5 categories:**
   - ✅ Cakes
   - ✅ Pastries
   - ✅ Desserts
   - ✅ Cookies
   - ✅ Test Category

---

## 📸 Current State (Before Upload)

![Shop Page - Blank](file:///C:/Users/ASUS/.gemini/antigravity/brain/fbbbc988-64a1-40f6-835a-3fea8c1b6a3e/live_shop_before_fix_1767682800301.png)

**Current Issue:** Shop page is blank because of the config error.

---

## ✅ Expected Result (After Upload)

After uploading the fixed `shop.php`:
- ✅ Shop page loads properly
- ✅ Navigation dropdown shows 5 categories
- ✅ Clicking a category filters products
- ✅ No more blank page!

---

## 🚨 Important Notes

1. **File to Upload:** `C:\xampp\htdocs\bakery\shop.php`
2. **Upload Location:** `htdocs/shop.php` (overwrite existing)
3. **What Changed:** Line 58 - `config.php` → `config_secure.php`

---

## 🆘 Troubleshooting

**If categories still don't show:**
1. Clear browser cache (Ctrl + F5)
2. Check file was uploaded to correct location
3. Verify file size matches (should be ~13KB)

---

**Ready to upload? Follow the steps above!** 🚀

**After upload, let me know and I'll verify it's working!**

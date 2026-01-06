# 📁 MISSING FOLDERS - MUST UPLOAD

## ❌ Critical Missing Folders

You need to upload these folders from your local bakery directory to InfinityFree:

### 1. **css/** folder
**Location:** `c:\xampp\htdocs\bakery\css\`  
**Upload to:** `htdocs/css/`  
**Contains:** Bootstrap CSS, custom styles, etc.

### 2. **js/** folder
**Location:** `c:\xampp\htdocs\bakery\js\`  
**Upload to:** `htdocs/js/`  
**Contains:** jQuery, Bootstrap JS, custom scripts

### 3. **fonts/** folder ⚠️ CRITICAL
**Location:** `c:\xampp\htdocs\bakery\fonts\`  
**Upload to:** `htdocs/fonts/`  
**Contains:** FontAwesome icons, webfonts, circular-std fonts  
**Why critical:** Icons won't display without this!

### 4. **uploads/** folder
**Location:** `c:\xampp\htdocs\bakery\uploads\`  
**Upload to:** `htdocs/uploads/`  
**Contains:** Product images  
**Note:** Upload all image files

### 5. **includes/** folder
**Location:** `c:\xampp\htdocs\bakery\includes\`  
**Upload to:** `htdocs/includes/`  
**Contains:** email_config.php and other includes

---

## 🎯 How to Upload Folders

### Method 1: ZIP and Upload (Recommended)
1. **Create ZIPs:**
   - Right-click `css` folder → Send to → Compressed folder → `css.zip`
   - Repeat for `js`, `fonts`, `uploads`, `includes`

2. **Upload to InfinityFree:**
   - Go to File Manager → `htdocs/`
   - Upload each ZIP file
   - Extract each ZIP
   - Delete the ZIP files after extraction

### Method 2: Direct Upload
1. In File Manager, click "Upload"
2. Select entire folder (if supported)
3. Or upload files one by one

---

## ✅ After Upload, Your Structure Should Be:

```
htdocs/
  ├── index.php
  ├── shop.php
  ├── css/
  │   ├── bootstrap.min.css
  │   ├── style.css
  │   └── ...
  ├── js/
  │   ├── jquery-3.3.1.min.js
  │   ├── bootstrap.bundle.js
  │   └── ...
  ├── fonts/
  │   ├── fontawesome/
  │   ├── webfonts/  ← CRITICAL!
  │   └── circular-std/
  ├── uploads/
  │   ├── [product images]
  │   └── default-image.jpg
  ├── includes/
  │   └── email_config.php
  └── admin/
```

---

## 🚀 Priority Order:

1. **fonts/** - Fix icons immediately
2. **css/** - Fix layout
3. **js/** - Fix interactions
4. **uploads/** - Fix product images
5. **includes/** - For email features

---

**Upload these 5 folders and your website will look perfect!** 🎨

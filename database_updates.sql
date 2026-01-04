-- Database Schema Updates for Security Improvements
-- Run this script to update the database for enhanced security

USE onlinecakeshop;

-- 1. Increase password field length to accommodate hashed passwords (255 characters)
ALTER TABLE `cake_shop_users_registrations` 
MODIFY COLUMN `users_password` VARCHAR(255) NOT NULL;

ALTER TABLE `cake_shop_admin_registrations` 
MODIFY COLUMN `admin_password` VARCHAR(255) NOT NULL;

-- 2. Add timestamps for better tracking
ALTER TABLE `cake_shop_users_registrations` 
ADD COLUMN `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

ALTER TABLE `cake_shop_admin_registrations` 
ADD COLUMN `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

ALTER TABLE `cake_shop_product` 
ADD COLUMN `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

ALTER TABLE `cake_shop_category` 
ADD COLUMN `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

ALTER TABLE `cake_shop_orders` 
ADD COLUMN `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- 3. Add indexes for better performance
ALTER TABLE `cake_shop_users_registrations` 
ADD INDEX `idx_email` (`users_email`),
ADD INDEX `idx_username` (`users_username`);

ALTER TABLE `cake_shop_admin_registrations` 
ADD INDEX `idx_email` (`admin_email`),
ADD INDEX `idx_username` (`admin_username`);

ALTER TABLE `cake_shop_product` 
ADD INDEX `idx_category` (`product_category`);

ALTER TABLE `cake_shop_orders` 
ADD INDEX `idx_user` (`users_id`),
ADD INDEX `idx_date` (`delivery_date`);

-- 4. Add email verification fields (for future enhancement)
ALTER TABLE `cake_shop_users_registrations` 
ADD COLUMN `email_verified` TINYINT(1) DEFAULT 0,
ADD COLUMN `verification_token` VARCHAR(100) NULL;

-- Note: Existing passwords will need to be migrated using the migrate_passwords.php script

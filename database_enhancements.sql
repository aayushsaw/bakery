-- Database Enhancements for Feature Additions
-- Run this script to add all new tables and columns

USE onlinecakeshop;

-- ============================================================
-- Email Verification & Password Reset
-- ============================================================

ALTER TABLE `cake_shop_users_registrations` 
ADD COLUMN `email_verification_token` VARCHAR(100) NULL AFTER `email_verified`,
ADD COLUMN `email_verified_at` TIMESTAMP NULL AFTER `email_verification_token`,
ADD COLUMN `reset_token` VARCHAR(100) NULL AFTER `email_verified_at`,
ADD COLUMN `reset_token_expires` TIMESTAMP NULL AFTER `reset_token`;

ALTER TABLE `cake_shop_admin_registrations` 
ADD COLUMN `reset_token` VARCHAR(100) NULL AFTER `updated_at`,
ADD COLUMN `reset_token_expires` TIMESTAMP NULL AFTER `reset_token`;

-- ============================================================
-- Two-Factor Authentication
-- ============================================================

ALTER TABLE `cake_shop_users_registrations` 
ADD COLUMN `two_factor_secret` VARCHAR(255) NULL AFTER `reset_token_expires`,
ADD COLUMN `two_factor_enabled` TINYINT(1) DEFAULT 0 AFTER `two_factor_secret`,
ADD COLUMN `backup_codes` TEXT NULL AFTER `two_factor_enabled`;

ALTER TABLE `cake_shop_admin_registrations` 
ADD COLUMN `two_factor_secret` VARCHAR(255) NULL AFTER `reset_token_expires`,
ADD COLUMN `two_factor_enabled` TINYINT(1) DEFAULT 0 AFTER `two_factor_secret`,
ADD COLUMN `backup_codes` TEXT NULL AFTER `two_factor_enabled`;

-- ============================================================
-- Customer Reviews & Ratings
-- ============================================================

CREATE TABLE IF NOT EXISTS `cake_shop_reviews` (
    `review_id` INT AUTO_INCREMENT PRIMARY KEY,
    `product_id` INT NOT NULL,
    `user_id` INT NOT NULL,
    `rating` INT NOT NULL CHECK (`rating` >= 1 AND `rating` <= 5),
    `review_title` VARCHAR(200),
    `review_text` TEXT,
    `approved` TINYINT(1) DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`product_id`) REFERENCES `cake_shop_product`(`product_id`) ON DELETE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES `cake_shop_users_registrations`(`users_id`) ON DELETE CASCADE,
    UNIQUE KEY `unique_user_product` (`user_id`, `product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Add average rating to products table
ALTER TABLE `cake_shop_product` 
ADD COLUMN `average_rating` DECIMAL(3,2) DEFAULT 0.00 AFTER `product_description`,
ADD COLUMN `total_reviews` INT DEFAULT 0 AFTER `average_rating`;

-- ============================================================
-- Order Tracking & Status
-- ============================================================

ALTER TABLE `cake_shop_orders` 
ADD COLUMN `order_status` ENUM('Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled') DEFAULT 'Pending' AFTER `payment_method`,
ADD COLUMN `tracking_number` VARCHAR(100) NULL AFTER `order_status`,
ADD COLUMN `status_updated_at` TIMESTAMP NULL AFTER `tracking_number`,
ADD COLUMN `notes` TEXT NULL AFTER `status_updated_at`;

-- ============================================================
-- Payment Gateway Integration
-- ============================================================

CREATE TABLE IF NOT EXISTS `cake_shop_payments` (
    `payment_id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT NOT NULL,
    `payment_gateway` VARCHAR(50) DEFAULT 'Razorpay',
    `transaction_id` VARCHAR(255),
    `amount` DECIMAL(10,2) NOT NULL,
    `currency` VARCHAR(10) DEFAULT 'INR',
    `payment_status` ENUM('Pending', 'Success', 'Failed', 'Refunded') DEFAULT 'Pending',
    `payment_method` VARCHAR(50),
    `payment_response` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`order_id`) REFERENCES `cake_shop_orders`(`orders_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `cake_shop_orders` 
ADD COLUMN `payment_id` INT NULL AFTER `notes`,
ADD FOREIGN KEY (`payment_id`) REFERENCES `cake_shop_payments`(`payment_id`) ON DELETE SET NULL;

-- ============================================================
-- Email Notifications Log
-- ============================================================

CREATE TABLE IF NOT EXISTS `cake_shop_email_log` (
    `log_id` INT AUTO_INCREMENT PRIMARY KEY,
    `recipient_email` VARCHAR(150) NOT NULL,
    `subject` VARCHAR(255) NOT NULL,
    `email_type` VARCHAR(50),
    `status` ENUM('Sent', 'Failed') DEFAULT 'Sent',
    `error_message` TEXT NULL,
    `sent_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- Indexes for Performance
-- ============================================================

ALTER TABLE `cake_shop_reviews` 
ADD INDEX `idx_product` (`product_id`),
ADD INDEX `idx_user` (`user_id`),
ADD INDEX `idx_approved` (`approved`);

ALTER TABLE `cake_shop_payments` 
ADD INDEX `idx_order` (`order_id`),
ADD INDEX `idx_transaction` (`transaction_id`),
ADD INDEX `idx_status` (`payment_status`);

ALTER TABLE `cake_shop_orders` 
ADD INDEX `idx_status` (`order_status`),
ADD INDEX `idx_tracking` (`tracking_number`);

-- ============================================================
-- Sample Data Updates
-- ============================================================

-- Update existing orders with default status
UPDATE `cake_shop_orders` SET `order_status` = 'Pending' WHERE `order_status` IS NULL;

-- ============================================================
-- Success Message
-- ============================================================

SELECT 'Database enhancements completed successfully!' AS Message;

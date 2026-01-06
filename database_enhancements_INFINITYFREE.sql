-- Database Enhancements for InfinityFree
-- This file adds new tables and columns for the bakery shop features
-- Import this in phpMyAdmin after importing onlinecakeshop.sql

-- =====================================================
-- 1. CREATE REVIEWS TABLE
-- =====================================================

CREATE TABLE IF NOT EXISTS `cake_shop_reviews` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(1) NOT NULL,
  `review_title` varchar(200) DEFAULT NULL,
  `review_text` text NOT NULL,
  `approved` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`review_id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- 2. CREATE EMAIL LOG TABLE
-- =====================================================

CREATE TABLE IF NOT EXISTS `cake_shop_email_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `recipient_email` varchar(255) NOT NULL,
  `recipient_name` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `status` enum('sent','failed') NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- 3. ADD COLUMNS TO USERS TABLE
-- =====================================================

ALTER TABLE `cake_shop_users_registrations` 
ADD COLUMN IF NOT EXISTS `email_verified` tinyint(1) DEFAULT 0,
ADD COLUMN IF NOT EXISTS `email_verification_token` varchar(255) DEFAULT NULL,
ADD COLUMN IF NOT EXISTS `email_verified_at` timestamp NULL DEFAULT NULL,
ADD COLUMN IF NOT EXISTS `reset_token` varchar(255) DEFAULT NULL,
ADD COLUMN IF NOT EXISTS `reset_token_expires` timestamp NULL DEFAULT NULL,
ADD COLUMN IF NOT EXISTS `failed_login_attempts` int(11) DEFAULT 0,
ADD COLUMN IF NOT EXISTS `last_failed_login` timestamp NULL DEFAULT NULL,
ADD COLUMN IF NOT EXISTS `account_locked_until` timestamp NULL DEFAULT NULL;

-- =====================================================
-- 4. ADD COLUMNS TO PRODUCT TABLE
-- =====================================================

ALTER TABLE `cake_shop_product` 
ADD COLUMN IF NOT EXISTS `average_rating` decimal(3,2) DEFAULT 0.00,
ADD COLUMN IF NOT EXISTS `total_reviews` int(11) DEFAULT 0;

-- =====================================================
-- 5. ADD COLUMNS TO ORDERS TABLE
-- =====================================================

ALTER TABLE `cake_shop_orders` 
ADD COLUMN IF NOT EXISTS `order_status` varchar(50) DEFAULT 'Pending',
ADD COLUMN IF NOT EXISTS `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
ADD COLUMN IF NOT EXISTS `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp();

-- =====================================================
-- DONE! All enhancements applied successfully
-- =====================================================

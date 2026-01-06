<?php
/**
 * Database Configuration for InfinityFree
 * IMPORTANT: Upload this file to htdocs/ on InfinityFree
 */

// InfinityFree Database Credentials
$db_host = "sql103.infinityfree.com";
$db_user = "if0_40824927";
$db_pass = "BakeryShop123";
$db_name = "if0_40824927_bakery_db";

// Create connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if (!$conn) {
    die("Database connection failed. Please try again later.");
}

// Set charset
mysqli_set_charset($conn, "utf8mb4");
?>

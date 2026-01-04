<?php
/**
 * Secure Database Configuration using PDO
 * This file replaces the old mysqli connection with a more secure PDO connection
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'onlinecakeshop');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Create PDO instance with error handling
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    // Log error (in production, don't display detailed error messages)
    error_log("Database Connection Error: " . $e->getMessage());
    die("Database connection failed. Please try again later.");
}

// Keep old mysqli connection for backward compatibility during transition
$host = DB_HOST;
$config_username = DB_USER;
$password = DB_PASS;
$db = DB_NAME;
$conn = mysqli_connect($host, $config_username, $password, $db);

if (!$conn) {
    error_log("MySQLi Connection Error: " . mysqli_connect_error());
    die("Database connection failed. Please try again later.");
}

mysqli_set_charset($conn, DB_CHARSET);
?>

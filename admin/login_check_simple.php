<?php
/**
 * Simplified Admin Login for InfinityFree
 * Compatible with free hosting limitations
 */

session_start();

// Include database config
require_once('../config_secure.php');

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

// Get inputs
$admin_username = isset($_POST['admin_username']) ? trim($_POST['admin_username']) : '';
$admin_password = isset($_POST['admin_password']) ? $_POST['admin_password'] : '';

// Validate inputs
if (empty($admin_username) || empty($admin_password)) {
    header("Location: index.php?login_error=1");
    exit();
}

// Query admin
$query = "SELECT * FROM cake_shop_admin_registrations WHERE admin_username = ?";
$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    die("Database error");
}

mysqli_stmt_bind_param($stmt, "s", $admin_username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    // Verify password
    if (password_verify($admin_password, $row['admin_password'])) {
        // Login successful
        $_SESSION['user_admin_id'] = $row['admin_id'];
        $_SESSION['user_admin_username'] = $row['admin_username'];
        
        mysqli_stmt_close($stmt);
        header("Location: dashboard.php");
        exit();
    }
}

// Login failed
mysqli_stmt_close($stmt);
header("Location: index.php?login_error=1");
exit();
?>

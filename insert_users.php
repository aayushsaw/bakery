<?php
/**
 * User Registration Handler - Simplified for InfinityFree
 */

session_start();
require_once('config_secure.php');

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: register.php");
    exit();
}

// Get and validate inputs
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

// Basic validation
if (empty($username) || empty($email) || empty($password)) {
    header("Location: register.php?error=empty_fields");
    exit();
}

if ($password !== $confirm_password) {
    header("Location: register.php?error=password_mismatch");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: register.php?error=invalid_email");
    exit();
}

// Check if username or email already exists
$check_query = "SELECT users_id FROM cake_shop_users_registrations WHERE users_username = ? OR users_email = ?";
$check_stmt = mysqli_prepare($conn, $check_query);

if ($check_stmt) {
    mysqli_stmt_bind_param($check_stmt, "ss", $username, $email);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);
    
    if (mysqli_num_rows($check_result) > 0) {
        mysqli_stmt_close($check_stmt);
        header("Location: register.php?error=user_exists");
        exit();
    }
    mysqli_stmt_close($check_stmt);
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Insert new user
$insert_query = "INSERT INTO cake_shop_users_registrations (users_username, users_email, users_password, email_verified) VALUES (?, ?, ?, 1)";
$insert_stmt = mysqli_prepare($conn, $insert_query);

if ($insert_stmt) {
    mysqli_stmt_bind_param($insert_stmt, "sss", $username, $email, $hashed_password);
    
    if (mysqli_stmt_execute($insert_stmt)) {
        mysqli_stmt_close($insert_stmt);
        header("Location: login_users.php?register_success=1");
        exit();
    }
    
    mysqli_stmt_close($insert_stmt);
}

// Registration failed
header("Location: register.php?error=registration_failed");
exit();
?>
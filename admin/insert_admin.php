<?php
/**
 * Admin Registration Handler - Secure Version
 * Uses password hashing, prepared statements, and input validation
 */

require_once('../config.php');
require_once('../includes/security.php');

// Initialize secure session
init_secure_session();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: admin_signup.php");
    exit();
}

// Validate CSRF token
if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
    log_security_event('CSRF_VALIDATION_FAILED', 'Admin registration attempt with invalid CSRF token');
    header("Location: admin_signup.php?error=invalid_request");
    exit();
}

// Sanitize and validate inputs
$admin_username = sanitize_input(isset($_POST['admin_username']) ? $_POST['admin_username'] : '');
$admin_email = sanitize_input(isset($_POST['admin_email']) ? $_POST['admin_email'] : '');
$admin_password = isset($_POST['admin_password']) ? $_POST['admin_password'] : '';

// Validation
if (empty($admin_username) || strlen($admin_username) < 3) {
    header("Location: admin_signup.php?error=invalid_username");
    exit();
}

if (!validate_email($admin_email)) {
    header("Location: admin_signup.php?error=invalid_email");
    exit();
}

if (empty($admin_password) || strlen($admin_password) < 6) {
    header("Location: admin_signup.php?error=weak_password");
    exit();
}

// Check if admin already exists
$check_query = "SELECT admin_id FROM cake_shop_admin_registrations WHERE admin_username = ? OR admin_email = ?";
$stmt = mysqli_prepare($conn, $check_query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ss", $admin_username, $admin_email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_close($stmt);
        log_security_event('ADMIN_REGISTRATION_DUPLICATE', "Attempted admin registration with existing username/email: $admin_username");
        header("Location: admin_signup.php?register_msg=1");
        exit();
    }
    
    mysqli_stmt_close($stmt);
}

// Hash the password
$hashed_password = hash_password($admin_password);

// Insert new admin
$insert_query = "INSERT INTO cake_shop_admin_registrations (admin_username, admin_email, admin_password) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $insert_query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "sss", $admin_username, $admin_email, $hashed_password);
    
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        log_security_event('ADMIN_REGISTERED', "New admin registered: $admin_username");
        header("Location: index.php?success=registered");
        exit();
    } else {
        mysqli_stmt_close($stmt);
        log_security_event('ADMIN_REGISTRATION_ERROR', "Database error during admin registration");
        header("Location: admin_signup.php?error=database");
        exit();
    }
} else {
    log_security_event('ADMIN_REGISTRATION_ERROR', "Failed to prepare statement");
    header("Location: admin_signup.php?error=database");
    exit();
}

mysqli_close($conn);
?>

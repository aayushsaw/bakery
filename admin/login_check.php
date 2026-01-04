<?php
/**
 * Admin Login Handler - Secure Version
 * Uses password verification, prepared statements, and session security
 */

require_once('../config.php');
require_once('../includes/security.php');

// Initialize secure session
init_secure_session();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

// Validate CSRF token
if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
    log_security_event('CSRF_VALIDATION_FAILED', 'Admin login attempt with invalid CSRF token');
    header("Location: index.php?login_error=invalid_request");
    exit();
}

// Get and sanitize inputs
$admin_username = sanitize_input(isset($_POST['admin_username']) ? $_POST['admin_username'] : '');
$admin_password = isset($_POST['admin_password']) ? $_POST['admin_password'] : '';

// Basic validation
if (empty($admin_username) || empty($admin_password)) {
    header("Location: index.php?login_error=empty_fields");
    exit();
}

// Rate limiting
$rate_limit_key = 'admin_login_' . $admin_username . '_' . (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unknown');
if (!check_rate_limit($rate_limit_key, 5, 300)) {
    log_security_event('ADMIN_RATE_LIMIT_EXCEEDED', "Too many admin login attempts for: $admin_username");
    header("Location: index.php?login_error=rate_limit");
    exit();
}

// Fetch admin using prepared statement
$select_query = "SELECT admin_id, admin_username, admin_password, admin_email FROM cake_shop_admin_registrations WHERE admin_username = ?";
$stmt = mysqli_prepare($conn, $select_query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $admin_username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);
        
        // Verify password
        if (verify_password($admin_password, $admin['admin_password'])) {
            // Password is correct - create session
            
            // Regenerate session ID
            session_regenerate_id(true);
            
            // Set session variables
            $_SESSION['user_admin_id'] = $admin['admin_id'];
            $_SESSION['user_admin_username'] = $admin['admin_username'];
            $_SESSION['user_admin_email'] = $admin['admin_email'];
            $_SESSION['admin_login_time'] = time();
            
            // Clear rate limit
            if (isset($_SESSION['rate_limit'][$rate_limit_key])) {
                unset($_SESSION['rate_limit'][$rate_limit_key]);
            }
            
            log_security_event('ADMIN_LOGIN_SUCCESS', "Admin logged in: $admin_username");
            
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            
            header("Location: dashboard.php?login_success=1");
            exit();
        } else {
            // Invalid password
            log_security_event('ADMIN_LOGIN_FAILED', "Invalid password for admin: $admin_username");
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: index.php?login_error=1");
            exit();
        }
    } else {
        // Admin not found
        log_security_event('ADMIN_LOGIN_FAILED', "Admin not found: $admin_username");
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header("Location: index.php?login_error=1");
        exit();
    }
} else {
    log_security_event('ADMIN_LOGIN_ERROR', "Database error during admin login");
    mysqli_close($conn);
    header("Location: index.php?login_error=database");
    exit();
}
?>
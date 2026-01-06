<?php
/**
 * User Login Handler - Secure Version
 * Uses password verification, prepared statements, rate limiting, and session security
 */

require_once('config_secure.php');
require_once('includes/security.php');

// Initialize secure session
init_secure_session();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login_users.php");
    exit();
}

// Validate CSRF token
if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
    log_security_event('CSRF_VALIDATION_FAILED', 'User login attempt with invalid CSRF token');
    header("Location: login_users.php?login_error=invalid_request");
    exit();
}

// Get and sanitize inputs
$users_username = sanitize_input(isset($_POST['users_username']) ? $_POST['users_username'] : '');
$users_password = isset($_POST['users_password']) ? $_POST['users_password'] : ''; // Don't sanitize password

// Basic validation
if (empty($users_username) || empty($users_password)) {
    header("Location: login_users.php?login_error=empty_fields");
    exit();
}

// Rate limiting - prevent brute force attacks
$rate_limit_key = 'login_' . $users_username . '_' . (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unknown');
if (!check_rate_limit($rate_limit_key, 5, 300)) {
    log_security_event('RATE_LIMIT_EXCEEDED', "Too many login attempts for: $users_username");
    header("Location: login_users.php?login_error=rate_limit");
    exit();
}

// Fetch user using prepared statement
$select_query = "SELECT users_id, users_username, users_password, users_email FROM cake_shop_users_registrations WHERE users_username = ?";
$stmt = mysqli_prepare($conn, $select_query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $users_username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify password
        if (verify_password($users_password, $user['users_password'])) {
            // Password is correct - create session
            
            // Regenerate session ID to prevent session fixation
            session_regenerate_id(true);
            
            // Set session variables
            $_SESSION['user_users_id'] = $user['users_id'];
            $_SESSION['user_users_username'] = $user['users_username'];
            $_SESSION['user_users_email'] = $user['users_email'];
            $_SESSION['login_time'] = time();
            
            // Clear rate limit for this user
            if (isset($_SESSION['rate_limit'][$rate_limit_key])) {
                unset($_SESSION['rate_limit'][$rate_limit_key]);
            }
            
            log_security_event('USER_LOGIN_SUCCESS', "User logged in: $users_username");
            
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            
            header("Location: index.php?login_success=1");
            exit();
        } else {
            // Invalid password
            log_security_event('LOGIN_FAILED', "Invalid password for user: $users_username");
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: login_users.php?login_error=1");
            exit();
        }
    } else {
        // User not found
        log_security_event('LOGIN_FAILED', "User not found: $users_username");
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header("Location: login_users.php?login_error=1");
        exit();
    }
} else {
    log_security_event('LOGIN_ERROR', "Database error during login attempt");
    mysqli_close($conn);
    header("Location: login_users.php?login_error=database");
    exit();
}
?>
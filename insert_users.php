<?php
/**
 * User Registration Handler - Secure Version
 * Uses password hashing, prepared statements, and input validation
 */

require_once('config_secure.php');
require_once('includes/security.php');

// Initialize secure session
init_secure_session();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: register.php");
    exit();
}

// Validate CSRF token
if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
    log_security_event('CSRF_VALIDATION_FAILED', 'User registration attempt with invalid CSRF token');
    header("Location: register.php?error=invalid_request");
    exit();
}

// Sanitize and validate inputs
$users_username = sanitize_input(isset($_POST['users_username']) ? $_POST['users_username'] : '');
$users_email = sanitize_input(isset($_POST['users_email']) ? $_POST['users_email'] : '');
$users_password = isset($_POST['users_password']) ? $_POST['users_password'] : ''; // Don't sanitize password
$users_mobile = sanitize_input(isset($_POST['users_mobile']) ? $_POST['users_mobile'] : '');
$users_address = sanitize_input(isset($_POST['users_address']) ? $_POST['users_address'] : '');

// Validation
$errors = [];

if (empty($users_username) || strlen($users_username) < 3) {
    $errors[] = "Username must be at least 3 characters long";
}

if (!validate_email($users_email)) {
    $errors[] = "Invalid email address";
}

if (empty($users_password) || strlen($users_password) < 6) {
    $errors[] = "Password must be at least 6 characters long";
}

if (!validate_phone($users_mobile)) {
    $errors[] = "Invalid phone number (must be 10 digits)";
}

if (empty($users_address)) {
    $errors[] = "Address is required";
}

// If there are validation errors, redirect back
if (!empty($errors)) {
    $_SESSION['registration_errors'] = $errors;
    header("Location: register.php?error=validation");
    exit();
}

// Check if username or email already exists using prepared statement
$check_query = "SELECT users_id FROM cake_shop_users_registrations WHERE users_username = ? OR users_email = ?";
$stmt = mysqli_prepare($conn, $check_query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ss", $users_username, $users_email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_close($stmt);
        log_security_event('REGISTRATION_DUPLICATE', "Attempted registration with existing username/email: $users_username");
        header("Location: register.php?register_msg=1");
        exit();
    }
    
    mysqli_stmt_close($stmt);
}

// Hash the password
$hashed_password = hash_password($users_password);

// Insert new user using prepared statement
$insert_query = "INSERT INTO cake_shop_users_registrations (users_username, users_email, users_password, users_mobile, users_address) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $insert_query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "sssss", $users_username, $users_email, $hashed_password, $users_mobile, $users_address);
    
    if (mysqli_stmt_execute($stmt)) {
        $user_id = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt);
        
        // Generate email verification token
        $verification_token = bin2hex(openssl_random_pseudo_bytes(32));
        $verification_link = 'http://localhost/bakery/verify_email.php?token=' . $verification_token;
        
        // Update user with verification token
        $update_query = "UPDATE cake_shop_users_registrations SET email_verification_token = ? WHERE users_id = ?";
        $update_stmt = mysqli_prepare($conn, $update_query);
        if ($update_stmt) {
            mysqli_stmt_bind_param($update_stmt, "si", $verification_token, $user_id);
            mysqli_stmt_execute($update_stmt);
            mysqli_stmt_close($update_stmt);
        }
        
        // Send verification email
        require_once('includes/email_config.php');
        require_once('includes/email_templates.php');
        send_email(
            $users_email,
            $users_username,
            'Verify Your Email - Bakery Shop',
            email_template_verification($users_username, $verification_link)
        );
        
        log_security_event('USER_REGISTERED', "New user registered: $users_username");
        redirect_with_message('login_users.php', 'success', 'Registration successful! Please check your email to verify your account.');
    } else {
        mysqli_stmt_close($stmt);
        log_security_event('REGISTRATION_ERROR', "Database error during registration for: $users_username");
        header("Location: register.php?error=database");
        exit();
    }
} else {
    log_security_event('REGISTRATION_ERROR', "Failed to prepare statement for registration");
    header("Location: register.php?error=database");
    exit();
}

mysqli_close($conn);
?>
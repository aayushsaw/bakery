<?php
/**
 * Resend Verification Email
 * Allows users to request a new verification email
 */

require_once('config.php');
require_once('includes/security.php');
require_once('includes/email_config.php');
require_once('includes/email_templates.php');

init_secure_session();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login_users.php");
    exit();
}

// Validate CSRF token
if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
    header("Location: login_users.php?error=invalid_request");
    exit();
}

$users_email = sanitize_input(isset($_POST['users_email']) ? $_POST['users_email'] : '');

if (empty($users_email) || !validate_email($users_email)) {
    header("Location: login_users.php?error=invalid_email");
    exit();
}

// Find user
$query = "SELECT users_id, users_username, email_verified FROM cake_shop_users_registrations WHERE users_email = ?";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $users_email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Check if already verified
        if ($user['email_verified'] == 1) {
            mysqli_stmt_close($stmt);
            header("Location: login_users.php?message=already_verified");
            exit();
        }
        
        // Generate new token
        $verification_token = bin2hex(openssl_random_pseudo_bytes(32));
        $verification_link = APP_URL . '/verify_email.php?token=' . $verification_token;
        
        // Update token
        $update_query = "UPDATE cake_shop_users_registrations SET email_verification_token = ? WHERE users_id = ?";
        $update_stmt = mysqli_prepare($conn, $update_query);
        
        if ($update_stmt) {
            mysqli_stmt_bind_param($update_stmt, "si", $verification_token, $user['users_id']);
            mysqli_stmt_execute($update_stmt);
            mysqli_stmt_close($update_stmt);
        }
        
        // Send email
        send_email(
            $users_email,
            $user['users_username'],
            'Verify Your Email - Bakery Shop',
            email_template_verification($user['users_username'], $verification_link)
        );
        
        log_security_event('VERIFICATION_EMAIL_RESENT', "Verification email resent to: $users_email");
        mysqli_stmt_close($stmt);
        header("Location: login_users.php?message=verification_sent");
        exit();
    } else {
        mysqli_stmt_close($stmt);
        header("Location: login_users.php?error=email_not_found");
        exit();
    }
}

mysqli_close($conn);
?>

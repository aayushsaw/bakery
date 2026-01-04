<?php
/**
 * Send Password Reset Link
 * Generates reset token and sends email
 */

require_once('config.php');
require_once('includes/security.php');
require_once('includes/email_config.php');
require_once('includes/email_templates.php');

init_secure_session();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: forgot_password.php");
    exit();
}

if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
    header("Location: forgot_password.php?error=invalid_request");
    exit();
}

$users_email = sanitize_input(isset($_POST['users_email']) ? $_POST['users_email'] : '');

if (empty($users_email) || !validate_email($users_email)) {
    redirect_with_message('forgot_password.php', 'error', 'Please enter a valid email address.');
}

// Find user
$query = "SELECT users_id, users_username FROM cake_shop_users_registrations WHERE users_email = ?";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $users_email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Generate reset token
        $reset_token = bin2hex(openssl_random_pseudo_bytes(32));
        $reset_link = APP_URL . '/reset_password.php?token=' . $reset_token;
        $expires = date('Y-m-d H:i:s', strtotime('+24 hours'));
        
        // Save token
        $update_query = "UPDATE cake_shop_users_registrations SET reset_token = ?, reset_token_expires = ? WHERE users_id = ?";
        $update_stmt = mysqli_prepare($conn, $update_query);
        
        if ($update_stmt) {
            mysqli_stmt_bind_param($update_stmt, "ssi", $reset_token, $expires, $user['users_id']);
            mysqli_stmt_execute($update_stmt);
            mysqli_stmt_close($update_stmt);
        }
        
        // Send email
        send_email(
            $users_email,
            $user['users_username'],
            'Reset Your Password - Bakery Shop',
            email_template_password_reset($user['users_username'], $reset_link)
        );
        
        log_security_event('PASSWORD_RESET_REQUESTED', "Password reset requested for: $users_email");
    }
    
    mysqli_stmt_close($stmt);
}

// Always show success message (security best practice)
redirect_with_message('login_users.php', 'success', 'If an account exists with that email, a password reset link has been sent.');

mysqli_close($conn);
?>

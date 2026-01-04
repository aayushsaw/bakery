<?php
/**
 * Process Password Reset
 * Updates password and clears reset token
 */

require_once('config.php');
require_once('includes/security.php');

init_secure_session();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login_users.php");
    exit();
}

if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
    header("Location: login_users.php?error=invalid_request");
    exit();
}

$token = isset($_POST['token']) ? sanitize_input($_POST['token']) : '';
$new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

// Validate inputs
if (empty($token) || empty($new_password) || empty($confirm_password)) {
    redirect_with_message('reset_password.php?token=' . $token, 'error', 'All fields are required.');
}

if ($new_password !== $confirm_password) {
    redirect_with_message('reset_password.php?token=' . $token, 'error', 'Passwords do not match.');
}

if (strlen($new_password) < 6) {
    redirect_with_message('reset_password.php?token=' . $token, 'error', 'Password must be at least 6 characters.');
}

// Verify token
$query = "SELECT users_id, users_username FROM cake_shop_users_registrations WHERE reset_token = ? AND reset_token_expires > NOW()";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Hash new password
        $hashed_password = hash_password($new_password);
        
        // Update password and clear token
        $update_query = "UPDATE cake_shop_users_registrations SET users_password = ?, reset_token = NULL, reset_token_expires = NULL WHERE users_id = ?";
        $update_stmt = mysqli_prepare($conn, $update_query);
        
        if ($update_stmt) {
            mysqli_stmt_bind_param($update_stmt, "si", $hashed_password, $user['users_id']);
            
            if (mysqli_stmt_execute($update_stmt)) {
                log_security_event('PASSWORD_RESET_SUCCESS', "Password reset successful for: " . $user['users_username']);
                mysqli_stmt_close($update_stmt);
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                
                redirect_with_message('login_users.php', 'success', 'Password reset successful! You can now login with your new password.');
            }
            
            mysqli_stmt_close($update_stmt);
        }
    }
    
    mysqli_stmt_close($stmt);
}

redirect_with_message('forgot_password.php', 'error', 'Invalid or expired reset link.');

mysqli_close($conn);
?>

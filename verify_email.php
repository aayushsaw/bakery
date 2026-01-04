<?php
/**
 * Email Verification Handler
 * Verifies user email address using token
 */

require_once('config.php');
require_once('includes/security.php');

init_secure_session();

// Get token from URL
$token = isset($_GET['token']) ? sanitize_input($_GET['token']) : '';

if (empty($token)) {
    header("Location: login_users.php?error=invalid_token");
    exit();
}

// Find user with this token
$query = "SELECT users_id, users_username, users_email, email_verified FROM cake_shop_users_registrations WHERE email_verification_token = ?";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $token);
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
        
        // Update user as verified
        $update_query = "UPDATE cake_shop_users_registrations SET email_verified = 1, email_verified_at = NOW(), email_verification_token = NULL WHERE users_id = ?";
        $update_stmt = mysqli_prepare($conn, $update_query);
        
        if ($update_stmt) {
            mysqli_stmt_bind_param($update_stmt, "i", $user['users_id']);
            
            if (mysqli_stmt_execute($update_stmt)) {
                log_security_event('EMAIL_VERIFIED', "Email verified for user: " . $user['users_username']);
                mysqli_stmt_close($update_stmt);
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                
                // Redirect to login with success message
                header("Location: login_users.php?message=email_verified");
                exit();
            } else {
                mysqli_stmt_close($update_stmt);
                header("Location: login_users.php?error=verification_failed");
                exit();
            }
        }
    } else {
        mysqli_stmt_close($stmt);
        header("Location: login_users.php?error=invalid_token");
        exit();
    }
} else {
    header("Location: login_users.php?error=database_error");
    exit();
}

mysqli_close($conn);
?>

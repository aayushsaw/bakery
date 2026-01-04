<?php
/**
 * Email Configuration - Fallback Version
 * Uses PHP's built-in mail() function since Composer/PHPMailer not available
 */

// Email configuration constants
define('MAIL_FROM_EMAIL', 'noreply@bakeryshop.com');
define('MAIL_FROM_NAME', 'Bakery Shop');

// Application URL
if (!defined('APP_URL')) {
    define('APP_URL', 'http://localhost/bakery');
}

/**
 * Send email using PHP mail() function
 */
function send_email($to_email, $to_name, $subject, $body) {
    // Set headers
    $headers = array();
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=UTF-8';
    $headers[] = 'From: ' . MAIL_FROM_NAME . ' <' . MAIL_FROM_EMAIL . '>';
    $headers[] = 'Reply-To: ' . MAIL_FROM_EMAIL;
    $headers[] = 'X-Mailer: PHP/' . phpversion();
    
    // Send email
    $result = mail($to_email, $subject, $body, implode("\r\n", $headers));
    
    // Log result
    if ($result) {
        log_email('Sent', $to_email, $subject, 'Email sent successfully');
    } else {
        log_email('Failed', $to_email, $subject, 'Failed to send email');
    }
    
    return $result;
}

/**
 * Log email sending attempts
 */
function log_email($status, $recipient, $subject, $message) {
    global $conn;
    
    if (!$conn) {
        return;
    }
    
    $email_type = extract_email_type($subject);
    $error_msg = ($status === 'Failed') ? $message : NULL;
    
    $query = "INSERT INTO cake_shop_email_log (recipient_email, subject, email_type, status, error_message) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssss", $recipient, $subject, $email_type, $status, $error_msg);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

/**
 * Extract email type from subject
 */
function extract_email_type($subject) {
    if (stripos($subject, 'verify') !== false) return 'Verification';
    if (stripos($subject, 'reset') !== false || stripos($subject, 'password') !== false) return 'Password Reset';
    if (stripos($subject, 'order') !== false) return 'Order';
    if (stripos($subject, 'payment') !== false) return 'Payment';
    if (stripos($subject, 'welcome') !== false) return 'Welcome';
    if (stripos($subject, 'review') !== false) return 'Review';
    return 'Other';
}

/**
 * Test email configuration
 */
function test_email_config() {
    $test_email = "test@example.com";
    $subject = "Bakery Shop - Email Configuration Test";
    $body = "<h2>Email Configuration Test</h2><p>If you receive this email, your email configuration is working correctly!</p>";
    
    return send_email($test_email, "Test User", $subject, $body);
}
?>

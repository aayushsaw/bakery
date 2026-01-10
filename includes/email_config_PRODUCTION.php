<?php
/**
 * Email Configuration - PRODUCTION
 * Replace the content of includes/email_config.php with this
 */

// Application URL (UPDATED for production)
define('APP_URL', 'https://bakeryshop.infinityfreeapp.com');

// Email settings
define('MAIL_FROM_EMAIL', 'noreply@bakeryshop.infinityfreeapp.com');
define('MAIL_FROM_NAME', 'Bakery Shop');

/**
 * Send email function
 */
function send_email($to, $to_name, $subject, $html_body) {
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: ' . MAIL_FROM_NAME . ' <' . MAIL_FROM_EMAIL . '>' . "\r\n";
    
    $success = mail($to, $subject, $html_body, $headers);
    
    // Log email
    global $conn;
    if (isset($conn)) {
        $log_query = "INSERT INTO cake_shop_email_log (recipient_email, recipient_name, subject, status, sent_at) 
                      VALUES (?, ?, ?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $log_query);
        if ($stmt) {
            $status = $success ? 'sent' : 'failed';
            mysqli_stmt_bind_param($stmt, "ssss", $to, $to_name, $subject, $status);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
    
    return $success;
}
?>

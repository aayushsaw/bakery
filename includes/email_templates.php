<?php
/**
 * Email Templates
 * Reusable email templates for various notifications
 */

/**
 * Base email template wrapper
 */
function email_template_wrapper($title, $content) {
    return '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . htmlspecialchars($title) . '</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f4; margin: 0; padding: 0; }
            .container { max-width: 600px; margin: 20px auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
            .header { text-align: center; padding-bottom: 20px; border-bottom: 2px solid #007bff; }
            .header h1 { color: #007bff; margin: 0; }
            .content { padding: 20px 0; }
            .button { display: inline-block; padding: 12px 30px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px; margin: 20px 0; }
            .button:hover { background-color: #0056b3; }
            .footer { text-align: center; padding-top: 20px; border-top: 1px solid #ddd; color: #777; font-size: 12px; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>🍰 Bakery Shop</h1>
            </div>
            <div class="content">
                ' . $content . '
            </div>
            <div class="footer">
                <p>&copy; ' . date('Y') . ' Bakery Shop. Created by Aayush Saw.</p>
                <p>This is an automated email. Please do not reply.</p>
            </div>
        </div>
    </body>
    </html>
    ';
}

/**
 * Welcome email template
 */
function email_template_welcome($username) {
    $content = '
        <h2>Welcome to Bakery Shop!</h2>
        <p>Hi <strong>' . htmlspecialchars($username) . '</strong>,</p>
        <p>Thank you for registering with Bakery Shop. We\'re excited to have you as part of our community!</p>
        <p>You can now browse our delicious collection of cakes, pastries, and desserts.</p>
        <a href="' . APP_URL . '" class="button">Start Shopping</a>
        <p>If you have any questions, feel free to contact us.</p>
        <p>Happy shopping!</p>
    ';
    return email_template_wrapper('Welcome to Bakery Shop', $content);
}

/**
 * Email verification template
 */
function email_template_verification($username, $verification_link) {
    $content = '
        <h2>Verify Your Email Address</h2>
        <p>Hi <strong>' . htmlspecialchars($username) . '</strong>,</p>
        <p>Thank you for registering! Please verify your email address to activate your account.</p>
        <a href="' . htmlspecialchars($verification_link) . '" class="button">Verify Email</a>
        <p>Or copy and paste this link into your browser:</p>
        <p style="word-break: break-all; color: #007bff;">' . htmlspecialchars($verification_link) . '</p>
        <p>This link will expire in 24 hours.</p>
        <p>If you didn\'t create an account, please ignore this email.</p>
    ';
    return email_template_wrapper('Verify Your Email', $content);
}

/**
 * Password reset template
 */
function email_template_password_reset($username, $reset_link) {
    $content = '
        <h2>Reset Your Password</h2>
        <p>Hi <strong>' . htmlspecialchars($username) . '</strong>,</p>
        <p>We received a request to reset your password. Click the button below to create a new password:</p>
        <a href="' . htmlspecialchars($reset_link) . '" class="button">Reset Password</a>
        <p>Or copy and paste this link into your browser:</p>
        <p style="word-break: break-all; color: #007bff;">' . htmlspecialchars($reset_link) . '</p>
        <p>This link will expire in 24 hours.</p>
        <p>If you didn\'t request a password reset, please ignore this email or contact us if you have concerns.</p>
    ';
    return email_template_wrapper('Reset Your Password', $content);
}

/**
 * Order confirmation template
 */
function email_template_order_confirmation($username, $order_id, $total_amount, $order_details) {
    $content = '
        <h2>Order Confirmation</h2>
        <p>Hi <strong>' . htmlspecialchars($username) . '</strong>,</p>
        <p>Thank you for your order! Your order has been received and is being processed.</p>
        <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p><strong>Order ID:</strong> #' . htmlspecialchars($order_id) . '</p>
            <p><strong>Total Amount:</strong> ₹' . number_format($total_amount, 2) . '</p>
        </div>
        ' . $order_details . '
        <a href="' . APP_URL . '/track_order.php?order_id=' . $order_id . '" class="button">Track Order</a>
        <p>We\'ll send you another email when your order ships.</p>
    ';
    return email_template_wrapper('Order Confirmation', $content);
}

/**
 * Order status update template
 */
function email_template_order_status($username, $order_id, $status) {
    $status_messages = array(
        'Processing' => 'Your order is being prepared.',
        'Shipped' => 'Your order has been shipped and is on its way!',
        'Delivered' => 'Your order has been delivered. Enjoy!',
        'Cancelled' => 'Your order has been cancelled.'
    );
    
    $message = isset($status_messages[$status]) ? $status_messages[$status] : 'Your order status has been updated.';
    
    $content = '
        <h2>Order Status Update</h2>
        <p>Hi <strong>' . htmlspecialchars($username) . '</strong>,</p>
        <p>Your order <strong>#' . htmlspecialchars($order_id) . '</strong> status has been updated:</p>
        <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0; text-align: center;">
            <h3 style="color: #007bff; margin: 0;">' . htmlspecialchars($status) . '</h3>
            <p style="margin: 10px 0 0 0;">' . $message . '</p>
        </div>
        <a href="' . APP_URL . '/track_order.php?order_id=' . $order_id . '" class="button">Track Order</a>
    ';
    return email_template_wrapper('Order Status Update', $content);
}

/**
 * Payment receipt template
 */
function email_template_payment_receipt($username, $order_id, $transaction_id, $amount, $payment_method) {
    $content = '
        <h2>Payment Receipt</h2>
        <p>Hi <strong>' . htmlspecialchars($username) . '</strong>,</p>
        <p>Your payment has been successfully processed. Here are the details:</p>
        <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p><strong>Order ID:</strong> #' . htmlspecialchars($order_id) . '</p>
            <p><strong>Transaction ID:</strong> ' . htmlspecialchars($transaction_id) . '</p>
            <p><strong>Amount Paid:</strong> ₹' . number_format($amount, 2) . '</p>
            <p><strong>Payment Method:</strong> ' . htmlspecialchars($payment_method) . '</p>
        </div>
        <p>Thank you for your payment!</p>
    ';
    return email_template_wrapper('Payment Receipt', $content);
}

/**
 * Review submission confirmation template
 */
function email_template_review_confirmation($username, $product_name) {
    $content = '
        <h2>Review Submitted</h2>
        <p>Hi <strong>' . htmlspecialchars($username) . '</strong>,</p>
        <p>Thank you for submitting a review for <strong>' . htmlspecialchars($product_name) . '</strong>!</p>
        <p>Your review is currently being moderated and will be published soon.</p>
        <p>We appreciate your feedback!</p>
    ';
    return email_template_wrapper('Review Submitted', $content);
}

/**
 * Admin notification for new order
 */
function email_template_admin_new_order($order_id, $customer_name, $total_amount) {
    $content = '
        <h2>New Order Received</h2>
        <p>A new order has been placed:</p>
        <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p><strong>Order ID:</strong> #' . htmlspecialchars($order_id) . '</p>
            <p><strong>Customer:</strong> ' . htmlspecialchars($customer_name) . '</p>
            <p><strong>Total Amount:</strong> ₹' . number_format($total_amount, 2) . '</p>
        </div>
        <a href="' . APP_URL . '/admin/view_orders.php" class="button">View Order</a>
    ';
    return email_template_wrapper('New Order Notification', $content);
}
?>

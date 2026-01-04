<?php
/**
 * Order Tracking Page
 * Allows customers to track their orders
 */

require_once('config.php');
require_once('includes/security.php');

init_secure_session();

$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
$order = null;

if ($order_id > 0) {
    // Fetch order details
    $query = "SELECT o.*, u.users_username, u.users_email 
              FROM cake_shop_orders o 
              LEFT JOIN cake_shop_users_registrations u ON o.users_id = u.users_id 
              WHERE o.orders_id = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $order_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $order = mysqli_fetch_assoc($result);
        }
        
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order - Bakery Shop</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="fonts/fontawesome/css/fontawesome-all.css">
    <style>
        .timeline {
            position: relative;
            padding: 20px 0;
        }
        .timeline-item {
            padding: 20px;
            margin-bottom: 20px;
            position: relative;
        }
        .timeline-item.active {
            background: #e7f3ff;
            border-left: 4px solid #007bff;
        }
        .timeline-item.completed {
            background: #d4edda;
            border-left: 4px solid #28a745;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Track Your Order</h2>
        
        <?php if ($order): ?>
            <div class="card mt-4">
                <div class="card-header">
                    <h4>Order #<?php echo $order['orders_id']; ?></h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Customer:</strong> <?php echo htmlspecialchars($order['users_username']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($order['users_email']); ?></p>
                            <p><strong>Delivery Address:</strong> <?php echo htmlspecialchars($order['delivery_address']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Order Date:</strong> <?php echo date('M d, Y', strtotime($order['created_at'])); ?></p>
                            <p><strong>Delivery Date:</strong> <?php echo date('M d, Y', strtotime($order['delivery_date'])); ?></p>
                            <p><strong>Total Amount:</strong> ₹<?php echo number_format($order['total_amount'], 2); ?></p>
                            <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></p>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h5>Order Status Timeline</h5>
                    <div class="timeline">
                        <div class="timeline-item <?php echo ($order['order_status'] == 'Pending') ? 'active' : 'completed'; ?>">
                            <h6><i class="fas fa-clock"></i> Pending</h6>
                            <p>Your order has been received and is awaiting processing.</p>
                        </div>
                        
                        <div class="timeline-item <?php echo ($order['order_status'] == 'Processing') ? 'active' : (in_array($order['order_status'], ['Shipped', 'Delivered']) ? 'completed' : ''); ?>">
                            <h6><i class="fas fa-cog"></i> Processing</h6>
                            <p>Your order is being prepared.</p>
                        </div>
                        
                        <div class="timeline-item <?php echo ($order['order_status'] == 'Shipped') ? 'active' : ($order['order_status'] == 'Delivered' ? 'completed' : ''); ?>">
                            <h6><i class="fas fa-shipping-fast"></i> Shipped</h6>
                            <p>Your order has been shipped and is on the way.</p>
                            <?php if ($order['tracking_number']): ?>
                                <p><strong>Tracking Number:</strong> <?php echo htmlspecialchars($order['tracking_number']); ?></p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="timeline-item <?php echo ($order['order_status'] == 'Delivered') ? 'active completed' : ''; ?>">
                            <h6><i class="fas fa-check-circle"></i> Delivered</h6>
                            <p>Your order has been delivered. Enjoy!</p>
                        </div>
                        
                        <?php if ($order['order_status'] == 'Cancelled'): ?>
                        <div class="timeline-item active" style="border-left-color: #dc3545; background: #f8d7da;">
                            <h6><i class="fas fa-times-circle"></i> Cancelled</h6>
                            <p>This order has been cancelled.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning mt-4">
                Order not found. Please check your order ID.
            </div>
        <?php endif; ?>
        
        <a href="index.php" class="btn btn-primary mt-3">Back to Home</a>
    </div>
    
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>

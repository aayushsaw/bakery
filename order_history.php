<?php
/**
 * Order History Page
 * Shows all orders for logged-in user
 */

require_once('config.php');
require_once('includes/security.php');

init_secure_session();
require_login();

$user_id = $_SESSION['user_users_id'];

// Fetch user's orders
$query = "SELECT * FROM cake_shop_orders WHERE users_id = ? ORDER BY created_at DESC";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $orders = mysqli_stmt_get_result($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - Bakery Shop</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container mt-5">
        <h2>My Order History</h2>
        
        <?php if ($orders && mysqli_num_rows($orders) > 0): ?>
            <div class="table-responsive mt-4">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Total Amount</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = mysqli_fetch_assoc($orders)): ?>
                            <tr>
                                <td>#<?php echo $order['orders_id']; ?></td>
                                <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                                <td>₹<?php echo number_format($order['total_amount'], 2); ?></td>
                                <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                                <td>
                                    <span class="badge badge-<?php 
                                        echo ($order['order_status'] == 'Delivered') ? 'success' : 
                                             (($order['order_status'] == 'Cancelled') ? 'danger' : 'info'); 
                                    ?>">
                                        <?php echo htmlspecialchars($order['order_status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="track_order.php?order_id=<?php echo $order['orders_id']; ?>" class="btn btn-sm btn-primary">Track</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info mt-4">
                You haven't placed any orders yet.
            </div>
            <a href="shop.php" class="btn btn-primary">Start Shopping</a>
        <?php endif; ?>
    </div>
    
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
</body>
</html>
<?php 
if ($stmt) mysqli_stmt_close($stmt);
mysqli_close($conn); 
?>

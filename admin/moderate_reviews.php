<?php
/**
 * Admin Review Moderation
 * Allows admin to approve/reject customer reviews
 */

session_start();
if (!empty($_SESSION['admin_admin_id']) && !empty($_SESSION['admin_admin_username'])) {
    $printUsername = $_SESSION['admin_admin_username'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Moderate Reviews - Admin Panel</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href="../fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../fonts/fontawesome/css/fontawesome-all.css">
</head>

<body>
    <div class="dashboard-main-wrapper">
        <!-- Navigation (copy from other admin pages) -->
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="dashboard.php">Bakery Admin</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
                    <span class="fas fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="account_admin.php"><?php echo $printUsername; ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="container-fluid dashboard-content">
            <div class="row">
                <div class="col-xl-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Moderate Reviews</h2>
                        <p class="pageheader-text">Approve or reject customer product reviews</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <h5 class="card-header">Pending Reviews</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Product</th>
                                            <th>User</th>
                                            <th>Rating</th>
                                            <th>Review</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require_once('../config.php');
                                        
                                        // Handle approve/reject actions
                                        if (isset($_GET['action']) && isset($_GET['review_id'])) {
                                            $review_id = (int)$_GET['review_id'];
                                            $action = $_GET['action'];
                                            
                                            if ($action === 'approve') {
                                                $update = "UPDATE cake_shop_reviews SET approved = 1 WHERE review_id = ?";
                                                $stmt = mysqli_prepare($conn, $update);
                                                if ($stmt) {
                                                    mysqli_stmt_bind_param($stmt, "i", $review_id);
                                                    mysqli_stmt_execute($stmt);
                                                    mysqli_stmt_close($stmt);
                                                    
                                                    // Update product average rating
                                                    $get_product = "SELECT product_id FROM cake_shop_reviews WHERE review_id = ?";
                                                    $stmt2 = mysqli_prepare($conn, $get_product);
                                                    if ($stmt2) {
                                                        mysqli_stmt_bind_param($stmt2, "i", $review_id);
                                                        mysqli_stmt_execute($stmt2);
                                                        $result = mysqli_stmt_get_result($stmt2);
                                                        if ($row = mysqli_fetch_assoc($result)) {
                                                            $product_id = $row['product_id'];
                                                            
                                                            // Calculate average
                                                            $avg_query = "SELECT AVG(rating) as avg_rating, COUNT(*) as total 
                                                                         FROM cake_shop_reviews 
                                                                         WHERE product_id = ? AND approved = 1";
                                                            $stmt3 = mysqli_prepare($conn, $avg_query);
                                                            if ($stmt3) {
                                                                mysqli_stmt_bind_param($stmt3, "i", $product_id);
                                                                mysqli_stmt_execute($stmt3);
                                                                $avg_result = mysqli_stmt_get_result($stmt3);
                                                                if ($avg_row = mysqli_fetch_assoc($avg_result)) {
                                                                    $update_product = "UPDATE cake_shop_product 
                                                                                      SET average_rating = ?, total_reviews = ? 
                                                                                      WHERE product_id = ?";
                                                                    $stmt4 = mysqli_prepare($conn, $update_product);
                                                                    if ($stmt4) {
                                                                        mysqli_stmt_bind_param($stmt4, "dii", 
                                                                            $avg_row['avg_rating'], 
                                                                            $avg_row['total'], 
                                                                            $product_id
                                                                        );
                                                                        mysqli_stmt_execute($stmt4);
                                                                        mysqli_stmt_close($stmt4);
                                                                    }
                                                                }
                                                                mysqli_stmt_close($stmt3);
                                                            }
                                                        }
                                                        mysqli_stmt_close($stmt2);
                                                    }
                                                    
                                                    echo '<div class="alert alert-success">Review approved successfully!</div>';
                                                }
                                            } elseif ($action === 'reject') {
                                                $delete = "DELETE FROM cake_shop_reviews WHERE review_id = ?";
                                                $stmt = mysqli_prepare($conn, $delete);
                                                if ($stmt) {
                                                    mysqli_stmt_bind_param($stmt, "i", $review_id);
                                                    mysqli_stmt_execute($stmt);
                                                    mysqli_stmt_close($stmt);
                                                    echo '<div class="alert alert-warning">Review rejected and deleted.</div>';
                                                }
                                            }
                                        }
                                        
                                        // Fetch pending reviews
                                        $query = "SELECT r.*, p.product_name, u.users_username 
                                                 FROM cake_shop_reviews r 
                                                 JOIN cake_shop_product p ON r.product_id = p.product_id 
                                                 JOIN cake_shop_users_registrations u ON r.user_id = u.users_id 
                                                 WHERE r.approved = 0 
                                                 ORDER BY r.created_at DESC";
                                        $result = mysqli_query($conn, $query);
                                        
                                        if ($result && mysqli_num_rows($result) > 0) {
                                            while ($review = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $review['review_id']; ?></td>
                                            <td><?php echo htmlspecialchars($review['product_name']); ?></td>
                                            <td><?php echo htmlspecialchars($review['users_username']); ?></td>
                                            <td><?php echo str_repeat('⭐', $review['rating']); ?></td>
                                            <td>
                                                <?php if (!empty($review['review_title'])): ?>
                                                    <strong><?php echo htmlspecialchars($review['review_title']); ?></strong><br>
                                                <?php endif; ?>
                                                <?php echo htmlspecialchars($review['review_text']); ?>
                                            </td>
                                            <td><?php echo date('M d, Y', strtotime($review['created_at'])); ?></td>
                                            <td>
                                                <a href="?action=approve&review_id=<?php echo $review['review_id']; ?>" 
                                                   class="btn btn-sm btn-success"
                                                   onclick="return confirm('Approve this review?')">
                                                    Approve
                                                </a>
                                                <a href="?action=reject&review_id=<?php echo $review['review_id']; ?>" 
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Reject and delete this review?')">
                                                    Reject
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        } else {
                                            echo '<tr><td colspan="7" class="text-center">No pending reviews</td></tr>';
                                        }
                                        mysqli_close($conn);
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer mt-5">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            Created By - Aayush Saw
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.bundle.js"></script>
</body>
</html>
<?php
} else {
    header("Location: index.php");
}
?>

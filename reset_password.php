<?php
/**
 * Reset Password Form
 * Allows user to set new password with valid token
 */

require_once('config.php');
require_once('includes/security.php');

init_secure_session();

$token = isset($_GET['token']) ? sanitize_input($_GET['token']) : '';
$valid_token = false;

if (!empty($token)) {
    // Verify token
    $query = "SELECT users_id, users_username FROM cake_shop_users_registrations WHERE reset_token = ? AND reset_token_expires > NOW()";
    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $token);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $valid_token = true;
        }
        
        mysqli_stmt_close($stmt);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Reset Password - Bakery Shop</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
    html, body { height: 100%; }
    body { display: flex; align-items: center; padding-top: 40px; padding-bottom: 40px; }
    </style>
</head>
<body>
    <div class="splash-container">
        <div class="card">
            <div class="card-header text-center">
                <h2 class="text-primary">Reset Password</h2>
            </div>
            <div class="card-body">
                <?php if ($valid_token): ?>
                    <?php display_flash_message(); ?>
                    <form method="post" action="process_reset.php">
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                        <?php echo csrf_token_field(); ?>
                        
                        <div class="form-group">
                            <input class="form-control form-control-lg" type="password" name="new_password" required placeholder="New Password" minlength="6">
                        </div>
                        
                        <div class="form-group">
                            <input class="form-control form-control-lg" type="password" name="confirm_password" required placeholder="Confirm Password" minlength="6">
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Reset Password</button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-danger">
                        <strong>Invalid or Expired Link</strong><br>
                        This password reset link is invalid or has expired. Please request a new one.
                    </div>
                    <a href="forgot_password.php" class="btn btn-primary btn-block">Request New Link</a>
                <?php endif; ?>
            </div>
            <div class="card-footer bg-white p-0">
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="login_users.php" class="footer-link">Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php mysqli_close($conn); ?>

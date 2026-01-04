<?php
/**
 * Forgot Password Page
 * Form to request password reset
 */

require_once('includes/security.php');
init_secure_session();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Forgot Password - Bakery Shop</title>
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
                <h2 class="text-primary">Forgot Password?</h2>
                <span class="splash-description">Enter your email to reset your password.</span>
            </div>
            <div class="card-body">
                <?php display_flash_message(); ?>
                <form method="post" action="send_reset_link.php">
                    <?php echo csrf_token_field(); ?>
                    <div class="form-group">
                        <input class="form-control form-control-lg" type="email" name="users_email" required placeholder="Email Address" autocomplete="off">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Send Reset Link</button>
                </form>
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

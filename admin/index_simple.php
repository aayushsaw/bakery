<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Login - Bakery Shop</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href="../fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../fonts/fontawesome/css/fontawesome-all.css">
    <style>
    html, body {
        height: 100%;
    }
    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    </style>
</head>

<body>
    <div class="splash-container">
        <div class="card">
            <div class="card-header text-center">
                <h2 class="text-primary">Bakery Shop Admin</h2>
                <span class="splash-description">Please enter your credentials</span>
            </div>
            <div class="card-body">
                <?php if (isset($_GET['login_error'])): ?>
                <div class="alert alert-danger">Invalid username or password!</div>
                <?php endif; ?>
                
                <form method="post" action="login_check_simple.php">
                    <div class="form-group">
                        <input class="form-control form-control-lg" type="text" name="admin_username" required placeholder="Username" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" type="password" name="admin_password" required placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
                </form>
            </div>
            <div class="card-footer bg-white p-0">
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="../index.php" class="footer-link">Back to Website</a>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.bundle.js"></script>
</body>
</html>

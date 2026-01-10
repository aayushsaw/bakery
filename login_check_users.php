<?php
/**
 * User Login Handler - Simplified for InfinityFree
 */

session_start();
require_once('config_secure.php');

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login_users.php");
    exit();
}

// Get inputs
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Validate inputs
if (empty($username) || empty($password)) {
    header("Location: login_users.php?login_error=empty_fields");
    exit();
}

// Fetch user
$query = "SELECT * FROM cake_shop_users_registrations WHERE users_username = ?";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        // Verify password
        if (password_verify($password, $row['users_password'])) {
            // Check if email is verified (if column exists)
            if (isset($row['email_verified']) && $row['email_verified'] == 0) {
                mysqli_stmt_close($stmt);
                header("Location: login_users.php?login_error=email_not_verified");
                exit();
            }
            
            // Login successful
            $_SESSION['user_users_id'] = $row['users_id'];
            $_SESSION['user_users_username'] = $row['users_username'];
            $_SESSION['user_users_email'] = $row['users_email'];
            
            mysqli_stmt_close($stmt);
            header("Location: index.php?login_success=1");
            exit();
        }
    }
    
    mysqli_stmt_close($stmt);
}

// Login failed
header("Location: login_users.php?login_error=1");
exit();
?>
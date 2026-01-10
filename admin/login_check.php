<?php
session_start();
require_once('../config_secure.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

$admin_username = trim($_POST['admin_username']);
$admin_password = $_POST['admin_password'];

$query = "SELECT * FROM cake_shop_admin_registrations WHERE admin_username = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $admin_username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    if (password_verify($admin_password, $row['admin_password'])) {
        $_SESSION['user_admin_id'] = $row['admin_id'];
        $_SESSION['user_admin_username'] = $row['admin_username'];
        header("Location: dashboard.php");
        exit();
    }
}

header("Location: index.php?login_error=1");
exit();
?>
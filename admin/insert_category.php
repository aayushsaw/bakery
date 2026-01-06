<?php
session_start();
require_once('../config_secure.php');

// Check if admin is logged in
if (!isset($_SESSION['user_admin_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = trim($_POST['category_name']);
    
    if (!empty($category_name)) {
        $query = "INSERT INTO cake_shop_category (category_name) VALUES (?)";
        $stmt = mysqli_prepare($conn, $query);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $category_name);
            
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                header("Location: view_category.php?success=1");
                exit();
            }
        }
    }
    
    header("Location: add_category.php?error=1");
    exit();
}

header("Location: add_category.php");
exit();
?>
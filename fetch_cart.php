<?php
session_start();
// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    // Simply add the product ID to cart (allows duplicates for quantity)
    $_SESSION['cart'][] = $id;
}

echo json_encode($_SESSION['cart']);
?>
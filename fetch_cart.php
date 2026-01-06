<?php
session_start();
// Initialize cart with quantities if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    
    // Check if product already exists in cart
    $found = false;
    foreach($_SESSION['cart'] as $key => $item) {
        if($item['id'] == $id) {
            // Product exists, increment quantity
            $_SESSION['cart'][$key]['quantity']++;
            $found = true;
            break;
        }
    }
    
    // If product not found, add new item with quantity 1
    if(!$found) {
        $_SESSION['cart'][] = array('id' => $id, 'quantity' => 1);
    }
}

echo json_encode($_SESSION['cart']);
?>
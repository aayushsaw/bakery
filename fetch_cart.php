<?php
session_start();

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Convert old format to new format if needed
if (!empty($_SESSION['cart']) && !is_array(reset($_SESSION['cart']))) {
    // Old format detected: ["1", "2", "3"]
    // Convert to new format: [{"id": "1", "quantity": 1}, ...]
    $old_cart = $_SESSION['cart'];
    $_SESSION['cart'] = array();
    $counts = array_count_values($old_cart);
    foreach($counts as $id => $quantity) {
        $_SESSION['cart'][] = array('id' => $id, 'quantity' => $quantity);
    }
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
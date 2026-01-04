<?php
/**
 * Submit Review Handler
 * Processes customer product reviews
 */

require_once('config.php');
require_once('includes/security.php');

init_secure_session();

// Check if user is logged in
if (!is_logged_in()) {
    header("Location: login_users.php?error=login_required");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: shop.php");
    exit();
}

if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
    header("Location: shop.php?error=invalid_request");
    exit();
}

$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
$review_title = sanitize_input(isset($_POST['review_title']) ? $_POST['review_title'] : '');
$review_text = sanitize_input(isset($_POST['review_text']) ? $_POST['review_text'] : '');
$user_id = $_SESSION['user_users_id'];

// Validation
if ($product_id <= 0 || $rating < 1 || $rating > 5) {
    header("Location: single_product.php?product_id=$product_id&error=invalid_data");
    exit();
}

// Check if user already reviewed this product
$check_query = "SELECT review_id FROM cake_shop_reviews WHERE user_id = ? AND product_id = ?";
$check_stmt = mysqli_prepare($conn, $check_query);

if ($check_stmt) {
    mysqli_stmt_bind_param($check_stmt, "ii", $user_id, $product_id);
    mysqli_stmt_execute($check_stmt);
    mysqli_stmt_store_result($check_stmt);
    
    if (mysqli_stmt_num_rows($check_stmt) > 0) {
        mysqli_stmt_close($check_stmt);
        header("Location: single_product.php?product_id=$product_id&error=already_reviewed");
        exit();
    }
    
    mysqli_stmt_close($check_stmt);
}

// Insert review
$insert_query = "INSERT INTO cake_shop_reviews (product_id, user_id, rating, review_title, review_text, approved) VALUES (?, ?, ?, ?, ?, 0)";
$stmt = mysqli_prepare($conn, $insert_query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "iiiss", $product_id, $user_id, $rating, $review_title, $review_text);
    
    if (mysqli_stmt_execute($stmt)) {
        log_security_event('REVIEW_SUBMITTED', "Review submitted for product $product_id by user $user_id");
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        
        header("Location: single_product.php?product_id=$product_id&message=review_submitted");
        exit();
    }
    
    mysqli_stmt_close($stmt);
}

header("Location: single_product.php?product_id=$product_id&error=submission_failed");

mysqli_close($conn);
?>

\u003c?php
session_start();
// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
$id = $_GET['id'];
if (!in_array($id, $_SESSION['cart'])) {
\t$_SESSION['cart'][] = $id;
}
echo json_encode($_SESSION['cart']);
?\u003e
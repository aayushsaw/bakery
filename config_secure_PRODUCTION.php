<?php
// Production Database Configuration for InfinityFree
// Replace the content of config_secure.php with this

$db_host = "sql103.infinityfree.com";
$db_user = "if0_40824927";
$db_pass = "BakeryShop123";
$db_name = "if0_40824927_bakery_db";

// Connect to database
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<?php
/**
 * Product Search Page
 * Displays search results with filters
 */

require_once('config_secure.php');
require_once('includes/security.php');

init_secure_session();

$search_query = isset($_GET['q']) ? sanitize_input($_GET['q']) : '';
$category_filter = isset($_GET['category']) ? sanitize_input($_GET['category']) : '';
$min_price = isset($_GET['min_price']) ? (int)$_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? (int)$_GET['max_price'] : 10000;

// Build search query
$sql = "SELECT p.*, c.category_name FROM cake_shop_product p 
        LEFT JOIN cake_shop_category c ON p.product_category = c.category_id 
        WHERE 1=1";
$params = array();
$types = "";

if (!empty($search_query)) {
    $sql .= " AND (p.product_name LIKE ? OR p.product_description LIKE ?)";
    $search_term = "%$search_query%";
    $params[] = $search_term;
    $params[] = $search_term;
    $types .= "ss";
}

if (!empty($category_filter)) {
    $sql .= " AND p.product_category = ?";
    $params[] = $category_filter;
    $types .= "i";
}

$sql .= " AND p.product_price BETWEEN ? AND ?";
$params[] = $min_price;
$params[] = $max_price;
$types .= "ii";

$sql .= " ORDER BY p.product_name ASC";

$stmt = mysqli_prepare($conn, $sql);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$products = mysqli_stmt_get_result($stmt);

// Get categories for filter
$cat_query = "SELECT * FROM cake_shop_category";
$categories = mysqli_query($conn, $cat_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - Bakery Shop</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="fonts/fontawesome/css/fontawesome-all.css">
</head>
<body>
    <!-- Navigation (copy from index.php) -->
    
    <div class="container mt-5">
        <h2>Search Results for "<?php echo htmlspecialchars($search_query); ?>"</h2>
        
        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-md-12">
                <form method="GET" action="search.php" class="form-inline">
                    <input type="text" name="q" class="form-control mr-2" placeholder="Search..." value="<?php echo htmlspecialchars($search_query); ?>">
                    
                    <select name="category" class="form-control mr-2">
                        <option value="">All Categories</option>
                        <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                            <option value="<?php echo $cat['category_id']; ?>" <?php echo ($category_filter == $cat['category_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['category_name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    
                    <input type="number" name="min_price" class="form-control mr-2" placeholder="Min Price" value="<?php echo $min_price; ?>" style="width:120px;">
                    <input type="number" name="max_price" class="form-control mr-2" placeholder="Max Price" value="<?php echo $max_price; ?>" style="width:120px;">
                    
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            </div>
        </div>
        
        <!-- Results -->
        <div class="row">
            <?php if (mysqli_num_rows($products) > 0): ?>
                <?php while ($product = mysqli_fetch_assoc($products)): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="uploads/<?php echo $product['product_image1']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['product_name']); ?></h5>
                                <p class="card-text">₹<?php echo number_format($product['product_price'], 2); ?></p>
                                <span class="badge badge-secondary"><?php echo htmlspecialchars($product['category_name']); ?></span>
                                <a href="single_product.php?product_id=<?php echo $product['product_id']; ?>" class="btn btn-primary btn-block mt-2">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        No products found matching your search criteria.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Footer (copy from index.php) -->
    
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>

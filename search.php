<?php
/**
 * Product Search Page - Simplified for InfinityFree
 */

session_start();
require_once('config_secure.php');

$search_query = isset($_GET['q']) ? trim($_GET['q']) : '';
$category_filter = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$min_price = isset($_GET['min_price']) ? (int)$_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? (int)$_GET['max_price'] : 10000;

// Build search query
$sql = "SELECT p.*, c.category_name FROM cake_shop_product p 
        LEFT JOIN cake_shop_category c ON p.product_category = c.category_id 
        WHERE 1=1";

if (!empty($search_query)) {
    $search_term = "%" . mysqli_real_escape_string($conn, $search_query) . "%";
    $sql .= " AND (p.product_name LIKE '$search_term' OR p.product_description LIKE '$search_term')";
}

if ($category_filter > 0) {
    $sql .= " AND p.product_category = $category_filter";
}

$sql .= " AND p.product_price BETWEEN $min_price AND $max_price";
$sql .= " ORDER BY p.product_name ASC";

$products = mysqli_query($conn, $sql);

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
    <div class="container mt-5">
        <h2>Search Results<?php if($search_query) echo ' for "' . htmlspecialchars($search_query) . '"'; ?></h2>
        
        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-md-12">
                <form method="GET" action="search.php" class="form-inline">
                    <input type="text" name="q" class="form-control mr-2" placeholder="Search..." value="<?php echo htmlspecialchars($search_query); ?>">
                    
                    <select name="category" class="form-control mr-2">
                        <option value="">All Categories</option>
                        <?php 
                        mysqli_data_seek($categories, 0);
                        while ($cat = mysqli_fetch_assoc($categories)): 
                        ?>
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
            <?php if ($products && mysqli_num_rows($products) > 0): ?>
                <?php while ($product = mysqli_fetch_assoc($products)): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <?php
                            // Handle multiple images - use only first one
                            $images = explode(', ', $product['product_image']);
                            $first_image = trim($images[0]);
                            ?>
                            <img src="uploads/<?php echo htmlspecialchars($first_image); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['product_name']); ?>" style="max-height: 200px; object-fit: cover;">
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
    
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>

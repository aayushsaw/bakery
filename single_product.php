<?php
session_start();
if (!empty($_SESSION['cart'])) {
    $printCount = count($_SESSION['cart']);
}
else {
    $printCount = 0;
}
if (!empty($_SESSION['user_users_id']) && !empty($_SESSION['user_users_username'])) {
    $printUsername = $_SESSION['user_users_username'];
}
else {
    $printUsername = "None"; 
}
?>
<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>OCS - Product Details</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/userpage.css">
    <link rel="stylesheet" href="fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="css/owl.theme.default.min.css">
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
         <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
         <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="#">Bakery Shop</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span><i class="fas fa-bars mx-3
"></i></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link active" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Shop</a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink1">
                            <?php
                            require_once('config_secure.php');
                            $select = "SELECT * FROM cake_shop_category";
                            $query = mysqli_query($conn, $select);
                            while ($res = mysqli_fetch_assoc($query)) {
                            ?>
                                <a class="dropdown-item" href="shop.php?category=<?php echo $res['category_id'];?>">
                                    <?php echo $res['category_name'];?>
                                </a>
                            <?php
                            }
                            ?>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> <span class="badge badge-pill badge-secondary"><?php echo $printCount;?></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact</a>
                        </li>
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="uploads/default-image.jpg" alt="" class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name"><?php echo $printUsername;?></h5>
                                    <span class="status"></span><span class="ml-2">Available</span>
                                </div>
                                <a class="dropdown-item" href="account_users.php"><i class="fas fa-user mr-2"></i>Account</a>
                                <a class="dropdown-item" href="login_users.php"><i class="fas fa-sign-in-alt mr-2"></i>Login</a>
                                <a class="dropdown-item" href="logout_users.php"><i class="fas fa-power-off mr-2"></i>Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <!-- <div class="dashboard-wrapper"> -->
            <div class="container-fluid dashboard-content">    
                
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">Product</h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php" class="breadcrumb-link">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Product details</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mx-5">

                    <?php
                    require_once('config_secure.php');
                    $product_id = $_GET['product_id'];
                    $select = "SELECT * FROM cake_shop_product where product_id = $product_id";
                    $query = mysqli_query($conn, $select);
                    $res = mysqli_fetch_assoc($query);
                    ?>
                    <div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 pr-xl-0 pr-lg-0 pr-md-0 m-b-30">
                                <div class="product-slider p-4">
                                    <div id="carouselExampleIndicators" class="product-carousel carousel slide" data-ride="carousel">
                                        <?php
                                        $file_array = explode(', ', $res['product_image']);
                                        ?>
                                        <div class="carousel-inner">
                                            <?php
                                            for ($i = 0; $i < count($file_array); $i++) {
                                            ?>
                                            <div class="carousel-item <?php if($i == 0) {echo 'active';} ?>">
                                                <img class="d-block w-100" src="uploads/<?php echo $file_array[$i];?>" alt="slide<?php echo $i;?>">
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 pl-xl-0 pl-lg-0 pl-md-0 border-left m-b-30 d-flex">
                                <div class="product-details p-4">
                                    <div class="border-bottom pb-3 mb-3">
                                        <h2 class="mb-3"><?php echo $res['product_name'];?></h2>
                                        <h3 class="mb-0 text-primary">Rs. <?php echo $res['product_price'];?></h3>
                                    </div>
                                    <div class="product-description">
                                        <h4 class="mb-1">Descriptions</h4>
                                        <p><?php echo $res['product_description'];?></p>
                                        <button onclick="add_cart(<?php echo $res['product_id'];?>)" class="btn btn-primary btn-block btn-lg">Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row m-5">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                        <h1>Our Categories</h1>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="owl-carousel owl-theme">
                            <?php
                            require_once('config_secure.php');
                            $select = "SELECT * FROM cake_shop_category";
                            $query = mysqli_query($conn, $select);
                            while ($res = mysqli_fetch_assoc($query)) {
                            ?>
                            <div class="item">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h3 class="card-title"><?php echo $res['category_name'];?></h3>
                                        <a href="shop.php?category=<?php echo $res['category_id'];?>"><img class="card-img" src="uploads/<?php echo $res['category_image'];?>"></a>
                                    </div>
                                    
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>

            </div>
            
            <!-- Reviews Section -->
            <div class="container-fluid dashboard-content mt-5">
                <div class="row">
                    <div class="col-12">
                        <h3>Customer Reviews</h3>
                        <hr>
                        
                        <?php
                        // Display existing reviews
                        $review_query = "SELECT r.*, u.users_username 
                                        FROM cake_shop_reviews r 
                                        JOIN cake_shop_users_registrations u ON r.user_id = u.users_id 
                                        WHERE r.product_id = ? AND r.approved = 1 
                                        ORDER BY r.created_at DESC";
                        $review_stmt = mysqli_prepare($conn, $review_query);
                        if ($review_stmt) {
                            mysqli_stmt_bind_param($review_stmt, "i", $product_id);
                            mysqli_stmt_execute($review_stmt);
                            $reviews = mysqli_stmt_get_result($review_stmt);
                            
                            if (mysqli_num_rows($reviews) > 0) {
                                while ($review = mysqli_fetch_assoc($reviews)) {
                        ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title"><?php echo htmlspecialchars($review['users_username']); ?></h5>
                                    <span class="text-warning">
                                        <?php echo str_repeat('⭐', $review['rating']); ?>
                                    </span>
                                </div>
                                <?php if (!empty($review['review_title'])): ?>
                                    <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($review['review_title']); ?></h6>
                                <?php endif; ?>
                                <p class="card-text"><?php echo htmlspecialchars($review['review_text']); ?></p>
                                <small class="text-muted">Posted on <?php echo date('M d, Y', strtotime($review['created_at'])); ?></small>
                            </div>
                        </div>
                        <?php
                                }
                            } else {
                                echo '<p class="text-muted">No reviews yet. Be the first to review this product!</p>';
                            }
                            mysqli_stmt_close($review_stmt);
                        }
                        ?>
                        
                        <!-- Review Form -->
                        <?php if (isset($_SESSION['user_users_id'])): ?>
                            <?php
                            // Check if user already reviewed
                            $check_query = "SELECT review_id FROM cake_shop_reviews WHERE user_id = ? AND product_id = ?";
                            $check_stmt = mysqli_prepare($conn, $check_query);
                            $already_reviewed = false;
                            if ($check_stmt) {
                                mysqli_stmt_bind_param($check_stmt, "ii", $_SESSION['user_users_id'], $product_id);
                                mysqli_stmt_execute($check_stmt);
                                mysqli_stmt_store_result($check_stmt);
                                $already_reviewed = (mysqli_stmt_num_rows($check_stmt) > 0);
                                mysqli_stmt_close($check_stmt);
                            }
                            ?>
                            
                            <?php if (!$already_reviewed): ?>
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h5>Write a Review</h5>
                                </div>
                                <div class="card-body">
                                    <form action="submit_review.php" method="POST">
                                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                        <?php 
                                        require_once('includes/security.php');
                                        echo csrf_token_field(); 
                                        ?>
                                        
                                        <div class="form-group">
                                            <label>Rating <span class="text-danger">*</span></label>
                                            <select name="rating" class="form-control" required>
                                                <option value="">Select Rating</option>
                                                <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                                                <option value="4">⭐⭐⭐⭐ Good</option>
                                                <option value="3">⭐⭐⭐ Average</option>
                                                <option value="2">⭐⭐ Poor</option>
                                                <option value="1">⭐ Terrible</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Review Title (Optional)</label>
                                            <input type="text" name="review_title" class="form-control" placeholder="e.g., Best cake ever!" maxlength="200">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Your Review <span class="text-danger">*</span></label>
                                            <textarea name="review_text" class="form-control" rows="4" required placeholder="Share your experience with this product..."></textarea>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary">Submit Review</button>
                                    </form>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="alert alert-info mt-4">
                                You have already reviewed this product. Thank you for your feedback!
                            </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="alert alert-warning mt-4">
                                Please <a href="login_users.php">login</a> to write a review.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- End Reviews Section -->

            
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <div class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                           Created By - Aayush Saw<a href="https://colorlib.com/wp/"></a>.
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="text-md-right footer-links d-none d-sm-block">
                                <a href="javascript: void(0);">About</a>
                                <a href="javascript: void(0);">Support</a>
                                <a href="javascript: void(0);">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        <!-- </div> -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/jquery.slimscroll.js"></script>
    <script src="js/main-js.js"></script>
    <script type="text/javascript" src="js/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.owl-carousel').owlCarousel({
                loop: true, margin: 10, dots: 0, autoplay: 4000, autoplayHoverPause: true, responsive:{
                    0:{items:1}, 600:{items:2}, 1000:{items:4}
                }
            })
        });
        function add_cart(product_id) {
                $.ajax({
                    url:'fetch_cart.php',
                    data:'id='+product_id,
                    method:'get',
                    dataType:'json',
                    success:function(cart){
                        console.log(cart);
                        $('.badge').html(cart.length);
                    }
                });
            }
    </script>
</body>
 
</html>

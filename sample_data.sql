-- Quick Sample Data for InfinityFree Deployment
-- Run this in phpMyAdmin to populate your database

-- Add Categories
INSERT INTO `cake_shop_category` (`category_id`, `category_name`, `category_image`) VALUES
(1, 'Cakes', 'default-image.jpg'),
(2, 'Cookies', 'default-image.jpg'),
(3, 'Pastries', 'default-image.jpg'),
(4, 'Desserts', 'default-image.jpg');

-- Add Sample Products
INSERT INTO `cake_shop_product` (`product_id`, `category_id`, `product_name`, `product_description`, `product_price`, `product_image`, `average_rating`, `total_reviews`) VALUES
(1, 1, 'Chocolate Cake', 'Delicious chocolate cake with rich frosting', 25.99, 'default-image.jpg', 0.00, 0),
(2, 1, 'Vanilla Cake', 'Classic vanilla cake with buttercream', 22.99, 'default-image.jpg', 0.00, 0),
(3, 2, 'Chocolate Chip Cookies', 'Fresh baked chocolate chip cookies', 8.99, 'default-image.jpg', 0.00, 0),
(4, 2, 'Oatmeal Cookies', 'Healthy oatmeal raisin cookies', 7.99, 'default-image.jpg', 0.00, 0),
(5, 3, 'Croissant', 'Buttery French croissant', 3.99, 'default-image.jpg', 0.00, 0),
(6, 3, 'Danish Pastry', 'Sweet Danish pastry with fruit filling', 4.99, 'default-image.jpg', 0.00, 0),
(7, 4, 'Tiramisu', 'Italian coffee-flavored dessert', 12.99, 'default-image.jpg', 0.00, 0),
(8, 4, 'Cheesecake', 'Creamy New York style cheesecake', 15.99, 'default-image.jpg', 0.00, 0);

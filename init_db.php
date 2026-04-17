<?php
include "db.php";

// 1. Create products table
$sql_products = "CREATE TABLE IF NOT EXISTS products (
    id VARCHAR(50) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    brand VARCHAR(255),
    category VARCHAR(255),
    price DECIMAL(10, 2),
    originalPrice DECIMAL(10, 2),
    condition_text VARCHAR(50),
    location VARCHAR(255),
    featured BOOLEAN DEFAULT FALSE,
    createdAt BIGINT,
    shipping VARCHAR(255)
)";
mysqli_query($conn, $sql_products);

// 2. Create orders table (Sync with admin_orders.php and update_order.php)
$sql_orders = "CREATE TABLE IF NOT EXISTS orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(50),
    product_id VARCHAR(50),
    product_name VARCHAR(255),
    order_status VARCHAR(50) DEFAULT 'Placed',
    shipping_date DATE,
    delivery_date DATE,
    payment_status VARCHAR(50) DEFAULT 'Pending',
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id)
)";
mysqli_query($conn, $sql_orders);

// 3. Consolidated products from browse.php and _scripts.php
$all_products = [
    // From browse.php
    ['p1', 'iPhone 14 Pro', 'Apple', 'Phones', 749, 849, 'Like New', 'USA', 1, 1679872000000, 'Delivery'],
    ['p2', 'Samsung Galaxy S23', 'Samsung', 'Phones', 699, 799, 'New', 'UK', 0, 1679872000000, 'Delivery Pickup'],
    ['p3', 'MacBook Air M2', 'Apple', 'Laptops', 999, 1199, 'Like New', 'Canada', 1, 1679872000000, 'Delivery'],
    ['p4', 'iPad Pro 12.9"', 'Apple', 'Tablets', 650, 750, 'Used', 'UAE', 0, 1679872000000, 'Pickup'],
    ['p5', 'Sony WH-1000XM5', 'Sony', 'Accessories', 280, 350, 'New', 'India', 0, 1679872000000, 'Delivery'],
    ['p6', 'Dell XPS 15', 'Dell', 'Laptops', 850, 1050, 'Refurbished', 'USA', 1, 1679872000000, 'Delivery Pickup'],
    ['p7', 'PlayStation 5', 'Sony', 'Gaming', 420, 499, 'Like New', 'UK', 0, 1679872000000, 'Delivery'],
    ['p8', 'Google Pixel 7', 'Google', 'Phones', 399, 499, 'Open Box', 'USA', 0, 1679872000000, 'Delivery Pickup'],
    ['p9', 'Surface Pro 9', 'Microsoft', 'Tablets', 1099, 1299, 'New', 'Canada', 1, 1679872000000, 'Delivery'],
    ['p10', 'Nintendo Switch OLED', 'Nintendo', 'Gaming', 280, 350, 'Used', 'Australia', 0, 1679872000000, 'Pickup'],
    
    // Additional items from _scripts.php logic (simplified for DB)
    ['l1', 'MacBook Pro 16" M3 Max', 'Apple', 'Laptops', 2499, 3499, 'New', 'San Francisco, USA', 1, 1712415174000, 'Delivery Pickup'],
    ['l3', 'Dell XPS 15 Plus', 'Dell', 'Laptops', 1699, 1999, 'New', 'Austin, USA', 1, 1712242374000, 'Delivery Pickup'],
    ['t1', 'iPad Pro 12.9" M2', 'Apple', 'Tablets', 899, 1099, 'New', 'San Francisco, USA', 1, 1711205574000, 'Delivery Pickup'],
    ['a1', 'Apple AirPods Pro 2', 'Apple', 'Accessories', 179, 249, 'New', 'San Francisco, USA', 1, 1710168774000, 'Delivery Pickup']
];

echo "<h2>Database Synchronization</h2>";
foreach ($all_products as $p) {
    $id = mysqli_real_escape_string($conn, $p[0]);
    $name = mysqli_real_escape_string($conn, $p[1]);
    $brand = mysqli_real_escape_string($conn, $p[2]);
    $cat = mysqli_real_escape_string($conn, $p[3]);
    $price = $p[4];
    $orig = $p[5];
    $cond = mysqli_real_escape_string($conn, $p[6]);
    $loc = mysqli_real_escape_string($conn, $p[7]);
    $feat = $p[8];
    $time = $p[9];
    $ship = mysqli_real_escape_string($conn, $p[10]);

    $sql = "INSERT INTO products (id, name, brand, category, price, originalPrice, condition_text, location, featured, createdAt, shipping) 
            VALUES ('$id', '$name', '$brand', '$cat', $price, $orig, '$cond', '$loc', $feat, $time, '$ship')
            ON DUPLICATE KEY UPDATE name='$name', price=$price";
    
    if (mysqli_query($conn, $sql)) {
        echo "Product $id synced ✅<br>";
    } else {
        echo "Error syncing $id: " . mysqli_error($conn) . " ❌<br>";
    }
}
echo "<h3>Ready! You can now use the Buy Now button.</h3>";
?>

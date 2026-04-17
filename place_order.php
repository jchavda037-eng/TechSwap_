<?php
session_start();
include "db.php";

// Check login
if (!isset($_SESSION['user_id'])) {
    die("User not logged in");
}

$user_id = $_SESSION['user_id'];

// Get POST data safely
$product_id = $_POST['product_id'] ?? '';
$product_name = $_POST['product_name'] ?? '';

// Validate
if(empty($product_id) || empty($product_name)){
    die("Missing data");
}

// Insert query
$sql = "INSERT INTO orders (user_id, product_id, product_name) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if(!$stmt){
    die("Prepare failed");
}

mysqli_stmt_bind_param($stmt, "iss", $user_id, $product_id, $product_name);

// Execute
if(mysqli_stmt_execute($stmt)){
    echo "Order Placed Successfully";
}else{
    echo "Error: " . mysqli_error($conn);
}

// Close (good practice)
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
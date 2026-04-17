<?php
session_start();
include('db.php');
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
  echo json_encode(["status" => "error", "message" => "Not logged in"]);
  exit;
}

// 📦 Get input from fetch request
$data = json_decode(file_get_contents("php://input"), true);
$product_id = isset($data['product_id']) ? mysqli_real_escape_string($conn, $data['product_id']) : '';

if (!$product_id) {
    echo json_encode(["status" => "error", "message" => "Invalid product ID"]);
    exit;
}

// 🔒 Always fetch from DB (security) - Using string ID support
$result = mysqli_query($conn, "SELECT * FROM products WHERE id = '$product_id'");
$product = mysqli_fetch_assoc($result);

if (!$product) {
  echo json_encode(["status" => "error", "message" => "Product not found"]);
  exit;
}

$user_id = $_SESSION['user_id'];
$product_name = mysqli_real_escape_string($conn, $product['name']);

// Insert order with improved SQL safety
$sql_order = "INSERT INTO orders (user_id, product_id, product_name, order_status, payment_status, order_date)
              VALUES ('$user_id', '$product_id', '$product_name', 'Placed', 'Pending', NOW())";

if (mysqli_query($conn, $sql_order)) {
    $orderId = (int) mysqli_insert_id($conn);
    echo json_encode([
        "status" => "success",
        "order_id" => $orderId,
        "display_order_id" => 'TS-' . str_pad((string) $orderId, 5, '0', STR_PAD_LEFT)
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "Order failed: " . mysqli_error($conn)]);
}
?>

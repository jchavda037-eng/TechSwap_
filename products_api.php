<?php
header('Content-Type: application/json');

require_once __DIR__ . '/db.php';

$result = mysqli_query(
    $conn,
    "SELECT id, name, brand, category, price, originalPrice, condition_text, location, featured, createdAt, shipping
     FROM products
     ORDER BY featured DESC, createdAt DESC, id ASC"
);

if (!$result) {
    echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    exit();
}

$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $shipping = $row['shipping'] ?? '';
    $originalPrice = isset($row['originalPrice']) ? (float) $row['originalPrice'] : null;
    $price = isset($row['price']) ? (float) $row['price'] : 0.0;
    $discount = ($originalPrice && $originalPrice > $price)
        ? (int) round((1 - ($price / $originalPrice)) * 100)
        : 0;

    $products[] = [
        'id' => $row['id'],
        'name' => $row['name'],
        'brand' => $row['brand'] ?? '',
        'category' => $row['category'] ?? '',
        'condition' => $row['condition_text'] ?? 'Used',
        'price' => $price,
        'originalPrice' => $originalPrice,
        'location' => $row['location'] ?? '',
        'featured' => !empty($row['featured']),
        'createdAt' => isset($row['createdAt']) ? (int) $row['createdAt'] : 0,
        'shipping' => $shipping,
        'delivery' => stripos($shipping, 'delivery') !== false,
        'pickup' => stripos($shipping, 'pickup') !== false,
        'discount' => $discount,
    ];
}

echo json_encode(['status' => 'success', 'data' => $products]);

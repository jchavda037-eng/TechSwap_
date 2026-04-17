<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/db.php';

function format_order_display_id(int $orderId): string {
    return 'TS-' . str_pad((string) $orderId, 5, '0', STR_PAD_LEFT);
}

if (empty($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

$userId = (int) $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? '';
    $orderId = isset($data['order_id']) ? (int) $data['order_id'] : 0;

    if ($action !== 'cancel' || $orderId <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
        exit();
    }

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE orders
         SET order_status = 'Cancelled'
         WHERE order_id = ? AND user_id = ? AND order_status IN ('Placed', 'Packed')"
    );
    mysqli_stmt_bind_param($stmt, 'ii', $orderId, $userId);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'This order cannot be cancelled.']);
    }
    mysqli_stmt_close($stmt);
    exit();
}

$stmt = mysqli_prepare(
    $conn,
    "SELECT
        o.order_id,
        o.user_id,
        o.product_id,
        o.product_name,
        o.order_status,
        o.payment_status,
        o.order_date,
        o.shipping_date,
        o.delivery_date,
        COALESCE(p.brand, '') AS product_brand,
        COALESCE(p.category, '') AS product_category,
        COALESCE(p.price, 0) AS total_price
     FROM orders o
     LEFT JOIN products p ON p.id = o.product_id
     WHERE o.user_id = ?
     ORDER BY o.order_date DESC, o.order_id DESC"
);
mysqli_stmt_bind_param($stmt, 'i', $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$orders = [];
while ($row = mysqli_fetch_assoc($result)) {
    $row['total_price'] = (float) $row['total_price'];
    $row['expected_delivery_date'] = $row['delivery_date'];
    $row['display_order_id'] = format_order_display_id((int) $row['order_id']);
    $orders[] = $row;
}

mysqli_stmt_close($stmt);

echo json_encode(['status' => 'success', 'data' => $orders]);

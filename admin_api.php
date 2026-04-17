<?php
session_start();
include "db.php";

function format_order_display_id(int $orderId): string {
    return 'TS-' . str_pad((string) $orderId, 5, '0', STR_PAD_LEFT);
}

// Simple admin check
if (!isset($_SESSION['admin_logged_in'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

$action = $_GET['action'] ?? '';

if ($action === 'get_products') {
    $res = mysqli_query($conn, "SELECT * FROM products ORDER BY featured DESC, createdAt DESC, id ASC");
    $products = mysqli_fetch_all($res, MYSQLI_ASSOC);
    echo json_encode(["status" => "success", "data" => $products]);
} 
elseif ($action === 'save_product') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = mysqli_real_escape_string($conn, $data['id']);
    $name = mysqli_real_escape_string($conn, $data['name']);
    $brand = mysqli_real_escape_string($conn, $data['brand']);
    $category = mysqli_real_escape_string($conn, $data['category']);
    $price = (float)$data['price'];
    $orig = (float)$data['originalPrice'] ?: 'NULL';
    $cond = mysqli_real_escape_string($conn, $data['condition']);
    $loc = mysqli_real_escape_string($conn, $data['location']);
    $feat = (int)$data['featured'];
    $time = time() * 1000;

    $sql = "INSERT INTO products (id, name, brand, category, price, originalPrice, condition_text, location, featured, createdAt)
            VALUES ('$id', '$name', '$brand', '$category', $price, $orig, '$cond', '$loc', $feat, $time)
            ON DUPLICATE KEY UPDATE name='$name', brand='$brand', category='$category', price=$price, originalPrice=$orig, condition_text='$cond', location='$loc', featured=$feat";
    
    if (mysqli_query($conn, $sql)) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
}
elseif ($action === 'delete_product') {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    if (mysqli_query($conn, "DELETE FROM products WHERE id='$id'")) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
}
elseif ($action === 'get_orders') {
    $res = mysqli_query(
        $conn,
        "SELECT
            o.*,
            COALESCE(p.price, 0) AS product_price,
            COALESCE(u.name, CONCAT('User #', o.user_id)) AS user_name,
            COALESCE(u.email, '') AS user_email
         FROM orders o
         LEFT JOIN products p ON p.id = o.product_id
         LEFT JOIN users u ON u.id = o.user_id
         ORDER BY o.order_date DESC, o.order_id DESC"
    );
    $orders = mysqli_fetch_all($res, MYSQLI_ASSOC);
    foreach ($orders as &$order) {
        $order['product_price'] = (float) $order['product_price'];
        $order['display_order_id'] = format_order_display_id((int) $order['order_id']);
    }
    unset($order);
    echo json_encode(["status" => "success", "data" => $orders]);
}
elseif ($action === 'update_order') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = (int)$data['order_id'];
    $status = mysqli_real_escape_string($conn, $data['order_status']);
    $payment = mysqli_real_escape_string($conn, $data['payment_status']);

    $shippingSql = "shipping_date = shipping_date";
    $deliverySql = "delivery_date = delivery_date";

    if ($status === 'Shipped' || $status === 'Out for Delivery') {
        $shippingSql = "shipping_date = COALESCE(shipping_date, CURDATE())";
    }
    if ($status === 'Delivered') {
        $shippingSql = "shipping_date = COALESCE(shipping_date, CURDATE())";
        $deliverySql = "delivery_date = COALESCE(delivery_date, CURDATE())";
    }
    if ($status === 'Cancelled') {
        $deliverySql = "delivery_date = NULL";
    }

    $sql = "UPDATE orders
            SET order_status='$status',
                payment_status='$payment',
                $shippingSql,
                $deliverySql
            WHERE order_id=$id";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
}
elseif ($action === 'get_users') {
    $res = mysqli_query($conn, "SELECT id, email, name, created_at FROM users");
    $users = mysqli_fetch_all($res, MYSQLI_ASSOC);
    echo json_encode(["status" => "success", "data" => $users]);
}
?>

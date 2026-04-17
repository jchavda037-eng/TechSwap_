<?php
include "db.php";

$result = mysqli_query($conn, "SELECT * FROM orders ORDER BY order_id DESC");

$orders = [];
while($row = mysqli_fetch_assoc($result)){
    $orders[] = $row;
}

header('Content-Type: application/json');
echo json_encode($orders);
?>
<?php
include "db.php";

$order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
$status = mysqli_real_escape_string($conn, $_POST['order_status']);
$shipping = mysqli_real_escape_string($conn, $_POST['shipping_date']);
$delivery = mysqli_real_escape_string($conn, $_POST['delivery_date']);
$payment = mysqli_real_escape_string($conn, $_POST['payment_status']);

$sql = "UPDATE orders 
        SET order_status=?, shipping_date=?, delivery_date=?, payment_status=?
        WHERE order_id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sssss", $status, $shipping, $delivery, $payment, $order_id);

if(mysqli_stmt_execute($stmt)){
    echo "Updated Successfully";
}else{
    echo "Error";
}
?>
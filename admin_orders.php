<?php
session_start();
include "db.php";

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin.php");
    exit();
}

include "_header.php";
?>

<div class="container section-sm">
    <h2>Admin - Manage Orders</h2>

    <div class="card">
        <table class="orders-table">

            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Status</th>
                <th>Shipping</th>
                <th>Delivery</th>
                <th>Payment</th>
                <th>Action</th>
            </tr>

<?php
$result = mysqli_query($conn, "SELECT * FROM orders");

while($row = mysqli_fetch_assoc($result)){
?>

<tr>
<form method="POST" action="update_order.php">

<td><?= $row['order_id'] ?></td>
<td><?= $row['product_name'] ?></td>

<td>
<select name="order_status">
<option>Placed</option>
<option>Packed</option>
<option>Shipped</option>
<option>Out for Delivery</option>
<option>Delivered</option>
<option>Cancelled</option>
</select>
</td>

<td>
<input type="date" name="shipping_date">
</td>

<td>
<input type="date" name="delivery_date">
</td>

<td>
<select name="payment_status">
<option>Paid</option>
<option>Pending</option>
</select>
</td>

<td>
<input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
<button type="submit">Update</button>
</td>

</form>
</tr>

<?php } ?>

        </table>
    </div>
</div>

<?php include "_footer.php"; ?>
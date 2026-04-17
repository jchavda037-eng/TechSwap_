<?php
include "db.php";
$res = mysqli_query($conn, "DESCRIBE orders");
while($row = mysqli_fetch_assoc($res)) {
    echo $row['Field'] . " - " . $row['Type'] . "\n";
}
echo "\n====\n";
$res2 = mysqli_query($conn, "SELECT * FROM orders LIMIT 1");
if($res2 && $row2 = mysqli_fetch_assoc($res2)) {
    print_r($row2);
}
?>

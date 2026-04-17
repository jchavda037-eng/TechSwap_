<?php
include "db.php";

if($conn){
    echo "Database Connected ✅";
}else{
    echo "Connection Failed ❌";
}
?>
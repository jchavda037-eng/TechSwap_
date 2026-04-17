<?php
session_start();
include "db.php";

$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$name = $fname . " " . $lname;

// Check if email already exists
$check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
if (mysqli_num_rows($check) > 0) {
    header("Location: login.php?error=" . urlencode("An account with this email already exists."));
    exit();
}

$sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sss", $name, $email, $password);

if (mysqli_stmt_execute($stmt)) {
    header("Location: login.php?success=" . urlencode("Account created successfully! Please sign in."));
} else {
    header("Location: login.php?error=" . urlencode("Registration failed. Please try again."));
}
exit();
?>
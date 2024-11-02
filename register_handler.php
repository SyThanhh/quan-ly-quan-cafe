<?php
session_start();
include 'config.php'; // Kết nối tới cơ sở dữ liệu

// Lấy thông tin từ form đăng nhập
$username = $_POST['username'];
//$password = $_POST['password'];
$email = $_POST["email"];
$phone = $_POST['phone'];

$sql = "INSERT INTO customer (CustomerName, CustomerPassword, Email, CustomerPhone) VALUES ('$username', '123456', '$email', '$phone')";

if ($conn->query($sql) === TRUE) {
    header("Location: login.php?success=1");
    exit();
} else {
    header("Location: register.php?error=1");
    exit();
}
?>

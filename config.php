<?php
$servername = "localhost";
$username = "root"; // Tên đăng nhập của MySQL
$password = ""; // Mật khẩu của MySQL
$dbname = "db_ql3scoffee"; // Tên cơ sở dữ liệu bạn đã tạo

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>

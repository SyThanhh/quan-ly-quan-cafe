<?php
session_start();
include 'config.php'; // Kết nối tới cơ sở dữ liệu

// Lấy thông tin từ form đăng nhập
$username = $_POST['username'];
$password = $_POST['password'];

// Truy vấn CSDL để kiểm tra tài khoản
$sql = "SELECT * FROM customer WHERE CustomerName = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if ($password == $user['CustomerPassword']) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user['CustomerName'];
        header("Location: index.php");
        exit();
    } else {
        header("Location: login.php?error=1");
        exit();
    }
} else {
    header("Location: login.php?error=1");
   
    exit();
}
?>

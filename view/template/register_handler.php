<?php
session_start();
include './connect/database.php'; // Kết nối tới cơ sở dữ liệu
$database = new Database();
$conn = $database->connect(); // Lấy kết nối

// Lấy thông tin từ form đăng ký
$username = $_POST['username'];
//$password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Mã hóa mật khẩu
$email = $_POST['email'];
$phone = $_POST['phone'];

// Chuẩn bị câu truy vấn với các placeholder
$sql = "INSERT INTO customer (CustomerName, CustomerPassword, Email, CustomerPhone) VALUES (?, '123456', ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    // Gán giá trị cho các tham số để tránh SQL Injection
    $stmt->bind_param('sss', $username, $email, $phone);
    $stmt->execute();

    // Kiểm tra xem một dòng có được thêm vào không
    if ($stmt->affected_rows > 0) {
        // header("Location: login.php?success=1");
        header("Location: index.php?page=login&success=1");

    } else {
        // header("Location: register.php?error=1");
        header("Location: index.php?page=register&error=1");
    }
    $stmt->close();
} else {
    // Xử lý lỗi khi chuẩn bị câu lệnh thất bại
    // header("Location: register.php?error=2");
    header("Location: index.php?page=register&error=2");
}

$conn->close();
exit();
?>


<?php
    session_start();
    include './connect/database.php'; // Kết nối tới cơ sở dữ liệu
    $database = new Database();
    $conn = $database->connect(); // Lấy kết nối
    
    // Lấy thông tin từ form đăng nhập
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Truy vấn CSDL để kiểm tra tài khoản
    $sql = "SELECT CustomerID, CustomerName, CustomerPassword FROM customer WHERE CustomerName = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    
        // Kiểm tra mật khẩu đã mã hóa
        if ($password == $user['CustomerPassword']){
            // Lưu thông tin vào session
            $_SESSION['loggedin'] = true;
            $_SESSION['CustomerID'] = $user['CustomerID'];  // Lưu CustomerID vào session
            $_SESSION['username'] = $user['CustomerName'];
    
            // Chuyển hướng tới trang chủ hoặc trang người dùng
            header("Location: index.php");
            exit();
        } else {
            // Mật khẩu sai
            header("Location: index.php?page=login&error=1");
            exit();
        }
    } else {
        // Tài khoản không tồn tại
        header("Location: index.php?page=login&error=1");
        exit();
    }    
?>
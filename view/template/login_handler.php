<?php
// Bắt đầu phiên làm việc
session_start();

// Kiểm tra nếu người dùng đã đăng nhập thì chuyển hướng về trang chủ
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: index.php");
    exit();
}

// Kiểm tra xem có dữ liệu POST từ form đăng nhập không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kết nối tới cơ sở dữ liệu
    $servername = "localhost";
    $username = "root";  // Tên đăng nhập MySQL
    $password = "";      // Mật khẩu MySQL
    $dbname = "db_ql3scoffee"; // Tên cơ sở dữ liệu

    // Tạo kết nối
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Lấy dữ liệu từ form
    $username = $_POST['username'];
    $password = $_POST['password'];  // Mật khẩu người dùng nhập vào

    // Truy vấn kiểm tra tên đăng nhập
    $sql = "SELECT CustomerID, CustomerName, CustomerPassword, role FROM customer WHERE CustomerName = ?";

    // Kiểm tra câu lệnh SQL
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        // Nếu tìm thấy người dùng
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $db_username, $db_password, $role);
            $stmt->fetch();

            // Kiểm tra mật khẩu
            if ($password === $db_password) { // Nếu mật khẩu được hash, dùng password_verify
                // Lưu thông tin vào session
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $db_username;
                $_SESSION['role'] = $role;
                $_SESSION['id'] = $id;

                // Kiểm tra nếu có ProductID trong session và chuyển hướng
                if (isset($_SESSION['ProductID']) && $_SESSION['ProductID'] != '') {
                    $productID = $_SESSION['ProductID'];
                    unset($_SESSION['ProductID']);  // Loại bỏ ProductID khỏi session sau khi sử dụng
                    header("Location: index.php?page=page_productdetail&ProductID=$productID");
                    exit();
                } else {
                    header("Location: index.php");  // Chuyển hướng về trang chủ nếu không có ProductID
                    exit();
                }
            } else {
                // Nếu mật khẩu không đúng
                header("Location: index.php?page=login&error=1");
                exit();
            }
        } else {
            // Nếu không tìm thấy người dùng
            header("Location: index.php?page=login&error=1");
            exit();
        }

        // Đóng kết nối
        $stmt->close();
    } else {
        // In ra lỗi SQL nếu không thể chuẩn bị câu lệnh
        echo "Error preparing query: " . $conn->error;
        exit();
    }

    // Đóng kết nối
    $conn->close();
}
?>

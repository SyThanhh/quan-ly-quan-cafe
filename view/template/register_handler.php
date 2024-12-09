<?php
// Kiểm tra nếu có dữ liệu POST từ form đăng ký
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form và kiểm tra đầu vào
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : null;

    // Kiểm tra nếu có trường nào trống
    if (empty($username) || empty($email)) {
        echo "<div class='alert alert-danger'>Vui lòng điền đầy đủ thông tin!</div>";
        exit();
    }

    // Kết nối tới cơ sở dữ liệu
    include_once("./connect/database.php");
    $db = new Database();
    $conn = $db->connect();

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("<div class='alert alert-danger'>Kết nối thất bại: " . $conn->connect_error . "</div>");
    }

    // Kiểm tra nếu tên đăng nhập hoặc email đã tồn tại
    $stmt = $conn->prepare("SELECT CustomerID FROM customer WHERE CustomerPhone = ? OR Email = ?");
    $stmt->bind_param("ss", $phone, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<div class='alert alert-warning'>Số điện thoại hoặc email đã tồn tại. Vui lòng chọn tên khác.</div>";
        $stmt->close();
        $conn->close();
        exit();
    }
    $stmt->close();

    // Mật khẩu mặc định là '123456'
    $password = '123456';
    $password = md5($password);
    
    // Thực hiện truy vấn SQL để thêm người dùng vào cơ sở dữ liệu
    $stmt = $conn->prepare("INSERT INTO customer (CustomerName, CustomerPassword, Email, CustomerPhone, CustomerPoint) VALUES (?, ?, ?, ?,  ?)");
    $points = 0;  // Mặc định là 0 điểm
    $stmt->bind_param("ssssi", $username, $password, $email, $phone,$points);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Đăng ký thành công! Bạn sẽ được chuyển hướng đến trang đăng nhập trong 5 giây.</div>";
        echo "<script>
                setTimeout(function(){
                    window.location.href = 'index.php?page=login'; 
                }, 3000); 
              </script>";
    } else {
        echo "<div class='alert alert-danger'>Có lỗi xảy ra khi đăng ký: " . $stmt->error . "</div>";
    }

    $stmt->close();
    $conn->close();
}
?>

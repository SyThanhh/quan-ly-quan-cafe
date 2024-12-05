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
    $servername = "localhost";
    $dbUsername = "root";  // Tên đăng nhập MySQL
    $dbPassword = "";  // Mật khẩu MySQL
    $dbname = "db_ql3scoffee";  // Tên cơ sở dữ liệu

    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("<div class='alert alert-danger'>Kết nối thất bại: " . $conn->connect_error . "</div>");
    }

    // Kiểm tra nếu tên đăng nhập hoặc email đã tồn tại
    $stmt = $conn->prepare("SELECT CustomerID FROM customer WHERE CustomerName = ? OR Email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<div class='alert alert-warning'>Tên đăng nhập hoặc email đã tồn tại. Vui lòng chọn tên khác.</div>";
        $stmt->close();
        $conn->close();
        exit();
    }
    $stmt->close();

    // Mật khẩu mặc định là '123456'
    $password = '123456';
    
    // Thực hiện truy vấn SQL để thêm người dùng vào cơ sở dữ liệu
    $stmt = $conn->prepare("INSERT INTO customer (CustomerName, CustomerPassword, Email, CustomerPhone, role, CustomerPoint) VALUES (?, ?, ?, ?, ?, ?)");
    $role = 'user';  // Mặc định là 'user'
    $points = 0;  // Mặc định là 0 điểm
    $stmt->bind_param("sssssi", $username, $password, $email, $phone, $role, $points);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Đăng ký thành công! Bạn sẽ được chuyển hướng đến trang đăng nhập trong 5 giây.</div>";
        echo "<script>
                setTimeout(function(){
                    window.location.href = 'index.php?page=login'; // Chuyển hướng về trang login
                }, 5000); // 5000 milliseconds = 5 giây
              </script>";
    } else {
        echo "<div class='alert alert-danger'>Có lỗi xảy ra khi đăng ký: " . $stmt->error . "</div>";
    }

    $stmt->close();
    $conn->close();
}
?>

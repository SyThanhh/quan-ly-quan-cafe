<style>
    .center-alert {
        position: fixed; /* Cố định vị trí */
        top: 10px; /* Cách trên cùng 10px */
        left: 50%; /* Đưa tới giữa màn hình theo chiều ngang */
        transform: translateX(-50%); /* Dịch chuyển để căn giữa theo chiều ngang */
        width: 80%; /* Đảm bảo phù hợp với mọi màn hình */
        max-width: 400px; /* Giới hạn độ rộng */
        z-index: 1000; /* Đảm bảo hiển thị trên tất cả các phần tử khác */
        text-align: center;
    }

    .alert {
        padding: 15px; /* Khoảng cách nội dung */
        font-size: 16px; /* Kích thước chữ */
        border-radius: 8px; /* Bo góc */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Đổ bóng */
        background-color: white; /* Nền trắng */
        border: 1px solid transparent; /* Đường viền mặc định */
    }

    .alert-danger {
        background-color: #f8d7da; /* Nền đỏ nhạt */
        color: #842029; /* Màu chữ đỏ đậm */
        border: 1px solid #f5c2c7; /* Viền đỏ nhạt */
    }

    .alert-success {
        background-color: #d1e7dd; /* Nền xanh nhạt */
        color: #0f5132; /* Màu chữ xanh đậm */
        border: 1px solid #badbcc; /* Viền xanh nhạt */
    }
    .alert-warning {
        background-color: #fff3cd; /* Nền vàng nhạt */
        color: #856404; /* Màu chữ vàng đậm */
        border: 1px solid #ffeeba; /* Viền vàng nhạt */
    }
</style>



<?php
// Kiểm tra nếu có dữ liệu POST từ form đăng ký
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form và kiểm tra đầu vào
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : null;
     // Hàm hiển thị thông báo lỗi và tự động quay lại trang đăng ký
     function showError($message) {
        echo "<div class='center-alert'>
                <div class='alert alert-danger'>$message</div>
              </div>";
        echo "<script>
                setTimeout(function(){
                    window.location.href = 'index.php?page=register';
                }, 4000);
              </script>";
        exit();
    }

    // Kiểm tra nếu có trường nào trống
    if (empty($username) || empty($email)) {
        showError("Vui lòng điền đầy đủ thông tin!");
        
        exit();
    }
    if (!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/", $email)) {
       
        showError("Email không hợp lệ. Vui lòng nhập lại!");    
    }

    // Kiểm tra định dạng số điện thoại (chỉ cho phép số và độ dài từ 10-15 ký tự)
    if (!preg_match("/^(09|03|08|07|05)[0-9]{8}$/", $phone)) {
       
        showError("Số điện thoại không hợp lệ. Vui lòng nhập số điện thoại theo đúng định dạng!");
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

        echo "<div class='center-alert'>
        <div class='alert alert-warning'>Số điện thoại hoặc email đã tồn tại. Vui lòng chọn tên khác.</div>";
        echo "<script>
            setTimeout(function(){
                window.location.href = 'index.php?page=register'; // Chuyển hướng về form đăng ký
            }, 2000); 
          </script>";

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
        echo "<div class='center-alert'>
        <div class='alert alert-success'>Đăng ký thành công! Bạn sẽ được chuyển hướng đến trang đăng nhập trong 4 giây.</div>";
        echo "<script>
                setTimeout(function(){
                    window.location.href = 'index.php?page=login'; 
                }, 2000); 
              </script>";
    } else {
        echo "<div class='alert alert-danger'>Có lỗi xảy ra khi đăng ký: " . $stmt->error . "</div>";
    }

    $stmt->close();
    $conn->close();
}
?>

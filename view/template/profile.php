<?php
// session_start();
include_once("./connect/database.php");
 $db = new Database();
 $conn = $db->connect();

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['loggedinCustomer']) || $_SESSION['loggedinCustomer'] !== true) {
    header("Location: login.php");
    exit();
}


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_col = $_SESSION['idCustomer'];

$phone = "";
$email = "";
$notification = "";  // Biến thông báo

// Kiểm tra khi form được gửi (POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra và lấy dữ liệu từ form
    if (isset($_POST['phone'])) {
        $phone = $_POST['phone'];
    }
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    }
    if (isset($_POST['password'])) {
        $newPassword = $_POST['password'];
    }

    // Cập nhật thông tin nếu có thay đổi
    if (!empty($phone) || !empty($email) || !empty($newPassword)) {
        // Cập nhật số điện thoại nếu có thay đổi
        if (!empty($phone)) {
            $sql = "UPDATE customer SET CustomerPhone = ? WHERE CustomerID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $phone, $id_col);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $notification = "Cập nhật số điện thoại thành công!";
                } else {
                    $notification = "Số điện thoại không thay đổi.";
                }
            } else {
                $notification = "Có lỗi khi cập nhật số điện thoại.";
            }
            $stmt->close();
        }

        // Cập nhật email nếu có thay đổi
        if (!empty($email)) {
            $sql = "UPDATE customer SET Email = ? WHERE CustomerID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $email, $id_col);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $notification = "Cập nhật email thành công!";
                } else {
                    $notification = "Email không thay đổi.";
                }
            } else {
                $notification = "Có lỗi khi cập nhật email.";
            }
            $stmt->close();
        }

        // Cập nhật mật khẩu nếu có thay đổi
        if (!empty($newPassword)) {
            // Mã hóa mật khẩu bằng MD5
            $hashedPassword = md5($newPassword);
        
            $sql = "UPDATE customer SET CustomerPassword = ? WHERE CustomerID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $hashedPassword, $id_col);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $notification = "Cập nhật mật khẩu thành công!";
                } else {
                    $notification = "Mật khẩu không thay đổi.";
                }
            } else {
                $notification = "Có lỗi khi cập nhật mật khẩu.";
            }
            $stmt->close();
        }
    } else {
        $notification = "Cả số điện thoại, email và mật khẩu đều không thay đổi!";
    }
}



// Lấy thông tin người dùng từ CSDL
$sql = "SELECT CustomerName, CustomerPhone, Email, CustomerPoint, CustomerPassword FROM customer WHERE CustomerID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_col);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($username, $phone, $email, $points, $password);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân - KOPPEE</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .container {
            width: 700px;
            margin-top: 50px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .icon-edit {
            cursor: pointer;
            color: #007bff;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }

        .icon-edit:hover {
            color: #0056b3;
        }

        .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .user-info .label {
            width: 150px;
            font-weight: bold;
        }

        .user-info .input {
            flex: 1;
            position: relative;
        }

        .form-control {
            width: 70%;
        }

        .form-control:disabled {
            background-color: #f8f9fa;
        }

        .input-group {
            position: relative;
            display: flex;
            width: 70%;
        }

        .form-actions {
            text-align: right;
            margin-top: 20px;
            margin-right: 20px;
        }

        /* Kiểu dáng cho thông báo */
        .notification {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }

        .notification.success {
            background-color: #d4edda;
            color: #155724;
            text-align: center;

        }

        .notification.error {
            background-color: #f8d7da;
            color: #721c24;
            text-align: center;

        }

        .notification.warning {
            background-color: #fff3cd;
            color: #856404;
            text-align: center;

        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-5" style="text-align: center;">THÔNG TIN KHÁCH HÀNG</h2>

        <!-- Hiển thị thông báo nếu có -->
        <?php if (!empty($notification)): ?>
            <div class="notification <?php echo (strpos($notification, 'thành công') !== false) ? 'success' : (strpos($notification, 'lỗi') !== false ? 'error' : 'warning'); ?>">
                <?php echo $notification; ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form action="index.php?page=profile" method="POST">
                    <div class="user-info">
                        <div class="label">
                            <label for="username">Tên khách hàng</label>
                        </div>
                        <div class="input">
                            <input type="text" id="username" class="form-control" value="<?php echo $username; ?>" disabled>
                        </div>
                    </div>

                    <div class="user-info">
                        <div class="label">
                            <label for="phone">Số điện thoại</label>
                        </div>
                        <div class="input">
                            <div class="input-group">
                                <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $phone; ?>" disabled>
                            </div>
                            <span class="input-group-text icon-edit" onclick="editPhone()"><i class="fas fa-edit"></i> Thay đổi</span>
                        </div>
                    </div>

                    <div class="user-info">
                        <div class="label">
                            <label for="email">Email</label>
                        </div>
                        <div class="input">
                            <div class="input-group">
                                <input type="email" id="email" name="email" class="form-control" value="<?php echo $email; ?>" disabled>
                            </div>
                            <span class="input-group-text icon-edit" onclick="editEmail()"><i class="fas fa-edit"></i> Thay đổi</span>
                        </div>
                    </div>

                    <div class="user-info">
                        <div class="label">
                            <label for="password">Mật khẩu</label>
                        </div>
                        <div class="input">
                            <div class="input-group">
                                <!-- Đặt type=password ban đầu và thêm disabled để không cho chỉnh sửa -->
                                <input type="password" id="password" name="password" class="form-control" value="" disabled>
                            </div>
                            <span class="input-group-text icon-edit" onclick="editPassword()"><i class="fas fa-edit"></i> Thay đổi</span>
                        </div>
                    </div>

                    <div class="user-info">
                        <div class="label">
                            <label for="points">Điểm tích lũy</label>
                        </div>
                        <div class="input">
                            <input type="text" id="points" class="form-control" value="<?php echo $points; ?>" disabled>
                        </div>
                    </div>

                    <div class="form-actions d-flex justify-content-between">
                    <!-- Nút Quay lại -->
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>

                     <!-- Nút Cập nhật -->
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        function editPhone() {
            var phoneInput = document.getElementById('phone');
            phoneInput.disabled = false;
        }

        function editEmail() {  
            var emailInput = document.getElementById('email');
            emailInput.disabled = false;
        }
function editPassword() {
    var passwordInput = document.getElementById('password');

    // Kiểm tra xem trường mật khẩu có đang bị vô hiệu hóa không
    if (passwordInput.disabled) {
        passwordInput.disabled = false;  // Cho phép nhập liệu
        passwordInput.type = "text";     // Hiển thị mật khẩu (chuyển type thành text)
    } else {
        passwordInput.disabled = true;  // Vô hiệu hóa khi không cần sửa
        passwordInput.type = "password"; // Ẩn mật khẩu khi không thay đổi
    }
}

    </script>
</body>
</html>

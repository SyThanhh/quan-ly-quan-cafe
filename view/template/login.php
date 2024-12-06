<?php
// Bắt đầu phiên làm việc
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Chỉ gọi session_start() nếu phiên chưa được khởi động
}
// Kiểm tra nếu người dùng đã đăng nhập thì chuyển hướng về trang chủ
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: index.php");
    exit();
}

// Kiểm tra nếu có dữ liệu POST từ form đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kết nối tới cơ sở dữ liệu
    $servername = "localhost";
    $username = "root";  // Tên đăng nhập MySQL
    $password = "";      // Mật khẩu MySQL
    $dbname = "db_ql3scoffee"; // Tên cơ sở dữ liệu

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Lấy dữ liệu từ form
    $username_input = $_POST['username'];  // Tên đăng nhập
    $password_input = $_POST['password'];  // Mật khẩu người dùng nhập vào

    // Kiểm tra đăng nhập khách hàng
    $sql_customer = "SELECT CustomerID, CustomerName, CustomerPassword, role FROM customer WHERE CustomerName = ?";
    $stmt_customer = $conn->prepare($sql_customer);
    $stmt_customer->bind_param("s", $username_input);
    $stmt_customer->execute();
    $stmt_customer->store_result();

    // Nếu tìm thấy khách hàng
    if ($stmt_customer->num_rows > 0) {
        $stmt_customer->bind_result($id, $db_customername, $db_password, $role);
        $stmt_customer->fetch();

        // Kiểm tra mật khẩu
        if ($password_input === $db_password) { 
            // Lưu thông tin vào session
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $db_customername;
            $_SESSION['role'] = $role;
            $_SESSION['id'] = $id;

            // Chuyển hướng về trang chính
            header("Location: index.php");
            exit();
        }
    }

    // Kiểm tra đăng nhập quản trị viên
    $sql_employee = "SELECT EmployeeID, LastName, password, Roles FROM employee WHERE LastName = ?";
    $stmt_employee = $conn->prepare($sql_employee);
    $stmt_employee->bind_param("s", $username_input);
    $stmt_employee->execute();
    $stmt_employee->store_result();
    
    // Kiểm tra xem có dữ liệu trả về không
    if ($stmt_employee->num_rows > 0) {
        $stmt_employee->bind_result($id, $db_lastname, $db_employee_password, $Roles);
        $stmt_employee->fetch();
    
        // Kiểm tra mật khẩu
        if ($password_input === $db_employee_password) {
            // Lưu thông tin vào session
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $db_lastname;
            $_SESSION['role'] = $role;
            $_SESSION['id'] = $id;

            // Chuyển hướng dựa trên vai trò
            if (in_array($Roles, ['1', '2', '3', '4'])){
                header("Location: index.php?page=index_admin");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            // Mật khẩu không chính xác
            echo "Password does not match for employee.";
        }
    } else {
        echo "Employee not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - KOPPEE</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <!-- Kiểm tra và hiển thị thông báo lỗi nếu có -->
    <?php if (isset($_GET['error'])): ?>
        <div class="container mt-3">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="alert alert-danger text-center">
                        Tên đăng nhập hoặc mật khẩu không chính xác. Vui lòng thử lại.
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Form đăng nhập -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Đăng nhập</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="username">Tên đăng nhập</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" name="username" id="username" class="form-control" required autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">Mật khẩu</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                        </form>
                        <div class="text-center mt-3">
                            <p>Bạn chưa có tài khoản? <a href="index.php?page=register" class="btn btn-link">Tạo tài khoản</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gọi các thư viện JavaScript của Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

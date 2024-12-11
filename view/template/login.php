<?php
 include_once("./connect/database.php");
 $db = new Database();
 $conn = $db->connect();
// Bắt đầu phiên làm việc
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Chỉ gọi session_start() nếu phiên chưa được khởi động
}


// Kiểm tra nếu có dữ liệu POST từ form đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone_input = trim(mysqli_real_escape_string($conn, $_POST['phone']));
    $password_input = trim(mysqli_real_escape_string($conn, $_POST['password']));

    function loginCustomer($conn, $table, $username_col, $phone_col, $password_col, $id_col,$phone_input, $password_input) {
        $password_input = md5($password_input);
        $sql = "SELECT $id_col, $username_col, $password_col FROM $table WHERE $phone_col = ?";
        
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            die("SQL Error: " . mysqli_error($conn));
        }
      
        mysqli_stmt_bind_param($stmt, "s", $phone_input);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            if ($password_input === $row[$password_col]) {
                $_SESSION['loggedinCustomer'] = true;
                $_SESSION['usernameCustomer'] = $row[$username_col];
                $_SESSION['idCustomer'] = $row[$id_col];
                return true;
            }
        }
        mysqli_stmt_close($stmt);
        return false;
    }

    function loginEmployee($conn, $table, $username_col,$phone_col, $password_col ,$role_col, $id_col, $phone_input, $password_input) {
        $password_input = md5($password_input);
        $sql = "SELECT $id_col, $username_col, $password_col, $role_col FROM $table WHERE $phone_col = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            die("SQL Error: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, "s", $phone_input);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        

        if ($row = mysqli_fetch_assoc($result)) {
            if ($password_input === $row[$password_col]) {
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $row[$username_col];
                $_SESSION['role'] = $row[$role_col];
                $_SESSION['id'] = $row[$id_col];
                return true;
            }
        }
        mysqli_stmt_close($stmt);
        return false;
    }

    // Kiểm tra đăng nhập nhân viên trước
    
    if (loginEmployee($conn, 'employee','LastName' ,  'PhoneNumber','password', 'Roles', 'EmployeeID',$phone_input ,$password_input)) {
        $role = $_SESSION['role'];
        if (in_array($role, ['1', '2', '3', '4'])) {
            if($role === 1) {
                echo "<script>alert('Bạn đăng nhập thành công với vai trò người Quản Lý'); window.location.href='index.php?page=index_admin';</script>";
            } else if($role === 2) {
                echo "<script>alert('Bạn đăng nhập thành công với vai trò Nhân Viên Quầy'); window.location.href='index.php?page=index_admin';</script>";
            } else if($role === 3) {
                echo "<script>alert('Bạn đăng nhập thành công với vai trò Nhân Viên Kế Toán'); window.location.href='index.php?page=index_admin';</script>";
            } else if($role === 4) {
                echo "<script>alert('Bạn đăng nhập thành công với vai trò Nhân viên Pha Chế'); window.location.href='index.php?page=index_admin';</script>";
            }
        } else {
            echo "<script>window.location.href='index.php';</script>";
        }
        exit();
    }
    

    // Nếu không phải nhân viên, kiểm tra khách hàng
    if (loginCustomer($conn, 'customer', 'CustomerName','CustomerPhone', 'CustomerPassword', 'CustomerID', $phone_input, $password_input)) {
        header("Location: index.php");
        exit();
    }

    // Nếu không thành công
    echo "<p class='text-center' style='color:red;'>Số điện thoại hoặc mật khẩu không chính xác.</p>";
}


// Đóng kết nối
mysqli_close($conn);

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
                                <label for="phone">Số điện thoại</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" name="phone" id="phone" class="form-control" required autofocus>
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
                            <p>Bạn chưa có tài khoản? <a href="index.php?page=register" class="btn btn-link">Đăng ký tài khoản</a></p>
                        </div>
                        <div>
                         <span class="text-center" style="color: green;">Lưu ý : Khi khách hàng đăng nhập lần đầu mật khẩu là 123456</span>
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

<?php
// Bắt đầu phiên làm việc
// session_start();

// Kiểm tra nếu người dùng đã đăng nhập thì chuyển hướng về trang chủ
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - KOPPEE</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Thêm Font Awesome -->
</head>
<body>
    <!-- Thanh điều hướng (sử dụng lại thanh điều hướng của bạn) 
    <div class="container-fluid p-0 nav-bar">
        <nav class="navbar navbar-expand-lg bg-none navbar-dark py-3">
            <a href="index.php" class="navbar-brand px-lg-4 m-0">
                <h1 class="m-0 display-4 text-uppercase text-white">3S COFFEE</h1>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav ml-auto p-4">
                    <a href="index.php" class="nav-item nav-link">Trang chủ</a>
                    <a href="index.php?page=about" class="nav-item nav-link">Giới thiệu</a>
                    <a href="index.php?page=service" class="nav-item nav-link">Dịch vụ</a>
                    <a href="index.php?page=menu" class="nav-item nav-link">Menu</a>
                    <a href="index.php?page=contact" class="nav-item nav-link">Liên hệ</a>
                    <a href="login.php" class="nav-item nav-link">Tài khoản</a>
                </div>
            </div>
        </nav>
    </div>-->

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
                        <!-- <form action="login_handler.php" method="POST"> -->
                        <form action="index.php?page=login_handler" method="POST">
                            <div class="form-group">
                                <label for="username">Tên đăng nhập</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" name="username" id="username" class="form-control" required>
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
                        <!-- Thêm nút tạo tài khoản -->
                        <div class="text-center mt-3">
                            <!-- <p>Bạn chưa có tài khoản? <a href="register.php" class="btn btn-link">Tạo tài khoản</a></p> -->
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

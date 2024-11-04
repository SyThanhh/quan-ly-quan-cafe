<?php
session_start();

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
    <title>Đăng ký - KOPPEE</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Thêm Font Awesome -->
</head>
<body>
    <!-- Kiểm tra và hiển thị thông báo lỗi nếu có -->
    <?php if (isset($_GET['error'])): ?>
        <div class="container mt-3">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="alert alert-danger text-center">
                        <?php
                        if ($_GET['error'] == 1) {
                            echo "Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.";
                        } elseif ($_GET['error'] == 2) {
                            echo "Có lỗi xảy ra. Vui lòng thử lại.";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Form đăng ký -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Đăng ký</h3>
                    </div>
                    <div class="card-body">
                        <!-- <form action="register_handler.php" method="POST"> -->
                        <form action="index.php?page=register_handler" method="POST">
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
                                <label for="email">Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" name="email" id="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></i></span>
                                    </div>
                                    <input type="phone" name="phone" id="phone" class="form-control" required>
                                </div>
                            </div>
                           <!-- <div class="form-group">
                                <label for="password">Mật khẩu</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Xác nhận mật khẩu</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                                </div>-->
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Đăng ký</button>
                        </form>
                    </div>
                    <!-- Thêm nút tạo tài khoản -->
                    <div class="text-center mt-3">
                        <!-- <p>Bạn đã có tài khoản? <a href="login.php" class="btn btn-link">Đăng nhập</a></p> -->
                        <p>Bạn đã có tài khoản? <a href="index.php?page=login" class="btn btn-link">Đăng nhập</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

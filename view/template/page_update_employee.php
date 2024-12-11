<?php
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php?page=login");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Đầu trang -->
    <?php
        include_once('./common/head/head.php');    
        include_once('./connect/database.php'); // Đường dẫn vào file kết nối database

        // Tạo một đối tượng Database để kết nối
        $database = new Database();
        $conn = $database->connect(); // Lấy kết nối
    ?>
    <link rel="stylesheet" href="./assets/css/employee_shift.css">
</head>

<body>
    <div id="wrapper">
        <!-- Thanh điều hướng dọc -->
        <?php include_once('./common/menu/siderbar.php'); ?>

        <!-- Giao giện trang -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Thanh điều hướng ngang -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <!-- <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> -->

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                          
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <!-- Hiển thị tên người dùng từ session -->
                                <input type="text" id="employeeIdByRole" value="<?php echo htmlspecialchars($employeeID); ?>" hidden/>
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php
                                        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                            echo "Xin chào <b>".htmlspecialchars($_SESSION['username'])."</b>";
                                        } else {
                                            echo "Guest";
                                        }
                                    ?>
                                </span>
                                <img class="img-profile rounded-circle" src="./assets/img/testimonial-2.jpg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="index.php?page=page_profile">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Thông tin nhân viên
                            </a>
                            
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="index.php?page=logout">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Đăng xuất 
                            </a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <!--  Nội dung trang  -->
                <?php
                    // Lấy mã nhân viên từ URL
                    if (isset($_GET['id'])) {
                        $employeeID = $_GET['id'];}
                    // Truy vấn thông tin nhân viên dựa trên ID
                    $result = $conn->query("SELECT * FROM employee WHERE EmployeeID = $employeeID");
                    $employee = $result->fetch_assoc();
                    // Chuyển đổi `datetime` thành định dạng `date` (YYYY-MM-DD) cho trường nhập HTML
                    $dateOfBirth = date("Y-m-d", strtotime($employee['DateOfBirth']));
                ?>
                <div class="container-fluid" align="center">
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <h4>SỬA THÔNG TIN NHÂN VIÊN</h4>
                                </br>   
                            </div>
                            <form action="" method="post" >
                            <table>
                                <tr>
                                    <th><label for="employeeID">Mã Nhân Viên:</label></th>
                                    <td><input type="text" class="form-control" id="employeeID" name="employeeID" value="<?php echo $employee['EmployeeID']; ?>" readonly></td>
                                </tr>
                                <tr>
                                    <th><label for="firstName">Họ:</label></th>
                                    <td><input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $employee['FirstName']; ?>" required></td>
                                </tr>
                                <tr>
                                    <th><label for="lastName">Tên:</label></th>
                                    <td><input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $employee['LastName']; ?>" required></td>
                                </tr>
                                <tr>
                                    <th><label for="email">Email:</label></th>
                                    <td><input type="email" class="form-control" id="email" name="email" value="<?php echo $employee['Email']; ?>" required></td>
                                </tr>
                                <tr>
                                    <th><label for="phoneNumber">Số Điện Thoại:</label></th>
                                    <td><input type="text" class="form-control" id="phoneNumber" name="phoneNumber" value="<?php echo $employee['PhoneNumber']; ?>" required></td>
                                </tr>
                                <tr>
                                    <th><label for="birthDate">Ngày Sinh:</label></th>
                                    <td><input type="date" class="form-control" id="birthDate" name="birthDate" value="<?php echo $dateOfBirth; ?>" required></td>
                                </tr>
                                <tr>
                                    <th><label for="password">Mật khẩu:</label></th>
                                    <td><input type="password" class="form-control" id="password" name="password" placeholder="Để trống nếu không đổi"></td>
                                </tr>
                            </table>
                                <!-- Button section -->
                                <div class="button-group">
                                    </br>
                                    <button type="button" class='btn btn-danger' onclick="window.history.back();">Hủy</button>
                                    <button class="btn btn-secondary" type="reset">Làm Lại</button>
                                    <button type="submit" class="btn btn-primary btn-add" name="updateEmployee" style="background-color: #683c08bf; border:none">Cập nhật</button>
                                </div>
                            </form>        
                        </div>
                    </div>
                </div>

                <!-- Kiểm tra dữ liệu nhập -->
                <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const form = document.querySelector('form');
                    const email = document.getElementById('email');
                    const phoneNumber = document.getElementById('phoneNumber');

                    // Hiển thị lỗi
                    function showError(input, message) {
                        const errorElement = input.nextElementSibling; // Giả định có `span` lỗi ngay sau input
                        if (errorElement && errorElement.classList.contains('error-message')) {
                            errorElement.textContent = message;
                        } else {
                            const errorSpan = document.createElement('span');
                            errorSpan.className = 'error-message text-danger';
                            errorSpan.textContent = message;
                            input.parentNode.appendChild(errorSpan);
                        }
                        input.classList.add('is-invalid');
                    }

                    // Xóa lỗi
                    function clearError(input) {
                        const errorElement = input.nextElementSibling;
                        if (errorElement && errorElement.classList.contains('error-message')) {
                            errorElement.textContent = '';
                        }
                        input.classList.remove('is-invalid');
                    }

                    // Kiểm tra email
                    function checkEmail(input) {
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(input.value.trim())) {
                            showError(input, 'Email không hợp lệ. Vui lòng nhập đúng định dạng email.');
                            return false;
                        }
                        clearError(input);
                        return true;
                    }

                    // Kiểm tra số điện thoại
                    function checkPhoneNumber(input) {
                        const phoneRegex = /^[0-9]{10}$/;
                        if (!phoneRegex.test(input.value.trim())) {
                            showError(input, 'Số điện thoại phải có đúng 10 chữ số.');
                            return false;
                        }
                        clearError(input);
                        return true;
                    }

                    // Gắn sự kiện 'blur' để kiểm tra khi rời khỏi trường
                    email.addEventListener('blur', () => checkEmail(email));
                    phoneNumber.addEventListener('blur', () => checkPhoneNumber(phoneNumber));

                    // Xử lý khi form được gửi
                    form.addEventListener('submit', function (e) {
                        let isValid = true;

                        // Kiểm tra từng trường
                        if (!checkEmail(email)) isValid = false;
                        if (!checkPhoneNumber(phoneNumber)) isValid = false;

                        // Nếu không hợp lệ, ngăn gửi form
                        if (!isValid) {
                            e.preventDefault();
                        }
                    });
                });
                </script>

                <!-- Xử lý cập nhật thông tin nhân viên -->
                <?php
                    if (isset($_POST['updateEmployee'])) {
                        // Nhận dữ liệu từ form
                        $employeeID = $_POST['employeeID'];
                        $firstName = trim($_POST['firstName']);
                        $lastName = trim($_POST['lastName']);
                        $email = trim($_POST['email']);
                        $phoneNumber = trim($_POST['phoneNumber']);
                        $birthDate = $_POST['birthDate'];
                        $password = trim($_POST['password']);
                        
                        // Chuẩn bị câu truy vấn SQL để cập nhật thông tin nhân viên
                        $query = "UPDATE employee 
                                SET FirstName = ?, LastName = ?, Email = ?, PhoneNumber = ?, DateOfBirth = ?";
                        $params = array($firstName, $lastName, $email, $phoneNumber, $birthDate);
                        $types = "sssss";

                        // Nếu mật khẩu được cung cấp, thêm nó vào câu truy vấn
                        if (!empty($password)) {
                            $query .= ", Password = ?";
                            $params[] = md5($password);
                            $types .= "s";
                        }

                        $query .= " WHERE EmployeeID = ?";
                        $params[] = $employeeID;
                        $types .= "i";
                        
                        // Chuẩn bị câu truy vấn và ràng buộc tham số
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param($types, ...$params);

                        // Thực thi câu truy vấn
                        if ($stmt->execute()) {
                            // Hiển thị thông báo "Cập nhật thành công" và chuyển hướng
                            echo "<script>
                                    window.location.href = 'index.php?page=page_employee';
                                    alert('Cập nhật thành công');
                                    </script>";
                            exit;
                        } else {
                            echo "<p>Đã có lỗi xảy ra: " . $stmt->error . "</p>";
                        }
                        $stmt->close();
                    }
                ?>
            </div>
            <!-- Cuối trang -->
            <?php include_once('./common/footer/footer.php'); ?>
        </div>    

    <!-- Bootstrap core JavaScript-->
    <?php include_once('./common/script/default.php'); ?>
</body>
</html>

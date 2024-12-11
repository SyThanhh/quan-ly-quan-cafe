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

                <!-- Nội dung trang -->
                <?php
                // Lấy mã ca làm sắp tới (MAX + 1) từ database
                $result = $conn->query("SELECT MAX(ShiftID) AS max_id FROM workshift");
                $row = $result->fetch_assoc();
                $nextShiftID = $row['max_id'] + 1;

                // Lấy danh sách nhân viên đứng quầy
                $cashierEmployees = $conn->query("SELECT EmployeeID, CONCAT(LastName, ' ', FirstName) AS FullName FROM employee WHERE Roles = 2");
                // Lấy danh sách nhân viên kế toán
                $accountingEmployees = $conn->query("SELECT EmployeeID, CONCAT(LastName, ' ', FirstName) AS FullName FROM employee WHERE Roles = 3");
                // Lấy danh sách nhân viên pha chế
                $baristaEmployees = $conn->query("SELECT EmployeeID, CONCAT(LastName, ' ', FirstName) AS FullName FROM employee WHERE Roles = 4");
                ?>

                <div class="container-fluid" align="center">
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <h4>THÊM LỊCH MỚI</h4>
                                </br>
                            </div>
                            <form action="" method="post">
                                <table>
                                    <tr>
                                        <th><label for="shiftID">Mã Ca Làm:</label></th>
                                        <td><input type="text" class="form-control" id="shiftID" name="shiftID" value="<?php echo $nextShiftID; ?>" readonly></td>
                                    </tr>
                                    <tr>
                                        <th><label for="shiftType">Loại Ca Làm:</label></th>
                                        <td>
                                            <select id="shiftType" class="form-control" name="shiftType" required>
                                                <option value="Sáng">Ca Sáng</option>
                                                <option value="Chiều">Ca Chiều</option>
                                                <option value="Tối">Ca Tối</option>
                                                <option value="Đêm">Ca Đêm</option>
                                                <option value="Linh Hoạt">Ca Linh Hoạt</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><label>Thời Gian Áp Dụng:</label></th>
                                    </tr>
                                    <tr>
                                        <td><label for="startDate">Ngày bắt đầu:</label></td>
                                        <td><input type="date" class="form-control" id="startDate" name="startDate" required></td>
                                    </tr>
                                    <tr>
                                        <td><label for="endDate">Ngày kết thúc:</label></td>
                                        <td><input type="date" class="form-control" id="endDate" name="endDate" required></td>
                                    </tr>
                                    <tr>
                                        <th><label for="cashier">Nhân Viên Đứng Quầy:</label></th>
                                        <td>
                                            <select id="cashier" class="form-control" name="cashier" required>
                                                <?php while ($employee = $cashierEmployees->fetch_assoc()) {
                                                    echo "<option value='{$employee['EmployeeID']}'>{$employee['FullName']}</option>";
                                                } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><label for="accountant">Nhân Viên Kế Toán:</label></th>
                                        <td>
                                            <select id="accountant" class="form-control" name="accountant" required>
                                                <?php while ($employee = $accountingEmployees->fetch_assoc()) {
                                                    echo "<option value='{$employee['EmployeeID']}'>{$employee['FullName']}</option>";
                                                } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><label for="barista">Nhân Viên Pha Chế:</label></th>
                                        <td>
                                            <select id="barista" class="form-control" name="barista" required>
                                                <?php while ($employee = $baristaEmployees->fetch_assoc()) {
                                                    echo "<option value='{$employee['EmployeeID']}'>{$employee['FullName']}</option>";
                                                } ?>
                                            </select>
                                        </td>
                                    </tr>
                                </table>

                                <!-- Button section -->
                                <div class="button-group">
                                    </br>
                                    <button type="button" class='btn btn-danger' onclick="window.history.back();">Hủy</button>
                                    <button class="btn btn-secondary" type="reset">Làm Lại</button>
                                    <button type="submit" class="btn btn-primary btn-add" name="addShift" style="background-color: #683c08bf; border:none">Thêm Lịch</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Xử lý thêm lịch -->
                <?php
                if (isset($_POST['addShift'])) {
                    $shiftID = $_POST['shiftID'];
                    $shiftType = $_POST['shiftType'];
                    $startDate = $_POST['startDate'];
                    $endDate = $_POST['endDate'];
                    $cashier = $_POST['cashier'];
                    $accountant = $_POST['accountant'];
                    $barista = $_POST['barista'];

                    // Thêm ca làm mới vào bảng workshift
                    $queryWorkshift = "INSERT INTO workshift (ShiftID, ShiftType, StartDate, EndDate) VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($queryWorkshift);
                    $stmt->bind_param("isss", $shiftID, $shiftType, $startDate, $endDate);

                    if ($stmt->execute()) {
                        // Thêm từng nhân viên vào bảng workshift_employee
                        $queryWorkshiftEmployee = "INSERT INTO workshift_employee (ShiftID, EmployeeID) VALUES (?, ?)";
                        $stmtEmployee = $conn->prepare($queryWorkshiftEmployee);

                        // Thêm nhân viên đứng quầy
                        $stmtEmployee->bind_param("ii", $shiftID, $cashier);
                        $stmtEmployee->execute();

                        // Thêm nhân viên kế toán
                        $stmtEmployee->bind_param("ii", $shiftID, $accountant);
                        $stmtEmployee->execute();

                        // Thêm nhân viên pha chế
                        $stmtEmployee->bind_param("ii", $shiftID, $barista);
                        $stmtEmployee->execute();

                        echo "<script>
                                alert('Thêm lịch thành công');
                                window.location.href = 'index.php?page=page_shift';
                            </script>";
                        exit;
                    } else {
                        echo "<p>Đã có lỗi xảy ra: " . $stmt->error . "</p>";
                    }

                    $stmt->close();
                    // $stmtEmployee->close();
                }
                ?>
            
            
        </div>    
        <!-- Cuối trang -->
        <?php include_once('./common/footer/footer.php'); ?>
    <!-- Bootstrap core JavaScript-->
    <?php include_once('./common/script/default.php'); ?>
</body>
</html>

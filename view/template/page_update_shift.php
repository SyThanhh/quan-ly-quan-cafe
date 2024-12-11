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
                // Lấy mã lịch từ URL
                if (isset($_GET['id'])) {
                    $shiftID = $_GET['id'];
                }

                // Truy vấn thông tin lịch dựa trên ID
                $query = "
                    SELECT w.ShiftID, w.ShiftType, w.StartDate, w.EndDate,
                        GROUP_CONCAT(CONCAT(e.EmployeeID, ':', e.Roles)) AS EmployeeRoles
                    FROM workshift AS w
                    LEFT JOIN workshift_employee AS we ON w.ShiftID = we.ShiftID
                    LEFT JOIN employee AS e ON we.EmployeeID = e.EmployeeID
                    WHERE w.ShiftID = $shiftID
                    GROUP BY w.ShiftID
                ";
                $result = $conn->query($query);
                $shift = $result->fetch_assoc();

                $startDate = date("Y-m-d", strtotime($shift['StartDate']));
                $endDate = date("Y-m-d", strtotime($shift['EndDate']));

                // Xử lý nhân viên hiện tại theo vai trò
                $employeeRoles = [];
                if (!empty($shift['EmployeeRoles'])) {
                    foreach (explode(',', $shift['EmployeeRoles']) as $entry) {
                        [$employeeID, $role] = explode(':', $entry);
                        $employeeRoles[$role] = $employeeID;
                    }
                }

                // Lấy danh sách nhân viên theo vai trò
                $cashierEmployees = $conn->query("SELECT EmployeeID, CONCAT(LastName, ' ', FirstName) AS FullName FROM employee WHERE Roles = 2");
                $accountingEmployees = $conn->query("SELECT EmployeeID, CONCAT(LastName, ' ', FirstName) AS FullName FROM employee WHERE Roles = 3");
                $baristaEmployees = $conn->query("SELECT EmployeeID, CONCAT(LastName, ' ', FirstName) AS FullName FROM employee WHERE Roles = 4");
                ?>

                <div class="container-fluid" align="center">
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <h4>SỬA LỊCH</h4>
                                </br>
                            </div>
                            <form action="" method="post">
                                <table>
                                    <tr>
                                        <th><label for="shiftID">Mã Ca Làm:</label></th>
                                        <td><input type="text" class="form-control" id="shiftID" name="shiftID" value="<?php echo $shift['ShiftID']; ?>" readonly></td>
                                    </tr>
                                    <tr>
                                        <th><label for="shiftType">Loại Ca Làm:</label></th>
                                        <td><input type="text" class="form-control" value="<?php echo $shift['ShiftType']; ?>" readonly></td>
                                    </tr>
                                    <tr>
                                        <th><label>Thời Gian Áp Dụng:</label></th>
                                    </tr>
                                    <tr>
                                        <td><label for="startDate">Ngày bắt đầu:</label></td>
                                        <td><input type="date" class="form-control" id="startDate" value="<?php echo $startDate; ?>" readonly></td>
                                    </tr>
                                    <tr>
                                        <td><label for="endDate">Ngày kết thúc:</label></td>
                                        <td><input type="date" class="form-control" id="endDate" value="<?php echo $endDate; ?>" readonly></td>
                                    </tr>
                                    <tr>
                                        <th><label for="cashier">Nhân Viên Đứng Quầy:</label></th>
                                        <td>
                                            <select id="cashier" class="form-control" name="cashier" required>
                                                <?php while ($employee = $cashierEmployees->fetch_assoc()) {
                                                    $selected = ($employee['EmployeeID'] == ($employeeRoles[2] ?? '')) ? 'selected' : '';
                                                    echo "<option value='{$employee['EmployeeID']}' {$selected}>{$employee['FullName']}</option>";
                                                } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><label for="accountant">Nhân Viên Kế Toán:</label></th>
                                        <td>
                                            <select id="accountant" class="form-control" name="accountant" required>
                                                <?php while ($employee = $accountingEmployees->fetch_assoc()) {
                                                    $selected = ($employee['EmployeeID'] == ($employeeRoles[3] ?? '')) ? 'selected' : '';
                                                    echo "<option value='{$employee['EmployeeID']}' {$selected}>{$employee['FullName']}</option>";
                                                } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><label for="barista">Nhân Viên Pha Chế:</label></th>
                                        <td>
                                            <select id="barista" class="form-control" name="barista" required>
                                                <?php while ($employee = $baristaEmployees->fetch_assoc()) {
                                                    $selected = ($employee['EmployeeID'] == ($employeeRoles[4] ?? '')) ? 'selected' : '';
                                                    echo "<option value='{$employee['EmployeeID']}' {$selected}>{$employee['FullName']}</option>";
                                                } ?>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                                <div class="button-group">
                                    </br>
                                    <button type="button" class='btn btn-danger' onclick="window.history.back();">Hủy</button>
                                    <button type="submit" class="btn btn-primary" name="editShift">Lưu Thay Đổi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <?php
                // Xử lý cập nhật nhân viên làm trong bảng workshift_employee
                if (isset($_POST['editShift'])) {
                    $cashier = $_POST['cashier'];
                    $accountant = $_POST['accountant'];
                    $barista = $_POST['barista'];

                    // Xóa nhân viên cũ của ca làm
                    $queryDeleteEmployees = "DELETE FROM workshift_employee WHERE ShiftID = ?";
                    $stmtDelete = $conn->prepare($queryDeleteEmployees);
                    $stmtDelete->bind_param("i", $shiftID);
                    $stmtDelete->execute();

                    // Thêm nhân viên mới
                    $queryInsertEmployee = "INSERT INTO workshift_employee (ShiftID, EmployeeID) VALUES (?, ?)";
                    $stmtInsert = $conn->prepare($queryInsertEmployee);

                    $stmtInsert->bind_param("ii", $shiftID, $cashier);
                    $stmtInsert->execute();
                    $stmtInsert->bind_param("ii", $shiftID, $accountant);
                    $stmtInsert->execute();
                    $stmtInsert->bind_param("ii", $shiftID, $barista);
                    $stmtInsert->execute();

                    echo "<script>alert('Cập nhật nhân viên thành công!'); window.location.href = 'index.php?page=page_shift';</script>";
                }
                ?>
            <!-- Cuối trang -->
            <?php include_once('./common/footer/footer.php'); ?>
        </div>    

    <!-- Bootstrap core JavaScript-->
    <?php include_once('./common/script/default.php'); ?>
</body>
</html>

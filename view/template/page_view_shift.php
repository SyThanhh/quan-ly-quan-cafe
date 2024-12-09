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

        // Hàm chuyển đổi mã vai trò thành tên vai trò
        function getRoleName($roleCode) {
            switch ($roleCode) {
                case 2:
                    return "Nhân viên đứng quầy";
                case 3:
                    return "Nhân viên kế toán";
                case 4:
                    return "Nhân viên pha chế";
                default:
                    return "Không xác định";
            }
        }

        // Xử lý tìm kiếm
        $searchDate = isset($_GET['search_date']) ? $_GET['search_date'] : '';
        $whereClause = '';
        if (!empty($searchDate)) {
            $formattedSearchDate = date('Y-m-d', strtotime($searchDate));
            $whereClause = "WHERE '$formattedSearchDate' BETWEEN DATE(StartDate) AND DATE(EndDate)";
        }

        // Số bản ghi trên mỗi trang
        $recordsPerPage = 5;

        // Tính tổng số bản ghi với điều kiện tìm kiếm
        $totalRecordsQuery = "SELECT COUNT(*) as total FROM workshift $whereClause";
        $totalRecordsResult = $database->select($totalRecordsQuery);
        $totalRecords = $totalRecordsResult->fetch_assoc()['total'];

        // Tính tổng số trang
        $totalPages = ceil($totalRecords / $recordsPerPage);

        // Lấy trang hiện tại từ URL, mặc định là trang 1
        $page = isset($_GET['page_number']) ? (int)$_GET['page_number'] : 1;
        $page = max(1, min($page, $totalPages));

        // Tính offset để lấy dữ liệu
        $offset = ($page - 1) * $recordsPerPage;

        // Truy vấn danh sách lịch làm việc với phân trang và tìm kiếm
        $query = "SELECT * FROM workshift $whereClause ORDER BY StartDate DESC LIMIT $offset, $recordsPerPage";
        $shifts = $database->select($query);

        // Xử lý xóa lịch
        if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
            $shiftID = $_GET['id'];
            
            // Xóa các bản ghi liên quan trong bảng workshift_employee
            $deleteEmployeesQuery = "DELETE FROM workshift_employee WHERE ShiftID = ?";
            $stmtDeleteEmployees = $conn->prepare($deleteEmployeesQuery);
            $stmtDeleteEmployees->bind_param("i", $shiftID);
            $stmtDeleteEmployees->execute();

            // Xóa lịch từ bảng workshift
            $deleteShiftQuery = "DELETE FROM workshift WHERE ShiftID = ?";
            $stmtDeleteShift = $conn->prepare($deleteShiftQuery);
            $stmtDeleteShift->bind_param("i", $shiftID);
            
            if ($stmtDeleteShift->execute()) {
                echo "<script>alert('Xóa lịch thành công!'); window.location.href = 'index.php?page=page_shift';</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra khi xóa lịch!'); window.location.href = 'index.php?page=page_shift';</script>";
            }
        }
    ?>
    <link rel="stylesheet" href="./assets/css/employee_shift.css">
    <style>
    /* Khi hover vào phần tử dropdown */
.nav-item.dropdown:hover .dropdown-menu {
    display: block;  /* Hiển thị menu khi hover */
}

/* Mặc định ẩn menu dropdown */
.dropdown-menu {
    display: none; /* Ẩn menu khi không hover */
}

/* Các hiệu ứng chuyển động */
.dropdown-menu {
    transition: opacity 0.3s ease;  /* Thêm hiệu ứng mờ dần */
    opacity: 0;
}

/* Khi dropdown hiển thị */
.nav-item.dropdown:hover .dropdown-menu {
    opacity: 1;  /* Hiển thị khi hover */
}

</style>
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
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_2.svg"
                                            alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_3.svg"
                                            alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

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
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <!--  Nội dung trang  -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="header text-left">
                                <h4>LỊCH LÀM VIỆC</h4>
                            </div>
                            
                            <div class="col-md-12 text-center">
                                <div class="row">
                                    <div class="col-md-6">
                                        <form action="" method="GET">
                                            <div class="input-group">
                                                <input type="date" class="form-control" id="search_date" name="search_date" value="<?php echo $searchDate; ?>" placeholder="Tìm lịch theo ngày">
                                                <input type="hidden" name="page" value="page_shift">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary search-button m-0" type="submit">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- <div class="col-md-6 text-right">
                                        <a class="btn btn-primary btn-add" style="color:white" href="index.php?page=page_add_shift"><i class="fas fa-plus"></i> &nbsp; Thêm lịch mới</a>
                                    </div> -->
                                </div>
                            </div>
                            </br>

                            <?php
                            // Số bản ghi trên mỗi trang
                            
                            ?>

                            <!-- Danh sách lịch -->
                            <div class="mt-8">
                                <table class="table table-bordered">
                                    <thead align="center">
                                        <tr>
                                            <th>Mã</th>
                                            <th>Loại ca</th>
                                            <th>Ngày bắt đầu</th>
                                            <th>Ngày kết thúc</th>
                                            <th colspan="2">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    // Hiển thị danh sách lịch làm việc
                                    if ($shifts) {
                                        while ($row = $shifts->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>{$row['ShiftID']}</td>";
                                            echo "<td>{$row['ShiftType']}</td>";
                                            echo "<td>{$row['StartDate']}</td>";
                                            echo "<td>{$row['EndDate']}</td>";
                                            echo "<td>
                                                <button type='button' class='btn btn-info' data-toggle='modal' data-target='#detailsModal{$row['ShiftID']}'>
                                                    <i class='fas fa-eye'></i>
                                                </button>
                                                </td>";
                                            // echo "<td>
                                            //     <a href='index.php?page=page_update_shift&id={$row['ShiftID']}' class='btn btn-success' style='color:white'>
                                            //         <i class='fas fa-edit'></i>
                                            //     </a></td>";
                                            // echo "<td>
                                            //     <button type='button' class='btn btn-danger' onclick='confirmDelete({$row['ShiftID']})'>
                                            //         <i class='fas fa-trash'></i>
                                            //     </button>
                                            // </td>";
                                            echo "</tr>";

                                            // Tạo modal hiển thị thông tin chi tiết
                                            echo "
                                            <div class='modal fade' id='detailsModal{$row['ShiftID']}' tabindex='-1' role='dialog' aria-labelledby='detailsModalLabel{$row['ShiftID']}' aria-hidden='true'>
                                                <div class='modal-dialog' role='document'>
                                                    <div class='modal-content'>
                                                        <div class='modal-header'>
                                                            <h5 class='modal-title' id='detailsModalLabel{$row['ShiftID']}'>Chi Tiết Lịch Làm</h5>
                                                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                                <span aria-hidden='true'>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class='modal-body'>
                                                            <p><strong>Mã Ca Làm:</strong> {$row['ShiftID']}</p>
                                                            <p><strong>Loại Ca Làm:</strong> {$row['ShiftType']}</p>
                                                            <p><strong>Ngày Bắt Đầu:</strong> {$row['StartDate']}</p>
                                                            <p><strong>Ngày Kết Thúc:</strong> {$row['EndDate']}</p>";

                                            // Truy vấn nhân viên của lịch làm
                                            $employeeQuery = "
                                                SELECT w.ShiftID, w.ShiftType, w.StartDate, w.EndDate,
                                                GROUP_CONCAT(CONCAT(e.LastName, ' ', e.FirstName, ':', e.Roles) SEPARATOR ',') AS EmployeeInfo
                                                FROM workshift AS w
                                                LEFT JOIN workshift_employee AS we ON w.ShiftID = we.ShiftID
                                                LEFT JOIN employee AS e ON we.EmployeeID = e.EmployeeID
                                                WHERE w.ShiftID = {$row['ShiftID']}
                                                GROUP BY w.ShiftID
                                            ";
                                            $employeeResult = $database->select($employeeQuery);
                                            $employeeInfo = $employeeResult->fetch_assoc()['EmployeeInfo'];

                                            echo "<p><strong>Nhân viên:</strong></p>";
                                            if ($employeeInfo) {
                                                $employees = explode(',', $employeeInfo);
                                                echo "<ul>";
                                                foreach ($employees as $employee) {
                                                    list($name, $roleCode) = explode(':', $employee);
                                                    $roleName = getRoleName($roleCode);
                                                    echo "<li>$name - $roleName</li>";
                                                }
                                                echo "</ul>";
                                            } else {
                                                echo "<p>Không có nhân viên</p>";
                                            }

                                            echo "
                                                        </div>
                                                        <div class='modal-footer'>
                                                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Đóng</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6' class='text-center'>Không có dữ liệu</td></tr>";
                                    }
                                    ?>
                                </tbody>
                                </table>
                            </div>

                            <!-- Phân trang -->
                            <div class="row justify-content-end mr-1">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <!-- Nút Previous -->
                                        <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                                            <a class="page-link" href="index.php?page=page_shift&page_number=<?php echo $page - 1; ?>&search_date=<?php echo $searchDate; ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>

                                        <!-- Các trang số -->
                                        <?php 
                                        $startPage = max(1, $page - 2);
                                        $endPage = min($totalPages, $page + 2);
                                        for ($i = $startPage; $i <= $endPage; $i++): 
                                        ?>
                                            <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                                <a class="page-link" href="index.php?page=page_shift&page_number=<?php echo $i; ?>&search_date=<?php echo $searchDate; ?>">
                                                    <?php echo $i; ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>

                                        <!-- Nút Next -->
                                        <li class="page-item <?php if ($page >= $totalPages) echo 'disabled'; ?>">
                                            <a class="page-link" href="index.php?page=page_shift&page_number=<?php echo $page + 1; ?>&search_date=<?php echo $searchDate; ?>" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Cuối trang -->
            <?php include_once('./common/footer/footer.php'); ?>
        </div>    
    <!-- Modal xác nhận xóa -->
    <!-- <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteLabel">Xác nhận xóa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa lịch này không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>    

    <script>
        // Hàm mở modal xác nhận xóa
        function confirmDelete(shiftID) {
            // Hiển thị modal
            $('#confirmDeleteModal').modal('show');
            
            // Gán ID của lịch vào nút xác nhận
            document.getElementById('confirmDeleteButton').onclick = function () {
                // Thực hiện hành động xóa
                window.location.href = 'index.php?page=page_shift&action=delete&id=' + shiftID;
            };
        }
    </script> -->
    <!-- Bootstrap core JavaScript-->
    <?php include_once('./common/script/default.php'); ?>
</body>
</html>


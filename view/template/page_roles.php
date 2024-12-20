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

.page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #8e6d46 !important;
            border-color: #8e6d46 !important;
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
                // Kiểm tra nếu có tìm kiếm
                $searchKeyword = isset($_POST['name-search']) ? $_POST['name-search'] : '';

                // Số bản ghi trên mỗi trang
                $recordsPerPage = 5;

                // Tính tổng số bản ghi
                $totalRecordsQuery = "SELECT COUNT(*) as total FROM employee WHERE Roles > 1 AND Status = 1";
                if ($searchKeyword !== '') {
                    $totalRecordsQuery .= " AND (FirstName LIKE '%$searchKeyword%' OR LastName LIKE '%$searchKeyword%')";
                }
                $totalRecordsResult = $database->select($totalRecordsQuery);
                $totalRecords = $totalRecordsResult->fetch_assoc()['total'];

                // Tính tổng số trang
                $totalPages = ceil($totalRecords / $recordsPerPage);

                // Lấy trang hiện tại từ URL, mặc định là trang 1
                $page = isset($_GET['page_number']) ? (int)$_GET['page_number'] : 1;
                $page = ($page > $totalPages) ? $totalPages : $page;
                $page = ($page < 1) ? 1 : $page;

                // Tính offset để lấy dữ liệu
                $offset = ($page - 1) * $recordsPerPage;

                // Truy vấn danh sách nhân viên với phân trang và tìm kiếm
                $query = "SELECT * FROM employee WHERE Roles > 1 AND Status = 1";
                if ($searchKeyword !== '') {
                    $query .= " AND (FirstName LIKE '%$searchKeyword%' OR LastName LIKE '%$searchKeyword%')";
                }
                $query .= " LIMIT $offset, $recordsPerPage";
                $employees = $database->select($query);
                ?>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="header text-left">
                                <h4>CẬP NHẬT LẠI VỊ TRÍ NHÂN VIÊN</h4>
                            </div>
                            
                            <div class="col-md-12 text-center">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="name-search" placeholder="Tìm nhân viên theo tên" value="<?php echo htmlspecialchars($searchKeyword); ?>">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary search-button m-0" type="button">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <span style="color:red">Lưu ý: Thay đổi vị trí làm việc sẽ thay đổi các chức năng nhân viên có thể sử dụng trên hệ thống</span>
                                    </div>
                                </div>
                            </div>
                            </br>

                            <!-- Danh sách nhân viên -->
                            <div class="mt-8">
                                <table class="table table-bordered">
                                    <thead style="background-color: #683c08bf; border:none; color:white">
                                        <tr>
                                            <th>Mã</th>
                                            <th>Họ</th>
                                            <th>Tên</th>
                                            <th>Email</th>
                                            <th>Số điện thoại</th>
                                            <th>Vai trò</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            // Hiển thị danh sách nhân viên
                                            if ($employees) {
                                                while ($row = $employees->fetch_assoc()) { // Sử dụng fetch_assoc() từ mysqli
                                                    echo "<tr>";
                                                    echo "<td>{$row['EmployeeID']}</td>";
                                                    echo "<td>{$row['FirstName']}</td>";
                                                    echo "<td>{$row['LastName']}</td>";
                                                    echo "<td>{$row['Email']}</td>";
                                                    echo "<td>{$row['PhoneNumber']}</td>";
                                                    // Thay đổi giá trị của cột Roles dựa trên điều kiện
                                                    $role = '';
                                                    if ($row['Roles'] == 1) {
                                                        $role = "Quản lý";
                                                    } elseif ($row['Roles'] == 2) {
                                                        $role = "Nhân viên đứng quầy";
                                                    } elseif ($row['Roles'] == 3) {
                                                        $role = "Nhân viên kế toán";
                                                    } elseif ($row['Roles'] == 4) {
                                                        $role = "Nhân viên pha chế";
                                                    }
                                                    echo "<td>{$role}</td>";
                                                    echo "<td>
                                                        <a href='index.php?page=page_update_roles&id={$row['EmployeeID']}' class='btn btn-success' style='color:white'>
                                                            <i class='fas fa-edit'></i>
                                                        </a>
                                                    </td> ";
                                                }
                                            } else {
                                                echo "<tr><td colspan='8' class='text-center'>Không có dữ liệu</td></tr>";
                                            }                                            
                                        ?>
                                    </tbody>
                                </table>

                                <!-- Phân trang -->
                                <div class="row justify-content-end mr-1">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">
                                            <!-- Nút Previous -->
                                            <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                                                <a class="page-link" href="index.php?page=page_roles&page_number=<?php echo ($page > 1) ? $page - 1 : 1; ?>&search=<?php echo urlencode($searchKeyword); ?>" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>

                                            <!-- Các trang số -->
                                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                                    <a class="page-link" href="index.php?page=page_roles&page_number=<?php echo $i; ?>&search=<?php echo urlencode($searchKeyword); ?>">
                                                        <?php echo $i; ?>
                                                    </a>
                                                </li>
                                            <?php endfor; ?>

                                            <!-- Nút Next -->
                                            <li class="page-item <?php if ($page >= $totalPages) echo 'disabled'; ?>">
                                                <a class="page-link" href="index.php?page=page_roles&page_number=<?php echo ($page < $totalPages) ? $page + 1 : $totalPages; ?>&search=<?php echo urlencode($searchKeyword); ?>" aria-label="Next">
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
            </div>

            <!-- Cuối trang -->
            <?php include_once('./common/footer/footer.php'); ?>
        </div>    
        
       

    
    <!-- Bootstrap core JavaScript-->
    <?php include_once('./common/script/default.php'); ?>
</body>
</html>

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
                            <a class="dropdown-item" href="#">
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
                <div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="header text-left mb-4">
                <h4 class="font-weight-bold">QUẢN LÝ PHIẾU YÊU CẦU</h4>
            </div>
            <div class="mb-3">
                <a href="index.php?page=page_requestform&status=0" class="btn btn-primary btn-lg mr-2">Xem phiếu chưa duyệt</a>
                <a href="index.php?page=page_requestform&status=1" class="btn btn-success btn-lg">Xem phiếu đã duyệt</a>
            </div>

            <?php
            // Kiểm tra và lấy giá trị của 'status' từ URL, mặc định là 0 (chưa duyệt)
            $status = isset($_GET['status']) ? $_GET['status'] : 0;
            ?>

            <table class="table table-striped table-bordered">
                <thead class="thead-dark text-center">
                <tr>
                        <th>Mã</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Nhà cung cấp</th>
                        <th>Thời gian</th>
                        <th>Nhân viên nhập phiếu</th>
                        <?php if ($status == 0): ?>                           
                            <th colspan="2">Trạng thái</th>
                        <?php elseif ($status == 1): ?>                         
                            <th>Thời gian duyệt</th>
                            <th>Trạng thái</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Truy vấn danh sách yêu cầu theo trạng thái (chưa duyệt hoặc đã duyệt)
                    $requestform = $database->select("
                    SELECT 
                        rf.*, 
                        e.*, 
                        pr.ProductName, 
                        s.CompanyName AS SupplierName
                    FROM requestform rf
                    JOIN employee e ON rf.EmployeeID = e.EmployeeID
                    JOIN product pr ON rf.ProductID = pr.ProductID
                    LEFT JOIN product_supplier ps ON pr.ProductID = ps.ProductID
                    LEFT JOIN supplier s ON ps.SupplierID = s.SupplierID
                    WHERE rf.Status = $status

                    ");

                    // Hiển thị danh sách yêu cầu
                    if ($requestform) {
                        while ($row = $requestform->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='text-center'>{$row['RequestID']}</td>";
                            echo "<td class='text-center'>{$row['ProductName']}</td>";
                            echo "<td class='text-center'>{$row['RequestQuantity']}</td>";
                            echo "<td class='text-center'>{$row['SupplierName']}</td>";
                            echo "<td class='text-center'>{$row['CreateDate']}</td>";

                            if ($status == 1) {
                                // Nếu phiếu đã duyệt, hiển thị nhân viên duyệt và thời gian duyệt
                                echo "<td class='text-center'>{$row['FirstName']} {$row['LastName']}</td>";
                                echo "<td class='text-center'>{$row['ApproveDate']}</td>";
                                echo "<td class='text-center'>Đã duyệt</td>";
                            } else {
                                // Nếu phiếu chưa duyệt, hiển thị nhân viên duyệt và các nút Duyệt, Xóa
                                echo "<td class='text-center'>{$row['FirstName']} {$row['LastName']}</td>";
                                echo "<td class='text-center'>
                                <a href='index.php?page=page_requestform&RequestID={$row['RequestID']}&status=1' class='btn btn-success btn-sm'>
                                    <i class='fas fa-check'></i> Duyệt
                                </a>
                                   </td>";
                        
                                echo "<td class='text-center'>
                                        <a href='index.php?page=page_delete_request&RequestID={$row['RequestID']}' 
                                           class='btn btn-danger btn-sm' 
                                           onclick=\"return confirm('Bạn có thực sự muốn xóa yêu cầu này không?')\">
                                           <i class='fas fa-trash'></i> Xóa
                                        </a>
                                    </td>";
                            }

                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center'>Không có dữ liệu</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>

<?php
// Đặt múi giờ cho Việt Nam (Asia/Ho_Chi_Minh)
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Kiểm tra xem RequestID có được truyền qua URL không
if (isset($_GET['RequestID'])) {
    // Lấy RequestID từ URL
    $requestID = $_GET['RequestID'];
    
    // Lấy thời gian hiện tại để ghi vào cột ApproveDate
    $approveDate = date('Y-m-d H:i:s');

    // Lấy ProductID và RequestQuantity từ bảng requestform
    $query = "SELECT ProductID, RequestQuantity FROM requestform WHERE RequestID = '$requestID'";
    $result = $database->select($query);

    if ($result && $row = $result->fetch_assoc()) {
        $productID = $row['ProductID'];
        $requestQuantity = $row['RequestQuantity'];

        // Cập nhật Status và ApproveDate trong requestform
        $sqlUpdateRequest = "UPDATE requestform 
                             SET Status = 1, ApproveDate = '$approveDate' 
                             WHERE RequestID = '$requestID'";
        $database->select($sqlUpdateRequest);

        // Cập nhật UnitsInStock trong bảng product
        $sqlUpdateProduct = "UPDATE product 
                             SET UnitsInStock = UnitsInStock + $requestQuantity 
                             WHERE ProductID = '$productID'";
        $database->select($sqlUpdateProduct);

        // Thông báo thành công
        echo "<script>alert('Duyệt phiếu và cộng số lượng sản phẩm thành công!'); 
              window.location.href = 'index.php?page=page_requestform&status=1';</script>";
    } else {
        // Nếu không tìm thấy dữ liệu
        echo "<script>alert('Phiếu yêu cầu không tồn tại hoặc không hợp lệ!'); 
              href = 'index.php?page=page_requestform';</script>";
    }
} else {
    // Nếu không có RequestID
    echo "<script>href = 'index.php?page=page_requestform';</script>";
}
?>
    <!-- Bootstrap core JavaScript-->
     
    <?php include_once('./common/script/default.php'); ?>
</body>
</html>

<?php
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php?page=login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php
        include_once('./common/head/head.php');    
        include_once('./connect/database.php'); // Đường dẫn vào file kết nối database

        // Tạo một đối tượng Database để kết nối
        $database = new Database();
        $conn = $database->connect(); // Lấy kết nối
    ?>
  <script src="./assets/js/manager.js"></script>
</head>

<?php

?>
<style>
  .custom-btn {
    background-color: #4e73df;
    color: #fff;
    border: none;
  }

  .custom-btn:hover {
    background-color: #3b5fb5;
  }
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
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include_once('./common/menu/siderbar.php')?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

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
                <div>
                
                </div>
                        <!-- End of Topbar -->
        <div class="container mt-4">
            <h1 class="h3 mb-0 text-gray-800">THỐNG KÊ DOANH THU</h1>
            <form>
            <div class="form-row">
                <!-- Cột bên trái -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="start_date">Ngày bắt đầu:</label>
                        <input 
                            type="date" 
                            id="start_date" 
                            name="start_date" 
                            class="form-control" 
                            value="<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>" 
                    >
                    </div>
                </div>

                <!-- Cột giữa để canh lề -->
                <div class="col-md-3"></div>

                <!-- Cột bên phải -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="end_date">Ngày kết thúc:</label>
                        <input 
                            type="date" 
                            id="end_date" 
                            name="end_date" 
                            class="form-control" 
                            value="<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ''; ?>" 
                        >

                    </div>
                </div>
            </div>
            <button type="button" id="stats-btn" class="btn " style="background-color: #683c08bf; border:none; color:#fff">Thống kê</button>
        </form>
        <br>
        </div>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Doanh thu theo ngày</h6>
                                </div>
                                <!-- Vùng chứa biểu đồ Bar -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myBarChart" style="display: none;"></canvas> <!-- Ẩn canvas mặc định -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Doanh thu theo sản phẩm</h6>

                                </div>
                                <!-- Vùng chứa biểu đồ Doughnut -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myDoughnutChart" style="display: none;"></canvas> <!-- Ẩn canvas mặc định -->
                                    </div>
                                </div>
                                    <!-- <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-primary"></i> Direct
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Social
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-info"></i> Referral
                                        </span>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                 <br>   
            <div class="container mt-3">
            <!-- <div class="d-flex justify-content-between align-items-center mb-3">
                <button class="btn btn-outline-primary d-flex align-items-center">
                    <i class="bi bi-download me-2"></i> <span>Xuất báo cáo</span>
                </button>
            </div> -->
            <table class="table table-bordered text-center">
            <thead class="custom" style="background-color: #683c08bf; border: none;">
            <tr> <th class="text-white">Mã ID</th> 
                <th class="text-white">Ngày bán</th> 
                <th class="text-white">Hình thức thanh toán</th> 
                <th class="text-white">Doanh thu</th> 
            </tr> 
        </thead>
        <tbody>
        <tbody>
        <tbody>
        <?php
        // Kiểm tra nếu có thời gian bắt đầu và kết thúc
        if (isset($_POST['start_date']) && isset($_POST['end_date']) && !empty($_POST['start_date']) && !empty($_POST['end_date'])) {
            // Lấy giá trị thời gian từ form
            $startDate = $_POST['start_date'];
            $endDate = $_POST['end_date'];

            // Truy vấn dữ liệu từ cơ sở dữ liệu sử dụng SELECT thông thường
            $query = "
            SELECT 
                p.ProductName, 
                SUM(od.Quantity) AS TotalQuantity, 
                SUM(od.Quantity * od.UnitPrice) AS TotalRevenue,
                o.* -- Lấy toàn bộ các cột từ bảng `order`
            FROM 
                product p
            JOIN 
                orderdetail od ON p.ProductID = od.ProductID
            JOIN 
                `order` o ON od.OrderID = o.OrderID
            WHERE 
                DATE(o.CreateDate) BETWEEN '$startDate' AND '$endDate'
            GROUP BY 
                p.ProductName, o.OrderID -- Cần thêm `o.OrderID` vào GROUP BY để phù hợp với dữ liệu từ `o.*`
            ORDER BY 
                o.OrderID ASC -- Sắp xếp theo OrderID tăng dần
        ";
        
            $result = $database->select($query);
            $totalRevenue = 0; // Biến để tính tổng doanh thu

            // Kiểm tra xem $result có phải là đối tượng hợp lệ không
if ($result && $result->num_rows > 0) {
    // Hiển thị dữ liệu khi có dữ liệu
    $stt = 1; // Số thứ tự
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['OrderID']}</td>";
        echo "<td>{$row['CreateDate']}</td>";
        echo "<td>{$row['PaymentMethod']}</td>";
        echo "<td>" . number_format($row['TotalAmount']) . " VNĐ</td>";
            
        // Cộng tổng doanh thu
        $totalRevenue += $row['TotalAmount'];
        
        echo "</tr>";
        $stt++;
    }

    // Hiển thị tổng doanh thu
    $formattedTotalRevenue = number_format($totalRevenue);

    // Hiển thị hàng tổng cộng
    echo "<tr>";
    echo "<td colspan='3'></td>";
    echo "<td><strong>Tổng doanh thu:</strong> {$formattedTotalRevenue} VNĐ</td>";
    echo "</tr>";
} else {
    // Xử lý trường hợp không có dữ liệu hoặc có lỗi trong câu truy vấn
    echo "<tr><td colspan='4' class='text-center'>Không có dữ liệu trong khoảng thời gian này.</td></tr>";
}

        }
        ?>
</tbody>

</tbody>
        </tbody>
    </table>

    <!-- <div class="row justify-content-end mr-1">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div> -->
</div>

<style>
    /* CSS tùy chỉnh để đổi màu viền của thead */
    .custom-thead th {
        background-color: #4e73df;
    }
</style>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include_once('./common/footer/footer.php') ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <?php
    // Khởi tạo mảng rỗng cho biểu đồ
    $dates = [];
    $totalRevenueBar = [];
    $productNames = [];
    $totalRevenueDonut = [];

    // Xử lý thống kê khi nhận yêu cầu
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        // Validate dữ liệu ngày tháng
        if (isset($start_date, $end_date) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $start_date) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $end_date)) {
            try {
                // Truy vấn dữ liệu cho biểu đồ Bar
                $barQuery = $conn->prepare("
                    SELECT DATE(CreateDate) AS Date, SUM(TotalAmount) AS TotalRevenue
                    FROM `order`
                    WHERE DATE(CreateDate) BETWEEN ? AND ?
                    GROUP BY DATE(CreateDate)
                ");
                $barQuery->bind_param("ss", $start_date, $end_date); // Gắn tham số
                $barQuery->execute();
                $barResult = $barQuery->get_result();

                while ($data = $barResult->fetch_assoc()) {
                    $dates[] = $data['Date'];
                    $totalRevenueBar[] = $data['TotalRevenue'];
                }

                // Truy vấn dữ liệu cho biểu đồ Doughnut
                $donutQuery = $conn->prepare("
                    SELECT p.ProductName, SUM(od.Quantity * od.UnitPrice) AS TotalRevenue
                    FROM product p
                    JOIN orderdetail od ON p.ProductID = od.ProductID
                    JOIN `order` o ON od.OrderID = o.OrderID
                    WHERE DATE(o.CreateDate) BETWEEN ? AND ?
                    GROUP BY p.ProductName
                ");
                $donutQuery->bind_param("ss", $start_date, $end_date); // Gắn tham số
                $donutQuery->execute();
                $donutResult = $donutQuery->get_result();

                while ($data = $donutResult->fetch_assoc()) {
                    $productNames[] = $data['ProductName'];
                    $totalRevenueDonut[] = $data['TotalRevenue'];
                }
            } catch (mysqli_sql_exception $e) {
                echo "Lỗi truy vấn SQL: " . $e->getMessage();
                exit;
            }
        } else {
            echo "Dữ liệu ngày không hợp lệ.";
            exit;
        }
    }

  ?>



<script>
// Khi người dùng nhấn nút thống kê
document.getElementById("stats-btn").addEventListener("click", function() {
    // Gửi dữ liệu ngày bắt đầu và ngày kết thúc qua POST
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;

    if (!startDate || !endDate) {
        alert('Vui lòng nhập ngày bắt đầu và ngày kết thúc.');
        return;
    }
    if (new Date(startDate) >= new Date(endDate)) {
    alert('Ngày bắt đầu phải nhỏ hơn ngày kết thúc.');
    return;
    }

    // Reload lại trang với POST để thực hiện thống kê
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = ''; // Gửi tới chính trang hiện tại

    const inputStartDate = document.createElement('input');
    inputStartDate.type = 'hidden';
    inputStartDate.name = 'start_date';
    inputStartDate.value = startDate;

    const inputEndDate = document.createElement('input');
    inputEndDate.type = 'hidden';
    inputEndDate.name = 'end_date';
    inputEndDate.value = endDate;

    form.appendChild(inputStartDate);
    form.appendChild(inputEndDate);

    document.body.appendChild(form);
    form.submit();
});

// Hiển thị biểu đồ nếu dữ liệu có sẵn
<?php if (!empty($dates) && !empty($productNames)): ?>
    document.getElementById("myBarChart").style.display = "block";
    document.getElementById("myDoughnutChart").style.display = "block";

    // Biểu đồ Bar
    const barLabels = <?php echo json_encode($dates); ?>;
    const barDataValues = <?php echo json_encode($totalRevenueBar); ?>;

    new Chart(document.getElementById('myBarChart'), {
        type: 'bar',
        data: {
            labels: barLabels,
            datasets: [{
                label: 'Doanh thu theo thời gian',
                data: barDataValues,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(201, 203, 207, 0.2)',
                    'rgba(100, 149, 237, 0.2)',
                    'rgba(255, 127, 80, 0.2)',
                    'rgba(124, 252, 0, 0.2)',
                    'rgba(72, 209, 204, 0.2)',
                    'rgba(240, 230, 140, 0.2)',
                    'rgba(147, 112, 219, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(201, 203, 207, 1)',
                    'rgba(100, 149, 237, 1)',
                    'rgba(255, 127, 80, 1)',
                    'rgba(124, 252, 0, 1)',
                    'rgba(72, 209, 204, 1)',
                    'rgba(240, 230, 140, 1)',
                    'rgba(147, 112, 219, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Biểu đồ Doughnut
    const donutLabels = <?php echo json_encode($productNames); ?>;
    const donutDataValues = <?php echo json_encode($totalRevenueDonut); ?>;

    new Chart(document.getElementById('myDoughnutChart'), {
        type: 'doughnut',
        data: {
            labels: donutLabels,
            datasets: [{
                label: 'Doanh thu theo sản phẩm',
                data: donutDataValues,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(252, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(201, 203, 207, 0.2)',
                    'rgba(100, 149, 237, 0.2)',
                    'rgba(255, 127, 80, 0.2)',
                    'rgba(124, 252, 0, 0.2)',
                    'rgba(72, 209, 204, 0.2)',
                    'rgba(240, 230, 140, 0.2)',
                    'rgba(147, 112, 219, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(252, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(201, 203, 207, 1)',
                    'rgba(100, 149, 237, 1)',
                    'rgba(255, 127, 80, 1)',
                    'rgba(124, 252, 0, 1)',
                    'rgba(72, 209, 204, 1)',
                    'rgba(240, 230, 140, 1)',
                    'rgba(147, 112, 219, 1)'
                ],
                borderWidth: 1
            }]
        }
    });
<?php endif; ?>
</script>


    <!-- Bootstrap core JavaScript-->
    <?php 
    include_once('./common/script/default.php')
    ?>
</body>

</html>
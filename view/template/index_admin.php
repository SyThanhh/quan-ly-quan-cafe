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

</head>
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
                            < <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" aria-haspopup="true" aria-expanded="false">
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
                               
                                <a class="dropdown-item" href="index.php?page=logout" >
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Đăng xuất
                                </a>
                            </div>
                        </li>


                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Tổng quan</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Doanh thu
                                            </div>
                                            <?php
                                                // Truy vấn lấy tất cả các đơn hàng từ bảng "order"
                                                $total = $database->select("SELECT * FROM `order`");
                                                $totalRevenue = 0;

                                                // Duyệt qua tất cả các đơn hàng để tính tổng doanh thu
                                                foreach ($total as $row) {
                                                    $totalRevenue += $row['TotalAmount'];
                                                }
                                                // Định dạng tổng doanh thu thành dạng số có 3 chữ số thập phân
                                                $formattedTotalRevenue = number_format($totalRevenue );
                                                // Hiển thị tổng doanh thu
                                                echo '<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">' . $formattedTotalRevenue . ' VND</div>';

                                                ?>

                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Số lượng khách hàng</div>
                                            <?php
                                                $sql = "SELECT COUNT(*) AS totalCustomers FROM customer";
                                                $result = $conn->query($sql);
                                                $row = $result->fetch_assoc();
                                                echo '<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">' . $row['totalCustomers'] . '</div>';
                                            ?>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Số lượng nhân viên
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                <?php
                                                    $sql = "SELECT COUNT(*) AS totalEmployees FROM employee";
                                                    $result = $conn->query($sql);
                                                    
                                                    // Lấy dữ liệu từ kết quả truy vấn và hiển thị
                                                    $row = $result->fetch_assoc();
                                                    echo "<div class='h5 mb-0 mr-3 font-weight-bold text-gray-800'>{$row['totalEmployees']}</div>";
                                                ?>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <!-- <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Số lượng đơn hàng
                                            </div>
                                            <?php
                                                $sql = "SELECT COUNT(*) AS totalOrders FROM `order`";  // Đặt tên bảng `order` trong dấu backtick
                                                $result = $conn->query($sql);
                                                
                                                // Lấy dữ liệu từ kết quả truy vấn và hiển thị
                                                $row = $result->fetch_assoc();
                                                echo "<div class='h5 mb-0 mr-3 font-weight-bold text-gray-800'>{$row['totalOrders']}</div>";
                                            ?>
                                        </div>
                                        <!-- <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Doanh thu</h6>

                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="varChart"></canvas>
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
                                    <h6 class="m-0 font-weight-bold text-primary">Tổng tiền mua của khách hàng</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="doughnutChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->


    <!-- Logout Modal-->
    <!-- <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div> -->
    <?php
$query1 = $database->select("
  SELECT DATE(CreateDate) AS Date, SUM(TotalAmount) AS TotalRevenue
  FROM `order`
  GROUP BY DATE(CreateDate)
");

$date = [];
$totalRevenue = [];

foreach ($query1 as $data) {
    $date[] = $data['Date'];
    $totalRevenue[] = $data['TotalRevenue'];


}

// Giả sử dữ liệu thứ hai là doanh thu theo khách hàng, bạn có thể thay thế bằng truy vấn thực tế của mình
$query2 = $database->select("
  SELECT c.CustomerName, SUM(o.TotalAmount) AS TotalSpent
  FROM customer c
  JOIN `order` o ON c.CustomerID = o.CustomerID
  GROUP BY c.CustomerID
");


$customerNames = [];
$totalSpent = [];

foreach ($query2 as $data) {
    $customerNames[] = $data['CustomerName'];
    $totalSpent[] = $data['TotalSpent'];
}
?>

<script>
/* Biểu đồ cột cho doanh thu theo ngày */
const barLabels = <?php echo json_encode($date); ?>;
const barDataValues = <?php echo json_encode($totalRevenue); ?>;

const barColors = [
  'rgba(255, 99, 132, 0.2)',
  'rgba(255, 159, 64, 0.2)',
  'rgba(255, 205, 86, 0.2)',
  'rgba(75, 192, 192, 0.2)',
  'rgba(54, 162, 235, 0.2)',
];

const barBorderColors = [
  'rgb(255, 99, 132)',
  'rgb(255, 159, 64)',
  'rgb(255, 205, 86)',
  'rgb(75, 192, 192)',
  'rgb(54, 162, 235)',
];

const barData = {
  labels: barLabels,
  datasets: [{
    label: 'Doanh thu theo ngày',
    data: barDataValues,
    backgroundColor: barColors,
    borderColor: barBorderColors,
    borderWidth: 1
  }]
};

const barConfig = {
  type: 'bar',
  data: barData,
  options: {
    responsive: true,
    scales: {
      x: { beginAtZero: true },
      y: { beginAtZero: true }
    },
    plugins: {
      legend: { display: true, position: 'top' }
    }
  },
};

var barChart = new Chart(
  document.getElementById('varChart'),
  barConfig
);

/* Biểu đồ Doughnut cho doanh thu theo khách hàng */
const doughnutLabels = <?php echo json_encode($customerNames); ?>;
const doughnutDataValues = <?php echo json_encode($totalSpent); ?>;

const doughnutColors = [
  'rgba(255, 99, 132, 0.6)',
  'rgba(54, 162, 235, 0.6)',
  'rgba(255, 206, 86, 0.6)',
  'rgba(75, 192, 192, 0.6)',
  'rgba(153, 102, 255, 0.6)',
];

const doughnutBorderColors = [
  'rgb(255, 99, 132)',
  'rgb(54, 162, 235)',
  'rgb(255, 206, 86)',
  'rgb(75, 192, 192)',
  'rgb(153, 102, 255)',
];

const doughnutData = {
  labels: doughnutLabels,
  datasets: [{
    label: 'Tổng chi tiêu của khách hàng',
    data: doughnutDataValues,
    backgroundColor: doughnutColors,
    borderColor: doughnutBorderColors,
    borderWidth: 1
  }]
};

const doughnutConfig = {
  type: 'doughnut',
  data: doughnutData,
  options: {
    responsive: true,
    plugins: {
      legend: { display: true, position: 'top' }
    }
  },
};

var doughnutChart = new Chart(
  document.getElementById('doughnutChart'),
  doughnutConfig
);
</script>

    <?php 
    include_once('./common/script/default.php')
    ?>

</body>

</html>
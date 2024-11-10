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
                    <form
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
                    </form>

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
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
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
                        <label for="ngayBatDau">Ngày bắt đầu</label>
                        <input type="date" class="form-control" value="2024-01-01">
 
                    </div>
                    
                </div>
                <div>
                    
                </div>
                <!-- Cột giữa để canh lề, tạo khoảng cách giữa hai phần -->
                <div class="col-md-3"></div>
                <!-- Cột bên phải -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="ngayKetThuc">Ngày kết thúc</label>
                        <input type="date" class="form-control"  value="2024-01-31">
                    </div>
                </div>
            </div>
        </form>
        <div>
            <div class="col-md-3">
                <div class="form-group">
                    <button id="stats-btn" class="btn custom-btn">Thống kê</button>
                    
                </div>
    
            </div>
        </div>
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
            <table class="table table-bordered text-center">
            <thead class="custom-thead"> 
                <tr> <th class="text-white">STT</th> 
                <th class="text-white">Loại Sản Phẩm</th> 
                <th class="text-white">Số lượng</th> 
                <th class="text-white">Doanh thu</th> 
            </tr> 
        </thead>
        <tbody>
        <tbody>
        <tbody>
    <?php
    $supplier = $database->select("
        SELECT p.*, ps.*, od.*, o.*
        FROM product p
        JOIN product_supplier ps ON p.ProductID = ps.ProductID
        JOIN orderdetail od ON p.ProductID = od.ProductID
        JOIN `order` o ON od.OrderID = o.OrderID
    ");

    $totalRevenue = 0; // Biến để tính tổng doanh thu

    if ($supplier) {
        while ($row = $supplier->fetch_assoc()) { // Sử dụng fetch_assoc() từ mysqli
            echo "<tr>";
            echo "<td>{$row['ProductID']}</td>";
            echo "<td>{$row['ProductName']}</td>";
            echo "<td>{$row['Quantity']}</td>";
            echo "<td>{$row['TotalAmount']}</td>";
            
            // Cộng tổng doanh thu
            $totalRevenue += $row['TotalAmount'];
            
            
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='9' class='text-center'>Không có dữ liệu</td></tr>";
    }

    // Định dạng tổng doanh thu với hai số thập phân
    $formattedTotalRevenue = number_format($totalRevenue, 2);

    // Hiển thị hàng tổng cộng
    echo "<tr>";
    echo "<td colspan='3'></td>";
    echo "<td><strong>Tổng doanh thu:</strong> {$formattedTotalRevenue}</td>";
    echo "</tr>";
    ?>
</tbody>

</tbody>
        </tbody>
    </table>

    <div class="row justify-content-end mr-1">
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
    </div>
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
// Biểu đồ Bar: Doanh thu theo thời gian
$barQuery = $database->select("
  SELECT DATE(CreateDate) AS Date, SUM(TotalAmount) AS TotalRevenue
  FROM `order`
  GROUP BY DATE(CreateDate)
");

$dates = [];
$totalRevenueBar = [];

foreach ($barQuery as $data) {
    $dates[] = $data['Date'];
    $totalRevenueBar[] = $data['TotalRevenue'];
}

// Biểu đồ Doughnut: Doanh thu theo sản phẩm
$donutQuery = $database->select("
  SELECT p.ProductName, SUM(od.Quantity * od.UnitPrice) AS TotalRevenue
  FROM product p
  JOIN orderdetail od ON p.ProductID = od.ProductID
  JOIN `order` o ON od.OrderID = o.OrderID
  GROUP BY p.ProductName
");

$productNames = [];
$totalRevenueDonut = [];

foreach ($donutQuery as $data) {
    $productNames[] = $data['ProductName'];
    $totalRevenueDonut[] = $data['TotalRevenue'];
}
?>


<script>
// Khi người dùng nhấn nút thống kê
document.getElementById("stats-btn").addEventListener("click", function() {
    // Hiển thị cả 2 canvas (biểu đồ)
    document.getElementById("myBarChart").style.display = "block";
    document.getElementById("myDoughnutChart").style.display = "block";
    
    // Khởi tạo dữ liệu và vẽ biểu đồ Bar
    const barLabels = <?php echo json_encode($dates); ?>;
    const barDataValues = <?php echo json_encode($totalRevenueBar); ?>;

    const barColors = [
      'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(201, 203, 207, 0.2)',
    ];

    const barBorderColors = [
      'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)',
    ];

    const barData = {
      labels: barLabels,
      datasets: [{
        label: 'Doanh thu theo thời gian',
        data: barDataValues,
        backgroundColor: barColors.slice(0, barDataValues.length),
        borderColor: barBorderColors.slice(0, barDataValues.length),
        borderWidth: 1
      }]
    };

    const barConfig = {
      type: 'bar', // Biểu đồ dạng cột (Bar)
      data: barData,
      options: {
        responsive: true,
        scales: {
          x: {
            beginAtZero: true,
          },
          y: {
            beginAtZero: true
          }
        },
        plugins: {
          legend: {
            display: true,
            position: 'top'
          }
        }
      },
    };

    var myBarChart = new Chart(
      document.getElementById('myBarChart'),
      barConfig
    );

    // Khởi tạo dữ liệu và vẽ biểu đồ Doughnut
    const donutLabels = <?php echo json_encode($productNames); ?>;
    const donutDataValues = <?php echo json_encode($totalRevenueDonut); ?>;

    const donutColors = [
      'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(201, 203, 207, 0.2)',
    ];

    const donutBorderColors = [
      'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)',
    ];

    const donutData = {
      labels: donutLabels,
      datasets: [{
        label: 'Doanh thu theo sản phẩm',
        data: donutDataValues,
        backgroundColor: donutColors.slice(0, donutDataValues.length),
        borderColor: donutBorderColors.slice(0, donutDataValues.length),
        borderWidth: 1
      }]
    };

    const donutConfig = {
      type: 'doughnut', // Biểu đồ hình tròn (Doughnut)
      data: donutData,
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top'
          },
          tooltip: {
            callbacks: {
              label: function(tooltipItem) {
                return tooltipItem.label + ': ' + tooltipItem.raw.toLocaleString() + ' VND';
              }
            }
          }
        }
      },
    };

    var myDoughnutChart = new Chart(
      document.getElementById('myDoughnutChart'),
      donutConfig
    );
});
</script>


    <!-- Bootstrap core JavaScript-->
    <?php 
    include_once('./common/script/default.php')
    ?>
</body>

</html>
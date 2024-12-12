<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  <?php  include_once('./common/head/head.php')    ?>
 
  <style>
     .nav-item.dropdown:hover .dropdown-menu {
        display: block;  /* Hiển thị menu khi hover */
    }

    .dropdown-menu {
        display: none; /* Ẩn menu khi không hover */
    }

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
<?php
    include_once('./connect/database.php');
    $db = new Database();
    $conn = $db->connect();

    function format_currency_vnd($amount) {
        return number_format($amount, 3, ',', '.') . ' ₫';
    }
    
?>
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
                  

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                      

                        <!-- Nav Item - Alerts -->
                       

                        <!-- Nav Item - Messages -->
                      

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
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
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
                <!-- End of Topbar -->
                <div class="container mt-4">
                  <h1 class="h3 mb-0 text-gray-800">THÔNG TIN KHÁCH HÀNG</h1>
    
                <!-- Begin Page Content -->
                <div class="container-fluid">
                   
                    <!-- Content Row -->
                    <div class="container my-5">
                        <div class="card mb-4" id="customer-info">
                        <div class="card-body">
                        <?php
                      
                            $id = isset($_GET['customerId']) ? intval($_GET['customerId']) : 1;
                            
                            $customerSql = "SELECT CustomerName, Email, CustomerPhone,
                            (SELECT COUNT(*) FROM `order` WHERE CustomerID = $id) AS TotalOrders,
                            (SELECT SUM(p.UnitPrice * od.Quantity) FROM `order` o 
                             JOIN orderdetail od ON o.OrderID = od.OrderID 
                             JOIN product p ON p.ProductID = od.ProductID 
                             WHERE o.CustomerID = $id) AS TotalSpent,
                             CustomerPoint 
                             FROM customer 
                             WHERE CustomerID = $id";

                            $result = $conn->query($customerSql);
                            if ($result && $result->num_rows > 0) {
                                 while($row = $result->fetch_assoc()) {
                                    echo '<h5 class="card-title">Tên: <span id="customer-name">' . ($row['CustomerName']) . '</span></h5>';
                                    echo '<p class="card-text">Email: <span id="customer-email">' . ($row['Email']) . '</span></p>';
                                    echo '<p class="card-text">Số điện thoại: <span id="customer-phone">' . ($row['CustomerPhone']) . '</span></p>';
                                    echo '<p class="card-text">Tổng số đơn hàng: <span id="total-orders">' . $row['TotalOrders'] . '</span></p>';
                                    echo '<p class="card-text">Tổng chi tiêu: <span id="total-spent">' . number_format($row['TotalSpent'], 0, ',', '.') . ' đ</span></p>';
                                    echo '<p class="card-text">Điểm tích lũy: <span id="reward-points">' . ($row['CustomerPoint']) . '</span></p>';
                                } 
                            
                            }else {
                                echo '<p>Không tìm thấy thông tin khách hàng.</p>';
                            }
           
                    ?>
                            
                        </div>
                    </div>

                    <h3>Lịch sử mua sắm</h3>
                    <table class="table table-striped" id="purchase-history">
                        <thead>
                            <tr>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Ngày mua</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = "SELECT p.ProductName, od.Quantity, p.UnitPrice, o.CreateDate
                                FROM `order` o 
                                JOIN orderdetail od ON o.OrderID = od.OrderID 
                                JOIN product p ON p.ProductID = od.ProductID 
                                WHERE o.CustomerID = $id";

                                $result = $conn->query($query);

                                if($result && $result->num_rows>0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                            echo '<td>' . $row['ProductName'] . '</td>';
                                            echo '<td>' . $row['Quantity'] . '</td>';
                                            echo '<td>' . number_format($row['UnitPrice'], 0, ',', '.') . ' đ</td>';
                                            echo '<td>' . date('d/m/Y', strtotime($row['CreateDate'])) . '</td>';
                                        echo " </tr>";
                                    }
                                }
                            ?>
                        </tbody>
                    </table>

                    <div class="chart-container">
                        <canvas id="purchaseChart"></canvas>
                    </div>

                    <button class="btn btn-secondary" id="back-button">Trở về</button>
                 </div>

                   
                </div>
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
    </div>

    

    <script>
     
    $(document).ready(function() {
      // Dữ liệu mẫu cho biểu đồ
      const purchaseData = {
        labels: [],
        datasets: [{
          label: 'Số lượng sản phẩm đã mua',
          data: [],
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1
        }]
      };


      <?php
        $query = "SELECT MONTH(o.CreateDate) AS month, SUM(od.Quantity) AS total_quantity
                FROM `order` o
                JOIN orderdetail od ON o.OrderID = od.OrderID
                JOIN product p ON p.ProductID = od.ProductID
                WHERE o.CustomerID = $id
                GROUP BY MONTH(o.CreateDate)
                ORDER BY MONTH(o.CreateDate)";

        $result = $conn->query($query);

        // Tạo dữ liệu cho biểu đồ
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo 'purchaseData.labels.push("Tháng ' . $row['month'] . '");';
                echo 'purchaseData.datasets[0].data.push(' . $row['total_quantity'] . ');';
            }
        } else {
            echo 'purchaseData.labels.push("");';
            echo 'purchaseData.datasets[0].data.push(0, 0, 0, 0);'; 
        }
    ?>
      // Vẽ biểu đồ
      console.log(purchaseData);

      const ctx = $('#purchaseChart')[0].getContext('2d');
      const purchaseChart = new Chart(ctx, {
        type: 'bar',
        data: purchaseData,
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });

      // Sự kiện quay lại
      $('#back-button').click(function() {
            window.history.back();
      });
    });

  </script>
    <!-- Script -->
    <?php include_once('./common/script/default.php')?>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  <?php  include_once('./common/head/head.php')    ?>
 
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
                                    echo '<p class="card-text">Tổng chi tiêu: <span id="total-spent">' . format_currency_vnd($row['TotalSpent']) . '</span></p>';
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
                                            echo '<td>' . format_currency_vnd($row['UnitPrice']) . '</td>';
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
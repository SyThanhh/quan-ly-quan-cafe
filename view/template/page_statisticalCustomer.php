<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php  include_once('./common/head/head.php')    ?>
    <style>

        @media (min-width: 768px) {
            .chart-pie {
                height: calc(23rem - 38px) !important;
            }
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
                <!-- End of Topbar -->
                <div class="container mt-4">
                  <h1 class="h3 mb-0 text-gray-800">THỐNG KÊ THÔNG TIN KHÁCH HÀNG</h1>
    
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <button class="btn btn-primary btn-sm stats-btn" data-type="products">Thống kê theo sản phẩm</button>
                                        <button class="btn btn-primary btn-sm stats-btn" data-type="points">Thống kê theo mức điểm và chi tiêu</button>
                                    </h6>
                
                                </div>
                                <!-- Card Body -->
                                <div class="container">
                                    <div class="stats-option">
                                       
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area">
                                         <canvas id="statsChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow" style="width:420px;">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="width:418px;">
                                    <h6 class="m-0 font-weight-bold text-primary">Tổng chi tiêu của khách hàng</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                      
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie ">
                                        <canvas id="pieChart"></canvas>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="container my-5">
                       
                        <div class="data-table">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Tên khách hàng</th>
                                    <th>Tổng lượng mua</th>
                                    <th>Xem chi tiết</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $sql = "SELECT c.CustomerID, c.CustomerName, SUM(p.UnitPrice * od.Quantity) AS TotalPurchase
                                    FROM customer c
                                    JOIN `order` o ON c.CustomerID = o.CustomerID
                                    JOIN orderdetail od ON od.OrderID = o.OrderID
                                    JOIN product p ON p.ProductID = od.ProductID
                                    GROUP BY c.CustomerID";
                    
                                    $result = $conn->query($sql);
                            
                                    // Kiểm tra kết quả truy vấn
                                    if ($result && $result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<tr>';
                                            echo '<td>' . htmlspecialchars($row['CustomerName']) . '</td>'; // Tên khách hàng
                                            echo '<td>' . format_currency_vnd($row['TotalPurchase']) .'</td>'; // Tổng lượng mua
                                            echo '<td><a href="?page=page_viewDetailCustomer&customerId=' . $row['CustomerID'] . '" class="btn btn-primary btn-sm">Xem</a></td>'; // Nút xem chi tiết
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="3">Không có dữ liệu nào.</td></tr>';
                                    }
                                ?>
                            
                                </tbody>
                            </table>
                        </div>
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

  
    <!-- Script -->
    <?php include_once('./common/script/default.php')?>


    <script>
        
        $(document).ready(function() {
           

        $('.stats-btn').on('click', function() {
            const type = $(this).data('type'); // Lấy kiểu thống kê

            // Gọi hàm fetch dữ liệu và vẽ biểu đồ
            fetchData(type);
        });

        // Hàm fetch dữ liệu và vẽ biểu đồ
        function fetchData(type) {
            $.ajax({
                url: `view/template/get_data.php?type=${type}`,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                   
                    if (type === "points") {

                        renderPieChart(data); // Vẽ biểu đồ pie
                    }
                    renderChart(data, type); // Vẽ biểu đồ cột
                },
                error: function(error) {
                    console.error('Có vấn đề với yêu cầu fetch:', error);
                }
            });
        }

        // Hàm vẽ biểu đồ hình tròn
        function renderPieChart(data) {
            const pieCtx = $('#pieChart')[0].getContext('2d');
            if (pieChart instanceof Chart) {
                pieChart.destroy(); // Hủy biểu đồ cũ nếu có
            }

            window.pieChart = new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: data.labels, // Tên khách hàng
                    datasets: [{
                        label: 'Tổng giá trị đơn hàng',
                        data: data.datasets[0].data, // Dữ liệu tổng giá trị đơn hàng
                        backgroundColor: data.datasets[0].backgroundColor,
                        borderColor: data.datasets[0].borderColor,
                        borderWidth: data.datasets[0].borderWidth,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: "" 
                        }
                    }
                }   
            });
        }

        function renderChart(data, types) {
            if (statsChart instanceof Chart) {
                statsChart.destroy();
            }

            const ctx = $('#statsChart')[0].getContext('2d');
            statsChart = new Chart(ctx, {
                type: 'bar', // Hoặc loại biểu đồ bạn đang sử dụng
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: data.title,
                        data: data.datasets[0].data,
                        backgroundColor: data.datasets[0].backgroundColor,
                        borderColor: data.datasets[0].borderColor,
                        borderWidth: data.datasets[0].borderWidth
                    }]
                },
                options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: "" // Tiêu đề cho biểu đồ
                    },
                    legend: {
                        display: true // Hiển thị legend nếu cần
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: (types === 'products') ? 'Tên Sản Phẩm' : 'Tên Khách Hàng',
                            font: {
                            size: 16 // Kích thước chữ cho nhãn trục Y
                        }
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: (types === 'products') ? 'Số Lượng Bán Ra' : 'Tổng Giá Trị Đơn Hàng (VNĐ)', // Tên cho trục Y
                            font: {
                            size: 16 // Kích thước chữ cho nhãn trục Y
                        }
                        },
                        beginAtZero: true // Bắt đầu từ 0
                    }
                }
            }
            });
        }
        });

    </script>
   
</body>

</html>
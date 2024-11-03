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
    </style>
</head>
<?php
    include_once('./connect/database.php');
    $db = new Database();
    $conn = $db->connect();
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
                                    <button class="btn btn-primary btn-sm stats-btn" data-type="points">Thống kê theo điểm</button>    
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
                                        <canvas id="pieChart" width="500" height="500"></canvas>
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

                            ?>
                            
                            <tr>
                                <td>Mary Johnson</td>
                                <td>$4,500</td>
                                <td><a href="?page=page_viewDetailCustomer" class="btn btn-primary btn-sm">Xem</a></td>
                            </tr>
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
    // $(document).ready(function() {
    //   const ctx = $('#statsChart')[0].getContext('2d');
    //   const pieCtx = $('#pieChart')[0].getContext('2d');

    //   let statsChart, pieChart;

    //   // Dữ liệu mẫu cho thống kê theo sản phẩm
    //   const productData = {
    //     labels: ['Cà phê', 'Cà pha Phin', 'Nước ép'],
    //     datasets: [{
    //       label: 'Số lượng bán',
    //       data: [120, 150, 90],
    //       backgroundColor: [
    //         'rgba(255, 99, 132, 0.2)',
    //         'rgba(54, 162, 235, 0.2)',
    //         'rgba(255, 206, 86, 0.2)'
    //       ],
    //       borderColor: [
    //         'rgba(255, 99, 132, 1)',
    //         'rgba(54, 162, 235, 1)',
    //         'rgba(255, 206, 86, 1)'
    //       ],
    //       borderWidth: 1
    //     }]
    //   };

    //   // Add sample data for `pointsData`
    //     const pointsData = {
    //     labels: ['Hạng kim Cương', 'Hạng Vàng', 'Hạng Bạc'],
    //     datasets: [{
    //         label: 'Điểm thưởng',
    //         data: [300, 450, 200],
    //         backgroundColor: [
    //         'rgba(153, 102, 255, 0.2)',
    //         'rgba(75, 192, 192, 0.2)',
    //         'rgba(255, 159, 64, 0.2)'
    //         ],
    //         borderColor: [
    //         'rgba(153, 102, 255, 1)',
    //         'rgba(75, 192, 192, 1)',
    //         'rgba(255, 159, 64, 1)'
    //         ],
    //         borderWidth: 1
    //     }]
    //     };

    //   const pieData = {
    //         labels: ['Nguyễn Văn A', 'Văn Thị Mọng', 'Đào lê'],
    //         datasets: [{
    //             label: 'Tổng chi tiêu',
    //             data: [5000, 3000, 4500],
    //             backgroundColor: [
    //                 'rgba(255, 99, 132, 0.2)',
    //                 'rgba(54, 162, 235, 0.2)',
    //                 'rgba(255, 206, 86, 0.2)'
    //             ],
    //             borderColor: [
    //                 'rgba(255, 99, 132, 1)',
    //                 'rgba(54, 162, 235, 1)',
    //                 'rgba(255, 206, 86, 1)'
    //             ],
    //             borderWidth: 1
    //         }]
    //     };

    //     $(document).ready(function() {
    //         const ctx = $('#pieChart')[0].getContext('2d');
    //         const pieChart = new Chart(ctx, {
    //             type: 'pie',
    //             data: pieData,
    //             options: {
    //                 responsive: true,
    //                 plugins: {
    //                     legend: {
    //                         position: 'top',
    //                     },
    //                     title: {
    //                         display: true,
    //                         text: 'Tổng chi tiêu của khách hàng'
    //                     }
    //                 }
    //             }
    //         });
    //     });

    //     function renderChart(data) {
    //         if (statsChart) {
    //             statsChart.destroy(); // Xóa biểu đồ cũ nếu có
    //             statsChart.data.datasets[0].data = data.datasets[0].data; // Cập nhật dữ liệu
    //             statsChart.update(); // Cập nhật biểu đồ
    //         }
    //         statsChart = new Chart(ctx, {
    //             type: 'bar',
    //             data: data,
    //             options: {
    //                 scales: {
    //                     y: {
    //                         beginAtZero: true, // Bắt đầu từ 0
    //                         min: 0,
    //                         max : 500
    //                     }
    //                 },
    //                 plugins: {
    //                     title: {
    //                         display: true,
    //                         text: 'Thống kê theo sản phẩm'
    //                     }
    //                 }
    //             }
    //         });
    //     }
    //   function renderPieChart(data) {
    //         if (pieChart) {
    //             pieChart.destroy(); // Xóa biểu đồ cũ nếu có
    //         }
    //         pieChart = new Chart(pieCtx, {
    //             type: 'pie',
    //             data: data,
    //             options: {
    //             responsive: true,
    //             plugins: {
    //                 legend: {
    //                 position: 'right', // Di chuyển huyền thoại đến bên phải
    //                 labels: {
    //                     font: {
    //                     size: 14 // Tăng kích thước phông chữ của huyền thoại
    //                     }
    //                 }
    //                 },
    //                 title: {
    //                 display: true,
    //                 // text: 'Tổng chi tiêu của khách hàng',
    //                 font: {
    //                     size: 18 // Tăng kích thước phông chữ của tiêu đề
    //                 }
    //                 }
    //             }
    //             }
    //         });
    //     }
    //   $('.stats-btn').click(function() {
    //     const type = $(this).data('type');
    //     $('#error-message').hide(); // Ẩn thông báo lỗi

    //     if (type === 'products') {
    //       renderChart(productData);
    //       renderPieChart(pieData); // Cập nhật biểu đồ tròn theo sản phẩm
    //     } else if (type === 'points') {
    //       renderChart(pointsData);
    //       renderPieChart(pieData); // Cập nhật biểu đồ tròn theo điểm
    //     } else {
    //       $('#error-message').show(); // Hiển thị thông báo lỗi nếu không có dữ liệu
    //     }
    //   });
    //   console.log(pointsData);
    //   // Hiển thị biểu đồ theo sản phẩm mặc định khi tải trang
    //   renderChart(productData);
    //   renderPieChart(pieData); // Hiển thị biểu đồ tròn mặc định
    // });
   document.addEventListener('DOMContentLoaded', function() {
    // Lấy dữ liệu sản phẩm
    fetch('view/template/get_data.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log(data);
        renderChart(data);
        renderPieChart(pieData);
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
});

//     function renderChart(data) {
//         if (statsChart) {
//             statsChart.destroy(); // Xóa biểu đồ cũ nếu có
//         }
//         statsChart = new Chart(ctx, {
//             type: 'bar',
//             data: data,
//             options: {
//                 scales: {
//                     y: {
//                         beginAtZero: true,
//                         min: 0
//                     }
//                 },
//                 plugins: {
//                     title: {
//                         display: true,
//                         text: 'Thống kê theo sản phẩm'
//                     }
//                 }
//             }
//         });
//     }
// });
  </script>
  <!-- <script>

     $(document).ready(function() {
      const ctx = $('#statsChart')[0].getContext('2d');

      const productData = {
        labels: ['Cà phê', 'Cà pha Phin', 'Nước ép'],
        datasets: [{
          label: 'Số lượng bán',
          data: [120, 150, 90],
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)'
          ],
          borderWidth: 1
        }]
      };

      const statsChart = new Chart(ctx, {
        type: 'bar',
        data: productData,
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          },
          plugins: {
            title: {
              display: true,
              text: 'Thống kê theo sản phẩm'
            }
          }
        }
      });
    });
  </script> -->
   
</body>

</html>
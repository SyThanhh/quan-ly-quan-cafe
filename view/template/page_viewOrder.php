<?php
    // session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/table.css">
    <!-- Đầu trang -->
    <?php
        include_once('./common/head/head.php');   
        include_once('./controller/OrderController.php'); // Đường dẫn vào file kết nối database

        $orderController = new OrderController(); 

        $fromDate = '';
        $toDate = '';
        $orders = [];
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $fromDate = isset($_POST['from-date']) ? $_POST['from-date'] : '';
            $toDate = isset($_POST['to-date']) ? $_POST['to-date'] : '';
        
            $_SESSION['from-date'] = $fromDate;
            $_SESSION['to-date'] = $toDate;
        
            if (!empty($fromDate) || !empty($toDate)) {
                $orders = $orderController->getAllOrders($fromDate, $toDate);
            } else {
                $orders = $orderController->getAllOrders("", ""); 
            }
        } elseif (isset($_POST['clear'])) {
            unset($_SESSION['from-date']); 
            unset($_SESSION['to-date']);
            $fromDate = '';
            $toDate = '';
            $orders = $orderController->getAllOrders("", "");
        } else {
            $fromDate = isset($_SESSION['from-date']) ? $_SESSION['from-date'] : '';
            $toDate = isset($_SESSION['to-date']) ? $_SESSION['to-date'] : '';
            $orders = $orderController->getAllOrders($fromDate, $toDate);
        }
        
        
    ?>
    
    <style>
      
        
        @media (max-width: 600px) {
            .table, .table thead, .table tbody, .table th, .table td, .table tr {
                display: block;
            }
            .table thead {
                display: none;
            }
            .table tbody tr {
                margin-bottom: 15px;
            }
            .table td {
                text-align: right;
                position: relative;
                padding-left: 50%;
            }
             .table td:before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                width: 45%;
                padding-left: 10px;
                text-align: left;
                font-weight: bold;
            } 

        }

        .filter-container {
            width: 200px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            width: fit-content;
        }

        .date-input {
            display: flex;
            flex-direction: column;
            align-items: start;
        }

        .date-input label {
            font-size: 13px;
            margin-bottom: 2px;
            color: #333;
        }

        .date-input input[type="date"] {
            padding: 6px;
            font-size: 13px;
            border: 1px solid #ccc;
            border-radius: 3px;
            width: 195px;
        }

        .filter-button {
            padding: 6px 15px;
            font-size: 13px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            margin-top: 15px;
        }

        .filter-button:hover {
            background-color: #0056b3;
        }

    </style>
</head>

<body>
    <div id="wrapper">
        <!-- Thanh điều hướng dọc -->
        <?php include_once('./common/menu/siderbar.php'); ?>

        <!-- Giao diện trang -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Thanh điều hướng ngang -->
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

                <!--  Nội dung trang  -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="header text-left">
                                <h4>QUẢN LÝ HÓA ĐƠN</h4>
                            </div>
                            
                            <div class="col-md-12 text-center">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group" style="width:55%;">
                                            <div class="filter-container">
                                                <form class="d-flex" id="filter-date" method="post">
                                                    <div class="date-input mr-2">
                                                        <label for="from-date">Từ ngày:</label>
                                                        <input type="date" id="from-date" name="from-date" placeholder="mm/dd/yyyy" value="<?php echo isset($_SESSION['from-date']) ? $_SESSION['from-date'] : ''; ?>">
                                                    </div>
                                                    <div class="date-input mr-2">
                                                        <label for="to-date">Đến ngày:</label>
                                                        <input type="date" id="to-date" name="to-date" placeholder="mm/dd/yyyy" value="<?php echo isset($_SESSION['to-date']) ? $_SESSION['to-date'] : ''; ?>">
                                                    </div>
                                                    <button class="filter-button mr-2" id="btn-filter" type="submit">Lọc</button>
                                                    <button class="btn  filter-button  btn-light" id="btn-clear">
                                                         <i class="fas fa-eraser"></i>
                                                    </button>
                                                </form>
                                            </div>

                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </br>

                            <!-- Danh sách nhân viên -->
                             <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Tên Khách hàng</th> 
                                            <!-- <th scope="col">Tên Khách hàng</th>-->
                                            <th scope="col">Ngày tạo</th>
                                            <th scope="col">Giảm giá</th>
                                            <th scope="col">Hình thức thanh toán</th>
                                            <th scope="col">Tổng tiền</th>
                                            <th scope="col">Trạng thái</th>
                                            <th scope="col">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        
                                          
                                            // Hiển thị danh sách nhân viên
                                            if ($orders) {
                                                while ($row = $orders->fetch_assoc()) {
                                                    echo "<tr>";
                                                        echo "<td>{$row['OrderID']}</td>";
                                                        echo "<td>{$row['CustomerName']}</td>";
                                                        // echo "<td>{$row['FirstName']} {$row['LastName']}</td>"; 
                                                        echo "<td>{$row['CreateDate']}</td>";
                                                        echo "<td>{$row['CouponDiscount']} <span>%</span></td>";
                                                        echo "<td>{$row['PaymentMethod']}</td>";
                                                        echo "<td>{$row['TotalAmount']} <span>đ</span> </td>";
                                                        echo "<td>";
                                                            if ($row['Status']) {
                                                                echo "<span class='badge badge-success'>Đã thanh toán</span>";
                                                            } else {
                                                                echo "<span class='badge badge-danger'>Chưa thanh toán</span>";
                                                            }
                                                        echo "</td>";
                                                        echo "<td><a href='index.php?page=page_viewOrderDetail&OrderID={$row['OrderID']}' class='btn btn-primary btn-sm view-invoice'>Xem chi tiết</a></td>"; 
                                                    echo "</tr>";
                                                   
                                                }
                                            } else {
                                                echo "<tr><td colspan='9' class='text-center text-danger'>Không có dữ liệu</td></tr>";
                                            }
                                        ?>
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
                        </div>
                    </div>
                </div>

             

            </div>
            <!-- Cuối trang -->
            <?php include_once('./common/footer/footer.php'); ?>
        </div>   

    
    <!-- Bootstrap core JavaScript-->
     
    <?php include_once('./common/script/default.php'); ?>
    <script>
        $('#btn-clear').on('click', function(e) {
            $('#from-date').val('');
                
            $('#to-date').val('');
            clearSearch();
        });

           
        function clearSearch(e) {
            // e.preventDefault();
           
            $.ajax({
                url: '?page=page_viewOrder', 
                data: { clear: true }, 
                success: function(response) {
                    $('#search-results').html(response);
                },
                error: function() {
                    $('#search-results').html('<p class="text-danger">Có lỗi xảy ra trong quá trình tìm kiếm.</p>');
                }
            });
        }
    </script>
</body>
</html>

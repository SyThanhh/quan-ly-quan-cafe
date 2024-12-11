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
        include_once('./connect/database.php'); // Đường dẫn vào file kết nối database

        // Tạo một đối tượng Database để kết nối
        $database = new Database();
        $conn = $database->connect(); // Lấy kết nối
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

       
    </style>
</head>
<?php
    include_once('./controller/OrderDetailController.php'); 
    $orderDetailController = new OrderDetailController();
?>
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

                <!--  Nội dung trang  -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="header text-left">
                                <h4>XEM CHI TIẾT HÓA ĐƠN</h4>
                            </div>
                            
                            <div class="col-md-12 mt-4" style="padding-bottom: -20px;">
                                <div class="row">
                                    <div class="col-md-6">
                                         <a href="?page=page_viewOrder" class="btn btn-primary" style="border: none;
    background: #683c08bf;">
                                         <i class="fas fa-arrow-left"></i> Trở lại
                                        </a>
                                    </div>
                                </div>
                            </div>
                            </br>

                            <!-- Danh sách nhân viên -->
                             <table class="table">
                                    <thead style="border: none;
    background: #683c08bf;">
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Tên Nhân viên</th> 
                                            <th scope="col">Ngày tạo</th>
                                            <!-- <th scope="col">Tên Khách hàng</th>-->
                                            <th scope="col">Mã sản phẩm</th>
                                            <th scope="col">Tên sản phẩm</th>
                                            <th scope="col">Giá bán</th>
                                            <th scope="col">Số lượng</th>
                                            <th scope="col">Tổng tiền</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                           if (isset($_GET["OrderID"])) {
                                            $orderID = $_GET["OrderID"];
                                        
                                            // Gọi phương thức lấy dữ liệu
                                            $orderDetails = $orderDetailController->getOrderDetailById($orderID);
                                        
                                         
                                                if ($orderDetails && mysqli_num_rows($orderDetails) > 0) {
                                                    while ($row = mysqli_fetch_assoc($orderDetails)) {
                                                        echo "<tr>";
                                                        echo "<td>{$row['OrderID']}</td>";
                                                        echo "<td>{$row['FirstName']} {$row['LastName']}</td>";
                                                        echo "<td>{$row['CreateDate']}</td>";
                                                        echo "<td>{$row['ProductID']}</td>";
                                                        echo "<td>{$row['ProductName']}</td>";
                                                        echo "<td>{$row['UnitPrice']}<span>đ</span></td>";
                                                        echo "<td>{$row['Quantity']}</td>";
                                                        echo "<td>" . number_format($row['Quantity'] * $row['UnitPrice'], 3) . "<span>đ</span></td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='9' class='text-center text-danger'>Không có dữ liệu</td></tr>";
                                                }   
                                                
                                            }
                                            else {
                                                    echo "<tr><td colspan='9' class='text-center text-danger'>Không tồn tại OrderID</td></tr>";
                                            }
                                        
                                        ?>
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

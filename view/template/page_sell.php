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
        include_once('./common/head/head.php') ; 
    ?>
 
    <link rel="stylesheet" href="./assets/css/sell.css">
    <link rel="stylesheet" href="./assets/css/alertNotification.css">
    <style>
        .button:hover {
            background-color: #0056b3; 
            border-color: #ffffff; /* Viền sáng lên */
        }

        /* thêm thak cuoi này vô nè */
        .product-item.out-of-stock {
            opacity: 0.5; /* Làm mờ */
            pointer-events: none; 
        }
        .product-item {
            position: relative; /* Đặt phần tử cha có position: relative để làm gốc */
        }
        .out-of-stock-message {
            color: red; 
            font-weight: bold;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.8); /* Nền trắng nhạt */
            padding: 5px;
            border-radius: 5px;
        }

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
require_once($_SERVER['DOCUMENT_ROOT'] . "/quan-ly-quan-cafe/payment/config.php");
   
    include_once('./connect/database.php'); 
    include_once('./controller/CustomerController.php'); 
    include_once('./controller/cCoupon.php'); 
    include_once('./controller/OrderController.php'); 
    include_once('./controller/EmployeeController.php'); 
    $orderController = new OrderController();
    $employeeController = new EmployeeController();

    $invoiceData = isset($_SESSION['invoiceData']) ? $_SESSION['invoiceData'] : [];
    $database = new Database();
    $conn = $database->connect(); // Lấy kết nối   
    $CustomerController = new CustomerController();
    $CouponController = new cCoupon();
    $searchKeyword = '';

    
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['search-sell'])) {
            $_SESSION['searchKeywordSell'] = $_POST['search-sell']; // Lưu từ khóa tìm kiếm
            $searchKeyword = $_SESSION['searchKeywordSell'];
            $customerBySearch = $CustomerController->getAllCustomersByPhone($searchKeyword);
            if (is_array($customerBySearch)) {
                $_SESSION["CustomerName"] =  $customerBySearch['CustomerName'] ?  $customerBySearch['CustomerName'] : "";
                $_SESSION["CustomerPhone"] =  $customerBySearch['CustomerPhone'] ?  $customerBySearch['CustomerPhone'] : "";
                $_SESSION["CustomerPoint"] =  $customerBySearch['CustomerPoint'] ?  $customerBySearch['CustomerPoint'] : "0";
                $_SESSION["CustomerEmail"] =  $customerBySearch['Email'] ?  $customerBySearch['Email'] : "";
            }
        }
        if (isset($_POST['clearSell'])) {
            $_SESSION["CustomerName"] = null;
            $_SESSION['CustomerPhone'] = null;
            $_SESSION['CustomerPoint'] = null;
            $_SESSION['CustomerEmail'] = null;
            unset($_SESSION['searchKeywordSell']); 

        }
    }

   
    if (isset($_SESSION['customerID'])) {
        $customerID = $_SESSION['customerID'];
        $customer = $CustomerController->getCustomerById($customerID);
        if (isset($_POST['clearSell'])) {

            $searchKeyword = null;
            unset($_SESSION['searchKeywordSell']);
            unset($_SESSION['customerID']);

            $customer['CustomerName'] = null;
            unset($_SESSION['CustomerName']); 

            $customer['CustomerPhone'] = null;
            unset($_SESSION['CustomerPhone']); 

            $customer['CustomerPoint'] = null;
            unset($_SESSION['CustomerPoint']); 

            $customer['CustomerEmail'] = null;
            unset($_SESSION['CustomerEmail']); 
        } else {
            if(is_array($customer)) {
                $_SESSION["CustomerName"] = $customer['CustomerName'] ? $customer['CustomerName'] : "";
                $_SESSION["CustomerPhone"] = $customer['CustomerPhone'] ? $customer['CustomerPhone'] : "";
                $_SESSION["CustomerPoint"] = $customer['CustomerPoint'] ? $customer['CustomerPoint'] : "0";
                $_SESSION["CustomerEmail"] =  $customer['Email'] ?  $customer['Email'] : "";
            }
        }
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

                        <?php
                         if (isset($_SESSION["role"]) && ($_SESSION["role"] === 1 || $_SESSION["role"] === 2)) {
                                $role =  $_SESSION['role'];
                                $employee = $employeeController->selectEmployeeByRoles($role);
                                if(is_array($employee)) {
                                    $employeeID = $employee["EmployeeID"];
                                }

                         }

                        ?>
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

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="header text-center">
                                <h4>THÔNG TIN KHÁCH HÀNG</h4>
                            </div>
                            <div id="message-notification" class="alert" style="display: none;">
                                <strong></strong> <span class="message-content"></span>
                            </div>

                        <!-- <form id="formInfoOrder" action="?page=page_sell"> -->
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <form method="POST" id="search-form" class="d-flex flex-column">
                                        <label for="phone">Số điện thoại</label>
                                       
                                        <?php
                                            if (isset($_SESSION['searchKeywordSell']) && !empty($_SESSION['searchKeywordSell'])) {
                                                echo '<input type="text" class="form-control" name="search-sell" id="name-search" placeholder="Tìm nhân viên theo tên / số điện thoại" value="' . $_SESSION["searchKeywordSell"] . '">';
                                            } elseif (isset($_SESSION['CustomerPhone']) && !empty($_SESSION['CustomerPhone'])) {
                                                echo '<input type="text" class="form-control" name="search-sell" id="name-search" placeholder="Tìm nhân viên theo tên / số điện thoại" value="' . $_SESSION["CustomerPhone"] . '">';
                                            } else {
                                                echo '<input type="text" class="form-control" name="search-sell" id="name-search" placeholder="Tìm nhân viên theo tên / số điện thoại" value="">';
                                            }
                                        ?>

                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary search-button" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary search-button" id="btn-clear">
                                                <i class="fas fa-eraser"></i>
                                            </button>
                                            <button type="button" id="btnAddCustomerPageSell" class="btn btn-primary btn-add">
                                                <i class="fas fa-plus-square"></i>
                                                Thêm mới
                                            </button>
                                        </div>
                                    </form>
                                  
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="customerName">Tên khách hàng</label>
                                    <input type="text" class="form-control" id="customerNameSell" name="customerNameSell" placeholder="Nhập tên khách hàng" value="<?php echo isset($_SESSION["CustomerName"]) ? $_SESSION["CustomerName"] : ''; ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="points">Điểm</label>
                                    <input type="text" class="form-control" id="points" placeholder="Điểm tích lũy" value="<?php echo isset($_SESSION["CustomerPoint"]) ? $_SESSION["CustomerPoint"] : '0'; ?>" readonly>
                                    <!-- <button type="button" class="btn btn-secondary btn-custom">Quy đổi</button> -->
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="points">Email</label>
                                    <input type="text" class="form-control" id="customerEmailSell" placeholder="" value="<?php echo isset($_SESSION["CustomerEmail"]) ? $_SESSION["CustomerEmail"] : ''; ?>" readonly>
                                    <!-- <button type="button" class="btn btn-secondary btn-custom">Quy đổi</button> -->
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="discountCode">Mã KM</label>
                                    <select class="form-control" id="discountCode">
                                        <option value="0">Chọn mã KM</option>
                                    <?php
                                        $point = isset($_SESSION["CustomerPoint"]) ? $_SESSION["CustomerPoint"] : '0';
                                        $coupons = $CouponController->getCouponByPoint($point);
                                        if ($coupons) {
                                            while ($cpon = mysqli_fetch_assoc($coupons)) {
                                                echo "<option value='".$cpon["CouponID"]."'>".$cpon["CouponCode"]."</option>";
                                            }
                                        } else {
                                            echo "<option>Không đủ điểm</option>";
                                        }
                                    ?>
                                   
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="reduction">Giảm Giá (%) </label>
                                    <input type="text" class="form-control" id="reduction" value="" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <!-- Ô trống để tạo sự cân bằng -->
                                </div>
                            </div>
            
                            <div class="header text-center">
                                <h4>THÔNG TIN HÓA ĐƠN</h4>
                            </div>
                            <table class="table table-bordered mt-3" id="invoice-list">
                                <thead class="table-header">
                                    <tr>
                                        <th>Tên SP</th>
                                        <th>Đơn Giá</th>
                                        <th>SL</th>
                                        <th>Tổng</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="invoice-list-body">
                                    <!-- Các sản phẩm sẽ được thêm vào đây -->
                                </tbody>
                            </table>
                            <div class="text-right d-flex justify-content-end">
                                <h5 class="mr-4">Giảm : <span id="total-amount-discount">0</span> VNĐ</h5> 
                                <h5 id="grand-total">Tổng tất cả:</span> <span id="total-amount">0.0</span>VNĐ</h5>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <!-- <button class="btn btn-danger me-2" style="transform: translate(-12px, 0px);">HỦY</button> -->
                                <button type="button" id="btnPaymentModal" class="btn btn-primary" data-toggle="modal" data-target="#paymentModal">THANH TOÁN</button>
                            </div>
            
                        </div>
                
                        <!-- </form> -->
                       
                        <div class="col-md-6">
                            <div class="header text-center">
                                <h4>BỘ LỌC</h4>
                            </div>
                            
                            <form id="formProduct" method="post">
                                <div class="form-group">
                                    <label for="product-search">Tên Sản Phẩm:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="product-search" name="tim" placeholder="Nhập tên sản phẩm...">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary search-button m-0" type="button">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="category-select">Danh Mục Sản Phẩm:</label>
                                    <select class="form-control" id="category-select" name="category">
                                        <option value="">Chọn danh mục</option>
                                        <option value="1">Cafe pha máy</option>
                                        <option value="2">Cafe pha phin</option>
                                        <option value="3">Nước ép</option>
                                        <option value="4">Trà</option>
                                        <option value="5">Nước ngọt</option>
                                    </select>
                                </div>

                                <div class="header text-center">
                                    <h4>Danh sách sản phẩm</h4>
                                </div>
                                <div class="product-list" id="product-list">
                                    <?php
                                        // Lấy từ khóa tìm kiếm và danh mục từ form
                                        $searchKeyword = isset($_POST['tim']) ? $_POST['tim'] : '';
                                        $categoryID = isset($_POST['category']) ? (int)$_POST['category'] : null;

                                        // Truy vấn cơ sở dữ liệu
                                        $query = "SELECT ProductID, ProductName, UnitsInStock, UnitPrice, ProductImage, CategoryID FROM product WHERE 1=1";

                                        if (!empty($searchKeyword)) {
                                            $query .= " AND ProductName LIKE '%$searchKeyword%'";
                                        }

                                        if (!empty($categoryID)) {
                                            $query .= " AND CategoryID = $categoryID";
                                        }

                                        $products = $database->select($query);

                                        if ($products && $products->num_rows > 0) {
                                            while ($product = $products->fetch_assoc()) {
                                                echo '<div class="product-item" data-name="' . $product['ProductName'] . '" data-stock="' . $product['UnitsInStock'] . '" data-price="' . $product['UnitPrice'] . '" data-category="' . $product['CategoryID'] . '">';
                                                echo '<img src="assets/img/products/' . $product["ProductImage"] . '" alt="' . $product['ProductName'] . '">';
                                                echo '<p>' . $product['ProductName'] . '</p>';
                                                echo '<p class="stock">Tồn kho: ' . $product['UnitsInStock'] . '</p>';
                                                echo '<p class="price">Giá: ' . $product['UnitPrice']. '₫</p>';
                                                echo '<input type="text" name="productID" id="productID" value="' . $product['ProductID'] . '" hidden/>';
                                                echo '</div>';
                                            }
                                        } else {
                                            echo "<p>Không có sản phẩm nào phù hợp với tìm kiếm của bạn.</p>";
                                        }
                                    ?>
                                </div>
                            </form>

                            <script>
                                // Lọc sản phẩm theo tên và danh mục
                                document.getElementById("category-select").addEventListener("change", filterProducts);
                                document.getElementById("product-search").addEventListener("input", filterProducts);

                                function filterProducts() {
                                    const searchTerm = document.getElementById("product-search").value.toLowerCase();
                                    const selectedCategory = document.getElementById("category-select").value;
                                    const products = document.querySelectorAll(".product-item");

                                    products.forEach(product => {
                                        const productName = product.getAttribute("data-name").toLowerCase();
                                        const productCategory = product.getAttribute("data-category");

                                        const matchesName = productName.includes(searchTerm);
                                        const matchesCategory = !selectedCategory || productCategory === selectedCategory;

                                        if (matchesName && matchesCategory) {
                                            product.style.display = "block";
                                        } else {
                                            product.style.display = "none";
                                        }
                                    });
                                }
                            </script>

                        </div>
                    </div>
                </div>
            
              
              <!-- Modal -->
              <div class="modal fade" id="addCustomerModalSell" tabindex="-1" role="dialog" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addCustomerModalLabel">Thêm Khách Hàng</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            <!-- method="post" action="?page=processing_customer" -->
                                <form id="customerFormSell">
                                    <div class="form-group">
                                        <label for="customerName">Họ Tên</label>
                                        <input type="text" class="form-control" id="customerName" value="" name="customerFormName" placeholder="Nhập họ tên" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="customerEmail">Email</label>
                                        <input type="email" class="form-control" id="customerEmail" value="" name="customerFormEmail" placeholder="Nhập email" required>
                                        <span id="emailFeedback"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="customerPhone">Số Điện Thoại</label>
                                        <input type="tel" class="form-control" id="customerPhone" value="" name="customerFormPhone" placeholder="Nhập số điện thoại" required>
                                        <span id="phoneFeedback"></span>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Hủy</button>
                                        <button type="button" class="btn btn-primary" id="btnConFirmAddCustomerSell">Xác Nhận</button>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                            
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Modal cho phương thức thanh toán -->
                 <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="paymentModalLabel">Chọn Phương Thức Thanh Toán</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-check">
                                        <input type="radio" name="paymentMethod" id="cash" value="Tiền mặt" class="form-check-input" checked>
                                        <label for="cash" class="form-check-label">Thanh toán tiền mặt</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="paymentMethod" id="bank" value="Chuyển khoản" class="form-check-input">
                                        <label for="bank" class="form-check-label">Chuyển khoản ngân hàng</label>
                                    </div>
                                    
                                    <!-- Trường nhập tiền mặt -->
                                    <div id="cashFields" class="payment-fields mt-3">
                                        <label for="cashAmount">Số tiền khách trả:</label>
                                        <input type="text" class="form-control" id="cashAmount" placeholder="Nhập số tiền">
                                        <span id="cashAmountError" class="text-danger" style="display: none;"></span>
                                        
                                        <label for="total-amount" class="mt-3">Tổng tiền hóa đơn:</label>
                                        <input type="text" class="form-control" id="total-amount" value="0" readonly>
                                        
                                        <label for="amountReturn" class="mt-3">Tiền thối lại:</label>
                                        <input type="text" class="form-control" id="amountReturn" value="0" readonly>
                                    </div>

                                    <!-- Trường nhập thông tin chuyển khoản -->
                                    <div id="bankFields" class="payment-fields mt-3">
                                    <div class="container">

                            <h3>Tạo mới đơn hàng</h3>
                            <div class="table-responsive">
                                <form action="/quan-ly-quan-cafe/payment/vnpay_create_payment.php" id="create_form" method="post">       

                                    <div class="form-group">
                                        <label for="language">Loại hàng hóa </label>
                                        <select name="order_type" id="order_type" class="form-control">
                                            <option value="billpayment" selected>Thanh toán hóa đơn</option>
                                            <option value="other">Khác - Xem thêm tại VNPAY</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="order_id">Mã hóa đơn</label>
                                        <input class="form-control" id="order_id" name="order_id" type="text" value="<?php echo date("YmdHis") ?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="amount">Số tiền</label>
                                        <input class="form-control" id="amount"
                                            name="amount" type="number" value="10000"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="order_desc">Nội dung thanh toán</label>
                                        <textarea class="form-control" cols="20" id="order_desc" name="order_desc" rows="2">Noi dung thanh toan</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="bank_code">Ngân hàng</label>
                                        <select name="bank_code" id="bank_code" class="form-control">
                                            <option value="">Không chọn</option>
                                            <option value="NCB"> Ngan hang NCB</option>
                                        
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="language">Ngôn ngữ</label>
                                        <select name="language" id="language" class="form-control">
                                            <option value="vn">Tiếng Việt</option>
                                            <option value="en">English</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label >Thời hạn thanh toán</label>
                                        <input class="form-control" id="txtexpire"
                                            name="txtexpire" type="text" value="<?php echo $expire; ?>"/>
                                    </div>
                                    <div class="form-group">
                                        <h3>Thông tin hóa đơn (Billing)</h3>
                                    </div>
                                    <div class="form-group">
                                        <label >Họ tên (*)</label>
                                        <input class="form-control" id="txt_billing_fullname"
                                            name="txt_billing_fullname" type="text" value="NGUYEN VAN XO"/>             
                                    </div>
                                    <div class="form-group">
                                        <label >Email (*)</label>
                                        <input class="form-control" id="txt_billing_email"
                                            name="txt_billing_email" type="text" value="xonv@vnpay.vn"/>   
                                    </div>
                                    <div class="form-group">
                                        <label >Số điện thoại (*)</label>
                                        <input class="form-control" id="txt_billing_mobile"
                                            name="txt_billing_mobile" type="text" value="0934998386"/>   
                                    </div>
                                    
                                
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary mr-3" data-dismiss="modal">Đóng</button>
                                    <button type="submit" name="redirect" id="redirect" class="btn btn-default btn-primary">Xác nhận Thanh toán</button>

                                </div>
                                </form>
                            </div>
                        </div>  
                    
                        </div>
                  </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="processPayment">Xác nhận Thanh Toán</button>
                </div>
            </div>
        </div>
    </div>
               
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

          
            <!-- End of Footer -->
            <?php include_once('./common/footer/footer.php') ?>
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

  
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!--Thanh toán-->
    <script>
      
    const $totalAmountDiscount = $("#total-amount-discount");
    function updateGrandTotal() {
        const $reductionDisplay = extractDiscount($('#reduction').val());
        let grandTotal = 0;
        let grantToTalDiscount = 0;
        $invoiceListBody.find('tr').each(function() {
            const total = convertToNumber($(this).find('.total-price').text());
       
            grandTotal += total;
        });
        grantToTalDiscount = grandTotal - (grandTotal* ($reductionDisplay/100))
        $totalAmountDisplay.text(grantToTalDiscount.toLocaleString());
        let discount = (grandTotal* ($reductionDisplay/100));
        console.log("grantToTalDiscount" ,grantToTalDiscount);
        console.log("discount" ,discount);

        $totalAmountDiscount.text(discount.toLocaleString());
    }
    function validateEmail(email) {
        var regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    
         return regex.test(email);
    }

    function validatePhone(phone) {
        var regex = /^(09|03|08|07|05)[0-9]{8}$/;
        return regex.test(phone);
    }


    $(document).ready(function() {
        $("#btnAddCustomerPageSell").on('click', function() {
            $("#addCustomerModalSell").modal('show');
        });

        // Kiểm tra email
        $('#customerEmail').on('input', function() {
            const email = $(this).val().trim(); // Lấy giá trị email và xóa khoảng trắng hai đầu
            const id = ''; 

            // Kiểm tra định dạng email
            let checkEmail = validateEmail(email);
            if (!checkEmail) {
                $('#emailFeedback')
                    .text("Email không hợp lệ. Vui lòng sử dụng định dạng ví dụ: thanh@gmail.com hoặc thanh_298@gmail.com")
                    .css("color", "red");
                    $('#btnConFirmAddCustomerSell').prop('disabled', true);
                return;
            } else {
                $('#emailFeedback').text("").css("color", ""); 
                $('#btnConFirmAddCustomerSell').prop('disabled', false);
            }

            // Nếu email hợp lệ, thực hiện kiểm tra xem email có tồn tại không
            if (checkEmail) {
                $.ajax({
                    url: '?page=check_email_customer', 
                    type: 'POST',
                    data: { email: email, id: id },
                    success: function(response) {
                        if (response.exists) {
                            $('#emailFeedback').text("Email đã tồn tại.").css("color", "red");
                            $('#btnConFirmAddCustomerSell').prop('disabled', true);
                        } else {
                            $('#emailFeedback').text("Email có thể sử dụng.").css("color", "green");
                            $('#btnConFirmAddCustomerSell').prop('disabled', false);
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#emailFeedback').text("Có lỗi xảy ra. Vui lòng thử lại sau.").css("color", "red");
                        console.error('Error:', error);
                        $('#btnConFirmAddCustomerSell').prop('disabled', false);
                    }
                });
            }
        });

    // Kiểm tra số điện thoại
    $('#customerPhone').on('input', function() {
        const phone = $(this).val().trim(); 
        const id = ''; 

        if (phone && phone.length !== 10) {
            $('#phoneFeedback')
                .text("Số điện thoại phải có 10 chữ số.")
                .css("color", "red");
                $('#btnConFirmAddCustomerSell').prop('disabled', true); 
            return; // Dừng tại đây nếu số không có độ dài đúng
        }
        let checkPhone = validatePhone(phone);
        if (!checkPhone) {
            $('#phoneFeedback')
                .text("Số điện thoại không hợp lệ. Số điện thoại phải bắt đầu bằng 09, 03, 08, 07, hoặc 05 và có 10 chữ số.")
                .css("color", "red");
                $('#btnConFirmAddCustomerSell').prop('disabled', true); 
            return; // Dừng kiểm tra nếu định dạng không hợp lệ
        } else {
            $('#phoneFeedback').text("").css("color", ""); // Xóa thông báo nếu định dạng hợp lệ
        }

        if (phone) {
            $.ajax({
                url: '?page=check_phone_customer', // Đường dẫn đến script xử lý
                type: 'POST',
                data: { phone: phone, id: id }, // Gửi cả số điện thoại và ID nếu cần
                success: function(response) {
                    if (response.exists) {
                        $('#phoneFeedback').text("Số điện thoại đã tồn tại.").css("color", "red");
                        $('#btnConFirmAddCustomerSell').prop('disabled', true); 
                    } else {
                        $('#phoneFeedback').text("Số điện thoại có thể sử dụng.").css("color", "green");
                        $('#btnConFirmAddCustomerSell').prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    $('#phoneFeedback').text("Có lỗi xảy ra. Vui lòng thử lại sau.").css("color", "red");
                    $('#btnConFirmAddCustomerSell').prop('disabled', true); 
                    console.error('Error:', error);
                }
            });
        }
    });

    $('#btnConFirmAddCustomerSell').on('click', function(e) {
            const id = null;
            const name = $('#customerName').val();
            const email = $('#customerEmail').val();
            const phone = $('#customerPhone').val();
            const form =  $('#customerFormSell')[0];
            const message = $("#message-notification");
            const action = 'addSell';
            e.preventDefault();
            $.ajax({
                url: '?page=processing_customer',
                type: 'POST',
                data: { action, id, name, email, phone },
                success: function(response) {
                    if (response.success) {
                        showMessage(response.message, 'success');
            
                        setTimeout(function() {
                            update();
                        }, 2000);

                        resetForm(); 
                        
                    } else {
                        showMessage(response.message, 'danger');
                    } 
                    $('#addCustomerModalSell').modal('hide'); 
                },
                error: function(error) {
                    showMessage('Đã xảy ra lỗi: ' + error.statusText, 'danger');
                }
        });

        
    });

    $('#search-button').on('click', function(e) {
        e.preventDefault();
            const searchKeyword = $('#name-search').val();
            searchCustomers(searchKeyword);
        });

        $('#name-search').on('input', function() {
            const searchKeyword = $(this).val()
            searchCustomers(searchKeyword);
    });
    function searchCustomers(keyword) {
        $.ajax({
            url: '?page=page_sell', 
            type: 'POST',
            data: { search: keyword },
            success: function(response) {
                $('#search-results').html(response); 
            },
            error: function() {
                $('#search-results').html('<p class="text-danger">Có lỗi xảy ra trong quá trình tìm kiếm.</p>');
            }
        });
    }
    $("#btn-clear").on('click', function(e) {
        clearSearch();
        e.preventDefault();
    })

    function clearSearch() {
        $('#name-search').val(""); 
        $('#customerNameSell').val("");
        $('#customerEmailSell').val("");
        $('#points').val("");
        $('#discountCode').val("");

        // Gửi yêu cầu POST để xóa session
        $.post('?page=page_sell', { clearSell: true }, function(response) {
            // Hiển thị phản hồi từ server trong console
            console.log(response);
            $('#search-results').html(response);
        }).fail(function() {
            $('#search-results').html('<p class="text-danger">Có lỗi xảy ra trong quá trình tìm kiếm.</p>');
        });
    }


          

    function showMessage(message, type) {
            const alertDiv = $('#message-notification');
            
            alertDiv.removeClass('alert-success alert-danger').addClass('alert-' + type);
            
            alertDiv.find('strong').text(type === 'success' ? 'Thành công!' : 'Lỗi!');
            
            alertDiv.find('.message-content').text(message);
            
            alertDiv.show();
                
            setTimeout(() => {
                alertDiv.hide();
            }, 8000);
        }
    });

    function resetForm() {
        $('#customerName').val('');
        $('#customerEmail').val('');
        $('#customerPhone').val('');
        $('#emailFeedback').text(''); 
        $('#phoneFeedback').text(''); 
    }

    function update() {
        $.get("index.php?page=page_sell", function(data) {
            $("body").html(data);
        
        });
    }

    $('#discountCode').on('change', function() {
        var couponID = $(this).val(); 
        if (couponID) {
            $.ajax({
                url: '?page=processing_coupon',  
                type: 'GET',
                data: { couponID: couponID },  // Gửi CouponID qua GET
                success: function(response) {
                    // Kiểm tra nếu server trả về dữ liệu hợp lệ
                    console.log(response);

                    if (response.success) {
                        var couponDiscount = response.couponDiscount;  // Nhận CouponDiscount từ phản hồi
                        var couponCode = response.couponCode;  // Nhận CouponCode từ phản hồi
                        
                        // Hiển thị thông tin lên giao diện
                        $('#reduction').val('Giảm giá: ' + couponDiscount + '%');
                        updateGrandTotal();

                    } else {
                        $('#reduction').val('Giảm giá: ' + 0 + '%');
                            updateGrandTotal();

                        alert('Không tìm thấy mã khuyến mãi');
                    }
                },
                error: function(error) {
                    alert('Đã xảy ra lỗi: ' + error.statusText);
                }
            });
        } else {
            // Nếu không có mã nào được chọn
            $('#couponDiscount').text('');
            $('#couponCode').text('');
        }
    });
    function convertToNumber(priceString) {
        if (typeof priceString !== 'string') {
            priceString = String(priceString); 
        }
        
        priceString = priceString.replace(/[^0-9]/g, '');

        return parseFloat(priceString);
    }
    function extractDiscount(value) {
        const match = value.match(/(\d+(\.\d+)?)/); // Tìm giá trị số (cả số nguyên và số thập phân)
        return match ? match[0] : '0'; // Nếu tìm thấy giá trị, trả về giá trị đó, nếu không trả về '0'
    }

       
    </script>
    

    <script>
        const $invoiceListBody = $('#invoice-list-body');
        const $totalAmountDisplay = $('#total-amount');
        function cleanPrice(value) {
            return value.replace(/[^0-9.]/g, ''); // Loại bỏ mọi ký tự không phải là số hoặc dấu chấm
        }
        function replaceWhitespace(value) {
            return value.trim().replace(/\s+/g, ' '); // Loại bỏ khoảng trắng dư thừa và thay thế chúng bằng một khoảng trắng đơn
        }

        

        function extractDiscount(value) {
            const match = value.match(/(\d+(\.\d+)?)/); // Tìm giá trị số (cả số nguyên và số thập phân)
            return match ? match[0] : '0'; // Nếu tìm thấy giá trị, trả về giá trị đó, nếu không trả về '0'
        }

        // gửi data để lưu session


     $(document).ready(function() {
            $('#bank').change(function() {
                if ($(this).is(':checked')) {
                    $(".modal-footer").hide();
                    // Điều hướng đến trang thanh toán
                    // window.location.href = 'payment/index.php'; // Đường dẫn đến file PHP
                    var orderType = $(this).val();
                    let totalAmount = $("#total-amount").text().replace(/,/g, '');
                    let phone = replaceWhitespace($('#name-search').val());
                    let customerName = replaceWhitespace($('#customerNameSell').val());
                    let customerPhone = $('#name-search').val();
                    let email = $("#customerEmailSell").val();
                    <?php
                        $orderID = $orderController->createOrderID();
                    ?>
                    // Tự động điền thông tin dựa trên loại hàng hóa
                        $('#order_id').val('<?php echo $orderID; ?>');
                        $('#amount').val(totalAmount); // Giá trị ví dụ
                        $('#order_desc').val('Thanh toán hóa đơn');
                        $('#txt_billing_fullname').val(customerName);
                        $('#txt_billing_email').val(email);
                        $('#txt_billing_mobile').val(customerPhone);
                   
                   
                } else {
                    $('#bankDetails').hide(); 
                    $('#order_id').val('');
                    $('#amount').val('');
                    $('#order_desc').val('');
                    $('#txt_billing_fullname').val('');
                    $('#txt_billing_email').val('');
                    $('#txt_billing_mobile').val('');
                }
            });
            $("#cash").change(function() {
                $(".modal-footer").show();
            });

            function updatePaymentInfo() {
                let totalAmount = $("#total-amount").text().replace(/,/g, ''); // Lấy giá trị từ thẻ <span>
                $('#amount').val(totalAmount); // Cập nhật giá trị trong form thanh toán

                // Bạn có thể thêm các xử lý khác ở đây nếu cần
            }

           
            $("#btnPaymentModal").click(function() {
               
                updatePaymentInfo(); 
            });

        });
        
        function collectOrderData() {
            let phone = replaceWhitespace($('#name-search').val());
            let customerName = replaceWhitespace($('#customerNameSell').val());
            let discountCode = replaceWhitespace($('#discountCode').val());
            let reduction = replaceWhitespace($('#reduction').val());
            let employeeIdByRole = $('#employeeIdByRole').val();
            // Làm sạch dữ liệu
            reduction = extractDiscount(reduction);  // Chỉ lấy phần trăm giảm giá

            let orderData = {
                employeeId : employeeIdByRole,
                phone: phone,
                customerName: customerName,
                couponID: discountCode,
                reduction: reduction,  // Sử dụng giá trị phần trăm giảm giá đã làm sạch
                items: [],
                paymentMethod: $('input[name="paymentMethod"]:checked').val(),
                totalAmount: cleanPrice($totalAmountDisplay.text()), // Làm sạch tổng tiền
            };

            $invoiceListBody.find('tr').each(function() {
                // Lấy thêm productID từ thuộc tính data-id
                const productID = replaceWhitespace($(this).data('id')); 
                const productName = replaceWhitespace($(this).data('name')); 
                const productStock = $(this).data('stock'); 
                const productPrice = cleanPrice(replaceWhitespace($(this).find('td').eq(1).text())); // Làm sạch giá sản phẩm
                const quantity = replaceWhitespace($(this).find('.quantity-display').val());
                const totalPrice = cleanPrice(replaceWhitespace($(this).find('.total-price').text())); // Làm sạch tổng giá trị sản phẩm

                orderData.items.push({
                    id: productID,
                    name: productName,
                    stock: productStock,
                    price: productPrice,
                    quantity: quantity,
                    total: totalPrice
                });
            });

            if (orderData.paymentMethod === 'Chuyển khoản') {
                orderData.cashAmount = cleanPrice($('#cashAmount').val()); // Làm sạch tiền mặt
                orderData.amountReturn = cleanPrice($('#amountReturn').val()); // Làm sạch tiền thừa
            } else {
                orderData.accountInfo = $('#accountInfo').val();
            }

            return orderData;
    }

    

    // gửi data để lưu session
    function sendOrderData() {
        const orderData = collectOrderData();
        const isCash = $('#cash').is(':checked');
        const cashAmount = $('#cashAmount');
        const amountReturn = $('#amountReturn');
        const totalAmount = $("#total-amount"); 


        console.log("orderData : ", orderData);
        
        $.ajax({
            type: 'POST',
            url: 'index.php?page=processing_order',  // URL để xử lý lưu trữ đơn hàng
            data: JSON.stringify(orderData),
            contentType: 'application/json',
            success: function(response, status, xhr) {
                if (xhr.status === 200) {
                    showAlert('success', 'Đơn hàng đã được lưu thành công! <br> Tiền thối lại: ' + amountReturn.val() + ' VNĐ.');
    
                    // Gọi deleteSession và chờ nó hoàn tất
                    deleteSession()
                        .done(function() {
                            // Reset các trường nhập liệu
                           
                            $('#paymentModal').modal('hide');

                            updateUIForNoData();
                        })
                        .fail(function() {
                            console.log('Có lỗi xảy ra khi xóa session.');
                            $('#paymentModal').modal('hide'); // Đảm bảo modal đóng ngay cả khi xóa session lỗi
                        });
                } else {
                    showAlert('error', 'Có lỗi xảy ra khi lưu đơn hàng.');
                }
    
                setTimeout(function() {
                    $('.modal-backdrop').remove();
                }, 3000);
            },
            error: function(error) {
                console.error("Error: " + error);
                showAlert('error', 'Có lỗi xảy ra khi kết nối với server.');
            }
        });
    }
    <?php
        if (isset($_GET['vnp_ResponseCode']) && $_GET['vnp_ResponseCode'] == '00') {
            echo "
                    window.onload = function() {
                        sendOrderData();
                        const newUrl = 'index.php?page=page_sell';
                        window.history.replaceState(null, null, newUrl);
                    }
            ";
        } 
    ?>


    // Thông báo khi có lỗi hoặc thành công
    function showAlert(type, message) {
        const alertTypes = {
            'error': 'alert-error',
            'warning': 'alert-warning',
            'success': 'alert-success'
        };
    
        const $alert = $(` 
            <div class="alert ${alertTypes[type]}" id="alert" role="alert">
                <i class="fas fa-${type === 'error' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : 'check-circle'}"></i>
                <span>${message}</span>
                <span class="close" data-dismiss="alert" aria-label="Close">&times;</span>
            </div>
        `);
    
        $('body').append($alert);
    
        setTimeout(function() {
            hideAlert();
        }, 3000);
    }

    function hideAlert() {
        $('#alert').remove();
    }

    // Hàm xóa session sau khi đơn hàng đã lưu thành công
    function deleteSession() {
        return $.ajax({
            url: 'index.php?page=save_invoice',
            method: 'POST',
            data: {
                action: 'delete_invoice'
            }
        }).done(function(response) {
            if (response.status === 'success') {
                console.log('Hóa đơn đã được xóa thành công');
            } else {
                console.log('Lỗi: ' + response.message);
            }
        }).fail(function(xhr, status, error) {
            console.error('Có lỗi xảy ra khi gửi yêu cầu AJAX:', error);
        });
    }
    function updateUIForNoData() {
        const cashAmount = $('#cashAmount'); 
        const amountReturn = $('#amountReturn'); 
        const totalAmount = $("#total-amount"); 
        cashAmount.val("");
        amountReturn.val("");
        totalAmount.text("0.000");
        $invoiceListBody.empty(); // Xóa nội dung bảng
        $totalAmountDiscount.text("");
    }

        
    </script>
    <!-- Bootstrap core JavaScript-->
    <?php 
        include_once('./common/script/default.php')
    ?>

    
    <script src="./assets/js/sell.js"></script> <!-- Đảm bảo file JS đã được tải -->
   
</body>

</html>
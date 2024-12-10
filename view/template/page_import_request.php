<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Đầu trang -->
    <?php
        include_once('./common/head/head.php');    
       
    ?>
    <link rel="stylesheet" href="./assets/css/employee_shift.css">
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
</head>
<?php
    include_once('./connect/database.php'); // Đường dẫn vào file kết nối database

     // Tạo một ấđối tượng Database để kết nối
    $database = new Database();
    $conn = $database->connect(); // Ly kết nối

?>
<body>
    <div id="wrapper">
        <!-- Thanh điều hướng dọc -->
        <?php include_once('./common/menu/siderbar.php'); ?>

        <!-- Giao giện trang -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Thanh điều hướng ngang -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
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
                                    Thông tin cá nhân
                                </a>
                                
                                <a class="dropdown-item" href="index.php?page=logout" >
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Đăng xuất
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <!--  Nội dung trang  -->
                <?php
// Bắt đầu phiên làm việc
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['id'])) {
    // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập hoặc thông báo lỗi
    header("Location: login.php");
    exit();
}

// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_ql3scoffee";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Biến lưu thông báo
$message = '';

// Kiểm tra nếu form được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $productID = $_POST['product'];  // ProductID
    $quantity = $_POST['quantity'];
    $supplierID = $_POST['supplier'];  // SupplierID
    $note = $_POST['note'];  // Lấy ghi chú từ form

    // Tạo RequestID tự động
    $requestID = 'RQ' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);  // Ví dụ: RQ0001

    // Lấy ID nhân viên từ session
    $employeeID = $_SESSION['id'];

    // Thêm yêu cầu vào bảng requestform
    $sql = "INSERT INTO requestform (RequestID, RequestQuantity, Status, CreateDate, EmployeeID, ProductID, Note)
            VALUES (?, ?, 0, NOW(), ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siiss", $requestID, $quantity, $employeeID, $productID, $note);  // Dùng bind_param để truyền tham số vào câu lệnh SQL

    if ($stmt->execute()) {
        $message = "Gửi yêu cầu thành công!";
    } else {
        $message = "Có lỗi xảy ra khi gửi yêu cầu: " . $stmt->error;
    }

    $stmt->close();
}

// Lấy danh sách sản phẩm từ bảng 'product'
$sql_product = "SELECT ProductID, ProductName FROM product";
$result_product = $conn->query($sql_product);

if ($result_product === false) {
    die("Error fetching products: " . $conn->error);
}

// Lấy danh sách nhà cung cấp từ bảng 'supplier'
$sql_supplier = "SELECT SupplierID, CompanyName FROM supplier";
$result_supplier = $conn->query($sql_supplier);

if ($result_supplier === false) {
    die("Error fetching suppliers: " . $conn->error);
}

?>

<div class="container mt-5">
    <h3 class="text-center">Gửi yêu cầu nhập hàng</h3>

    <?php if ($message): ?>
        <div class="alert alert-info">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST" id="myFormRequest">
        <!-- Chọn tên sản phẩm -->
        <div class="form-group">
            <label for="product">Tên sản phẩm</label>
            <select class="form-control" id="product" name="product" >
                <option value="">Chọn sản phẩm</option>
                <?php
                if ($result_product->num_rows > 0) {
                    while ($row = $result_product->fetch_assoc()) {
                        echo "<option value='" . $row['ProductID'] . "'>" . $row['ProductName'] . "</option>";
                    }
                } else {
                    echo "<option value=''>Không có sản phẩm nào</option>";
                }
                ?>

            </select>
            <small class="text-danger error-message" style="display: none;">Vui lòng chọn sản phẩm</small>
        </div>

        <!-- Số lượng -->
        <div class="form-group">
            <label for="quantity">Số lượng</label>
            <input type="number" class="form-control" id="quantity" name="quantity" >
            <small class="text-danger error-message" style="display: none;">Vui lòng nhập số lượng</small>
        </div>

        <!-- Chọn nhà cung cấp -->
        <div class="form-group">
            <label for="supplier">Nhà cung cấp</label>
            <select class="form-control" id="supplier" name="supplier">
                <option value="">Chọn nhà cung cấp</option>
                <?php
                if ($result_supplier->num_rows > 0) {
                    while ($row = $result_supplier->fetch_assoc()) {
                        echo "<option value='" . $row['SupplierID'] . "'>" . $row['CompanyName'] . "</option>";
                    }
                } else {
                    echo "<option value=''>Không có nhà cung cấp nào</option>";
                }
                ?>
            </select>
            <small class="text-danger error-message" style="display: none;">Vui lòng chọn nhà cung cấp</small>
        </div>

        <!-- Ghi chú -->
        <div class="form-group">
            <label for="note">Ghi chú</label>
            <textarea class="form-control" id="note" name="note" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Gửi yêu cầu</button>
    </form>
</div>

<?php
// Đóng kết nối sau khi đã thực hiện xong các truy vấn
$conn->close();
?>


    <script>
        // Hàm mở modal xác nhận xóa
        function confirmBrowse(RequestID) {
            // Hiển thị modal
            $('#confirmBrowseModal').modal('show');
            

        }
        function confirmDelete(RequestID) {
            // Hiển thị modal
            $('#confirmDeleteModal').modal('show');
            

        }
       

        $(document).ready(function () {
        $('#myFormRequest').on('submit', function (e) {
            let isValid = true;

            const product = $('#product');
            const productError = product.next('.error-message'); // Thẻ <small> hiển thị lỗi
            if (product.val() === "") {
                isValid = false;
                productError.show(); // Hiển thị thông báo lỗi
            } else {
                productError.hide(); // Ẩn thông báo lỗi nếu hợp lệ
            }

            // Kiểm tra trường "quantity"
            const quantity = $('#quantity');
            const quantityError = quantity.next('.error-message'); // Thẻ <small> hiển thị lỗi
            if (quantity.val() === "" || quantity.val() <= 0) {
                isValid = false;
                quantityError.show(); // Hiển thị thông báo lỗi
            } else {
                quantityError.hide(); 
            }

            const supplier = $('#supplier');
            const supplierError = supplier.next('.error-message'); // Thẻ <small> hiển thị lỗi
            if (supplier.val() === "") {
                isValid = false;
                supplierError.show(); 
            } else {
                supplierError.hide();
            }

            if (!isValid) {
                e.preventDefault();
            }
        });

        // Ẩn lỗi khi người dùng sửa lại giá trị
        $('#product, #quantity, #supplier').on('change', function () {
            $(this).next('.error-message').hide();
        });
    });
    </script>
    <!-- Bootstrap core JavaScript-->
    <?php include_once('./common/script/default.php'); ?>
</body>
</html>

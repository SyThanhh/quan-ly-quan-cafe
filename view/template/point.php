<?php 
// Start session to check if the user is logged in
// session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// Include the header navigation
include_once('./common/header/navbar.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once('./common/head/head-website.php'); ?>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .promo-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .promo-card {
            border: 1px solid #ddd;
            padding: 20px;
            width: 300px;
            height: 500px;
            text-align: center;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
        }

        .promo-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .promo-info {
            margin-top: 10px;
        }

        .page-header {
            text-align: center;
            padding: 60px 0;
            background-color: #333;
            color: white;
            margin-bottom: 30px;
        }

        .footer {
            text-align: center;
            background-color: #333;
            padding: 50px 0;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #555542;
            color: white;
            font-weight: bold;
        }
        
    </style>
</head>

<body>
    <!-- Navbar -->
 

    <!-- Page Header -->
    <div class="container-fluid page-header mb-5 position-relative overlay-bottom">
        <div class="d-flex flex-column align-items-center justify-content-center pt-0 pt-lg-5" style="min-height: 260px">
            <h1 class="display-4 mb-3 mt-0 mt-lg-5 text-white text-uppercase">ĐIỂM TÍCH LŨY</h1>
        </div>
    </div>
    <?php include_once('./common/header/navbar.php'); ?>
    <?php
    
// Kết nối cơ sở dữ liệu
$servername = "localhost"; // Máy chủ CSDL
$username = "root";        // Tên người dùng CSDL
$password = "";        // Mật khẩu CSDL
$dbname = "db_ql3scoffee"; // Tên cơ sở dữ liệu

// Tạo kết nối
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Lấy ID của người dùng đã đăng nhập
$customerID = $_SESSION['id']; 

// Truy vấn SQL để lấy điểm cho người dùng đã đăng nhập
$sql = "SELECT c.CustomerID, c.CustomerName, c.CustomerPhone,  c.CustomerPoint
        FROM customer c 
        JOIN `order` o ON c.CustomerID = o.CustomerID 
        WHERE c.CustomerID = ?";  //Chỉ lấy các điểm của người dùng đã đăng nhập

// Chuẩn bị và thực hiện truy vấn SQL
if ($stmt = mysqli_prepare($conn, $sql)) {
    //Liên kết ID khách hàng của người dùng đã đăng nhập với truy vấn SQL
    mysqli_stmt_bind_param($stmt, "i", $customerID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Kiểm tra kết quả
    if (mysqli_num_rows($result) > 0) {
        echo '<table class="table table-bordered mt-3">
                <thead class="table-header">
                    <tr>
                        <th>Mã khách hàng</th>
                        <th>Tên khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Điểm khách hàng</th>
                    </tr>
                </thead>
                <tbody>';

        //Lấy và hiển thị từng hàng
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>
                    <td>' . $row['CustomerID'] . '</td>
                    <td>' . $row['CustomerName'] . '</td>
                    <td>' . $row['CustomerPhone'] . '</td>
                    <td>' . $row['CustomerPoint'] . '</td>
                </tr>';
        }
        echo '</tbody></table>';
    } else {
        echo "No transaction records found.";
    }

    // Đóng câu lệnh đã chuẩn bị
    mysqli_stmt_close($stmt);
} else {
    echo "Error preparing query: " . mysqli_error($conn);
}

// đóng kết nối
mysqli_close($conn);
    ?>

    <!-- Footer Start -->
    <div class="container-fluid footer text-white mt-5 pt-5 px-0 position-relative overlay-top">
        <div class="row mx-0 pt-5 px-sm-3 px-lg-5 mt-4">
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-white text-uppercase mb-4" style="letter-spacing: 3px;">LIÊN HỆ</h4>
                <p><i class="fa fa-map-marker-alt mr-2"></i>Nguyễn Văn Bảo, P4, Gò Vấp, TP.HCM</p>
                <p><i class="fa fa-phone-alt mr-2"></i>+012 345 67890</p>
                <p class="m-0"><i class="fa fa-envelope mr-2"></i>info@example.com</p>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-white text-uppercase mb-4" style="letter-spacing: 3px;">Theo dõi chúng tôi</h4>
                <p>Cùng khám phá những dịch vụ mới và nhận được những ưu đãi hấp dẫn.</p>
                <div class="d-flex justify-content-start">
                    <a class="btn btn-lg btn-outline-light btn-lg-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-lg btn-outline-light btn-lg-square mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-lg btn-outline-light btn-lg-square mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-lg btn-outline-light btn-lg-square" href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-white text-uppercase mb-4" style="letter-spacing: 3px;">Giờ mở cửa</h4>
                <div>
                    <h6 class="text-white text-uppercase">Thứ 2  - Thứ 6</h6>
                    <p>8.00H - 20H</p>
                    <h6 class="text-white text-uppercase">Thứ 7 - Chủ nhật</h6>
                    <p>8.00H - 22.00H</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-white text-uppercase mb-4" style="letter-spacing: 3px;">Bản tin</h4>
                <p>Đăng ký nhận những ưu đãi hấp dẫn</p>
                <div class="w-100">
                    <div class="input-group">
                        <input type="text" class="form-control border-light" style="padding: 25px;" placeholder="Your Email">
                        <div class="input-group-append">
                            <button class="btn btn-primary font-weight-bold px-3">Đăng ký</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>
    <?php include_once('./common/script/default-template.php')?>

</body>

</html>

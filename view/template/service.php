<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once('./common/head/head-website.php'); ?>
    <style>
        /* CSS updated to center content */

        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Main content grid */
        .promo-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            /* Căn giữa các promo-card theo chiều ngang */
            align-items: center;
            /* Căn giữa các promo-card theo chiều dọc */
            margin-top: 20px;
            /* Khoảng cách giữa header và promo cards */
        }

        /* Promo card style */
        .promo-card {
            border: 1px solid #ddd;
            padding: 20px;
            width: 300px;
            text-align: center;
            /* Căn giữa nội dung trong mỗi promo card */
            box-sizing: border-box;
        }

        /* Image inside promo card */
        .promo-card img {
            width: 100%;
            height: auto;
            object-fit: cover;
            /* Giúp ảnh không bị méo */
        }

        /* Text content inside promo card */
        .promo-info {
            margin-top: 10px;
        }

        /* Page Header */
        .page-header {
            text-align: center;
            padding: 60px 0;
            background-color: #333;
            color: white;
            margin-bottom: 30px;
        }

        /* Footer */
        .footer {
            text-align: center;
            background-color: #333;
            padding: 50px 0;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <?php include_once('./common/header/navbar.php'); ?>
    <?php
    // Kết nối với cơ sở dữ liệu
    $servername = "localhost"; // Hoặc IP của máy chủ MySQL
    $username = "root";        // Tên người dùng MySQL
    $password = "";            // Mật khẩu MySQL
    $dbname = "code_data_ql3scoffee"; // Tên cơ sở dữ liệu

    // Tạo kết nối
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Kiểm tra kết nối
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    ?>

    <!-- Page Header -->
    <div class="container-fluid page-header mb-5 position-relative overlay-bottom">
        <div class="d-flex flex-column align-items-center justify-content-center pt-0 pt-lg-5" style="min-height: 400px">
            <h1 class="display-4 mb-3 mt-0 mt-lg-5 text-white text-uppercase">Khuyến mãi</h1>
            <div class="d-inline-flex mb-lg-5">
                <p class="m-0 text-white"><a class="text-white" href="">Trang chủ</a></p>
                <p class="m-0 text-white px-2">/</p>
                <p class="m-0 text-white">Khuyến mãi</p>
            </div>
        </div>
    </div>

    <!-- Promo Cards Grid -->
    <div class="promo-grid">
        <?php
        // Query to fetch all coupon data, including image field
        $sql = "SELECT CouponID, CouponCode, StartDate, EndDate, Description, CouponDiscount, Status, UpdateAt, image FROM coupon";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
        
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="promo-card">';
                // Display image if exists
                if (!empty($row["image"])) {
                    $imagePath = htmlspecialchars($row["image"]);
                    echo '<img src="http://localhost/quanlycf/quan-ly-quan-cafe/view/template/' . $imagePath . '" alt="Promo Image">';
                }
                 else {
                    echo '<img src="template/' . htmlspecialchars($row["image"]) . '" alt="Promo Image">'; // Thêm "template/" vào đường dẫn
                    // echo '<img src="template/path/to/default-image.jpg" alt="Default Promo Image">'; // Đường dẫn cho hình ảnh mặc định
                }
                echo '<div class="promo-info">';
                echo '<h3>' . htmlspecialchars($row["Description"]) . '</h3>';
                echo '<p><strong>Coupon Code:</strong> ' . htmlspecialchars($row["CouponCode"]) . '</p>';
                echo '<p><strong>Discount:</strong> ' . htmlspecialchars($row["CouponDiscount"]) . '%</p>';
                // echo '<p><strong>Start Date:</strong> ' . htmlspecialchars($row["StartDate"]) . '</p>';
                // echo '<p><strong>End Date:</strong> ' . htmlspecialchars($row["EndDate"]) . '</p>';
                echo '<p><strong>Status:</strong> ' . ($row["Status"] ? 'Active' : 'Inactive') . '</p>';
                // echo '<p><strong>Last Updated:</strong> ' . htmlspecialchars($row["UpdateAt"]) . '</p>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "<p>No promotions available.</p>";
        }
        ?>
    </div>


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
    <!-- Footer End -->



    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <?php include_once('./common/script/default-template.php')?>

</body>

</html>
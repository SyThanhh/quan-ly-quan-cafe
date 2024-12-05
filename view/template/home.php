<!DOCTYPE html>
<html lang="en">

<head>
<?php  include_once('./common/head/head-website.php')    ?>
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
            justify-content: center; /* Căn giữa các promo-card theo chiều ngang */
            align-items: center; /* Căn giữa các promo-card theo chiều dọc */
            margin-top: 20px; /* Khoảng cách giữa header và promo cards */
        }

        /* Promo card style */
        .promo-card {
            border: 1px solid #ddd;
            padding: 20px;
            width: 300px;
            height: 500px;
            text-align: center; /* Căn giữa nội dung trong mỗi promo card */
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
        }

        /* Image inside promo card */
        .promo-card img {
            width: 100%;
            height: 200px; /* Chiều cao cố định cho hình ảnh để đảm bảo kích cỡ đồng đều */
            object-fit: cover; /* Giúp ảnh không bị méo */
            border-radius: 8px; /* Thêm bo góc cho ảnh nếu cần */
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
    <!-- Navbar Start -->
    <?php  include_once('./common/header/navbar.php')    ?>
    <?php
    // Kết nối với cơ sở dữ liệu
    $servername = "localhost"; // Hoặc IP của máy chủ MySQL
    $username = "root";        // Tên người dùng MySQL
    $password = "";            // Mật khẩu MySQL
    $dbname = "db_ql3scoffee"; // Tên cơ sở dữ liệu

    // Tạo kết nối
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Kiểm tra kết nối
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    ?>
    <!-- Navbar End -->

    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5">
        <div id="blog-carousel" class="carousel slide overlay-bottom" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img style="width: 100%; max-height: 60vh; object-fit: cover;" src="./assets/img/carousel-1.jpg" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        
                        <h1 class="display-1 text-white m-0">COFFEE</h1>
                        <h2 class="text-white m-0">* SINCE 1999 *</h2>
                    </div>
                </div>
                
            </div>
            <a class="carousel-control-prev" href="#blog-carousel" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#blog-carousel" data-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="section-title">
                <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;">Về chúng tôi</h4>
                <h1 class="display-4">Phục vụ từ năm </h1>
            </div>
            <div class="row">
                <div class="col-lg-4 py-0 py-lg-5">
                    <h1 class="mb-3">Câu chuyện</h1>
                    <h5 class="mb-3">"Chúng tôi luôn đặt chất lượng và sự hài lòng của khách hàng lên hàng đầu, mang đến trải nghiệm cà phê tinh tế và đáng nhớ."</h5>
                    <p>Cà phê không chỉ là một thức uống – đó là trải nghiệm, là niềm đam mê và là sự kết nối giữa con người. Từ những ngày đầu tiên, chúng tôi đã cam kết mang đến những ly cà phê chất lượng, từ hạt cà phê chọn lọc, rang xay cẩn thận đến từng công đoạn pha chế. Đối với chúng tôi, mỗi ly cà phê là một hành trình, chứa đựng tình yêu và sự tận tâm.</p>
                    <a href="" class="btn btn-secondary font-weight-bold py-2 px-4 mt-2">Tìm hiểu thêm</a>
                </div>
                <div class="col-lg-4 py-5 py-lg-0" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-100" src="./assets/img/about.png" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-4 py-0 py-lg-5">
                    <h1 class="mb-3">Tầm nhìn</h1>
                    <p>Chúng tôi luôn hướng đến việc xây dựng một cộng đồng yêu cà phê, nơi mọi người có thể tận hưởng không gian thoải mái và thưởng thức những ly cà phê đậm đà, thơm ngon. Tầm nhìn của chúng tôi là trở thành thương hiệu cà phê được yêu thích, không chỉ bởi chất lượng sản phẩm mà còn vì sự gắn kết, sẻ chia mà chúng tôi mang đến cho khách hàng.</p>
                    <h5 class="mb-3"><i class="fa fa-check text-primary mr-3"></i>Chất lượng đặt lên hàng đầu</h5>
                    <h5 class="mb-3"><i class="fa fa-check text-primary mr-3"></i>Không gian thư giãn và thoải mái</h5>
                    <h5 class="mb-3"><i class="fa fa-check text-primary mr-3"></i>Dịch vụ tận tình, chu đáo</h5>
                    <a href="" class="btn btn-primary font-weight-bold py-2 px-4 mt-2">Tìm hiểu thêm </a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Service Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <div class="section-title">
                <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;">Dịch Vụ Của Chúng Tôi</h4>
                <h1 class="display-4">Hạt Cà Phê Tươi & Hữu Cơ</h1>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-5">
                    <div class="row align-items-center">
                        <div class="col-sm-5">
                            <img class="img-fluid mb-3 mb-sm-0" src="./assets/img/service-1.jpg" alt="">
                        </div>
                        <div class="col-sm-7">
                            <h4><i class="fa fa-chair service-icon"></i>Không Gian Thoải Mái</h4>
                            <p class="m-0">Chúng tôi cung cấp một không gian ấm cúng và thoải mái, lý tưởng cho những buổi trò chuyện cùng bạn bè hoặc giây phút thư giãn một mình với ly cà phê yêu thích.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-5">
                    <div class="row align-items-center">
                        <div class="col-sm-5">
                            <img class="img-fluid mb-3 mb-sm-0" src="./assets/img/service-2.jpg" alt="">
                        </div>
                        <div class="col-sm-7">
                            <h4><i class="fa fa-coffee service-icon"></i>Hạt Cà Phê Tươi</h4>
                            <p class="m-0">Hạt cà phê của chúng tôi được tuyển chọn từ những nông trại chất lượng, đảm bảo mang đến hương vị cà phê đậm đà và tươi mới nhất.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-5">
                    <div class="row align-items-center">
                        <div class="col-sm-5">
                            <img class="img-fluid mb-3 mb-sm-0" src="./assets/img/service-3.jpg" alt="">
                        </div>
                        <div class="col-sm-7">
                            <h4><i class="fa fa-award service-icon"></i>Cà Phê Chất Lượng Tốt Nhất</h4>
                            <p class="m-0">Chúng tôi cam kết mang đến những ly cà phê chất lượng cao nhất, được pha chế cẩn thận từ hạt cà phê rang mới mỗi ngày.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-5">
                    <div class="row align-items-center">
                        <div class="col-sm-5">
                            <img class="img-fluid mb-3 mb-sm-0" src="./assets/img/service-4.jpg" alt="">
                        </div>
                        <div class="col-sm-7">
                            <h4><i class="fa fa-handshake service-icon"></i>Phục Vụ Tận Tâm</h4>
                            <p class="m-0">Đội ngũ nhân viên của chúng tôi luôn nhiệt tình, thân thiện, và sẵn sàng phục vụ để mang đến cho bạn trải nghiệm tuyệt vời nhất.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->


    <!-- Offer Start -->
    <div class="offer container-fluid my-5 py-5 text-center position-relative overlay-top overlay-bottom">
        <div class="container py-5">
            <h1 class="display-3 text-primary mt-3">Giảm giá 30%</h1>
            <h1 class="text-white mb-3">Ưu đãi đặc biệt ngày chủ nhật</h1>
            <h4 class="text-white font-weight-normal mb-4 pb-3">Chỉ dành cho Chủa nhật từ ngày 1 tháng 12 đến ngày 30 tháng 12 năm 2024</h4>
            <form class="form-inline justify-content-center mb-4">
                <div class="input-group">
                    <input type="text" class="form-control p-4" placeholder="Your Email" style="height: 60px;">
                    <div class="input-group-append">
                        <button class="btn btn-primary font-weight-bold px-4" type="submit">Đăng ký</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Offer End -->


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
                    echo '<img src="assets/img/coupon/' . $imagePath . '" alt="Promo Image">';
                }
                 else {
                    echo '<img src="template/' . htmlspecialchars($row["image"]) . '" alt="Promo Image">'; // Thêm "template/" vào đường dẫn
                    // echo '<img src="template/path/to/default-image.jpg" alt="Default Promo Image">'; // Đường dẫn cho hình ảnh mặc định
                }
                echo '<div class="promo-info">';
                echo '<h3>' . htmlspecialchars($row["Description"]) . '</h3>';
                echo '<p><strong>Mã giảm giá:</strong> ' . htmlspecialchars($row["CouponCode"]) . '</p>';
                echo '<p><strong>Giảm giá:</strong> ' . htmlspecialchars($row["CouponDiscount"]) . '%</p>';
                // echo '<p><strong>Start Date:</strong> ' . htmlspecialchars($row["StartDate"]) . '</p>';
                // echo '<p><strong>End Date:</strong> ' . htmlspecialchars($row["EndDate"]) . '</p>';
                echo '<p><strong>Trạng thái:</strong> ' . ($row["Status"] ? 'Đang hoạt động' : 'Không hoạt động') . '</p>';
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
<!DOCTYPE html>
<html lang="en">

<head>
    <?php  include_once('./common/head/head-website.php')    ?>
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .containerfull,
        .row {
            float: left;
            width: 100%;
        }
        .container {
            width: 1200px;
            margin: 0 auto;
        }
        .box25 {
            float: left;
            width: 25%;
            width: calc(25% - 30px);
            position: relative;
        }
        .box25 img {
            width: 100%;
            border-radius: 10px;
            box-shadow: 0px 0px 10px #999999;
        }
        .mr15 {
            margin-right: 30px;
        }
        
        button {
            color: #993300;
            font-size: 13pt;
            font-weight: bold;
            width: 100%;
            border: 1px #993300 dotted;
            border-radius: 5px;
            padding: 10px 0px;
            background-color: #FFFFFF;
        }
        h1 {
            text-align: center;
            font-size: 24pt;
            margin: 0px;
        }
        .price {
            text-align: center;
            color: #993300;
            font-size: 12pt;
            float: left;
            width: 100%;
            padding: 8px 0px;
        }
        a {
            color: #993300;
            font-size: 13pt;
            font-weight: bold;
            text-decoration: none;
        }

        a:hover {
            color: #000000;
        }
        .boxleft {
            float: left;
            width: 20%;
        }
        .boxright {
            float: left;
            width: 78%;
        }
        .mb {
            margin-bottom: 50px;
        }
        .menutrai a {
            display: block;
            width: 100%;
            color: #993300;
            font-size: 13pt;
            font-weight: bold;
            text-decoration: none;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px #CCC dotted;
        }
        .menutrai a:hover {
            color: #000000;
        }
        .menu{
            height: 40px;
            line-height: 40px;
        }
        .menu a{
            margin: 0 20px;
        }

    </style>
</head>

<body>
    <!-- Navbar Start -->
    <?php  include_once('./common/header/navbar.php')    ?>
    
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 position-relative overlay-bottom">
        <div class="d-flex flex-column align-items-center justify-content-center pt-0 pt-lg-5" style="min-height: 400px">
            <h1 class="display-4 mb-3 mt-0 mt-lg-5 text-white text-uppercase">Menu</h1>
            <div class="d-inline-flex mb-lg-5">
                <p class="m-0 text-white"><a class="text-white" href="">Trang chủ</a></p>
                <p class="m-0 text-white px-2">/</p>
                <p class="m-0 text-white">Menu</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


   <!-- Menu Start -->
    <div class="container-fluid pt-5">
    <section class="containerfull">
        <div class="container">
            <div class="boxleft mr2pt menutrai">
                <h1>DANH MỤC</h1><br><br>
                <a href="#">Cà phê</a>
             
                <a href="#">Trà</a>
            </div>
            <div class="boxright">
                <h1>SẢN PHẨM</h1><br>
                <div class="containerfull mr30">
                    <div class="box25 mr15 mb">
                        <div class="best"></div>
                        <img src="/assets/img/sp1.webp" alt="">
                        <span class="price">15.000Vnd</span>
                        <button>Chi tiết</button>
                    </div>
                    <div class="box25 mr15 mb">
                    <img src="/assets/img/sp2.webp" alt="">
                        <span class="price">29.000Vnd</span>
                        <button>Chi tiết</button>
                    </div>
                    <div class="box25 mr15 mb">
                    <img src="/assets/img/menu-1.jpg" alt="">
                        <span class="price">25.000Vnd</span>
                        <button>Chi tiết</button>
                    </div>
                    <div class="box25 mr15 mb">
                    <img src="/assets/img/sp3.webp" alt="">
                        <span class="price">25.000Vnd</span>
                        <button>Chi tiết</button>
                    </div>
                    <div class="box25 mr15 mb">
                    <img src="/assets/img/sp5.jpg" alt="">
                        <span class="price">19.000Vnd</span>
                        <button>Chi tiết</button>
                    </div>
                    <div class="box25 mr15 mb">
                    <img src="/assets/img/sp7.webp" alt="">
                        <span class="price">29.000Vnd</span>
                        <button>Chi tiết</button>
                    </div>
                    <div class="box25 mr15 mb">
                    <img src="/assets/img/menu-2.jpg" alt="">
                        <span class="price">39.000Vnd</span>
                        <button>Chi tiết</button>
                    </div>
                    <div class="box25 mr15 mb">
                    <img src="/assets/img/menu-3.jpg" alt="">
                        <span class="price">39.000Vnd</span>
                        <button>Chi tiết</button>
                    </div>
                </div>
            </div>


        </div>
    </section>

    </div>
    <!-- Menu End -->





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
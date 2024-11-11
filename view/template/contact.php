<!DOCTYPE html>
<html lang="en">

<head>
    <?php  include_once('./common/head/head-website.php')    ?>
</head>

<body>
    <!-- Navbar Start -->
    <?php  include_once('./common/header/navbar.php')    ?>
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 position-relative overlay-bottom">
        <div class="d-flex flex-column align-items-center justify-content-center pt-0 pt-lg-5" style="min-height: 400px">
            <h1 class="display-4 mb-3 mt-0 mt-lg-5 text-white text-uppercase">Liên hệ</h1>
            <div class="d-inline-flex mb-lg-5">
                <p class="m-0 text-white"><a class="text-white" href="">Trang chủ</a></p>
                <p class="m-0 text-white px-2">/</p>
                <p class="m-0 text-white">Liên hệ</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Contact Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <div class="section-title">
                <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;">Liên hệ với chúng tôi</h4>
                
            </div>
            <div class="row px-3 pb-2">
                <div class="col-sm-4 text-center mb-3">
                    <i class="fa fa-2x fa-map-marker-alt mb-3 text-primary"></i>
                    <h4 class="font-weight-bold">Địa chỉ</h4>
                    <p>Nguyễn Văn Bảo, P4, Gò Vấp, TP.HCM</p>
                </div>
                <div class="col-sm-4 text-center mb-3">
                    <i class="fa fa-2x fa-phone-alt mb-3 text-primary"></i>
                    <h4 class="font-weight-bold">Phone</h4>
                    <p>+012 345 6789</p>
                </div>
                <div class="col-sm-4 text-center mb-3">
                    <i class="far fa-2x fa-envelope mb-3 text-primary"></i>
                    <h4 class="font-weight-bold">Email</h4>
                    <p>info@example.com</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 pb-5">
                   
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31350.868768746088!2d106.6661723347656!3d10.822131500000008!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317528e548200413%3A0xdbf245c4ae10416d!2zTmd1eeG7hW4gVsSDbiBC4bqjbywgR8OyIFbhuqVwLCBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1731315214932!5m2!1svi!2s" width="550" height="450" style="border:0;" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0" ></iframe> 
                </div>
                <div class="col-md-6 pb-5">
                    <div class="contact-form">
                        <div id="success"></div>
                        <form name="sentMessage" id="contactForm" novalidate="novalidate">
                            <div class="control-group">
                                <input type="text" class="form-control bg-transparent p-4" id="name" placeholder="Your Name"
                                    required="required" data-validation-required-message="Please enter your name" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group">
                                <input type="email" class="form-control bg-transparent p-4" id="email" placeholder="Your Email"
                                    required="required" data-validation-required-message="Please enter your email" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group">
                                <input type="text" class="form-control bg-transparent p-4" id="subject" placeholder="Subject"
                                    required="required" data-validation-required-message="Please enter a subject" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group">
                                <textarea class="form-control bg-transparent py-3 px-4" rows="5" id="message" placeholder="Message"
                                    required="required"
                                    data-validation-required-message="Please enter your message"></textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                            <div>
                                <button class="btn btn-primary font-weight-bold py-3 px-5" type="submit" id="sendMessageButton">Send
                                    Message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->


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
<?php
// Mảng sản phẩm ví dụ (thực tế sẽ lấy từ cơ sở dữ liệu)
$products = [
    1 => [
        'name' => 'Bánh Mì',
        'description' => 'Bánh mì được thêm gia vị như tương ớt, mayonnaise, hoặc pate.',
        'price' => '15,000 VND',
        'image' => 'assets/img/sp1.webp',
        'sizes' => ['S' => '15,000 VND', 'M' => '25,000 VND']
    ],
    2 => [
        'name' => 'Cà Phê',
        'description' => 'Cà phê rang xay nguyên chất.',
        'price' => '20,000 VND',
        'image' => 'assets/img/sp2.webp',
        'sizes' => ['S' => '20,000 VND', 'M' => '30,000 VND']
    ],
    // Thêm các sản phẩm khác nếu cần
];

// Lấy ID sản phẩm từ URL
$productId = isset($_GET['id']) ? $_GET['id'] : null;

if ($productId && isset($products[$productId])) {
    $product = $products[$productId];
} else {
    echo 'Sản phẩm không tồn tại.';
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <?php include_once('./common/head/head-website.php') ?>
    <style>
        /* CSS cho trang chi tiết sản phẩm */
        .product-detail {
            margin: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .product-detail img {
            width: 400px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0px 0px 10px #999;
            margin-top: 10px;
        }

        .product-detail h1 {
            text-align: center;
            font-size: 24px;
            color: #993300;
            margin-left: 0px;
            margin-top: 20px;
        }

        .product-detail .price {
            color: #993300;
            font-size: 18px;
            font-weight: bold;
            margin-left: 50px;
        }

        .product-detail .description {
            text-align: center;
            margin-top: 20px;
            font-size: 20px;
        }

        .product-detail .sizes {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            margin-left: 50px;
        }

        .product-detail .sizes a {
            margin: 0 10px;
            color: #993300;
            text-decoration: none;
            font-weight: bold;
            margin-left: 50px;
        }

        .product-detail .sizes a:hover {
            color: #000000;
        }
        .col-md-6>img{
            margin-left: 50px;
        }
        .productBox{
            margin-left: 100px;
        }
        .size ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex; /* Đặt các phần tử con theo hàng ngang */
        }

        .size li {
            margin-right: 10px; /* Khoảng cách giữa các item */
            border: 1px solid #ccc; /* Đóng khung */
            padding: 8px 15px;
            border-radius: 5px;
            background-color: #f5f5f5; /* Màu nền cho các phần tử */
            cursor: pointer;
            text-align: center; /* Căn giữa nội dung */
            transition: background-color 0.3s ease; /* Hiệu ứng khi hover */
        }

        .size li:last-child {
            margin-right: 0; /* Loại bỏ margin bên phải của phần tử cuối cùng */
        }

        .size li a {
            color: #333; /* Màu chữ */
            text-decoration: none; /* Xóa gạch chân */
            font-weight: bold; /* In đậm */
        }

        .size li:hover {
            background-color: red; /* Thay đổi màu nền khi hover */
        }

        .size li.selected {
            background-color: #993300; /* Màu nền khi kích cỡ được chọn */
            color: white; /* Màu chữ khi kích cỡ được chọn */
        }

        #slideOther .slick-slider {
            width: 50%; /* Đảm bảo slider chiếm toàn bộ chiều rộng của container */
        }

        #slideOther .slick-track {
            display: flex; /* Sử dụng Flexbox để các item sắp xếp theo chiều ngang */
        }

        #slideOther .item {
            flex: 0 0 auto; /* Đảm bảo mỗi item có kích thước cố định */
            width: 20%; /* Hiển thị 5 items trên mỗi dòng, có thể điều chỉnh tùy nhu cầu */
            margin-right: 10px; /* Khoảng cách giữa các item */
        }

        .img>a>img{
            width: 200px;
            height: auto;
        }
        .tend2{
            size: 10px;
            margin-left: 18px;
        }
        input[type="text"],
        textarea, select {
            width: 100%;
            padding: 8px; 
            margin: 5px 0;
            box-sizing: border-box; 
        }
        .fa-star {
            color: #f39c12; /* Màu vàng cho ngôi sao */
            font-size: 18px;
            margin-right: 3px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#slideOther').slick({
                autoplay: true,            // Bật chế độ tự động chạy
                autoplaySpeed: 3000,       // Thời gian chuyển slide (3 giây)
                dots: true,                // Hiển thị dấu chấm dưới slider
                arrows: true,              // Hiển thị nút điều hướng (next/prev)
                infinite: true,            // Chế độ lặp lại vô hạn
                slidesToShow: 4,           // Số lượng slide hiển thị trên một trang
                slidesToScroll: 1          // Mỗi lần cuộn 1 slide
            });
    });
</script>
</head>

<body>
    <!-- Navbar Start -->
    <?php include_once('./common/header/navbar.php') ?>
    <!-- Navbar End -->

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 position-relative overlay-bottom">
        <div class="d-flex flex-column align-items-center justify-content-center pt-0 pt-lg-5" style="min-height: 400px">
            <h1 class="display-4 mb-3 mt-0 mt-lg-5 text-white text-uppercase"><?php echo $product['name']; ?></h1>
            <div class="d-inline-flex mb-lg-5">
                <p class="m-0 text-white"><a class="text-white" href="index.php">Trang chủ</a></p>
                <p class="m-0 text-white px-2">/</p>
                <p class="m-0 text-white">Chi tiết sản phẩm</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Product Detail Start -->
    <div class="product-detail">
        <div class="row">
            <div class="col-md-6">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                <h1><?php echo $product['name']; ?></h1>
            </div>
            <div class="col-md-6">
                <div class="description"><?php echo $product['description']; ?></div>
                <img alt="65-dat-mua-kmk" data-ck-zoom="yes" src="https://highlandscoffee.com.vn/vnt_upload/product/04_2020/65-dat-mua-kmk.png" style="width: 400px; height: 99px;">
                <p>&nbsp;</p>
                <div class="productBox">
                    <div class="title-box">Size :</div>
                    <div class="content-box mb-5">
                        <div class="size">
                            <ul>
                                <?php foreach ($product['sizes'] as $size => $price) : ?>
                                    <li class=""><a href="javascript:void(0)" data-id="<?php echo $size; ?>" data-price="<?php echo $price; ?>"><?php echo $size?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="price" bis_skin_checked="1">Giá : <strong id="ext_price"><?php echo $product['price']; ?></strong></div>
                </div>
            </div>
            <script>
                document.querySelectorAll('.size a').forEach(function(sizeElement) {
                sizeElement.addEventListener('click', function(event) {
                    // Lấy giá từ thuộc tính 'data-price' của liên kết được nhấp
                    var newPrice = sizeElement.getAttribute('data-price');
                    
                    // Cập nhật giá hiển thị trong phần tử có ID 'ext_price'
                    document.getElementById('ext_price').innerText = newPrice;
                });
            });
            </script>
        </div>
        <div class="row">
            <div class="box_mid">
                <div class="mid-title">
                    <div class="titleL"><h2>Khác</h2></div>
                    <div class="titleR"></div>
                </div>

                <div class="mid-content">
                    <div id="slideOther" class="slick-slider">
                        <div class="slick-list">
                            <div class="slick-track">
                                <!-- Item 1 -->
                                <div class="item slick-slide">
                                    <div class="product mb-3">
                                        <div class="img mb-3">
                                            <a href="https://www.highlandscoffee.com.vn/vn/tra-thach-dao.html">
                                                <img src="https://www.highlandscoffee.com.vn/vnt_upload/product/06_2023/thumbs/270_crop_HLC_New_logo_5.1_Products__TRA_THANH_DAO-09.jpg" alt="Trà Thạch Đào">
                                            </a>
                                        </div>
                                        <div class="tend2">
                                            <h4><a href="https://www.highlandscoffee.com.vn/vn/tra-thach-dao.html">Trà Thạch Đào</a></h4>
                                        </div>
                                        <div class="price">Giá: <strong>45,000 VNĐ</strong></div>
                                    </div>
                                </div>

                                <!-- Item 2 -->
                                <div class="item slick-slide">
                                    <div class="product mb-3">
                                        <div class="img mb-3">
                                            <a href="https://www.highlandscoffee.com.vn/vn/tra-thanh-d.html">
                                                <img src="https://www.highlandscoffee.com.vn/vnt_upload/product/06_2023/thumbs/270_crop_HLC_New_logo_5.1_Products__TRA_THANH_DAO-08.jpg" alt="Trà Thanh Đào">
                                            </a>
                                        </div>
                                        <div class="tend2">
                                            <h4><a href="https://www.highlandscoffee.com.vn/vn/tra-thanh-d.html">Trà Thanh Đào</a></h4>
                                        </div>
                                        <div class="price">Giá: <strong>45,000 VNĐ</strong></div>
                                    </div>
                                </div>

                                <!-- Item 3 -->
                                <div class="item slick-slide">
                                    <div class="product mb-3">
                                        <div class="img mb-3">
                                            <a href="https://www.highlandscoffee.com.vn/vn/tra-sen-vang-sen-.html">
                                                <img src="https://www.highlandscoffee.com.vn/vnt_upload/product/06_2023/thumbs/270_crop_HLC_New_logo_5.1_Products__TSV.jpg" alt="Trà Sen Vàng (Sen)">
                                            </a>
                                        </div>
                                        <div class="tend2">
                                            <h4><a href="https://www.highlandscoffee.com.vn/vn/tra-sen-vang-sen-.html">Trà Sen Vàng</a></h4>
                                        </div>
                                        <div class="price">Giá: <strong>45,000 VNĐ</strong></div>
                                    </div>
                                </div>

                                <!-- Item 4 -->
                                <div class="item slick-slide">
                                    <div class="product mb-3">
                                        <div class="img mb-3">
                                            <a href="https://www.highlandscoffee.com.vn/vn/tra-xanh-dau-d.html">
                                                <img src="https://www.highlandscoffee.com.vn/vnt_upload/product/06_2023/thumbs/270_crop_HLC_New_logo_5.1_Products__TRA_XANH_DAU_DO.jpg" alt="Trà Xanh Đậu Đỏ">
                                            </a>
                                        </div>
                                        <div class="tend2">
                                            <h4><a href="https://www.highlandscoffee.com.vn/vn/tra-xanh-dau-d.html">Trà Xanh Đậu Đỏ</a></h4>
                                        </div>
                                        <div class="price">Giá: <strong>45,000 VNĐ</strong></div>
                                    </div>
                                </div>

                                <!-- Item 5 -->
                                <div class="item slick-slide">
                                    <div class="product mb-3">
                                        <div class="img mb-3">
                                            <a href="https://www.highlandscoffee.com.vn/vn/tra-thac-vai.html">
                                                <img src="https://www.highlandscoffee.com.vn/vnt_upload/product/06_2023/thumbs/270_crop_HLC_New_logo_5.1_Products__TRA_TACH_VAI.jpg" alt="Trà Thạch Vải">
                                            </a>
                                        </div>
                                        <div class="tend2">
                                            <h4><a href="https://www.highlandscoffee.com.vn/vn/tra-thac-vai.html">Trà Thạch Vải</a></h4>
                                        </div>
                                        <div class="price">Giá: <strong>45,000 VNĐ</strong></div>
                                    </div>
                                </div>

                                <!-- Thêm các item khác nếu cần -->
                            </div>
                        </div>
                        <!-- <button class="slick-prev slick-arrow" aria-label="Previous" type="button"><</button>
                        <button class="slick-next slick-arrow" aria-label="Next" type="button">></button> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="product-review">
                    <h2 style="margin-left:-370px;">Đánh giá sản phẩm</h2>
                    <?php

                        // Mảng để lưu các đánh giá
                        if (!isset($_SESSION['reviews'])) {
                            $_SESSION['reviews'] = [];
                        }

                        // Xử lý form khi người dùng gửi đánh giá
                        if (isset($_POST['submit_review'])) {
                            $name = $_POST['name'];
                            $rating = $_POST['rating'];
                            $comment = $_POST['comment'];
                            
                            // Thêm đánh giá vào mảng session
                            $_SESSION['reviews'][] = [
                                'name' => $name,
                                'rating' => $rating,
                                'comment' => $comment
                            ];
                        }
                        $reviews = $_SESSION['reviews'];
                    ?>
                    <form action="" method="POST">
                        <div>
                            <label for="name">Tên của bạn:</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div>
                            <label for="rating">Đánh giá:</label>
                            <select id="rating" name="rating" required>
                                <option value="1">1 sao</option>
                                <option value="2">2 sao</option>
                                <option value="3">3 sao</option>
                                <option value="4">4 sao</option>
                                <option value="5">5 sao</option>
                            </select>
                        </div>
                        <h2 style="margin-left:-370px;">Bình luận sản phẩm</h2>
                        <div>
                            <label for="comment">Bình luận:</label>
                            <textarea id="comment" name="comment" rows="4" required></textarea>
                        </div>
                        <button type="submit" style="margin-left:100px;" name="submit_review">Gửi phản hồi</button>
                    </form>

                    <?php if (!empty($reviews)) : ?>
                        <div class="review-list">
                            <h3>Đánh giá từ khách hàng:</h3>
                            <?php foreach ($reviews as $review) : ?>
                                <div class="review-item">
                                    <strong><?php echo htmlspecialchars($review['name']); ?></strong>
                                    <div>Đánh giá: <?php echo str_repeat('<i class="fas fa-star"></i>', $review['rating']); ?></div>
                                    <p><?php echo htmlspecialchars($review['comment']); ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
        </div>
    </div>
    <!-- Product Detail End -->

    <!-- Footer Start -->
    <?php include_once('./common/footer/footer.php') ?>
    <!-- Footer End -->

    <!-- JavaScript Libraries -->
    <?php include_once('./common/script/default-template.php') ?>
</body>

</html>
<?php
    include_once('./connect/database.php');
    $database = new Database();
    $conn = $database->connect();

    if (isset($_GET['ProductID']) && !empty($_GET['ProductID'])) {
        $productID = $_GET['ProductID'];

        $sql = "SELECT ProductID, ProductName, UnitPrice, ProductImage, Description, UnitsInStock, Status 
                FROM product 
                WHERE ProductID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $productID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result);
        } else {
            echo "<p>Không tìm thấy sản phẩm!</p>";
            exit;
        }
    } else {
        echo "<p>Không tồn tại mã sản phẩm!</p>";
        exit;
    }

    $carouselSql = "SELECT ProductID, ProductName, UnitPrice, ProductImage FROM product WHERE Status = 1 LIMIT 25";  // Bạn có thể thay đổi LIMIT
    $carouselResult = mysqli_query($conn, $carouselSql);

    mysqli_stmt_close($stmt);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <?php include_once('./common/head/head-website.php') ?>
    <link rel="stylesheet" href="./assets/css/productdetail-styles.css">
</head>
<body>
    <?php include_once('./common/header/navbar.php'); ?>

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 position-relative overlay-bottom">
        <div class="d-flex flex-column align-items-center justify-content-center pt-0 pt-lg-5" style="min-height: 400px">
            <h1 class="display-4 mb-3 mt-0 mt-lg-5 text-white text-uppercase">CHI TIẾT SẢN PHẨM</h1>
            <div class="d-inline-flex mb-lg-5">
                <p class="m-0 text-white"><a class="text-white" href="index.php?page=menu">Menu</a></p>
                <p class="m-0 text-white px-2">/</p>
                <p class="m-0 text-white">Chi tiết sản phẩm</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-4">
            <div class="product-detail">
                <?php if (!empty($product['ProductImage'])): ?>
                    <img src="assets/img/products/<?php echo htmlspecialchars($product['ProductImage']); ?>" alt="<?php echo htmlspecialchars($product['ProductName']); ?>" class="img-fluid">
                <?php else: ?>
                    <img src="assets/img/default-product.jpg" alt="Default Product Image" class="img-fluid">
                <?php endif; ?>

            </div>
        </div>
        <div class="col-md-6">
                <h1><?php echo htmlspecialchars($product['ProductName']); ?></h1>
                <p><strong>Giá:</strong> <?php echo number_format($product['UnitPrice'], 0, ',', '.'); ?> VND</p>
                <p><strong>Mô tả:</strong> <?php echo htmlspecialchars($product['Description']); ?></p>
                <p><strong>Số lượng trong kho:</strong> <?php echo $product['UnitsInStock']; ?></p>
                <p><strong>Trạng thái:</strong> <?php echo $product['Status'] == 1 ? 'Còn hàng' : 'Hết hàng'; ?></p>
            <a href="index.php?page=menu" style="margin-left:150px" class="btn btn-secondary mt-3">Quay lại danh sách sản phẩm</a>
        </div>
    </div>
    <div class="row mb-5">
    <div class="container mt-5">
    <h2 class="text-center">Sản phẩm nổi bật</h2>
    <div id="productCarousel" class="carousel slide" data-ride="carousel" data-interval="5000">
        <div class="carousel-inner">
            <?php 
            if ($carouselResult->num_rows > 0) {
                $isActive = true;
                $count = 0;
                while ($carouselProduct = mysqli_fetch_assoc($carouselResult)) {
                    if ($count % 4 == 0) { 
                        if ($count > 0) echo '</div></div>'; // Kết thúc nhóm trước
                        echo '<div class="carousel-item '.($isActive ? 'active' : '').'">'; // Nhóm mới
                        echo '<div class="row d-flex justify-content-start">';
                        $isActive = false; // Sau nhóm đầu tiên, không còn active nữa
                    }
                    ?>
                    <div class="col-md-3 text-center">
                        <a href="index.php?page=page_productdetail&ProductID=<?php echo $carouselProduct['ProductID']; ?>" class="text-decoration-none">
                            <div class="product-image-wrapper">
                                <img src="assets/img/products/<?php echo htmlspecialchars($carouselProduct['ProductImage']); ?>" 
                                    class="img-fluid product-image" 
                                    alt="<?php echo htmlspecialchars($carouselProduct['ProductName']); ?>">
                            </div>
                            <h5 class="mt-2"><?php echo htmlspecialchars($carouselProduct['ProductName']); ?></h5>
                            <p><?php echo number_format($carouselProduct['UnitPrice'], 0, ',', '.'); ?> VND</p>
                        </a>
                    </div>
                    <?php 
                    $count++;
                }
                if ($count % 4 != 0) echo '</div></div>'; // Đảm bảo kết thúc nhóm cuối nếu không đủ 4 sản phẩm
            } else {
                echo "<p class='text-center'>Không có sản phẩm nào để hiển thị!</p>";
            }
            ?>
        </div>

            <a class="carousel-control-prev" href="#productCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#productCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="container mt-5">
            <div class="product-review">
                <h3>Đánh giá sản phẩm</h3>
                <?php
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                ?>
                <?php
                    if (isset($_SESSION['loggedinCustomer']) && $_SESSION['loggedinCustomer'] == true) {
                        if (isset($_SESSION['ProductID'])) {
                            header('Location: index.php?page=page_productdetail&ProductID=' . $_SESSION['ProductID']);
                            exit();
                        }
                ?>
                        <form action="index.php?page=page_review" method="POST">
                            <input type="hidden" name="ProductID" value="<?php echo $product['ProductID']; ?>">
                            <input type="hidden" name="rating" id="rating" value="0">
                            <b><?php echo htmlspecialchars($_SESSION['usernameCustomer']); ?></b>
                            <br><br>
                            
                            <label for="rating">Đánh giá:</label>
                            <div class="star-rating">
                                <span class="star" data-value="1">&#9733;</span>
                                <span class="star" data-value="2">&#9733;</span>
                                <span class="star" data-value="3">&#9733;</span>
                                <span class="star" data-value="4">&#9733;</span>
                                <span class="star" data-value="5">&#9733;</span>
                            </div>
                            <br><br>

                            <label for="comment">Bình luận:</label><br>
                            <textarea name="comment" id="comment" rows="4" cols="50" required></textarea><br><br>

                            <button type="submit" class="btn btn-primary mb-5" style="width: 41.5%">Gửi phản hồi</button>
                        </form>

                        <script>
                            const stars = document.querySelectorAll('.star');
                            const ratingInput = document.getElementById('rating');

                            stars.forEach(star => {
                                star.addEventListener('mouseover', function() {
                                    const value = this.getAttribute('data-value');
                                    highlightStars(value);
                                });

                                star.addEventListener('mouseout', function() {
                                    highlightStars(ratingInput.value);
                                });

                                star.addEventListener('click', function() {
                                    const value = this.getAttribute('data-value');
                                    ratingInput.value = value;
                                    highlightStars(value);
                                });
                            });

                            function highlightStars(rating) {
                                stars.forEach(star => {
                                    if (star.getAttribute('data-value') <= rating) {
                                        star.style.color = 'gold';
                                    } else {
                                        star.style.color = 'gray';
                                    }
                                });
                            }
                        </script>
                        <?php
                    } else {
                        echo "<p>Vui lòng <a href='index.php?page=login'>đăng nhập</a> để đánh giá sản phẩm.</p>";
                    }
                    ?>
                
                <?php
                        $sql = "SELECT c.CommentID, c.Content, c.Rating, c.CreateDate, cu.CustomerName
                                FROM comment c JOIN comment_product cp ON cp.CommentID = c.CommentID
                                JOIN customer cu ON cu.CustomerID = c.CustomerID 
                                WHERE cp.ProductID = ? 
                                ORDER BY c.CreateDate DESC";
                        $stmt = mysqli_prepare($conn, $sql);
                        if (!$stmt) {
                            echo "Lỗi trong câu truy vấn: " . mysqli_error($conn);
                            exit;
                        }
                        
                        mysqli_stmt_bind_param($stmt, "s", $productID);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        if (mysqli_num_rows($result) > 0):
                    ?>
                    <?php while ($review = mysqli_fetch_assoc($result)): ?>
                        <div class="review">
                            <p><b><?php echo htmlspecialchars($review['CustomerName']); ?>:</b>
                        <?php 
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $review['Rating']) {
                                    echo '★';
                                } else {
                                    echo '☆';
                                }
                            }
                            ?> (<?php echo $review['Rating']; ?>/5)
                        </p>
                            <p><?php echo nl2br(htmlspecialchars($review['Content'])); ?></p>
                            <p><small><?php echo date('d/m/Y H:i', strtotime($review['CreateDate'])); ?></small></p>
                        </div>
                        <hr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Chưa có đánh giá cho sản phẩm này.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

            <?php
                mysqli_stmt_close($stmt);
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
    <!-- Footer End -->

    <!-- JavaScript Libraries -->
    <script src="./assets/vendor/jquery/jquery.min.js"></script>
    <script src="./assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="./assets/css/bootstrap/js/bootstrap.min.css"></script>
    <script src="./assets/vendor/jquery/jquery.slim.min.js"></script>
    <?php include_once('./common/script/default-template.php')?>
    <script>
        $(document).ready(function() {
            $('#productCarousel').carousel({
                interval: 5000 // thời gian chuyển slide tự động (5000ms = 5s)
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const decreaseButton = document.getElementById("decrease");
            const increaseButton = document.getElementById("increase");
            const quantityInput = document.getElementById("quantity");

            decreaseButton.addEventListener("click", function () {
                let currentValue = parseInt(quantityInput.value) || 1;
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });

            increaseButton.addEventListener("click", function () {
                let currentValue = parseInt(quantityInput.value) || 1;
                let maxStock = <?php echo $product['UnitsInStock']; ?>;
                if (currentValue < maxStock) {
                    quantityInput.value = currentValue + 1;
                }
            });
        });
    </script>
    <script>
        function showProductDetails(productId) {
            // Hide all product details
            var details = document.querySelectorAll('.product-details');
            details.forEach(function (detail) {
                detail.style.display = 'none';
            });

            // Show the selected product details
            var productDetail = document.getElementById('product-details-' + productId);
            if (productDetail) {
                productDetail.style.display = 'block';
            }
        }
    </script>
</body>
</html>

<?php
    mysqli_close($conn);
?>
<?php
    include_once('./connect/database.php');
    $database = new Database();
    $conn = $database->connect();

    // Kiểm tra nếu ProductID tồn tại trong URL
    if (isset($_GET['ProductID']) && !empty($_GET['ProductID'])) {
        $productID = $_GET['ProductID'];

        // Truy vấn chi tiết sản phẩm từ cơ sở dữ liệu
        $sql = "SELECT ProductID, ProductName, UnitPrice, ProductImage, Description, UnitsInStock, Status 
                FROM product 
                WHERE ProductID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $productID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Kiểm tra nếu sản phẩm tồn tại
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

    $carouselSql = "SELECT ProductID, ProductName, UnitPrice, ProductImage FROM product WHERE Status = 1 LIMIT 5";  // Bạn có thể thay đổi LIMIT
    $carouselResult = mysqli_query($conn, $carouselSql);

    mysqli_stmt_close($stmt);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <?php include_once('./common/head/head-website.php') ?>
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
        .containerfull {
            display: flex;
            justify-content: space-between;
            padding: 0 20px;
        }

        .boxleft {
            width: 20%;
            padding-right: 20px;
        }

        .boxright {
            width: 78%;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* 4 cột mỗi hàng */
            gap: 20px; /* Khoảng cách giữa các sản phẩm */
        }
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
        .search-form {
            display: flex;                
            justify-content: center;    
            align-items: center;           
            gap: 10px;                     
            margin: 30px auto;
            max-width: 600px;
            margin-left:90px;
        }

        .search-form form {
            display: flex;             
            width: 100%;
            justify-content: center;       
            align-items: center;           
        }

        .search-form input[type="text"] {
            font-size: 14px;
            padding: 10px;
            width: 300px;                
            border: 2px solid #333;
            border-radius: 15px;
            background-color: #f4f4f9;
            transition: background-color 0.3s ease;
        }

        .search-form input[type="text"]:focus {
            background-color: #fff;
        }

        .search-form button {
            font-size: 13px;
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            margin-left: 20px;
            transition: background-color 0.3s ease;
            width: 112px;
        }

        .search-form a {
            font-size: 13px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            border-radius: 15px;  /* bo tròn */
            padding: 10px 20px;
            width: 112px;
            margin-left: 20px;
            background-color: #28a745 ; 
            /* #28a745 */
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: inline-block;
            text-transform: uppercase;
            text-align: center;
        }

        .search-form button:hover, .search-form a:hover {
            background-color: #218838;
        }

        .search-form button:active, .search-form a:active {
            background-color: #1e7e34;
        }

        .product-card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        text-align: center;
    }

    .product-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 15px;
    }
    .product-detail img{
        margin-top: 50px;
    }

    .product-card h3 {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    .product-card p {
        font-size: 14px;
        color: #555;
        margin-bottom: 10px;
    }

    .product-card p:nth-of-type(3) {
        color: #E74C3C;
        font-size: 16px;
        font-weight: bold;
    }

    .product-card p:nth-of-type(4) {
        color: #2ecc71;
        font-weight: bold;
    }

    .menu-item {
        margin-left: 50px;
    }
  
    .star-rating {
        font-size: 30px;
        cursor: pointer;
    }

    .star {
        color: gray; 
        padding: 0 5px;
    }
    .row .container .text-center{
        display: flex;
        flex-wrap: nowrap;
        justify-content: flex-start;
        gap: 10px; 
        margin-left: 20px;
    }

    .col-md-2 {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .product-image-wrapper {
        width: 100%;
        height: 200px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .col-md-2 h5, .col-md-2 p {
        text-align: center;
    }
    </style>
</head>
<body>
    <?php include_once('./common/header/navbar.php'); ?>

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 position-relative overlay-bottom">
        <div class="d-flex flex-column align-items-center justify-content-center pt-0 pt-lg-5" style="min-height: 400px">
            <h1 class="display-4 mb-3 mt-0 mt-lg-5 text-white text-uppercase">CHI TIẾT SẢN PHẨM</h1>
            <div class="d-inline-flex mb-lg-5">
                <p class="m-0 text-white"><a class="text-white" href="index.php">Menu</a></p>
                <p class="m-0 text-white px-2">/</p>
                <p class="m-0 text-white">Chi tiết sản phẩm</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Form tìm kiếm -->
    <div class="search-form mb-5">
        <form action="" method="get">
            <input type="text" name="tim" placeholder="Nhập tên sản phẩm..." required>
            <button type="submit">TÌM KIẾM</button>
            <a href="index.php?page=menu" id='a1'>Quay Lại</a>
        </form>
    </div>
    <div class="row">
        <div class="col-md-3">
            <h1 style="margin-left: -80px">DANH MỤC</h1><br><br>
            <a href="#" class="menu-item">Cà phê</a><br>
            <a href="#" class="menu-item">Trà</a>
         </div>
        <div class="col-md-4">
            <div class="product-detail">
                <?php if (!empty($product['ProductImage'])): ?>
                    <img src="assets/img/products/<?php echo htmlspecialchars($product['ProductImage']); ?>" alt="<?php echo htmlspecialchars($product['ProductName']); ?>" class="img-fluid">
                <?php else: ?>
                    <img src="assets/img/default-product.jpg" alt="Default Product Image" class="img-fluid">
                <?php endif; ?>

            </div>
        </div>
        <div class="col-md-5">
                <h1><?php echo htmlspecialchars($product['ProductName']); ?></h1>
                <p><strong>Giá:</strong> <?php echo number_format($product['UnitPrice'], 0, ',', '.'); ?> VND</p>
                <p><strong>Mô tả:</strong> <?php echo htmlspecialchars($product['Description']); ?></p>
                <p><strong>Số lượng trong kho:</strong> <?php echo $product['UnitsInStock']; ?></p>
                <p><strong>Trạng thái:</strong> <?php echo $product['Status'] == 1 ? 'Còn hàng' : 'Hết hàng'; ?></p>

                <form action="#" method="POST">
                    <input type="hidden" name="ProductID" value="<?php echo $product['ProductID']; ?>">
                    <button type="submit" class="btn btn-primary">Thêm vào giỏ hàng</button>
                </form>
            <a href="index.php?page=menu" style="margin-left:150px" class="btn btn-secondary mt-3">Quay lại danh sách sản phẩm</a>
        </div>
    </div>
    <div class="row mb-5">
        <div class="container mt-5">
            <h2 class="text-center">Sản phẩm nổi bật</h2>
            <div id="productCarousel" class="carouselslide" data-ride="carousel" data-interval="5000">
                <div class="carousel-inner">
                    <?php 
                        $isActive = true;
                        $count = 0; 
                        echo '<div class="carousel-item '.($isActive ? 'active' : '').'">';
                    ?>
                    <div class="row d-flex justify-content-start">
                        <?php 
                            while ($carouselProduct = mysqli_fetch_assoc($carouselResult)): 
                        ?>
                            <div class="col-md-2 text-center">
                                <div class="product-image-wrapper">
                                    <img src="assets/img/products/<?php echo htmlspecialchars($carouselProduct['ProductImage']); ?>" 
                                        class="product-image" 
                                        alt="<?php echo htmlspecialchars($carouselProduct['ProductName']); ?>">
                                </div>
                                <h5><?php echo htmlspecialchars($carouselProduct['ProductName']); ?></h5>
                                <p><?php echo number_format($carouselProduct['UnitPrice'], 0, ',', '.'); ?> VND</p>
                            </div>
                        <?php 
                            $count++; 
                        endwhile; 
                        ?>
                    </div>
                    </div> <!-- Đóng slide -->
                </div>
            </div>
                <!-- Điều hướng carousel -->
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
                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                ?>
                        <form action="index.php?page=page_review" method="POST">
                            <input type="hidden" name="ProductID" value="<?php echo $product['ProductID']; ?>">
                            <input type="hidden" name="rating" id="rating" value="0">
                            <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>
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

                            <button type="submit" class="btn btn-primary" style="width: 41.5%">Gửi phản hồi</button>
                        </form>

                        <script>
                            // JavaScript để xử lý sự kiện khi người dùng click vào ngôi sao
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
                                        star.style.color = 'gold'; // Ngôi sao sáng
                                    } else {
                                        star.style.color = 'gray'; // Ngôi sao mờ
                                    }
                                });
                            }
                        </script>
                        <?php
                    } else {
                        // Nếu người dùng chưa đăng nhập
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
    <?php include_once('./common/footer/footer.php'); ?>
    <!-- Footer End -->

    <!-- JavaScript Libraries -->
    <script src="./assets/vendor/jquery/jquery.min.js"></script>
    <script src="./assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <?php include_once('./common/script/default-template.php')?>
    <script>
        $(document).ready(function() {
            $('#productCarousel').carousel({
                interval: 5000 // thời gian chuyển slide tự động (5000ms = 5s)
            });
        });
    </script>
</body>
</html>

<?php
    mysqli_close($conn);
?>
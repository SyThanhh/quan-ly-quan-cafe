
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
        /* Phong cách tổng thể cho form tìm kiếm */
        .search-form {
            display: flex;                 /* Sử dụng Flexbox để căn chỉnh các phần tử trong cùng một hàng */
            justify-content: center;       /* Căn giữa các phần tử */
            align-items: center;           /* Căn chỉnh các phần tử theo chiều dọc */
            gap: 10px;                     /* Khoảng cách giữa các phần tử */
            margin: 30px auto;
            max-width: 600px;
            margin-left:90px;
        }

        .search-form form {
            display: flex;                 /* Flexbox cho form */
            width: 100%;
            justify-content: center;       /* Căn giữa các phần tử trong form */
            align-items: center;           /* Căn chỉnh các phần tử theo chiều dọc */
        }

        .search-form input[type="text"] {
            font-size: 16px;
            padding: 10px;
            width: 300px;                  /* Đặt chiều rộng cho ô input */
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
    </style>
</head>

<body>
<?php include_once('./common/header/navbar.php'); ?>
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
    <!-- Navbar Start -->
    
    
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 position-relative overlay-bottom">
        <div class="d-flex flex-column align-items-center justify-content-center pt-0 pt-lg-5" style="min-height: 400px">
            <h1 class="display-4 mb-3 mt-0 mt-lg-5 text-white text-uppercase">MENU</h1>
            <div class="d-inline-flex mb-lg-5">
                <p class="m-0 text-white"><a class="text-white" href="">Trang chủ</a></p>
                <p class="m-0 text-white px-2">/</p>
                <p class="m-0 text-white">Menu</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Form tìm kiếm -->
    <div class="search-form">
        <form action="" method="post">
            <input type="text" name="tim" placeholder="Nhập tên sản phẩm..." required>
            <button type="submit">TÌM KIẾM</button>

            <!-- <a href="?page=menu" id='a1'>Quay Lại</a> -->
        </form>
    </div>

   <!-- Menu Start -->
   <section class="containerfull">
    <div class="boxleft">
        <h1>DANH MỤC</h1><br><br>
        <select class="form-control" id="category-select" name="category" onchange="filterByCategory()" style=" font-size: 16px;padding: 8px;width: 175px;border: 1px solid #333;border-radius: 14px;background-color: #f4f4f9;transition: background-color 0.3s ease;">
            <option value="">Chọn danh mục</option>
            <option value="1">Cafe</option>
            <option value="2">Soda</option>
            <option value="3">Nước ép</option>
            <option value="4">Trà</option>
            <option value="5">Nước ngọt</option>
        </select>
    </div>    

    <div class="product-grid">
        <?php
        // Kết nối cơ sở dữ liệu
        $servername = "localhost"; // Hoặc IP của máy chủ MySQL
        $username = "root";        // Tên người dùng MySQL
        $password = "";        // Mật khẩu MySQL
        $dbname = "db_ql3scoffee"; // Tên cơ sở dữ liệu

        // Tạo kết nối
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Kiểm tra kết nối
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Get selected category from GET request or use default
        $categoryID = isset($_GET['category']) ? $_GET['category'] : '';

        $searchTerm = isset($_REQUEST['tim']) ? $_REQUEST['tim'] : '';

        if (!empty($searchTerm)) {
            $sql = "SELECT p.ProductID, p.ProductName, p.UnitPrice, p.ProductImage, p.Description, p.UnitsInStock, p.Status, 
                       c.CategoryID, c.CategoryName 
                    FROM product p
                    LEFT JOIN category c ON p.CategoryID = c.CategoryID
                    WHERE p.ProductName LIKE ?";
            $stmt = mysqli_prepare($conn, $sql);
            $likeSearchTerm = "%" . $searchTerm . "%";
            mysqli_stmt_bind_param($stmt, "s", $likeSearchTerm);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        } else {
            // Query products by category if selected
            if (!empty($categoryID)) {
                $sql = "SELECT p.ProductID, p.ProductName, p.UnitPrice, p.ProductImage, p.Description, p.UnitsInStock, p.Status, 
                           c.CategoryID, c.CategoryName 
                        FROM product p
                        LEFT JOIN category c ON p.CategoryID = c.CategoryID
                        WHERE c.CategoryID = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "i", $categoryID);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
            } else {
                $sql = "SELECT p.ProductID, p.ProductName, p.UnitPrice, p.ProductImage, p.Description, p.UnitsInStock, p.Status, 
                           c.CategoryID, c.CategoryName 
                        FROM product p
                        LEFT JOIN category c ON p.CategoryID = c.CategoryID";
                $result = mysqli_query($conn, $sql);
            }
        }

        // Display products
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='product-card'>";

                if (!empty($row['ProductImage'])) {
                    echo "<img src='assets/img/products/" . htmlspecialchars($row['ProductImage']) . "' alt='" . htmlspecialchars($row['ProductName']) . "'>";
                } else {
                    echo "<img src='assets/img/default-product.jpg' alt='Default Product Image'>";
                }

                echo "<a href='index.php?page=page_productdetail&ProductID=" . $row['ProductID'] . "'>";
                echo "<h3>" . htmlspecialchars($row['ProductName']) . "</h3>";
                echo "</a>";

                echo "<p><strong>Giá:</strong> " . number_format($row['UnitPrice'], 0, ',', '.') . " VND</p>";
                echo "<p><strong>Tồn kho:</strong> " . $row['UnitsInStock'] . "</p>";
                echo "<p><strong>Trạng thái:</strong> " . ($row['Status'] == 1 ? 'Có sẵn' : 'Out of Stock') . "</p>";
                // echo "<p><strong>Danh mục:</strong> " . htmlspecialchars($row['CategoryName']) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No products available.</p>";
        }

        // Close database connection
        if (!empty($searchTerm)) {
            mysqli_stmt_close($stmt);
        }

        mysqli_close($conn);
        ?>
    </div>
</section>

<script>
    // JavaScript function to reload page with selected category filter
    function filterByCategory() {
        var categoryID = document.getElementById('category-select').value;
        var searchTerm = "<?php echo isset($searchTerm) ? $searchTerm : ''; ?>"; // Retain search term

        // Create the URL with category filter
        var url = new URL(window.location.href);
        url.searchParams.set('category', categoryID);
        url.searchParams.set('tim', searchTerm);

        // Redirect to the new URL
        window.location.href = url;
    }
</script>


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
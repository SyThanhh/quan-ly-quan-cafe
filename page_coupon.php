
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Đầu trang -->
    <?php
        include_once('./common/head/head.php');    
        include_once('./connect/database.php'); // Đường dẫn vào file kết nối database

        // Tạo một đối tượng Database để kết nối
        $database = new Database();
        $conn = $database->connect(); // Lấy kết nối
    ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="./assets/font/fontawesome-free-5.15.4-web/css/all.min.css">
    <style>
        .table>thead>tr>th{
            border: 2px solid black;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <!-- Thanh điều hướng dọc -->
        <?php include_once('./common/menu/siderbar.php'); ?>

        <!-- Giao diện trang -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Thanh điều hướng ngang -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <div class="col-3">
                        <span><i class="fas fa-bars"></i></span>
                    </div>
                    <div class="col-md-9 text-right">
                        <span><i class="fas fa-image"></i> Thanh Nguyen</span>
                    </div>
                </nav>

                <!--  Nội dung trang  -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="header text-left">
                                <h4>QUẢN LÝ CHƯƠNG TRÌNH KHUYẾN MÃI</h4>
                            </div>
                            
                            <div class="col-md-12 text-center">
                                <div class="row">
                                    <div class="col-md-6">
                                            
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button type="button" class="btn btn-primary btn-add">Thêm chương trình</button>
                                    </div>
                                </div>
                            </div>
                            </br>

                            <!-- Danh sách nhân viên -->
                            <div class="mt-7">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Mã Định Danh</th>
                                            <th>Mã Giảm Giá</th>
                                            <th>Ngày Bắt Đầu</th>
                                            <th>Ngày Kết Thúc</th>
                                            <th>Mô Tả</th>
                                            <th>Giảm Giá</th>
                                            <th>Trạng Thái</th>
                                            <th>Thời Điểm Cập Nhật Cuối Cùng</th>
                                            <th colspan="2">Thao Tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            // Truy vấn danh sách nhân viên
                                            $coupon = $database->select("SELECT * FROM coupon");

                                            // Hiển thị danh sách nhân viên
                                            if ($coupon) {
                                                while ($row = $coupon->fetch_assoc()) { // Sử dụng fetch_assoc() từ mysqli
                                                    echo "<tr>";
                                                    echo "<td style='border: 2px solid black'>{$row['CouponID']}</td>";
                                                    echo "<td style='border: 2px solid black'>{$row['CouponCode']}</td>";
                                                    echo "<td style='border: 2px solid black'>{$row['StartDate']}</td>";
                                                    echo "<td style='border: 2px solid black'>{$row['EndDate']}</td>";
                                                    echo "<td style='border: 2px solid black'>{$row['Description']}</td>";
                                                    echo "<td style='border: 2px solid black'>{$row['CouponDiscount']}</td>";
                                                    echo "<td style='border: 2px solid black'>{$row['Status']}</td>";
                                                    echo "<td style='border: 2px solid black'>{$row['UpdateAt']}</td>";
                                                    echo "<td style='border: 2px solid black'>
                                                        <button type='button' class='btn btn-success'>
                                                            <i class='fas fa-edit'></i>
                                                        </button>
                                                    </td>";
                                                    echo "<td style='border: 2px solid black'>
                                                        <button type='button' class='btn btn-danger'>
                                                            <i class='fas fa-trash'></i>
                                                        </button>
                                                    </td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='7' class='text-center'>Không có dữ liệu</td></tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-10"></div>
                                    <div class="col-2 text-right">
                                        <ul class="pagination">
                                            <li class="page-item disabled"><a class="page-link" href="#"><<</a></li>
                                            <li class="page-item disabled"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">>></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Cuối trang -->
            <?php include_once('./common/footer/footer.php'); ?>
        </div>   

    <!-- Bootstrap core JavaScript-->
    <?php include_once('./common/script/default.php'); ?>
</body>
</html>

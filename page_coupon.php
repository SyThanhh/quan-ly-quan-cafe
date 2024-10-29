<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script>
        function showSection(sectionId) {
            document.querySelectorAll('.content-section').forEach(section => {
                section.style.display = 'none';
            });
            document.getElementById(sectionId).style.display = 'block';
        }
    </script>
    <style>
        .btn {
            float: right;
            border: 1px solid black;
        }
        .pagination {
            float: right;
        }
        .table>thead>tr>th{
            border: 2px solid black;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 sidebar bg-dark text-white">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="index.php">ADMIN</a>
                        <hr class="bg-white">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#" onclick="showSection('home')"><i class="fa fa-home"></i> Trang chủ</a>
                        <hr class="bg-white">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#" onclick="showSection('staff')">Quản lý nhân viên</a>
                        <hr class="bg-white">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#" onclick="showSection('customer')">Quản lý khách hàng</a>
                        <hr class="bg-white">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#" onclick="showSection('invoice')">Quản lý hóa đơn</a>
                        <hr class="bg-white">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#" onclick="showSection('menu')">Quản lý menu</a>
                        <hr class="bg-white">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#" onclick="showSection('promotion')">Quản lý chương trình khuyến mãi</a>
                        <hr class="bg-white">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#" onclick="showSection('request')">Quản lý phiếu gửi yêu cầu</a>
                        <hr class="bg-white">
                    </li>
                </ul>
            </div>
            
            <div class="col-md-10">
                <nav class="navbar navbar-light bg-light justify-content-between">
                    <span><i class="fas fa-bars"></i></span>
                    <span><i class="fa-solid fa-image"></i> Thanh Nguyen</span>
                </nav>
                
                <div class="container mt-4">
                    <div id="home" class="content-section">
                        <h2>Trang chủ</h2>
                        <p>Chào mừng bạn đến với trang chủ.</p>
                    </div>

                    <div id="promotion" class="content-section" style="display: none;">
                        <button class="btn btn-lightgray mb-3 border-right" style='border: 2px solid black'>
                            <i class="fa-sharp fa-solid fa-square-plus"></i> Thêm Chương Trình
                        </button>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>CouponID</th>
                                    <th>CouponCode</th>
                                    <th>StartDate</th>
                                    <th>EndDate</th>
                                    <th>Description</th>
                                    <th>CouponDiscount</th>
                                    <th>Status</th>
                                    <th>UpdateAt</th>
                                    <th colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $servername = "localhost";
                                    $username = "Nguyen";
                                    $password = "123";
                                    $dbname = "db_ql3scoffee";

                                    $conn = new mysqli($servername, $username, $password, $dbname);

                                    if ($conn->connect_error) {
                                        die("Kết nối thất bại: " . $conn->connect_error);
                                    }

                                    $sql = "SELECT CouponID, CouponCode, StartDate, EndDate, Description, CouponDiscount, Status, UpdateAt FROM coupon";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($promo = $result->fetch_assoc()) {
                                            echo "<tr style='border: 2px solid black'>
                                                <td style='border: 2px solid black'>{$promo['CouponID']}</td>
                                                <td style='border: 2px solid black'>{$promo['CouponCode']}</td>
                                                <td style='border: 2px solid black'>{$promo['StartDate']}</td>
                                                <td style='border: 2px solid black'>{$promo['EndDate']}</td>
                                                <td style='border: 2px solid black'>{$promo['Description']}</td>
                                                <td style='border: 2px solid black'>{$promo['CouponDiscount']}</td>
                                                <td style='border: 2px solid black'>{$promo['Status']}</td>
                                                <td style='border: 2px solid black'>{$promo['UpdateAt']}</td>
                                                <td style='border: 2px solid black'>
                                                    <button class='btn btn-sm btn-success'><i class='fa fa-edit'></i></button>
                                                </td>
                                                <td>
                                                    <button class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></button>
                                                </td>
                                            </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='10'>Không có chương trình khuyến mãi nào</td></tr>";
                                    }

                                    $conn->close();
                                ?>
                            </tbody>
                        </table>
                        <ul class="pagination">
                            <li class="page-item disabled"><a class="page-link" href="#"><<</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">>></a></li>
                        </ul>
                    </div>
                    

                    <div id="staff" class="content-section" style="display: none;">
                        <h2>Quản lý nhân viên</h2>
                    </div>
                    <div id="customer" class="content-section" style="display: none;">
                        <h2>Quản lý khách hàng</h2>
                    </div>
                    <div id="invoice" class="content-section" style="display: none;">
                        <h2>Quản lý hóa đơn</h2>
                    </div>
                    <div id="menu" class="content-section" style="display: none;">
                        <h2>Quản lý menu</h2>
                    </div>
                    <div id="request" class="content-section" style="display: none;">
                        <h2>Quản lý phiếu gửi yêu cầu</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
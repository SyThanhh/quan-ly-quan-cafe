
<?php ?>
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
    <style>
        .table-custom {
        border: 2px solid black; /* Đặt độ dày của đường viền bảng */
    }

    .table-custom th,
    .table-custom td {
        border: 2px solid black; /* Đặt độ dày của đường viền cho từng ô */
    }

    .table-custom th {
        background-color: #f8f9fa; /* Tùy chọn: Thay đổi màu nền cho tiêu đề bảng */
    }
    input[type="text"],
    input[type="datetime-local"],
    select {
        width: 100%;
        padding: 8px; 
        margin: 5px 0;
        box-sizing: border-box; 
    }
    #search-form .btn-outline-secondary {
            border: 1px solid #ced4da;
            padding: 0.5rem 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
            margin-bottom: 5px;
            margin-top: 5px;
        }

        #search-form .search-button i {
            font-size: 0.75 rem;
            color: #495057;
        }

        #search-form .btn-outline-secondary:hover {
            background-color: #e2e6ea;
        }

        #name-search{
            width: 350px;
        }
            #search-form .btn-outline-secondary {
                width: 100%;
                border-radius: 6px;
        }
            /* Khi hover vào phần tử dropdown */
            .nav-item.dropdown:hover .dropdown-menu {
            display: block;  /* Hiển thị menu khi hover */
        }

        /* Mặc định ẩn menu dropdown */
        .dropdown-menu {
            display: none; /* Ẩn menu khi không hover */
        }

        /* Các hiệu ứng chuyển động */
        .dropdown-menu {
            transition: opacity 0.3s ease;  /* Thêm hiệu ứng mờ dần */
            opacity: 0;
        }

        /* Khi dropdown hiển thị */
        .nav-item.dropdown:hover .dropdown-menu {
            opacity: 1;  /* Hiển thị khi hover */
        }

    </style>
    <script>
        // Hàm để tự động cập nhật thời gian vào ô input
        function updateCurrentTime() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0'); // Tháng bắt đầu từ 0
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const dateTimeString = `${year}-${month}-${day}T${hours}:${minutes}`; // Lấy định dạng YYYY-MM-DDTHH:mm
            document.getElementById('ThoiDiemCapNhat').value = dateTimeString;
        }
    </script>
</head>

<body onload="updateCurrentTime()">
    <div id="wrapper">
        <!-- Thanh điều hướng dọc -->
        <?php include_once('./common/menu/siderbar.php'); ?>

        <!-- Giao diện trang -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Thanh điều hướng ngang -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                            aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small"
                                        placeholder="Search for..." aria-label="Search"
                                        aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>

                    <!-- Nav Item - Alerts -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell fa-fw"></i>
                            <!-- Counter - Alerts -->
                            <span class="badge badge-danger badge-counter">3+</span>
                        </a>
                        <!-- Dropdown - Alerts -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="alertsDropdown">
                            <h6 class="dropdown-header">
                                Alerts Center
                            </h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 12, 2019</div>
                                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-donate text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 7, 2019</div>
                                    $290.29 has been deposited into your account!
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-warning">
                                        <i class="fas fa-exclamation-triangle text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 2, 2019</div>
                                    Spending Alert: We've noticed unusually high spending for your account.
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                        </div>
                    </li>

                    <!-- Nav Item - Messages -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-envelope fa-fw"></i>
                            <!-- Counter - Messages -->
                            <span class="badge badge-danger badge-counter">7</span>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="messagesDropdown">
                            <h6 class="dropdown-header">
                                Message Center
                            </h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="img/undraw_profile_1.svg"
                                        alt="...">
                                    <div class="status-indicator bg-success"></div>
                                </div>
                                <div class="font-weight-bold">
                                    <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                        problem I've been having.</div>
                                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="img/undraw_profile_2.svg"
                                        alt="...">
                                    <div class="status-indicator"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">I have the photos that you ordered last month, how
                                        would you like them sent to you?</div>
                                    <div class="small text-gray-500">Jae Chun · 1d</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="img/undraw_profile_3.svg"
                                        alt="...">
                                    <div class="status-indicator bg-warning"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">Last month's report looks great, I am very happy with
                                        the progress so far, keep up the good work!</div>
                                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                        alt="...">
                                    <div class="status-indicator bg-success"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                        told me that people say this to all dogs, even if they aren't good...</div>
                                    <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                        </div>
                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <!-- Hiển thị tên người dùng từ session -->
                                <input type="text" id="employeeIdByRole" value="<?php echo htmlspecialchars($employeeID); ?>" hidden/>
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php
                                        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                            echo "Xin chào <b>".htmlspecialchars($_SESSION['username'])."</b>";
                                        } else {
                                            echo "Guest";
                                        }
                                    ?>
                                </span>
                                <img class="img-profile rounded-circle" src="./assets/img/testimonial-2.jpg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                               
                                <a class="dropdown-item" href="index.php?page=logout" >
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>
                </nav>

                <!-- Nội dung trang -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="header text-left">
                <h4>QUẢN LÝ CHƯƠNG TRÌNH KHUYẾN MÃI</h4>
            </div>
            <form method="POST" id="search-form" class="d-flex mb-3">
                <input type="text" class="form-control" name="txtSearch" id="name-search" 
                    placeholder="Tìm mã giảm giá theo tên"
                    value="<?php echo isset($_POST['txtSearch']) ? htmlspecialchars($_POST['txtSearch']) : ''; ?>">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary search-button" type="submit" name="btnSearch">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary search-button" type="submit" name="btnClear">
                        <i class="fas fa-eraser"></i>
                    </button>
                </div>
            </form>
    <?php
    include_once('./controller/cCoupon.php');
    $c = new cCoupon();

    // Xử lý tìm kiếm và nút xóa
    $searchKeyword = '';
    if (isset($_POST['btnSearch'])) {
        $searchKeyword = $_POST['txtSearch'];
    } elseif (isset($_POST['btnClear'])) {
        $searchKeyword = '';
    }

    // Xử lý phân trang
    $page = isset($_GET['page_number']) ? (int)$_GET['page_number'] : 1;
    $limit = 5;
    $offset = ($page - 1) * $limit;

    // Lấy dữ liệu mã giảm giá và tổng số trang
    $tbl = $c->listCoupon($searchKeyword, $limit, $offset);
    $totalPages = $c->getTotalPageCoupon($searchKeyword, $limit);

    if ($tbl):
    ?>
        <!-- <div style="text-align: right;">
            <button type="button" class="btn btn-primary btn-add mb-3" data-toggle="modal" data-target="#addCouponModal">
                <i class="fas fa-plus-square"></i> Thêm Mã Giảm Giá
            </button>
        </div> -->
        <table class="table table-bordered table-custom">
            <thead>
                <tr>
                    <th>Mã Giảm Giá</th>
                    <th>Ngày Bắt Đầu</th>
                    <th>Ngày Kết Thúc</th>
                    <th>Mô Tả</th>
                    <th>Giảm Giá</th>
                    <th>Trạng Thái</th>
                    <th>Thời Điểm Cập Nhật Cuối Cùng</th>
                    <!-- <th colspan="2">Điều chỉnh</th> -->
                </tr>
            </thead>
            <tbody>
                <?php while ($r = mysqli_fetch_assoc($tbl)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($r['CouponCode']); ?></td>
                        <td><?php echo htmlspecialchars($r['StartDate']); ?></td>
                        <td><?php echo htmlspecialchars($r['EndDate']); ?></td>
                        <td><?php echo htmlspecialchars($r['Description']); ?></td>
                        <td><?php echo number_format($r['CouponDiscount'], 0, ',', '.'); ?> %</td>
                        <td><?php echo ($r['Status'] == 1) ? 'Còn hạn sử dụng' : 'Hết hạn sử dụng'; ?></td>
                        <td><?php echo htmlspecialchars($r['UpdateAt']); ?></td>
                        <!-- <td>
                            <a href="index.php?page=page_update_coupon&CouponID=<?php echo $r['CouponID']; ?>" class="btn btn-success">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                        <td>
                            <a href="index.php?page=page_delete_coupon&CouponID=<?php echo $r['CouponID']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có thực sự muốn xóa mã giảm giá này không?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td> -->
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Phân trang -->
        <div class="row justify-content-end">
            <nav>
                <ul class="pagination">
                    <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                        <a class="page-link" href="index.php?page=page_coupon&page_number=<?php echo $page - 1; ?>&search=<?php echo urlencode($searchKeyword); ?>">
                            &laquo;
                        </a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                            <a class="page-link" href="index.php?page=page_coupon&page_number=<?php echo $i; ?>&search=<?php echo urlencode($searchKeyword); ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php if ($page >= $totalPages) echo 'disabled'; ?>">
                        <a class="page-link" href="index.php?page=page_coupon&page_number=<?php echo $page + 1; ?>&search=<?php echo urlencode($searchKeyword); ?>">
                            &raquo;
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    <?php elseif (!$tbl): ?>
        <p class="text-center">Không tìm thấy mã giảm giá nào phù hợp với từ khóa "<b><?php echo htmlspecialchars($searchKeyword); ?></b>".</p>
    <?php endif; ?>
</div>

        <div class="modal fade" id="addCouponModal" tabindex="-1" role="dialog" aria-labelledby="addCouponModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addCouponModalLabel">Thêm Chương Trình Khuyến Mãi</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="#" method="post" enctype="multipart/form-data">
                                    <table>
                                        <tr>
                                            <td>Mã Giảm Giá</td>
                                            <td>
                                                <input type="text" name="MaGiamGia" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ngày Bắt Đầu</td>
                                            <td><input type="datetime-local"  name="NgayBatDau" required></td>
                                        </tr>
                                        <tr>
                                            <td>Ngày Kết Thúc</td>
                                            <td><input type="datetime-local" name="NgayKetThuc"  required></td> 
                                        </tr>
                                        <tr>
                                            <td>Mô Tả</td>
                                            <td><input type="text" name="MoTa"  required></td> 
                                        </tr>
                                        <tr>
                                            <td>Giảm Giá</td>
                                            <td>
                                                <select name="GiamGia" id="GiamGia">
                                                    <option value="10.00">10.00</option>
                                                    <option value="15.00">15.00</option>
                                                    <option value="20.00">20.00</option>
                                                </select>
                                            </td> 
                                        </tr>
                                        <tr>
                                            <td>Trạng Thái</td>
                                            <td>
                                                <select name="TrangThai" id="TrangThai">
                                                    <option value="1">Hết hạn sử dụng</option>
                                                    <option value="0">Còn hạn sử dụng</option>
                                                </select>
                                            </td> 
                                        </tr>
                                        <tr>
                                            <td>Thời điểm cập nhật cuối cùng</td>
                                            <td>
                                                <input type="datetime-local" id="ThoiDiemCapNhat" name="ThoiDiemCapNhat" required readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>
                                                <input type="submit" name="btnInsert" class="btn btn-success" value="Thêm">
                                                <input type="reset" value="Nhập lại" class="btn btn-danger">
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                            <div class="modal-footer">
                            
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="updateCouponModal" tabindex="-1" role="dialog" aria-labelledby="updateCouponModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateCouponModalLabel">Cập Nhật Chương Trình Khuyến Mãi</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            <?php
                                include_once('./controller/cCoupon.php');
                                $p = new cCoupon();

                                if (isset($_GET['CouponID'])) {
                                    $CouponID = $_GET['CouponID'];
                                    $result = $p->get01CouponByID($CouponID);

                                    if ($result && $row = mysqli_fetch_assoc($result)) {
                                        echo json_encode($row);
                                    } else {
                                        echo json_encode(['error' => 'Không tìm thấy chương trình khuyến mãi']);
                                    }
                                }
                                ?>

                                <form action="#" method="post" enctype="multipart/form-data">
                                    <table>
                                        <input type="hidden" name="CouponID" id="modalCouponID" value="">
                                        <tr>
                                            <td>Mã Giảm Giá</td>
                                            <td>
                                                <input type="text" name="MaGiamGia" value="<?php if (isset($CouponCode)) echo $CouponCode; ?>" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ngày Bắt Đầu</td>
                                            <td><input type="datetime-local" name="NgayBatDau" value="<?php if (isset($StartDate)) echo $StartDate; ?>" required></td>
                                        </tr>
                                        <tr>
                                            <td>Ngày Kết Thúc</td>
                                            <td><input type="datetime-local" name="NgayKetThuc" value="<?php if (isset($EndDate)) echo $EndDate; ?>" required></td>
                                        </tr>
                                        <tr>
                                            <td>Mô Tả</td>
                                            <td><input type="text" name="MoTa" value="<?php if (isset($Description)) echo $Description; ?>" required></td>
                                        </tr>
                                        <tr>
                                            <td>Giảm Giá</td>
                                            <td>
                                                <select name="GiamGia" id="GiamGia">
                                                    <option value="10.00" <?php if (isset($CouponDiscount) && $CouponDiscount == "10.00") echo "selected"; ?>>10.00</option>
                                                    <option value="15.00" <?php if (isset($CouponDiscount) && $CouponDiscount == "15.00") echo "selected"; ?>>15.00</option>
                                                    <option value="20.00" <?php if (isset($CouponDiscount) && $CouponDiscount == "20.00") echo "selected"; ?>>20.00</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Trạng Thái</td>
                                            <td>
                                                <select name="TrangThai" id="TrangThai">
                                                    <option value="0" <?php if (isset($Status) && $Status == "0") echo "selected"; ?>>Hết hạn sử dụng</option>
                                                    <option value="1" <?php if (isset($Status) && $Status == "1") echo "selected"; ?>>Còn hạn sử dụng</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Thời điểm cập nhật cuối cùng</td>
                                            <td>
                                                <input type="datetime-local" id="ThoiDiemCapNhat" name="ThoiDiemCapNhat" value="<?php if (isset($UpDateAt)) echo $UpDateAt; ?>" required readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>
                                                <input type="submit" name="btnUpDate" class="btn btn-success" value="Cập nhật">
                                                <input type="reset" value="Nhập lại" class="btn btn-danger">
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                            <div class="modal-footer">
                            
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
    <?php
                                if(isset($_REQUEST["btnInsert"])){
                                    include_once('./controller/cCoupon.php');
                                    $p = new cCoupon();
                                    $currentDate = date('Y-m-d\TH:i');
                                    $StartDate = $_REQUEST['NgayBatDau'];
                                    $EndDate = $_REQUEST['NgayKetThuc'];
                                    if (strtotime($StartDate) < strtotime($currentDate)) {
                                        echo "<script>alert('Ngày bắt đầu phải lớn hơn hoặc bằng ngày hiện tại!')</script>";
                                    } elseif (strtotime($StartDate) >= strtotime($EndDate)) {
                                        echo "<script>alert('Ngày kết thúc phải lớn hơn ngày bắt đầu!')</script>";
                                    } else {
                                        $kq = $p->cInsertCp($_REQUEST['MaGiamGia'], $_REQUEST['NgayBatDau'], $_REQUEST['NgayKetThuc'], $_REQUEST['MoTa'], $_REQUEST['GiamGia'], $_REQUEST['TrangThai'], $_REQUEST['ThoiDiemCapNhat']);
                                        if ($kq) {
                                            echo '<script>
                                            alert("Thêm chương trình khuyến mãi thành công!");
                                            setTimeout(function(){
                                                window.location.href = "index.php?page=page_coupon";
                                            }, 500); // Chuyển hướng sau 0.5 giây
                                          </script>';
                                        } else {
                                            echo "<script>alert('Thêm thất bại!')</script>";
                                        }
                                    }
                                }
                                else if (isset($_REQUEST["btnUpDate"])) {
                                    include_once('./controller/cCoupon.php');
                                    $p = new cCoupon();
                                    $currentDate = date('Y-m-d\TH:i'); 
                                    if (strtotime($StartDate) < strtotime($currentDate)) {
                                        echo "<script>alert('Ngày bắt đầu phải lớn hơn hoặc bằng ngày hiện tại!')</script>";
                                    } elseif (strtotime($StartDate) >= strtotime($EndDate)) {
                                        echo "<script>alert('Ngày kết thúc phải lớn hơn ngày bắt đầu!')</script>";
                                    } else {
                                        $kq = $p->cUpdateCp($CouponID, $_REQUEST['MaGiamGia'], $_REQUEST['NgayBatDau'], $_REQUEST['NgayKetThuc'], $_REQUEST['MoTa'], $_REQUEST['GiamGia'], $_REQUEST['TrangThai'], $_REQUEST['ThoiDiemCapNhat']); 
                                        if ($kq) {
                                            echo "<script>alert('Cập nhật thành công!')</script>";
                                            header('refresh:0.5; url="index.php?page=page_coupon"');
                                            exit();
                                        } else {
                                            echo "<script>alert('Cập nhật thất bại!')</script>";
                                            header('refresh:0.5; url="index.php?page=page_coupon"');
                                            exit();
                                        }
                                    }
                                }
                            ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.edit-btn');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const CouponID = this.getAttribute('data-id');
                    document.getElementById('modalCouponID').value = CouponID;

                    // Gửi AJAX để lấy dữ liệu chương trình khuyến mãi
                    fetch(`page_coupon.php?CouponID=${CouponID}`)
                        .then(response => response.json())
                        .then(data => {
                            // Điền dữ liệu vào các trường trong modal
                            document.querySelector('#updateCouponModal input[name="MaGiamGia"]').value = data.CouponCode;
                            document.querySelector('#updateCouponModal input[name="NgayBatDau"]').value = data.StartDate;
                            document.querySelector('#updateCouponModal input[name="NgayKetThuc"]').value = data.EndDate;
                            document.querySelector('#updateCouponModal input[name="MoTa"]').value = data.Description;
                            document.querySelector('#updateCouponModal select[name="GiamGia"]').value = data.CouponDiscount;
                            document.querySelector('#updateCouponModal select[name="TrangThai"]').value = data.Status;
                            document.querySelector('#updateCouponModal input[name="ThoiDiemCapNhat"]').value = data.UpDateAt;
                        })
                        .catch(error => console.error('Lỗi khi tải dữ liệu:', error));
                });
            });
        });
        </script>

</body>
</html>

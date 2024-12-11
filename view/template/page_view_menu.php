
<?php
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php?page=login");
    exit();
}
?>
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

    .table-custom th{
        border: 2px solid black;
    }
    .table-custom td {
        border: 2px solid black;
    }

    .table-custom th {
        background-color: #f8f9fa;
        border: 2px solid black; /* Tùy chọn: Thay đổi màu nền cho tiêu đề bảng */
    }
    input[type="text"],
        input[type="datetime-local"],
        input[type="money"],
        input[type="int"],
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
            document.getElementById('ThoiGianTaoSanPham').value = dateTimeString;
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
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <!-- <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> -->

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                       

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
                            <a class="dropdown-item" href="index.php?page=page_profile">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Thông tin nhân viên
                            </a>
                            
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="index.php?page=logout">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Đăng xuất 
                            </a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <!--  Nội dung trang  -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>QUẢN LÝ MENU</h4>
                            <form method="POST" id="search-form" class="d-flex mb-3">
                                <input type="text" class="form-control" name="txtSearch" id="name-search" 
                                    placeholder="Tìm sản phẩm theo tên"
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
                            include_once('./controller/cMenu.php');
                            $p = new cProduct();
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

                            // Lấy dữ liệu sản phẩm và tổng số trang
                            $tbl = $p->listProduct($searchKeyword, $limit, $offset);
                            $totalPages = $p->getTotalPageProduct($searchKeyword, $limit);

                            if ($tbl):
                            ?>
                                <!-- <div style="text-align: right;">
                                    <button type="button" class="btn btn-primary btn-add mb-3" data-toggle="modal" data-target="#addMenuModal">
                                        <i class="fas fa-plus-square"></i> Thêm Món Trong Menu
                                    </button>
                                </div> -->
                                <table class="table table-bordered table-custom">
                                    <thead>
                                        <tr>
                                            <th>Mã Sản Phẩm</th>
                                            <th>Tên Sản Phẩm</th>
                                            <th>Giá Bán</th>
                                            <th>Hình Ảnh</th>
                                            <th>Số Lượng Tồn Kho</th>
                                            <th>Trạng Thái</th>
                                            <th>Mô Tả</th>
                                            <th>Loại Sản Phẩm</th>
                                            <!-- <th colspan="2">Điều chỉnh</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($r = mysqli_fetch_assoc($tbl)): ?>
                                            <tr>
                                                <td><?php echo $r['ProductID']; ?></td>
                                                <td><?php echo htmlspecialchars($r['ProductName']); ?></td>
                                                <td><?php echo number_format($r['UnitPrice'], 0, ',', '.'); ?> đ</td>
                                                <td>
                                                    <img src="assets/img/products/<?php echo $r['ProductImage']; ?>" width="100px">
                                                </td>
                                                <td><?php echo $r['UnitsInStock']; ?></td>
                                                <td><?php echo $r['Status'] == 1 ? 'Còn sản phẩm' : 'Hết sản phẩm'; ?></td>
                                                <td><?php echo htmlspecialchars($r['Description']); ?></td>
                                                <td><?php echo htmlspecialchars($r['CategoryName']); ?></td>
                                                <!-- <td>
                                                    <a href="index.php?page=page_update_menu&ProductID=<?php echo $r['ProductID']; ?>" class="btn btn-success">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="index.php?page=page_delete_menu&ProductID=<?php echo $r['ProductID']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có thực sự muốn xóa sản phẩm này không?')">
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
                                                <a class="page-link" href="index.php?page=page_view_menu&page_number=<?php echo $page - 1; ?>&search=<?php echo urlencode($searchKeyword); ?>">
                                                    &laquo;
                                                </a>
                                            </li>
                                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                                    <a class="page-link" href="index.php?page=page_view_menu&page_number=<?php echo $i; ?>&search=<?php echo urlencode($searchKeyword); ?>">
                                                        <?php echo $i; ?>
                                                    </a>
                                                </li>
                                            <?php endfor; ?>
                                            <li class="page-item <?php if ($page >= $totalPages) echo 'disabled'; ?>">
                                                <a class="page-link" href="index.php?page=page_view_menu&page_number=<?php echo $page + 1; ?>&search=<?php echo urlencode($searchKeyword); ?>">
                                                    &raquo;
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            <?php elseif(!$tbl):?>
                                <p class="text-center">Không tìm thấy sản phẩm nào phù hợp với từ khóa "<b><?php echo htmlspecialchars($searchKeyword); ?></b>".</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>


                            <div class="modal fade" id="addMenuModal" tabindex="-1" role="dialog" aria-labelledby="addMenuModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addMenuModalLabel">Thêm Món Trong Menu</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="#" method="post" enctype="multipart/form-data">
                                <table>
                                    <tr>
                                        <td>Mã Sản Phẩm</td>
                                        <td>
                                            <input type="text" name="MaSanPham" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tên Sản Phẩm</td>
                                        <td>
                                            <input type="text" name="TenSanPham" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Giá Bán</td>
                                        <td><input type="money"  name="GiaBan" required></td>
                                    </tr>
                                    <tr>
                                        <td>Hình Ảnh</td>
                                        <td><input type="file" name="HinhAnh"  required></td> 
                                    </tr>
                                    <tr>
                                        <td>Số Lượng Tồn Kho</td>
                                        <td><input type="int" name="SoLuongTonKho"  required></td> 
                                    </tr>
                                    <tr>
                                        <td>Trạng Thái</td>
                                        <td>
                                            <select name="TrangThai" id="TrangThai">
                                                <option value="1">Hết sản phẩm</option>
                                                <option value="0">Còn sản phẩm</option>
                                            </select>
                                        </td> 
                                    </tr>
                                    <tr>
                                        <td>Mô Tả</td>
                                        <td><input type="text"  name="MoTa" required></td>
                                    </tr>
                                    <tr>
                                        <td>Thời Gian Tạo Sản Phẩm</td>
                                        <td><input type="datetime-local"  name="ThoiGianTaoSanPham" id="ThoiGianTaoSanPham" required readonly></td>
                                    </tr>
                                    <tr>
                                        <td>Mã Yêu Cầu</td>
                                        <td><input type="int"  name="MaYeuCau" required></td>
                                    </tr>
                                    <tr>
                                        <td>Loại Sản Phẩm</td>
                                        <td>
                                            <?php
                                                include_once('controller/cCategory.php');
                                                $po = new cCategory();
                                                $tbl = $po -> getCategory();
                                                if($tbl){
                                                    echo '<select name="cboLoaiSP" id="">';
                                                    while($r = mysqli_fetch_assoc($tbl)){
                                                            echo '<option value='.$r["CategoryID"].'>'.$r["CategoryName"].'</option>';
                                                    }
                                                    echo '</select>';
                                                }
                                                else{
                                                    echo 'Lỗi kết nối!';
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Thời Điểm Cập Nhật Cuối Cùng</td>
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

                                <?php
                                    if (isset($_REQUEST["btnInsert"])) {
                                    include_once('controller/cMenu.php');
                                    $p = new cProduct();
                                    $kq = $p->cInsertMenu($_REQUEST['MaSanPham'],
                                                $_REQUEST['TenSanPham'],
                                                $_REQUEST['GiaBan'],
                                                $_FILES['HinhAnh'],
                                                $_REQUEST['SoLuongTonKho'],
                                                $_REQUEST['TrangThai'],
                                                $_REQUEST['MoTa'],
                                                $_REQUEST['ThoiGianTaoSanPham'],
                                                $_REQUEST['ThoiDiemCapNhat'],
                                                $_REQUEST['MaYeuCau'],
                                                $_REQUEST['cboLoaiSP']
                                            );
                                            
                                            if ($kq) {
                                                echo '<script>
                                                alert("Thêm món thành công!");
                                                setTimeout(function(){
                                                    window.location.href = "index.php?page=page_menu";
                                                }, 500); // Chuyển hướng sau 0.5 giây
                                              </script>';
                                            } else {
                                                echo "<script>alert('Thêm món thất bại!')</script>";
                                            }
                                        }
                                ?>
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

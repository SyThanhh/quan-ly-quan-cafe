<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Đầu trang -->
    <?php
        ob_start();
        include_once('./common/head/head.php');    
        include_once('./connect/database.php'); // Đường dẫn vào file kết nối database

        // Tạo một đối tượng Database để kết nối
        $database = new Database();
        $conn = $database->connect(); // Lấy kết nối
    ?>
    <style>
        .table>thead>tr>th {
            border: 2px solid black;
        }
        form {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
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
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                            <img class="img-profile rounded-circle"
                                src="img/undraw_profile.svg">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Settings
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                Activity Log
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="index.php?page=logout">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>

                    </ul>
                </nav>

                <!--  Nội dung trang  -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="header text-left">
                                <h4>THÊM MÓN TRONG MENU</h4>
                            </div>
                            
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
                                                echo "<script>alert('Thêm thành công!')</script>";
                                                header('refresh:0.5; url="index.php?page=page_menu"');
                                                exit();
                                            } else {
                                                echo "<script>alert('Thêm thất bại!')</script>";
                                                //header('refresh:0.5; url="index.php?page=page_menu"');
                                                exit();
                                            }
                                        }
                                ?>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Cuối trang -->
        <?php include_once('./common/footer/footer.php'); ob_end_flush();?>
    </div> 

    <!-- Bootstrap core JavaScript-->
    <?php include_once('./common/script/default.php'); ?>
</body>
</html>

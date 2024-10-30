<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Đầu trang -->
    <?php
        include_once('./common/head/head.php');    
        include_once('./connect/ddatabase.php'); // Đường dẫn vào file kết nối database

        // Tạo một đối tượng Database để kết nối
        $database = new Database();
        $conn = $database->connect(); // Lấy kết nối
    ?>
    <link rel="stylesheet" href="./assets/css/page_employee.css">
</head>

<body>
    <div id="wrapper">
        <!-- Thanh điều hướng dọc -->
        <?php include_once('./common/menu/siderbar.php'); ?>

        <!-- Giao giện trang -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Thanh điều hướng ngang -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    Này tính sau nha hihi
                </nav>

                <!--  Nội dung trang  -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="header text-left">
                                <h4>QUẢN LÝ THÔNG TIN NHÂN VIÊN</h4>
                            </div>
                            
                            <div class="col-md-12 text-center">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="name-search" placeholder="Tìm nhân viên theo tên">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary search-button m-0" type="button">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button type="button" class="btn btn-primary btn-add">Thêm nhân viên mới</button>
                                    </div>
                                </div>
                            </div>
                            </br>

                            <!-- Danh sách nhân viên -->
                            <div class="mt-7">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Mã</th>
                                            <th>Tên</th>
                                            <th>Họ</th>
                                            <th>Email</th>
                                            <th>Số điện thoại</th>
                                            <th>Vai trò</th>
                                            <th>Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            // Truy vấn danh sách nhân viên
                                            $employees = $database->select("SELECT * FROM employee");

                                            // Hiển thị danh sách nhân viên
                                            if ($employees) {
                                                while ($row = $employees->fetch_assoc()) { // Sử dụng fetch_assoc() từ mysqli
                                                    echo "<tr>";
                                                    echo "<td>{$row['EmployeeID']}</td>";
                                                    echo "<td>{$row['FirstName']}</td>";
                                                    echo "<td>{$row['LastName']}</td>";
                                                    echo "<td>{$row['Email']}</td>";
                                                    echo "<td>{$row['PhoneNumber']}</td>";
                                                    echo "<td>{$row['Roles']}</td>";
                                                    echo "<td>{$row['Status']}</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='7' class='text-center'>Không có dữ liệu</td></tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
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

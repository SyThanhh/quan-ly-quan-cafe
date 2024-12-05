<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Đầu trang -->
    <?php
        include_once('./common/head/head.php');    
        include_once('./connect/database.php'); // Đường dẫn vào file kết nối database

        // Tạo một đối tượng Database để kết nối
        $database = new Database();
        $conn = $database->connect(); // Lấy kết nối

        // Xử lý cập nhật trạng thái nhân viên
        if (isset($_GET['action']) && $_GET['action'] == 'update_status' && isset($_GET['id'])) {
            $employeeID = $_GET['id'];
            $updateQuery = "UPDATE employee SET Status = 0 WHERE EmployeeID = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("i", $employeeID);
            if ($stmt->execute()) {
                echo "<script>alert('Cập nhật trạng thái nhân viên thành công!'); window.location.href = 'index.php?page=page_employee';</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra khi cập nhật trạng thái nhân viên!'); window.location.href = 'index.php?page=page_employee';</script>";
            }
        }
    ?>
    <link rel="stylesheet" href="./assets/css/employee_shift.css">
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
                    <!-- ... (phần code cho thanh điều hướng ngang) ... -->
                </nav>

                <!--  Nội dung trang  -->
                <?php
                // Kiểm tra nếu có tìm kiếm
                $searchKeyword = isset($_POST['name-search']) ? $_POST['name-search'] : '';

                // Số bản ghi trên mỗi trang
                $recordsPerPage = 5;

                // Tính tổng số bản ghi
                $totalRecordsQuery = "SELECT COUNT(*) as total FROM employee WHERE Roles > 1";
                if ($searchKeyword !== '') {
                    $totalRecordsQuery .= " AND (FirstName LIKE '%$searchKeyword%' OR LastName LIKE '%$searchKeyword%')";
                }
                $totalRecordsResult = $database->select($totalRecordsQuery);
                $totalRecords = $totalRecordsResult->fetch_assoc()['total'];

                // Tính tổng số trang
                $totalPages = ceil($totalRecords / $recordsPerPage);

                // Lấy trang hiện tại từ URL, mặc định là trang 1
                $page = isset($_GET['page_number']) ? (int)$_GET['page_number'] : 1;
                $page = ($page > $totalPages) ? $totalPages : $page;
                $page = ($page < 1) ? 1 : $page;

                // Tính offset để lấy dữ liệu
                $offset = ($page - 1) * $recordsPerPage;

                // Truy vấn danh sách nhân viên với phân trang và tìm kiếm
                $query = "SELECT * FROM employee WHERE Roles > 1";
                if ($searchKeyword !== '') {
                    $query .= " AND (FirstName LIKE '%$searchKeyword%' OR LastName LIKE '%$searchKeyword%')";
                }
                $query .= " LIMIT $offset, $recordsPerPage";
                $employees = $database->select($query);
                ?>

                <!-- Các nút và danh sách nhân viên -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="header text-left">
                                <h4>QUẢN LÝ THÔNG TIN NHÂN VIÊN</h4>
                            </div>
                            
                            <div class="col-md-12 text-center">
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- Form tìm kiếm nhân viên theo tên -->
                                        <form method="post" action="">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="name-search" placeholder="Tìm nhân viên theo tên" 
                                                    value="<?php echo htmlspecialchars($searchKeyword); ?>">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary search-button m-0" type="submit">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <a class="btn btn-primary btn-add" style="color:white" href="index.php?page=page_add_employee">
                                            <i class="fas fa-plus"></i> &nbsp; Thêm nhân viên mới
                                        </a>
                                    </div>
                                </div>
                            </div>
                            </br>

                            <!-- Danh sách nhân viên -->
                            <div class="mt-8">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Mã</th>
                                            <th>Họ</th>
                                            <th>Tên</th>
                                            <th>Email</th>
                                            <th>Số điện thoại</th>
                                            <th>Vị trí làm việc</th>
                                            <th>Trạng thái</th>
                                            <th colspan='2'>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Hiển thị danh sách nhân viên
                                        if ($employees) {
                                            while ($row = $employees->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>{$row['EmployeeID']}</td>";
                                                echo "<td>{$row['FirstName']}</td>";
                                                echo "<td>{$row['LastName']}</td>";
                                                echo "<td>{$row['Email']}</td>";
                                                echo "<td>{$row['PhoneNumber']}</td>";
                                                // Hiển thị vị trí làm việc
                                                $role = '';
                                                if ($row['Roles'] == 2) $role = "Nhân viên đứng quầy";
                                                elseif ($row['Roles'] == 3) $role = "Nhân viên kế toán";
                                                elseif ($row['Roles'] == 4) $role = "Nhân viên pha chế";
                                                echo "<td>{$role}</td>";
                                                // Hiển thị trạng thái
                                                $status = ($row['Status'] == 1) ? "Đang làm việc" : "Đã nghỉ việc";
                                                echo "<td>{$status}</td>";
                                                echo "<td>
                                                    <a href='index.php?page=page_update_employee&id={$row['EmployeeID']}' class='btn btn-success' style='color:white'>
                                                        <i class='fas fa-edit'></i>
                                                    </a>
                                                </td>
                                                <td>";
                                                if ($row['Status'] == 1) {
                                                    echo "<button type='button' class='btn btn-danger' onclick='confirmDelete({$row['EmployeeID']})'>
                                                        <i class='fas fa-user-times'></i>
                                                    </button>";
                                                }
                                                echo "</td></tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='9' class='text-center'>Không có dữ liệu</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>

                                <!-- Phân trang -->
                                <div class="row justify-content-end mr-1">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">
                                            <!-- Nút Previous -->
                                            <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                                                <a class="page-link" href="index.php?page=page_employee&page_number=<?php echo ($page > 1) ? $page - 1 : 1; ?>&search=<?php echo urlencode($searchKeyword); ?>" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>

                                            <!-- Các trang số -->
                                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                                    <a class="page-link" href="index.php?page=page_employee&page_number=<?php echo $i; ?>&search=<?php echo urlencode($searchKeyword); ?>">
                                                        <?php echo $i; ?>
                                                    </a>
                                                </li>
                                            <?php endfor; ?>

                                            <!-- Nút Next -->
                                            <li class="page-item <?php if ($page >= $totalPages) echo 'disabled'; ?>">
                                                <a class="page-link" href="index.php?page=page_employee&page_number=<?php echo ($page < $totalPages) ? $page + 1 : $totalPages; ?>&search=<?php echo urlencode($searchKeyword); ?>" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Cuối trang -->
            <?php include_once('./common/footer/footer.php'); ?>
        </div>    
        
    <!-- Modal xác nhận xóa -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteLabel">Xác nhận xóa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa nhân viên không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <a href="#" class="btn btn-danger" id="confirmDeleteButton" onclick="updateEmployeeStatus()">Xác nhận</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        var employeeIDToUpdate;  // Biến toàn cục lưu ID nhân viên cần cập nhật

        // Hàm mở modal xác nhận cập nhật trạng thái
        function confirmDelete(employeeID) {
            // Lưu ID của nhân viên vào biến
            employeeIDToUpdate = employeeID;
            
            // Hiển thị modal
            $('#confirmDeleteModal').modal('show');
        }

        // Hàm cập nhật trạng thái nhân viên
        function updateEmployeeStatus() {
            // Gửi yêu cầu cập nhật trạng thái nhân viên
            window.location.href = 'index.php?page=page_employee&action=update_status&id=' + employeeIDToUpdate;
        }
    </script>

    <!-- Bootstrap core JavaScript-->
    <?php include_once('./common/script/default.php'); ?>
</body>
</html>


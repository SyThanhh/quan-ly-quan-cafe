<?php
    // session_start();
    include_once('./common/head/head.php');   
    include_once('./controller/CustomerController.php'); // Đường dẫn vào file kết nối database
    $customerControler = new CustomerController();

    // Xử lý khi có yêu cầu POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['search'])) {
            $_SESSION['searchKeyword'] = $_POST['search']; // Lưu từ khóa tìm kiếm vào session
        } elseif (isset($_POST['clear'])) {
            unset($_SESSION['searchKeyword']); // Xóa từ khóa tìm kiếm
        }
    }

    
    // Lấy từ khóa tìm kiếm từ session nếu có
    $searchKeyword = isset($_POST['search']) ? $_POST['search'] : '';

    // Xử lý phân trang
    $page = isset($_GET['page_number']) ? (int)$_GET['page_number'] : 1;
    $limit = 5;
    $offset = ($page - 1) * $limit;
    
    // Lấy dữ liệu từ model
    $customers = $customerControler->listCustomers($searchKeyword, $limit, $offset);
    $totalPages  = $customerControler->getTotalPages($searchKeyword, $limit);
    
    

?>

<div class="col-md-12 text-center">
    <div class="row">
        <div class="col-md-6">
            <!-- Form tìm kiếm -->
            <form method="POST" id="search-form" class="d-flex">
                <input type="text" class="form-control" name="search" id="name-search" placeholder="Tìm khách hàng theo tên / số điện thoại" value="<?php echo htmlspecialchars($searchKeyword); ?>">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary search-button" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary search-button" id="btn-clear">
                        <i class="fas fa-eraser"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-6 text-right">
            <button type="button" class="btn btn-primary btn-add" data-toggle="modal" data-target="#addCustomerModal" style="border: none;
    background: #683c08bf;">
                <i class="fas fa-plus-square"></i> Thêm Mới Khách hàng
            </button>
        </div>
    </div>
</div>
</br>

<!-- Danh sách khách hàng -->
<table class="table">
    <thead style="border: none;
    background: #683c08bf;">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Tên</th>
            <th scope="col">Số Điện thoại</th>
            <th scope="col">Email</th>
            <th scope="col">Điểm tích lũy</th>
            <th scope="col">Thời gian tạo</th>
            <th colspan='2' class="">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($customers && is_array($customers)) {
            foreach ($customers as $row) {
                echo "<tr data-id='{$row['CustomerID']}'>";
                echo "<td data-label='ID'>{$row['CustomerID']}</td>";
                echo "<td data-label='Tên' class='customerName'>{$row['CustomerName']}</td>";
                echo "<td data-label='Số Điện thoại' class='customerPhone'>{$row['CustomerPhone']}</td>";
                echo "<td data-label='Email' class='customerEmail'>{$row['Email']}</td>";
                echo "<td data-label='Điểm tích lũy'>{$row['CustomerPoint']}</td>";
                echo "<td data-label='Thời gian tạo'>{$row['CreateAt']}</td>";
                echo "<td data-label='Thao tác'>
                        <button type='button' class='btn btn-success edit-btn'>
                            <i class='fas fa-edit'></i>
                        </button>
                    </td>";
                echo "<td data-label='Thao tác'>
                        <button type='button' class='btn btn-danger delete-btn'>
                            <i class='fas fa-minus-square'></i>
                        </button>
                    </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8' class='text-center'>Không có khách hàng nào</td></tr>";
        }
        
        ?>
    </tbody>
</table>

<!-- Phân trang -->
<div class="row justify-content-end mr-1">
    <nav aria-label="Page navigation example" >
        <ul class="pagination">
            <!-- Nút Previous -->
            <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                <a class="page-link" href="index.php?page=page_customer&page_number=<?php echo ($page > 1) ? $page - 1 : 1; ?><?php echo isset($searchKeyword) && $searchKeyword !== '' ? '&search='.htmlspecialchars($searchKeyword) : ''; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <!-- Các trang số -->
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="index.php?page=page_customer&page_number=<?php echo $i; ?><?php echo isset($searchKeyword) && $searchKeyword !== '' ? '&search='.htmlspecialchars($searchKeyword) : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Nút Next -->
            <li class="page-item <?php if ($page >= $totalPages) echo 'disabled'; ?>">
                <a class="page-link" href="index.php?page=page_customer&page_number=<?php echo ($page < $totalPages) ? $page + 1 : $totalPages; ?><?php echo isset($searchKeyword) && $searchKeyword !== '' ? '&search='.htmlspecialchars($searchKeyword) : ''; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>

</div>

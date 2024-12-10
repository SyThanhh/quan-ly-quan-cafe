<?php
    include_once('./common/head/head.php');   
    include_once('./controller/OrderController.php'); // Đường dẫn vào file kết nối database

    $orderController = new OrderController(); 

    $fromDate = '';
    $toDate = '';
    $orders = [];
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fromDate = isset($_POST['from-date']) ? $_POST['from-date'] : '';
        $toDate = isset($_POST['to-date']) ? $_POST['to-date'] : '';
    
        $_SESSION['from-date'] = $fromDate;
        $_SESSION['to-date'] = $toDate;
    
        if (!empty($fromDate) || !empty($toDate)) {
            $orders = $orderController->getAllOrders($fromDate, $toDate);
        } else {
            $orders = $orderController->getAllOrders("", ""); 
        }
    } elseif (isset($_POST['clear'])) {
        unset($_SESSION['from-date']); 
        unset($_SESSION['to-date']);
        $fromDate = '';
        $toDate = '';
        $orders = $orderController->getAllOrders("", "");
    } else {
        $fromDate = isset($_SESSION['from-date']) ? $_SESSION['from-date'] : '';
        $toDate = isset($_SESSION['to-date']) ? $_SESSION['to-date'] : '';
        $orders = $orderController->getAllOrders($fromDate, $toDate);
    }

    $page = isset($_GET['page_number']) ? (int)$_GET['page_number'] : 1;
    $limit = 5;
    $offset = ($page - 1) * $limit;

    // Lấy dữ liệu từ model
  
    $orders = $orderController->listOrders($fromDate, $toDate, $limit, $offset);
    $totalPages  = $orderController->getTotalPages($fromDate ,$toDate, $limit);
    
    
?>
<div class="col-md-12 text-center">
<div class="row">
    <div class="col-md-6">
        <div class="input-group" style="width:55%;">
            <div class="filter-container">
                <form class="d-flex" id="filter-date" method="post">
                    <div class="date-input mr-2">
                        <label for="from-date">Từ ngày:</label>
                        <input type="date" id="from-date" name="from-date" placeholder="mm/dd/yyyy" value="<?php echo isset($_SESSION['from-date']) ? $_SESSION['from-date'] : ''; ?>" required>
                    </div>
                    <div class="date-input mr-2">
                        <label for="to-date">Đến ngày:</label>
                        <input type="date" id="to-date" name="to-date" placeholder="mm/dd/yyyy" value="<?php echo isset($_SESSION['to-date']) ? $_SESSION['to-date'] : ''; ?>" >
                    </div>
                    <button class="filter-button mr-2" id="btn-filter" type="submit">Lọc</button>
                    <button class="btn filter-button btn-light" id="btn-clear">
                        <i class="fas fa-eraser"></i>
                    </button>
                </form>
            </div>

        
        </div>
    </div>
</div>
</div>
</br>

<!-- Danh sách nhân viên -->
<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Tên Khách hàng</th> 
            <!-- <th scope="col">Tên Khách hàng</th>-->
            <th scope="col">Ngày tạo</th>
            <th scope="col">Giảm giá</th>
            <th scope="col">Hình thức thanh toán</th>
            <th scope="col">Tổng tiền</th>
            <th scope="col">Trạng thái</th>
            <th scope="col">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php
        
        
            // Hiển thị danh sách nhân viên
            if (!empty($orders) && is_array($orders)) {
                foreach ($orders as $row) {
                    echo "<tr>";
                    echo "<td>{$row['OrderID']}</td>";
                    echo "<td>{$row['CustomerName']}</td>";
                    // echo "<td>{$row['FirstName']} {$row['LastName']}</td>"; // Nếu có trường này, hãy bỏ comment khi cần thiết
                    echo "<td>{$row['CreateDate']}</td>";
                    echo "<td>{$row['CouponDiscount']} <span>%</span></td>";
                    echo "<td>{$row['PaymentMethod']}</td>";
                    echo "<td>{$row['TotalAmount']} <span>đ</span> </td>";
                    echo "<td>";
                    if ($row['Status']) {
                        echo "<span class='badge badge-success'>Đã thanh toán</span>";
                    } else {
                        echo "<span class='badge badge-danger'>Chưa thanh toán</span>";
                    }
                    echo "</td>";
                    echo "<td><a href='index.php?page=page_viewOrderDetail&OrderID={$row['OrderID']}' class='btn btn-primary btn-sm view-invoice'>Xem chi tiết</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9' class='text-center text-danger'>Không có dữ liệu</td></tr>";
            }
            
        ?>
    </tbody>
</table>
<div class="row justify-content-end mr-1">
<nav aria-label="Page navigation example">
        <ul class="pagination">
            <!-- Nút Previous -->
            <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                <a class="page-link" href="index.php?page=page_viewOrder&page_number=<?php echo ($page > 1) ? $page - 1 : 1; ?><?php echo isset($searchKeyword) && $searchKeyword !== '' ? '&search='.htmlspecialchars($searchKeyword) : ''; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <!-- Các trang số -->
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="index.php?page=page_viewOrder&page_number=<?php echo $i; ?><?php echo isset($searchKeyword) && $searchKeyword !== '' ? '&search='.htmlspecialchars($searchKeyword) : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Nút Next -->
            <li class="page-item <?php if ($page >= $totalPages) echo 'disabled'; ?>">
                <a class="page-link" href="index.php?page=page_viewOrder&page_number=<?php echo ($page < $totalPages) ? $page + 1 : $totalPages; ?><?php echo isset($searchKeyword) && $searchKeyword !== '' ? '&search='.htmlspecialchars($searchKeyword) : ''; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>


</div>
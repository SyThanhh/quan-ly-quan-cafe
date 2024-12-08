<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
</head>
<body>
    <h1>Product List</h1>

    <!-- Form tìm kiếm -->
    <form method="GET" action="index.php">
        <input type="hidden" name="page" value="page_customer">
        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search products">
        <button type="submit">Search</button>
    </form>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
        </tr>
        <?php if (is_array($customers)): ?>
            <?php foreach ($customers as $customer): ?>
            <tr>
                <td><?php echo htmlspecialchars($customer['CustomerID']); ?></td>
                <td><?php echo htmlspecialchars($customer['CustomerName']); ?></td>
              
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No customers found.</td>
            </tr>
        <?php endif; ?>
    </table>

    <!-- Phân trang -->
    <div>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="index.php?page=page_customer&page_number=<?php echo $i; ?>&search=<?php echo $search; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
        <?php
        $page = isset($_GET['page_number']) ? (int)$_GET['page_number'] : 1; // Đảm bảo $page có giá trị hợp lệ
        ?>
<nav aria-label="Page navigation example">
    <ul class="pagination">
        <!-- Nút Previous -->
        <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
            <a class="page-link" href="index.php?page=page_customer&page_number=<?php echo ($page > 1) ? $page - 1 : 1; ?>&search=<?php echo htmlspecialchars($search); ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>

        <!-- Các trang số -->
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                <a class="page-link" href="index.php?page=page_customer&page_number=<?php echo $i; ?>&search=<?php echo htmlspecialchars($search); ?>">
                    <?php echo $i; ?>
                </a>
            </li>
        <?php endfor; ?>

        <!-- Nút Next -->
        <li class="page-item <?php if ($page >= $totalPages) echo 'disabled'; ?>">
            <a class="page-link" href="index.php?page=page_customer&page_number=<?php echo ($page < $totalPages) ? $page + 1 : $totalPages; ?>&search=<?php echo htmlspecialchars($search); ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>




    </div>
</body>
</html>
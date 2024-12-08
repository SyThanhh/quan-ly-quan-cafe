<?php
ob_start(); // Bắt đầu output buffering

// Giả sử chúng ta đã có session start và kết nối database ở đây
include_once('./connect/database.php');
$database = new Database();
$conn = $database->connect();

// // Hàm kiểm tra vai trò của người dùng
// function getUserRole($conn, $username) {
//     $stmt = $conn->prepare("SELECT Roles FROM employee WHERE Lastname = ?");
//     $stmt->bind_param("s", $username);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     if ($row = $result->fetch_assoc()) {
//         return $row['Roles'];
//     }
//     return null;
// }

// Lấy vai trò của người dùng hiện tại
$userRole = $_SESSION['role'];

// Định nghĩa các trang được phép truy cập cho mỗi vai trò
$allowedPages = [
    1 => ['all'],
    2 => ['page_view_shift', 'page_view_coupon', 'page_view_menu', 'page_sell'],
    3 => ['page_view_shift', 'page_viewOrder', 'page_manage'],
    4 => ['page_view_shift', 'page_import_request']
];

$restrictedPagesForAdmin = ['page_view_shift', 'page_view_menu', 'page_view_coupon'];

function isPageAllowed($page, $userRole, $allowedPages) {
    global $restrictedPagesForAdmin; // Sử dụng biến toàn cục
    if ($userRole == 1) {
        // Admin không được truy cập các trang trong danh sách cấm
        return !in_array($page, $restrictedPagesForAdmin);
    }
    // Kiểm tra quyền truy cập với các role khác
    return in_array($page, $allowedPages[$userRole]);
}
?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php?page=index_admin">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">3S Admin <sup></sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.php?page=index_admin">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Trang chủ</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <?php if (isPageAllowed('page_view_shift', $userRole, $allowedPages)): ?>
    <!-- Nav Item - Xem lịch làm việc -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="index.php?page=page_view_shift">
            <i class="fas fa-id-badge"></i>
            <span>Xem lịch làm việc</span>
        </a>
    </li>
    <?php endif; ?>

    <?php if (isPageAllowed('page_sell', $userRole, $allowedPages)): ?>
    <!-- Nav Item - Bán hàng -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="index.php?page=page_sell">
            <i class="fas fa-money-bill-wave"></i>
            <span>Bán hàng</span>
        </a>
    </li>
    <?php endif; ?>

    <?php if ($userRole == 1): // Chỉ admin mới có quyền quản lý khách hàng ?>
    <!-- Nav Item - Quản lý khách hàng -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manageCustomer"
            aria-expanded="true" aria-controls="manageCustomer">
            <i class="fas fa-users"></i>
            <span>Quản lý khách hàng</span>
        </a>
        <div id="manageCustomer" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="index.php?page=page_customer">Xem thông tin</a>
                <a class="collapse-item" href="index.php?page=page_statisticalCustomer">Thống kê thông tin</a>
            </div>
        </div>
    </li>
    <?php endif; ?>

    <?php if ($userRole == 1): // Chỉ admin mới có quyền quản lý nhân viên ?>
    <!-- Nav Item - Quản lý nhân viên -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manageEmployee"
            aria-expanded="true" aria-controls="manageEmployee">
            <i class="fas fa-id-badge"></i>
            <span>Quản lý nhân viên</span>
        </a>
        <div id="manageEmployee" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="index.php?page=page_employee">Quản lý thông tin nhân viên</a>
                <a class="collapse-item" href="index.php?page=page_shift">Quản lý lịch làm việc</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Cập nhật vị trí nhân viên -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="index.php?page=page_roles">
            <i class="fas fa-id-badge"></i>
            <span>Cập nhật vị trí nhân viên</span>
        </a>
    </li>
    <?php endif; ?>

    <?php if (isPageAllowed('page_viewOrder', $userRole, $allowedPages)): ?>
    <!-- Nav Item - Quản lý hóa đơn -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="index.php?page=page_viewOrder">
            <i class="fas fa-receipt"></i>
            <span>Quản lý hóa đơn</span>
        </a>
    </li>
    <?php endif; ?>

    <?php if (isPageAllowed('page_view_menu', $userRole, $allowedPages)): ?>
    <!-- Nav Item - Xem menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="index.php?page=page_view_menu">
            <i class="fas fa-book"></i>
            <span>Xem menu</span>
        </a>
    </li>
    <?php endif; ?>

    <?php if (isPageAllowed('page_menu', $userRole, $allowedPages)): ?>
    <!-- Nav Item - Quản lý menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manageMenu"
            aria-expanded="true" aria-controls="manageMenu">
            <i class="fas fa-book"></i>
            <span>Quản lý menu</span>
        </a>
        <div id="manageMenu" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="index.php?page=page_menu">Quản lý menu</a>
            </div>
        </div>
    </li>
    <?php endif; ?>

    <?php if (isPageAllowed('page_view_coupon', $userRole, $allowedPages)): ?>
    <!-- Nav Item - Xem khuyến mãi -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="index.php?page=page_view_coupon">
            <i class="fas fa-ticket-alt"></i>
            <span>Xem khuyến mãi</span>
        </a>
    </li>
    <?php endif; ?>

    <?php if (isPageAllowed('page_coupon', $userRole, $allowedPages)): ?>
    <!-- Nav Item - Quản lý khuyến mãi -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manageCoupon"
            aria-expanded="true" aria-controls="manageCoupon">
            <i class="fas fa-ticket-alt"></i>
            <span>Quản lý khuyến mãi</span>
        </a>
        <div id="manageCoupon" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="index.php?page=page_coupon">Quản lý khuyến mãi</a>
            </div>
        </div>
    </li>
    <?php endif; ?>

    <?php if (isPageAllowed('page_import_request', $userRole, $allowedPages)): ?>
    <!-- Nav Item - Gửi yêu cầu nhập hàng -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="index.php?page=page_import_request">
            <i class="fas fa-file-alt"></i> 
            <span>Gửi yêu cầu nhập hàng</span>
        </a>
    </li>
    <?php endif; ?>

    <?php if (isPageAllowed('page_requestform', $userRole, $allowedPages)): ?>
    <!-- Nav Item - Quản lý phiếu gửi yêu cầu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manageRequest"
            aria-expanded="true" aria-controls="manageRequest">
            <i class="fas fa-file-alt"></i>
            <span>Quản lý phiếu gửi yêu cầu</span>
        </a>
        <div id="manageRequest" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <?php if ($userRole == 1): ?>
                <a class="collapse-item" href="index.php?page=page_requestform">Quản lý phiếu</a>
                <?php endif; ?>
            </div>
        </div>
    </li>
    <?php endif; ?>

    <?php if (isPageAllowed('page_manage', $userRole, $allowedPages)): ?>
    <!-- Nav Item - Thống kê doanh thu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manageStatistical"
            aria-expanded="true" aria-controls="manageStatistical">
            <i class="fas fa-chart-bar"></i>
            <span>Thống kê doanh thu</span>
        </a>
        <div id="manageStatistical" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="index.php?page=page_manage">Thống kê</a>
            </div>
        </div>
    </li>
    <?php endif; ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<?php
ob_end_flush(); // Kết thúc output buffering
?>
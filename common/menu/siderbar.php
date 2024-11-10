<?php
ob_start(); // Bắt đầu output buffering
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
        <span>Trang chủ</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Interface
</div>



<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-money-bill-wave"></i>
        <span>Bán hàng</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Components:</h6>
            <a class="collapse-item" href="index.php?page=page_sell">Bán hàng</a>
        </div>
    </div>
</li>


<!-- Nav Item - Utilities Collapse Menu -->



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
            <a class="collapse-item" href="index.php?page=page_statisticalCustomer">Thống kê thông kê</a>

        </div>
    </div>
</li>

  <!-- Nav Item - Utilities Collapse Menu -->
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

<li class="nav-item">
    <a class="nav-link collapsed" href="index.php?page=page_roles">
        <i class="fas fa-id-badge"></i>
        <span>Cập nhật vị trí nhân viên</span>
    </a>
</li>

  <!-- Nav Item - Utilities Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manageOrder"
        aria-expanded="true" aria-controls="manageOrder">
        <i class="fas fa-receipt"></i>
        <span>Quản lý hóa đơn</span>
    </a>
    <div id="manageOrder" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <!-- <h6 class="collapse-header">Custom Utilities:</h6> -->
            <a class="collapse-item" href="index.php?page=page_viewOrder">Xem hóa đơn chi tiết hóa <br> đơn</a>
           
        </div>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manageMenu"
        aria-expanded="true" aria-controls="manageMenu">
        <i class="fas fa-book"></i>
        <span>Quản lý menu</span>
    </a>
    <div id="manageMenu" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <!-- <h6 class="collapse-header">Custom Utilities:</h6> -->
            <a class="collapse-item" href="index.php?page=page_menu">Quản lý menu</a>
        </div>
    </div>
</li>


<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manageCoupon"
        aria-expanded="true" aria-controls="manageCoupon">
        <i class="fas fa-ticket-alt"></i>
        <span>Quản lý khuyến mãi</span>
    </a>
    <div id="manageCoupon" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <!-- <h6 class="collapse-header">Custom Utilities:</h6> -->
            <a class="collapse-item" href="index.php?page=page_coupon">Quản lý khuyến mãi</a>
        </div>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manageRequest"
        aria-expanded="true" aria-controls="manageRequest">
        <i class="fas fa-file-alt"></i>
        <span>Quản lý phiếu gửi yêu cầu</span>
    </a>
    <div id="manageRequest" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <!-- <h6 class="collapse-header">Custom Utilities:</h6> -->
            <a class="collapse-item" href="index.php?page=page_requestform">Quản lý phiếu</a>
        </div>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manageStatistical"
        aria-expanded="true" aria-controls="manageStatistical">
        <i class="fas fa-chart-bar"></i>
        <span>Thống kê doanh thu</span>
    </a>
    <div id="manageStatistical" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Utilities:</h6>
            <a class="collapse-item" href="index.php?page=page_manage">Thống kê</a>

        </div>
    </div>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<!-- <div class="sidebar-heading">
    Addons
</div> -->

<!-- Nav Item - Pages Collapse Menu -->
<!-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
        aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-fw fa-folder"></i>
        <span>Pages</span>
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Login Screens:</h6>
            <a class="collapse-item" href="login.html">Login</a>
            <a class="collapse-item" href="register.html">Register</a>
            <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Other Pages:</h6>
            <a class="collapse-item" href="404.html">404 Page</a>
            <a class="collapse-item" href="blank.html">Blank Page</a>
        </div>
    </div>
</li> -->

<!-- Nav Item - Charts -->
<!-- <li class="nav-item">
    <a class="nav-link" href="charts.html">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Charts</span></a>
</li> -->

<!-- Nav Item - Tables -->
<!-- <li class="nav-item">
    <a class="nav-link" href="tables.html">
        <i class="fas fa-fw fa-table"></i>
        <span>Tables</span></a>
</li> -->

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

<!-- Sidebar Message -->
<div class="sidebar-card d-none d-lg-flex">
    <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
    <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
    <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
</div>

</ul>
<?php
ob_end_flush(); // Kết thúc output buffering
?>

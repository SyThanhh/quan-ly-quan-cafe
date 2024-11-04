<?php
session_start();
?>
<head>
<script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
<!--Get your code at fontawesome.com-->
</head>
<style>
.nav-item.dropdown:hover .dropdown-menu {
    display: block;
    margin-top: 0;
}

</style>
<div class="container-fluid p-0 nav-bar">
    <nav class="navbar navbar-expand-lg bg-none navbar-dark py-3">
        <a href="index.php" class="navbar-brand px-lg-4 m-0">
            <h1 class="m-0 display-4 text-uppercase text-white">3S COFFEE</h1>
        </a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
            <div class="navbar-nav ml-auto p-4">
                <a href="index.php" class="nav-item nav-link">Trang chủ</a>
                <a href="index.php?page=menu" class="nav-item nav-link">Menu</a>
                <a href="index.php?page=service" class="nav-item nav-link">Khuyến mãi</a>
               <!-- <a href="index.php?page=about" class="nav-item nav-link">Thành Viên</a>-->
                <a href="index.php?page=contact" class="nav-item nav-link">Liên hệ</a>
                <div id="icon-user">

                </div>
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $_SESSION['username']; ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a href="profile.php" class="dropdown-item">Thông tin cá nhân</a>
                            <a href="membership.php" class="dropdown-item">Khách hàng thành viên</a>
                            <a href="reviews.php" class="dropdown-item">Sản phẩm đã đánh giá</a>
                            <div class="dropdown-divider"></div>
                            <!-- <a href="logout.php" class="dropdown-item">Đăng xuất</a> -->
                            <a href="index.php?page=logout" class="dropdown-item">Đăng xuất</a>
                        </div>
                    </div>
                <?php else: ?>
                    
           

            <div id="icon-user">
                <!-- <a style="padding: 0px 21px;" class="tk-gh" href="login.php" id="icon-user1"> -->
                <a style="padding: 0px 21px;" class="tk-gh" href="index.php?page=login" id="icon-user1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor"
                        class="bi bi-person-circle" viewBox="0 0 16 16" style="color: #ccc;">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                        <path fill-rule="evenodd"
                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                    </svg>
                </a>
            </div>
               
               
                <?php endif; ?>
            </div>
        </div>
    </nav>
</div>

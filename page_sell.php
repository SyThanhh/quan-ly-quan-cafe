<!DOCTYPE html>
<html lang="en">

<head>

    <?php
        include_once('./common/head/head.php')    
    ?>
    
    <link rel="stylesheet" href="./assets/css/thanhtoan.css">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include_once('./common/menu/siderbar.php')?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
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
                    </form>

                    <!-- Topbar Navbar -->
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
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-6">
                        <div class="header text-center">
                            <h4>THÔNG TIN KHÁCH HÀNG</h4>
                        </div>
                        
                        <form>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="phone">Số điện thoại</label>
                                    <input type="text" class="form-control" id="phone" placeholder="Nhập số điện thoại">
                                    <button type="button" class="btn btn-primary btn-add">Thêm mới</button>
                                    <button type="button" class="btn btn-primary btn-search">search</button>
                                    <button type="button" class="btn btn-primary btn-clear">Clear</button>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="customerName">Tên khách hàng</label>
                                    <input type="text" class="form-control" id="customerName" placeholder="Nhập tên khách hàng">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="points">Điểm</label>
                                    <input type="text" class="form-control" id="points" placeholder="Điểm tích lũy">
                                    <button type="button" class="btn btn-secondary btn-custom">Quy đổi</button>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="discountCode">Mã KM</label>
                                    <select class="form-control" id="discountCode">
                                        <option value="">Chọn mã KM</option>
                                        <option value="KM01">KM01</option>
                                        <option value="KM02">KM02</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="reduction">Giảm</label>
                                    <input type="text" class="form-control" id="reduction" placeholder="Giảm giá" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <!-- Ô trống để tạo sự cân bằng -->
                                </div>
                            </div>
            
                            <div class="header text-center">
                                <h4>THÔNG TIN HÓA ĐƠN</h4>
                            </div>
                            <table class="table table-bordered mt-3" id="invoice-list">
                                <thead class="table-header">
                                    <tr>
                                        <th>Tên SP</th>
                                        <th>Đơn Giá</th>
                                        <th>SL</th>
                                        <th>Tổng</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="invoice-list-body">
                                    <!-- Các sản phẩm sẽ được thêm vào đây -->
                                </tbody>
                            </table>
                            <div class="text-right">
                                <h5 id="grand-total">Tổng tất cả: <span id="total-amount">25000</span> VNĐ</h5>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button class="btn btn-danger me-2" style="transform: translate(-12px, 0px);">HỦY</button>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#paymentModal">THANH TOÁN</button>
            
                            </div>
            
                        </div>
                
                        </form>
                       
                        <div class="col-md-6">
                            <div class="header text-center">
                                <h4>BỘ LỌC</h4>
                            </div>
                            
                            <form>
                                <div class="form-group">
                                    <label for="product-search">Tên Sản Phẩm:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="product-search" placeholder="Nhập tên sản phẩm...">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary search-button m-0" type="button">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="category-select">Danh Mục Sản Phẩm:</label>
                                    <select class="form-control" id="category-select">
                                        <option value="">Chọn danh mục</option>
                                        <option value="thuc-pham">Thực phẩm</option>
                                        <option value="do-uong">Đồ uống</option>
                                        <option value="do-dung">Đồ dùng</option>
                                        <option value="thiet-bi">Thiết bị</option>
                                    </select>
                                </div>
                
                
                                <div class="header text-center">
                                    <h4>Danh sách sản phẩm</h4>
                                </div>
                                <div class="product-list" id="product-list">
                                    <div class="product-item" data-name="Sản phẩm 1" data-stock="1" data-price="100000">
                                        <img src="https://via.placeholder.com/100" alt="Sản phẩm 1">
                                        <p>Sản phẩm 1</p>
                                        <p class="stock">Tồn kho: 1</p>
                                    </div>
                                    <div class="product-item" data-name="Sản phẩm 2" data-stock="2" data-price="200000">
                                        <img src="https://via.placeholder.com/100" alt="Sản phẩm 2">
                                        <p>Sản phẩm 2</p>
                                        <p class="stock">Tồn kho: 2</p>
                                    </div>
                                    <div class="product-item" data-name="Sản phẩm 3" data-stock="3" data-price="300000">
                                        <img src="https://via.placeholder.com/100" alt="Sản phẩm 3">
                                        <p>Sản phẩm 3</p>
                                        <p class="stock">Tồn kho: 3</p>
                                    </div>
                                    <div class="product-item" data-name="Sản phẩm 4" data-stock="4" data-price="400000">
                                        <img src="https://via.placeholder.com/100" alt="Sản phẩm 4">
                                        <p>Sản phẩm 4</p>
                                        <p class="stock">Tồn kho: 4</p>
                                    </div>
                                    <div class="product-item" data-name="Sản phẩm 5" data-stock="5" data-price="300000">
                                        <img src="https://via.placeholder.com/100" alt="Sản phẩm 5">
                                        <p>Sản phẩm 5</p>
                                        <p class="stock">Tồn kho: 5</p>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            
              
              <!-- Modal -->
              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      ...
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                  </div>
                </div>
              </div>
            
                <!-- Modal cho phương thức thanh toán -->
                 <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="paymentModalLabel">Chọn Phương Thức Thanh Toán</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-check">
                                        <input type="radio" name="paymentMethod" id="cash" value="cash" class="form-check-input" checked>
                                        <label for="cash" class="form-check-label">Thanh toán tiền mặt</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="paymentMethod" id="bank" value="bank" class="form-check-input">
                                        <label for="bank" class="form-check-label">Chuyển khoản ngân hàng</label>
                                    </div>
                                    
                                    <!-- Trường nhập tiền mặt -->
                                    <div id="cashFields" class="payment-fields mt-3">
                                        <label for="cashAmount">Số tiền khách trả:</label>
                                        <input type="text" class="form-control" id="cashAmount" placeholder="Nhập số tiền">
                                        <span id="cashAmountError" class="text-danger" style="display: none;"></span>
                                        
                                        <label for="total-amount" class="mt-3">Tổng tiền hóa đơn:</label>
                                        <input type="text" class="form-control" id="total-amount" value="0" readonly>
                                        
                                        <label for="amountReturn" class="mt-3">Tiền thối lại:</label>
                                        <input type="text" class="form-control" id="amountReturn" readonly>
                                    </div>

                                    <!-- Trường nhập thông tin chuyển khoản -->
                                    <div id="bankFields" class="payment-fields mt-3">
                                        <label for="accountInfo">Thông tin tài khoản:</label>
                                        <input type="text" class="form-control" id="accountInfo" placeholder="Nhập thông tin tài khoản">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                    <button type="button" class="btn btn-primary" onclick="processPayment()">Xác nhận Thanh Toán</button>
                                </div>
                            </div>
                        </div>
                    </div>
               
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

          
            <!-- End of Footer -->
            <?php include_once('./common/footer/footer.php') ?>
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!--Thanh toán-->
   <script>
        <?php include_once('./assets/js/sell.js') ?>
    </script>
    <!-- Bootstrap core JavaScript-->
    <?php include_once('./common/script/default.php')?>


</body>

</html>
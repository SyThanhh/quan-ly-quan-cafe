<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/table.css">
    <!-- Đầu trang -->
    <?php
        include_once('./common/head/head.php');   
        include_once('./controller/CustomerController.php'); // Đường dẫn vào file kết nối database
        $CustomerControler = new CustomerController();
        // $customer = $CustomerControler->getC
    ?>
    
    <style>
      
        @media (max-width: 600px) {
            .table, .table thead, .table tbody, .table th, .table td, .table tr {
                display: block;
            }
            .table thead {
                display: none;
            }
            .table tbody tr {
                margin-bottom: 15px;
            }
            .table td {
                text-align: right;
                position: relative;
                padding-left: 50%;
            }
             .table td:before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                width: 45%;
                padding-left: 10px;
                text-align: left;
                font-weight: bold;
            } 
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <!-- Thanh điều hướng dọc -->
        <?php include_once('./common/menu/siderbar.php'); ?>

        <!-- Giao diện trang -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Thanh điều hướng ngang -->
                  <div id="content">
                <!-- Thanh điều hướng ngang -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
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

                <!--  Nội dung trang  -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="header text-left">
                                <h4>QUẢN LÝ KHÁCH HÀNG</h4>
                            </div>
                            <div id="message-notification" class="alert" style="display: none;">
                                <strong></strong> <span class="message-content"></span>
                            </div>

                            <div class="col-md-12 text-center">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group" style="width:55%;">
                                            <input type="text" class="form-control" width="60" id="name-search" placeholder="Tìm nhân viên theo tên">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary search-button m-0" type="button">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary search-button m-0" type="button">
                                                     <i class="fas fa-eraser"></i>
                                                </button>
                                            </div>
                                           
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button type="button" class="btn btn-primary btn-add" data-toggle="modal" data-target="#addCustomerModal">
                                        <i class="fas fa-plus-square"></i>
                                            Thêm Mới Khách hàng
                                        </button>
                                    </div>
                                </div>
                            </div>
                            </br>

                            <!-- Danh sách nhân viên -->
                             <table class="table">
                                    <thead>
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
                                            // Truy vấn danh sách nhân viên
                                            $customers= $CustomerControler->getAllCutomers("SELECT * FROM customer");

                                            // Hiển thị danh sách nhân viên
                                            if ($customers) {
                                                while ($row = $customers->fetch_assoc()) {
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
                                                          </td>
                                                          <td data-label='Thao tác'>
                                                            <button type='button' class='btn btn-danger delete-btn'>
                                                                <i class='fas fa-minus-square'></i>
                                                            </button>
                                                          </td>";
                                                    echo "</tr>";
                                                }
                                            } elseif ($customers === -1) {
                                                echo "<tr><td colspan='9' class='text-center'>Không có khách hàng nào</td></tr>";
                                            } else {
                                                echo "<tr><td colspan='9' class='text-center'>Không có dữ liệu</td></tr>";
                                            }
                                        ?>
                                    </tbody>
                                 </table>
                                 <div class="row justify-content-end mr-1">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Next">
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
                                        <!--Modal Customer-->
                <div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addCustomerModalLabel">Thêm Khách Hàng</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="customerForm" method="post">
                                    <input type="text" id="customerId" name="customerId" value="" hidden>
                                    <div class="form-group">
                                        <label for="customerName">Họ Tên</label>
                                        <input type="text" class="form-control" id="customerName" name="customerName" placeholder="Nhập họ tên" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="customerEmail">Email</label>
                                        <input type="email" class="form-control" id="customerEmail" name="customerEmail" placeholder="Nhập email" required>
                                        <span id="emailFeedback"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="customerPhone">Số Điện Thoại</label>
                                        <input type="tel" class="form-control" id="customerPhone" name="customerPhone" placeholder="Nhập số điện thoại" required>
                                        <span id="phoneFeedback"></span>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-primary" id="btnAddCustomer">Xác Nhận</button>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                            
                            </div>
                        </div>
                    </div>
                </div>
                                        <!--Modal delete-->
                <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
              
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Xác nhận xóa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Bạn có chắc chắn muốn xóa khách hàng có <b>ID</b> là <b id="confirmDeleteID"></b> ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete">Xóa</button>
                    </div>
                    </div>
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

    <script>
        $(document).ready(function() {

            $('#customerEmail').on('input', function() {
                const email = $(this).val();
                const id = $('#customerId').val(); // Lấy ID của khách hàng hiện tại
                
                if (email) {
                    $.ajax({
                        url: '?page=check_email_customer',
                        type: 'POST',
                        data: { email: email, id: id }, // Gửi cả email và id
                        success: function(response) {
                            if (response.exists) {
                                $('#emailFeedback').text("Email đã tồn tại.").css("color", "red");
                            } else {
                                $('#emailFeedback').text("Email có thể sử dụng.").css("color", "green");
                            }
                        }
                    });
                }
            });

          // Kiểm tra số điện thoại
            $('#customerPhone').on('input', function() {
                    const phone = $(this).val();
                    const id = $('#customerId').val();
                    
                    if (phone && phone.length !== 10) {
                        $('#phoneFeedback').text("Số điện thoại phải có 10 chữ số.").css("color", "red");
                    } else if (phone) {
                        $.ajax({
                            url: '?page=check_phone_customer', 
                            type: 'POST',
                            data: { phone: phone, id: id  },
                            success: function(response) {
                                if (response.exists) {
                                    $('#phoneFeedback').text("Số điện thoại đã tồn tại.").css("color", "red");

                                } else {
                                    $('#phoneFeedback').text("Số điện thoại có thể sử dụng.").css("color", "green");
                                }
                            }
                        });
                    } else {
                        $('#phoneFeedback').text('Số điện thoại không hợp lệ ').css("color", "red");

                    }
                });

            });
        $('#customerForm').on('submit', function(e) {
                const id = $('#customerId').val();
                const name = $('#customerName').val();
                const email = $('#customerEmail').val();
                const phone = $('#customerPhone').val();
                const message = $("#message-notification");
                const action = (id) ? 'edit' : 'add';
                e.preventDefault();
                $.ajax({
                    url: '?page=processing_customer',
                    type: 'POST',
                    data: { action, id, name, email, phone },
                    success: function(response) {
                        if (response.success) {
                            showMessage(response.message, 'success'); 
                        } else {
                            showMessage(response.message, 'danger'); // Hiển thị thông báo lỗi
                        }
                        $('#addCustomerModal').modal('hide'); 
                    },
                    error: function(error) {
                        showMessage('Đã xảy ra lỗi: ' + error.statusText, 'danger');
                    }
                });
            // }
        });
    
    

    $('.btn-add').on('click', function() {
        $('#addCustomerModalLabel').text('Thêm mới khách hàng');
        $('#customerForm')[0].reset();
        $('#emailFeedback').text("");
        $('#phoneFeedback').text("");

    });
    // Edit customer
    $('.edit-btn').on('click', function() {
        $('#emailFeedback').text("");
        $('#phoneFeedback').text("");
        const row = $(this).closest('tr');
        const id = row.data('id');
        const name = row.find('.customerName').text(); 
        const email = row.find('.customerEmail').text(); 
        const phone = row.find('.customerPhone').text(); 

        // Điền dữ liệu vào form
        $('#customerName').val(name);
        $('#customerEmail').val(email);
        $('#customerPhone').val(phone);
        $('#customerId').val(id);
        $('#addCustomerModalLabel').text('Cập nhật thông tin khách hàng');
        $('#addCustomerModal').modal('show'); 
    });

    // Delete customer
    let row;
    $('.delete-btn').on('click', function() {
        row = $(this).closest('tr');
        const id = row.data('id');
        $('#confirmDeleteModal').modal('show');
        $('#confirmDeleteID').text(id);
    });
    $('#confirmDelete').on('click', function() {
        const id = row.data('id');
        
    
        $.ajax({
            url: '?page=processing_customer',
            type: 'POST',
            data: { action: 'delete', id },
            success: function(response) {
                if (response.success) {
                    showMessage(response.message, 'success'); 
                } else {
                    showMessage(response.message, 'danger'); // Hiển thị thông báo lỗi
                }
                $('#addCustomerModal').modal('hide'); 
            },
            error: function(error) {
                showMessage('Đã xảy ra lỗi: ' + error.statusText, 'danger');
            }
        });
        
    });


    function showMessage(message, type) {
        const alertDiv = $('#message-notification');
        
        alertDiv.removeClass('alert-success alert-danger').addClass('alert-' + type);
        
        alertDiv.find('strong').text(type === 'success' ? 'Thành công!' : 'Lỗi!');
        
        alertDiv.find('.message-content').text(message);
        
        alertDiv.show();
        
        setTimeout(() => {
            alertDiv.hide();
        }, 8000);
    }



    </script>
</body>
</html>

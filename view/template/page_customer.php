<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/table.css">
    <!-- Đầu trang -->
    
    
    <style>
        #search-form {
            max-width: 600px;
            /* margin: auto; */
            padding: 8px;
            background-color: #f8f9fa;
            border-radius: 6px;
        }

        #search-form .form-control {
            border-radius: 6px 0 0 6px;
            padding: 10px 15px;
            border: 1px solid #ced4da;
        }

        #search-form .btn-outline-secondary {
            border: 1px solid #ced4da;
            padding: 0.5rem 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }

        #search-form .search-button i {
            font-size: 1.1rem;
            color: #495057;
        }

        #search-form .btn-outline-secondary:hover {
            background-color: #e2e6ea;
        }

        #search-form .btn-outline-secondary:focus {
            box-shadow: none;
        }

        @media (max-width: 576px) {
            #search-form {
                flex-direction: column;
            }

            #search-form .form-control {
                border-radius: 8px;
                margin-bottom: 8px;
            }

            #search-form .input-group-append {
                width: 100%;
                margin-bottom: 4px;
            }

            #search-form .btn-outline-secondary {
                width: 100%;
                border-radius: 8px;
            }
        }


       
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
    /* Khi hover vào phần tử dropdown */
        .nav-item.dropdown:hover .dropdown-menu {
            display: block;  /* Hiển thị menu khi hover */
        }

        /* Mặc định ẩn menu dropdown */
        .dropdown-menu {
            display: none; /* Ẩn menu khi không hover */
        }

        /* Các hiệu ứng chuyển động */
        .dropdown-menu {
            transition: opacity 0.3s ease;  /* Thêm hiệu ứng mờ dần */
            opacity: 0;
        }

        /* Khi dropdown hiển thị */
        .nav-item.dropdown:hover .dropdown-menu {
            opacity: 1;  /* Hiển thị khi hover */
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
                        

                            <!-- Nav Item - Messages -->
                           

                            <div class="topbar-divider d-none d-sm-block"></div>


                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <!-- Hiển thị tên người dùng từ session -->
                                <input type="text" id="employeeIdByRole" value="<?php echo htmlspecialchars($employeeID); ?>" hidden/>
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php
                                        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                            echo "Xin chào <b>".htmlspecialchars($_SESSION['username'])."</b>";
                                        } else {
                                            echo "Guest";
                                        }
                                    ?>
                                </span>
                                <img class="img-profile rounded-circle" src="./assets/img/testimonial-2.jpg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                
                                <a class="dropdown-item" href="index.php?page=logout" >
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

                                <!--Form group-->

                                <?php
                                include __DIR__ . '/customer/customer_list.php';

                                ?>
                                <!-- Danh sách nhân viên -->
                                
                            
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
        function validateEmail(email) {
            var regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        
            return regex.test(email);
        }

        function validatePhone(phone) {
            var regex = /^(09|03|08|07|05)[0-9]{8}$/;
            return regex.test(phone);
        }
        $(document).ready(function() {

            $('#customerEmail').on('input', function() {
                const email = $(this).val();
                const id = $('#customerId').val(); // Lấy ID của khách hàng hiện tại
                
                let checkEmail = validateEmail(email);
                if (!checkEmail) {
                    $('#emailFeedback')
                        .text("Email không hợp lệ. Vui lòng sử dụng định dạng ví dụ: thanh@gmail.com hoặc thanh_298@gmail.com")
                        .css("color", "red");
                        $('#btnConFirmAddCustomerSell').prop('disabled', true);
                    return;
                } else {
                    $('#emailFeedback').text("").css("color", ""); 
                    $('#btnConFirmAddCustomerSell').prop('disabled', false);
                }

            // Nếu email hợp lệ, thực hiện kiểm tra xem email có tồn tại không
                if (checkEmail) {
                    $.ajax({
                        url: '?page=check_email_customer', 
                        type: 'POST',
                        data: { email: email, id: id },
                        success: function(response) {
                            if (response.exists) {
                                $('#emailFeedback').text("Email đã tồn tại.").css("color", "red");
                                $('#btnConFirmAddCustomerSell').prop('disabled', true);
                            } else {
                                $('#emailFeedback').text("Email có thể sử dụng.").css("color", "green");
                                $('#btnConFirmAddCustomerSell').prop('disabled', false);
                            }
                        },
                        error: function(xhr, status, error) {
                            $('#emailFeedback').text("Có lỗi xảy ra. Vui lòng thử lại sau.").css("color", "red");
                            console.error('Error:', error);
                            $('#btnConFirmAddCustomerSell').prop('disabled', false);
                        }
                    });
                }
            });

          // Kiểm tra số điện thoại
            $('#customerPhone').on('input', function() {
                    const phone = $(this).val();
                    const id = $('#customerId').val();
                    
                    if (phone && phone.length !== 10) {
                    $('#phoneFeedback')
                        .text("Số điện thoại phải có 10 chữ số.")
                        .css("color", "red");
                        $('#btnConFirmAddCustomerSell').prop('disabled', true); 
                    return; // Dừng tại đây nếu số không có độ dài đúng
                }
                let checkPhone = validatePhone(phone);
                if (!checkPhone) {
                    $('#phoneFeedback')
                        .text("Số điện thoại không hợp lệ. Số điện thoại phải bắt đầu bằng 09, 03, 08, 07, hoặc 05 và có 10 chữ số.")
                        .css("color", "red");
                        $('#btnConFirmAddCustomerSell').prop('disabled', true); 
                    return; // Dừng kiểm tra nếu định dạng không hợp lệ
                } else {
                    $('#phoneFeedback').text("").css("color", ""); // Xóa thông báo nếu định dạng hợp lệ
                }

                if (phone) {
                    $.ajax({
                        url: '?page=check_phone_customer', // Đường dẫn đến script xử lý
                        type: 'POST',
                        data: { phone: phone, id: id }, // Gửi cả số điện thoại và ID nếu cần
                        success: function(response) {
                            if (response.exists) {
                                $('#phoneFeedback').text("Số điện thoại đã tồn tại.").css("color", "red");
                                $('#btnConFirmAddCustomerSell').prop('disabled', true); 
                            } else {
                                $('#phoneFeedback').text("Số điện thoại có thể sử dụng.").css("color", "green");
                                $('#btnConFirmAddCustomerSell').prop('disabled', false);
                            }
                        },
                        error: function(xhr, status, error) {
                            $('#phoneFeedback').text("Có lỗi xảy ra. Vui lòng thử lại sau.").css("color", "red");
                            $('#btnConFirmAddCustomerSell').prop('disabled', true); 
                            console.error('Error:', error);
                        }
                    });
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
        $('#customerName').attr("readonly", true);
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
    $('#confirmDelete').on('click', function(e) {
        const id = row.data('id');
        
        $.ajax({
            url: '?page=processing_customer',
            type: 'POST',
            data: { action: 'delete', id },
            success: function(response) {
                if (response.success) {
                    row.remove();
                    showMessage(response.message, 'success');
                    $('#confirmDeleteModal').modal('hide');
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

    $('#search-button').on('click', function(e) {
        e.preventDefault();
        const searchKeyword = $('#name-search').val();
            searchCustomers(searchKeyword);
        });

        $('#name-search').on('input', function() {
            const searchKeyword = $(this).val()
            searchCustomers(searchKeyword);
    });

    function searchCustomers(keyword) {
        $.ajax({
            url: '?page=page_customer', 
            type: 'POST',
            data: { search: keyword },
            success: function(response) {
                $('#search-results').html(response); 
            },
            error: function() {
                $('#search-results').html('<p class="text-danger">Có lỗi xảy ra trong quá trình tìm kiếm.</p>');
            }
        });
    }
    $("#btn-clear").on('click', function(e) {
        clearSearch();
        // e.preventDefault();
    })
    function clearSearch() {
        $('#name-search').val(""); 
        $.ajax({
            url: '?page=page_customer', 
            data: { clear: true }, 
            success: function(response) {
                $('#search-results').html(response);
            },
            error: function() {
                $('#search-results').html('<p class="text-danger">Có lỗi xảy ra trong quá trình tìm kiếm.</p>');
            }
        });
    }


   
    
    </script>
</body>
</html>
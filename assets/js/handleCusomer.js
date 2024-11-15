$(document).ready(function() {
    $("#btnAdd-pageSell").on('click', function() {
        $("#addCustomerModal").modal('show');
    });

    // Kiểm tra email
    $('#customerEmail').on('input', function() {
        const email = $(this).val();
        const id = null;// Lấy ID của khách hàng hiện tại
        
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
        const id = null;
        
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

    // Xử lý form submit
    $('#customerFormSell').on('submit', function(e) {
        e.preventDefault(); // Ngăn chặn hành vi submit mặc định
        
        const name = $('#customerName').val();
        const email = $('#customerEmail').val();
        const phone = $('#customerPhone').val();
        const action = 'add';
        console.log("Name: " + name);
        console.log("Email: " + email);
        console.log("Phone: " + phone);

        // $.ajax({
        //     url: '?page=processing_customer',
        //     type: 'POST',
        //     data: { action, id, name, email, phone },
        //     success: function(response) {
        //         if (response.success) {
        //             showMessage(response.message, 'success');
        //         } else {
        //             showMessage(response.message, 'danger');
        //         }
        //         $('#addCustomerModal').modal('hide');
        //     },
        //     error: function(error) {
        //         showMessage('Đã xảy ra lỗi: ' + error.statusText, 'danger');
        //     }
        // });
    });
    
    // Hàm hiển thị thông báo
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
    $('#btnAddCustomer').on('click', function() {
        console.log('Xác Nhận clicked');
    });
});

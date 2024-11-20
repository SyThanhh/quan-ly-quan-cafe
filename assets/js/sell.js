$(document).ready(function() {
   
    const $invoiceListBody = $('#invoice-list-body');
    const $totalAmountDisplay = $('#total-amount');
    let isCheck = false;

   
    $('.btn-primary[data-toggle="modal"]').on('click', function() {
        $('#paymentModal').modal('show');
    });

    // xóa session
    $(document).on('click', '.btn-remove', function(e) {
        deleteSession();
    })
    
    
    // chỉ lấy số
    function convertToNumber(priceString) {
        if (typeof priceString !== 'string') {
            priceString = String(priceString); 
        }
        
        priceString = priceString.replace(/[^0-9]/g, '');

        return parseFloat(priceString);
    }


    // cập nhật total amount
    function updateGrandTotal() {
        let grandTotal = 0;
        $invoiceListBody.find('tr').each(function() {
            const total = convertToNumber($(this).find('.total-price').text());
       
            grandTotal += total;
        });
        $totalAmountDisplay.text(grandTotal.toLocaleString());
    }

    // xáo session
    function deleteSession() {
        $.ajax({
            url: 'index.php?page=save_invoice', 
            method: 'POST',
            data: {
                action: 'delete_invoice' 
            },
            success: function(response) {
                if (response.status === 'success') {
                    console('Hóa đơn đã được xóa thành công');
                } else {
                    console('Lỗi: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Có lỗi xảy ra khi gửi yêu cầu AJAX:', error);
            }
        });
    }
    
    // thêm row, cộng, trừ số lượng, update tổng
    function addProductToInvoice(product) {
        const $existingRow = $invoiceListBody.find(`tr[data-name="${product.name}"]`);
        let updated = false;
        if ($existingRow.length) {
            const $quantityInput = $existingRow.find('.quantity-display');
            let quantity = $quantityInput.val();
            const stock = parseInt(product.stock);

            if (quantity < stock) {
                quantity++;
                $quantityInput.val(quantity);
                const productPrice = parseFloat(product.price.replace(/\./g, ''));
                const totalPrice = quantity * productPrice;
                $existingRow.find('.total-price').text(totalPrice.toLocaleString() + " đ");
                updated = true; 
            } else {
                showAlert('warning', 'Số lượng sản phẩm đã đạt tối đa tồn kho.');
            }
        } else {
            const $row = $(`
                <tr data-name="${product.name}">
                    <td>${product.name}</td>
                    <td>${product.price} <span>VNĐ</span></td>
                    <td>
                        <div class="quantity-container">
                            <button class="btn-change btn-plus">+</button>
                            <input type="number" class="quantity-display" value="1" min="1" />
                            <button class="btn-change btn-minus">-</button>
                        </div>
                    </td>
                    <td class="total-price">${product.price} <span> đ</span></td>
                    <td><button class="btn-custome btn-remove" >Xóa</button></td> 
                </tr>
            `);
            $invoiceListBody.append($row);
            updated = true; 

            const $quantityInput = $row.find('.quantity-display');
            const stock = product.stock;

            $quantityInput.on('input', function(e) {
                e.preventDefault();
                let quantity = parseInt($(this).val());
                if (isNaN(quantity) || quantity < 1) {
                    $(this).val(1);
                    quantity = 1;
                } else if (quantity > stock) {
                    showAlert('warning', 'Số lượng sản phẩm đã đạt tối đa tồn kho.');
                    $(this).val(stock);
                    quantity = stock;
                }
                const productPrice = parseFloat(product.price.replace(/\./g, ''));
                const totalPrice = quantity * productPrice;
              
                $row.find('.total-price').text(totalPrice.toLocaleString());
                updated = true; 
                updateGrandTotal();
            });

            $row.find('.btn-plus').on('click', function(e) {
                e.preventDefault();
                let quantity = $quantityInput.val();
                if (quantity < stock) {
                    quantity++;
                    console.log("++++");
                    $quantityInput.val(quantity);
                    const productPrice = parseFloat(product.price.replace(/\./g, ''));
                    const totalPrice = quantity * productPrice;
                   
                    $row.find('.total-price').text(totalPrice.toLocaleString() + " đ");
                    updateGrandTotal();
                    updated = true; 
                } else {
                    showAlert('warning', 'Số lượng sản phẩm đã đạt tối đa tồn kho.');
                }
            });

            $row.find('.btn-minus').on('click', function(e) {
                 e.preventDefault();
                let quantity = $quantityInput.val();
                if (quantity > 1) {
                    quantity--;
                    console.log("---");
                    $quantityInput.val(quantity);
                    const productPrice = parseInt(product.price.replace(/\./g, ''));
                    const totalPrice = quantity * productPrice;
                  
                    $row.find('.total-price').text(totalPrice.toLocaleString() + " đ");
                    updated = true; 
                    updateGrandTotal();
                }
            });

            $row.find('.btn-remove').on('click', function() {
                $row.remove();
                updateGrandTotal();
                updated = true; 
            });
        }
        if (updated) {
            updateSession();
        }
        updateGrandTotal();
    }

    // click vào sản phẩm
    $('.product-item').on('click', function() {
        const productName = $(this).data('name');
        const productStock = parseInt($(this).data('stock'));
        const productPrice = $(this).data('price')                                                                                                                                                                                                                                                                                                                                                                                                                                      ;
        addProductToInvoice({ name: productName, stock: productStock, price: productPrice });
    });

    function togglePaymentFields() {
        const isCash = $('#cash').is(':checked');                                                                                                                                                                   
        $('#cashFields').toggle(isCash);                                                                                                                                                                                                    
        $('#bankFields').toggle(!isCash);
    }

    $('input[name="paymentMethod"]').on('change', togglePaymentFields);
    togglePaymentFields();  // Khởi động với phương thức thanh toán mặc định

  
    // Gắn sự kiện cho các nút trong modal
    $('#paymentModal').on('shown.bs.modal', function() {
        $(this).find("#total-amount").val($totalAmountDisplay.text());

        let totalAmount = parseFloat($(this).find("#total-amount").val().replace(/,/g, ''));

        $('#cashAmount').off('change').on('change', function() {
                let cashAmount = $(this).val();
                cashAmount = parseFloat(cashAmount.replace(/,/g, ''));
                let errorSpan = $(this).closest(".modal").find("#cashAmountError");

                // Reset thông báo lỗi
                errorSpan.text('').hide();

                // Kiểm tra giá trị nhập vào
                if (!cashAmount) {
                    errorSpan.html('Vui lòng nhập số tiền.<br>').show();
                    $(this).val(''); // Xóa giá trị trong input
                    return;
                }
                if (cashAmount < totalAmount) {
                    errorSpan.html('Vui lòng nhập số tiền > Số tiền phải trả.<br>').show();
                    $(this).val(''); 
                    return;
                }

                
            if (isNaN(cashAmount)) {
                    errorSpan.html('Số tiền phải là một số hợp lệ.<br>').show();
                    $(this).val(''); // Xóa giá trị trong input
                    return;
                }
                if (cashAmount < 0) {
                    errorSpan.html('Số tiền không được âm.<br>').show();
                    $(this).val(''); // Xóa giá trị trong input
                    return;
                }

                // Tính toán tiền trả lại
                const amountReturn = convertToNumber(cashAmount) - convertToNumber(totalAmount);
                isCheck = true;
                // Cập nhật giá trị tiền thối lại
                $(this).closest(".modal").find("#amountReturn").val(amountReturn.toLocaleString() + " ₫");
            });

        togglePaymentFields();
    });


    // alert notifiction
   
    function hideAlert() {
        $('#alert').remove();
    }
    function showAlert(type, message) {
        const alertTypes = {
            'error': 'alert-error',
            'warning': 'alert-warning',
            'success': 'alert-success'
        };
    
        const $alert = $(`
            <div class="alert ${alertTypes[type]}" id="alert" role="alert">
                <i class="fas fa-${type === 'error' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : 'check-circle'}"></i>
                <span>${message}</span>
                <span class="close" data-dismiss="alert" aria-label="Close">&times;</span>
            </div>
        `);
    
        $('body').append($alert);
    
        setTimeout(function() {
            hideAlert();
        }, 3000);
    }


    // lấy dữ liệu từ form
    function collectOrderData() {
        let orderData = {
            
            items: [],
            paymentMethod: $('input[name="paymentMethod"]:checked').val(),
            totalAmount: $totalAmountDisplay.text(),
        };
    
        $invoiceListBody.find('tr').each(function() {
            const productName = $(this).data('name');
            const productPrice = $(this).find('td').eq(1).text().trim();
            const quantity = $(this).find('.quantity-display').val();
            const totalPrice = $(this).find('.total-price').text().trim();
    
            orderData.items.push({
                name: productName,
                price: productPrice,
                quantity: quantity,
                total: totalPrice
            });
        });
    
        if (orderData.paymentMethod === 'cash') {
            orderData.cashAmount = $('#cashAmount').val();
            orderData.amountReturn = $('#amountReturn').val();
        } else {
            orderData.accountInfo = $('#accountInfo').val();
        }
    
        return orderData;
    }

    function sendOrderData() {
        const orderData = collectOrderData();
        const isCash = $('#cash').is(':checked');
        // const cashAmount = $('#cashAmount').val();
        const amountReturn = $('#amountReturn').val();
        // if (isCash) {

        // } else {
        //     const accountInfo = $('#accountInfo').val();
        //     showAlert('success','Thanh toán bằng chuyển khoản với thông tin tài khoản: ' + accountInfo);
        // }
        $.ajax({
            type: 'POST',
            url: 'index.php?page=processing_order',  // URL để xử lý lưu trữ đơn hàng
            data: JSON.stringify(orderData),
            contentType: 'application/json',
            success: function(response, status, xhr) {
                
                if (xhr.status === 200) {
                    if (response.items && response.items.length > 0) {
                        showAlert('success', 'Đơn hàng đã được lưu thành công! <br> Tiền thối lại: ' + amountReturn + ' VNĐ.');
                        // showAlert('success','Thanh toán tiền mặt với số tiền: ' + cashAmount + ' VNĐ. Tiền thối lại: ' + amountReturn + ' VNĐ.');
                    } else {
                        showAlert('error', 'Có lỗi xảy ra khi lưu đơn hàng.');
                    }
                } else {
                    // Nếu mã trạng thái HTTP không phải 200, báo lỗi kết nối
                    showAlert('error', 'Có lỗi xảy ra khi kết nối với server.');
                }
                setTimeout(function() {
                    $('.modal-backdrop').remove();
                }, 3000); 
                $('#paymentModal').modal('hide');
            },
            error: function(error) {
                console.error("Error: " + error);
               
                showAlert('error', 'Có lỗi xảy ra khi kết nối với server.');
            }
        });
    }
    
    
    $('#processPayment').on('click', function(e) {
        e.preventDefault(); 
        sendOrderData(); 
    });
    

    
    
    

    // Hàm khởi tạo hóa đơn từ dữ liệu đã lưu
function initializeInvoice(savedInvoiceData) {
    console.log('initializeInvoice được gọi', savedInvoiceData); 
    savedInvoiceData.forEach(function(product) {
        // Quá trình thêm các sản phẩm vào bảng hoặc xử lý hóa đơn
        const $existingRow = $invoiceListBody.find(`tr[data-name="${product.name}"]`);
        let updated = false;
        
        // Kiểm tra nếu dòng sản phẩm đã tồn tại trong bảng
        if ($existingRow.length) {
            const $quantityInput = $existingRow.find('.quantity-display');
            let quantity = parseInt($quantityInput.val());
            const stock = parseInt(product.stock);

            if (quantity < stock) {
                quantity = parseInt(product.quantity); // Sử dụng số lượng đã lưu trong session
                $quantityInput.val(quantity);
                const productPrice = parseFloat(product.price.replace(/\./g, ''));
                const totalPrice = quantity * productPrice;
                $existingRow.find('.total-price').text(totalPrice.toLocaleString() + " đ");
                updated = true;
            } else {
                showAlert('warning', 'Số lượng sản phẩm đã đạt tối đa tồn kho.');
            }
        } else {
            // Nếu không tồn tại dòng sản phẩm, tạo mới dòng
            const $row = $(`
                <tr data-name="${product.name}">
                    <td>${product.name}</td>
                    <td>${product.price} <span>VNĐ</span></td>
                    <td>
                        <div class="quantity-container">
                            <button class="btn-change btn-plus">+</button>
                            <input type="number" class="quantity-display" value="${product.quantity}" min="1" />
                            <button class="btn-change btn-minus">-</button>
                        </div>
                    </td>
                    <td class="total-price">${product.totalPrice} <span> đ</span></td>
                    <td><button class="btn-custome btn-remove">Xóa</button></td>
                </tr>
            `);
            $invoiceListBody.append($row);
            updated = true;

            const $quantityInput = $row.find('.quantity-display');
            const stock = product.stock;

            // Xử lý sự kiện thay đổi số lượng
            $quantityInput.on('input', function(e) {
                e.preventDefault();
                let quantity = parseInt($(this).val());
                if (isNaN(quantity) || quantity < 1) {
                    $(this).val(1);
                    quantity = 1;
                } else if (quantity > stock) {
                    showAlert('warning', 'Số lượng sản phẩm đã đạt tối đa tồn kho.');
                    $(this).val(stock);
                    quantity = stock;
                }
                const productPrice = parseFloat(product.price.replace(/\./g, ''));
                const totalPrice = quantity * productPrice;

                $row.find('.total-price').text(totalPrice.toLocaleString());
                updated = true;
                updateGrandTotal();
            });

            // Xử lý sự kiện tăng số lượng
            $row.find('.btn-plus').on('click', function(e) {
                e.preventDefault();
                let quantity = $quantityInput.val();
                if (quantity < stock) {
                    quantity++;
                    $quantityInput.val(quantity);
                    const productPrice = parseFloat(product.price.replace(/\./g, ''));
                    const totalPrice = quantity * productPrice;
                    $row.find('.total-price').text(totalPrice.toLocaleString() + " đ");
                    updateGrandTotal();
                    updated = true;
                } else {
                    showAlert('warning', 'Số lượng sản phẩm đã đạt tối đa tồn kho.');
                }
            });

            // Xử lý sự kiện giảm số lượng
            $row.find('.btn-minus').on('click', function(e) {
                e.preventDefault();
                let quantity = $quantityInput.val();
                if (quantity > 1) {
                    quantity--;
                    $quantityInput.val(quantity);
                    const productPrice = parseFloat(product.price.replace(/\./g, ''));
                    const totalPrice = quantity * productPrice;
                    $row.find('.total-price').text(totalPrice.toLocaleString() + " đ");
                    updated = true;
                    updateGrandTotal();
                }
            });

            // Xử lý sự kiện xóa sản phẩm
            $row.find('.btn-remove').on('click', function() {
                $row.remove();
                updateGrandTotal();
                updated = true;
            });
        }

        if (updated) {
            updateSession(); // Cập nhật lại session sau khi thay đổi
        }
        updateGrandTotal(); // Cập nhật tổng tiền
    });
}


function updateSession() {
    let invoiceData = [];

    // Duyệt qua các dòng sản phẩm trong hóa đơn
    $invoiceListBody.find('tr').each(function() {
        const productName = $(this).data('name');
        const quantity = $(this).find('.quantity-display').val();
        const totalPrice = $(this).find('.total-price').text().replace(" đ", "").replace(/\./g, ''); // Loại bỏ dấu "đ" và dấu chấm
        const price = $(this).find('td').eq(1).text().replace(" VNĐ", "").replace(/\./g, ''); // Giá sản phẩm (VNĐ)

        // Thêm thông tin vào mảng invoiceData
        invoiceData.push({
            name: productName,
            quantity: quantity,
            price: price,
            totalPrice: totalPrice
        });
    });

    // Gửi thông tin vào server để lưu trữ vào session
    $.ajax({
        url: 'index.php?page=save_invoice', // Đường dẫn đến file PHP xử lý lưu trữ
        method: 'POST',
        data: {
            action: 'update_invoice',
            invoiceData: JSON.stringify(invoiceData) // Chuyển đổi thành chuỗi JSON
        },
        success: function(response) {
            console.log('Thông tin hóa đơn đã được lưu vào session');
        },
        error: function(error) {
            console.error('Lỗi khi lưu thông tin vào session:', error);
        }
    });
}

// lấy dữ liệu từ form
function collectOrderData() {
    let orderData = {
        
        items: [],
        paymentMethod: $('input[name="paymentMethod"]:checked').val(),
        totalAmount: $totalAmountDisplay.text(),
    };

    $invoiceListBody.find('tr').each(function() {
        const productName = $(this).data('name');
        const productPrice = $(this).find('td').eq(1).text().trim();
        const quantity = $(this).find('.quantity-display').val();
        const totalPrice = $(this).find('.total-price').text().trim();

        orderData.items.push({
            name: productName,
            price: productPrice,
            quantity: quantity,
            total: totalPrice
        });
    });

    if (orderData.paymentMethod === 'cash') {
        orderData.cashAmount = $('#cashAmount').val();
        orderData.amountReturn = $('#amountReturn').val();
    } else {
        orderData.accountInfo = $('#accountInfo').val();
    }

    return orderData;
}

// gửi data để lưu session
function sendOrderData() {
    const orderData = collectOrderData();
    const isCash = $('#cash').is(':checked');
    // const cashAmount = $('#cashAmount').val();
    const amountReturn = $('#amountReturn').val();
    // if (isCash) {

    // } else {
    //     const accountInfo = $('#accountInfo').val();
    //     showAlert('success','Thanh toán bằng chuyển khoản với thông tin tài khoản: ' + accountInfo);
    // }
    $.ajax({
        type: 'POST',
        url: 'index.php?page=processing_order',  // URL để xử lý lưu trữ đơn hàng
        data: JSON.stringify(orderData),
        contentType: 'application/json',
        success: function(response, status, xhr) {
            
            if (xhr.status === 200) {
                if (response.items && response.items.length > 0) {
                    showAlert('success', 'Đơn hàng đã được lưu thành công! <br> Tiền thối lại: ' + amountReturn + ' VNĐ.');
                    // showAlert('success','Thanh toán tiền mặt với số tiền: ' + cashAmount + ' VNĐ. Tiền thối lại: ' + amountReturn + ' VNĐ.');
                } else {
                    showAlert('error', 'Có lỗi xảy ra khi lưu đơn hàng.');
                }
            } else {
                // Nếu mã trạng thái HTTP không phải 200, báo lỗi kết nối
                showAlert('error', 'Có lỗi xảy ra khi kết nối với server.');
            }
            setTimeout(function() {
                $('.modal-backdrop').remove();
            }, 3000); 
            $('#paymentModal').modal('hide');
        },
        error: function(error) {
            console.error("Error: " + error);
           
            showAlert('error', 'Có lỗi xảy ra khi kết nối với server.');
        }
    });
}
   
    

function fetchDataInvoice() {
    $.ajax({
        url: 'view/template/save_invoice.php',  // Địa chỉ file PHP để lấy dữ liệu
        method: 'GET',  // Sử dụng GET để lấy dữ liệu từ server
        dataType: 'json',  // Dữ liệu trả về dưới dạng JSON
        success: function(data) {
            if (data.status === 'success') {
                console.log(data.data);  // In dữ liệu hóa đơn ra console
                // Xử lý dữ liệu nhận được từ server và hiển thị
                initializeInvoice(data.data);
            } else {
                console.error('Không có dữ liệu hóa đơn:', data.message);  // Lỗi nếu không có dữ liệu
            }
        },
        error: function(error) {
            console.error('Có vấn đề với yêu cầu fetch:', error);  // Lỗi nếu fetch gặp sự cố
        }
    });
}

// Gọi hàm để lấy dữ liệu hóa đơn
fetchDataInvoice();



});

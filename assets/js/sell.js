$(document).ready(function() {
   
    const $invoiceListBody = $('#invoice-list-body');
    const $totalAmountDisplay = $('#total-amount');
    let isCheck = false;

   
    $('.btn-primary[data-toggle="modal"]').on('click', function() {
        $('#paymentModal').modal('show');
    });



    function convertToNumber(priceString) {
        if (typeof priceString !== 'string') {
            priceString = String(priceString); // Chuyển đổi thành chuỗi
        }
        return parseInt(priceString.replace(/,/g, '')); // Loại bỏ dấu phẩy và chuyển đổi sang số nguyên
    }

    function updateGrandTotal() {
        let grandTotal = 0;
        $invoiceListBody.find('tr').each(function() {
            const total = convertToNumber($(this).find('.total-price').text());
            grandTotal += total;
        });
        $totalAmountDisplay.text(grandTotal.toLocaleString());
    }

    function addProductToInvoice(product) {
        const $existingRow = $invoiceListBody.find(`tr[data-name="${product.name}"]`);

        if ($existingRow.length) {
            const $quantityInput = $existingRow.find('.quantity-display');
            let quantity = parseInt($quantityInput.val());
            const stock = parseInt(product.stock);

            if (quantity < stock) {
                quantity++;
                $quantityInput.val(quantity);
                const totalPrice = quantity * product.price;
                $existingRow.find('.total-price').text(totalPrice.toLocaleString());
            } else {
                showAlert('warning', 'Số lượng sản phẩm đã đạt tối đa tồn kho.');
            }
        } else {
            const $row = $(`
                <tr data-name="${product.name}">
                    <td>${product.name}</td>
                    <td>${product.price.toLocaleString()} <span>VNĐ</span></td>
                    <td>
                        <div class="quantity-container">
                            <button class="btn-change btn-plus">+</button>
                            <input type="number" class="quantity-display" value="1" min="1" />
                            <button class="btn-change btn-minus">-</button>
                        </div>
                    </td>
                    <td class="total-price">${product.price.toLocaleString()}</td>
                    <td><button class="btn-custome btn-remove">Xóa</button></td> 
                </tr>
            `);
            $invoiceListBody.append($row);

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
                const totalPrice = quantity * product.price;
                $row.find('.total-price').text(totalPrice.toLocaleString());
                updateGrandTotal();
            });

            $row.find('.btn-plus').on('click', function(e) {
                e.preventDefault();
                let quantity = parseInt($quantityInput.val());
                if (quantity < stock) {
                    quantity++;
                    $quantityInput.val(quantity);
                    const totalPrice = quantity * product.price;
                    $row.find('.total-price').text(totalPrice.toLocaleString());
                    updateGrandTotal();
                } else {
                    showAlert('warning', 'Số lượng sản phẩm đã đạt tối đa tồn kho.');
                }
            });

            $row.find('.btn-minus').on('click', function(e) {
                 e.preventDefault();
                let quantity = parseInt($quantityInput.val());
                if (quantity > 1) {
                    quantity--;
                    $quantityInput.val(quantity);
                    const totalPrice = quantity * product.price;
                    $row.find('.total-price').text(totalPrice.toLocaleString());
                    updateGrandTotal();
                }
            });

            $row.find('.btn-remove').on('click', function() {
                $row.remove();
                updateGrandTotal();
            });
        }
        updateGrandTotal();
    }

    $('.product-item').on('click', function() {
        const productName = $(this).data('name');
        const productStock = parseInt($(this).data('stock'));
        const productPrice = parseInt($(this).data('price'));
        addProductToInvoice({ name: productName, stock: productStock, price: productPrice });
    });

    function togglePaymentFields() {
        const isCash = $('#cash').is(':checked');
        $('#cashFields').toggle(isCash);
        $('#bankFields').toggle(!isCash);
    }

    $('input[name="paymentMethod"]').on('change', togglePaymentFields);
    togglePaymentFields();  // Khởi động với phương thức thanh toán mặc định

   
    $('#processPayment').on("click", function() {
        const isCash = $('#cash').is(':checked');
        if(isCheck) {
            if (isCash) {
                const cashAmount = $('#cashAmount').val();
                const amountReturn = $('#amountReturn').val();
              
                showAlert('success','Thanh toán tiền mặt với số tiền: ' + cashAmount + ' VNĐ. Tiền thối lại: ' + amountReturn + ' VNĐ.');
            } else {
                const accountInfo = $('#accountInfo').val();
                showAlert('success','Thanh toán bằng chuyển khoản với thông tin tài khoản: ' + accountInfo);
            }
            
            $('#paymentModal').modal('hide');
            setTimeout(function() {
                $('.modal-backdrop').remove();
            }, 300); 
        }
        
    });

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
});
$(document).ready(function() {
   
    const $invoiceListBody = $('#invoice-list-body');
    const $totalAmountDisplay = $('#total-amount');
    const $totalAmountDiscount = $("#total-amount-discount").val();
    const $reductionDisplay = extractDiscount($('#reduction').val());
    let isCheck = false;

   
    $('.btn-primary[data-toggle="modal"]').on('click', function() {
        $('#paymentModal').modal('show');
    });



    function convertToNumber(priceString) {
        if (typeof priceString !== 'string') {
            priceString = String(priceString); // Chuyển đổi thành chuỗi
        }
        return parseInt(priceString.replace(/\./g, '')); // Loại bỏ dấu phẩy và chuyển đổi sang số nguyên
    }

    function updateGrandTotal() {
        let grandTotal = 0;
        let grantToTalDiscount = 0;
        $invoiceListBody.find('tr').each(function() {
            const total = convertToNumber($(this).find('.total-price').text());
            grandTotal += total;
        });
        grantToTalDiscount = grandTotal - (grandTotal* ($reductionDisplay/100))
        $totalAmountDisplay.text(grantToTalDiscount.toLocaleString());
        let discount = (grandTotal* ($reductionDisplay/100));
        
        $("#total-amount-discount").text(discount.toLocaleString());
    }


  

    // xáo session
    function deleteSession() {
        return $.ajax({
            url: 'index.php?page=save_invoice', 
            method: 'POST',
            data: {
                action: 'delete_invoice' 
            }
        }).done(function(response) {
            if (response.status === 'success') {
                console.log('Hóa đơn đã được xóa thành công');
            } else {
                console.log('Lỗi: ' + response.message);
            }
        }).fail(function(xhr, status, error) {
            console.error('Có lỗi xảy ra khi gửi yêu cầu AJAX:', error);
        });
    }
    
    // thêm row, cộng, trừ số lượng, update tổng
    function addProductToInvoice(product) {
        const $existingRow = $invoiceListBody.find(`tr[data-id="${product.id}"]`);
        if ($existingRow.length) {
            const $quantityInput = $existingRow.find('.quantity-display');
            let quantity = parseInt($quantityInput.val());
            const stock = parseInt(product.stock);
            const productPrice = parseInt(product.price.replace(/\./g, ''));
            
            if (quantity < stock) {
                quantity++;
                const totalPrice = quantity * productPrice;
                $quantityInput.val(quantity);
                $existingRow.find('.total-price').text(totalPrice.toLocaleString() + " đ");
                updateSession();
            } else {
                showAlert('warning', 'Số lượng sản phẩm đã đạt tối đa tồn kho.');
            }
        } else {
            const $row = $(`
                <tr data-id="${product.id}" data-name="${product.name}" data-stock="${product.stock}">
                    <td>${product.name}</td>
                    <td>${product.price} <span>VNĐ</span></td>
                    <td>
                        <div class="quantity-container">
                            <button class="btn-change btn-plus">+</button>
                            <input type="number" class="quantity-display" value="1" min="1" />
                            <button class="btn-change btn-minus">-</button>
                        </div>
                    </td>
                    <td class="total-price">${product.price}</td>
                    <td><button class="btn-custome btn-remove">Xóa</button></td> 
                </tr>
            `);
            $invoiceListBody.append($row);
    
            updateSession();
            
            const $quantityInput = $row.find('.quantity-display');
            const stock = parseInt(product.stock);
            const productPrice = parseInt(product.price.replace(/\./g, ''));
    
            $quantityInput.on('input', function(e) {
                e.preventDefault();
                let quantity = parseInt($(this).val());
                if (isNaN(quantity) || quantity < 1) {
                    quantity = 1;
                    $(this).val(1);
                } else if (quantity > stock) {
                    quantity = stock;
                    $(this).val(stock);
                    showAlert('warning', 'Số lượng sản phẩm đã đạt tối đa tồn kho.');
                }
                const totalPrice = quantity * productPrice;
                $row.find('.total-price').text(totalPrice.toLocaleString() + " đ");
                updateGrandTotal();
                updateSession();
            });
    
            $row.find('.btn-plus').on('click', function(e) {
                e.preventDefault();
                let quantity = parseInt($quantityInput.val());
                if (quantity < stock) {
                    quantity++;
                    const totalPrice = quantity * productPrice;
                    $quantityInput.val(quantity);
                    $row.find('.total-price').text(totalPrice.toLocaleString() + " đ");
                    updateGrandTotal();
                    updateSession();
                } else {
                    showAlert('warning', 'Số lượng sản phẩm đã đạt tối đa tồn kho.');
                }
            });
    
            $row.find('.btn-minus').on('click', function(e) {
                e.preventDefault();
                let quantity = parseInt($quantityInput.val());
                if (quantity > 1) {
                    quantity--;
                    const totalPrice = quantity * productPrice;
                    $quantityInput.val(quantity);
                    $row.find('.total-price').text(totalPrice.toLocaleString() + " đ");
                    updateGrandTotal();
                    updateSession();
                }
            });
    
            $row.find('.btn-remove').on('click', function() {
                $row.remove();
                updateGrandTotal();
            });
        }
    
        updateGrandTotal();
    }


    // click vào sản phẩm
    $('.product-item').each(function() {
        const productStock = parseInt($(this).data('stock'));

        // Nếu stock bằng 0, thêm lớp 'out-of-stock'
        if (productStock === 0) {
            $(this).addClass('out-of-stock');

            $(this).append('<div class="out-of-stock-message">Tạm hết hàng</div>');
        }
    });

    // Xử lý sự kiện click khi sản phẩm được chọn

    $('.product-item').on('click', function() {
        const productID = $(this).find('#productID').val();
        const productName = $(this).data('name');
        const productStock = parseInt($(this).data('stock'));
        const productPrice = $(this).data('price');

        // Chỉ thêm vào hóa đơn nếu stock lớn hơn 0
        if (productStock > 0) {
            addProductToInvoice({ id: productID, name: productName, stock: productStock, price: productPrice });
        }
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
            if (cashAmount === '' || isNaN(cashAmount)) {
                errorSpan.html('Vui lòng nhập số tiền hợp lệ.<br>').show();
                $(this).val(''); // Xóa giá trị trong input
                return;
            }
    
            if (cashAmount < totalAmount) {
                errorSpan.html('Vui lòng nhập số tiền > Số tiền phải trả.<br>').show();
                $(this).val(''); 
                return;
            }
            
            if (cashAmount < 0) {
                errorSpan.html('Số tiền không được âm.<br>').show();
                $(this).val(''); // Xóa giá trị trong input
                return;
            }
    
            // Tính toán tiền trả lại
            const amountReturn = cashAmount - totalAmount;
            $(this).closest(".modal").find("#amountReturn").val(amountReturn.toLocaleString() + " ₫");
        });
    
        togglePaymentFields();
    });
    
    $('#processPayment').on('click', function() {
        let cashAmountInput = $('#cashAmount').val().trim(); 
        let cashAmount = parseFloat(cashAmountInput.replace(/,/g, '')); 
        let errorSpan = $('#cashAmountError'); // Thông báo lỗi
        let totalAmount = $("#total-amount").val().replace(/,/g, '');

        errorSpan.text('').hide();
        if (cashAmountInput === '' || isNaN(cashAmount) || cashAmount < totalAmount) {
            if (cashAmountInput === '' || isNaN(cashAmount)) {
                errorSpan.html('Vui lòng nhập số tiền hợp lệ.<br>').show();
            } else if (cashAmount < totalAmount) {
                errorSpan.html('Vui lòng nhập số tiền > Số tiền phải trả.<br>').show();
            }
            return; 
        }
    
        sendOrderData(); 
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


    function replaceWhitespace(value) {
        return value.trim().replace(/\s+/g, ' '); // Loại bỏ khoảng trắng dư thừa và thay thế chúng bằng một khoảng trắng đơn
    }
    
   
    function updateSession() {
        let invoiceData = [];
    
        
        let phone = replaceWhitespace($('#name-search').val());
        let customerName = replaceWhitespace($('#customerNameSell').val());
        let discountCode = replaceWhitespace($('#discountCode').val());
        let reduction = replaceWhitespace($('#reduction').val());

        // Duyệt qua các dòng sản phẩm trong hóa đơn
        $invoiceListBody.find('tr').each(function() {
            const productId = replaceWhitespace($(this).data('id')); 
            const productName = replaceWhitespace($(this).data('name'));
            const productStock = $(this).data('stock');
            const quantity = $(this).find('.quantity-display').val();
            const totalPrice = cleanPrice($(this).find('.total-price').text().replace(" đ", "").replace(/\./g, ''));
            const price = cleanPrice($(this).find('td').eq(1).text().replace(" VNĐ", "").replace(/\./g, ''));
    
            // Thêm thông tin vào mảng invoiceData
            invoiceData.push({
                id: productId,     // Thêm ID sản phẩm
                name: productName,
                stock: productStock,
                quantity: quantity,
                price: price,
                totalPrice: totalPrice
            });
        });

        let customerData = {
            phone: phone,
            customerName: customerName,
            couponID: discountCode,
            reduction: reduction
        };
    
      
        // Gửi thông tin vào server để lưu trữ vào session
        $.ajax({
            url: 'index.php?page=save_invoice', // Đường dẫn đến file PHP xử lý lưu trữ
            method: 'POST',
            data: {
                action: 'update_invoice',
                invoiceData: JSON.stringify(invoiceData),
                customerData: JSON.stringify(customerData)
            },
            success: function(response) {
                console.log('Thông tin hóa đơn đã được lưu vào session');
            },
            error: function(error) {
                console.error('Lỗi khi lưu thông tin vào session:', error);
            }
        });
    }
    

    // Hàm khởi tạo hóa đơn từ dữ liệu đã lưu
    function initializeInvoice(savedInvoiceData) {
        savedInvoiceData.forEach(function(product) {
            // Quá trình thêm các sản phẩm vào bảng hoặc xử lý hóa đơn
            const $existingRow = $invoiceListBody.find(`tr[data-id="${product.id}"]`);
            
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
                    updateSession();
                } else {
                    showAlert('warning', 'Số lượng sản phẩm đã đạt tối đa tồn kho.');
                }
            } else {
                // Nếu không tồn tại dòng sản phẩm, tạo mới dòng
                const $row = $(`
                    <tr data-id="${product.id}" data-name="${product.name}" data-stock="${product.stock}">
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
                const $quantityInput = $row.find('.quantity-display');
                const stock = product.stock;
                updateSession();
    
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
                    updateSession();
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
                        updateSession();
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
                        updateGrandTotal();
                        updateSession();
                    }
                });
    
                // Xử lý sự kiện xóa sản phẩm
                $row.find('.btn-remove').on('click', function() {
                    $row.remove();
                    updateGrandTotal();
                    updateSession();
                });
            }
    
            updateGrandTotal(); // Cập nhật tổng tiền
        });
    }
    


    function cleanPrice(value) {
        return value.replace(/[^0-9.]/g, ''); // Loại bỏ mọi ký tự không phải là số hoặc dấu chấm
    }

    // Hàm lấy phần trăm giảm giá
    function extractDiscount(value) {
        const match = value.match(/(\d+(\.\d+)?)/); // Tìm giá trị số (cả số nguyên và số thập phân)
        return match ? match[0] : '0'; // Nếu tìm thấy giá trị, trả về giá trị đó, nếu không trả về '0'
    }

    function collectOrderData() {
        let phone = replaceWhitespace($('#name-search').val());
        let customerName = replaceWhitespace($('#customerNameSell').val());
        let discountCode = replaceWhitespace($('#discountCode').val());
        let reduction = replaceWhitespace($('#reduction').val());

        // Làm sạch dữ liệu
        reduction = extractDiscount(reduction);  // Chỉ lấy phần trăm giảm giá

        let orderData = {
            phone: phone,
            customerName: customerName,
            couponID: discountCode,
            reduction: reduction,  // Sử dụng giá trị phần trăm giảm giá đã làm sạch
            items: [],
            paymentMethod: $('input[name="paymentMethod"]:checked').val(),
            totalAmount: cleanPrice($totalAmountDisplay.text()), // Làm sạch tổng tiền
        };

        $invoiceListBody.find('tr').each(function() {
            // Lấy thêm productID từ thuộc tính data-id
            const productID = replaceWhitespace($(this).data('id')); 
            const productName = replaceWhitespace($(this).data('name')); 
            const productStock = $(this).data('stock'); 
            const productPrice = cleanPrice(replaceWhitespace($(this).find('td').eq(1).text())); // Làm sạch giá sản phẩm
            const quantity = replaceWhitespace($(this).find('.quantity-display').val());
            const totalPrice = cleanPrice(replaceWhitespace($(this).find('.total-price').text())); // Làm sạch tổng giá trị sản phẩm

            orderData.items.push({
                id: productID,
                name: productName,
                stock: productStock,
                price: productPrice,
                quantity: quantity,
                total: totalPrice
            });
        });

        if (orderData.paymentMethod === 'Tiền mặt') {
            orderData.cashAmount = cleanPrice($('#cashAmount').val()); // Làm sạch tiền mặt
            orderData.amountReturn = cleanPrice($('#amountReturn').val()); // Làm sạch tiền thừa
        } else {
            orderData.accountInfo = $('#accountInfo').val();
        }

        return orderData;
    }

    

    // gửi data để lưu session
    function sendOrderData() {
        const orderData = collectOrderData();
        const isCash = $('#cash').is(':checked');
        const cashAmount = $('#cashAmount');
        const amountReturn = $('#amountReturn');
        const totalAmount = $("#total-amount"); 

        console.log("orderData : ", orderData);
        
        $.ajax({
            type: 'POST',
            url: 'index.php?page=processing_order',  // URL để xử lý lưu trữ đơn hàng
            data: JSON.stringify(orderData),
            contentType: 'application/json',
            success: function(response, status, xhr) {
                if (xhr.status === 200) {
                    showAlert('success', 'Đơn hàng đã được lưu thành công! <br> Tiền thối lại: ' + amountReturn.val() + ' VNĐ.');
    
                    // Gọi deleteSession và chờ nó hoàn tất
                    deleteSession()
                        .done(function() {
                            // Reset các trường nhập liệu
                           
                            $('#paymentModal').modal('hide');
                            updateUIForNoData();
                        })
                        .fail(function() {
                            console.log('Có lỗi xảy ra khi xóa session.');
                            $('#paymentModal').modal('hide'); // Đảm bảo modal đóng ngay cả khi xóa session lỗi
                        });
                } else {
                    showAlert('error', 'Có lỗi xảy ra khi lưu đơn hàng.');
                }
    
                setTimeout(function() {
                    $('.modal-backdrop').remove();
                }, 3000);
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
            method: 'GET', 
            dataType: 'json',  
            success: function(data) {
                if (data.status === 'success') {
                    initializeInvoice(data.data);
                } else {
                    console.error('Không có dữ liệu hóa đơn:', data.message);  // Lỗi nếu không có dữ liệu
                }
            },
            error: function(error) {
                updateUIForNoData();
                console.error('Có vấn đề với yêu cầu fetch:', error);  // Lỗi nếu fetch gặp sự cố
            }
        });
    }
    function updateUIForNoData() {
        const cashAmount = $('#cashAmount'); 
        const amountReturn = $('#amountReturn'); 
        const totalAmount = $("#total-amount"); 
        cashAmount.val("");
        amountReturn.val("");
        totalAmount.text("0.000");
        $invoiceListBody.empty(); // Xóa nội dung bảng
        $totalAmountDiscount.text("");
    }

    // Gọi hàm để lấy dữ liệu hóa đơn
    fetchDataInvoice();





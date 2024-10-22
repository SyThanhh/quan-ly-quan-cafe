$(document).ready(function() {
    const $invoiceListBody = $('#invoice-list-body');
    const $totalAmountDisplay = $('#total-amount');


   
    $('.btn-primary[data-toggle="modal"]').on('click', function() {
        $('#paymentModal').modal('show');
    });



    function convertToNumber(priceString) {
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
                alert('Số lượng sản phẩm đã đạt tối đa tồn kho.');
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

            $quantityInput.on('input', function() {
                let quantity = parseInt($(this).val());
                if (isNaN(quantity) || quantity < 1) {
                    $(this).val(1);
                    quantity = 1;
                } else if (quantity > stock) {
                    alert('Số lượng vượt quá tồn kho!');
                    $(this).val(stock);
                    quantity = stock;
                }
                const totalPrice = quantity * product.price;
                $row.find('.total-price').text(totalPrice.toLocaleString());
                updateGrandTotal();
            });

            $row.find('.btn-plus').on('click', function() {
                let quantity = parseInt($quantityInput.val());
                if (quantity < stock) {
                    quantity++;
                    $quantityInput.val(quantity);
                    const totalPrice = quantity * product.price;
                    $row.find('.total-price').text(totalPrice.toLocaleString());
                    updateGrandTotal();
                } else {
                    alert('Số lượng sản phẩm đã đạt tối đa tồn kho.');
                }
            });

            $row.find('.btn-minus').on('click', function() {
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

    function calculateChange() {
        const $cashAmountInput = $('#cashAmount');
        const $totalAmountInput = $('#total-amount');
        const $amountReturnInput = $('#amountReturn');
        const $cashAmountError = $('#cashAmountError');

        // Lấy giá trị và chuyển đổi thành số
        const cashAmount = parseFloat($cashAmountInput.val());
        const totalAmount = parseFloat($totalAmountInput.text().replace(/,/g, '')) || 0;

        // Reset thông báo lỗi
        $cashAmountError.hide().text('');

        // Kiểm tra xem cashAmount có phải là một số hợp lệ và không âm
        if (isNaN(cashAmount) || cashAmount < 0) {
            $cashAmountError.show().text('Vui lòng nhập số tiền hợp lệ (khác chữ và > 0).');
            $amountReturnInput.val('');
            return;
        }

        // Tính toán số tiền thối lại
        const amountReturn = cashAmount - totalAmount;

        // Cập nhật giá trị tiền thối lại
        $amountReturnInput.val(amountReturn >= 0 ? amountReturn : 0);
    }

    function processPayment() {
        const isCash = $('#cash').is(':checked');
        if (isCash) {
            const cashAmount = $('#cashAmount').val();
            const amountReturn = $('#amountReturn').val();
            alert('Thanh toán tiền mặt với số tiền: ' + cashAmount + ' VNĐ. Tiền thối lại: ' + amountReturn + ' VNĐ.');
        } else {
            const accountInfo = $('#accountInfo').val();
            alert('Thanh toán bằng chuyển khoản với thông tin tài khoản: ' + accountInfo);
        }
        // Đóng modal sau khi xác nhận
        $('#paymentModal').modal('hide');
    }

    // Gắn sự kiện cho các nút trong modal
    $('#paymentModal').on('shown.bs.modal', function() {
        togglePaymentFields();
    });
});
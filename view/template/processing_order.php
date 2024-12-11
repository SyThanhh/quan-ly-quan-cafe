<?php
header('Content-Type: application/json');
include_once('./controller/OrderController.php'); 
$orderController = new OrderController();
include_once('./controller/OrderDetailController.php'); 
$orderDetailController = new OrderDetailController();
include_once('./controller/CustomerController.php'); 
$CustomerController = new CustomerController();

include_once('./controller/ProductController.php'); 
$ProductController = new ProductController();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ yêu cầu POST
    $orderData = json_decode(file_get_contents('php://input'), true);

    
    if ($orderData && is_array($orderData)) {
        $employeeID = $orderData['employeeId'] ?? '';
        $phone = $orderData['phone'] ?? '';
        $customerName = $orderData['customerName'] ?? '';
        $couponID = $orderData['couponID']??'';
        $reduction =  $orderData['reduction'] ?? '0.0';
        $products = $orderData['items'] ?? [];
        $paymentMethod = $orderData['paymentMethod'] ?? '';
        $totalAmount = $orderData['totalAmount'] ?? '';
        $cashAmount = $orderData['cashAmount'] ?? '';
        $amountReturn = $orderData['amountReturn'] ?? '';

        $customer = $CustomerController->getAllCustomersByPhoneAndEmail($phone);
        if($customer) {
            $customerID = $customer['CustomerID'];
        } else {
            $customerID = null;

        }
        $checkOrderDetail = false;
        $OrderID = $orderController->SaveOrder($reduction, $paymentMethod, $totalAmount,$couponID, $customerID, $employeeID);
        foreach ($products as $product) {
            $productID = $product['id'] ?? null;
            $quantity = $product['quantity'] ?? 1;
            $unitprice = $product['price'] ?? 0;

            $checkOrderDetail  = $orderDetailController->SaveOrderDetail($OrderID, $productID, $unitprice, $quantity);
            $checkProductInstock = $ProductController->updateQuantityInStock($productID, $quantity);
            
        }

        if ($customerID !== null) {
            if ($couponID === null) {
                $checkPointCustomer = $CustomerController->updateCustomerPoint($customerID, $totalAmount);
            } 
            else {
                $checkPointCustomer = $CustomerController->updateCustomerPoint($customerID, $totalAmount);
                
                $checkPointCustomerWithCoupon = $CustomerController->updateCustomerPointWithCoupon($customerID, $reduction);
            }
        }
        

        // Kiểm tra kết quả lưu
        if ($OrderID!== false) {
            // Nếu lưu thành công
            echo json_encode([
                // 'checkPointCustomerWithCoupon'=> $checkPointCustomerWithCoupon,
                // 'checkProductInstock '=> $checkProductInstock,
                // 'checkPointCustomer '=> $checkPointCustomer,
                // 'checkOrderDetail '=> $checkOrderDetail,
                'success' => true,
                'message' => 'Đơn hàng đã được lưu thành công!',
                'data' => [
                    'productID' => $productID,
                    'CustomerID' => $customerID,
                    'phone' => $phone,
                    'customerName' => $customerName,
                    'couponID' => $couponID,
                    'reduction' => $reduction,
                    'products' => $products,
                    'paymentMethod' => $paymentMethod,
                    'totalAmount' => $totalAmount,
                    'cashAmount' => $cashAmount,
                    'amountReturn' => $amountReturn,
                ]
            ]);
        } else {
            // Nếu lưu thất bại
            echo json_encode([
                // 'checkPointCustomerWithCoupon'=> $checkPointCustomerWithCoupon,
                // 'checkProductInstock '=> $checkProductInstock,
                // 'checkPointCustomer '=> $checkPointCustomer,
                // 'checkOrderDetail '=> $checkOrderDetail,
                'success' => false,
                'message' => 'Đơn hàng không được lưu thành công. Vui lòng thử lại!',
                'data' => [
                    'CustomerID' => $customerID,
                    'phone' => $phone,
                    'customerName' => $customerName,
                    'couponID' => $couponID,
                    'reduction' => $reduction,
                    'products' => $products,
                    'paymentMethod' => $paymentMethod,
                    'totalAmount' => $totalAmount,
                    'cashAmount' => $cashAmount,
                    'amountReturn' => $amountReturn
                ]
            ]);
        }
    } else {
        // Nếu dữ liệu JSON không hợp lệ
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Dữ liệu JSON không hợp lệ.'
        ]);
    }

} else {
    // Nếu không phải yêu cầu POST, trả về lỗi 405
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
}
?>

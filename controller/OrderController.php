<?php
    include("model/mOrder.php");
    include_once('OrderController.php'); 
    include_once('OrderDetailController.php'); 
 
    include_once('CustomerController.php'); 
    
    include_once('ProductController.php'); 
    
    
    class OrderController {
        private $mOrder;

        public function __construct() {
            $this->mOrder = new ModelOrder();
        }
    

        public function getAllOrders($fromdate, $todate) {
            $tblOrders = $this->mOrder->selectAll($fromdate, $todate);
        
            if ($tblOrders) {
                if ($tblOrders->num_rows > 0) {
                    return $tblOrders; 
                } else {
                    return null; 
                }
            } else {
                return false; 
            }
        }

        public function SaveOrder($discount, $payment, $total, $couponID, $customerID, $employeeID) {
            // $couponID = empty($couponID) ? 6 : trim($couponID);
            $id = $this->mOrder->generateNewId();
            
            // $couponID = empty($couponID) ? 6 : trim($couponID);
               
           
            $result = $this->mOrder->add($id, $discount, $payment, $total, $couponID, $customerID, $employeeID);
        
            
            return $result ? $id : false;
        }

        public function test() {
            return $this->mOrder->createID();
        }
        
        public function getOrder($id) {
            $order = $this->mOrder->getOrderById($id);
            
            if ($order) {
                return $order;
            } else {
                return false; // Có lỗi xảy ra
            }
        }
        // pagination
        public function listOrders($fromdate, $todate, $limit, $offset) {
            return $this->mOrder->getOrders($limit, $offset, $fromdate, $todate);
        }
        public function getTotalPages($fromdate, $todate, $limit) {
            $totalOrders = $this->mOrder->getTotalOrders($fromdate, $todate);
            return ceil($totalOrders / $limit);
        }

        public function createOrderID() {
            $orderID = $this->mOrder->generateNewId();
            return $orderID ?? null;
        }
        
           
       public function processingOrderData() {
        header('Content-Type: application/json');
        $orderController = new OrderController();
        $orderDetailController = new OrderDetailController();
        $CustomerController = new CustomerController();
        $ProductController = new ProductController();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ yêu cầu POST
            $orderData = json_decode(file_get_contents('php://input'), true);
        
            
            if ($orderData && is_array($orderData)) {
                $phone = $orderData['phone'] ?? '';
                $customerName = $orderData['customerName'] ?? '';
                $couponID = $orderData['couponID']??'';
                $reduction =  $orderData['reduction'] ?? '0.0';
                $products = $orderData['items'] ?? [];
                $paymentMethod = $orderData['paymentMethod'] ?? '';
                $totalAmount = $orderData['totalAmount'] ?? '';
                $cashAmount = $orderData['cashAmount'] ?? '';
                $amountReturn = $orderData['amountReturn'] ?? '';
        
                $customer = $CustomerController->getAllCustomersByPhone($phone);
                if($customer) {
                    $customerID = $customer['CustomerID'];
                } else {
                    $customerID = null;
        
                }
                $checkOrderDetail = false;
                $OrderID = $orderController->SaveOrder($reduction, $paymentMethod, $totalAmount,$couponID, $customerID, 2 );
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
       }
        

    
    }
?>
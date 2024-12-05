<?php
    include("model/mOrder.php");

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

        public function addOrder($discount, $payment, $total, $couponID, $customerID, $employeeID) {
               
           
            $result = $this->mOrder->add($discount, $payment, $total, $couponID, $customerID, $employeeID);
        
            // Kiểm tra kết quả thực thi
            if ($result) {
                return true; // Thêm đơn hàng thành công
            } else {
                return false; // Thêm đơn hàng không thành công
            }
        }
        
        public function getOrder($id) {
            $order = $this->mOrder->getOrderById($id);
            
            if ($order) {
                return $order;
            } else {
                return false; // Có lỗi xảy ra
            }
        }

        
        

    
    }
?>
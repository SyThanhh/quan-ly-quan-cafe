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

        public function listOrders($fromdate, $todate, $limit, $offset) {
            return $this->mOrder->getOrders($limit, $offset, $fromdate, $todate);
        }
        public function getTotalPages($fromdate, $todate, $limit) {
            $totalOrders = $this->mOrder->getTotalOrders($fromdate, $todate);
            return ceil($totalOrders / $limit);
        }
        
        

    
    }
?>
<?php
    include("model/mOrderDetail.php");

    class OrderDetailController {
        private $mOrderDetail;

        public function __construct() {
            $this->mOrderDetail = new ModelOrderDetail();
        }
    

        public function SaveOrderDetail($OrderID, $ProductID, $UnitPrice, $Quantity) {
            
               
            $result = $this->mOrderDetail->add($OrderID, $ProductID, $UnitPrice, $Quantity);
        
            if ($result) {
                return true; // Thêm đơn hàng thành công
            } else {
                return false; // Thêm đơn hàng không thành công
            }
        }

   
      

        
        

    
    }
?>
<?php
    include("model/mProduct.php");

    class ProductController {
        private $mProduct;

        public function __construct() {
            $this->mProduct = new ModelProduct();
        }
    



        public function updateQuantityInStock($id, $quantity) {
            $id = empty($id) ? null :  trim($id);
            $quantity = empty($quantity) ? null :  trim($quantity);
            $result = $this->mProduct->updateQuantityInStock($id, $quantity);
            if($result) {
                return true;
            }
            return false;
        }
       

    
    }
?>
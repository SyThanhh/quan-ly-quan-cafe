<?php
    include("model/mCustomer.php");

    class ProductController {
        private $mProduct;

        public function __construct() {
            $this->mProduct = new ModelProduct();
        }
    

        public function getAllProducts($keyword) {
            $tblProduct = $this->mProduct->selectAll($keyword);
        
            if ($tblProduct) {
                if ($tblProduct->num_rows > 0) {
                    return $tblProduct; 
                } else {
                    return null; 
                }
            } else {
                return false; 
            }
        }

       

    
    }
?>
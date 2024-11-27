<?php
    include_once('./model/mMenu.php');
    class cProduct{
        public function getProduct() {
            $p = new mProduct();
            $tbl = $p->selProduct();
        
            
            if ($tbl && is_object($tbl)) {
                if (mysqli_num_rows($tbl) > 0) {
                    return $tbl;
                } else {
                    return false;
                }
            } else {
                echo 'Lỗi kết nối!';
                return false;
            }
        }

        public function getProductByName($ProductName){
            $p = new mProduct();
            $tbl = $p -> selProductByName($ProductName);
            if($tbl){
                if(mysqli_num_rows($tbl)>0){
                    return $tbl;
                }
                else{
                    return false;
                }
            }
            else{
                echo 'Không có sản phẩm cần tìm!';
            }
        }
            public function get01ProductByID($ProductID){
            $p = new mProduct();
            $tbl = $p -> sel01ProductByID($ProductID);
            if($tbl){
                if(mysqli_num_rows($tbl)>0){
                    return $tbl;
                }
                else{
                    return false;
                }
            }
            else{
                echo 'Lỗi kết nối!';
            }
        }

        public function cUpDateMenu($ProductID, $ProductName, $UnitPrice, $file, $UnitsInStock, $Status, $Description, $CreateAt, $UpdatedAt, $RequestID, $CategoryName){
           $p = new mProduct();
           $tbl = $p -> mUpDateMenu($ProductID, $ProductName, $UnitPrice, $file, $UnitsInStock, $Status, $Description, $CreateAt, $UpdatedAt, $RequestID, $CategoryName);
           if($tbl){
                return $tbl;
            }
            else{
                echo 'Lỗi kết nối!';
            }
        }

            public function cInSertMenu($ProductID, $ProductName, $UnitPrice, $file, $UnitsInStock, $Status, $Description, $CreateAt, $UpdatedAt, $RequestID, $CategoryName){
                $p = new mProduct();
                $tbl = $p -> mInsertMenu($ProductID, $ProductName, $UnitPrice, $file, $UnitsInStock, $Status, $Description, $CreateAt, $UpdatedAt, $RequestID, $CategoryName);
                if($tbl){
                     return $tbl;
                 }
                 else{
                     echo 'Lỗi kết nối!';
                 }
            }
            
            public function cDeleteMenu($ProductID){
                $p = new mProduct();
                return $p -> mDeleteMenu($ProductID);
            }

            public function listMenu($searchKeyword, $limit, $offset) {
                $p = new mProduct();
                return $p->getMenu($searchKeyword, $limit, $offset);  // Gọi phương thức từ model
            }
        
            // Lấy tổng số trang cho phân trang
            public function getTotalPages($searchKeyword, $limit) {
                $p = new mProduct();
                $totalMenu = $p->getTotalMenu($searchKeyword);  // Lấy tổng số sản phẩm theo từ khóa tìm kiếm
                return ceil($totalMenu / $limit);  // Tính tổng số trang
            }

    }
?>
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

        public function getProductByType($CategoryID) {
            $p = new mProduct();
            $tbl = $p->selProductByType($CategoryID);
            
            if ($tbl) {
                if (mysqli_num_rows($tbl) > 0) {
                    return $tbl;
                } else {
                    return false; 
                }
            } else {
                echo 'Lỗi kết nối!';
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

            public function listProduct($searchKeyword = '', $limit = 5, $offset = 0) {
                global $conn; // Nếu bạn sử dụng kết nối toàn cục
                $sql = "SELECT * FROM product p join category c on c.CategoryID = p.CategoryID WHERE p.ProductName LIKE '%$searchKeyword%' LIMIT $limit OFFSET $offset";
                return mysqli_query($conn, $sql); // Trả về kết quả của câu truy vấn
            }
        
            // Phương thức lấy tổng số trang
            public function getTotalPageProduct($searchKeyword = '', $limit = 5) {
                global $conn;
                $sql = "SELECT COUNT(*) FROM product p join category c on c.CategoryID = p.CategoryID WHERE p.ProductName LIKE '%$searchKeyword%'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_row($result);
                return ceil($row[0] / $limit); // Trả về tổng số trang
            }

    }
?>
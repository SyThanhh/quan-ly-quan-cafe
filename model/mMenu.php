<?php
    include_once('./connect/database.php');
    class mProduct{
        public function selProduct(){
            $p = new Database();
            $con = $p -> connect();
            if($con){
                $str = "SELECT p.ProductID, p.ProductName, p.UnitPrice, p.ProductImage, p.UnitsInStock, p.Status, p.Description, p.CreateAt, p.UpdatedAt, p.RequestID, c.CategoryName from product p join category c on p.CategoryID = c.CategoryID";
                $tbl = mysqli_query($con, $str);
                return $tbl;
            }
            else{
                echo 'Lỗi kết nối!';
            }
        }
        public function sel01ProductByID($ProductID){
            $p = new Database();
            $con = $p -> connect();
            if($con){
                $str = "select p.ProductID, p.ProductName, p.UnitPrice, p.ProductImage, p.UnitsInStock, p.Status, p.Description, p.CreateAt, p.UpdatedAt, p.RequestID, c.CategoryName from product p join category c on p.CategoryID = c.CategoryID where p.ProductID = '$ProductID'";
                $tbl = mysqli_query($con, $str);
                return $tbl;
            }
            else{
                echo 'Lỗi kết nối!';
            }
        }

        public function mUpDateMenu($ProductID, $ProductName, $UnitPrice, $ProductImage, $UnitsInStock, $Status, $Description, $CreateAt, $UpdatedAt, $RequestID, $CategoryName): bool|mysqli_result{
            $p = new Database();
            $con = $p -> connect();
            if($con){
                $str = "update product set ProductName = N'$ProductName', UnitPrice = N'$UnitPrice', ProductImage = N'$ProductImage', UnitsInStock = N'$UnitsInStock', 
                Status = N'$Status', Description = N'$Description', CreateAt = N'$CreateAt', UpdatedAt = N'$UpdatedAt', RequestID = N'$RequestID', CategoryName = N'$CategoryName' where ProductID = '$ProductID'";
                $tbl = mysqli_query($con, $str);
                return $tbl;
            }
            else{
                return false;
            }
        }

        public function mInSertMenu($ProductID, $ProductName, $UnitPrice, $ProductImage, $UnitsInStock, $Status, $Description, $CreateAt, $UpdatedAt, $RequestID, $CategoryID, $CategoryName){
            $p = new Database();
            $str = "insert into product(ProductID, ProductName, UnitPrice, ProductImage, UnitsInStock, Status, Description, CreateAt, UpdatedAt, RequestID, CategoryID) values(N'$ProductID', N'$ProductName', N'$UnitPrice', N'$ProductImage', N'$UnitsInStock', N'$Status', N'$Description', N'$CreateAt', N'$UpdatedAt', N'$RequestID', N'$CategoryName')";
            try{
                $con = $p -> connect();
                $tbl = mysqli_query($con, $str);
                return $tbl;
            }catch(Exception $e){
                return false;
            }
        }

        public function mDeleteMenu($ProductID){
            $p = new Database();
            $str = "delete from product where ProductID = '$ProductID'";
            try{
                $con = $p -> connect();
                $tbl = mysqli_query($con, $str);
                return $tbl;
            }catch(Exception $e){
                return false;
            }
        }
    }
?>
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
        
        public function mUpDateMenu($ProductID, $ProductName, $UnitPrice, $file, $UnitsInStock, $Status, $Description, $CreateAt, $UpdatedAt, $RequestID, $CategoryID) {
            $p = new Database();
            $con = $p->connect();
            if (!$con) {
                echo "Lỗi kết nối cơ sở dữ liệu!<br>";
                return false; 
            }
            $query = "SELECT ProductImage FROM product WHERE ProductID = '$ProductID'";
            $result = mysqli_query($con, $query);
            $oldImage = "";
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $oldImage = $row['ProductImage'];
            }
        
            $ProductImage = "";
        
            if (is_array($file) && isset($file['tmp_name'])) {
                $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
                $name = $file["name"];
                $target_file = "" . $name;
        
                if ($file["size"] > 500000) {
                    echo "Tệp của bạn quá lớn.<br>";
                    return false;
                }
        
                if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                    echo "Chỉ cho phép tệp JPG, JPEG, PNG & GIF.<br>";
                    return false; 
                }
        
                if (move_uploaded_file($file["tmp_name"], $target_file)) {
                    echo "Tệp " . htmlspecialchars(basename($target_file)) . " đã được upload.<br>";
                    $ProductImage = $target_file;
        
                    if (!empty($oldImage) && file_exists($oldImage)) {
                        unlink($oldImage); 
                    }
                } else {
                    echo "Đã xảy ra lỗi khi upload tệp.<br>";
                    return false;
                }
            }
        
            $str = "UPDATE product SET ProductName = N'$ProductName', UnitPrice = '$UnitPrice', ProductImage = '$ProductImage', UnitsInStock = '$UnitsInStock', Status = '$Status', Description = N'$Description', CreateAt = '$CreateAt', UpdatedAt = '$UpdatedAt', RequestID = '$RequestID', CategoryID = '$CategoryID' 
                    WHERE ProductID = '$ProductID'";
        
            if (mysqli_query($con, $str)) {
                return true; 
            } else {
                echo "Lỗi khi thực hiện câu lệnh SQL: " . mysqli_error($con) . "<br>";
                return false; 
            }
        }
        public function mInSertMenu($ProductID, $ProductName, $UnitPrice, $file, $UnitsInStock, $Status, $Description, $CreateAt, $UpdatedAt, $RequestID, $CategoryID) {
            $p = new Database();
            $con = $p->connect();
        
            if (!$con) {
                echo "Lỗi kết nối cơ sở dữ liệu!<br>";
                return false;
            }
        
            $ProductImage = "";
        
            if (is_array($file) && isset($file['tmp_name'])) {
                $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
                $target_file = "" . $imageFileType; 
 
                if ($file["size"] > 500000) {
                    echo "Tệp của bạn quá lớn.<br>";
                    return false;
                }
        
                if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                    echo "Chỉ cho phép tệp JPG, JPEG, PNG & GIF.<br>";
                    return false; 
                }
        
                if (move_uploaded_file($file["tmp_name"], $target_file)) {
                    echo "Tệp " . htmlspecialchars(basename($target_file)) . " đã được upload.<br>";
                    $ProductImage = $target_file;
                } else {
                    echo "Đã xảy ra lỗi khi upload tệp.<br>";
                    return false; 
                }
            } else {
                echo "Không có tệp nào được upload hoặc tệp không hợp lệ.<br>";
            }
        
            $str = "INSERT INTO product (ProductID, ProductName, UnitPrice, ProductImage, UnitsInStock, Status, Description, CreateAt, UpdatedAt, RequestID, CategoryID) 
                    VALUES (N'$ProductID', N'$ProductName', N'$UnitPrice', N'$ProductImage', N'$UnitsInStock', N'$Status', N'$Description', N'$CreateAt', N'$UpdatedAt', N'$RequestID', N'$CategoryID')";
            
            if (mysqli_query($con, $str)) {
                return true;
            } else {
                echo "Lỗi khi thực hiện câu lệnh SQL: " . mysqli_error($con) . "<br>";
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
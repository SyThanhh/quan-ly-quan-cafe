<?php
    include_once('./connect/database.php');
    class mProduct{
        public function selProduct(){
            $p = new Database();
            $con = $p -> connect();
            if($con){
                $str = "select p.ProductID, p.ProductName, p.UnitPrice, p.ProductImage, p.UnitsInStock, p.Status, p.Description, p.CreateAt, p.UpdatedAt, p.RequestID, c.CategoryName from product p join category c on p.CategoryID = c.CategoryID";
                $tbl = mysqli_query($con, $str);
                return $tbl;
            }
            else{
                echo 'Lỗi kết nối!âa';
            }
        }

        public function selProductByName($ProductName){
            $p = new Database();
            $con = $p -> connect();
            if($con){
                $str = "select p.ProductID, p.ProductName, p.UnitPrice, p.ProductImage, p.UnitsInStock, p.Status, p.Description, p.CreateAt, p.UpdatedAt, p.RequestID, 
                c.CategoryName from product p join category c on p.CategoryID = c.CategoryID where ProductName like N'%$ProductName%'";
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
                $str = "select p.ProductID, p.ProductName, p.UnitPrice, p.ProductImage, p.UnitsInStock, p.Status, p.Description, p.CreateAt, p.UpdatedAt, p.RequestID, c.CategoryName 
                from product p join category c on p.CategoryID = c.CategoryID where p.ProductID = '$ProductID'";
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

        public function getMenu($limit, $offset, $keyword = '') {
            // Bắt đầu xây dựng truy vấn SQL cho bảng product
            $p = new Database();  // Tạo đối tượng kết nối
            $con = $p->connect();  // Kết nối đến cơ sở dữ liệu
            
            // Bắt đầu truy vấn SQL
            $query = "SELECT * FROM product WHERE Status = 1";
            
            // Nếu có từ khóa tìm kiếm, thêm vào điều kiện LIKE cho ProductName
            if (!empty($keyword)) {
                $query .= " AND ProductName LIKE ?";
            }
            
            // Thêm phần LIMIT và OFFSET
            $query .= " LIMIT ? OFFSET ?";
            
            // Chuẩn bị truy vấn
            $stmt = mysqli_prepare($con, $query); // Sử dụng $con thay vì $this->con
        
            if ($stmt) {
                // Nếu có từ khóa tìm kiếm, gắn tham số tìm kiếm và LIMIT/OFFSET
                if (!empty($keyword)) {
                    $searchTerm = "%$keyword%";
                    mysqli_stmt_bind_param($stmt, "ssii", $searchTerm, $searchTerm, $limit, $offset);
                } else {
                    // Nếu không có từ khóa tìm kiếm, chỉ gắn LIMIT và OFFSET
                    mysqli_stmt_bind_param($stmt, "ii", $limit, $offset);
                }
        
                // Thực thi truy vấn
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
        
                // Lấy kết quả
                $menu = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $menu[] = $row;
                }
        
                // Đóng statement
                mysqli_stmt_close($stmt);
        
                return $menu;  // Trả về danh sách sản phẩm
            }
        
            return [];  // Nếu không có dữ liệu, trả về mảng rỗng
        }
        
        
        public function getTotalMenu($keyword = '') {
            // Xây dựng truy vấn đếm tổng số sản phẩm trong bảng product
            $p = new Database();  // Tạo đối tượng kết nối
            $con = $p->connect(); 
            $query = "SELECT COUNT(*) as total FROM product WHERE Status = 1";
            
            // Nếu có từ khóa tìm kiếm, thêm vào điều kiện LIKE cho ProductName
            if (!empty($keyword)) {
                $query .= " AND ProductName LIKE ?";
            }
        
            // Chuẩn bị truy vấn
            $stmt = mysqli_prepare($con, $query);
        
            if ($stmt) {
                // Nếu có từ khóa tìm kiếm, gắn tham số tìm kiếm
                if (!empty($keyword)) {
                    $searchTerm = "%$keyword%";
                    mysqli_stmt_bind_param($stmt, "s", $searchTerm);
                }
        
                // Thực thi truy vấn
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $data = mysqli_fetch_assoc($result);
        
                mysqli_stmt_close($stmt);
        
                return $data['total'];  // Trả về tổng số sản phẩm
            }
        
            return 0;  // Nếu không có sản phẩm, trả về 0
        }
        
    }
?>
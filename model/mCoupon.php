<?php
    include_once('./connect/database.php');
    class mCoupon{
        public function selCoupon(){
            $p = new Database();
            $con = $p -> connect();
            if($con){
                $str = "SELECT CouponID, CouponCode, StartDate, EndDate, Description, CouponDiscount, Status, UpDateAt from coupon";
                $tbl = mysqli_query($con, $str);
                return $tbl;
            }
            else{
                echo 'Lỗi kết nối!';
            }
        }

        public function selCouponByCode($CouponCode){
            $p = new Database();
            $con = $p -> connect();
            if($con){
                $str = "select CouponID, CouponCode, StartDate, EndDate, Description, CouponDiscount, Status, UpDateAt from coupon where CouponCode like N'%$CouponCode%'";
                $tbl = mysqli_query($con, $str);
                return $tbl;
            }
            else{
                echo 'Lỗi kết nối!';
            }
        }
        public function selCouponByPoint($point) {
            $p = new Database();
            $con = $p->connect();
        
            if ($con) {
                if ($point >= 100) {
                    // Hạng Kim Cương: 100 điểm trở lên, giảm 20%
                    $str = "SELECT CouponID, CouponCode, StartDate, EndDate, Description, CouponDiscount, Status, UpDateAt 
                            FROM coupon 
                            WHERE CouponDiscount = 20 AND CURDATE() BETWEEN StartDate AND EndDate";
                } elseif ($point >= 70) {
                    // Hạng Vàng: 70 điểm trở lên, giảm 15%
                    $str = "SELECT CouponID, CouponCode, StartDate, EndDate, Description, CouponDiscount, Status, UpDateAt 
                            FROM coupon 
                            WHERE CouponDiscount = 15 AND CURDATE() BETWEEN StartDate AND EndDate";
                } elseif ($point >= 50) {
                    // Hạng Bạc: 50 điểm trở lên, giảm 10%
                    $str = "SELECT CouponID, CouponCode, StartDate, EndDate, Description, CouponDiscount, Status, UpDateAt 
                            FROM coupon 
                            WHERE CouponDiscount = 10 AND CURDATE() BETWEEN StartDate AND EndDate";
                } else {
                    // Không đủ điểm cho bất kỳ hạng nào, trả về kết quả rỗng
                    return null;
                }
        
                // Thực hiện truy vấn SQL
                $tbl = mysqli_query($con, $str);
                return $tbl;
            } else {
                echo 'Lỗi kết nối!';
                return null;
            }
        }
        

        public function sel01CouponByID($CouponID){
            $p = new Database();
            $con = $p -> connect();
            if($con){
                $str = "select CouponID, CouponCode, StartDate, EndDate, Description, CouponDiscount, Status, UpDateAt from coupon where CouponID = '$CouponID'";
                $tbl = mysqli_query($con, $str);
                return $tbl;
            }
            else{
                echo 'Lỗi kết nối!';
            }
        }

        public function mUpDateCp($CouponID, $CouponCode, $StartDate, $EndDate, $Description, $CouponDiscount, $Status, $UpDateAt){
            $p = new Database();
            $con = $p -> connect();
            if($con){
                $str = "update coupon set CouponCode = N'$CouponCode', StartDate = N'$StartDate', EndDate = N'$EndDate', Description = N'$Description', 
                CouponDiscount = N'$CouponDiscount', Status = N'$Status', UpDateAt = N'$UpDateAt' where CouponID = '$CouponID'";
                $tbl = mysqli_query($con, $str);
                return $tbl;
            }
            else{
                return false;
            }
        }

        public function mInSertCp($CouponCode, $StartDate, $EndDate, $Description, $CouponDiscount, $Status, $UpDateAt){
            $p = new Database();
            $str = "insert into coupon(CouponCode, StartDate, EndDate, Description, CouponDiscount, Status, UpDateAt) values(N'$CouponCode', N'$StartDate', N'$EndDate', N'$Description', N'$CouponDiscount', N'$Status', N'$UpDateAt')";
            try{
                $con = $p -> connect();
                $tbl = mysqli_query($con, $str);
                return $tbl;
            }catch(Exception $e){
                return false;
            }
        }

        public function mDeleteCp($CouponID){
            $p = new Database();
            $str = "delete from coupon where CouponID = $CouponID";
            try{
                $con = $p -> connect();
                $tbl = mysqli_query($con, $str);
                return $tbl;
            }catch(Exception $e){
                return false;
            }
        }

        public function getCoupon($limit, $offset, $keyword = '') {
            // Bắt đầu xây dựng truy vấn SQL cho bảng Coupon
            $p = new Database();  // Tạo đối tượng kết nối
            $con = $p->connect();  // Kết nối đến cơ sở dữ liệu
            
            // Bắt đầu truy vấn SQL
            $query = "SELECT * FROM Coupon WHERE Status = 1";
            
            // Nếu có từ khóa tìm kiếm, thêm vào điều kiện LIKE cho CouponName
            if (!empty($keyword)) {
                $query .= " AND CouponName LIKE ?";
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
                $Coupon = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $Coupon[] = $row;
                }
        
                // Đóng statement
                mysqli_stmt_close($stmt);
        
                return $Coupon;  // Trả về danh sách sản phẩm
            }
        
            return [];  // Nếu không có dữ liệu, trả về mảng rỗng
        }
        public function getTotalCoupon($keyword = '') {
            // Xây dựng truy vấn đếm tổng số sản phẩm trong bảng Coupon
            $p = new Database();  // Tạo đối tượng kết nối
            $con = $p->connect(); 
            $query = "SELECT COUNT(*) as total FROM Coupon WHERE Status = 1";
            
            // Nếu có từ khóa tìm kiếm, thêm vào điều kiện LIKE cho CouponName
            if (!empty($keyword)) {
                $query .= " AND CouponName LIKE ?";
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
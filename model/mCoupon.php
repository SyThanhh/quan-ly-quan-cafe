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

        public function getCoupon($limit, $offset, $keyword = '', $startDate = '', $endDate = '') {
            global $conn;  // Sử dụng kết nối toàn cục
        
            // Xây dựng truy vấn SQL
            $query = "SELECT * FROM Coupon WHERE Status = 1";
            
            // Thêm điều kiện tìm kiếm từ khóa
            if (!empty($keyword)) {
                $query .= " AND CouponName LIKE ?";
            }
            
            // Thêm điều kiện ngày bắt đầu nếu có
            if (!empty($startDate)) {
                $query .= " AND StartDate >= ?";
            }
            
            // Thêm điều kiện ngày kết thúc nếu có
            if (!empty($endDate)) {
                $query .= " AND EndDate <= ?";
            }
            
            // Thêm LIMIT và OFFSET
            $query .= " LIMIT ? OFFSET ?";
            
            // Chuẩn bị câu truy vấn
            $stmt = mysqli_prepare($conn, $query);
            
            if ($stmt) {
                // Xử lý tham số
                $params = [];
                $types = '';  // Chuỗi kiểu dữ liệu của các tham số
                
                if (!empty($keyword)) {
                    $params[] = "%$keyword%";
                    $types .= 's';  // 's' cho kiểu dữ liệu string
                }
                if (!empty($startDate)) {
                    $params[] = $startDate;
                    $types .= 's';  // 's' cho kiểu dữ liệu string
                }
                if (!empty($endDate)) {
                    $params[] = $endDate;
                    $types .= 's';  // 's' cho kiểu dữ liệu string
                }
                
                // Thêm tham số cho LIMIT và OFFSET
                $params[] = $limit;
                $params[] = $offset;
                $types .= 'ii';  // 'i' cho kiểu dữ liệu integer
                
                // Gắn tham số vào câu truy vấn
                mysqli_stmt_bind_param($stmt, $types, ...$params);
                
                // Thực thi truy vấn
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                
                // Lấy dữ liệu kết quả
                $coupons = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $coupons[] = $row;
                }
                
                // Đóng statement
                mysqli_stmt_close($stmt);
                
                return $coupons;  // Trả về danh sách phiếu giảm giá
            }
            
            return [];  // Nếu không có dữ liệu, trả về mảng rỗng
        }
        
        public function getTotalCoupon($keyword = '', $startDate = '', $endDate = '') {
            global $conn;  // Sử dụng kết nối toàn cục
            
            // Xây dựng truy vấn đếm tổng số phiếu giảm giá
            $query = "SELECT COUNT(*) as total FROM Coupon WHERE Status = 1";
            
            // Thêm điều kiện tìm kiếm từ khóa
            if (!empty($keyword)) {
                $query .= " AND CouponName LIKE ?";
            }
            
            // Thêm điều kiện ngày bắt đầu nếu có
            if (!empty($startDate)) {
                $query .= " AND StartDate >= ?";
            }
            
            // Thêm điều kiện ngày kết thúc nếu có
            if (!empty($endDate)) {
                $query .= " AND EndDate <= ?";
            }
            
            // Chuẩn bị câu truy vấn
            $stmt = mysqli_prepare($conn, $query);
            
            if ($stmt) {
                // Xử lý tham số
                $params = [];
                $types = '';  // Chuỗi kiểu dữ liệu của các tham số
                
                if (!empty($keyword)) {
                    $params[] = "%$keyword%";
                    $types .= 's';  // 's' cho kiểu dữ liệu string
                }
                if (!empty($startDate)) {
                    $params[] = $startDate;
                    $types .= 's';  // 's' cho kiểu dữ liệu string
                }
                if (!empty($endDate)) {
                    $params[] = $endDate;
                    $types .= 's';  // 's' cho kiểu dữ liệu string
                }
                
                // Gắn tham số vào câu truy vấn
                mysqli_stmt_bind_param($stmt, $types, ...$params);
                
                // Thực thi truy vấn
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $data = mysqli_fetch_assoc($result);
                
                // Đóng statement
                mysqli_stmt_close($stmt);
                
                return $data['total'];  // Trả về tổng số phiếu giảm giá
            }
            
            return 0;  // Nếu không có phiếu giảm giá, trả về 0
        }
        
    }
?>
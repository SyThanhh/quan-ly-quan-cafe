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
                // Điều chỉnh truy vấn SQL dựa trên số điểm và sử dụng CURDATE() để lấy ngày hiện tại
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
    }
?>
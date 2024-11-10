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
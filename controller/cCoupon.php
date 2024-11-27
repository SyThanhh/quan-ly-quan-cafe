<?php
    include_once('./model/mCoupon.php');
    class cCoupon{
        public function getCoupon() {
            $p = new mCoupon();
            $tbl = $p->selCoupon();
        
            // Kiểm tra xem kết nối có trả về một đối tượng kết quả hợp lệ
            if ($tbl && is_object($tbl)) {
                if (mysqli_num_rows($tbl) > 0) {
                    return $tbl;
                } else {
                    return false;  // Không có kết quả nào
                }
            } else {
                echo 'Lỗi kết nối!';
                return false;
            }
        }

        public function getCouponByPoint($point) {
            $p = new mCoupon();
            $tbl = $p->selCouponByPoint($point);
        
            // Kiểm tra xem kết nối có trả về một đối tượng kết quả hợp lệ
            if ($tbl && is_object($tbl)) {
                if (mysqli_num_rows($tbl) > 0) {
                    return $tbl;
                } else {
                    return false;  // Không có kết quả nào
                }
            } else {
                echo 'Lỗi kết nối!';
                return false;
            }
        }

        

        public function getCouponByCode($CouponCode){
            $p = new mCoupon();
            $tbl = $p -> selCouponByCode($CouponCode);
            if($tbl){
                if(mysqli_num_rows($tbl)>0){
                    return $tbl;
                }
                else{
                    return false;
                }
            }
            else{
                echo 'Không có mã giảm giá cần tìm!';
            }
        }

            public function get01CouponByID($CouponID){
            $p = new mCoupon();
            $tbl = $p -> sel01CouponByID($CouponID);
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

        public function cUpDateCp($CouponID, $CouponCode, $StartDate, $EndDate, $Description, $CouponDiscount, $Status, $UpDateAt){
           $p = new mCoupon();
           $tbl = $p -> mUpDateCp($CouponID, $CouponCode, $StartDate, $EndDate, $Description, $CouponDiscount, $Status, $UpDateAt);
           if($tbl){
                return $tbl;
            }
            else{
                echo 'Lỗi kết nối!';
            }
        }

            public function cInSertCp($CouponCode, $StartDate, $EndDate, $Description, $CouponDiscount, $Status, $UpDateAt){
                $p = new mCoupon();
                $tbl = $p -> mInsertCp($CouponCode, $StartDate, $EndDate, $Description, $CouponDiscount, $Status, $UpDateAt);
                if($tbl){
                     return $tbl;
                 }
                 else{
                     echo 'Lỗi kết nối!';
                 }
            }
            
            public function cDeleteCp($CouponID){
                $p = new mCoupon();
                return $p -> mDeleteCp($CouponID);
            }

            public function listCoupon($searchKeyword, $limit, $offset) {
                $p = new mCoupon();
                return $p->getCoupon($searchKeyword, $limit, $offset);  // Gọi phương thức từ model
            }
        
            // Lấy tổng số trang cho phân trang
            public function getTotalPageCoupon($searchKeyword, $limit) {
                $p = new mCoupon();
                $totalCoupon = $p->getTotalCoupon($searchKeyword);  // Lấy tổng số sản phẩm theo từ khóa tìm kiếm
                return ceil($totalCoupon / $limit);  // Tính tổng số trang
            }
    }
?>
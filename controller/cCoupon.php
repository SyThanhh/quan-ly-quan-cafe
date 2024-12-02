<?php
    include_once('./model/mCoupon.php');
    class cCoupon{
        private $conn;

    // Hàm khởi tạo kết nối MySQL
        public function __construct() {
            $this->conn = mysqli_connect('localhost', 'admin', '123456', 'db_ql3scoffee'); // Thay thế thông tin kết nối
            if (!$this->conn) {
                die('Kết nối MySQL thất bại: ' . mysqli_connect_error());
            }
        }
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

            public function listCoupon($searchKeyword = '', $limit = 5, $offset = 0) {
                global $conn; // Đảm bảo kết nối này là hợp lệ
                $sql = "SELECT * FROM coupon WHERE CouponCode LIKE '%$searchKeyword%' LIMIT $limit OFFSET $offset";
                
                // Kiểm tra lỗi trong câu truy vấn
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    die('Lỗi câu truy vấn: ' . mysqli_error($conn));  // Kiểm tra nếu câu truy vấn không thành công
                }
            
                return $result; // Trả về kết quả
            }
        
            // Phương thức lấy tổng số trang
            public function getTotalPageCoupon($searchKeyword, $limit) {
                // Sử dụng kết nối đã khởi tạo trong class
                $query = "SELECT COUNT(*) AS total FROM coupon WHERE CouponCode LIKE '%$searchKeyword%'";
                $result = mysqli_query($this->conn, $query);  // Sử dụng $this->conn
                
                // Kiểm tra nếu truy vấn thất bại
                if (!$result) {
                    die('Truy vấn thất bại: ' . mysqli_error($this->conn));  // Hiển thị lỗi nếu truy vấn không thành công
                }
                
                $row = mysqli_fetch_assoc($result);
                return ceil($row['total'] / $limit);  // Tính toán số trang
            }
    }
?>
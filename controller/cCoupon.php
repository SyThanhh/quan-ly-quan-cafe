<?php
    include_once('./model/mCoupon.php');
    class cCoupon{
        private $conn;

    // Hàm khởi tạo kết nối MySQL
        public function __construct() {
            $this->conn = mysqli_connect('localhost', 'root', '', 'db_ql3scoffee'); // Thay thế thông tin kết nối
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

            // Hàm lấy danh sách phiếu giảm giá (có phân trang)
            public function listCoupon($keyword = '', $startDate = '', $endDate = '', $limit = 5, $offset = 0) {
                global $conn;

                // Xây dựng câu truy vấn cơ bản
                $sql = "SELECT * FROM coupon WHERE CouponCode LIKE ?";

                // Thêm điều kiện ngày bắt đầu nếu có
                if (!empty($startDate)) {
                    $sql .= " AND StartDate >= ?";
                }

                // Thêm điều kiện ngày kết thúc nếu có
                if (!empty($endDate)) {
                    $sql .= " AND EndDate <= ?";
                }

                // Thêm phân trang
                $sql .= " LIMIT ? OFFSET ?";

                // Chuẩn bị câu truy vấn
                $stmt = mysqli_prepare($conn, $sql);
                if ($stmt) {
                    // Xây dựng các tham số cho câu truy vấn
                    $searchKeyword = "%$keyword%";  // Thêm dấu % vào keyword để tìm kiếm như "LIKE"
                    $params = [$searchKeyword];

                    if (!empty($startDate)) {
                        $params[] = $startDate;
                    }
                    
                    if (!empty($endDate)) {
                        $params[] = $endDate;
                    }

                    // Thêm tham số cho limit và offset
                    $params[] = $limit;
                    $params[] = $offset;

                    // Gắn tham số vào câu truy vấn
                    mysqli_stmt_bind_param($stmt, str_repeat('s', count($params) - 2) . 'ii', ...$params);

                    // Thực thi câu truy vấn
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    
                    // Trả về kết quả
                    return $result;
                } else {
                    die('Lỗi câu truy vấn: ' . mysqli_error($conn));
                }
            }

            // Hàm lấy tổng số phiếu giảm giá để tính số trang
            public function getTotalPageCoupon($keyword = '', $startDate = '', $endDate = '', $limit = 1) {
                global $conn;
                
                // Xây dựng câu truy vấn cơ bản
                $sql = "SELECT COUNT(*) AS total FROM coupon WHERE 1";  // Đảm bảo có WHERE luôn
            
                // Thêm điều kiện từ khóa
                if (!empty($keyword)) {
                    $sql .= " AND CouponCode LIKE ?";
                }
            
                // Thêm điều kiện ngày bắt đầu nếu có
                if (!empty($startDate)) {
                    $sql .= " AND StartDate >= ?";
                }
            
                // Thêm điều kiện ngày kết thúc nếu có
                if (!empty($endDate)) {
                    $sql .= " AND EndDate <= ?";
                }
            
                // Chuẩn bị câu truy vấn
                $stmt = mysqli_prepare($conn, $sql);
                if ($stmt) {
                    // Xây dựng các tham số cho câu truy vấn
                    $params = [];
                    $types = '';  // Chuỗi kiểu dữ liệu của các tham số
                    
                    // Thêm tham số cho từ khóa
                    if (!empty($keyword)) {
                        $params[] = "%$keyword%";
                        $types .= 's';  // Kiểu dữ liệu cho từ khóa là string
                    }
            
                    // Thêm tham số cho ngày bắt đầu nếu có
                    if (!empty($startDate)) {
                        $params[] = $startDate;
                        $types .= 's';
                    }
            
                    // Thêm tham số cho ngày kết thúc nếu có
                    if (!empty($endDate)) {
                        $params[] = $endDate;
                        $types .= 's';
                    }
            
                    // Nếu không có tham số nào, thì không cần gọi mysqli_stmt_bind_param
                    if ($types !== '') {
                        // Gắn tham số vào câu truy vấn
                        mysqli_stmt_bind_param($stmt, $types, ...$params);
                    }
            
                    // Thực thi câu truy vấn
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $row = mysqli_fetch_assoc($result);
            
                    mysqli_stmt_close($stmt);
            
                    // Trả về tổng số trang
                    return ceil($row['total'] / $limit);
                } else {
                    die('Lỗi câu truy vấn: ' . mysqli_error($conn));
                }
            }                        
    }
?>
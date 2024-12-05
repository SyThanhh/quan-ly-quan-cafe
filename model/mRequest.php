<?php
    include_once('./connect/database.php');
    class mRequest {
        public function mDeleteRq($RequestID) {
            $p = new Database();
            $str = "DELETE FROM requestform WHERE RequestID = '$RequestID'"; 

            try {
                $con = $p->connect();
                
                // In ra câu lệnh SQL để kiểm tra
                echo "SQL Query: " . $str . "<br>";  // In ra câu lệnh SQL để kiểm tra
                
                if (mysqli_query($con, $str)) {
                    return true;
                } else {
                    // In ra lỗi chi tiết của câu lệnh SQL
                    echo "Error: " . mysqli_error($con);  // Xem chi tiết lỗi của câu lệnh
                    return false;
                }
            } catch (Exception $e) {
                // In ra lỗi nếu có lỗi kết nối
                echo "Exception: " . $e->getMessage();
                return false;
            }
        }
    }
?>

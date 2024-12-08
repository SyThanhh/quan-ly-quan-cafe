<?php
    include_once("./connect/database.php");
    
    class ModelProduct {
        private $conn;

        public function __construct() {
          
            $this->conn = (new Database())->connect(); // Kết nối CSDL
        }

        
        public function updateQuantityInStock($id, $quantity) {
            if ($this->conn) {
                // Xử lý dữ liệu đầu vào
                $id = trim($id);
                $quantity = trim($quantity);
                
                if (empty($id) || empty($quantity)) {
                    return false; 
                }
                
                $str = "UPDATE product SET UnitsInStock = UnitsInStock - ? WHERE ProductID = ?";
                $stmt = mysqli_prepare($this->conn, $str);
                
                if ($stmt === false) {
                    return false; 
                }
                
                mysqli_stmt_bind_param($stmt, "ii", $quantity, $id);
                
                $result = mysqli_stmt_execute($stmt);
                if (!$result) {
                    error_log("MySQL Error: " . mysqli_stmt_error($stmt));
                }
                
                mysqli_stmt_close($stmt); 
                
                return $result; // Trả về kết quả thực thi
            }
            return false; 
        }
        



        public function getProductById($id) {
            if ($this->conn) {
                $str = "SELECT * FROM Product WHERE ProductID = ?";
                
                $stmt = mysqli_prepare($this->conn, $str);
                if ($stmt === false) {
                    return false;
                }
                
                mysqli_stmt_bind_param($stmt, "i", $id);
                
                $result = mysqli_stmt_execute($stmt);
                
                // Lấy kết quả
                $result = mysqli_stmt_get_result($stmt);
                $Product = mysqli_fetch_assoc($result); 


                mysqli_stmt_close($stmt); 

                return $Product; 
            }
            return false; 
        }

        
    }
?>

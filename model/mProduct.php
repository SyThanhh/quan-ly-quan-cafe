<?php
    include_once("./connect/database.php");
    
    class ModelProduct {
        private $conn;

        public function __construct() {
          
            $this->conn = (new Database())->connect(); // Kết nối CSDL
        }

        public function selectAll($keyword) {
            if ($this->conn) {
                $keyword = trim($keyword);
                $str = "SELECT * FROM product WHERE Status = 1";
        
                if (!empty($keyword)) {
                    $str .= " AND (ProductName LIKE ? )";
                }
    
                $stmt = mysqli_prepare($this->conn, $str);
        
                if ($stmt) {
                    if (!empty($keyword)) {
                        $searchTerm = "%$keyword%";
                        mysqli_stmt_bind_param($stmt, "ss", $searchTerm, $searchTerm); 
                    }
        
                    if (mysqli_stmt_execute($stmt)) {
                        $result = mysqli_stmt_get_result($stmt); 
                        return $result; 
                    } else {
                        return false; 
                    }
                } else {
                    return false; 
                }
            } else {
                return false; 
            }
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

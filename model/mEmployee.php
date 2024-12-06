<?php
    include_once("./connect/database.php");
    
    class ModelEmployee {
        private $conn;

        public function __construct() {
          
            $this->conn = (new Database())->connect(); // Kết nối CSDL
        }

        
     

        public function getEmployeeByRole($role) {
            if ($this->conn) {
                $str = "SELECT * FROM employee WHERE Roles = ?";
                
                $stmt = mysqli_prepare($this->conn, $str);
                if ($stmt === false) {
                    return false;
                }
                
                mysqli_stmt_bind_param($stmt, "i", $role);
                
                $result = mysqli_stmt_execute($stmt);
                
                $result = mysqli_stmt_get_result($stmt);
                $employee = mysqli_fetch_assoc($result); 


                mysqli_stmt_close($stmt); 

                return $employee; 
            }
            return false; 
        }

        
    }
?>

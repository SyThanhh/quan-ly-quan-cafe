<?php
    include_once("./connect/database.php");
    
    class ModelCustomer {
        private $conn;

        public function __construct() {
          
            $this->conn = (new Database())->connect(); // Kết nối CSDL
        }

        public function selectAll($keyword) {
            if ($this->conn) {
                $str = "SELECT * FROM customer WHERE Status = 1";
        
                if (!empty($keyword)) {
                    $str .= " AND (CustomerName LIKE ? OR CustomerPhone LIKE ?)";
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

       

        public function add($name, $email, $phone) {
            if ($this->conn) {
                // Xử lý dữ liệu đầu vào
                $name = trim($name);
                $email = trim($email);
                $phone = trim($phone);
        
                // Kiểm tra xem các trường có hợp lệ không
                if (empty($name) || empty($email) || empty($phone)) {
                    return false; 
                }
        
                // Thực hiện thêm mới khách hàng
                $str = "INSERT INTO customer (CustomerName, Email, CustomerPhone) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($this->conn, $str);
        
                if ($stmt === false) {
                    return false; // Xử lý lỗi
                }
        
                mysqli_stmt_bind_param($stmt, "sss", $name, $email, $phone);
        
                $result = mysqli_stmt_execute($stmt);
                if (!$result) {
                    error_log("MySQL Error: " . mysqli_stmt_error($stmt));
                }
        
                // Đóng câu lệnh
                mysqli_stmt_close($stmt); 
        
                return $result; // Trả về kết quả thực thi
            }
            return false; 
        }
        
        public function update($id, $name, $email, $phone) {
            if ($this->conn) {
                // Xử lý dữ liệu đầu vào
                $name = trim($name);
                $email = trim($email);
                $phone = trim($phone);
        
                // Kiểm tra xem các trường có hợp lệ không
                if (empty($name) || empty($email) || empty($phone) || !is_numeric($id)) {
                    return false; 
                }
        
                // Thực hiện cập nhật thông tin khách hàng
                $str = "UPDATE customer SET CustomerName = ?, Email = ?, CustomerPhone = ? WHERE CustomerID = ?";
                $stmt = mysqli_prepare($this->conn, $str);
        
                if ($stmt === false) {
                    return false; 
                }
        
                mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $phone, $id);
        
                $result = mysqli_stmt_execute($stmt);
                if (!$result) {
                    error_log("MySQL Error: " . mysqli_stmt_error($stmt));
                }
        
                // Đóng câu lệnh
                mysqli_stmt_close($stmt); 
        
                return $result; // Trả về kết quả thực thi
            }
            return false; 
        }
        
        

        public function delete($id) {
            if ($this->conn) {
                $str = "DELETE FROM customer WHERE CustomerID = ?";
                
                $stmt = mysqli_prepare($this->conn, $str);
                if ($stmt === false) {
                    return false;
                }
                
                mysqli_stmt_bind_param($stmt, "i", $id);
                
                $result = mysqli_stmt_execute($stmt);
                
                mysqli_stmt_close($stmt); 
                
                return $result; 
            }
            return false; 
        }

        public function getCustomerById($id) {
            if ($this->conn) {
                $str = "SELECT * FROM customer WHERE CustomerID = ?";
                
                $stmt = mysqli_prepare($this->conn, $str);
                if ($stmt === false) {
                    return false;
                }
                
                mysqli_stmt_bind_param($stmt, "i", $id);
                
                $result = mysqli_stmt_execute($stmt);
                
                // Lấy kết quả
                $result = mysqli_stmt_get_result($stmt);
                $customer = mysqli_fetch_assoc($result); 


                mysqli_stmt_close($stmt); 

                return $customer; 
            }
            return false; 
        }

        public function getCustomerByEmail($email) {
            if ($this->conn) {
                $str = "SELECT * FROM customer WHERE Email = ?";
                
                $stmt = mysqli_prepare($this->conn, $str);
                if ($stmt === false) {
                    return false;
                }
                
                mysqli_stmt_bind_param($stmt, "s", $email);
                
                mysqli_stmt_execute($stmt);
                
                // Lấy kết quả
                $result = mysqli_stmt_get_result($stmt);
                $customer = mysqli_fetch_assoc($result); 
                
                mysqli_stmt_close($stmt); 
                
                return $customer; // Trả về thông tin khách hàng
            }
            return false; 
        }

        public function getCustomerByPhone($phone) {
            if ($this->conn) {
                $str = "SELECT * FROM customer WHERE CustomerPhone = ?";
                
                $stmt = mysqli_prepare($this->conn, $str);
                if ($stmt === false) {
                    return false; 
                }
                
                mysqli_stmt_bind_param($stmt, "s", $phone);
                mysqli_stmt_execute($stmt);
                
                // Lấy kết quả
                $result = mysqli_stmt_get_result($stmt);
                $customer = mysqli_fetch_assoc($result); // Lấy khách hàng
                
                mysqli_stmt_close($stmt); 
                
                return $customer; // Trả về thông tin khách hàng
            }
            return false; 
        }

       
        
        public function checkEmailUnique($id, $email) {
            if ($this->conn) {
                $customerByEmail = $this->getCustomerByEmail($email);
        
                if($customerByEmail === null) return true;

                $isCheck = ($id === null);
                if($isCheck) {
                    if($customerByEmail != null) return false;
                } else {
                    if (is_array($customerByEmail) && $customerByEmail["CustomerID"] !== $id) {
                        return false;
                    }
                }
                return true;
            }
            return true;
        }
        
        

        public function checkPhoneUnique($id , $Phone) {
            if ($this->conn) {
                $customerByPhone = $this->getCustomerByPhone($Phone);
                
                if($customerByPhone === null) return true;

                $isCheck = ($id === null);
                if($isCheck) {
                    if($customerByPhone != null) return false;
                } else {
                    if (is_array($customerByPhone) && $customerByPhone["CustomerID"] !== $id) {
                        return false;
                    }
                }
                return true; 
            }
            return true;
        }
    }
?>

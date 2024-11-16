<?php
    include_once("./connect/database.php");
    
    class ModelCustomer {
        private $conn;

        public function __construct() {
          
            $this->conn = (new Database())->connect(); // Kết nối CSDL
        }

        public function selectAll($keyword) {
            if ($this->conn) {
                $keyword = trim($keyword);
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

        public function selectCustomerByPhone($keyword) {
            if (!$this->conn) {
                return false; 
            }
        
            $keyword = trim($keyword);
            $str = "SELECT * FROM customer WHERE Status = 1";
            
            if (!empty($keyword)) {
                $str .= " AND CustomerPhone LIKE ?";
            }
        
            $stmt = mysqli_prepare($this->conn, $str);
        
            if (!$stmt) {
                return false; 
            }
        
            if (!empty($keyword)) {
                $searchTerm = "%$keyword%";
                mysqli_stmt_bind_param($stmt, "s", $searchTerm);
            }
        
            if (mysqli_stmt_execute($stmt)) {
                // Lấy kết quả trả về
                $result = mysqli_stmt_get_result($stmt);
                // Lấy dữ liệu khách hàng từ kết quả
                $customer = mysqli_fetch_assoc($result); 
                
                mysqli_stmt_close($stmt);
                
                // Nếu tìm thấy khách hàng, trả về dữ liệu khách hàng
                if ($customer) {
                    return $customer;
                } 
            }
            return null; // Trả về null nếu không tìm thấy khách hàng
        }
        
        
        
        // public function selectByPhone($keyword) {
        //     if ($this->conn) {
        //         $keyword = trim($keyword);
        //         $str = "SELECT * FROM customer WHERE Status = 1";
        
        //         if (!empty($keyword)) {
        //             $str .= " AND (CustomerName LIKE ? OR CustomerPhone LIKE ?)";
        //         }
    
        //         $stmt = mysqli_prepare($this->conn, $str);
        
        //         if ($stmt) {
        //             if (!empty($keyword)) {
        //                 $searchTerm = "%$keyword%";
        //                 mysqli_stmt_bind_param($stmt, "ss", $searchTerm, $searchTerm); 
        //             }
        
        //             if (mysqli_stmt_execute($stmt)) {
        //                 $result = mysqli_stmt_get_result($stmt); 
        //                 return $result; 
        //             } else {
        //                 return false; 
        //             }
        //         } else {
        //             return false; 
        //         }
        //     } else {
        //         return false; 
        //     }
        // }


       

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

        public function addSell($name, $email, $phone) {
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
                    return false; 
                }
        
                mysqli_stmt_bind_param($stmt, "sss", $name, $email, $phone);
                
                $result = mysqli_stmt_execute($stmt);
                if (!$result) {
                    error_log("MySQL Error: " . mysqli_stmt_error($stmt));
                    mysqli_stmt_close($stmt);
                    return false; 
                }
        
                // Lấy ID của bản ghi vừa thêm
                $customerId = mysqli_insert_id($this->conn); // ID của bản ghi mới
        
                // Đóng câu lệnh
                mysqli_stmt_close($stmt);
        
                // Tạo đối tượng khách hàng
                $customer = (object)[
                    'id' => $customerId,
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone
                ];
        
                return $customer; // Trả về đối tượng khách hàng
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
                // Câu lệnh SQL tìm kiếm theo CustomerID
                $str = "SELECT * FROM customer WHERE CustomerID = ?";
                
                // Chuẩn bị câu lệnh SQL
                $stmt = mysqli_prepare($this->conn, $str);
                if ($stmt === false) {
                    // Trả về null nếu không thể chuẩn bị câu lệnh
                    return null; 
                }
                
                // Gắn tham số vào câu lệnh SQL
                mysqli_stmt_bind_param($stmt, "i", $id);
                
                // Thực thi câu lệnh
                if (mysqli_stmt_execute($stmt)) {
                    // Lấy kết quả trả về
                    $result = mysqli_stmt_get_result($stmt);
                    // Lấy dữ liệu khách hàng từ kết quả
                    $customer = mysqli_fetch_assoc($result); 
                    
                    mysqli_stmt_close($stmt);
                    
                    // Nếu tìm thấy khách hàng, trả về dữ liệu khách hàng
                    if ($customer) {
                        return $customer;
                    } else {
                        // Trả về null nếu không tìm thấy khách hàng
                        return null;
                    }
                } else {
                    // Trả về null nếu không thực thi câu lệnh SQL thành công
                    return null;
                }
            }
            
            // Trả về null nếu không có kết nối DB
            return null;
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

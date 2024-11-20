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
            // Kiểm tra kết nối
            if (!$this->conn) {
                return false; 
            }
        
            // Loại bỏ khoảng trắng ở đầu và cuối
            $keyword = trim($keyword);
            $str = "SELECT * FROM customer WHERE Status = 1";
        
            // Nếu từ khóa không rỗng, thêm điều kiện vào truy vấn
            if (!empty($keyword)) {
                $str .= " AND CustomerPhone = ?";
            } else {
                // Nếu từ khóa rỗng, trả về null
                return null; // Hoặc return false để biểu thị lỗi
            }
        
            // Chuẩn bị truy vấn
            $stmt = mysqli_prepare($this->conn, $str);
            if (!$stmt) {
                return false; 
            }
        
            // Gán giá trị cho tham số nếu từ khóa không rỗng
            if (!empty($keyword)) {
                mysqli_stmt_bind_param($stmt, "s", $keyword);
            }
        
            // Thực thi truy vấn
            if (mysqli_stmt_execute($stmt)) {
                // Lấy kết quả trả về
                $result = mysqli_stmt_get_result($stmt);
                $customer = mysqli_fetch_assoc($result); 
                
                // Đóng câu lệnh
                mysqli_stmt_close($stmt);
                
                return $customer ?: null; // Trả về null nếu không tìm thấy
            }
        
            mysqli_stmt_close($stmt);
            return null; // Trả về null nếu có lỗi xảy ra
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

        public function updatePoint($customerID, $invoiceAmount) {
            if ($this->conn) {
                // Kiểm tra thông tin đầu vào
                $customerID = trim($customerID);
                $invoiceAmount = trim($invoiceAmount);
        
                $invoiceAmount = intval($invoiceAmount);
        
                // Nếu thiếu dữ liệu cần thiết, trả về 
                if (empty($customerID) || $invoiceAmount <= 0) {
                    return false;
                }
                
                $pointsToAdd = 0;
                if ($invoiceAmount <= 100000) {
                    $pointsToAdd = 5;
                } elseif ($invoiceAmount >= 150000) {
                    $pointsToAdd = 10;
                }
        
                $str = "UPDATE customer SET CustomerPoint = CustomerPoint + ? WHERE CustomerID = ?";
                $stmt = mysqli_prepare($this->conn, $str);
                
                if ($stmt === false) {
                    return false; 
                }
        
                // Gán tham số cho câu lệnh chuẩn bị
                mysqli_stmt_bind_param($stmt, "ii", $pointsToAdd, $customerID);
        
                // Thực thi câu lệnh
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
        public function updatePointWithCoupon($customerID, $couponDiscount) {
            if ($this->conn) {
                // Kiểm tra thông tin đầu vào
                $customerID = trim($customerID);
                $couponDiscount = intval($couponDiscount);
        
                // Nếu thiếu dữ liệu cần thiết, trả về false
                if (empty($customerID) || $couponDiscount <= 0) {
                    return false;
                }
        
                $pointsToSubtract = 0;
                if ($couponDiscount === 10) {
                    $pointsToSubtract = 50; // Hạng Bạc
                } elseif ($couponDiscount === 15) {
                    $pointsToSubtract = 70; // Hạng Vàng
                } elseif ($couponDiscount === 20) {
                    $pointsToSubtract = 100; // Hạng Kim Cương
                } else {
                    return false;
                }
        
                // Trừ điểm của khách hàng
                $str = "UPDATE customer SET CustomerPoint = CustomerPoint - ? WHERE CustomerID = ? AND CustomerPoint >= ?";
                $stmt = mysqli_prepare($this->conn, $str);
                
                if ($stmt === false) {
                    return false; 
                }
        
                // Gán tham số cho câu lệnh chuẩn bị
                mysqli_stmt_bind_param($stmt, "iii", $pointsToSubtract, $customerID, $pointsToSubtract);
        
                // Thực thi câu lệnh
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

        
        public function getCustomers($limit, $offset, $keyword = '') {
            // Bắt đầu xây dựng truy vấn SQL
            $query = "SELECT * FROM customer WHERE Status = 1";
        
            // Nếu có từ khóa tìm kiếm, thêm vào điều kiện LIKE
            if (!empty($keyword)) {
                $query .= " AND (CustomerName LIKE ? OR CustomerPhone LIKE ?)";
            }
        
            // Thêm phần LIMIT và OFFSET
            $query .= " LIMIT ? OFFSET ?";
        
            $stmt = mysqli_prepare($this->conn, $query);
        
            if ($stmt) {
                if (!empty($keyword)) {
                    $searchTerm = "%$keyword%";
                    mysqli_stmt_bind_param($stmt, "ssss", $searchTerm, $searchTerm, $limit, $offset);
                } else {
                    // Nếu không có từ khóa tìm kiếm, chỉ gắn LIMIT và OFFSET
                    mysqli_stmt_bind_param($stmt, "ii", $limit, $offset);
                }
        
                // Thực thi truy vấn
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
        
                // Lấy kết quả
                $customers = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $customers[] = $row;
                }
        
                mysqli_stmt_close($stmt);
                return $customers;
            }
            
            return [];
        }
        
    
        public function getTotalCustomers($keyword = '') {
            // Xây dựng truy vấn đếm tổng số khách hàng
            $query = "SELECT COUNT(*) as total FROM customer WHERE Status = 1";
        
            // Nếu có từ khóa tìm kiếm, thêm vào điều kiện LIKE
            if (!empty($keyword)) {
                $query .= " AND (CustomerName LIKE ? OR CustomerPhone LIKE ?)";
            }
        
            // Chuẩn bị truy vấn
            $stmt = mysqli_prepare($this->conn, $query);
        
            if ($stmt) {
                // Nếu có từ khóa tìm kiếm, gắn tham số tìm kiếm
                if (!empty($keyword)) {
                    $searchTerm = "%$keyword%";
                    mysqli_stmt_bind_param($stmt, "ss", $searchTerm, $searchTerm);
                }
        
                // Thực thi truy vấn
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $data = mysqli_fetch_assoc($result);
        
                mysqli_stmt_close($stmt);
        
                return $data['total'];
            }
        
            return 0;
        }


    }
?>

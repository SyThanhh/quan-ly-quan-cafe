<?php
    include_once("./connect/database.php");
    
    class ModelOrder {
        private $conn;

        public function __construct() {
          
            $this->conn = (new Database())->connect(); // Kết nối CSDL
        }

        public function selectAll($fromdate, $todate) {
            if ($this->conn) {
                // Xử lý dữ liệu đầu vào
                $fromdate = trim($fromdate);
                $todate = trim($todate);
                
                // Khởi tạo câu lệnh SQL cơ bản
                $str = "SELECT * FROM  `order` o JOIN customer c ON o.CustomerId = c.CustomerID JOIN employee e ON o.EmployeeID = e.EmployeeID 
                JOIN coupon cp ON o.couponID = cp.couponID"; 
                $conditions = [];
                $params = [];
                $types = '';
        
                // Xây dựng điều kiện truy vấn
                if (!empty($fromdate) && !empty($todate)) {
                    $conditions[] = "CreateDate BETWEEN  ? AND ?";
                    $params[] = $fromdate . " 00:00:00"; 
                    $params[] = $todate . " 23:59:59";
                    $types .= 'ss'; 
                } elseif (!empty($fromdate)) {
                    $conditions[] = "CreateDate >= ?";
                    $params[] = $fromdate; 
                    $types .= 's'; 
                } elseif (!empty($todate)) {
                    $conditions[] = "CreateDate <= ?";
                    $params[] = $todate;
                    $types .= 's'; 
                } 
        
                // Nếu có điều kiện, thêm vào truy vấn
                if (!empty($conditions)) {
                    $str .= " WHERE " . implode(" AND ", $conditions);
                }
                $str.= " ORDER BY CreateDate DESC";
              
                $stmt = mysqli_prepare($this->conn, $str);
                if ($stmt === false) {
                    return false; 
                }
        
                // Ràng buộc tham số
                if (!empty($params)) {
                    mysqli_stmt_bind_param($stmt, $types, ...$params);
                }
        
                // Thực thi câu lệnh
                if (mysqli_stmt_execute($stmt)) {
                    $result = mysqli_stmt_get_result($stmt);
                    mysqli_stmt_close($stmt); 
                    return $result; 
                } else {
                    mysqli_stmt_close($stmt); 
                    return false; 
                }
            }
            return false;
        }
        

        public function generateNewId() {
            $newId = "";
            $isUnique = false;
        
            while (!$isUnique) {
                // Lấy ID lớn nhất hiện có trong cơ sở dữ liệu
                $query = "SELECT MAX(`OrderID`) AS maxId FROM `order`";
                $stmt = mysqli_prepare($this->conn, $query);
        
                if ($stmt === false) {
                    error_log("MySQL Error: " . mysqli_error($this->conn)); // Ghi log lỗi
                    return false;
                }
        
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($result);
        
                $maxId = $row['maxId'];
                $number = 0;
        
                if ($maxId) {
                    $number = (int) substr($maxId, 2); // Lấy phần số từ "HDxxxx"
                }
        
                // Tạo ID mới
                $newNumber = str_pad($number + 1, 4, '0', STR_PAD_LEFT); // Tăng số lên và đảm bảo có 4 chữ số
                $newId = "HD" . $newNumber;
        
                // Kiểm tra xem ID này có tồn tại trong cơ sở dữ liệu không
                $checkQuery = "SELECT COUNT(*) AS count FROM `order` WHERE `OrderID` = ?";
                $checkStmt = mysqli_prepare($this->conn, $checkQuery);
        
                if ($checkStmt === false) {
                    mysqli_stmt_close($stmt);
                    error_log("MySQL Error: " . mysqli_error($this->conn)); // Ghi log lỗi
                    return false;
                }
        
                mysqli_stmt_bind_param($checkStmt, "s", $newId);
                mysqli_stmt_execute($checkStmt);
                $checkResult = mysqli_stmt_get_result($checkStmt);
                $countRow = mysqli_fetch_assoc($checkResult);
        
                mysqli_stmt_close($checkStmt);
        
                if ($countRow['count'] == 0) {
                    $isUnique = true;
                }
        
                mysqli_stmt_close($stmt);
            }
    
        
            return $newId;
        }
        
        public function add($id, $discount, $payment, $total, $couponID = null, $customerID = null, $employeeID) {
            if ($this->conn) {
                // Xử lý dữ liệu đầu vào
                $id = trim($id);
                $discount = trim($discount);
                $payment = trim($payment);
                $total = trim($total);
                $couponID = trim($couponID); // Đảm bảo couponID không rỗng
                $customerID = trim($customerID);
                $employeeID = trim($employeeID);
                $status = 1;
        
                // Kiểm tra và xác định câu lệnh SQL
                if (empty($customerID) && empty($couponID)) {
                    // Nếu không có customerID và couponID, chèn vào không có cả hai
                    $str = "INSERT INTO `order` (OrderID, Discount, PaymentMethod, TotalAmount, Status, EmployeeID) 
                            VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($this->conn, $str);
                    mysqli_stmt_bind_param($stmt, "sdssii", $id, $discount, $payment, $total, $status, $employeeID);

                } else if (empty($customerID)) {
                    // Nếu không có customerID, nhưng có couponID
                    $str = "INSERT INTO `order` (OrderID, Discount, PaymentMethod, TotalAmount, Status, CouponID, EmployeeID) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($this->conn, $str);
                    mysqli_stmt_bind_param($stmt, "sdssisi", $id, $discount, $payment, $total, $status, $couponID, $employeeID);

                } else if (empty($couponID)) {
                    // Nếu không có couponID, nhưng có customerID
                    $str = "INSERT INTO `order` (OrderID, Discount, PaymentMethod, TotalAmount, Status, CustomerID, EmployeeID) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($this->conn, $str);
                    mysqli_stmt_bind_param($stmt, "sdssiii", $id, $discount, $payment, $total, $status, $customerID, $employeeID);
                    
                } else {
                    // Nếu có cả customerID và couponID
                    $str = "INSERT INTO `order` (OrderID, Discount, PaymentMethod, TotalAmount, Status, CouponID, CustomerID, EmployeeID) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($this->conn, $str);
                    mysqli_stmt_bind_param($stmt, "sdssiiii", $id, $discount, $payment, $total, $status, $couponID, $customerID, $employeeID);
                }
        
        
                if ($stmt === false) {
                    error_log("MySQL Error: " . mysqli_error($this->conn)); // Ghi log lỗi
                    return false;
                }
        
                // Thực thi câu lệnh
                $result = mysqli_stmt_execute($stmt);
        
                if (!$result) {
                    error_log("MySQL Error: " . mysqli_stmt_error($stmt)); // Ghi log lỗi
                }
        
                mysqli_stmt_close($stmt);
        
                return $result; // Trả về kết quả thực thi
            }
            return false; 
        }
        
        
    

        public function createID() {
            return $this->generateNewId();
        }
        
        

        public function getOrderById($id) {
            if ($this->conn) {
                $str = "SELECT * FROM order WHERE OrderID = ?";
                
                $stmt = mysqli_prepare($this->conn, $str);
                if ($stmt === false) {
                    return false;
                }
                
                mysqli_stmt_bind_param($stmt, "s", $id);
                
                $result = mysqli_stmt_execute($stmt);

                // Lấy kết quả
                $result = mysqli_stmt_get_result($stmt);
                $order = mysqli_fetch_assoc($result); 

                
                mysqli_stmt_close($stmt); 
                
                return $order; 
            }
            return false; 
        }

        public function getOrders($limit, $offset, $fromdate = '', $todate = '') {
            // Bắt đầu xây dựng truy vấn SQL
            $query = "SELECT *
                      FROM `order` o
                      JOIN customer c ON o.CustomerId = c.CustomerID
                      JOIN employee e ON o.EmployeeID = e.EmployeeID
                      LEFT JOIN coupon cp ON o.couponID = cp.couponID";
            
            $conditions = [];
            $params = [];
            $types = '';
            
            // Thêm điều kiện từ ngày và đến ngày
            if (!empty($fromdate) && !empty($todate)) {
                $conditions[] = "o.CreateDate BETWEEN ? AND ?";
                $params[] = $fromdate . " 00:00:00"; 
                $params[] = $todate . " 23:59:59";
                $types .= 'ss';
            } elseif (!empty($fromdate)) {
                $conditions[] = "o.CreateDate >= ?";
                $params[] = $fromdate; 
                $types .= 's';
            } elseif (!empty($todate)) {
                $conditions[] = "o.CreateDate <= ?";
                $params[] = $todate;
                $types .= 's';
            }
            
            // Nếu có điều kiện, thêm vào truy vấn
            if (!empty($conditions)) {
                $query .= " WHERE " . implode(" AND ", $conditions);
            }
            
            // Thêm phần ORDER BY và LIMIT/OFFSET
            $query .= " ORDER BY o.CreateDate DESC LIMIT ? OFFSET ?";
            
            // Gộp các tham số LIMIT và OFFSET vào mảng params
            $params[] = $limit;
            $params[] = $offset;
            $types .= 'ii'; // Gắn thêm 'ii' cho LIMIT và OFFSET
            
            // Chuẩn bị truy vấn
            $stmt = mysqli_prepare($this->conn, $query);
            
            if ($stmt) {
                // Ràng buộc tham số
                mysqli_stmt_bind_param($stmt, $types, ...$params);
                
                // Thực thi truy vấn
                $result = mysqli_stmt_execute($stmt);
                if ($result) {
                    $result = mysqli_stmt_get_result($stmt);
                    
                    // Lấy kết quả
                    $orders = [];
                    while ($row = mysqli_fetch_assoc($result)) {
                        $orders[] = $row;
                    }
                    
                    mysqli_stmt_close($stmt);
                    return $orders;
                } else {
                    // Xử lý lỗi nếu truy vấn không thực thi được
                    echo "Error executing query: " . mysqli_error($this->conn);
                }
            } else {
                // Xử lý lỗi khi không thể chuẩn bị câu truy vấn
                echo "Error preparing query: " . mysqli_error($this->conn);
            }
            
            return [];
        }
        
        
        public function getTotalOrders($fromdate = '', $todate = '') {
            // Xây dựng truy vấn đếm tổng số đơn hàng
            $query = "SELECT COUNT(*) as total
                      FROM `order` o
                      JOIN customer c ON o.CustomerId = c.CustomerID
                      LEFT JOIN coupon cp ON o.couponID = cp.couponID";
            
            $conditions = [];
            $params = [];
            $types = '';
            
            // Thêm điều kiện từ ngày và đến ngày
            if (!empty($fromdate) && !empty($todate)) {
                $conditions[] = "o.CreateDate BETWEEN ? AND ?";
                $params[] = $fromdate . " 00:00:00"; 
                $params[] = $todate . " 23:59:59";
                $types .= 'ss';
            } elseif (!empty($fromdate)) {
                $conditions[] = "o.CreateDate >= ?";
                $params[] = $fromdate; 
                $types .= 's';
            } elseif (!empty($todate)) {
                $conditions[] = "o.CreateDate <= ?";
                $params[] = $todate;
                $types .= 's';
            }
            
            // Nếu có điều kiện, thêm vào truy vấn
            if (!empty($conditions)) {
                $query .= " WHERE " . implode(" AND ", $conditions);
            }
            
            // Chuẩn bị truy vấn
            $stmt = mysqli_prepare($this->conn, $query);
            
            if ($stmt) {
                // Ràng buộc tham số
                if (!empty($params)) {
                    mysqli_stmt_bind_param($stmt, $types, ...$params);
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

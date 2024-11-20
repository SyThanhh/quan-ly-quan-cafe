<?php
    include_once("./connect/database.php");
    
    class ModelOrderDetail {
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
        
        public function add($OrderID, $ProductID, $Unitprice, $Quantity) {
            if ($this->conn) {
                // Xử lý dữ liệu đầu vào
                $OrderID = trim($OrderID);
                $ProductID = trim($ProductID);
                $Unitprice = trim($Unitprice);
                $Quantity = trim($Quantity);
        
                // Thực hiện thêm mới đơn hàng
                $str = "INSERT INTO orderdetail (OrderID, ProductID, Unitprice, Quantity) 
                        VALUES (?, ?, ?, ?)";
                
                $stmt = mysqli_prepare($this->conn, $str);
        
                if ($stmt === false) {
                    error_log("MySQL Error: " . mysqli_error($this->conn)); // Ghi log lỗi
                    return false;
                }
        
                mysqli_stmt_bind_param($stmt, "ssdi", $OrderID, $ProductID, $Unitprice, $Quantity);
        
                $result = mysqli_stmt_execute($stmt);
        
                if (!$result) {
                    error_log("MySQL Error: " . mysqli_stmt_error($stmt)); 
                }
        
                mysqli_stmt_close($stmt);
        
                return $result; // Trả về kết quả thực thi
            }
            return false; 
        }
        
        
        
       


        public function getOrderDetailById($id) {
            if ($this->conn) {
                $str = "SELECT * FROM orderdetail WHERE OrderID = ?";
                
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

        

        
    }
?>

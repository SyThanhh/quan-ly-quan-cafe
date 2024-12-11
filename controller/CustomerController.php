<?php
    include("model/mCustomer.php");

    class CustomerController {
        private $mCustomer;

        public function __construct() {
            $this->mCustomer = new ModelCustomer();
        }
    

        public function getAllCustomers($keyword) {
            $tblCustomer = $this->mCustomer->selectAll($keyword);
        
            if ($tblCustomer) {
                if ($tblCustomer->num_rows > 0) {
                    return $tblCustomer; 
                } else {
                    return null; 
                }
            } else {
                return false; 
            }
        }

        public function getAllCustomersByPhoneAndEmail($keyword) {
            $tblCustomer = $this->mCustomer->selectCustomerByPhoneAndEmail($keyword);
        
            if ($tblCustomer !== null) {
                return $tblCustomer; 
            } else {
                return false; 
            }
        }

        public function getCustomerById($id) {
            $result = $this->mCustomer->getCustomerById($id);

            if ($result) {
                return $result; 
               
            } else {
                return false; 
            }
        }
       

        public function SaveCustomer($id, $name, $email, $phone) {
            $id = $id ? intval($id) : null;
        
            if (!$this->mCustomer->checkEmailUnique($id, $email)) { 
                return ["success" => false, "message" => "Email đã tồn tại."];
            }
            if (!$this->mCustomer->checkPhoneUnique($id, $phone)) { 
                return ["success" => false, "message" => "Phone đã tồn tại."];
            }
        
            if ($id !== null) {
                $result = $this->mCustomer->update($id, $name, $email, $phone);
            } else {
                $result = $this->mCustomer->add($name, $email, $phone);
            }
        
            if ($result) {
                return ["success" => true, "message" => "Khách hàng đã được lưu thành công."];
            } else {
                return ["success" => false, "message" => "Có lỗi xảy ra khi lưu khách hàng."];
            }
        }

      

      

        public function SaveCustomerSell($id, $name, $email, $phone) {
            $id = $id ? intval($id) : null;
        
            if (!$this->mCustomer->checkEmailUnique($id, $email)) { 
                return ["success" => false, "message" => "Email đã tồn tại."];
            }
            if (!$this->mCustomer->checkPhoneUnique($id, $phone)) { 
                return ["success" => false, "message" => "Phone đã tồn tại."];
            }
        
            
            $result = $this->mCustomer->addSell($name, $email, $phone);
            
        
            if (!empty($result)) {
                // Lưu dữ liệu vào session
                $_SESSION['customerID'] = $result->id;
        
                // Phản hồi thành công
                echo json_encode([
                    'success' => true,
                    'message' => 'Khách hàng đã được thêm thành công',
                    'customerID' => $_SESSION['customerID']
                ]);
            } else {
                // Nếu $result rỗng, phản hồi lỗi
                echo json_encode([
                    'success' => false,
                    'message' => 'Thêm khách hàng thất bại'
                ]);
            }
            exit;
        }
        

        public function DeleteCustomerByID($id) {
            $customer = $this->mCustomer->getCustomerById($id);
            if($customer != null) {
                $tblCustomer = $this->mCustomer-> delete($id);
                if($tblCustomer) {
                    return $tblCustomer;
                } else {
                    return false;
                }
            } else {
                return "Không tìm thấy Khách hàng có ID :" .$id;
            }
           
        }

        public function updateCustomerPoint($customerID,  $invoiceAmount) {
            $customerID = empty($customerID) ? null :  trim($customerID);
            $invoiceAmount = empty($invoiceAmount) ? null :  trim($invoiceAmount);

            $result = $this->mCustomer->updatePoint($customerID, $invoiceAmount);
            if($result) {
                return true;
            } 
            return false;
        }

        public function updateCustomerPointWithCoupon($customerID, $couponDiscount) {
            $customerID = empty($customerID) ? null :  trim($customerID);
            $couponDiscount= empty($couponDiscount) ? null :  trim($couponDiscount);

            $result = $this->mCustomer->updatePointWithCoupon($customerID, $couponDiscount);
            if($result) {
                return true;
            } 
            return false;
        }
    
        
        public function listCustomers($searchKeyword, $limit, $offset) {
            return $this->mCustomer->getCustomers($limit, $offset, $searchKeyword);
        }
        public function getTotalPages($searchKeyword, $limit) {
            $totalCustomers = $this->mCustomer->getTotalCustomers($searchKeyword);
            return ceil($totalCustomers / $limit);
        }
     
        

    }
?>
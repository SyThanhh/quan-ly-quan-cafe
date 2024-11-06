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

        public function SaveCustomer($id, $name, $email, $phone) {
            // Kiểm tra ID, nếu không có thì gán null
            $id = $id ? intval($id) : null;
        
            // Kiểm tra tính duy nhất của email trước khi lưu
            if (!$this->mCustomer->checkEmailUnique($id, $email)) {
                return ["success" => false, "message" => "Email đã tồn tại."];
            }
        
            // Lưu thông tin khách hàng
            if ($id !== null) {
                // Cập nhật thông tin khách hàng nếu ID đã tồn tại
                $result = $this->mCustomer->update($id, $name, $email, $phone);
            } else {
                // Thêm mới khách hàng nếu ID không tồn tại
                $result = $this->mCustomer->add($name, $email, $phone);
            }
        
            // Kiểm tra kết quả thực thi
            if ($result) {
                return ["success" => true, "message" => "Khách hàng đã được lưu thành công."];
            } else {
                return ["success" => false, "message" => "Có lỗi xảy ra khi lưu khách hàng."];
            }
        }
        

        public function DeleteCustomerByID($id) {
            $mCustomer  = new ModelCustomer();
            $customer = $mCustomer->getCustomerById($id);
            if($customer != null) {
                $tblCustomer = $mCustomer -> delete($id);
                if($tblCustomer) {
                    return $tblCustomer;
                } else {
                    return false;
                }
            } else {
                return "Không tìm thấy Khách hàng có ID :" .$id;
            }
           
        }

    
    }
?>
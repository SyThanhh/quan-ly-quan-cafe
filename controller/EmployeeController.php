<?php
    include("model/mEmployee.php");

    class EmployeeController {
        private $mEmployee;

        public function __construct() {
            $this->mEmployee = new ModelEmployee();
        }
    



        public function selectEmployeeByRoles($role) {
            $role = empty($role) ? null :  trim($role);
            $result = $this->mEmployee->getEmployeeByRole($role);
            if($result) {
                return $result;
            }
            return false;
        }
       

    
    }
?>
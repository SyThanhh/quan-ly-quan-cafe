<?php
    include_once('Model/mCategory.php');
    class cCategory{
        public function getCategory(){
            $p = new mCategory();
            $tbl = $p -> selCategory();
            if($tbl){
                if(mysqli_num_rows($tbl)>0){
                    return $tbl;
                }
                else{
                    return false;
                }
            }
            else{
                echo 'Lỗi kết nối!';
            }
        }

        public function getOneTH($CategoryID){
            $p = new mCategory();
            $tbl = $p -> selOneTH($CategoryID);
            if($tbl){
                if(mysqli_num_rows($tbl)>0){
                    return $tbl;
                }
                else{
                    return false;
                }
            }
            else{
                echo 'Lỗi kết nối!';
            }
        }
    }
?>
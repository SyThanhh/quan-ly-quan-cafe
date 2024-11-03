<?php
    include_once('./connect/database.php');
    class mCategory{
        public function selCategory(){
            $p = new Database();
            $con = $p -> connect();
            if($con){
                $str = "select * from Category";
                $tbl = mysqli_query($con, $str);
                return $tbl;
            }
            else{
                echo 'Lỗi kết nối!';
            }
        }

        public function selOneTH($CategoryID){
            $p = new Database();
            $con = $p -> connect();
            if($con){
                $str = "select * from Category where CategoryID = '$CategoryID'";
                $tbl = mysqli_query($con, $str);
                return $tbl;
            }
            else{
                echo 'Lỗi kết nối!';
            }
        }
    }
?>
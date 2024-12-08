<?php
    if(!isset($_SERVER["HTTP_REFERER"])) {
        header('refresh:0; url="index.php"');
    }
    else {
        $ProductID = $_GET["ProductID"];
        include_once("./controller/cMenu.php");
        $p = new cProduct();
        $kq = $p -> cDeleteMenu($ProductID);
        if($kq){
            echo "<script>alert('Xóa món trong menu thành công!')</script>";
            header('refresh:0; url="index.php?page=page_menu"');
        }
        else{
            echo "<script>alert('Xóa món trong menu thất bại!')</script>";
            header('refresh:0; url="index.php?page=page_menu"');
        }
    }
?>
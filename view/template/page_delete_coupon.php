<?php
    if(!isset($_SERVER["HTTP_REFERER"])) {
        header('refresh:0; url="index.php"');
    }
    else {
        $CouponID = $_REQUEST["CouponID"];
        include_once("./controller/cCoupon.php");
        $p = new cCoupon();
        $kq = $p -> cDeleteCp($CouponID);
        if($kq){
            echo "<script>alert('Xóa chương trình khuyến mãi thành công!')</script>";
            header('refresh:0; url="index.php?page=page_coupon"');
        }
        else{
            echo "<script>alert('Xóa chương trình khuyến mãi thất bại!')</script>";
            header('refresh:0; url="index.php?page=page_coupon"');
        }
    }
?>
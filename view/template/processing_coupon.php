<?php
header('Content-Type: application/json');
include_once('./controller/cCoupon.php'); 
$CouponController = new cCoupon();
if (isset($_GET['couponID'])) {
    $couponID = $_GET['couponID'];

    // Giả sử bạn có một phương thức getCouponByID trong CouponController
    $result = $CouponController->get01CouponByID($couponID);
    if ($result && mysqli_num_rows($result) > 0) {
        $coupon = mysqli_fetch_assoc($result);  // Chuyển đổi kết quả thành mảng
        $_SESSION['CouponID'] = $coupon['CouponID'];
        $_SESSION['CouponDiscount'] = $coupon['CouponDiscount'];
        $_SESSION['CouponCode'] = $coupon['CouponCode'];
        
        echo json_encode([
            'success' => true,
            'couponID' =>  $_SESSION['CouponID'],
            'couponDiscount' => $_SESSION['CouponDiscount'],
            'couponCode' =>   $_SESSION['CouponCode']
        ]);
    } else {
        echo json_encode([
            'success' => false
        ]);
    }
}
?>

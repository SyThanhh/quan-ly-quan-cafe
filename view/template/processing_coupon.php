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
        echo json_encode([
            'success' => true,
            'couponDiscount' => $coupon['CouponDiscount'],
            'couponCode' => $coupon['CouponCode']
        ]);
    } else {
        echo json_encode([
            'success' => false
        ]);
    }
}
?>

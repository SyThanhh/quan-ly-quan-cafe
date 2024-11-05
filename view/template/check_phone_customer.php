<?php
header('Content-Type: application/json');
error_reporting(0); // Tắt báo lỗi (có thể tạm thời)
include_once("./model/mCustomer.php");
$model = new ModelCustomer();

$phone = $_POST['phone'] ?? '';
$id = $_POST['id'] ?? null;
$response = ['exists' => false];
if (!empty($phone)) {
    $response['exists'] = !$model->checkPhoneUnique($id, $phone);
}


echo json_encode($response);


?>
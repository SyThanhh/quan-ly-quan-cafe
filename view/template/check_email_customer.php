<?php
header('Content-Type: application/json');
error_reporting(0); // Tắt báo lỗi (có thể tạm thời)

include_once("./model/mCustomer.php");

$model = new ModelCustomer();

$email = $_POST['email'] ?? '';
$id = $_POST['id'] ?? null;
$response = ['exists' => false]; 

if (!empty($email)) {
    $response['exists'] = !$model->checkEmailUnique($id, $email);
}

echo json_encode($response);
?>
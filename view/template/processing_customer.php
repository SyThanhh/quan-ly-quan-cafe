<?php
header('Content-Type: application/json');
include("./controller/CustomerController.php");
include("./controller/HandleEmail.php");
$controller = new CustomerController();
$handleEmail = new HandleEmail();

$action = $_POST['action'] ?? '';
// echo json_encode($_POST);
if ($action === 'add') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $result = $controller->SaveCustomer($id, $name, $email, $phone);

    
    echo json_encode($result);
    exit();
}

if ($action === 'edit') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $result = $controller->SaveCustomer($id, $name, $email, $phone);
    echo json_encode($result);
    exit();
}

if ($action === 'delete') {
    $id = $_POST['id'];
    $result = $controller->DeleteCustomerByID($id);
    echo json_encode(['success' => true, 'message' => 'Khách hàng đã được xóa.']);
    exit();
}

?>

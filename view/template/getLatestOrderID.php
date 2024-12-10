<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Chỉ gọi session_start nếu chưa có session nào được khởi tạo
}
header('Content-Type: application/json'); 

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    include_once('./controller/OrderController.php'); 
        $orderController = new OrderController();
    $orderID = $orderController->createOrderID();
    echo json_encode(['orderID' => $orderID]);
}

?>
<?php
header('Content-Type: application/json');
    include_once('./controller/OrderController.php'); 
    $orderController = new OrderController();


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Read the JSON data from the request body
        $orderData = json_decode(file_get_contents('php://input'), true);
    
        echo json_encode($orderData);
        // $result = $orderController->SaveOrder($orderData);
    
        // Send response back to the client
        // if ($result) {
        //     echo json_encode(['success' => true, 'message' => 'Order saved successfully.']);
        // } else {
        //     echo json_encode(['success' => false, 'message' => 'Failed to save the order.']);
        // }
    } else {
        // If it's not a POST request, return a 405 Method Not Allowed response
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    }
?>
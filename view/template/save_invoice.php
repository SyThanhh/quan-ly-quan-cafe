<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Chỉ gọi session_start nếu chưa có session nào được khởi tạo
}
header('Content-Type: application/json'); 

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_SESSION['invoiceData'])) {
        echo json_encode(['status' => 'success', 'data' => $_SESSION['invoiceData']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Không có dữ liệu hóa đơn']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    // Kiểm tra nếu hành động là xóa hóa đơn
    if ($action === 'delete_invoice') {
        unset($_SESSION['invoiceData']); // Xóa dữ liệu hóa đơn khỏi session
        echo json_encode(['status' => 'success', 'message' => 'Dữ liệu hóa đơn đã bị xóa']);
        exit;
    }

    // Kiểm tra nếu hành động là cập nhật hóa đơn
    if ($action === 'update_invoice' && isset($_POST['invoiceData'])) {
        $invoiceData = json_decode($_POST['invoiceData'], true);

        if ($invoiceData === null) {
            echo json_encode(['status' => 'error', 'message' => 'Dữ liệu không hợp lệ']);
            exit;
        }

        $_SESSION['invoiceData'] = $invoiceData;

        echo json_encode(['status' => 'success', 'data' => $_SESSION['invoiceData']]);
        exit;
    }

    // Nếu hành động không hợp lệ
    echo json_encode(['status' => 'error', 'message' => 'Hành động không hợp lệ']);
    exit;
}
?>

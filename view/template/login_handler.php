<?php
session_start();
include './connect/database.php';
$database = new Database();
$conn = $database->connect(); 
$username = $_POST['username'];
$password = $_POST['password'];

// Truy vấn thông tin người dùng
$sql = "SELECT CustomerID, CustomerName, CustomerPassword FROM customer WHERE CustomerName = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if ($password == $user['CustomerPassword']){
        $_SESSION['loggedin'] = true;
        $_SESSION['CustomerID'] = $user['CustomerID'];
        $_SESSION['username'] = $user['CustomerName'];

        // Kiểm tra nếu có ProductID trong session
        if (isset($_SESSION['ProductID']) && $_SESSION['ProductID'] != '') {
            $productID = $_SESSION['ProductID'];
            unset($_SESSION['ProductID']);  // Loại bỏ ProductID khỏi session sau khi sử dụng
            echo "ProductID: " . $productID;  // In ra để kiểm tra ProductID
            header("Location: index.php?page=page_productdetail&ProductID=$productID");
            exit();
        } else {
            echo "Không có ProductID trong session.";  // In ra nếu không có ProductID
            header("Location: index.php");  // Chuyển hướng về trang chủ nếu không có ProductID
            exit();
        }
    } else {
        header("Location: index.php?page=login&error=1");
        exit();
    }
} else {
    header("Location: index.php?page=login&error=1");
    exit();
}
?>

<?php
// Bắt đầu phiên làm việc
session_start();
<<<<<<< HEAD

// Kiểm tra nếu người dùng đã đăng nhập thì chuyển hướng về trang chủ
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: index.php");
    exit();
}

// Kiểm tra xem có dữ liệu POST từ form đăng nhập không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kết nối tới cơ sở dữ liệu
    $servername = "localhost";
    $username = "root";  // Tên đăng nhập MySQL
    $password = "";      // Mật khẩu MySQL
    $dbname = "db_ql3scoffee"; // Tên cơ sở dữ liệu

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Lấy dữ liệu từ form
    $username = $_POST['username'];
    $password = $_POST['password'];  // Mật khẩu người dùng nhập vào

    // Truy vấn kiểm tra tên đăng nhập
    $sql = "SELECT CustomerID, CustomerName, CustomerPassword, role FROM customer WHERE CustomerName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Nếu tìm thấy người dùng
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $db_username, $db_password, $role);
        $stmt->fetch();

        // Kiểm tra mật khẩu (nếu mật khẩu lưu dạng plain text, sử dụng so sánh trực tiếp)
        if ($password === $db_password) { // Nếu sử dụng hashing, thay `===` bằng `password_verify($password, $db_password)`
            // Lưu thông tin vào session
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $db_username;
            $_SESSION['role'] = $role;
            $_SESSION['id'] = $id;

            // Chuyển hướng đến trang tương ứng với vai trò
            if ($role === 'admin') {
                header("Location: index.php?page=index_admin");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            // Nếu mật khẩu không đúng
            header("Location: index.php?page=login&error=1");
            exit();
        }
    } else {
        // Nếu không tìm thấy người dùng
        header("Location: index.php?page=login&error=1");
        exit();
    }

    // Đóng kết nối
    $stmt->close();
    $conn->close();
=======
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
>>>>>>> 1fab64999df152db7cd97f4d658f14bf5821d914
}
?>

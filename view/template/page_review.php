<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include './connect/database.php';

$database = new Database();
$conn = $database->connect();

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$customerID = isset($_SESSION['idCustomer']) ? $_SESSION['idCustomer'] : 1; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productID = $_POST['ProductID'];  
    $rating = $_POST['rating'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    
    if (!empty($productID) && !empty($rating) && !empty($comment)) {

        $sql = "INSERT INTO comment (CustomerID, Content, Rating, CreateDate) VALUES (?, ?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $sql);
        
        if ($stmt === false) {
            echo "<script>alert('Lỗi trong việc chuẩn bị câu lệnh SQL: " . mysqli_error($conn) . "'); window.location.href='index.php?page=page_productdetail&ProductID=$productID';</script>";
            exit;
        }

        mysqli_stmt_bind_param($stmt, "isi", $customerID, $comment, $rating);
        $result = mysqli_stmt_execute($stmt);
    
        if ($result) {

            $commentID = mysqli_insert_id($conn);
            echo "CommentID: $commentID";  

            $sqlProductComment = "INSERT INTO comment_product (ProductID, CommentID) VALUES (?, ?)";
            $stmtProductComment = mysqli_prepare($conn, $sqlProductComment);
            
            if ($stmtProductComment === false) {
                echo "<script>alert('Lỗi trong việc chuẩn bị câu lệnh SQL cho liên kết sản phẩm: " . mysqli_error($conn) . "'); window.location.href='index.php?page=page_productdetail&ProductID=$productID';</script>";
                exit;
            }

            mysqli_stmt_bind_param($stmtProductComment, "si", $productID, $commentID);
            $resultProductComment = mysqli_stmt_execute($stmtProductComment);
    
            if ($resultProductComment) {
                echo "<script>alert('Đánh giá của bạn đã được gửi!'); window.location.href='index.php?page=page_productdetail&ProductID=$productID';</script>";
            } else {
                echo "<script>alert('Lỗi trong việc lưu đánh giá sản phẩm vào comment_product: " . mysqli_error($conn) . "'); window.location.href='index.php?page=page_productdetail&ProductID=$productID';</script>";
            }
        } else {
            echo "<script>alert('Lỗi trong việc lưu bình luận: " . mysqli_error($conn) . "'); window.location.href='index.php?page=page_productdetail&ProductID=$productID';</script>";
        }

        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmtProductComment);
    } else {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin đánh giá!'); window.location.href='index.php?page=page_productdetail&ProductID=$productID';</script>";
    }
}

mysqli_close($conn);
?>

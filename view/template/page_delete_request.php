<?php
    // Kiểm tra xem RequestID có tồn tại trong URL không
    if (isset($_GET['RequestID'])) {
        $RequestID = $_GET['RequestID'];

        // Include controller để xử lý xóa
        include_once("./controller/cRequest.php");
        $p = new cRequest();
        $kq = $p->cDeleteRq($RequestID);  // Gọi đến phương thức xóa trong controller

        // Kiểm tra kết quả xóa
        if ($kq) {
            echo "<script>alert('Xóa phiếu yêu cầu thành công!'); window.location.href='index.php?page=page_requestform';</script>";
        } else {
            echo "<script>alert('Xóa phiếu yêu cầu thất bại!'); window.location.href='index.php?page=page_requestform';</script>";
        }
    }
?>

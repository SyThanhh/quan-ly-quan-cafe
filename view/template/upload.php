<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kiểm tra xem file đã được chọn chưa
    if (isset($_FILES['ProductImage'])) {
        $errors = [];
        $file_name = $_FILES['ProductImage']['name'];
        $file_size = $_FILES['ProductImage']['size'];
        $file_tmp = $_FILES['ProductImage']['tmp_name'];
        $file_type = $_FILES['ProductImage']['type'];
        
        // Phân tách phần mở rộng
        $file_ext = strtolower(end(explode('.', $file_name)));

        // Các phần mở rộng được phép
        $extensions = ["jpeg", "jpg", "png", "gif"];
        
        // Kiểm tra phần mở rộng
        if (in_array($file_ext, $extensions) === false) {
            $errors[] = "Phần mở rộng không hợp lệ, chỉ cho phép jpeg, jpg, png, gif.";
        }

        // Kiểm tra kích thước file (giới hạn 2MB)
        if ($file_size > 2097152) {
            $errors[] = "Kích thước file phải nhỏ hơn 2MB.";
        }

        // Nếu không có lỗi, tiến hành upload
        if (empty($errors)) {
            $upload_dir = "uploads/"; // Thư mục lưu trữ ảnh
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true); // Tạo thư mục nếu chưa tồn tại
            }

            // Tạo tên file mới để tránh trùng lặp
            $new_file_name = uniqid() . '.' . $file_ext;
            move_uploaded_file($file_tmp, $upload_dir . $new_file_name);
            
            // Trả về đường dẫn ảnh đã upload
            echo "Ảnh đã được upload thành công: " . $upload_dir . $new_file_name;

            // Gọi hàm mInSertMenu để lưu thông tin sản phẩm
            // $this->mInSertMenu(..., $new_file_name, ...); // Gọi với tên file ảnh đã upload
        } else {
            // Hiển thị lỗi
            foreach ($errors as $error) {
                echo $error . "<br/>";
            }
        }
    }
}
?>

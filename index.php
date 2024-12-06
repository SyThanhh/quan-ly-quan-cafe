<?php   
    session_start();

?>
<?php


   $page = isset($_GET['page']) ? $_GET['page'] : null; // Mặc định là null



   // Đường dẫn đến thư mục chứa các file trang
   $page_directory = 'view/template/';
   
   // Nếu không có tham số 'page', không làm gì cả
   if ($page) {
       $page_file = $page_directory . $page . '.php';
   
       // Kiểm tra xem file có tồn tại không
       if (file_exists($page_file)) {
         
            include($page_file); 
       } else {
           include($page_directory . '404.php'); 
       }
   } else {
        include("./view/template/home.php");
   }

?>

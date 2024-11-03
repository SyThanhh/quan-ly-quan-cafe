<?php
include_once('./connect/database.php');
$db = new Database();
$conn = $db->connect();

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
echo "Hello";
$productData = [];
$sql = "SELECT ProductName, SUM(quantity) as total_sales FROM orderdetail od JOIN product p ON od.ProductID = p.ProductID GROUP BY product_id";
$result = $conn->query($sql);

// Kiểm tra truy vấn
if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $productData['labels'][] = $row['name'];
            $productData['datasets'][0]['data'][] = (int)$row['total_sales'];
        }
    } else {
        $productData['labels'] = []; // Không có sản phẩm
        $productData['datasets'][0]['data'] = [];
    }

    // Thiết lập màu sắc động cho các sản phẩm
    $colors = [];
    for ($i = 0; $i < count($productData['labels']); $i++) {
        $colors[] = 'rgba(' . rand(0, 255) . ', ' . rand(0, 255) . ', ' . rand(0, 255) . ', 0.2)';
    }
    $borderColors = array_map(function($color) {
        return str_replace('0.2', '1', $color); // Tăng độ đậm cho border
    }, $colors);

    $productData['datasets'][0]['backgroundColor'] = $colors;
    $productData['datasets'][0]['borderColor'] = $borderColors;
    $productData['datasets'][0]['borderWidth'] = 1;

} else {
    // Xử lý lỗi truy vấn
    die("Lỗi truy vấn: " . $conn->error);
}

// Trả về dữ liệu dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($productData);

?>

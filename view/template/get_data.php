<?php
header('Content-Type: application/json');

// Bao gồm tệp kết nối cơ sở dữ liệu
include_once($_SERVER['DOCUMENT_ROOT'] . '/quan-ly-quan-cafe/connect/database.php');

$db = new Database();
$conn = $db->connect(); // Kết nối đã được thiết lập trong constructor

// Kiểm tra kết nối
if (!$conn) {
    echo json_encode(['error' => 'Kết nối thất bại: ' . mysqli_connect_error()]);
    exit;
}

// Khởi tạo mảng để lưu dữ liệu
$responseData = [
    'labels' => [],
    'datasets' => [[
        'data' => [],
        'backgroundColor' => [],
        'borderColor' => [],
        'borderWidth' => 1,
    ]]
];

// Lấy kiểu thống kê từ tham số URL
$type = isset($_GET['type']) ? $_GET['type'] : 'products';

// Xử lý các loại thống kê khác nhau
switch ($type) {
    case 'products':
        $sql = "SELECT p.ProductName, SUM(od.quantity) AS total_sales 
                FROM orderdetail od JOIN product p ON p.ProductID = od.ProductID
                GROUP BY od.ProductID";
                
        break;

    case 'points':
        $sql = "SELECT c.CustomerName, c.CustomerPoint, SUM(p.UnitPrice * od.Quantity) AS TotalPrice
        FROM customer c
        JOIN `order` o ON c.CustomerID = o.CustomerID
        JOIN orderdetail od ON od.OrderID = o.OrderID
        JOIN product p ON p.ProductID = od.ProductID
        GROUP BY c.CustomerID"; 
            
                
        break;

    default:
        echo json_encode(['error' => 'Kiểu thống kê không hợp lệ']);
        exit;
}

// Thực hiện truy vấn
$result = $conn->query($sql);

// Kiểm tra kết quả truy vấn
if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            switch ($type) {
                case 'products':
                    $responseData['title'] = "Số lượng bán";
                    $responseData['labels'][] = $row['ProductName'];
                    $responseData['datasets'][0]['data'][] = (int)$row['total_sales'];
                    break;

                case 'points':
                    $responseData['title'] = "Thống kê khách hàng theo điểm và hàng mức";
                    $responseData['labels'][] = $row['CustomerName'] . ' (Điểm: ' . $row['CustomerPoint'] . ')';
                    $responseData['datasets'][0]['data'][] = (float)$row['TotalPrice']; // Dữ liệu tổng giá trị đơn hàng
                    break;
            }
        }
    }

    // Thiết lập màu sắc động cho các sản phẩm hoặc hạng mức
    $colors = [];
    for ($i = 0; $i < count($responseData['labels']); $i++) {
        $colors[] = 'rgba(' . rand(0, 255) . ', ' . rand(0, 255) . ', ' . rand(0, 255) . ', 0.2)';
    }
    $borderColors = array_map(function($color) {
        return str_replace('0.2', '1', $color); // Tăng độ đậm cho border
    }, $colors);

    $responseData['datasets'][0]['backgroundColor'] = $colors;
    $responseData['datasets'][0]['borderColor'] = $borderColors;
    $responseData['datasets'][0]['borderWidth'] = 1;

} else {
    // Xử lý lỗi truy vấn
    echo json_encode(['error' => 'Lỗi truy vấn: ' . $conn->error]);
    exit;
}

// Trả về dữ liệu dưới dạng JSON
echo json_encode($responseData);
?>
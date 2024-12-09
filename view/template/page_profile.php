<?php
// session_start();
include_once("./connect/database.php");
 $db = new Database();
 $conn = $db->connect();




$id_col = $_SESSION['id'];


$phone = "";
$email = "";
$notification = "";  // Biến thông báo
  $sql = "SELECT LastName, PhoneNumber, Email, Roles FROM employee WHERE EmployeeID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_col);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($username, $phone, $email, $role);
$stmt->fetch();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Nhân Viên</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Thông Tin Nhân Viên</h3>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label for="name">Tên Nhân Viên</label>
                                <input type="text" id="username" class="form-control" value="<?php echo htmlspecialchars($username); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="phone">Số Điện Thoại</label>
                                <input type="text" id="phone" class="form-control" value="<?php echo htmlspecialchars($phone); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="role">Vai Trò</label>
                                <input type="text" id="role" class="form-control" value="<?php echo htmlspecialchars($role); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <a href="index.php?page=index_admin" class="btn btn-link">Quay lại trang admin</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gọi các thư viện JavaScript của Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

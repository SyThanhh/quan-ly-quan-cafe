<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Đầu trang -->
    <?php
        include_once('./common/head/head.php');    
        include_once('./connect/database.php'); // Đường dẫn vào file kết nối database

        // Tạo một đối tượng Database để kết nối
        $database = new Database();
        $conn = $database->connect(); // Lấy kết nối
    ?>
    <link rel="stylesheet" href="./assets/css/employee_shift.css">
</head>

<body>
    <div id="wrapper">
        <!-- Thanh điều hướng dọc -->
        <?php include_once('./common/menu/siderbar.php'); ?>

        <!-- Giao giện trang -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Thanh điều hướng ngang -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_2.svg"
                                            alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_3.svg"
                                            alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>
                </nav>

                <!-- Nội dung trang -->
                <?php
                    // Lấy mã ca làm sắp tới (MAX + 1) từ database
                    $result = $conn->query("SELECT MAX(ShiftID) AS max_id FROM workshift");
                    $row = $result->fetch_assoc();
                    $nextShiftID = $row['max_id'] + 1;

                    // Lấy danh sách nhân viên đứng quầy
                    $cashierEmployees = $conn->query("SELECT EmployeeID, CONCAT(LastName, ' ', FirstName) AS FullName FROM employee WHERE Roles = 2");
                    // Lấy danh sách nhân viên kế toán
                    $accountingEmployees = $conn->query("SELECT EmployeeID, CONCAT(LastName, ' ', FirstName) AS FullName FROM employee WHERE Roles = 3");
                    // Lấy danh sách nhân viên pha chế
                    $baristaEmployees = $conn->query("SELECT EmployeeID, CONCAT(LastName, ' ', FirstName) AS FullName FROM employee WHERE Roles = 4");
                ?>
                <div class="container-fluid" align="center">
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <h4>THÊM LỊCH MỚI</h4>
                                </br>   
                            </div>
                            <form action="" method="post">
                                <table>
                                    <tr>
                                        <th><label for="shiftID">Mã Ca Làm:</label></th>
                                        <td><input type="text" class="form-control" id="shiftID" name="shiftID" value="<?php echo $nextShiftID; ?>" readonly></td>
                                    </tr>
                                    <tr>
                                        <th><label for="shiftType">Loại Ca Làm:</label></th>
                                        <td>
                                            <select id="shiftType" class="form-control" name="shiftType" required>
                                                <option value="Sáng">Ca Sáng</option>
                                                <option value="Chiều">Ca Chiều</option>
                                                <option value="Tối">Ca Tối</option>
                                                <option value="Đêm">Ca Đêm</option>
                                                <option value="Linh Hoạt">Ca Linh Hoạt</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><label>Thời Gian Áp Dụng:</label></th>
                                    <tr>    
                                    </tr>
                                        <td>
                                            <label for="startDate">Ngày bắt đầu:</label>
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" id="startDate" name="startDate" required>
                                        </td>                                
                                    </tr> 
                                    <tr>  
                                        <td>
                                            <label for="endDate">Ngày kết thúc:</label>
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" id="endDate" name="endDate" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><label for="cashier">Nhân Viên Đứng Quầy:</label></th>
                                        <td>
                                            <select id="cashier" class="form-control" name="cashier" required>
                                                <?php while ($employee = $cashierEmployees->fetch_assoc()) {
                                                    echo "<option value='{$employee['EmployeeID']}'>{$employee['FullName']}</option>";
                                                } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><label for="accountant">Nhân Viên Kế Toán:</label></th>
                                        <td>
                                            <select id="accountant" class="form-control" name="accountant" required>
                                                <?php while ($employee = $accountingEmployees->fetch_assoc()) {
                                                    echo "<option value='{$employee['EmployeeID']}'>{$employee['FullName']}</option>";
                                                } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><label for="barista">Nhân Viên Pha Chế:</label></th>
                                        <td>
                                            <select id="barista" class="form-control" name="barista" required>
                                                <?php while ($employee = $baristaEmployees->fetch_assoc()) {
                                                    echo "<option value='{$employee['EmployeeID']}'>{$employee['FullName']}</option>";
                                                } ?>
                                            </select>
                                        </td>
                                    </tr>
                                </table>

                                <!-- Button section -->
                                <div class="button-group">
                                    </br>
                                    <button type="button" class='btn btn-danger' onclick="window.history.back();">Hủy</button>
                                    <button class="btn btn-secondary" type="reset">Làm Lại</button>
                                    <button type="submit" class="btn btn-primary btn-add">Thêm Lịch</button>
                                </div>
                            </form>        
                        </div>
                    </div>
                </div>
            </div>
            <!-- Cuối trang -->
            <?php include_once('./common/footer/footer.php'); ?>
        </div>    

    <!-- Bootstrap core JavaScript-->
    <?php include_once('./common/script/default.php'); ?>
</body>
</html>

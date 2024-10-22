	-- Tạo bảng Customer
CREATE TABLE Customer (
    CustomerID INT PRIMARY KEY AUTO_INCREMENT,        -- Khóa chính với tự động tăng
    CustomerName VARCHAR(50) NOT NULL,                     -- Tên khách hàng, không được null
    CustomerPhone VARCHAR(15) NOT NULL UNIQUE,                    -- Số điện thoại, không được null
    CustomerPassword VARCHAR(30) NOT NULL DEFAULT '123456',-- Mật khẩu với giá trị mặc định
    CustomerPoint INT(10) NOT NULL DEFAULT 0,              -- Điểm tích lũy với giá trị mặc định
    Email VARCHAR(50) NOT NULL unique,                            -- Địa chỉ email, không được null
    CreateAt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(), -- Thời gian tạo tài khoản
    UpdatedAt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP() -- Thời gian cập nhật
);


CREATE TABLE Coupon (
    CouponID INT PRIMARY KEY AUTO_INCREMENT,           -- Khóa chính với tự động tăng
    CouponCode VARCHAR(20) UNIQUE NOT NULL,               -- Mã coupon, duy nhất và không cho phép NULL
    StartDate DATETIME NOT NULL,                           -- Ngày bắt đầu hiệu lực
    EndDate DATETIME NOT NULL,                             -- Ngày kết thúc hiệu lực
    Description VARCHAR(255) NOT NULL,  
	CouponDiscount DECIMAL(5, 2) DEFAULT 0 NOT NULL, -- Mô tả coupon
	Status TINYINT(1) DEFAULT 1 NOT NULL,        
    UpdateAt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP() -- Thời gian cập nhật
);
        
-- Create Workshift
CREATE TABLE WorkShift (
    ShiftID INT PRIMARY KEY AUTO_INCREMENT,                     -- Khóa chính
    ShiftType VARCHAR(255) NOT NULL,             -- Loại ca làm việc
    StartDate DATE NOT NULL,                      -- Ngày bắt đầu
    EndDate DATE NOT NULL                         -- Ngày kết thúc
);

CREATE TABLE Supplier (
    SupplierID VARCHAR(10) PRIMARY KEY,         -- Khóa chính cho nhà cung cấp
    CompanyName VARCHAR(100) NOT NULL UNIQUE,          -- Tên công ty
    ContactName VARCHAR(100) NOT NULL,          -- Tên của người liên hệ
    Address VARCHAR(255),                        -- Địa chỉ
    Phone VARCHAR(15) NOT NULL,                 -- Số điện thoại
    Fax VARCHAR(15)                             -- Số fax (có thể để null)
);

CREATE TABLE Category (
    CategoryID INT PRIMARY KEY AUTO_INCREMENT,                -- Khóa chính
    CategoryName VARCHAR(50) NOT NULL,                        -- Tên danh mục
    Description VARCHAR(255),                                  -- Mô tả danh mục
    Status TINYINT NOT NULL DEFAULT 1,                                   -- Trạng thái (0/1)
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP -- Ngày cập nhật
);

CREATE TABLE Employee (
    EmployeeID INT PRIMARY KEY AUTO_INCREMENT,                -- Khóa chính
    FirstName VARCHAR(50) NOT NULL,           -- Tên
    LastName VARCHAR(50) NOT NULL,            -- Họ
   	Email varchar(50) not null Unique,
    PhoneNumber VARCHAR(15) not null Unique,                   -- Số điện thoại
    Roles tinyint not null,
    Status TINYINT DEFAULT 1,                           -- Trạng thái (0/1)
    DateOfBirth DATETIME not null,                         -- Ngày sinh
    CreateAt DATETIME DEFAULT CURRENT_TIMESTAMP, -- Ngày tạo
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP -- Ngày cập nhật
);

CREATE TABLE WorkShift_Employee (
    ShiftID INT,                                 -- Khóa ngoại từ WorkShift
    EmployeeID INT,                              -- Khóa ngoại từ Employee
    PRIMARY KEY (ShiftID, EmployeeID),          -- Khóa chính là tổ hợp
    FOREIGN KEY (ShiftID) REFERENCES WorkShift(ShiftID),
    FOREIGN KEY (EmployeeID) REFERENCES Employee(EmployeeID)
);


CREATE TABLE `Order` (
    OrderID VARCHAR(6) PRIMARY KEY,                          -- Khóa chính, mã đơn hàng-- Khóa ngoại, mã nhân viên
    Discount DECIMAL(10, 2) DEFAULT 0.0 NOT NULL,           -- Giảm giá với giá trị mặc định là 0.0
    PaymentMethod VARCHAR(20) NOT NULL,                     -- Phương thức thanh toán
    TotalAmount DECIMAL(10, 2) DEFAULT 0.0 NOT NULL,       -- Tổng số tiền của hóa đơn
    Status TINYINT(1) DEFAULT 0 NOT NULL,                   -- Trạng thái hóa đơn (0 = chưa thanh toán, 1 = đã thanh toán)
    CreateDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
	CouponID INT NOT NULL,                               -- Khóa ngoại, mã coupon
    CustomerID INT NOT NULL,                            -- Khóa ngoại, mã khách hàng
    EmployeeID INT NOT NULL,  -- Ngày tạo hóa đơn
    FOREIGN KEY (CouponID) REFERENCES Coupon(CouponID),     -- Khóa ngoại tham chiếu đến bảng Coupon
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID), -- Khóa ngoại tham chiếu đến bảng Customer
    FOREIGN KEY (EmployeeID) REFERENCES Employee(EmployeeID)  -- Khóa ngoại tham chiếu đến bảng Employee
);


CREATE TABLE RequestForm (
    RequestID VARCHAR(10) PRIMARY KEY,         -- Khóa chính
    RequestQuantity INT NOT NULL,              -- Số lượng yêu cầu
    Status TINYINT DEFAULT 0,                           -- Trạng thái (0/1)
    ApproveDate DATETIME,                         -- Ngày phê duyệt
    CreateDate DATETIME DEFAULT CURRENT_TIMESTAMP, -- Ngày tạo
    EmployeeID INT,                           -- Khóa ngoại đến Employee
    FOREIGN KEY (EmployeeID) REFERENCES Employee(EmployeeID) -- Khóa ngoại
);

CREATE TABLE Product (
    ProductID VARCHAR(10) PRIMARY KEY,         -- Khóa chính
    ProductName VARCHAR(100) NOT NULL,         -- Tên sản phẩm
    UnitPrice DECIMAL(10, 2) NOT NULL,         -- Giá đơn vị
    UnitsInStock INT,                -- Số lượng tồn kho
    Status TINYINT,                            -- Trạng thái (0/1)
    Description VARCHAR(255),                   -- Mô tả sản phẩm
    CreateAt DATETIME DEFAULT CURRENT_TIMESTAMP, -- Ngày tạo
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- Ngày cập nhật
    RequestID varchar(10) NULL,                               -- Khóa ngoại tham chiếu đến RequestForm
    CategoryID INT, 
    FOREIGN KEY (RequestID) REFERENCES RequestForm(RequestID),
  	FOREIGN KEY (CategoryID) REFERENCES Category(CategoryID)
);

CREATE TABLE OrderDetail (
    OrderID VARCHAR(6) NOT NULL,                               -- Khóa chính và khóa ngoại, mã đơn hàng
    ProductID VARCHAR(6) NOT NULL,                            -- Khóa chính và khóa ngoại, mã sản phẩm
    UnitPrice DECIMAL(10, 2) DEFAULT 0.0 NOT NULL,            -- Giá bán của sản phẩm
    Quantity INT DEFAULT 1 NOT NULL,                       -- Số lượng sản phẩm
    CreateDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,    -- Ngày tạo chi tiết hóa đơn
    PRIMARY KEY (OrderID, ProductID),                         -- Khóa chính là sự kết hợp của OrderID và ProductID
    FOREIGN KEY (OrderID) REFERENCES `Order`(OrderID),       -- Khóa ngoại tham chiếu đến bảng Order
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID)     -- Khóa ngoại tham chiếu đến bảng Product
);


CREATE TABLE Comment (
    CommentID INT PRIMARY KEY AUTO_INCREMENT,                   -- Khóa chính
    Content VARCHAR(255) NOT NULL,               -- Nội dung bình luận
	Rating DECIMAL(1,1) DEFAULT 0.0 NOT NULL CHECK (Rating BETWEEN 0.0 AND 5.0),             -- Đánh giá (0.0 - 5.0)
    Status TINYINT DEFAULT 1,                      -- Trạng thái (0/1)
    CreateDate DATE NOT NULL,                    -- Ngày tạo bình luận
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- Thời gian cập nhật
    CustomerID INT,                              -- Khóa ngoại tham chiếu đến Customer
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID)  -- Khóa ngoại liên kết với Customer
);


CREATE TABLE Comment_Product (
    ProductID VARCHAR(10),                       -- Mã sản phẩm
    CommentID INT,                               -- Mã bình luận
    PRIMARY KEY (ProductID, CommentID),         -- Khóa chính kết hợp
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID),  -- Khóa ngoại tham chiếu đến bảng Product
    FOREIGN KEY (CommentID) REFERENCES Comment(CommentID)   -- Khóa ngoại tham chiếu đến bảng Comment
);



CREATE TABLE Product_Supplier (
    ProductID VARCHAR(10),                       -- ID sản phẩm
    SupplierID VARCHAR(10),                      -- ID nhà cung cấp
    PRIMARY KEY (ProductID, SupplierID),        -- Khóa chính kết hợp
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID),  -- Khóa ngoại tham chiếu đến bảng Product
    FOREIGN KEY (SupplierID) REFERENCES Supplier(SupplierID) -- Khóa ngoại tham chiếu đến bảng Supplier
);


-- INSERT dữ liệu
-- INSERT dữ liệu
INSERT INTO Customer (CustomerName, CustomerPhone, CustomerPassword, CustomerPoint, Email) VALUES
('Nguyễn Văn A', '0123456789', 'password1', 100, 'vana@example.com'),
('Trần Thị B', '0123456780', 'password2', 200, 'thib@example.com'),
('Lê Văn C', '0123456781', 'password3', 50, 'vanc@example.com'),
('Phạm Thị D', '0123456782', 'password4', 20, 'thid@example.com'),
('Nguyễn Thị E', '0123456783', 'password5', 10, 'thie@example.com');


INSERT INTO Coupon (CouponCode, StartDate, EndDate, Description, CouponDiscount, Status) VALUES
('COUPON01', '2024-01-01', '2024-12-31', 'Giảm giá 10%', 10.00, 1),
('COUPON02', '2024-02-01', '2024-11-30', 'Giảm giá 15%', 15.00, 1),
('COUPON03', '2024-03-01', '2024-10-31', 'Giảm giá 20%', 20.00, 1),
('COUPON04', '2024-04-01', '2024-09-30', 'Giảm giá 29%', 20.00, 1),
('COUPON05', '2024-05-01', '2024-08-31', 'Giảm giá 10%', 10.00, 1);


INSERT INTO WorkShift (ShiftType, StartDate, EndDate) VALUES
('Ca sáng', '2024-01-01', '2024-01-31'),
('Ca chiều', '2024-02-01', '2024-02-28'),
('Ca tối', '2024-03-01', '2024-03-31'),
('Ca đêm', '2024-04-01', '2024-04-30'),
('Ca linh hoạt', '2024-05-01', '2024-05-31');


INSERT INTO Supplier (SupplierID, CompanyName, ContactName, Address, Phone, Fax) VALUES
('SP001', 'Công ty A', 'Nguyễn Văn X', 'Hà Nội', '0123456789', NULL),
('SP002', 'Công ty B', 'Trần Thị Y', 'Đà Nẵng', '0123456780', NULL),
('SP003', 'Công ty C', 'Lê Văn Z', 'TP. Hồ Chí Minh', '0123456781', NULL),
('SP004', 'Công ty D', 'Phạm Thị W', 'Hải Phòng', '0123456782', NULL),
('SP005', 'Công ty E', 'Nguyễn Thị V', 'Nha Trang', '0123456783', NULL);


INSERT INTO Category (CategoryName, Description, Status) VALUES
('Cafe pha máy', 'Các loại Cafe pha máy', 1),
('Cafe pha phin', 'Các loại Cafe pha phin', 1),
('Nước ép', 'Các loại nước ép', 1),
('Trà', 'Các loại nước ép', 1);

INSERT INTO Employee (FirstName, LastName, Email, PhoneNumber, Roles, DateOfBirth) VALUES
('Nguyễn', 'Thanh', 'nguyenthanh@email.com', '0123456789', 1, '1990-01-01'),
('Trần', 'Trang', 'trungtran@email.com', '0123456780', 2, '1991-02-01'),
('Lê', 'Bá', 'bale@mail.com', '0123456781', 3, '1992-03-01'),
('Phạm', 'Dũng', 'dungpham@mail.com', '0123456782', 4, '1993-04-01');
-- 1.Quản lý
-- 2: Nhân viên đứng quầy
-- 3: Nhân viên kế toán
-- 4: Nhân viên pha chế 

INSERT INTO WorkShift_Employee (ShiftID, EmployeeID) VALUES
(1, 1),
(1, 2),
(2, 3),
(3, 4);


INSERT INTO `Order` (OrderID, Discount, PaymentMethod, TotalAmount, Status, CouponID, CustomerID, EmployeeID) VALUES
('HD0001', 0.0, 'Tiền mặt', 100.00, 0, 1, 1, 2),
('HD0002', 5.0, 'Chuyển khoản', 150.00, 1, 2, 2, 2),
('HD0003', 10.0, 'Chuyển khoản', 200.00, 1, 3, 3, 2),
('HD0004', 0.0, 'Tiền mặt', 250.00, 0, 4, 4, 2),
('HD0005', 15.0, 'Chuyển khoản', 300.00, 1, 5, 5, 2);

INSERT INTO RequestForm (RequestID, RequestQuantity, Status, EmployeeID) VALUES
('RQ0001', 10, 0, 1),
('RQ0002', 20, 1, 2),
('RQ0003', 5, 0, 3),
('RQ0004', 15, 1, 4);

INSERT INTO Product (ProductID, ProductName, UnitPrice, UnitsInStock, Status, Description, RequestID, CategoryID) VALUES
('PR0001', 'Cà phê', 50.00, 100, 1, 'Cà phê ngon', 'RQ0001', 1),
('PR0002', 'Trà', 30.00, 150, 1, 'Trà xanh', 'RQ0002', 1),
('PR0003', 'Bánh ngọt', 20.00, 200, 1, 'Bánh ngọt tự làm', 'RQ0003', 2),
('PR0004', 'Nước ngọt', 15.00, 250, 1, 'Nước ngọt giải khát', 'RQ0004', 2),
('PR0005', 'Mì ăn liền', 10.00, 300, 1, 'Mì ăn liền tiện lợi', 'RQ0003', 3);



INSERT INTO OrderDetail (OrderID, ProductID, UnitPrice, Quantity) VALUES
('HD0001', 'PR0001', 50.00, 2),
('HD0002', 'PR0002', 30.00, 3),
('HD0003', 'PR0003', 20.00, 1),
('HD0004', 'PR0004', 15.00, 4),
('HD0005', 'PR0005', 10.00, 5);

INSERT INTO Comment (Content, Rating, CreateDate, CustomerID) VALUES
('Sản phẩm rất tốt!', 5.0, '2024-01-01', 1),
('Dịch vụ tuyệt vời!', 4.5, '2024-02-01', 2),
('Giá cả hợp lý.', 4.0, '2024-03-01', 3),
('Thích thú với sản phẩm.', 5.0, '2024-04-01', 4),
('Không hài lòng với chất lượng.', 2.0, '2024-05-01', 5);

INSERT INTO Comment_Product (ProductID, CommentID) VALUES
('PR0001', 1),
('PR0002', 2),
('PR0003', 3),
('PR0004', 4),
('PR0005', 5);


INSERT INTO Product_Supplier (ProductID, SupplierID) VALUES
('PR0001', 'SP001'),
('PR0002', 'SP002'),
('PR0003', 'SP003'),
('PR0004', 'SP004'),
('PR0005', 'SP005')


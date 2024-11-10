-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 10, 2024 lúc 09:50 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `code_data_ql3scoffee`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(50) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Status` tinyint(4) NOT NULL DEFAULT 1,
  `UpdatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`CategoryID`, `CategoryName`, `Description`, `Status`, `UpdatedAt`) VALUES
(1, 'Cafe pha máy', 'Các loại Cafe pha máy', 1, '2024-11-10 15:10:11'),
(2, 'Cafe pha phin', 'Các loại Cafe pha phin', 1, '2024-11-10 15:10:11'),
(3, 'Nước ép', 'Các loại nước ép', 1, '2024-11-10 15:10:11'),
(4, 'Trà', 'Các loại nước ép', 1, '2024-11-10 15:10:11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment`
--

CREATE TABLE `comment` (
  `CommentID` int(11) NOT NULL,
  `Content` varchar(255) NOT NULL,
  `Rating` decimal(1,1) NOT NULL DEFAULT 0.0 CHECK (`Rating` between 0.0 and 5.0),
  `Status` tinyint(4) DEFAULT 1,
  `CreateDate` date NOT NULL,
  `UpdatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CustomerID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `comment`
--

INSERT INTO `comment` (`CommentID`, `Content`, `Rating`, `Status`, `CreateDate`, `UpdatedAt`, `CustomerID`) VALUES
(1, 'Sản phẩm rất tốt!', 0.9, 1, '2024-01-01', '2024-11-10 15:10:12', 1),
(2, 'Dịch vụ tuyệt vời!', 0.9, 1, '2024-02-01', '2024-11-10 15:10:12', 2),
(3, 'Giá cả hợp lý.', 0.9, 1, '2024-03-01', '2024-11-10 15:10:12', 3),
(4, 'Thích thú với sản phẩm.', 0.9, 1, '2024-04-01', '2024-11-10 15:10:12', 4),
(5, 'Không hài lòng với chất lượng.', 0.9, 1, '2024-05-01', '2024-11-10 15:10:12', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment_product`
--

CREATE TABLE `comment_product` (
  `ProductID` varchar(10) NOT NULL,
  `CommentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `comment_product`
--

INSERT INTO `comment_product` (`ProductID`, `CommentID`) VALUES
('PR0001', 1),
('PR0002', 2),
('PR0003', 3),
('PR0004', 4),
('PR0005', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupon`
--

CREATE TABLE `coupon` (
  `CouponID` int(11) NOT NULL,
  `CouponCode` varchar(20) NOT NULL,
  `StartDate` datetime NOT NULL,
  `EndDate` datetime NOT NULL,
  `Description` varchar(255) NOT NULL,
  `CouponDiscount` decimal(5,2) NOT NULL DEFAULT 0.00,
  `Status` tinyint(1) NOT NULL DEFAULT 1,
  `UpdateAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `coupon`
--

INSERT INTO `coupon` (`CouponID`, `CouponCode`, `StartDate`, `EndDate`, `Description`, `CouponDiscount`, `Status`, `UpdateAt`, `Image`) VALUES
(1, 'COUPON01', '2024-01-01 00:00:00', '2024-12-31 00:00:00', 'Giảm giá 10%', 10.00, 1, '2024-11-10 15:13:53', '1.jpg'),
(2, 'COUPON02', '2024-02-01 00:00:00', '2024-11-30 00:00:00', 'Giảm giá 15%', 15.00, 1, '2024-11-10 15:14:05', '2.jpg'),
(3, 'COUPON03', '2024-03-01 00:00:00', '2024-10-31 00:00:00', 'Giảm giá 20%', 20.00, 1, '2024-11-10 15:14:14', '3.jpg'),
(4, 'COUPON04', '2024-04-01 00:00:00', '2024-09-30 00:00:00', 'Giảm giá 29%', 29.00, 1, '2024-11-10 15:28:26', '4.jpg'),
(5, 'COUPON05', '2024-05-01 00:00:00', '2024-08-31 00:00:00', 'Giảm giá 10%', 10.00, 1, '2024-11-10 15:14:29', '5.jpg'),
(6, 'COUPON06', '2024-05-01 00:00:00', '2024-08-31 00:00:00', 'Giảm giá 10%', 10.00, 1, '2024-11-10 15:14:29', '6.jpg'),
(7, 'COUPON07', '2024-05-01 00:00:00', '2024-08-31 00:00:00', 'Giảm giá 15%', 15.00, 1, '2024-11-10 15:28:09', '7.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer`
--

CREATE TABLE `customer` (
  `CustomerID` int(11) NOT NULL,
  `CustomerName` varchar(50) NOT NULL,
  `CustomerPhone` varchar(15) NOT NULL,
  `CustomerPassword` varchar(30) NOT NULL DEFAULT '123456',
  `CustomerPoint` int(10) NOT NULL DEFAULT 0,
  `Email` varchar(50) NOT NULL,
  `CreateAt` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `customer`
--

INSERT INTO `customer` (`CustomerID`, `CustomerName`, `CustomerPhone`, `CustomerPassword`, `CustomerPoint`, `Email`, `CreateAt`, `UpdatedAt`) VALUES
(1, 'Nguyễn Văn A', '0123456789', 'password1', 100, 'vana@example.com', '2024-11-10 15:10:11', '2024-11-10 15:10:11'),
(2, 'Trần Thị B', '0123456780', 'password2', 200, 'thib@example.com', '2024-11-10 15:10:11', '2024-11-10 15:10:11'),
(3, 'Lê Văn C', '0123456781', 'password3', 50, 'vanc@example.com', '2024-11-10 15:10:11', '2024-11-10 15:10:11'),
(4, 'Phạm Thị D', '0123456782', 'password4', 20, 'thid@example.com', '2024-11-10 15:10:11', '2024-11-10 15:10:11'),
(5, 'Nguyễn Thị E', '0123456783', 'password5', 10, 'thie@example.com', '2024-11-10 15:10:11', '2024-11-10 15:10:11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `employee`
--

CREATE TABLE `employee` (
  `EmployeeID` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `PhoneNumber` varchar(15) NOT NULL,
  `Roles` tinyint(4) NOT NULL,
  `Status` tinyint(4) DEFAULT 1,
  `DateOfBirth` datetime NOT NULL,
  `CreateAt` datetime DEFAULT current_timestamp(),
  `UpdatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `employee`
--

INSERT INTO `employee` (`EmployeeID`, `FirstName`, `LastName`, `Email`, `PhoneNumber`, `Roles`, `Status`, `DateOfBirth`, `CreateAt`, `UpdatedAt`) VALUES
(1, 'Nguyễn', 'Thanh', 'nguyenthanh@email.com', '0123456789', 1, 1, '1990-01-01 00:00:00', '2024-11-10 15:10:11', '2024-11-10 15:10:11'),
(2, 'Trần', 'Trang', 'trungtran@email.com', '0123456780', 2, 1, '1991-02-01 00:00:00', '2024-11-10 15:10:11', '2024-11-10 15:10:11'),
(3, 'Lê', 'Bá', 'bale@mail.com', '0123456781', 3, 1, '1992-03-01 00:00:00', '2024-11-10 15:10:11', '2024-11-10 15:10:11'),
(4, 'Phạm', 'Dũng', 'dungpham@mail.com', '0123456782', 4, 1, '1993-04-01 00:00:00', '2024-11-10 15:10:11', '2024-11-10 15:10:11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order`
--

CREATE TABLE `order` (
  `OrderID` varchar(6) NOT NULL,
  `Discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `PaymentMethod` varchar(20) NOT NULL,
  `TotalAmount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `Status` tinyint(1) NOT NULL DEFAULT 0,
  `CreateDate` datetime NOT NULL DEFAULT current_timestamp(),
  `CouponID` int(11) NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `EmployeeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order`
--

INSERT INTO `order` (`OrderID`, `Discount`, `PaymentMethod`, `TotalAmount`, `Status`, `CreateDate`, `CouponID`, `CustomerID`, `EmployeeID`) VALUES
('HD0001', 0.00, 'Tiền mặt', 100.00, 0, '2024-11-10 15:10:12', 1, 1, 2),
('HD0002', 5.00, 'Chuyển khoản', 150.00, 1, '2024-11-10 15:10:12', 2, 2, 2),
('HD0003', 10.00, 'Chuyển khoản', 200.00, 1, '2024-11-10 15:10:12', 3, 3, 2),
('HD0004', 0.00, 'Tiền mặt', 250.00, 0, '2024-11-10 15:10:12', 4, 4, 2),
('HD0005', 15.00, 'Chuyển khoản', 300.00, 1, '2024-11-10 15:10:12', 5, 5, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orderdetail`
--

CREATE TABLE `orderdetail` (
  `OrderID` varchar(6) NOT NULL,
  `ProductID` varchar(6) NOT NULL,
  `UnitPrice` decimal(10,2) NOT NULL DEFAULT 0.00,
  `Quantity` int(11) NOT NULL DEFAULT 1,
  `CreateDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orderdetail`
--

INSERT INTO `orderdetail` (`OrderID`, `ProductID`, `UnitPrice`, `Quantity`, `CreateDate`) VALUES
('HD0001', 'PR0001', 50.00, 2, '2024-11-10 15:10:12'),
('HD0002', 'PR0002', 30.00, 3, '2024-11-10 15:10:12'),
('HD0003', 'PR0003', 20.00, 1, '2024-11-10 15:10:12'),
('HD0004', 'PR0004', 15.00, 4, '2024-11-10 15:10:12'),
('HD0005', 'PR0005', 10.00, 5, '2024-11-10 15:10:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `ProductID` varchar(10) NOT NULL,
  `ProductName` varchar(100) NOT NULL,
  `UnitPrice` decimal(10,2) NOT NULL,
  `UnitsInStock` int(11) DEFAULT NULL,
  `Status` tinyint(4) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `CreateAt` datetime DEFAULT current_timestamp(),
  `UpdatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `RequestID` varchar(10) DEFAULT NULL,
  `CategoryID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `UnitPrice`, `UnitsInStock`, `Status`, `Description`, `CreateAt`, `UpdatedAt`, `RequestID`, `CategoryID`) VALUES
('PR0001', 'Cà phê', 50.00, 100, 1, 'Cà phê ngon', '2024-11-10 15:10:12', '2024-11-10 15:10:12', 'RQ0001', 1),
('PR0002', 'Trà', 30.00, 150, 1, 'Trà xanh', '2024-11-10 15:10:12', '2024-11-10 15:10:12', 'RQ0002', 1),
('PR0003', 'Bánh ngọt', 20.00, 200, 1, 'Bánh ngọt tự làm', '2024-11-10 15:10:12', '2024-11-10 15:10:12', 'RQ0003', 2),
('PR0004', 'Nước ngọt', 15.00, 250, 1, 'Nước ngọt giải khát', '2024-11-10 15:10:12', '2024-11-10 15:10:12', 'RQ0004', 2),
('PR0005', 'Mì ăn liền', 10.00, 300, 1, 'Mì ăn liền tiện lợi', '2024-11-10 15:10:12', '2024-11-10 15:10:12', 'RQ0003', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_supplier`
--

CREATE TABLE `product_supplier` (
  `ProductID` varchar(10) NOT NULL,
  `SupplierID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_supplier`
--

INSERT INTO `product_supplier` (`ProductID`, `SupplierID`) VALUES
('PR0001', 'SP001'),
('PR0002', 'SP002'),
('PR0003', 'SP003'),
('PR0004', 'SP004'),
('PR0005', 'SP005');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `requestform`
--

CREATE TABLE `requestform` (
  `RequestID` varchar(10) NOT NULL,
  `RequestQuantity` int(11) NOT NULL,
  `Status` tinyint(4) DEFAULT 0,
  `ApproveDate` datetime DEFAULT NULL,
  `CreateDate` datetime DEFAULT current_timestamp(),
  `EmployeeID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `requestform`
--

INSERT INTO `requestform` (`RequestID`, `RequestQuantity`, `Status`, `ApproveDate`, `CreateDate`, `EmployeeID`) VALUES
('RQ0001', 10, 0, NULL, '2024-11-10 15:10:12', 1),
('RQ0002', 20, 1, NULL, '2024-11-10 15:10:12', 2),
('RQ0003', 5, 0, NULL, '2024-11-10 15:10:12', 3),
('RQ0004', 15, 1, NULL, '2024-11-10 15:10:12', 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `supplier`
--

CREATE TABLE `supplier` (
  `SupplierID` varchar(10) NOT NULL,
  `CompanyName` varchar(100) NOT NULL,
  `ContactName` varchar(100) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Phone` varchar(15) NOT NULL,
  `Fax` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `supplier`
--

INSERT INTO `supplier` (`SupplierID`, `CompanyName`, `ContactName`, `Address`, `Phone`, `Fax`) VALUES
('SP001', 'Công ty A', 'Nguyễn Văn X', 'Hà Nội', '0123456789', NULL),
('SP002', 'Công ty B', 'Trần Thị Y', 'Đà Nẵng', '0123456780', NULL),
('SP003', 'Công ty C', 'Lê Văn Z', 'TP. Hồ Chí Minh', '0123456781', NULL),
('SP004', 'Công ty D', 'Phạm Thị W', 'Hải Phòng', '0123456782', NULL),
('SP005', 'Công ty E', 'Nguyễn Thị V', 'Nha Trang', '0123456783', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `workshift`
--

CREATE TABLE `workshift` (
  `ShiftID` int(11) NOT NULL,
  `ShiftType` varchar(255) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `workshift`
--

INSERT INTO `workshift` (`ShiftID`, `ShiftType`, `StartDate`, `EndDate`) VALUES
(1, 'Ca sáng', '2024-01-01', '2024-01-31'),
(2, 'Ca chiều', '2024-02-01', '2024-02-28'),
(3, 'Ca tối', '2024-03-01', '2024-03-31'),
(4, 'Ca đêm', '2024-04-01', '2024-04-30'),
(5, 'Ca linh hoạt', '2024-05-01', '2024-05-31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `workshift_employee`
--

CREATE TABLE `workshift_employee` (
  `ShiftID` int(11) NOT NULL,
  `EmployeeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `workshift_employee`
--

INSERT INTO `workshift_employee` (`ShiftID`, `EmployeeID`) VALUES
(1, 1),
(1, 2),
(2, 3),
(3, 4);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Chỉ mục cho bảng `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `CustomerID` (`CustomerID`);

--
-- Chỉ mục cho bảng `comment_product`
--
ALTER TABLE `comment_product`
  ADD PRIMARY KEY (`ProductID`,`CommentID`),
  ADD KEY `CommentID` (`CommentID`);

--
-- Chỉ mục cho bảng `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`CouponID`),
  ADD UNIQUE KEY `CouponCode` (`CouponCode`);

--
-- Chỉ mục cho bảng `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerID`),
  ADD UNIQUE KEY `CustomerPhone` (`CustomerPhone`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Chỉ mục cho bảng `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`EmployeeID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `PhoneNumber` (`PhoneNumber`);

--
-- Chỉ mục cho bảng `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `CouponID` (`CouponID`),
  ADD KEY `CustomerID` (`CustomerID`),
  ADD KEY `EmployeeID` (`EmployeeID`);

--
-- Chỉ mục cho bảng `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD PRIMARY KEY (`OrderID`,`ProductID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `RequestID` (`RequestID`),
  ADD KEY `CategoryID` (`CategoryID`);

--
-- Chỉ mục cho bảng `product_supplier`
--
ALTER TABLE `product_supplier`
  ADD PRIMARY KEY (`ProductID`,`SupplierID`),
  ADD KEY `SupplierID` (`SupplierID`);

--
-- Chỉ mục cho bảng `requestform`
--
ALTER TABLE `requestform`
  ADD PRIMARY KEY (`RequestID`),
  ADD KEY `EmployeeID` (`EmployeeID`);

--
-- Chỉ mục cho bảng `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`SupplierID`),
  ADD UNIQUE KEY `CompanyName` (`CompanyName`);

--
-- Chỉ mục cho bảng `workshift`
--
ALTER TABLE `workshift`
  ADD PRIMARY KEY (`ShiftID`);

--
-- Chỉ mục cho bảng `workshift_employee`
--
ALTER TABLE `workshift_employee`
  ADD PRIMARY KEY (`ShiftID`,`EmployeeID`),
  ADD KEY `EmployeeID` (`EmployeeID`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `comment`
--
ALTER TABLE `comment`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `coupon`
--
ALTER TABLE `coupon`
  MODIFY `CouponID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `employee`
--
ALTER TABLE `employee`
  MODIFY `EmployeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `workshift`
--
ALTER TABLE `workshift`
  MODIFY `ShiftID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`);

--
-- Các ràng buộc cho bảng `comment_product`
--
ALTER TABLE `comment_product`
  ADD CONSTRAINT `comment_product_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`),
  ADD CONSTRAINT `comment_product_ibfk_2` FOREIGN KEY (`CommentID`) REFERENCES `comment` (`CommentID`);

--
-- Các ràng buộc cho bảng `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`CouponID`) REFERENCES `coupon` (`CouponID`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`),
  ADD CONSTRAINT `order_ibfk_3` FOREIGN KEY (`EmployeeID`) REFERENCES `employee` (`EmployeeID`);

--
-- Các ràng buộc cho bảng `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD CONSTRAINT `orderdetail_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `order` (`OrderID`),
  ADD CONSTRAINT `orderdetail_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`RequestID`) REFERENCES `requestform` (`RequestID`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`);

--
-- Các ràng buộc cho bảng `product_supplier`
--
ALTER TABLE `product_supplier`
  ADD CONSTRAINT `product_supplier_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`),
  ADD CONSTRAINT `product_supplier_ibfk_2` FOREIGN KEY (`SupplierID`) REFERENCES `supplier` (`SupplierID`);

--
-- Các ràng buộc cho bảng `requestform`
--
ALTER TABLE `requestform`
  ADD CONSTRAINT `requestform_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `employee` (`EmployeeID`);

--
-- Các ràng buộc cho bảng `workshift_employee`
--
ALTER TABLE `workshift_employee`
  ADD CONSTRAINT `workshift_employee_ibfk_1` FOREIGN KEY (`ShiftID`) REFERENCES `workshift` (`ShiftID`),
  ADD CONSTRAINT `workshift_employee_ibfk_2` FOREIGN KEY (`EmployeeID`) REFERENCES `employee` (`EmployeeID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

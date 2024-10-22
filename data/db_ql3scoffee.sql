-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2024 at 02:02 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ql3scoffee`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(50) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Status` tinyint(4) NOT NULL DEFAULT 1,
  `UpdatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CategoryID`, `CategoryName`, `Description`, `Status`, `UpdatedAt`) VALUES
(1, 'Cafe pha máy', 'Các loại Cafe pha máy', 1, '2024-10-21 21:40:43'),
(2, 'Cafe pha phin', 'Các loại Cafe pha phin', 1, '2024-10-21 21:40:43'),
(3, 'Nước ép', 'Các loại nước ép', 1, '2024-10-21 21:40:43'),
(4, 'Trà', 'Các loại nước ép', 1, '2024-10-21 21:40:43');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `CommentID` int(11) NOT NULL,
  `Content` varchar(255) NOT NULL,
  `Rating` decimal(1,1) NOT NULL DEFAULT 0.0 CHECK (`Rating` between 0.0 and 5.0),
  `Status` tinyint(4) DEFAULT 1,
  `CreateDate` date NOT NULL,
  `UpdatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CustomerID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`CommentID`, `Content`, `Rating`, `Status`, `CreateDate`, `UpdatedAt`, `CustomerID`) VALUES
(1, 'Sản phẩm rất tốt!', 0.9, 1, '2024-01-01', '2024-10-21 21:40:43', 1),
(2, 'Dịch vụ tuyệt vời!', 0.9, 1, '2024-02-01', '2024-10-21 21:40:43', 2),
(3, 'Giá cả hợp lý.', 0.9, 1, '2024-03-01', '2024-10-21 21:40:43', 3),
(4, 'Thích thú với sản phẩm.', 0.9, 1, '2024-04-01', '2024-10-21 21:40:43', 4),
(5, 'Không hài lòng với chất lượng.', 0.9, 1, '2024-05-01', '2024-10-21 21:40:43', 5);

-- --------------------------------------------------------

--
-- Table structure for table `comment_product`
--

CREATE TABLE `comment_product` (
  `ProductID` varchar(10) NOT NULL,
  `CommentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment_product`
--

INSERT INTO `comment_product` (`ProductID`, `CommentID`) VALUES
('PR0001', 1),
('PR0002', 2),
('PR0003', 3),
('PR0004', 4),
('PR0005', 5);

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `CouponID` int(11) NOT NULL,
  `CouponCode` varchar(20) NOT NULL,
  `StartDate` datetime NOT NULL,
  `EndDate` datetime NOT NULL,
  `Description` varchar(255) NOT NULL,
  `CouponDiscount` decimal(5,2) NOT NULL DEFAULT 0.00,
  `Status` tinyint(1) NOT NULL DEFAULT 1,
  `UpdateAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupon`
--

INSERT INTO `coupon` (`CouponID`, `CouponCode`, `StartDate`, `EndDate`, `Description`, `CouponDiscount`, `Status`, `UpdateAt`) VALUES
(1, 'COUPON01', '2024-01-01 00:00:00', '2024-12-31 00:00:00', 'Giảm giá 10%', 10.00, 1, '2024-10-21 21:40:43'),
(2, 'COUPON02', '2024-02-01 00:00:00', '2024-11-30 00:00:00', 'Giảm giá 15%', 15.00, 1, '2024-10-21 21:40:43'),
(3, 'COUPON03', '2024-03-01 00:00:00', '2024-10-31 00:00:00', 'Giảm giá 20%', 20.00, 1, '2024-10-21 21:40:43'),
(4, 'COUPON04', '2024-04-01 00:00:00', '2024-09-30 00:00:00', 'Giảm giá 29%', 20.00, 1, '2024-10-21 21:40:43'),
(5, 'COUPON05', '2024-05-01 00:00:00', '2024-08-31 00:00:00', 'Giảm giá 10%', 10.00, 1, '2024-10-21 21:40:43');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustomerID`, `CustomerName`, `CustomerPhone`, `CustomerPassword`, `CustomerPoint`, `Email`, `CreateAt`, `UpdatedAt`) VALUES
(1, 'Nguyễn Văn A', '0123456789', 'password1', 100, 'vana@example.com', '2024-10-21 21:40:43', '2024-10-21 21:40:43'),
(2, 'Trần Thị B', '0123456780', 'password2', 200, 'thib@example.com', '2024-10-21 21:40:43', '2024-10-21 21:40:43'),
(3, 'Lê Văn C', '0123456781', 'password3', 50, 'vanc@example.com', '2024-10-21 21:40:43', '2024-10-21 21:40:43'),
(4, 'Phạm Thị D', '0123456782', 'password4', 20, 'thid@example.com', '2024-10-21 21:40:43', '2024-10-21 21:40:43'),
(5, 'Nguyễn Thị E', '0123456783', 'password5', 10, 'thie@example.com', '2024-10-21 21:40:43', '2024-10-21 21:40:43');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`EmployeeID`, `FirstName`, `LastName`, `Email`, `PhoneNumber`, `Roles`, `Status`, `DateOfBirth`, `CreateAt`, `UpdatedAt`) VALUES
(1, 'Nguyễn', 'Thanh', 'nguyenthanh@email.com', '0123456789', 1, 1, '1990-01-01 00:00:00', '2024-10-21 21:40:43', '2024-10-21 21:40:43'),
(2, 'Trần', 'Trang', 'trungtran@email.com', '0123456780', 2, 1, '1991-02-01 00:00:00', '2024-10-21 21:40:43', '2024-10-21 21:40:43'),
(3, 'Lê', 'Bá', 'bale@mail.com', '0123456781', 3, 1, '1992-03-01 00:00:00', '2024-10-21 21:40:43', '2024-10-21 21:40:43'),
(4, 'Phạm', 'Dũng', 'dungpham@mail.com', '0123456782', 4, 1, '1993-04-01 00:00:00', '2024-10-21 21:40:43', '2024-10-21 21:40:43');

-- --------------------------------------------------------

--
-- Table structure for table `order`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`OrderID`, `Discount`, `PaymentMethod`, `TotalAmount`, `Status`, `CreateDate`, `CouponID`, `CustomerID`, `EmployeeID`) VALUES
('HD0001', 0.00, 'Tiền mặt', 100.00, 0, '2024-10-21 21:40:43', 1, 1, 2),
('HD0002', 5.00, 'Chuyển khoản', 150.00, 1, '2024-10-21 21:40:43', 2, 2, 2),
('HD0003', 10.00, 'Chuyển khoản', 200.00, 1, '2024-10-21 21:40:43', 3, 3, 2),
('HD0004', 0.00, 'Tiền mặt', 250.00, 0, '2024-10-21 21:40:43', 4, 4, 2),
('HD0005', 15.00, 'Chuyển khoản', 300.00, 1, '2024-10-21 21:40:43', 5, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `orderdetail`
--

CREATE TABLE `orderdetail` (
  `OrderID` varchar(6) NOT NULL,
  `ProductID` varchar(6) NOT NULL,
  `UnitPrice` decimal(10,2) NOT NULL DEFAULT 0.00,
  `Quantity` int(11) NOT NULL DEFAULT 1,
  `CreateDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderdetail`
--

INSERT INTO `orderdetail` (`OrderID`, `ProductID`, `UnitPrice`, `Quantity`, `CreateDate`) VALUES
('HD0001', 'PR0001', 50.00, 2, '2024-10-21 21:40:43'),
('HD0002', 'PR0002', 30.00, 3, '2024-10-21 21:40:43'),
('HD0003', 'PR0003', 20.00, 1, '2024-10-21 21:40:43'),
('HD0004', 'PR0004', 15.00, 4, '2024-10-21 21:40:43'),
('HD0005', 'PR0005', 10.00, 5, '2024-10-21 21:40:43');

-- --------------------------------------------------------

--
-- Table structure for table `product`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `UnitPrice`, `UnitsInStock`, `Status`, `Description`, `CreateAt`, `UpdatedAt`, `RequestID`, `CategoryID`) VALUES
('PR0001', 'Cà phê', 50.00, 100, 1, 'Cà phê ngon', '2024-10-21 21:40:43', '2024-10-21 21:40:43', 'RQ0001', 1),
('PR0002', 'Trà', 30.00, 150, 1, 'Trà xanh', '2024-10-21 21:40:43', '2024-10-21 21:40:43', 'RQ0002', 1),
('PR0003', 'Bánh ngọt', 20.00, 200, 1, 'Bánh ngọt tự làm', '2024-10-21 21:40:43', '2024-10-21 21:40:43', 'RQ0003', 2),
('PR0004', 'Nước ngọt', 15.00, 250, 1, 'Nước ngọt giải khát', '2024-10-21 21:40:43', '2024-10-21 21:40:43', 'RQ0004', 2),
('PR0005', 'Mì ăn liền', 10.00, 300, 1, 'Mì ăn liền tiện lợi', '2024-10-21 21:40:43', '2024-10-21 21:40:43', 'RQ0003', 3);

-- --------------------------------------------------------

--
-- Table structure for table `product_supplier`
--

CREATE TABLE `product_supplier` (
  `ProductID` varchar(10) NOT NULL,
  `SupplierID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_supplier`
--

INSERT INTO `product_supplier` (`ProductID`, `SupplierID`) VALUES
('PR0001', 'SP001'),
('PR0002', 'SP002'),
('PR0003', 'SP003'),
('PR0004', 'SP004'),
('PR0005', 'SP005');

-- --------------------------------------------------------

--
-- Table structure for table `requestform`
--

CREATE TABLE `requestform` (
  `RequestID` varchar(10) NOT NULL,
  `RequestQuantity` int(11) NOT NULL,
  `Status` tinyint(4) DEFAULT 0,
  `ApproveDate` datetime DEFAULT NULL,
  `CreateDate` datetime DEFAULT current_timestamp(),
  `EmployeeID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requestform`
--

INSERT INTO `requestform` (`RequestID`, `RequestQuantity`, `Status`, `ApproveDate`, `CreateDate`, `EmployeeID`) VALUES
('RQ0001', 10, 0, NULL, '2024-10-21 21:40:43', 1),
('RQ0002', 20, 1, NULL, '2024-10-21 21:40:43', 2),
('RQ0003', 5, 0, NULL, '2024-10-21 21:40:43', 3),
('RQ0004', 15, 1, NULL, '2024-10-21 21:40:43', 4);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `SupplierID` varchar(10) NOT NULL,
  `CompanyName` varchar(100) NOT NULL,
  `ContactName` varchar(100) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Phone` varchar(15) NOT NULL,
  `Fax` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`SupplierID`, `CompanyName`, `ContactName`, `Address`, `Phone`, `Fax`) VALUES
('SP001', 'Công ty A', 'Nguyễn Văn X', 'Hà Nội', '0123456789', NULL),
('SP002', 'Công ty B', 'Trần Thị Y', 'Đà Nẵng', '0123456780', NULL),
('SP003', 'Công ty C', 'Lê Văn Z', 'TP. Hồ Chí Minh', '0123456781', NULL),
('SP004', 'Công ty D', 'Phạm Thị W', 'Hải Phòng', '0123456782', NULL),
('SP005', 'Công ty E', 'Nguyễn Thị V', 'Nha Trang', '0123456783', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `workshift`
--

CREATE TABLE `workshift` (
  `ShiftID` int(11) NOT NULL,
  `ShiftType` varchar(255) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workshift`
--

INSERT INTO `workshift` (`ShiftID`, `ShiftType`, `StartDate`, `EndDate`) VALUES
(1, 'Ca sáng', '2024-01-01', '2024-01-31'),
(2, 'Ca chiều', '2024-02-01', '2024-02-28'),
(3, 'Ca tối', '2024-03-01', '2024-03-31'),
(4, 'Ca đêm', '2024-04-01', '2024-04-30'),
(5, 'Ca linh hoạt', '2024-05-01', '2024-05-31');

-- --------------------------------------------------------

--
-- Table structure for table `workshift_employee`
--

CREATE TABLE `workshift_employee` (
  `ShiftID` int(11) NOT NULL,
  `EmployeeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workshift_employee`
--

INSERT INTO `workshift_employee` (`ShiftID`, `EmployeeID`) VALUES
(1, 1),
(1, 2),
(2, 3),
(3, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `CustomerID` (`CustomerID`);

--
-- Indexes for table `comment_product`
--
ALTER TABLE `comment_product`
  ADD PRIMARY KEY (`ProductID`,`CommentID`),
  ADD KEY `CommentID` (`CommentID`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`CouponID`),
  ADD UNIQUE KEY `CouponCode` (`CouponCode`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerID`),
  ADD UNIQUE KEY `CustomerPhone` (`CustomerPhone`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`EmployeeID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `PhoneNumber` (`PhoneNumber`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `CouponID` (`CouponID`),
  ADD KEY `CustomerID` (`CustomerID`),
  ADD KEY `EmployeeID` (`EmployeeID`);

--
-- Indexes for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD PRIMARY KEY (`OrderID`,`ProductID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `RequestID` (`RequestID`),
  ADD KEY `CategoryID` (`CategoryID`);

--
-- Indexes for table `product_supplier`
--
ALTER TABLE `product_supplier`
  ADD PRIMARY KEY (`ProductID`,`SupplierID`),
  ADD KEY `SupplierID` (`SupplierID`);

--
-- Indexes for table `requestform`
--
ALTER TABLE `requestform`
  ADD PRIMARY KEY (`RequestID`),
  ADD KEY `EmployeeID` (`EmployeeID`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`SupplierID`),
  ADD UNIQUE KEY `CompanyName` (`CompanyName`);

--
-- Indexes for table `workshift`
--
ALTER TABLE `workshift`
  ADD PRIMARY KEY (`ShiftID`);

--
-- Indexes for table `workshift_employee`
--
ALTER TABLE `workshift_employee`
  ADD PRIMARY KEY (`ShiftID`,`EmployeeID`),
  ADD KEY `EmployeeID` (`EmployeeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `CouponID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `EmployeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `workshift`
--
ALTER TABLE `workshift`
  MODIFY `ShiftID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`);

--
-- Constraints for table `comment_product`
--
ALTER TABLE `comment_product`
  ADD CONSTRAINT `comment_product_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`),
  ADD CONSTRAINT `comment_product_ibfk_2` FOREIGN KEY (`CommentID`) REFERENCES `comment` (`CommentID`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`CouponID`) REFERENCES `coupon` (`CouponID`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`),
  ADD CONSTRAINT `order_ibfk_3` FOREIGN KEY (`EmployeeID`) REFERENCES `employee` (`EmployeeID`);

--
-- Constraints for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD CONSTRAINT `orderdetail_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `order` (`OrderID`),
  ADD CONSTRAINT `orderdetail_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`RequestID`) REFERENCES `requestform` (`RequestID`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`);

--
-- Constraints for table `product_supplier`
--
ALTER TABLE `product_supplier`
  ADD CONSTRAINT `product_supplier_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`),
  ADD CONSTRAINT `product_supplier_ibfk_2` FOREIGN KEY (`SupplierID`) REFERENCES `supplier` (`SupplierID`);

--
-- Constraints for table `requestform`
--
ALTER TABLE `requestform`
  ADD CONSTRAINT `requestform_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `employee` (`EmployeeID`);

--
-- Constraints for table `workshift_employee`
--
ALTER TABLE `workshift_employee`
  ADD CONSTRAINT `workshift_employee_ibfk_1` FOREIGN KEY (`ShiftID`) REFERENCES `workshift` (`ShiftID`),
  ADD CONSTRAINT `workshift_employee_ibfk_2` FOREIGN KEY (`EmployeeID`) REFERENCES `employee` (`EmployeeID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

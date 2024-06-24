-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2024 at 04:08 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `donerkings`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(11) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `PasswordHash` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `Username`, `PasswordHash`) VALUES
(3, 'admin10', '$2y$10$c8HQyRzhAeCcx6KYAjhUNeQFq0qzAvrMamSs1cz1KwLkMMYeUkwPK'),
(4, 'admin20', '$2y$10$Naf9wT8gaimo25.zYNeGreBef/SVyUtios6NaiZ9mYKPhOFVyyV0O');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustomerID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `PasswordHash` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustomerID`, `Name`, `Email`, `Phone`, `Address`, `PasswordHash`) VALUES
(9, 'Harsh Khetia', 'harshjkhetia@gmail.com', '', '', '$2y$10$MfBaRltK1KeIz8FYWub8tOu9pyYZhubYtEa00nTElXH2zvsO/BkjW');

-- --------------------------------------------------------

--
-- Table structure for table `daily_sales`
--

CREATE TABLE `daily_sales` (
  `SaleDate` date NOT NULL,
  `TotalSales` decimal(10,2) NOT NULL,
  `NumberOfOrders` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `daily_sales`
--

INSERT INTO `daily_sales` (`SaleDate`, `TotalSales`, `NumberOfOrders`) VALUES
('2024-02-22', '336.67', 4),
('2024-02-23', '161.87', 3);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `ItemID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT 1,
  `LocationID` int(11) DEFAULT NULL,
  `imagePath` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`ItemID`, `Name`, `Description`, `Price`, `Active`, `LocationID`, `imagePath`) VALUES
(46, 'Classic Doner Kebab', 'A delicious blend of seasoned meat, fresh vegetables, wrapped in warm flatbread.', '9.99', 1, 1, 'images/img1.jpg'),
(47, 'Chicken Shawarma', 'Marinated chicken grilled to perfection, served with garlic sauce and pickles.', '8.99', 1, 1, 'images/img2.jpg'),
(48, 'Falafel Wrap', 'Crispy falafel balls wrapped with salad in a soft flatbread, served with tahini sauce.', '7.99', 1, 1, 'images/img3.jpg'),
(49, 'Lamb Gyro', 'Tender slices of lamb with tzatziki sauce, onions, and tomatoes.', '10.99', 1, 1, 'images/img4.jpg'),
(50, 'Beef Taco', 'Ground beef, lettuce, cheese, and salsa wrapped in a soft or crunchy corn tortilla.', '3.99', 1, 1, 'images/img5.jpg'),
(51, 'Veggie Burger', 'A hearty, flavorful veggie patty on a toasted bun with lettuce, tomato, and your choice of toppings.', '8.49', 1, 1, 'images/img6.jpg'),
(52, 'Spicy Chicken Wings', 'Crispy wings tossed in our signature spicy sauce.', '6.99', 1, 1, 'images/img7.jpg'),
(53, 'Caesar Salad', 'Crisp romaine lettuce, parmesan cheese, croutons, and Caesar dressing.', '5.99', 1, 1, 'images/img8.jpg'),
(54, 'Pepperoni Pizza', 'Classic pepperoni pizza with a rich tomato sauce and mozzarella cheese.', '11.99', 1, 1, 'images/img9.jpg'),
(55, 'Mushroom Risotto', 'Creamy risotto cooked with wild mushrooms and a hint of truffle oil.', '12.99', 1, 1, 'images/img10.jpg'),
(56, 'Pasta Carbonara', 'Spaghetti with crispy bacon, parmesan cheese, and a creamy egg sauce.', '10.99', 1, 1, 'images/img11.jpg'),
(57, 'BBQ Ribs', 'Slow-cooked ribs smothered in BBQ sauce, served with fries and coleslaw.', '14.99', 1, 1, 'images/img12.jpg'),
(58, 'Grilled Salmon', 'Perfectly grilled salmon fillet, served with steamed vegetables and lemon butter.', '13.99', 1, 1, 'images/img13.jpg'),
(59, 'Steak Frites', 'Juicy grilled steak served with a generous portion of crispy fries.', '15.99', 1, 1, 'images/img14.jpg'),
(60, 'Chocolate Lava Cake', 'Warm chocolate cake with a gooey center, served with vanilla ice cream.', '6.99', 1, 1, 'images/img15.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `LocationID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`LocationID`, `Name`, `Address`) VALUES
(1, 'Downtown Branch', '123 Main St, Manchester'),
(2, 'Citycenter', '123 que, paris');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `CustomerID` int(11) DEFAULT NULL,
  `StaffID` int(11) DEFAULT NULL,
  `OrderDate` date NOT NULL,
  `Status` enum('NEW','PREPARING','COMPLETED','CANCELLED') NOT NULL,
  `TotalPrice` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `CustomerID`, `StaffID`, `OrderDate`, `Status`, `TotalPrice`) VALUES
(1, NULL, NULL, '2024-02-22', 'COMPLETED', '27.98'),
(2, NULL, NULL, '2024-02-22', 'PREPARING', '12.99'),
(3, NULL, NULL, '2024-02-22', 'PREPARING', '18.98'),
(4, NULL, NULL, '2024-02-22', 'NEW', '18.98'),
(5, NULL, NULL, '2024-02-22', 'NEW', '9.99'),
(6, NULL, NULL, '2024-02-22', 'NEW', '23.98'),
(7, NULL, NULL, '2024-02-22', 'NEW', '80.94'),
(8, NULL, NULL, '2024-02-22', 'NEW', '9.99'),
(9, NULL, NULL, '2024-02-22', 'NEW', '27.98'),
(10, NULL, NULL, '2024-02-22', 'NEW', '12.99'),
(11, NULL, NULL, '2024-02-22', 'NEW', '22.98'),
(12, NULL, NULL, '2024-02-22', 'PREPARING', '23.98'),
(13, NULL, NULL, '2024-02-22', 'PREPARING', '179.82'),
(14, NULL, NULL, '2024-02-22', 'NEW', '109.89'),
(15, NULL, NULL, '2024-02-23', 'NEW', '93.92'),
(16, NULL, NULL, '2024-02-23', 'NEW', '53.96'),
(17, NULL, NULL, '2024-02-23', 'NEW', '13.99');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `StaffID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Role` enum('Manager','Cashier','Chef') NOT NULL,
  `PasswordHash` char(60) NOT NULL,
  `AdminID` int(11) DEFAULT NULL,
  `LocationID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`StaffID`, `Name`, `Email`, `Role`, `PasswordHash`, `AdminID`, `LocationID`) VALUES
(5, 'Harsh Khetia', 'work.harshkhetia@gmail.com', 'Manager', '$2y$10$0kvJ90VJ8wu5YnZfUjb6H.bA.ZgRHAd9YZJiz09nwlzhE06Votxv.', 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `StockID` int(11) NOT NULL,
  `ItemID` int(11) NOT NULL,
  `LocationID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`StockID`, `ItemID`, `LocationID`, `Quantity`) VALUES
(4, 48, 1, 200),
(6, 49, 2, 8),
(8, 46, 1, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `daily_sales`
--
ALTER TABLE `daily_sales`
  ADD PRIMARY KEY (`SaleDate`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`ItemID`),
  ADD KEY `LocationID` (`LocationID`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`LocationID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `idx_CustomerID` (`CustomerID`),
  ADD KEY `idx_StaffID` (`StaffID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`StaffID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `AdminID` (`AdminID`),
  ADD KEY `LocationID` (`LocationID`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`StockID`),
  ADD KEY `ItemID` (`ItemID`),
  ADD KEY `LocationID` (`LocationID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `LocationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `StaffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `StockID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`LocationID`) REFERENCES `location` (`LocationID`) ON DELETE SET NULL;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`AdminID`) REFERENCES `admin` (`AdminID`) ON DELETE SET NULL,
  ADD CONSTRAINT `staff_ibfk_2` FOREIGN KEY (`LocationID`) REFERENCES `location` (`LocationID`) ON DELETE SET NULL;

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `fk_stock_item` FOREIGN KEY (`ItemID`) REFERENCES `item` (`ItemID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_stock_location` FOREIGN KEY (`LocationID`) REFERENCES `location` (`LocationID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

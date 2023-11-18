-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 18, 2023 at 04:36 AM
-- Server version: 10.6.15-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u863194874_webinventorydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `cashier_temp`
--

CREATE TABLE `cashier_temp` (
  `pro_ID` bigint(8) UNSIGNED NOT NULL,
  `pro_IDQR` varchar(20) DEFAULT NULL,
  `pro_name` varchar(40) NOT NULL,
  `pro_price` decimal(11,2) NOT NULL,
  `pro_quantity` int(11) NOT NULL,
  `pro_total` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catdiscount`
--

CREATE TABLE `catdiscount` (
  `catdis_ID` bigint(8) UNSIGNED NOT NULL,
  `cat` varchar(15) NOT NULL,
  `catdis` decimal(11,2) DEFAULT NULL,
  `catdisper` decimal(11,2) DEFAULT NULL,
  `catdistart` date NOT NULL,
  `catdisend` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customerlist`
--

CREATE TABLE `customerlist` (
  `cust_ID` bigint(8) UNSIGNED NOT NULL,
  `cust_name` varchar(50) NOT NULL,
  `cust_con` varchar(50) DEFAULT NULL,
  `cust_mail` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gendiscount`
--

CREATE TABLE `gendiscount` (
  `gendis_ID` bigint(8) UNSIGNED NOT NULL,
  `gendis` decimal(11,2) DEFAULT NULL,
  `gendisper` decimal(11,2) DEFAULT NULL,
  `gendisqual` int(8) DEFAULT NULL,
  `gendistart` date NOT NULL,
  `gendisend` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gendiscount`
--

INSERT INTO `gendiscount` (`gendis_ID`, `gendis`, `gendisper`, `gendisqual`, `gendistart`, `gendisend`) VALUES
(1, 5000.00, 5.00, 5, '2012-03-23', '0002-03-23'),
(2, 5.00, 5.00, 3000, '2023-12-26', '0003-12-26'),
(3, 12.00, 12.00, 100000, '0000-00-00', '0000-00-00'),
(4, 5.00, 1.00, 1000, '2023-07-07', '2024-07-07');

-- --------------------------------------------------------

--
-- Table structure for table `itemdiscount`
--

CREATE TABLE `itemdiscount` (
  `itemdis_IDQR` varchar(12) DEFAULT NULL,
  `pro_ID` varchar(15) NOT NULL,
  `pro_name` varchar(40) NOT NULL,
  `itemdis` decimal(11,2) DEFAULT NULL,
  `itemdisper` decimal(11,2) DEFAULT NULL,
  `itemdistart` date NOT NULL,
  `itemdisend` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `itemdiscount`
--

INSERT INTO `itemdiscount` (`itemdis_IDQR`, `pro_ID`, `pro_name`, `itemdis`, `itemdisper`, `itemdistart`, `itemdisend`) VALUES
('123a', '', 'dasdas', 12.00, 12.00, '0000-00-00', '0000-00-00'),
('123d', '', 'Sunglasses', 5.00, 1.00, '2023-07-07', '2024-07-07');

-- --------------------------------------------------------

--
-- Table structure for table `itemlist`
--

CREATE TABLE `itemlist` (
  `pro_ID` bigint(8) UNSIGNED NOT NULL,
  `pro_IDQR` varchar(20) DEFAULT NULL,
  `pro_inf` varchar(255) NOT NULL,
  `pro_name` varchar(40) NOT NULL,
  `pro_cat` varchar(30) NOT NULL,
  `pro_price` decimal(11,2) NOT NULL,
  `pro_maxStock` int(11) NOT NULL,
  `pro_quantity` int(11) NOT NULL,
  `pro_unit` varchar(10) DEFAULT NULL,
  `pro_warr` tinyint(1) DEFAULT NULL,
  `pro_warrRng` date DEFAULT NULL,
  `pro_reorder` int(11) NOT NULL,
  `pro_minStock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `itemlist`
--

INSERT INTO `itemlist` (`pro_ID`, `pro_IDQR`, `pro_inf`, `pro_name`, `pro_cat`, `pro_price`, `pro_maxStock`, `pro_quantity`, `pro_unit`, `pro_warr`, `pro_warrRng`, `pro_reorder`, `pro_minStock`) VALUES
(2, '123b', '10-Cup Drip Coffee Machine', 'Coffee Maker', 'Home Appliances', 10000.00, 0, 6, NULL, NULL, NULL, 10, 0),
(3, '123c', '55 Inch UHD', 'Smart TV', 'Electronics', 85000.00, 0, 0, NULL, NULL, NULL, 0, 0),
(4, '123d', 'Polarized UV Protection Shades', 'Sunglasses', 'Fashion', 200.00, 0, 5, NULL, NULL, NULL, 2, 0),
(5, '123e', '700W High-Speed Countertop Blender', 'Blender', 'Home Appliances', 16000.00, 0, 1, NULL, NULL, NULL, 0, 0),
(6, '123f', 'Noise-Canceling Bluetooth Headset', 'Wireless Headphones', 'Electronics', 8000.00, 0, 0, NULL, NULL, NULL, 0, 0),
(7, '123g', 'Men\'s Slim Fit Dark Blue Denim', 'Jeans', 'Clothing', 750.00, 0, 0, NULL, NULL, NULL, 0, 0),
(8, '123h', 'Waterproof Activity Monitor', 'Fitness Tracker', 'Sports & Fitness', 6000.00, 0, 0, NULL, NULL, NULL, 0, 0),
(9, '123i', 'Ergonomic Office Chair', 'Desk Chair', 'Furniture', 5000.00, 0, 0, NULL, NULL, NULL, 0, 0),
(10, '123j', 'Men\'s Stainless Steel Chronograph', 'Watch', 'Accessories', 20000.00, 0, 0, NULL, NULL, NULL, 0, 0),
(11, '123k', '5.8 Qt Digital Hot Air Fryer', 'Air Fryer', 'Home Appliances', 15000.00, 0, 0, NULL, NULL, NULL, 0, 0),
(12, '123l', 'Optical Bluetooth Mouse', 'Wireless Mouse', 'Electronics', 2000.00, 0, 0, NULL, NULL, NULL, 0, 0),
(13, '123m', 'Women\'s Elegant A-line Dress', 'Dress', 'Clothing', 875.00, 0, 0, NULL, NULL, NULL, 0, 0),
(14, '123n', '2TB USB 3.0 Portable HDD', 'External Hard Drive', 'Electronics', 1000.00, 0, 0, NULL, NULL, NULL, 0, 0),
(15, '123o', 'Men\'s Quick Dry Workout Shorts', 'Running Shorts', 'Sports & Fitness', 1200.00, 0, 3, NULL, NULL, NULL, 0, 0),
(16, '123p', '2-Slice Stainless Steel Toaster', 'Toaster', 'Home Appliances', 8500.00, 0, 0, NULL, NULL, NULL, 0, 0),
(17, '123q', 'Canvas Crossbody Laptop Messenger', 'Messenger Bag', 'Accessories', 1590.00, 0, 0, NULL, NULL, NULL, 0, 0),
(18, '123r', 'Cordless Portable Car Vacuum Cleaner', 'Handheld Vacuum', 'Home Appliances', 19000.00, 0, 7, NULL, NULL, NULL, 0, 0),
(19, '123s', 'Women\'s Casual Hooded Sweatshirt', 'Hoodie', 'Clothing', 950.00, 0, 0, NULL, NULL, NULL, 0, 0),
(20, '123t', 'Slim 2.4GHz Compact Keyboard', 'Wireless Keyboard', 'Electronics', 2598.00, 0, 0, NULL, NULL, NULL, 0, 0),
(21, '123u', 'Full-Face Protection', 'Motorcycle Helmet', 'Motorcycle', 5979.00, 0, 0, NULL, NULL, NULL, 0, 0),
(22, '123v', 'Men\'s Classic Black', 'Leather Motorcycle Jacket', 'Motorcycle', 2500.00, 0, 0, NULL, NULL, NULL, 0, 0),
(23, '123w', 'All-Weather Riding Gloves', 'Motorcycle Gloves', 'Motorcycle', 475.00, 0, 0, NULL, NULL, NULL, 0, 0),
(24, '123x', 'Waterproof Riding Boots', 'Motorcycle Boots', 'Motorcycle', 1399.00, 0, 0, NULL, NULL, NULL, 0, 0),
(25, '123y', 'UV-Resistant Bike Cover', 'Motorcycle Cover', 'Motorcycle', 899.00, 0, 0, NULL, NULL, NULL, 0, 0),
(26, '123z', 'Handlebar Smartphone Holder', 'Motorcycle Phone Mount', 'Motorcycle', 850.00, 0, 0, NULL, NULL, NULL, 0, 0),
(27, '123{', 'Waterproof Rider\'s Backpack', 'Motorcycle Backpack', 'Motorcycle', 7599.00, 0, 0, NULL, NULL, NULL, 0, 0),
(28, '123|', 'Heavy-Duty Bike Security Lock', 'Motorcycle Chain Lock', 'Motorcycle', 2500.00, 0, 0, NULL, NULL, NULL, 0, 0),
(29, '123}', 'LED Headlamp for Night Riding', 'Motorcycle Headlight', 'Motorcycle', 4999.00, 0, 0, NULL, NULL, NULL, 0, 0),
(34, '321c', 'Disposable', 'Vape', 'Smoking Device', 22.00, 100, 0, NULL, NULL, NULL, 0, 10),
(35, '321', 'Size 5', 'Nails', 'Construction', 3.00, 0, 12, NULL, NULL, NULL, 0, 0),
(36, '321b', 'Hex', 'Screw ', 'Construction', 5.00, 0, 11, NULL, NULL, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `occdiscounts`
--

CREATE TABLE `occdiscounts` (
  `id` int(11) NOT NULL,
  `mnt_occasion` varchar(255) NOT NULL,
  `mnt_discount` decimal(11,2) NOT NULL,
  `mnt_start` date NOT NULL,
  `mnt_end` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `occdiscounts`
--

INSERT INTO `occdiscounts` (`id`, `mnt_occasion`, `mnt_discount`, `mnt_start`, `mnt_end`) VALUES
(2, 'TestDiscount', 12.00, '2023-11-16', '2023-11-20');

-- --------------------------------------------------------

--
-- Table structure for table `polist`
--

CREATE TABLE `polist` (
  `po_PONO` bigint(8) DEFAULT NULL,
  `po_unit` varchar(50) DEFAULT NULL,
  `po_item` varchar(50) DEFAULT NULL,
  `pro_IDQR` varchar(50) DEFAULT NULL,
  `pro_name` varchar(50) DEFAULT NULL,
  `po_supp` varchar(50) DEFAULT NULL,
  `po_quantity` bigint(9) DEFAULT NULL,
  `po_unitPrice` decimal(11,2) DEFAULT NULL,
  `po_total` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `polist`
--

INSERT INTO `polist` (`po_PONO`, `po_unit`, `po_item`, `pro_IDQR`, `pro_name`, `po_supp`, `po_quantity`, `po_unitPrice`, `po_total`) VALUES
(0, 'pcs', 'construction', '321', 'Nails', 'STI ', 12, 3.00, 36.00),
(0, 'pcs', 'construction', '321b', 'Screw ', 'STI ', 11, 6.00, 66.00);

-- --------------------------------------------------------

--
-- Table structure for table `reclay`
--

CREATE TABLE `reclay` (
  `id` int(11) DEFAULT NULL,
  `storeName` varchar(24) DEFAULT NULL,
  `storeAddress` varchar(24) DEFAULT NULL,
  `storePhone` varchar(24) DEFAULT NULL,
  `storeEmail` varchar(24) DEFAULT NULL,
  `textbox1` varchar(24) DEFAULT NULL,
  `textbox2` varchar(24) DEFAULT NULL,
  `textbox3` varchar(24) DEFAULT NULL,
  `textbox4` varchar(24) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_report`
--

CREATE TABLE `sales_report` (
  `invoice_no` int(11) DEFAULT NULL,
  `customer_name` varchar(50) DEFAULT NULL,
  `paymeans` varchar(30) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(50) DEFAULT NULL,
  `product_quantity` int(11) DEFAULT NULL,
  `product_discount` decimal(11,2) DEFAULT NULL,
  `product_total` decimal(11,2) DEFAULT NULL,
  `discount` decimal(11,2) DEFAULT NULL,
  `tax` decimal(11,2) DEFAULT NULL,
  `grand_total` decimal(11,2) DEFAULT NULL,
  `date_purchased` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales_report`
--

INSERT INTO `sales_report` (`invoice_no`, `customer_name`, `paymeans`, `product_id`, `product_name`, `product_quantity`, `product_discount`, `product_total`, `discount`, `tax`, `grand_total`, `date_purchased`) VALUES
(0, 'cust', 'cash', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, '2023-11-11 07:50:41'),
(1, 'cust', 'cash', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, '2023-11-11 07:51:42'),
(2, 'cust', '', 123, 'Backpack', 1, 0.00, 0.00, 0.00, 0.00, 0.00, '2023-11-11 10:25:47'),
(2, 'cust', '', 123, 'Coffee Maker', 1, 0.00, 0.00, 0.00, 0.00, 0.00, '2023-11-11 10:25:47'),
(3, 'cust', '', 123, 'Backpack', 1, 0.00, 0.00, 0.00, 0.00, 0.00, '2023-11-11 10:26:43'),
(3, 'cust', '', 123, 'Coffee Maker', 1, 0.00, 0.00, 0.00, 0.00, 0.00, '2023-11-11 10:26:44'),
(4, 'cust', 'cash', 123, 'Backpack', 1, 0.00, 0.00, 0.00, 0.00, 0.00, '2023-11-11 10:28:47'),
(4, 'cust', 'cash', 123, 'Coffee Maker', 1, 0.00, 0.00, 0.00, 0.00, 0.00, '2023-11-11 10:28:47'),
(4, 'cust', 'cash', 123, 'Smart TV', 1, 0.00, 0.00, 0.00, 0.00, 0.00, '2023-11-11 10:28:47'),
(5, 'cust', 'cash', 123, 'Backpack', 1, 0.00, 0.00, 0.00, 0.00, 0.00, '2023-11-11 10:37:50'),
(5, 'cust', 'cash', 123, 'Leather Motorcycle Jacket', 1, 0.00, 0.00, 0.00, 0.00, 0.00, '2023-11-11 10:37:50'),
(5, 'cust', 'cash', 123, 'Smart TV', 1, 0.00, 0.00, 0.00, 0.00, 0.00, '2023-11-11 10:37:50'),
(5, 'cust', 'cash', 123, 'Coffee Maker', 1, 0.00, 0.00, 0.00, 0.00, 0.00, '2023-11-11 10:37:50'),
(6, 'cust', 'cash', 123, 'Backpack', 1, 0.00, 1000.00, 0.00, 0.00, 1000.00, '2023-11-11 10:43:09'),
(7, 'cust', 'cash', 123, 'Backpack', 1, 0.00, 1000.00, 0.00, 0.00, 1000.00, '2023-11-11 10:43:44'),
(8, 'cust', 'cash', 123, 'Backpack', 1, 0.00, 1000.00, 0.00, 0.00, 1000.00, '2023-11-11 10:49:07'),
(8, 'cust', 'cash', 123, 'Coffee Maker', 1, 0.00, 0.00, 0.00, 0.00, 1000.00, '2023-11-11 10:49:07'),
(9, 'cust', 'cash', 123, 'Backpack', 1, 0.00, 1000.00, 0.00, 0.00, 1000.00, '2023-11-11 10:49:27'),
(9, 'cust', 'cash', 123, 'Coffee Maker', 1, 0.00, 0.00, 0.00, 0.00, 1000.00, '2023-11-11 10:49:27'),
(10, 'cust', 'cash', 123, 'Backpack', 1, 0.00, 1000.00, 0.00, 0.00, 1000.00, '2023-11-11 10:52:55'),
(11, 'cust', 'cash', 123, 'Backpack', 1, 0.00, 1000.00, 5.00, 5.00, 1000.00, '2023-11-14 04:30:51'),
(12, 'cust', 'cash', 123, 'Backpack', 1, 12.00, 880.00, 17.00, 5.00, 774.40, '2023-11-17 07:22:23');

-- --------------------------------------------------------

--
-- Table structure for table `supdelivery`
--

CREATE TABLE `supdelivery` (
  `supdel_PONO` bigint(8) DEFAULT NULL,
  `supdel_unit` varchar(50) DEFAULT NULL,
  `supdel_item` varchar(50) DEFAULT NULL,
  `pro_IDQR` varchar(50) DEFAULT NULL,
  `pro_name` varchar(50) DEFAULT NULL,
  `supdel_supp` varchar(50) DEFAULT NULL,
  `supdel_quantity` bigint(9) DEFAULT NULL,
  `supdel_unitPrice` decimal(11,2) DEFAULT NULL,
  `supdel_total` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supdelivery`
--

INSERT INTO `supdelivery` (`supdel_PONO`, `supdel_unit`, `supdel_item`, `pro_IDQR`, `pro_name`, `supdel_supp`, `supdel_quantity`, `supdel_unitPrice`, `supdel_total`) VALUES
(0, 'pcs', 'construction', '321', 'Nails', 'STI ', 12, 3.00, 36.00),
(0, 'pcs', 'construction', '321b', 'Screw ', 'STI ', 11, 6.00, 66.00);

-- --------------------------------------------------------

--
-- Table structure for table `supplierlist`
--

CREATE TABLE `supplierlist` (
  `supp_ID` bigint(8) UNSIGNED NOT NULL,
  `supp_name` varchar(50) NOT NULL,
  `supp_add` varchar(50) DEFAULT NULL,
  `supp_conper` varchar(50) DEFAULT NULL,
  `supp_mail` varchar(50) DEFAULT NULL,
  `supp_con` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplierlist`
--

INSERT INTO `supplierlist` (`supp_ID`, `supp_name`, `supp_add`, `supp_conper`, `supp_mail`, `supp_con`) VALUES
(2, 'CCI - Home depot', 'Poblacion 4, Calaca City, Batangas', 'Austin', 'pascuarafael12@gmail.com', '09214036110'),
(3, 'Uxada Company', 'Barangay Balaybalay', 'Ziltahi Hwang Alfonso', 'projectnext46@gmail.com', '094444444442'),
(4, 'STI ', 'Calzada Balayan', 'STI', 'sti.balayan@gmail.com', '092443434343');

-- --------------------------------------------------------

--
-- Table structure for table `taxmnt`
--

CREATE TABLE `taxmnt` (
  `taxPer` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `taxmnt`
--

INSERT INTO `taxmnt` (`taxPer`) VALUES
(5.00);

-- --------------------------------------------------------

--
-- Table structure for table `userauth`
--

CREATE TABLE `userauth` (
  `user_ID` bigint(8) UNSIGNED NOT NULL,
  `user_role` varchar(15) NOT NULL,
  `user_name` varchar(40) NOT NULL,
  `user_password` varchar(40) NOT NULL,
  `user_fullname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userauth`
--

INSERT INTO `userauth` (`user_ID`, `user_role`, `user_name`, `user_password`, `user_fullname`) VALUES
(1, 'Administrator', 'admin', 'admin123', 'Admin-kun');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cashier_temp`
--
ALTER TABLE `cashier_temp`
  ADD PRIMARY KEY (`pro_ID`);

--
-- Indexes for table `catdiscount`
--
ALTER TABLE `catdiscount`
  ADD PRIMARY KEY (`catdis_ID`);

--
-- Indexes for table `customerlist`
--
ALTER TABLE `customerlist`
  ADD PRIMARY KEY (`cust_ID`);

--
-- Indexes for table `gendiscount`
--
ALTER TABLE `gendiscount`
  ADD PRIMARY KEY (`gendis_ID`);

--
-- Indexes for table `itemlist`
--
ALTER TABLE `itemlist`
  ADD PRIMARY KEY (`pro_ID`);

--
-- Indexes for table `occdiscounts`
--
ALTER TABLE `occdiscounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplierlist`
--
ALTER TABLE `supplierlist`
  ADD PRIMARY KEY (`supp_ID`);

--
-- Indexes for table `userauth`
--
ALTER TABLE `userauth`
  ADD PRIMARY KEY (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cashier_temp`
--
ALTER TABLE `cashier_temp`
  MODIFY `pro_ID` bigint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `catdiscount`
--
ALTER TABLE `catdiscount`
  MODIFY `catdis_ID` bigint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customerlist`
--
ALTER TABLE `customerlist`
  MODIFY `cust_ID` bigint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gendiscount`
--
ALTER TABLE `gendiscount`
  MODIFY `gendis_ID` bigint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `itemlist`
--
ALTER TABLE `itemlist`
  MODIFY `pro_ID` bigint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `occdiscounts`
--
ALTER TABLE `occdiscounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `supplierlist`
--
ALTER TABLE `supplierlist`
  MODIFY `supp_ID` bigint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `userauth`
--
ALTER TABLE `userauth`
  MODIFY `user_ID` bigint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

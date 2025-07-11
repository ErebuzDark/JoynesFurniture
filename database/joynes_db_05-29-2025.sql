-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2025 at 05:52 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `joynes_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `addcart`
--

CREATE TABLE `addcart` (
  `ID` int(255) NOT NULL,
  `userID` bigint(255) NOT NULL,
  `prodName` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `cost` bigint(255) NOT NULL,
  `date` date NOT NULL,
  `width` decimal(10,2) DEFAULT NULL,
  `length` decimal(10,2) DEFAULT NULL,
  `height` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `addcartcustom`
--

CREATE TABLE `addcartcustom` (
  `ID` int(255) NOT NULL,
  `userID` int(255) NOT NULL,
  `prodName` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `cost` int(255) DEFAULT NULL,
  `date` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `addcustom`
--

CREATE TABLE `addcustom` (
  `orderID` int(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `cpNum` int(255) NOT NULL,
  `woodname` varchar(255) NOT NULL,
  `varnishname` varchar(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `cost` int(255) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `addtbl`
--

CREATE TABLE `addtbl` (
  `ID` bigint(255) NOT NULL,
  `prodName` varchar(128) NOT NULL,
  `image` varchar(255) NOT NULL,
  `quantity` bigint(255) NOT NULL,
  `cost` bigint(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addtbl`
--

INSERT INTO `addtbl` (`ID`, `prodName`, `image`, `quantity`, `cost`, `date`) VALUES
(133, 'Wardrobe Closet 004', 'wardrobe closet 04.jpg', 1, 8000, '2024-11-15'),
(133, 'Wardrobe Closet 004', 'wardrobe closet 04.jpg', 1, 8000, '2024-11-16');

-- --------------------------------------------------------

--
-- Table structure for table `archived`
--

CREATE TABLE `archived` (
  `ID` int(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `cost` int(255) NOT NULL,
  `date` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archived`
--

INSERT INTO `archived` (`ID`, `name`, `image`, `description`, `quantity`, `cost`, `date`) VALUES
(191, 'TV Stand 003', 'tv stand 003.jpg', 'Aesthetic Small TV Stand Cabinet with Elegant Design', 5, 6000, 2025),
(122, 'Corener Stand', '68284e020874f.jpg', 'TV Stand with Wide Open shelves and Two Small Cabinets', 5, 6000, 2025),
(192, 'Vision Console  ', '68280cbe325c2.jpg', 'Aesthetic Small TV Stand Cabinet with Elegant Design', 5, 6000, 2025),
(186, 'Viera Set ', '6827fe25bd9f6.jpg', ' Sleek and stylish, ideal for modern and minimalist homes', 0, 12500, 2025),
(185, 'Alaya Set', '6827fe3f20c96.jpg', 'Inviting and homey, designed for comfort and connection\r\n', 0, 10000, 2025),
(184, 'Eclipse Centerpiece ', 'Eclipse Centerpiece.jpg', 'Designed with simplicity and strength, this table fits seamlessly into any space or style.\"', 0, 3000, 2025),
(179, 'Bohemian Wooden', 'Bohemian Wooden Sala Set.jpg', 'L-shaped configuration provides ample seating and corner utility, Clean-lined, open-frame design with slatted or panel backrest', 0, 8000, 2025),
(183, 'Harmony Desk  ', '6827fc753b09e.jpg', 'A clean, modern piece crafted for everyday use—perfect for dining, working, or gathering.\"\r\n', 0, 4000, 2025),
(187, 'Storex Wardrobe Closet', 'wardrobe closet 01.jpg', 'Modern Wardrobe Closet with Hanging Section & Shelves', 0, 8000, 2024),
(170, 'Emberwood Console', 'wansbeck-tv-stand-28404-p.jpg', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos incidunt aut in dolorem ut quis suscipit veniam? Nisi incidunt et, veritatis delectus eius nobis distinctio placeat earum sapiente ut amet?', 0, 6000, 2025),
(167, 'Arcadia Table', '6827fed682054.jpg', ' timeless and elegant design, perfect for modern and classic interiors alike. With its sleek lines, sturdy construction, and smooth surface, this table blends functionality with aesthetic appeal.', 0, 5000, 2025),
(164, 'Ember Haven Set', 'Ember Haven Set.jpg', 'Its timeless appeal makes it ideal for gatherings, relaxation, or simply unwinding in a beautifully furnished home', 0, 30000, 2025),
(163, 'Ember Lounge', 'Ember Lounge.webp', 'A stylish wooden dining chair with a curved spindle back and a natural oak finish, blending Scandinavian and mid-century design.', 0, 2500, 2025),
(141, 'Aurora Vanity ', 'vanity mirror 04.jpg', 'Vanity Set with Circle Mirror, Drawers, and Cozy Chair', 0, 7000, 2024);

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE `checkout` (
  `orderID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `fID` varchar(50) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `prodName` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `cpNum` varchar(15) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL DEFAULT 'Pending Approval',
  `payment` varchar(255) NOT NULL DEFAULT 'No Payment',
  `balance` varchar(255) NOT NULL DEFAULT '0',
  `proofPay` varchar(255) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `variant` varchar(255) NOT NULL,
  `width` varchar(50) DEFAULT NULL,
  `length` varchar(50) DEFAULT NULL,
  `height` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checkout`
--

INSERT INTO `checkout` (`orderID`, `userID`, `image`, `fID`, `fullName`, `prodName`, `address`, `cpNum`, `cost`, `date`, `status`, `payment`, `balance`, `proofPay`, `quantity`, `variant`, `width`, `length`, `height`) VALUES
(1, 1, 'up/67499f08dd523.jpg, up/68286fcf78661.jpg', '169, 175', 'jerome bernante', 'Serenity Sleep , Corener TV Stand', 'malabon city', '09279892522', 13000.00, '2025-05-27 23:36:16', 'Completed', 'Full Payment', '0', 'up/qr_6835dbf0672ed8.39173509.png', 1, 'full', '53.00, 1.00', '75.00, 1.00', '63.00, 1.00');

-- --------------------------------------------------------

--
-- Table structure for table `checkoutcustom`
--

CREATE TABLE `checkoutcustom` (
  `orderID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `pName` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `prodDetails` varchar(255) NOT NULL,
  `totalCost` varchar(255) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `cpNum` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `variant` varchar(50) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL DEFAULT 'Pending Approval',
  `payment` varchar(255) NOT NULL DEFAULT 'No Payment',
  `balance` varchar(255) DEFAULT '0',
  `proofPay` varchar(255) NOT NULL,
  `width` varchar(50) DEFAULT NULL,
  `length` varchar(50) DEFAULT NULL,
  `height` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checkoutcustom`
--

INSERT INTO `checkoutcustom` (`orderID`, `userID`, `pName`, `image`, `prodDetails`, `totalCost`, `fullName`, `address`, `cpNum`, `quantity`, `variant`, `date`, `status`, `payment`, `balance`, `proofPay`, `width`, `length`, `height`) VALUES
(1, 1, 'cabinet ni jerome', './up/cabinet.png', 'L: 8.00 ft W: 8.00 ft H: 8.00 ft Wood: Accacia Varnish: Clear Varnish', '12250.00', 'jerome bernante', 'malabon city', '09279892522', '1', '', '2025-05-27 23:38:10', 'Pending Approval', 'Full Payment', '0', 'up/qr_6835dc621dfa67.89034507.png', '8.00', '8.00', '8.00');

-- --------------------------------------------------------

--
-- Table structure for table `customcheck`
--

CREATE TABLE `customcheck` (
  `orderID` int(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `cpNum` int(11) NOT NULL,
  `woodname` varchar(255) NOT NULL,
  `varnishname` varchar(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `cost` int(255) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `furnituretbl`
--

CREATE TABLE `furnituretbl` (
  `fID` bigint(20) NOT NULL,
  `fName` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `fDes` varchar(5000) NOT NULL,
  `fQuantity` int(11) NOT NULL,
  `cost` bigint(255) NOT NULL,
  `date` date NOT NULL,
  `width` decimal(10,2) DEFAULT NULL,
  `length` decimal(10,2) DEFAULT NULL,
  `height` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `furnituretbl`
--

INSERT INTO `furnituretbl` (`fID`, `fName`, `category`, `image`, `fDes`, `fQuantity`, `cost`, `date`, `width`, `length`, `height`) VALUES
(123, 'HomeBase Stand', 'tv', 'tv stand 02.jpg', 'TV Stand with Spacious Cabinet and Three Small Drawers', 20, 6000, '2024-11-07', 36.00, 16.00, 20.00),
(125, 'Horizon Media Unit', 'tv', 'tv stand 04.jpg', 'Stylish TV Stand with Open Shelves and Two Drawer Sides', 20, 6000, '2024-11-07', 36.00, 16.00, 20.00),
(128, 'Serenity Sleep ', 'bed', 'bed frame 03.jpg', 'Crafted from high-quality solid wood.', 20, 9000, '2024-11-07', 53.00, 75.00, 63.00),
(129, 'Tranquil Rest  ', 'bed', 'bed frame 04.jpg', 'Solid Wood Bed Frame with Elegant Headboard for Timeless Style', 20, 10000, '2024-11-07', 48.00, 75.00, 63.00),
(130, 'Storex Wardrobe Closet', 'cabinet', 'wardrobe closet 01.jpg', 'Modern Wardrobe Closet with Hanging Section & Shelves', 20, 8000, '2024-11-07', 60.00, 24.00, 80.00),
(131, 'Nuvu Wardrobe Closet', 'cabinet', 'wardrobe closet 02.jpg', 'Closed-door Wardrobe Closet with Hanging Section, Shelves ', 20, 12000, '2024-11-07', 55.00, 24.00, 80.00),
(132, 'Cabra Wardrobe Closet', 'cabinet', 'wardrobe closet 03.jpg', 'Closed-door wardrobe with Hanging Section, Shelves, and Drawers	', 20, 8000, '2024-11-07', 55.00, 24.00, 80.00),
(133, 'Stowa Wardrobe Closet', 'cabinet', 'wardrobe closet 04.jpg', 'Spacious Wardrobe for Maximum Storage', 20, 8000, '2024-11-07', 55.00, 24.00, 80.00),
(140, 'Celeste Dresser ', 'mirror', 'Vanity 1.jpg', 'Vanity Set with Wide Mirror, Drawers, and Comfortable Chair', 20, 8000, '2024-11-07', 20.00, 15.00, 28.00),
(159, 'Dreamscape Frame  ', 'bed', '67c5048c27244.jpg', 'Solid Wood Bed Frame with Slatted Design for Breathability and Style', 20, 13500, '2025-03-03', 48.00, 75.00, 63.00),
(160, 'Redwood Retreat', 'bed', '6827ff2278e9e.jpg', 'This is a wooden twin-over-full bunk bed with a rich brown finish, featuring a sturdy frame, safety rails on the top bunk, and an angled ladder for easy access.', 20, 15000, '2025-03-03', 53.00, 75.00, 63.00),
(165, 'Counter Stool', 'chair', 'Counter Stool.webp', 'A stylish and functional seating option, perfect for kitchen counters, bars, or high tables.', 20, 2000, '2025-03-04', 17.00, 17.00, 30.00),
(168, 'Belle Reflection', 'mirror', 'Belle Reflection.jpg', 'A modern wooden vanity table with a built-in flip-up mirror, multiple storage drawers, and a matching cushioned stool, offering both style and functionality for an organized beauty space.', 25, 6000, '2025-03-04', 20.00, 15.00, 28.00),
(169, 'Serenity Sleep ', 'bed', '67499f08dd523.jpg', 'This bed frame adds a touch of sophistication to your space', 30, 7000, '2025-03-12', 53.00, 75.00, 63.00),
(175, 'Corener TV Stand', 'tv', '68286fcf78661.jpg', 'Amole TV Stand Storage, Space-saving design', 30, 6000, '2025-03-18', 1.00, 1.00, 1.00);

-- --------------------------------------------------------

--
-- Table structure for table `official_receipts`
--

CREATE TABLE `official_receipts` (
  `OFC_ID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `orderID` int(11) NOT NULL,
  `payment_receipt_id` int(11) NOT NULL,
  `totalPaid` int(11) NOT NULL,
  `reference_number` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `official_receipts`
--

INSERT INTO `official_receipts` (`OFC_ID`, `userID`, `orderID`, `payment_receipt_id`, `totalPaid`, `reference_number`, `created_at`, `update_at`) VALUES
(1, 1, 1, 1, 13000, '1234567890008', '2025-05-27 23:36:35', '2025-05-27 23:36:35'),
(2, 1, 1, 2, 1000, '1234567890004', '2025-05-27 23:38:27', '2025-05-27 23:42:52'),
(3, 1, 1, 3, 11250, '1234567890007', '2025-05-27 23:44:23', '2025-05-27 23:44:23');

-- --------------------------------------------------------

--
-- Table structure for table `payment_receipts`
--

CREATE TABLE `payment_receipts` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `source` varchar(50) DEFAULT NULL,
  `productName` text DEFAULT NULL,
  `amountPaid` decimal(10,2) DEFAULT 0.00,
  `proofImage` varchar(255) DEFAULT NULL,
  `ref_no` varchar(100) DEFAULT NULL,
  `payment_status` enum('Pending','Confirmed','Invalid','Refunded') NOT NULL DEFAULT 'Pending',
  `paymentDate` datetime DEFAULT NULL,
  `orderID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_receipts`
--

INSERT INTO `payment_receipts` (`id`, `userID`, `source`, `productName`, `amountPaid`, `proofImage`, `ref_no`, `payment_status`, `paymentDate`, `orderID`) VALUES
(1, 1, 'checkout', 'Serenity Sleep , Corener TV Stand', 13000.00, 'up/qr_6835dbf0672ed8.39173509.png', '1234567890008', 'Confirmed', '2025-05-27 23:36:35', 1),
(2, 1, 'checkoutcustom', 'cabinet ni jerome', 1000.00, 'up/qr_6835dc621dfa67.89034507.png', '1234567890004', 'Confirmed', '2025-05-27 23:42:52', 1),
(3, 1, 'checkoutcustom', 'cabinet ni jerome', 11250.00, 'up/1748360587_6000 008.png', '1234567890007', 'Confirmed', '2025-05-27 23:44:23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rawmtbl`
--

CREATE TABLE `rawmtbl` (
  `pID` int(11) NOT NULL,
  `pName` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `pQuantity` int(11) NOT NULL,
  `pCost` int(255) NOT NULL,
  `pDes` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rawmtbl`
--

INSERT INTO `rawmtbl` (`pID`, `pName`, `image`, `pQuantity`, `pCost`, `pDes`, `date`) VALUES
(13, 'Accacia', 'Accacia.jpg', 416, 450, '', '2024-11-08'),
(14, 'Ash', 'Ash.jpg', 981, 450, 'sdasdasderff', '2024-10-04'),
(15, 'Cedar', 'Cedar.jpg', 994, 450, '', '2024-10-04'),
(16, 'Grandis', 'Grandis.jpg', 994, 450, '', '2024-10-04'),
(17, 'Pine', 'Pine.jpg', 996, 450, '', '2024-10-04'),
(18, 'Red Oak', 'Red Oak.jpg', 1000, 450, '', '2024-10-04'),
(19, 'Rose wood', 'Rose Wood.jpg', 997, 450, '', '2024-10-04'),
(20, 'Walnut', 'Walnut.jpg', 999, 450, '', '2024-10-04'),
(21, 'White Oak', 'White Oak.jpg', 1000, 450, '', '2024-10-04');

-- --------------------------------------------------------

--
-- Table structure for table `reviewtbl`
--

CREATE TABLE `reviewtbl` (
  `ID` int(255) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cartcus`
--

CREATE TABLE `tbl_cartcus` (
  `cart_id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `fName` varchar(255) NOT NULL,
  `vName` varchar(255) NOT NULL,
  `pName` varchar(255) NOT NULL,
  `width` decimal(10,2) NOT NULL,
  `length` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `totalCost` decimal(10,2) NOT NULL,
  `addDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `height` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usertbl`
--

CREATE TABLE `usertbl` (
  `ID` int(11) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cpNum` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usertbl`
--

INSERT INTO `usertbl` (`ID`, `fullName`, `address`, `email`, `cpNum`, `password`, `image`) VALUES
(1, 'jerome bernante', 'malabon city', 'jeromebernante@gmail.com', '09279892522', '$2y$10$3VRxm/Boh/x8WaEkiOajj.BmOmAwcyHvIjTd8YQppKv6.LF7t14Pi', NULL),
(3, 'Test', 'test', 'Testing@gmail.com', '09123456789', '$2y$10$mIxDZi.iz4uFqpYgRbYA2uuW7AH4L1WdfXnJMcBoGXG9TQMoweRs.', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `varnishtbl`
--

CREATE TABLE `varnishtbl` (
  `ID` int(255) NOT NULL,
  `vName` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `vQuantity` int(255) NOT NULL,
  `cost` int(255) NOT NULL,
  `vDes` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `varnishtbl`
--

INSERT INTO `varnishtbl` (`ID`, `vName`, `image`, `vQuantity`, `cost`, `vDes`, `date`) VALUES
(1, 'Clear Varnish', 'Clear Varnish.png', 958, 450, '', '2024-10-04'),
(2, 'Dark Oak', 'Dark oak.png', 978, 450, '', '2024-10-04'),
(3, 'Light Oak', 'Light Oak.png', 995, 400, '', '2024-10-04'),
(4, 'Mahogany', 'Mahogany.png', 996, 400, ' ', '2024-10-04'),
(5, 'Teak', 'TEAK.png', 997, 450, '', '2024-10-04'),
(6, 'Walnut', 'Walnut.png', 1000, 450, '', '2024-10-04'),
(7, 'Mahogany', 'Mahogany.png', 996, 450, '', '2024-10-04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addcart`
--
ALTER TABLE `addcart`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `addcartcustom`
--
ALTER TABLE `addcartcustom`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `addcustom`
--
ALTER TABLE `addcustom`
  ADD PRIMARY KEY (`orderID`);

--
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`orderID`);

--
-- Indexes for table `checkoutcustom`
--
ALTER TABLE `checkoutcustom`
  ADD PRIMARY KEY (`orderID`);

--
-- Indexes for table `customcheck`
--
ALTER TABLE `customcheck`
  ADD PRIMARY KEY (`orderID`);

--
-- Indexes for table `furnituretbl`
--
ALTER TABLE `furnituretbl`
  ADD PRIMARY KEY (`fID`);

--
-- Indexes for table `official_receipts`
--
ALTER TABLE `official_receipts`
  ADD PRIMARY KEY (`OFC_ID`);

--
-- Indexes for table `payment_receipts`
--
ALTER TABLE `payment_receipts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rawmtbl`
--
ALTER TABLE `rawmtbl`
  ADD PRIMARY KEY (`pID`);

--
-- Indexes for table `reviewtbl`
--
ALTER TABLE `reviewtbl`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_cartcus`
--
ALTER TABLE `tbl_cartcus`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `usertbl`
--
ALTER TABLE `usertbl`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `varnishtbl`
--
ALTER TABLE `varnishtbl`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addcartcustom`
--
ALTER TABLE `addcartcustom`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `addcustom`
--
ALTER TABLE `addcustom`
  MODIFY `orderID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `checkoutcustom`
--
ALTER TABLE `checkoutcustom`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customcheck`
--
ALTER TABLE `customcheck`
  MODIFY `orderID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `furnituretbl`
--
ALTER TABLE `furnituretbl`
  MODIFY `fID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT for table `official_receipts`
--
ALTER TABLE `official_receipts`
  MODIFY `OFC_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment_receipts`
--
ALTER TABLE `payment_receipts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rawmtbl`
--
ALTER TABLE `rawmtbl`
  MODIFY `pID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `reviewtbl`
--
ALTER TABLE `reviewtbl`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_cartcus`
--
ALTER TABLE `tbl_cartcus`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `usertbl`
--
ALTER TABLE `usertbl`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `varnishtbl`
--
ALTER TABLE `varnishtbl`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

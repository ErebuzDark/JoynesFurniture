-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2025 at 05:23 PM
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

--
-- Dumping data for table `addcart`
--

INSERT INTO `addcart` (`ID`, `userID`, `prodName`, `image`, `quantity`, `cost`, `date`, `width`, `length`, `height`) VALUES
(130, 1, 'Storex Wardrobe Closet', 'wardrobe closet 01.jpg', 1, 8000, '2025-05-27', 60.00, 24.00, 80.00);

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
(123, 'HomeBase Stand', 'tv', 'tv stand 02.jpg', 'TV Stand with Spacious Cabinet and Three Small Drawers', 3, 6000, '2024-11-07', 36.00, 16.00, 20.00),
(125, 'Horizon Media Unit', 'tv', 'tv stand 04.jpg', 'Stylish TV Stand with Open Shelves and Two Drawer Sides', 3, 6000, '2024-11-07', 36.00, 16.00, 20.00),
(128, 'Serenity Sleep ', 'bed', 'bed frame 03.jpg', 'Crafted from high-quality solid wood.', 3, 9000, '2024-11-07', 53.00, 75.00, 63.00),
(129, 'Tranquil Rest  \r\n', 'bed', 'bed frame 04.jpg', 'Solid Wood Bed Frame with Elegant Headboard for Timeless Style', 3, 10000, '2024-11-07', 48.00, 75.00, 63.00),
(130, 'Storex Wardrobe Closet', 'cabinet', 'wardrobe closet 01.jpg', 'Modern Wardrobe Closet with Hanging Section & Shelves', 10, 8000, '2024-11-07', 60.00, 24.00, 80.00),
(131, 'Nuvu Wardrobe Closet', 'cabinet', 'wardrobe closet 02.jpg', 'Closed-door Wardrobe Closet with Hanging Section, Shelves ', 3, 12000, '2024-11-07', 55.00, 24.00, 80.00),
(132, 'Cabra Wardrobe Closet', 'cabinet', 'wardrobe closet 03.jpg', 'Closed-door wardrobe with Hanging Section, Shelves, and Drawers	', 2, 8000, '2024-11-07', 55.00, 24.00, 80.00),
(133, 'Stowa Wardrobe Closet', 'cabinet', 'wardrobe closet 04.jpg', 'Spacious Wardrobe for Maximum Storage', 3, 10000, '2024-11-07', 55.00, 24.00, 80.00),
(140, 'Celeste Dresser ', 'mirror', 'Vanity 1.jpg', 'Vanity Set with Wide Mirror, Drawers, and Comfortable Chair', 3, 8000, '2024-11-07', 20.00, 15.00, 28.00),
(159, 'Dreamscape Frame  ', 'bed', '67c5048c27244.jpg', 'Solid Wood Bed Frame with Slatted Design for Breathability and Style', 3, 13500, '2025-03-03', 48.00, 75.00, 63.00),
(160, 'Redwood Retreat', 'bed', '6827ff2278e9e.jpg', 'This is a wooden twin-over-full bunk bed with a rich brown finish, featuring a sturdy frame, safety rails on the top bunk, and an angled ladder for easy access.', 3, 15000, '2025-03-03', 53.00, 75.00, 63.00),
(165, 'Counter Stool', 'chair', 'Counter Stool.webp', 'A stylish and functional seating option, perfect for kitchen counters, bars, or high tables.', 3, 2000, '2025-03-04', 17.00, 17.00, 30.00),
(168, 'Belle Reflection', 'mirror', 'Belle Reflection.jpg', 'A modern wooden vanity table with a built-in flip-up mirror, multiple storage drawers, and a matching cushioned stool, offering both style and functionality for an organized beauty space.', -1, 6000, '2025-03-04', 20.00, 15.00, 28.00),
(169, 'Serenity Sleep ', 'bed', '67499f08dd523.jpg', 'This bed frame adds a touch of sophistication to your space', -1, 7000, '2025-03-12', 53.00, 75.00, 63.00),
(175, 'Corener TV Stand', 'tv', '68286fcf78661.jpg', 'Amole TV Stand Storage, Space-saving design', -1, 6000, '2025-03-18', 1.00, 1.00, 1.00);

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
(1, 1, 'checkout', NULL, 8000.00, 'up/qr_6834409a8cab69.01282001.png', '1234567890008', 'Confirmed', '2025-05-26 20:16:21', 1),
(2, 1, 'checkoutcustom', 'cabinet ni jerome', 1000.00, 'up/qr_6834562ecaeb23.15886839.png', '1234567890004', 'Confirmed', '2025-05-26 20:36:41', 1),
(3, 1, 'checkoutcustom', 'cabinet ni jerome', 5000.00, 'up/1748261894_5000 005.png', '1234567890005', 'Confirmed', '2025-05-26 20:28:25', 1),
(4, 1, 'checkoutcustom', 'cabinet ni jerome', 3000.00, 'up/1748262551_3000 006.png', '1234567890006', 'Confirmed', '2025-05-26 20:29:34', 1),
(5, 1, 'checkoutcustom', 'cabinet ni jerome', 3250.00, 'up/1748262899_3250 007.png', '1234567890007', 'Confirmed', '2025-05-26 20:35:24', 1),
(6, 1, 'checkout', NULL, 6000.00, 'up/qr_683460a1a9c998.50385745.png', '1234567890008', 'Confirmed', '2025-05-26 20:38:33', 2),
(7, 2, 'checkout', 'Storex Wardrobe Closet', 8000.00, 'up/qr_68359451ca6f43.62870526.png', '1234567890009', 'Pending', '2025-05-27 18:31:30', 3),
(8, 2, 'checkout', NULL, 20000.00, 'up/qr_68359d02446751.58826059.png', '1234567890010', 'Confirmed', '2025-05-27 19:08:09', 4),
(9, 2, 'checkout', NULL, NULL, 'up/qr_68359de44d2463.88936406.png', NULL, 'Pending', '2025-05-27 13:11:32', 5),
(10, 3, 'checkoutcustom', 'test', 0.00, 'up/qr_68359fbf9fbf95.68015412.png', NULL, 'Pending', '2025-05-27 13:19:27', 2),
(11, 3, 'checkoutcustom', 'test', 5000.00, 'up/qr_6835a039ef8c65.11323089.png', '1234567890011', 'Confirmed', '2025-05-27 19:22:44', 3),
(12, 3, 'checkout', 'Storex Wardrobe Closet', 8000.00, 'up/qr_6835a0526b1c96.76852258.png', '1234567890015', 'Confirmed', '2025-05-27 19:28:35', 6),
(13, 3, 'checkoutcustom', 'test', 5000.00, 'up/1748344928_invoice0 (1).png', '1234567890016', 'Confirmed', '2025-05-27 19:32:10', 3),
(14, 3, 'checkoutcustom', 'test', 5000.00, 'up/1748345701_invoice0 (1).png', '1234567890017', 'Confirmed', '2025-05-27 19:36:19', 3),
(15, 3, 'checkout', 'Emberwood Console', 6000.00, 'up/qr_6835a3c60fcda0.27858033.png', '1234567890019', 'Confirmed', '2025-05-27 19:38:27', 7),
(16, 3, 'checkoutcustom', 'test', 500.00, 'up/1748346352_invoice0 (1).png', '1234567890022', 'Confirmed', '2025-05-27 19:46:17', 3),
(17, 3, 'checkout', NULL, 26000.00, 'up/qr_6835ac143d06e9.94247063.png', '1234567890216', 'Confirmed', '2025-05-27 20:18:49', 8),
(18, 3, 'checkout', NULL, 21000.00, 'up/qr_6835aef1553601.02939829.png', '', 'Confirmed', '2025-05-27 20:24:42', 9),
(19, 3, 'checkout', NULL, 42000.00, 'up/qr_6835af4c4bffa2.37811839.png', '1234567891016', 'Confirmed', '2025-05-27 20:26:20', 10),
(20, 3, 'checkout', NULL, 66000.00, 'up/qr_6835b37779c5d9.55443820.png', '1234567891216', 'Confirmed', '2025-05-27 20:48:04', 11),
(21, 3, 'checkout', NULL, NULL, 'up/qr_6835b5865844f3.52380533.png', NULL, 'Pending', '2025-05-27 14:52:22', 12),
(22, 3, 'checkout', NULL, NULL, 'up/qr_6835b68f2ed9d7.89723688.jpg', NULL, 'Pending', '2025-05-27 14:56:47', 13),
(23, 3, 'checkout', NULL, NULL, 'up/qr_6835b6eba8ae50.55358073.jpg', NULL, 'Pending', '2025-05-27 14:58:19', 14),
(24, 3, 'checkout', NULL, NULL, 'up/qr_6835b6eece51c3.63244966.jpg', NULL, 'Pending', '2025-05-27 14:58:22', 15),
(25, 3, 'checkout', 'Aurora Vanity , Ember Lounge, Counter Stool', 18500.00, 'up/qr_6835b777080bc4.82573910.jpg', '123456782016', 'Confirmed', '2025-05-27 21:01:05', 16),
(26, 3, 'checkout', 'Storex Wardrobe Closet', 8000.00, 'up/qr_6835b828ef32e1.68431100.png', '12345678016', 'Confirmed', '2025-05-27 21:19:43', 17),
(27, 3, 'checkout', 'Corener TV Stand', 6000.00, 'up/qr_6835bc00a87836.91622069.jpg', '5', 'Refunded', '2025-05-27 21:35:29', 18),
(28, 3, 'checkout', 'Counter Stool, Corener TV Stand', 16000.00, 'up/qr_6835ce69e9af58.77145595.png', '6', 'Pending', '2025-05-27 22:39:14', 19),
(29, 3, 'checkout', 'Ember Lounge', 15000.00, 'up/qr_6835cf35021477.25526262.png', NULL, 'Pending', '2025-05-27 16:41:57', 20),
(30, 3, 'checkout', 'HomeBase Stand, Ember Lounge', 19500.00, 'up/qr_6835cf4d3e5065.57682407.png', NULL, 'Pending', '2025-05-27 16:42:21', 21),
(31, 3, 'checkout', 'Horizon Media Unit, Counter Stool', 20000.00, 'up/qr_6835d0704410e3.63608034.png', NULL, 'Pending', '2025-05-27 16:47:12', 22),
(32, 3, 'checkoutcustom', 'test', 5000.00, 'up/qr_6835d1df4dbae0.51517384.png', '11', 'Confirmed', '2025-05-27 22:53:43', 4),
(33, 3, 'checkoutcustom', 'tete', 300.00, 'up/qr_6835d245d43529.46061646.png', '111', 'Confirmed', '2025-05-27 22:55:20', 5),
(34, 3, 'checkoutcustom', 'tete', 350.00, 'up/1748357739_invoice0 (1).png', '166', 'Confirmed', '2025-05-27 22:55:56', 5);

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
(13, 'Accacia', 'Accacia.jpg', 417, 450, '', '2024-11-08'),
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
(1, 'Clear Varnish', 'Clear Varnish.png', 959, 450, '', '2024-10-04'),
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
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `checkoutcustom`
--
ALTER TABLE `checkoutcustom`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `OFC_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_receipts`
--
ALTER TABLE `payment_receipts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

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
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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

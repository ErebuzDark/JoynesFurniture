-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2025 at 12:39 AM
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
(167, 46, 'Arcadia Table', '67c653500d00d.jpg', 1, 7000, '2025-05-16', 1.00, 1.00, 1.00),
(168, 46, 'Belle Reflection', 'Belle Reflection.jpg', 1, 8000, '2025-05-16', 1.00, 1.00, 1.00),
(169, 46, 'Bed frame 002', '67499f08dd523.jpg', 1, 7000, '2025-05-16', 1.00, 1.00, 1.00);

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
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL DEFAULT 'Pending Approval',
  `payment` varchar(255) NOT NULL DEFAULT 'No Payment',
  `balance` varchar(255) NOT NULL DEFAULT '0',
  `proofPay` varchar(255) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `width` varchar(50) DEFAULT NULL,
  `length` varchar(50) DEFAULT NULL,
  `height` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checkout`
--

INSERT INTO `checkout` (`orderID`, `userID`, `image`, `fID`, `fullName`, `prodName`, `address`, `cpNum`, `cost`, `date`, `status`, `payment`, `balance`, `proofPay`, `quantity`, `width`, `length`, `height`) VALUES
(1, 46, 'up/qr_67e747d9e9cb49.81268247.jpg', '177', 'Ramon Rodriguez', 'test2', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 500.00, '2025-03-29', 'Delivered', 'Full Payment', '0', 'up/qr_67e747d9e9cb49.81268247.jpg', 1, NULL, NULL, NULL),
(2, 46, 'up/qr_67e748424bf712.82787720.jpg', '175', 'Ramon Rodriguez', 'Testing 2', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 500.00, '2025-03-29', 'Delivered', 'Full Payment', '0', 'up/qr_67e748424bf712.82787720.jpg', 1, NULL, NULL, NULL),
(4, 46, 'up/$_57.jfif', '175', 'Ramon Rodriguez', 'Testing 2', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 500.00, '2025-03-29', 'Delivered', 'Full Payment', '0', 'up/qr_67e74cf639adc6.03737103.jpg', 1, NULL, NULL, NULL),
(5, 46, 'up/$_57.jfif', '175', 'Ramon Rodriguez', 'Testing 2', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 500.00, '2025-03-29', 'Delivered', 'Full Payment', '0', 'up/qr_67e74d21b7f6f5.06545728.jpg', 1, NULL, NULL, NULL),
(6, 46, 'up/$_57.jfif', '175', 'Ramon Rodriguez', 'Testing 2', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 500.00, '2025-03-29', 'Delivered', 'Full Payment', '0', 'up/qr_67e74d75e2e559.73262246.jpg', 1, NULL, NULL, NULL),
(7, 46, 'up/$_57.jfif', '175', 'Ramon Rodriguez', 'Testing 2', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 500.00, '2025-03-29', 'Delivered', 'Full Payment', '0', 'up/qr_67e74d96dce4d2.51163910.jpg', 1, NULL, NULL, NULL),
(8, 46, 'up/$_57.jfif', '175', 'Ramon Rodriguez', 'Testing 2', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 500.00, '2025-03-29', 'Delivered', 'Full Payment', '0', 'up/qr_67e74db471dd25.89737845.jpg', 1, NULL, NULL, NULL),
(9, 46, 'up/$_57.jfif', '175', 'Ramon Rodriguez', 'Testing 2', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 500.00, '2025-03-29', 'Delivered', 'Full Payment', '0', 'up/qr_67e74dd2b2b613.32492671.jpg', 1, NULL, NULL, NULL),
(10, 46, 'up/$_57.jfif', '175', 'Ramon Rodriguez', 'Testing 2', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 500.00, '2025-03-29', 'Delivered', 'Full Payment', '0', 'up/qr_67e74e044ad9a4.78635176.jpg', 1, NULL, NULL, NULL),
(11, 46, 'up/$_57.jfif', '175', 'Ramon Rodriguez', 'Testing 2', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 500.00, '2025-03-29', 'Delivered', 'Full Payment', '0', 'up/qr_67e74e22e5c0b5.45587926.jpg', 1, NULL, NULL, NULL),
(12, 46, 'up/$_57.jfif', '175', 'Ramon Rodriguez', 'Testing 2', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 500.00, '2025-03-29', 'Delivered', 'Full Payment', '0', 'up/qr_67e74e6436d6a2.14886964.jpg', 1, NULL, NULL, NULL),
(13, 46, 'up/tv stand 01.jpg, up/$_57.jfif', '122, 175', 'Ramon Rodriguez', 'TV Stand 001, Testing 2', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 6500.00, '2025-03-31', 'Delivered', 'Full Payment', '0', 'up/qr_67ea0008244a09.97052625.jpg', 1, NULL, NULL, NULL),
(14, 46, 'up/tv stand 01.jpg, up/wansbeck-tv-stand-28404-p.jpg, up/$_57.jfif', '122, 170, 175', 'Ramon Rodriguez', 'TV Stand 001, TV Stand 005, Testing 2', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 9000.00, '2025-03-31', 'Delivered', 'Full Payment', '0', 'up/qr_67ea039b1d6055.82239130.jpg', 1, NULL, NULL, NULL),
(15, 46, 'up/67da213a16b3d.jpg', '177', 'Ramon Rodriguez', 'test2', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 500.00, '2025-04-29', 'Delivered', 'Full Payment', '0', 'up/qr_6810649c3cff89.62415336.jpg', 1, NULL, NULL, NULL),
(16, 46, 'up/wansbeck-tv-stand-28404-p.jpg', '170', 'Ramon Rodriguez', 'TV Stand 005', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 2000.00, '2025-04-29', 'Delivered', 'Full Payment', '0', 'up/qr_681064eb30f466.36767230.jpg', 1, NULL, NULL, NULL),
(18, 46, 'up/67da213a16b3d.jpg', '177', 'Ramon Rodriguez', 'test2', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 500.00, '2025-04-29', 'Delivered', 'Full Payment', '0', 'up/qr_681071cc812a29.17199973.', 1, NULL, NULL, NULL),
(19, 46, 'up/67da213a16b3d.jpg', '177', 'Ramon Rodriguez', 'test2', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 500.00, '2025-04-29', 'Delivered', 'Full Payment', '0', 'up/qr_681071d0a90c33.17306002.', 1, NULL, NULL, NULL),
(20, 46, 'up/67da213a16b3d.jpg', '177', 'Ramon Rodriguez', 'test2', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 500.00, '2025-04-29', 'Delivered', 'Full Payment', '0', 'up/qr_681071d549c7a7.44989135.', 1, NULL, NULL, NULL),
(21, 46, 'up/67da213a16b3d.jpg', '177', 'Ramon Rodriguez', 'test2', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 500.00, '2025-04-29', 'Delivered', 'Full Payment', '0', 'up/qr_681071d9a5da73.62721326.', 1, NULL, NULL, NULL),
(22, 46, 'up/67da213a16b3d.jpg', '177', 'Ramon Rodriguez', 'test2', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 500.00, '2025-04-29', 'Delivered', 'Full Payment', '0', 'up/qr_681071de667762.98954894.', 1, NULL, NULL, NULL),
(23, 46, 'up/67da213a16b3d.jpg', '177', 'Ramon Rodriguez', 'test2', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 500.00, '2025-04-29', 'Delivered', 'Full Payment', '0', 'up/qr_681072a4499715.30465020.', 1, NULL, NULL, NULL),
(24, 46, 'up/67da213a16b3d.jpg', '177', 'Ramon Rodriguez', 'test2', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 500.00, '2025-04-29', 'Delivered', 'Full Payment', '0', 'up/qr_681072ac1a3c06.63470169.', 1, NULL, NULL, NULL),
(25, 46, 'up/67da213a16b3d.jpg', '177', 'Ramon Rodriguez', 'test2', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 500.00, '2025-04-29', 'Delivered', 'Full Payment', '0', 'up/qr_681072e208bcb6.13100014.', 1, NULL, NULL, NULL),
(26, 46, 'up/67da213a16b3d.jpg', '177', 'Ramon Rodriguez', 'test2', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 500.00, '2025-05-01', 'Delivered', 'Full Payment', '0', 'up/qr_6812c9bd91af40.61130578.', 1, NULL, NULL, NULL),
(28, 46, 'up/tv stand 01.jpg', '122', 'Ramon Rodriguez', 'TV Stand 001', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 6000.00, '2025-05-02', 'Delivered', 'Full Payment', '0', 'up/qr_68146dcbdd4444.84149499.jpg', 1, NULL, NULL, NULL),
(30, 46, 'up/Ember Lounge.webp', '163', 'Ramon Rodriguez', 'Ember Lounge', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 2500.00, '2025-05-02', 'Delivered', 'Full Payment', '0', 'up/qr_681495ef9e0061.12429705.jpg', 1, NULL, NULL, NULL),
(31, 46, 'up/vanity mirror 03.jpg', '140', 'Ramon Rodriguez', 'Vanity Mirror 003', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 15000.00, '2025-05-02', 'Delivered', 'Full Payment', '0', 'up/qr_681498020f2c64.74720076.jpg', 3, NULL, NULL, NULL),
(32, 46, 'up/wardrobe closet 02.jpg', '131', 'Ramon Rodriguez', 'Wardrobe Closet 002', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 8000.00, '2025-05-02', 'Delivered', 'Full Payment', '0', 'up/qr_68149c111ed9b9.09366763.jpg', 1, NULL, NULL, NULL),
(33, 46, 'up/wardrobe closet 01.jpg, up/wardrobe closet 03.jpg', '130, 132', 'Ramon Rodriguez', 'Wardrobe Closet 001, Wardrobe Closet 003', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 24000.00, '2025-05-02', 'Delivered', 'Full Payment', '0', 'up/qr_68149c51468647.01139591.jpg', 1, NULL, NULL, NULL),
(34, 46, 'up/$_57.jfif', '175', 'Ramon Rodriguez', 'Testing 2', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 2500.00, '2025-05-02', 'Delivered', 'Full Payment', '0', 'up/qr_6814a006bb8946.17610429.jpg', 5, NULL, NULL, NULL),
(35, 46, 'up/Ember Lounge.webp', '163', 'Ramon Rodriguez', 'Ember Lounge', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 2500.00, '2025-05-03', 'Delivered', 'Full Payment', '0', 'up/qr_6815618dacde36.97149440.jpg', 1, NULL, NULL, NULL),
(36, 46, 'up/67499f08dd523.jpg', '169', 'Ramon Rodriguez', 'Bed frame 002', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 7000.00, '2025-05-03', 'Delivered', 'Full Payment', '0', 'up/qr_6815620c3f0ee5.54736546.jpg', 1, NULL, NULL, NULL),
(37, 46, 'up/67499f08dd523.jpg', '169', 'Ramon Rodriguez', 'Bed frame 002', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 7000.00, '2025-05-03', 'Delivered', 'Full Payment', '0', 'up/qr_6815647f1e9564.25186367.jpg', 1, NULL, NULL, NULL),
(38, 46, 'up/67499f08dd523.jpg', '169', 'Ramon Rodriguez', 'Bed frame 002', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 14000.00, '2025-05-03', 'Completed', 'Full Payment', '0', 'up/qr_68156f4a09dbd2.22566745.jpg', 2, NULL, NULL, NULL),
(47, 46, 'up/$_57.jfif', '175', 'Ramon Rodriguez', 'Testing 2', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 500.00, '2025-05-15', 'On Queue', 'No Payment', '0', 'up/qr_68260d9aa375f7.53081926.png', 1, '1.00', '1.00', '1.00'),
(48, 46, 'up/Belle Reflection.jpg', '168', 'Ramon Rodriguez', 'Belle Reflection', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 8000.00, '2025-05-15', 'On Queue', 'No Payment', '0', 'up/qr_68260f2c1e7b14.83930943.png', 1, '1.00', '1.00', '1.00'),
(49, 46, 'up/tv stand 003.jpg', '162', 'Ramon Rodriguez', 'TV Stand 003', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', 6000.00, '2025-05-17', 'In Progress', 'Full Payment', '6000', 'up/qr_6827bd9da6b7b5.99408066.png', 1, '1.00', '1.00', '1.00');

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
  `date` date NOT NULL DEFAULT current_timestamp(),
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

INSERT INTO `checkoutcustom` (`orderID`, `userID`, `pName`, `image`, `prodDetails`, `totalCost`, `fullName`, `address`, `cpNum`, `quantity`, `date`, `status`, `payment`, `balance`, `proofPay`, `width`, `length`, `height`) VALUES
(41, 46, 'Ramon Raigor Rodriguez', 'up/pa.jpg', 'L: 2m W: 1m Wood: Red Oak Varnish: Walnut', '2000', 'Ramon Rodriguez', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', '1', '2025-05-02', 'Delivered', 'Full Payment', '0', 'up/qr_681470b1db3893.18410350.jpg', NULL, NULL, NULL),
(44, 46, 'test2, Ramon Raigor Rodriguez, test2', './up/67da213a16b3d.jpg, ./up/pa.jpg, ./up/67da213a16b3d.jpg', 'L: 1.00 m W: 1.00 m Wood: Accacia Varnish: Clear Varnish, L: 2.00 m W: 1.00 m Wood: Pine Varnish: Teak, L: 1.00 m W: 1.00 m Wood: Pine Varnish: Teak', '11000.00', 'Ramon Rodriguez', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', '1, 2, 3', '2025-05-02', 'Delivered', 'Full Payment', '0', 'up/qr_68149b78d103a5.55478475.jpg', NULL, NULL, NULL),
(53, 46, 'Wood Table Modern, TV Stand 005', './up/DFD Proposal Level 2 Part 2.drawio.png, ./up/wansbeck-tv-stand-28404-p.jpg', 'L: 1.00 ft W: 1.00 ft H: 1.00 ft Wood: Accacia Varnish: Clear Varnish, L: 1.00 ft W: 1.00 ft H: 1.00 ft Wood: Accacia Varnish: Clear Varnish', '5050.00', 'Ramon Rodriguez', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', '1, 1', '2025-05-15', 'On Queue', 'Full Payment', '0', 'up/qr_68260d742f36f5.33739321.png', '1.00, 1.00', '1.00, 1.00', '1.00, 1.00'),
(56, 46, 'Wood Table Modern', 'up/b61a2641-158b-4fa8-bad3-f4389687500b.jfif', 'L: 1ft W: 1ft H: 1ft Wood: Accacia Varnish: Clear Varnish', '2000', 'Ramon Rodriguez', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', '09515949774', '1', '2025-05-16', 'Completed', 'Full Payment', '0', 'up/qr_68273c5d4c44c5.66218009.jfif', '1', '1', '1');

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

--
-- Dumping data for table `customcheck`
--

INSERT INTO `customcheck` (`orderID`, `image`, `fullName`, `address`, `cpNum`, `woodname`, `varnishname`, `quantity`, `cost`, `date`, `status`) VALUES
(57, 'work desk.png', 'loreto', '123', 123, 'White Oak', 'Mahogany', 0, 450, '2024-11-07', 'On Queue'),
(58, '2.jpg', '', '', 0, '', 'Light Oak', 1, 900, '2024-11-17', 'On Queue'),
(59, 'k.jpg', '', '', 0, '', 'Mahogany', 1, 900, '2024-11-17', 'On Queue'),
(60, '2.jpg', 'loreto', '123', 123, '', 'Light Oak', 1, 900, '2024-11-17', 'On Queue'),
(61, '2.jpg', 'loreto', '123', 123, '', 'Dark Oak', 1, 900, '2024-11-17', 'On Queue'),
(62, '2.jpg', 'loreto', '123', 123, '', 'Mahogany', 1, 900, '2024-11-17', 'On Queue'),
(63, 'k.jpg', 'loreto', '123', 123, '', 'Light Oak', 1, 900, '2024-11-17', 'On Queue'),
(64, 'k.jpg', 'loreto', '123', 123, '', 'Light Oak', 1, 900, '2024-11-17', 'On Queue'),
(65, 'k.jpg', 'loreto', '123', 123, 'Cedar', 'Dark Oak', 1, 900, '2024-11-17', 'On Queue');

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
(122, 'TV Stand 001', 'tv', 'tv stand 01.jpg', 'TV Stand with Wide Open shelves and Two Small Cabinets', 7, 6000, '2024-11-07', 1.00, 1.00, 1.00),
(123, 'TV Stand 002', 'tv', 'tv stand 02.jpg', 'TV Stand with Spacious Cabinet and Three Small Drawers', 8, 6000, '2024-11-07', 1.00, 1.00, 1.00),
(125, 'TV Stand 004', 'tv', 'tv stand 04.jpg', 'Stylish TV Stand with Open Shelves and Two Drawer Sides', 7, 6000, '2024-11-07', 1.00, 1.00, 1.00),
(128, 'Bed frame 003', 'bed', 'bed frame 03.jpg', 'Crafted from high-quality solid wood.', 10, 7000, '2024-11-07', 1.00, 1.00, 1.00),
(129, 'Bed frame 004', 'bed', 'bed frame 04.jpg', 'Solid Wood Bed Frame with Elegant Headboard for Timeless Style', 10, 7000, '2024-11-07', 1.00, 1.00, 1.00),
(130, 'Wardrobe Closet 001', 'cabinet', 'wardrobe closet 01.jpg', 'Modern Wardrobe Closet with Hanging Section & Shelves', 9, 8000, '2024-11-07', 1.00, 1.00, 1.00),
(131, 'Wardrobe Closet 002', 'cabinet', 'wardrobe closet 02.jpg', 'Closed-door Wardrobe Closet with Hanging Section, Shelves ', 8, 8000, '2024-11-07', 1.00, 1.00, 1.00),
(132, 'Wardrobe Closet 003', 'cabinet', 'wardrobe closet 03.jpg', 'Closed-door wardrobe with Hanging Section, Shelves, and Drawers	', 9, 8000, '2024-11-07', 1.00, 1.00, 1.00),
(133, 'Wardrobe Closet 004', 'cabinet', 'wardrobe closet 04.jpg', 'Spacious Wardrobe for Maximum Storage', 10, 8000, '2024-11-07', 1.00, 1.00, 1.00),
(140, 'Vanity Mirror 003', 'mirror', 'vanity mirror 03.jpg', 'Vanity Set with Wide Mirror, Drawers, and Comfortable Chair', 7, 5000, '2024-11-07', 1.00, 1.00, 1.00),
(141, 'Vanity Mirror 004', 'mirror', 'vanity mirror 04.jpg', 'Vanity Set with Circle Mirror, Drawers, and Cozy Chair', 10, 5000, '2024-11-07', 1.00, 1.00, 1.00),
(159, 'Dreamscape Frame  ', 'bed', '67c5048c27244.jpg', 'Solid Wood Bed Frame with Slatted Design for Breathability and Style', 10, 17000, '2025-03-03', 1.00, 1.00, 1.00),
(160, 'Redwood Retreat', 'bed', '67c50449b2339.jpg', 'This is a wooden twin-over-full bunk bed with a rich brown finish, featuring a sturdy frame, safety rails on the top bunk, and an angled ladder for easy access.', 10, 10000, '2025-03-03', 1.00, 1.00, 1.00),
(162, 'TV Stand 003', '', 'tv stand 003.jpg', 'Aesthetic Small TV Stand Cabinet with Elegant Design', 9, 6000, '2025-03-03', 1.00, 1.00, 1.00),
(163, 'Ember Lounge', 'chair', 'Ember Lounge.webp', 'A stylish wooden dining chair with a curved spindle back and a natural oak finish, blending Scandinavian and mid-century design.', 7, 2500, '2025-03-03', 1.00, 1.00, 1.00),
(164, 'Ember Haven Set', 'sala', 'Ember Haven Set.jpg', 'Its timeless appeal makes it ideal for gatherings, relaxation, or simply unwinding in a beautifully furnished home', 5, 30000, '2025-03-04', 1.00, 1.00, 1.00),
(165, 'Counter Stool', 'chair', 'Counter Stool.webp', 'A stylish and functional seating option, perfect for kitchen counters, bars, or high tables.', 5, 6000, '2025-03-04', 1.00, 1.00, 1.00),
(167, 'Arcadia Table', 'table', '67c653500d00d.jpg', ' timeless and elegant design, perfect for modern and classic interiors alike. With its sleek lines, sturdy construction, and smooth surface, this table blends functionality with aesthetic appeal.', 10, 7000, '2025-03-04', 1.00, 1.00, 1.00),
(168, 'Belle Reflection', 'mirror', 'Belle Reflection.jpg', 'A modern wooden vanity table with a built-in flip-up mirror, multiple storage drawers, and a matching cushioned stool, offering both style and functionality for an organized beauty space.', 4, 8000, '2025-03-04', 1.00, 1.00, 1.00),
(169, 'Bed frame 002', '', '67499f08dd523.jpg', 'This bed frame adds a touch of sophistication to your space', 5, 7000, '2025-03-12', 1.00, 1.00, 1.00),
(170, 'TV Stand 005', 'tv', 'wansbeck-tv-stand-28404-p.jpg', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos incidunt aut in dolorem ut quis suscipit veniam? Nisi incidunt et, veritatis delectus eius nobis distinctio placeat earum sapiente ut amet?', 49, 2000, '2025-03-14', 1.00, 1.00, 1.00),
(175, 'Testing 2', '', '$_57.jfif', 'Testing 1', 473, 500, '2025-03-18', 1.00, 1.00, 1.00),
(179, 'test2', 'table', '67da213a16b3d.jpg', 'test2', 28, 500, '2025-05-03', 1.00, 1.00, 1.00);

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
(13, 'Accacia', 'Accacia.jpg', 425, 450, '', '2024-11-08'),
(14, 'Ash', 'Ash.jpg', 998, 450, 'sdasdasderff', '2024-10-04'),
(15, 'Cedar', 'Cedar.jpg', 999, 450, '', '2024-10-04'),
(16, 'Grandis', 'Grandis.jpg', 999, 450, '', '2024-10-04'),
(17, 'Pine', 'Pine.jpg', 997, 450, '', '2024-10-04'),
(18, 'Red Oak', 'Red Oak.jpg', 1000, 450, '', '2024-10-04'),
(19, 'Rose wood', 'Rose Wood.jpg', 1000, 450, '', '2024-10-04'),
(20, 'Walnut', 'Walnut.jpg', 1000, 450, '', '2024-10-04'),
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

--
-- Dumping data for table `tbl_cartcus`
--

INSERT INTO `tbl_cartcus` (`cart_id`, `userID`, `fName`, `vName`, `pName`, `width`, `length`, `quantity`, `image`, `cost`, `totalCost`, `addDate`, `height`) VALUES
(25, 43, 'Bed frame 002', 'Dark Oak', 'Grandis', 1.00, 1.00, 1, '67499f08dd523.jpg', 1800.00, 1800.00, '2024-12-06 11:52:08', NULL),
(51, 46, 'test2', 'Light Oak', 'Cedar', 1.00, 1.00, 1, '67da213a16b3d.jpg', 1750.00, 1750.00, '2025-05-02 12:28:54', NULL),
(52, 46, 'test2', 'Clear Varnish', 'Accacia', 1.00, 1.00, 4, '67da213a16b3d.jpg', 1750.00, 7000.00, '2025-05-02 12:56:01', NULL);

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
(39, 'te 1', '123', 'try5@gmail.com', '123', '$2y$10$6aMl6j38O6pLQrlzVyzSkODzz2TztwWzX6lSq/gkkbn1DV4cFX3ty', NULL),
(40, 'loreto', '123', 'lmanagbanag12@gmail.com', '123', '$2y$10$jAafVmeWWigP3IoUkEhNt.47Ysm2BA2VT2eKZhI07mTgOPV7vayb.', NULL),
(41, 'try1', '123', 'try1@gmail.com', '123', '$2y$10$qmAWci.FiRHfjMyIRj3lTeU98lxa1tef18ii5zXhQkrYq7bi5UL6O', NULL),
(43, 'Shane', 'Dalandanan, Valenzuela City', 'jhaneshailao05@gmail.com', '091236547895', '$2y$10$83N1SbvjJYIJdEfvohecj.IE15dwrQ.VPCwmzHrwcGECTnsHsDR7u', 'up/sachi.jpg'),
(44, 'Oia De Guia', '174 Fort Santiago St.', 'oia@gmail.com', '09123456789', '$2y$10$Oa2CWcCNqa.Clt.vd09GIe/v0EFwJJIGSmOxidym6NAgTKbS.qP9q', 'up/476741660_641479658358399_7033790522242672726_n.png'),
(45, 'Tomas Cute', 'Makati City', 'tomas@gmail.com', '09246810111', '$2y$10$7sbcjWe7J0JwEnoA/RNDGOjtDsGu7Pafgn19cxgVC/XfpQcoCFYoC', NULL),
(46, 'Ramon Rodriguez', '17 Patani Alley St. Gen. Mal. Ext. Bagong Barrio Caloocan City', 'ramon091717171@gmail.com', '09515949774', '$2y$10$h2T0Z61YxT2OVMK7rBLVie1FADGmLA653E19RY4Dx4AWeUhGWJYmK', 'up/maloi.jpg');

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
(1, 'Clear Varnish', 'Clear Varnish.png', 972, 450, '', '2024-10-04'),
(2, 'Dark Oak', 'Dark oak.png', 998, 450, '', '2024-10-04'),
(3, 'Light Oak', 'Light Oak.png', 999, 400, '', '2024-10-04'),
(4, 'Mahogany', 'Mahogany.png', 999, 400, ' ', '2024-10-04'),
(5, 'Teak', 'TEAK.png', 997, 450, '', '2024-10-04'),
(6, 'Walnut', 'Walnut.png', 1000, 450, '', '2024-10-04'),
(7, 'Mahogany', 'Mahogany.png', 999, 450, '', '2024-10-04');

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
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `checkoutcustom`
--
ALTER TABLE `checkoutcustom`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `customcheck`
--
ALTER TABLE `customcheck`
  MODIFY `orderID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `furnituretbl`
--
ALTER TABLE `furnituretbl`
  MODIFY `fID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

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
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `usertbl`
--
ALTER TABLE `usertbl`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `varnishtbl`
--
ALTER TABLE `varnishtbl`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2025 at 07:08 PM
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
-- Database: `joynes`
--

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
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `furnituretbl`
--

INSERT INTO `furnituretbl` (`fID`, `fName`, `category`, `image`, `fDes`, `fQuantity`, `cost`, `date`) VALUES
(122, 'TV Stand 001', 'tv', 'tv stand 01.jpg', 'TV Stand with Wide Open shelves and Two Small Cabinets', 10, 6000, '2024-11-07'),
(123, 'TV Stand 002', 'tv', 'tv stand 02.jpg', 'TV Stand with Spacious Cabinet and Three Small Drawers', 10, 6000, '2024-11-07'),
(125, 'TV Stand 004', 'tv', 'tv stand 04.jpg', 'Stylish TV Stand with Open Shelves and Two Drawer Sides', 7, 6000, '2024-11-07'),
(126, 'Bed frame 002', 'bed', '67499f08dd523.jpg', 'This bed frame adds a touch of sophistication to your space', 10, 7000, '2024-11-07'),
(128, 'Bed frame 003', 'bed', 'bed frame 03.jpg', 'Crafted from high-quality solid wood.', 10, 7000, '2024-11-07'),
(129, 'Bed frame 004', 'bed', 'bed frame 04.jpg', 'Solid Wood Bed Frame with Elegant Headboard for Timeless Style', 10, 7000, '2024-11-07'),
(130, 'Wardrobe Closet 001', 'cabinet', 'wardrobe closet 01.jpg', 'Modern Wardrobe Closet with Hanging Section & Shelves', 10, 8000, '2024-11-07'),
(131, 'Wardrobe Closet 002', 'cabinet', 'wardrobe closet 02.jpg', 'Closed-door Wardrobe Closet with Hanging Section, Shelves ', 9, 8000, '2024-11-07'),
(132, 'Wardrobe Closet 003', 'cabinet', 'wardrobe closet 03.jpg', 'Closed-door wardrobe with Hanging Section, Shelves, and Drawers	', 10, 8000, '2024-11-07'),
(133, 'Wardrobe Closet 004', 'cabinet', 'wardrobe closet 04.jpg', 'Spacious Wardrobe for Maximum Storage', 10, 8000, '2024-11-07'),
(140, 'Vanity Mirror 003', 'mirror', 'vanity mirror 03.jpg', 'Vanity Set with Wide Mirror, Drawers, and Comfortable Chair', 8, 5000, '2024-11-07'),
(141, 'Vanity Mirror 004', 'mirror', 'vanity mirror 04.jpg', 'Vanity Set with Circle Mirror, Drawers, and Cozy Chair', 10, 5000, '2024-11-07'),
(159, 'Dreamscape Frame  ', 'bed', '67c5048c27244.jpg', 'Solid Wood Bed Frame with Slatted Design for Breathability and Style', 10, 17000, '2025-03-03'),
(160, 'Redwood Retreat', 'bed', '67c50449b2339.jpg', 'This is a wooden twin-over-full bunk bed with a rich brown finish, featuring a sturdy frame, safety rails on the top bunk, and an angled ladder for easy access.', 10, 10000, '2025-03-03'),
(162, 'TV Stand 003', '', 'tv stand 003.jpg', 'Aesthetic Small TV Stand Cabinet with Elegant Design', 10, 6000, '2025-03-03'),
(163, 'Ember Lounge', 'chair', 'Ember Lounge.webp', 'A stylish wooden dining chair with a curved spindle back and a natural oak finish, blending Scandinavian and mid-century design.', 10, 2500, '2025-03-03'),
(164, 'Ember Haven Set', 'sala', 'Ember Haven Set.jpg', 'Its timeless appeal makes it ideal for gatherings, relaxation, or simply unwinding in a beautifully furnished home', 5, 30000, '2025-03-04'),
(165, 'Counter Stool', 'chair', 'Counter Stool.webp', 'A stylish and functional seating option, perfect for kitchen counters, bars, or high tables.', 5, 6000, '2025-03-04'),
(167, 'Arcadia Table', 'table', '67c653500d00d.jpg', ' timeless and elegant design, perfect for modern and classic interiors alike. With its sleek lines, sturdy construction, and smooth surface, this table blends functionality with aesthetic appeal.', 10, 7000, '2025-03-04'),
(168, 'Belle Reflection', 'mirror', 'Belle Reflection.jpg', 'A modern wooden vanity table with a built-in flip-up mirror, multiple storage drawers, and a matching cushioned stool, offering both style and functionality for an organized beauty space.', 5, 8000, '2025-03-04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `furnituretbl`
--
ALTER TABLE `furnituretbl`
  ADD PRIMARY KEY (`fID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `furnituretbl`
--
ALTER TABLE `furnituretbl`
  MODIFY `fID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 06, 2024 at 06:33 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resale_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `CategoryID` int(15) NOT NULL,
  `CategoryName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `listings`
--

CREATE TABLE `listings` (
  `listing_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `sub_category` varchar(100) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `color` varchar(50) NOT NULL,
  `years_used` int(11) NOT NULL,
  `condition` varchar(50) NOT NULL,
  `price` bigint(20) DEFAULT NULL,
  `description` text NOT NULL,
  `photos` text NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `town` varchar(100) DEFAULT NULL,
  `date_posted` date DEFAULT NULL,
  `seller_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `listings`
--

INSERT INTO `listings` (`listing_id`, `name`, `category`, `sub_category`, `brand`, `color`, `years_used`, `condition`, `price`, `description`, `photos`, `phone_number`, `city`, `town`, `date_posted`, `seller_id`) VALUES
(12, 'chair', 'furniture', 'other', 'Hisense', 'Brown', 1, 'fairly used', 1200, 'dinner table chair', 'ag.jpg', NULL, 'Nyeri', NULL, '2024-05-01', 37),
(13, 'tables', 'furniture', 'fridges', 'Mika', 'Black', 1, 'fairly used', 19000, 'a wooden dining table', 'ab67616d0000b273b5da98d1669cefce033629cb.jfif', NULL, 'Kiambu', NULL, '2024-05-01', 34),
(14, 'tables', 'furniture', 'fridges', 'LG', 'Black', 4, 'fairly used', 23435, 'dfxbdf', 'ab67616d0000b273b5da98d1669cefce033629cb.jfif,ab67616d0000b2739c05fec02bd9b81ee1246b2f.jfif', NULL, 'Mombasa', NULL, '2024-05-01', 37),
(15, 'epofpo', 'Appliances', 'fridges', 'Mika', 'Black', 3, 'new', 24545, 'vxddxv', '5e448c69ae6fa.image.jpg,1200x1200bb.jpg', NULL, 'Malindi', NULL, '2024-05-01', 31),
(16, 'picnic bench', 'furniture', 'fridges', 'Ramtons', 'Bronze', 0, 'fairly used', 24555, 'cdfzzv', '_savage_ TikTok wallpaper.jpg,03fbc79adc620966730d1d464bc9db93.300x300x1.jpg,50-505075_spotify-playlist-covers-chill.jpg,100% THAT BXTCH.jpg', NULL, 'Kiambu', NULL, '2024-05-01', 35),
(17, 'picnic bench', 'furniture', 'fridges', 'Ramtons', 'Bronze', 0, 'fairly used', 24555, 'cdfzzv', '_savage_ TikTok wallpaper.jpg,03fbc79adc620966730d1d464bc9db93.300x300x1.jpg,50-505075_spotify-playlist-covers-chill.jpg', NULL, 'Kisumu', NULL, '2024-05-01', 31),
(22, 'Jbl Flip 5 Speaker', 'electronics', 'Speakers', 'otherbrand', 'Black', 1, 'fairly used', 15000, 'Portable jbl flip 5 speaker', 'download (9).jfif,speaker.jfif', '254711936444', 'Nairobi', 'Ruiru', '2024-05-01', 35),
(24, 'LG Fridge', 'electronics', 'fridges', 'LG', 'Black', 1, 'fairly used', 20000, 'A fairly used LG fridge. Working well . Reason for sale is relocation', 'f2.jpg,f3.jpg,fridge.jpg', '254711936444', 'Nairobi', 'Ruiru', '2024-05-01', 35),
(26, 'Desk', 'furniture', 'tables', 'otherbrand', 'Brown', 1, 'fairly used', 5000, 'quality desk', 'pexels-catherine-augustin-3049121.jpg', '254711936444', 'Nairobi', 'Ruiru', NULL, 37),
(27, 'Bed Frame', 'furniture', 'other', 'otherbrand', 'Black', 3, 'used', 12000, 'Wooden bed frame', 'bed.jpeg,beds.jpeg', '254794879850', 'Muranga', 'Muranga town', NULL, 37),
(28, 'Spotify', 'Kitchenware', 'Microwaves', 'Mika', 'Black', 2, 'new', 12000, 'a good microwave', '68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f776174747061642d6d656469612d736572766963652f53746f7279496d6167652f79457a5f6b6554323268656171773d3d2d3630303238313433382e31353366356330363733356531653.jfif,ab67616d00001e02af37f5c01de02dc863bb7e9f.jpg,artworks-zS06HSfOPLbKBnhI-RqnNog-t500x500.jpg', '25411936444', 'Muranga', 'Chorong&#039;i', NULL, 31),
(29, 'Microwave', 'Kitchenware', 'Microwaves', 'Samsung', 'Black', 2, 'fairly used', 7000, 'dsdiooins', 'm2.jpg,micro.jpg', '254711936444', 'Nairobi', 'Utawala', NULL, 35),
(30, 'table', 'Appliances', 'Speakers', 'Hotpoint', 'other', 6, 'fairly used', 6789, 'buib', 'm2.jpg', '254711936444', 'Nairobi', 'iblip', '0000-00-00', NULL),
(34, 'tables', 'furniture', 'phones', 'Ramtons', 'Black', 8, 'used', 99, 'jkion', 'pexels-alina-vilchenko-1173651.jpg', '254711936444', 'Nairobi', 'Ruiru', NULL, 35);

-- --------------------------------------------------------

--
-- Table structure for table `mpesa_transactions`
--

CREATE TABLE `mpesa_transactions` (
  `transaction_type` varchar(255) NOT NULL,
  `trans_id` varchar(50) NOT NULL,
  `trans_time` datetime NOT NULL,
  `trans_amount` int(11) NOT NULL,
  `business_short_code` int(6) NOT NULL,
  `bill_ref_number` varchar(20) NOT NULL,
  `MSISDN` varchar(12) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mpesa_transactions`
--

INSERT INTO `mpesa_transactions` (`transaction_type`, `trans_id`, `trans_time`, `trans_amount`, `business_short_code`, `bill_ref_number`, `MSISDN`, `first_name`, `last_name`) VALUES
('Pay Bill', 'RKTQDM7W6S', '2019-11-22 06:38:45', 10, 600638, 'invoice008', '25470****149', 'John', 'Doe'),
('Pay Bill', 'RKTQDM7W6S', '2019-11-22 06:38:45', 10, 600638, 'invoice008', '25470****149', 'John', 'Doe'),
('Pay Bill', 'RKTQDM7W6S', '2019-11-22 06:38:45', 10, 600638, 'invoice008', '25470****149', 'John', 'Doe');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `email` varchar(255) NOT NULL,
  `subscriber_name` varchar(255) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`email`, `subscriber_name`, `customer_id`) VALUES
('anitawangui22@gmail.com', 'Anita Wangui', 31),
('shakirasyevuo@gmail.com', 'Shakira Syevuo', 35);

--
-- Triggers `subscribers`
--
DELIMITER $$
CREATE TRIGGER `subscribers_before_insert` BEFORE INSERT ON `subscribers` FOR EACH ROW BEGIN
    SET NEW.subscriber_name = (SELECT CONCAT(firstName, ' ', surname) FROM users WHERE UserId = NEW.customer_id);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserId` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL DEFAULT 2,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `category` enum('normal','seller','admin') NOT NULL DEFAULT 'normal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `firstName`, `surname`, `email`, `password`, `role`, `date`, `category`) VALUES
(31, 'Anita', 'Wangui', 'anitawangui22@gmail.com', '$2y$10$54JldTeQu71a5VxsR0jbeusoz2VmaeyoAw00XZtOEz0rC7P.gNXhC', 1, '2024-01-11', 'admin'),
(34, 'Francis', 'Ndegwa', 'fndegwa@gmail.com', '$2y$10$lSdibY.qL1w/sQuYfC1aAeCVNplmnlPLrq3VBBkuaedBJw9hLY04S', 2, '2024-02-22', 'normal'),
(35, 'Shakira', 'Syevuo', 'shakirasyevuo@gmail.com', '$2y$10$cGwMdvZrgVJtrPEnARmujOU74y5h8tLyKyM41eiF8dn2.mbQ1FEw6', 2, '2024-04-10', 'seller'),
(36, 'Brian', 'Kamau', 'bkk@gmail.com', '$2y$10$vZVdrw.rIXaZdatTBInne.ed0edMw.HlRiAMaxKZuYziN9HZBfPLi', 2, '2024-05-01', 'normal'),
(37, 'Rosemary', 'Ihomba', 'rihomba72@yahoo.com', '$2y$10$RM91ZoosMEc6342ae6b7VuBCs3JR2yEUN4zz5d6BXDlYc9DyZV.8C', 2, '2024-05-01', 'seller');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `listings`
--
ALTER TABLE `listings`
  ADD PRIMARY KEY (`listing_id`),
  ADD KEY `fk_seller_id` (`seller_id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`email`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserId`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `CategoryID` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `listings`
--
ALTER TABLE `listings`
  MODIFY `listing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `listings`
--
ALTER TABLE `listings`
  ADD CONSTRAINT `fk_seller_id` FOREIGN KEY (`seller_id`) REFERENCES `users` (`UserId`);

--
-- Constraints for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD CONSTRAINT `subscribers_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`UserId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

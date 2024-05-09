-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 09, 2024 at 10:31 PM
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
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`) VALUES
(1, 'Hisense'),
(2, 'Mika'),
(3, 'LG'),
(4, 'Ramtons'),
(5, 'otherbrand'),
(6, 'Samsung'),
(7, 'Hotpoint'),
(8, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(15) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'furniture'),
(2, 'Appliances'),
(3, 'electronics'),
(4, 'Kitchenware');

-- --------------------------------------------------------

--
-- Table structure for table `listings`
--

CREATE TABLE `listings` (
  `listing_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sub_category` varchar(100) NOT NULL,
  `color` varchar(50) NOT NULL,
  `years_used` int(11) NOT NULL,
  `condition` varchar(50) NOT NULL,
  `price` bigint(20) DEFAULT NULL,
  `description` text NOT NULL,
  `photos` text NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `town` varchar(100) DEFAULT NULL,
  `date_posted` date DEFAULT curdate(),
  `seller_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `listings`
--

INSERT INTO `listings` (`listing_id`, `name`, `sub_category`, `color`, `years_used`, `condition`, `price`, `description`, `photos`, `phone_number`, `city`, `town`, `date_posted`, `seller_id`, `category_id`, `brand_id`) VALUES
(1, 'Bed Frame', 'bed', 'Black', 2, 'fairly used', 150000, 'A fully wooden bed frame', 'bed.jpeg,beds.jpeg', '254794879850', 'Nairobi', 'Ruiru', '2024-05-01', 35, 1, 8),
(2, 'Microwave', 'Microwave', 'Black', 3, 'used', 6000, 'Black Samsung Microwave ', 'm2.jpg,micro.jpg', '254794879850', 'Nyeri', 'Chorong&#039;i', '2024-05-01', 35, 4, 6),
(4, 'LG Fridge', 'fridge', 'black', 5, 'used', 40000, 'No frost fridge with built in ice dispenser', 'f2.jpg,f3.jpg,fridge.jpg', '254798417766', 'Nairobi', 'Karen', '2024-05-09', 35, 3, 3),
(5, 'Coffee table', 'table', 'grey', 3, 'new', 4000, 'Wooden coffee table with two small top drawers', 'table.jfif', '254711936444', 'Kiambu', 'Thindigua', '2024-05-09', 35, 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `mpesa_request_details`
--

CREATE TABLE `mpesa_request_details` (
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
-- Dumping data for table `mpesa_request_details`
--

INSERT INTO `mpesa_request_details` (`transaction_type`, `trans_id`, `trans_time`, `trans_amount`, `business_short_code`, `bill_ref_number`, `MSISDN`, `first_name`, `last_name`) VALUES
('Pay Bill', 'RKTQDM7W6S', '2019-11-22 06:38:45', 10, 600638, 'invoice008', '25470****149', 'John', 'Doe'),
('Pay Bill', 'RKTQDM7W6S', '2019-11-22 06:38:45', 10, 600638, 'invoice008', '25470****149', 'John', 'Doe'),
('Pay Bill', 'RKTQDM7W6S', '2019-11-22 06:38:45', 10, 600638, 'invoice008', '25470****149', 'John', 'Doe');

-- --------------------------------------------------------

--
-- Table structure for table `mpesa_transactions`
--

CREATE TABLE `mpesa_transactions` (
  `Amount` float NOT NULL,
  `MpesaReceiptNumber` varchar(50) NOT NULL,
  `TransactionDate` datetime NOT NULL,
  `PhoneNumber` varchar(12) NOT NULL,
  `MerchantRequestID` varchar(50) NOT NULL,
  `CheckoutRequestID` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mpesa_transactions`
--

INSERT INTO `mpesa_transactions` (`Amount`, `MpesaReceiptNumber`, `TransactionDate`, `PhoneNumber`, `MerchantRequestID`, `CheckoutRequestID`) VALUES
(0, 'cow', '0000-00-00 00:00:00', 'dog', 'rabbit', 'lamb'),
(0, 'cow', '0000-00-00 00:00:00', 'dog', '-34591447', 'lamb'),
(1, 'NLJ7RT61SV', '2019-12-19 10:21:15', '254708374149', '29115-34620561-1', 'ws_CO_191220191020363925'),
(0, '', '0000-00-00 00:00:00', '', '', ''),
(1, 'NLJ7RT61SV', '2019-12-19 10:21:15', '254708374149', '29115-34620561-1', 'ws_CO_191220191020363925'),
(1, 'NLJ7RT61SV', '2019-12-19 10:21:15', '254708374149', '29115-34620561-1', 'ws_CO_191220191020363925'),
(0, '', '0000-00-00 00:00:00', '', 'Request canceled by user.', ''),
(0, 'Request canceled by user.', '0000-00-00 00:00:00', '1032', '29115-34620561-1', 'ws_CO_191220191020363925'),
(0, '', '0000-00-00 00:00:00', '', '', '');

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
('bkk@gmail.com', 'Brian Kamau', 36),
('rihomba72@yahoo.com', 'Rosemary Ihomba', 37),
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
  `date` date NOT NULL DEFAULT current_timestamp(),
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
(37, 'Rosemary', 'Ihomba', 'rihomba72@yahoo.com', '$2y$10$RM91ZoosMEc6342ae6b7VuBCs3JR2yEUN4zz5d6BXDlYc9DyZV.8C', 2, '2024-05-01', 'seller'),
(38, 'Anita', 'Gichuki', 'anitawangui04@gmail.com', '$2y$10$4QkpKEbV3ARpUQrX3Rkb5OngPxSXOl/2hXctP/IEM8dHCcSTQ0tSK', 2, '2024-05-09', 'normal'),
(40, 'Anita', 'Gichuki', 'anitawangui77@gmail.com', '$2y$10$zbXocLQwYwbigxxHcJnwY.9u7kblHTSoCuu5a6zZVoUFOzkGK4sty', 2, '2024-05-09', 'normal');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `listings`
--
ALTER TABLE `listings`
  ADD PRIMARY KEY (`listing_id`),
  ADD KEY `fk_seller_id` (`seller_id`),
  ADD KEY `fk_category` (`category_id`),
  ADD KEY `fk_brand` (`brand_id`);

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
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `listings`
--
ALTER TABLE `listings`
  MODIFY `listing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `listings`
--
ALTER TABLE `listings`
  ADD CONSTRAINT `fk_brand` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`brand_id`),
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
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

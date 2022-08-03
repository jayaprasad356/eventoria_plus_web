-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 03, 2022 at 05:40 AM
-- Server version: 10.5.13-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u743445510_ep`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `district` text DEFAULT NULL,
  `pincode` text DEFAULT NULL,
  `state` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `name`, `address`, `district`, `pincode`, `state`) VALUES
(1, 'prasad', 'street', 'sholapuram', '612828', 'kumbakonam'),
(2, 'c', 'vv', 'bbv', 'ff', 'gv'),
(3, 'Ad', 'udbxb', '134556', '18$849', 'india');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `status`) VALUES
(1, 'Birthday Event', 'upload/images/4743-2022-07-13.jpg', 1),
(2, 'Marriage Hall', 'upload/images/5311-2022-07-13.jpeg', 1),
(3, 'Graduation', 'upload/images/3397-2022-07-13.jpg', 1),
(4, 'Propose Hall', 'upload/images/8713-2022-07-13.jpg', 1),
(5, 'Birthday Decoration', 'upload/images/4202-2022-07-13.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_date` varchar(200) DEFAULT NULL,
  `event_date` varchar(100) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `address_id` int(11) DEFAULT NULL,
  `venue_id` int(11) DEFAULT NULL,
  `package_id` int(11) NOT NULL,
  `price` text DEFAULT NULL,
  `type` text DEFAULT NULL,
  `start_time` text DEFAULT NULL,
  `end_time` text DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_date`, `event_date`, `user_id`, `address_id`, `venue_id`, `package_id`, `price`, `type`, `start_time`, `end_time`, `status`) VALUES
(1, NULL, NULL, 1, 1, NULL, 1, '3000', 'own', '', '', 1),
(5, NULL, NULL, 1, NULL, 3, 1, '800', 'venue', '20:00', '20:00', 1),
(7, NULL, NULL, 1, NULL, 3, 1, '3000', 'venue', '20:00', '20:00', 1),
(8, NULL, NULL, 1, NULL, 3, 1, '', 'venue', NULL, NULL, 1),
(9, NULL, NULL, 1, NULL, 3, 1, '6000', 'venue', NULL, NULL, 1),
(10, '2022', NULL, 1, NULL, 3, 1, '6000', 'venue', NULL, NULL, 1),
(11, '2022-08-02', NULL, 1, NULL, 3, 1, '6000', 'venue', NULL, NULL, 1),
(12, '2022-08-02', NULL, 1, NULL, 3, 1, '6000', 'venue', NULL, NULL, 1),
(13, '2022-08-02', NULL, 1, NULL, 3, 1, '6000', 'venue', NULL, NULL, 1),
(14, '2022-08-02', '2022-08-05', 1, NULL, 3, 1, '6000', 'venue', NULL, NULL, 1),
(15, '2022-08-02', '2022-08-07', 1, NULL, 3, 1, '6000', 'venue', NULL, NULL, 1),
(16, '2022-08-02', '2022-08-07', 1, NULL, 3, 1, '3400', 'venue', NULL, NULL, 1),
(17, '2022-08-03', '2022-08-03', 2, NULL, 3, 1, '6000', 'venue', NULL, NULL, 1),
(18, '2022-08-03', '2022-08-07', 3, NULL, 3, 1, '3200', 'venue', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders_timeslot`
--

CREATE TABLE `orders_timeslot` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `venue_id` int(11) DEFAULT NULL,
  `time_slot_id` int(11) DEFAULT NULL,
  `start_time` varchar(100) DEFAULT NULL,
  `end_time` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders_timeslot`
--

INSERT INTO `orders_timeslot` (`id`, `user_id`, `order_id`, `venue_id`, `time_slot_id`, `start_time`, `end_time`, `price`) VALUES
(1, 1, 8, 3, 1, '20:00', '20:00', 3000),
(2, 1, 9, 3, 1, '20:00', '20:00', 3000),
(3, 1, 10, 3, 1, '20:00', '20:00', 3000),
(4, 1, 11, 3, 1, '20:00', '20:00', 3000),
(5, 1, 12, 3, 1, '20:00', '20:00', 3000),
(6, 1, 14, 3, 1, '20:00', '20:00', 3000),
(7, 1, 15, 3, 1, '20:00', '20:00', 3000),
(8, 1, 16, 3, 4, '11:45', '15:40', 400),
(9, 2, 17, 3, 1, '20:00', '20:00', 3000),
(10, 3, 18, 3, 3, '16:19', '20:24', 200);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `cover_photo` text DEFAULT NULL,
  `image1` text DEFAULT NULL,
  `image2` text DEFAULT NULL,
  `image3` text DEFAULT NULL,
  `image4` text DEFAULT NULL,
  `recommend` tinyint(4) NOT NULL,
  `price` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `pincode` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `cover_photo`, `image1`, `image2`, `image3`, `image4`, `recommend`, `price`, `category_id`, `description`, `pincode`, `status`) VALUES
(1, 'Basic Birthday', 'upload/images/1657836058.6088.png', 'upload/images/1657836058.6638.png', 'upload/images/1657836058.7648.png', NULL, 'upload/images/1657836059.2159.png', 1, '3000', 1, 'Basic Plan for Afforadable Price', '612345', 1);

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

CREATE TABLE `slides` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `slides`
--

INSERT INTO `slides` (`id`, `name`, `image`, `status`) VALUES
(1, 'Outdoor Decoration', 'upload/images/6592-2022-07-13.jpg', 1),
(2, 'Birthday Decoration', 'upload/images/7013-2022-07-13.jpg', 1),
(3, 'Wedding Decoration', 'upload/images/4790-2022-07-13.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `timeslots`
--

CREATE TABLE `timeslots` (
  `id` int(11) NOT NULL,
  `venue_id` int(11) DEFAULT NULL,
  `start_time` text DEFAULT NULL,
  `end_time` text DEFAULT NULL,
  `prices` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `timeslots`
--

INSERT INTO `timeslots` (`id`, `venue_id`, `start_time`, `end_time`, `prices`) VALUES
(1, 3, '20:00', '20:00', 3000),
(2, 4, '03:45', '16:00', 500),
(3, 3, '16:19', '20:24', 200),
(4, 3, '11:45', '15:40', 400);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `mobile` text DEFAULT NULL,
  `pincode` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mobile`, `pincode`) VALUES
(1, 'Prasad', '8778624681', '612345'),
(2, 'S.k.yadav', '8827241086', '497001'),
(3, 'tamil', '6382088746', '612345');

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

CREATE TABLE `venues` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `cover_image` text DEFAULT NULL,
  `image1` text DEFAULT NULL,
  `image2` text DEFAULT NULL,
  `image3` text DEFAULT NULL,
  `image4` text DEFAULT NULL,
  `pincode` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`id`, `name`, `address`, `cover_image`, `image1`, `image2`, `image3`, `image4`, `pincode`) VALUES
(3, 'Violet Park', 'near lasangles', 'upload/images/4059-2022-07-13.jpg', 'upload/images/1657837946.8139.png', NULL, 'upload/images/1657837947.0739.jpeg', NULL, '612345');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders_timeslot`
--
ALTER TABLE `orders_timeslot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timeslots`
--
ALTER TABLE `timeslots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `venues`
--
ALTER TABLE `venues`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `orders_timeslot`
--
ALTER TABLE `orders_timeslot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `slides`
--
ALTER TABLE `slides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `timeslots`
--
ALTER TABLE `timeslots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

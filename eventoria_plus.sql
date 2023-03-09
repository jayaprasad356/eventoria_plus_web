-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2023 at 07:49 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eventoria_plus`
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
(1, 'Divakar', '1/165,East Street', 'Coimbatore', '746749', 'Tamilnadu');

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
(1, 'Birthday eventoria', 'upload/images/1661263742.2405.jpg', 1),
(2, 'Marriage eventoria', 'upload/images/5311-2022-07-13.jpeg', 1),
(3, 'Commercial eventoria', 'upload/images/3397-2022-07-13.jpg', 1),
(4, 'Dating eventoria', 'upload/images/1661263426.2398.jpg', 1),
(5, 'Romantic room', 'upload/images/1661265987.8388.jfif', 1),
(6, 'Kitty party eventoria', 'upload/images/1661266015.51.jpg', 1),
(7, 'Gaming or fun eventoria', 'upload/images/0198-2022-08-23.jpg', 0),
(8, 'Outdoor Picnic', 'upload/images/9421-2022-08-23.jpg', 1),
(9, 'Test', 'upload/images/1676455610.2253.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `coupon_codes`
--

CREATE TABLE `coupon_codes` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL DEFAULT 0,
  `coupon_code` varchar(28) NOT NULL,
  `message` varchar(512) NOT NULL,
  `start_date` varchar(28) NOT NULL,
  `end_date` varchar(28) NOT NULL,
  `no_of_users` int(11) NOT NULL,
  `minimum_order_amount` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `discount_type` varchar(28) NOT NULL,
  `max_discount_amount` int(11) NOT NULL,
  `repeat_usage` tinyint(4) NOT NULL,
  `no_of_repeat_usage` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `coupon_codes`
--

INSERT INTO `coupon_codes` (`id`, `seller_id`, `category_id`, `coupon_code`, `message`, `start_date`, `end_date`, `no_of_users`, `minimum_order_amount`, `discount`, `discount_type`, `max_discount_amount`, `repeat_usage`, `no_of_repeat_usage`, `status`, `type`, `date_created`) VALUES
(1, 1, 1, 'ggrg435', 'HRHR', '2023-02-15', '2023-03-02', 5, 6655, 3, 'percentage', 45, 0, 0, 1, 'public', '2023-02-28 07:22:12');

-- --------------------------------------------------------

--
-- Table structure for table `deliver_pincodes`
--

CREATE TABLE `deliver_pincodes` (
  `id` int(11) NOT NULL,
  `pincode` text DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `deliver_pincodes`
--

INSERT INTO `deliver_pincodes` (`id`, `pincode`, `state`, `district`) VALUES
(1, '620028', NULL, NULL),
(3, '621313', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `months`
--

CREATE TABLE `months` (
  `id` int(11) NOT NULL,
  `month` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `months`
--

INSERT INTO `months` (`id`, `month`) VALUES
(1, 'January'),
(2, 'February'),
(3, 'March'),
(4, 'April'),
(5, 'May'),
(6, 'June'),
(7, 'July'),
(8, 'August'),
(9, 'September'),
(10, 'October'),
(11, 'November'),
(12, 'December');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `title` text DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `description`) VALUES
(1, 'Payments', 'Is there notifications available?');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `package_name` varchar(255) DEFAULT NULL,
  `order_date` varchar(200) DEFAULT NULL,
  `order_time` varchar(255) DEFAULT NULL,
  `event_date` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `address_id` int(11) DEFAULT NULL,
  `venue_id` int(11) DEFAULT NULL,
  `package_id` int(11) NOT NULL,
  `price` text DEFAULT NULL,
  `promo_code` varchar(100) DEFAULT NULL,
  `type` text DEFAULT NULL,
  `start_time` text DEFAULT NULL,
  `end_time` text DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `package_name`, `order_date`, `order_time`, `event_date`, `address`, `user_id`, `address_id`, `venue_id`, `package_id`, `price`, `promo_code`, `type`, `start_time`, `end_time`, `pincode`, `status`) VALUES
(50, 'Romantic candle light date', '2022-09-17', '23:49:22', '2022-09-17', 'near old bus stand Ambikapur', 1, NULL, 6, 12, '1000', '', 'venue', NULL, NULL, '612345', 2),
(51, 'Romantic room', '2022-09-20', '17:03:38', '2022-09-21', 'Bramha road, old panchsheel gali', 2, NULL, 8, 11, '3200', '', 'venue', NULL, NULL, '497001', 2),
(52, 'Romantic room', '2022-09-20', '17:30:44', '2022-09-21', 'Bramha road, old panchsheel gali', 2, NULL, 8, 11, '3200', '', 'venue', NULL, NULL, '497001', 2);

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
(10, 3, 18, 3, 3, '16:19', '20:24', 200),
(11, 2, 19, 3, 1, '20:00', '20:00', 3000),
(12, 2, 20, 3, 1, '20:00', '20:00', 3000),
(13, 2, 20, 3, 3, '16:19', '20:24', 200),
(14, 2, 20, 3, 4, '11:45', '15:40', 400),
(15, 3, 24, 3, 1, '20:00', '20:00', 3000),
(16, 1, 25, 3, 1, '20:00', '20:00', 3000),
(17, 1, 25, 3, 3, '16:19', '20:24', 200),
(18, 1, 25, 3, 4, '11:45', '15:40', 400),
(19, 1, 26, 3, 1, '20:00', '20:00', 3000),
(20, 1, 26, 3, 4, '11:45', '15:40', 400),
(21, 1, 31, 3, 1, '20:00', '20:00', 3000),
(22, 1, 32, 3, 1, '20:00', '20:00', 3000),
(23, 1, 32, 3, 3, '16:19', '20:24', 200),
(24, 1, 33, 3, 3, '16:19', '20:24', 200),
(25, 1, 36, 3, 1, '20:00', '20:00', 3000),
(26, 1, 38, 3, 1, '20:00', '20:00', 3000),
(27, 1, 39, 3, 1, '20:00', '20:00', 3000),
(28, 1, 40, 3, 1, '20:00', '20:00', 3000),
(29, 1, 40, 3, 3, '16:19', '20:24', 200),
(30, 1, 41, 3, 1, '20:00', '20:00', 3000),
(31, 1, 41, 3, 3, '16:19', '20:24', 200),
(32, 1, 41, 3, 4, '11:45', '15:40', 400),
(33, 2, 42, 5, 0, '', '', 0),
(34, 2, 43, 6, 7, '10:00', '23:00', 500),
(35, 2, 44, 6, 7, '10:00', '23:00', 500),
(36, 2, 45, 6, 7, '10:00', '12:00', 500),
(37, 1, 47, 6, 7, '10:00', '12:00', 500),
(38, 1, 48, 6, 7, '10:00', '12:00', 500),
(39, 1, 49, 6, 7, '10:00', '12:00', 500),
(40, 1, 50, 6, 7, '10:00', '12:00', 500),
(41, 2, 51, 8, 10, '11:00', '20:00', 1200),
(42, 2, 52, 8, 10, '11:00', '20:00', 1200);

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
(1, 'Basic Birthday', 'upload/images/1661266567.7263.jpg', 'upload/images/1657836058.6638.png', 'upload/images/1657836058.7648.png', NULL, 'upload/images/1657836059.2159.png', 1, '3000', 1, 'Basic Plan for Afforadable Price', '497001', 1),
(10, 'Special romantic date', 'upload/images/9277-2022-08-22.', '', '', '', '', 1, '5000', 2, 'decorated, dating space ....', '497001', 1),
(11, 'Romantic room', 'upload/images/3848-2022-08-23.', '', '', '', '', 0, '2000', 5, 'romantic decorated room', '497001', 1),
(12, 'Romantic candle light date', 'upload/images/0144-2022-08-23.', 'upload/images/4655-2022-08-23.', 'upload/images/9495-2022-08-23.', 'upload/images/2588-2022-08-23.', 'upload/images/0502-2022-08-23.', 0, '500', 1, 'romantic candle light table', '612345', 1),
(14, 'hhhhh', 'upload/images/1676377331.432.jpg', 'upload/images/1676377331.4362.jpg', 'upload/images/1676377331.4403.jpg', 'upload/images/1676377331.4449.jpg', 'upload/images/1676377331.4492.jpg', 1, '677', 2, '7777', '612908', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) DEFAULT 0,
  `name` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `measurement` text DEFAULT NULL,
  `unit` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `pincode` text DEFAULT NULL,
  `product_image` text DEFAULT NULL,
  `image1` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `seller_id`, `name`, `category_id`, `measurement`, `unit`, `price`, `description`, `pincode`, `product_image`, `image1`, `status`) VALUES
(1, 1, 'Strawberry Cake', 1, '1', 'Kg', '14999.00', 'This is one of the customer\'s liked product from ours', '620008', 'upload/images/1677152682.0039.jpg', 'upload/images/1677152697.1989.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `promo_codes`
--

CREATE TABLE `promo_codes` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT 0,
  `promo_code` varchar(28) NOT NULL,
  `message` varchar(512) NOT NULL,
  `start_date` varchar(28) NOT NULL,
  `end_date` varchar(28) NOT NULL,
  `no_of_users` int(11) NOT NULL,
  `minimum_order_amount` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `discount_type` varchar(28) NOT NULL,
  `max_discount_amount` int(11) NOT NULL,
  `repeat_usage` tinyint(4) NOT NULL,
  `no_of_repeat_usage` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `promo_codes`
--

INSERT INTO `promo_codes` (`id`, `category_id`, `promo_code`, `message`, `start_date`, `end_date`, `no_of_users`, `minimum_order_amount`, `discount`, `discount_type`, `max_discount_amount`, `repeat_usage`, `no_of_repeat_usage`, `status`, `type`, `date_created`) VALUES
(1, 0, 'DEMO', 'demo', '2022-01-31', '2022-02-03', 5, 100, 10, 'percentage', 300, 0, 0, 1, NULL, '2022-01-31 13:18:28'),
(3, 0, 'SUCCESS', 'success', '2022-08-09', '2022-08-24', 10, 3000, 5, 'percentage', 1000, 1, 10, 1, NULL, '2022-08-09 13:57:31'),
(4, 0, '12345', 'gift', '2022-05-25', '2022-10-25', 1, 1, 30, 'percentage', 300, 0, 0, 1, NULL, '2022-08-24 04:28:40'),
(5, 0, 'REER', 'ddfdfd', '2022-09-12', '2022-09-13', 5, 500, 50, 'percentage', 500, 1, 0, 1, 'public', '2022-09-04 04:10:43'),
(6, 0, 'FDFDF', 'dffsdfs', '2022-09-04', '2022-09-14', 4, 400, 343, 'percentage', 4343, 1, 4, 1, 'public', '2022-09-04 04:12:43'),
(7, 0, 'dsds', 'sdsds', '2022-09-13', '2022-09-28', 5, 5, 5, 'amount', 5, 0, 0, 1, 'public', '2022-09-16 13:04:37'),
(8, 0, 'sdsds', 'dsds', '2022-09-15', '2022-09-27', 5, 500, 5, 'amount', 5, 0, 0, 1, 'public', '2022-09-16 13:05:59');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `whatsapp` text DEFAULT NULL,
  `telegram` text DEFAULT NULL,
  `instagram` text DEFAULT NULL,
  `paytm_payment_method` tinyint(4) NOT NULL,
  `paytm_merchant_id` varchar(255) DEFAULT NULL,
  `paytm_merchant_key` varchar(255) DEFAULT NULL,
  `paytm_mode` varchar(255) DEFAULT NULL,
  `terms_conditions` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `whatsapp`, `telegram`, `instagram`, `paytm_payment_method`, `paytm_merchant_id`, `paytm_merchant_key`, `paytm_mode`, `terms_conditions`) VALUES
(1, 'https://div.whatsapp.com', 'eventoria.telegram.in', 'eventoria13.instagram.com', 1, '', '', 'sandbox', '<p>Hello Divakar</p>');

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `id` int(11) NOT NULL,
  `name` text CHARACTER SET utf8 DEFAULT NULL,
  `shop_name` text CHARACTER SET utf8 DEFAULT NULL,
  `mobile` text DEFAULT NULL,
  `email` text CHARACTER SET utf8 DEFAULT NULL,
  `password` text CHARACTER SET utf8 DEFAULT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `logo` text CHARACTER SET utf8 DEFAULT NULL,
  `pincode` text DEFAULT NULL,
  `street` text CHARACTER SET utf8 DEFAULT NULL,
  `state` text CHARACTER SET utf8 DEFAULT NULL,
  `account_number` text CHARACTER SET utf8 DEFAULT NULL,
  `bank_ifsc_code` text CHARACTER SET utf8 DEFAULT NULL,
  `holder_name` text CHARACTER SET utf8 DEFAULT NULL,
  `bank_name` text CHARACTER SET utf8 DEFAULT NULL,
  `latitude` varchar(256) CHARACTER SET utf8 DEFAULT NULL,
  `longitude` varchar(256) CHARACTER SET utf8 DEFAULT NULL,
  `joined_date` text DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`id`, `name`, `shop_name`, `mobile`, `email`, `password`, `balance`, `logo`, `pincode`, `street`, `state`, `account_number`, `bank_ifsc_code`, `holder_name`, `bank_name`, `latitude`, `longitude`, `joined_date`, `status`) VALUES
(1, 'Divakar A', 'DANGI Store', '7358832695', 'dinesh@gmail.com', 'Dangi@314', '0.00', '1676429139.4261.jpg', '621313', '2/42, Azhagapuri,R.T.Malai(Po)', 'Tamil Nadu', '83550981234', 'SBI0008355', 'Dangi Divakar', 'State Bank Of India', '74.259377', '10.677280', '2023-02-10', 1),
(2, 'Lalaa', 'LALA Eventers', '9876322323', 'lara@gmail.com', 'Smsatta@2022', '500.00', '1676433720.2287.jpg', '988399', 'West BANGAL', 'Andhra Pradesh', '83181051987', 'BOI66668318', 'samkarthi', 'Bank of India', '7645', '65.098', '2023-02-16', 1);

-- --------------------------------------------------------

--
-- Table structure for table `shop_timeslots`
--

CREATE TABLE `shop_timeslots` (
  `id` int(11) NOT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `start_time` text DEFAULT '',
  `end_time` text DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shop_timeslots`
--

INSERT INTO `shop_timeslots` (`id`, `shop_id`, `start_time`, `end_time`) VALUES
(1, 1, '08:00', '12:00'),
(2, 1, '13:00', '17:00'),
(3, 1, '15:00', '16:20');

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

CREATE TABLE `slides` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `link` text DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `slides`
--

INSERT INTO `slides` (`id`, `name`, `category_id`, `package_id`, `image`, `status`, `link`, `type`) VALUES
(1, 'Outdoor Decoration', NULL, 1, 'upload/images/3858-2023-02-14.jpg', 1, NULL, 'Package'),
(2, 'Birthday Decoration', NULL, NULL, 'upload/images/7013-2022-07-13.jpg', 1, NULL, NULL),
(3, 'Wedding Decoration', NULL, NULL, 'upload/images/4790-2022-07-13.jpg', 1, NULL, NULL),
(4, 'dfsfs', NULL, 1, 'upload/images/2510-2022-09-13.', 1, NULL, 'Package');

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
(4, 3, '11:45', '15:40', 400),
(5, 5, '10:00', '12:00', 500),
(6, 5, '01:00', '03:00', 500),
(7, 6, '10:00', '12:00', 500),
(8, 6, '12:30', '14:30', 500),
(9, 7, '14:29', '14:29', 4500),
(10, 8, '11:00', '20:00', 1200);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `unit` text DEFAULT NULL,
  `name` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unit`, `name`) VALUES
(1, 'g', 'Gram'),
(2, 'Kg', 'Kilogram');

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
-- Table structure for table `vendor_categories`
--

CREATE TABLE `vendor_categories` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `name` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0 COMMENT 'Inactive -0 |\r\nActive - 1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vendor_categories`
--

INSERT INTO `vendor_categories` (`id`, `seller_id`, `name`, `image`, `status`) VALUES
(1, 1, 'Cakes', 'upload/images/1676455610.2253.jpg', 1),
(2, 2, 'Snacks', 'upload/images/4351-2023-03-02.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vendor_orders`
--

CREATE TABLE `vendor_orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `quantity` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `order_date` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0 COMMENT 'Booked-0 | Confirmed-1 |\r\nCompleted -2 |\r\nCancelled-3'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vendor_orders`
--

INSERT INTO `vendor_orders` (`id`, `user_id`, `address_id`, `product_id`, `seller_id`, `quantity`, `price`, `order_date`, `status`) VALUES
(1, 1, 1, 1, 1, '2', '29998.00', '2023-02-25', 1);

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

CREATE TABLE `venues` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `categories` varchar(255) DEFAULT NULL,
  `cover_image` text DEFAULT NULL,
  `image1` text DEFAULT NULL,
  `image2` text DEFAULT NULL,
  `image3` text DEFAULT NULL,
  `image4` text DEFAULT NULL,
  `pincode` text DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`id`, `name`, `address`, `categories`, `cover_image`, `image1`, `image2`, `image3`, `image4`, `pincode`, `description`) VALUES
(3, 'Violet Park', 'near lasangles', '7', 'upload/images/4059-2022-07-13.jpg', 'upload/images/1657837946.8139.png', NULL, 'upload/images/1657837947.0739.jpeg', NULL, '612345', ''),
(5, 'GRS', 'near new bus stand Ambikapur', NULL, 'upload/images/1175-2022-08-22.', '', '', '', '', '497001', NULL),
(6, 'Hotel Virendra Prabha', 'near old bus stand Ambikapur', '1', 'upload/images/8042-2022-08-23.', '', '', '', '', '612345', 'dfdfdfdfdvd'),
(7, 'dsds', 'sdsd', '7,5', 'upload/images/1620-2022-09-04.', '', '', '', '', '434344', ''),
(8, 'Hotel Devraj', 'Bramha road, old panchsheel gali', '5', 'upload/images/0001-2022-09-20.', '', '', '', '', '497001', 'clean and secure atmosphere.');

-- --------------------------------------------------------

--
-- Table structure for table `years`
--

CREATE TABLE `years` (
  `id` int(11) NOT NULL,
  `year` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `years`
--

INSERT INTO `years` (`id`, `year`) VALUES
(1, '2022'),
(2, '2023'),
(3, '2024'),
(4, '2025'),
(5, '2026'),
(6, '2027');

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
-- Indexes for table `coupon_codes`
--
ALTER TABLE `coupon_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliver_pincodes`
--
ALTER TABLE `deliver_pincodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `months`
--
ALTER TABLE `months`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
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
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promo_codes`
--
ALTER TABLE `promo_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_timeslots`
--
ALTER TABLE `shop_timeslots`
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
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_categories`
--
ALTER TABLE `vendor_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_orders`
--
ALTER TABLE `vendor_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `venues`
--
ALTER TABLE `venues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `years`
--
ALTER TABLE `years`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `coupon_codes`
--
ALTER TABLE `coupon_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deliver_pincodes`
--
ALTER TABLE `deliver_pincodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `months`
--
ALTER TABLE `months`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `orders_timeslot`
--
ALTER TABLE `orders_timeslot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `promo_codes`
--
ALTER TABLE `promo_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shop_timeslots`
--
ALTER TABLE `shop_timeslots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `slides`
--
ALTER TABLE `slides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `timeslots`
--
ALTER TABLE `timeslots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vendor_categories`
--
ALTER TABLE `vendor_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vendor_orders`
--
ALTER TABLE `vendor_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `years`
--
ALTER TABLE `years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

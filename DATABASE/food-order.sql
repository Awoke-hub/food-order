-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2022 at 06:51 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_38629835_food`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `full_name`, `username`, `password`) VALUES
(12, 'Administrator', 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(13, 'Jaison E Mathew', 'jaison', '5f4dcc3b5aa765d61d8327deb882cf99'),
(14, 'Varghese Babu', 'password', '5f4dcc3b5aa765d61d8327deb882cf99');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `featured` varchar(10) NOT NULL,
  `active` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `title`, `image_name`, `featured`, `active`) VALUES
(1, 'Meats', 'Food_Category_548.jpg', 'Yes', 'Yes'),
(2, 'Diary', 'Food_Category_28.jfif', 'Yes', 'Yes'),
(3, 'Others', 'Food_Category_653.jpg', 'Yes', 'Yes'),
(4, 'Friuts', 'Food_Category_357.jfif', 'Yes', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_food`
--

CREATE TABLE `tbl_food` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `featured` varchar(10) NOT NULL,
  `active` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_food`
--

INSERT INTO `tbl_food` (`id`, `title`, `description`, `price`, `image_name`, `category_id`, `featured`, `active`) VALUES
(35, 'Chicken', 'Deliciously seasoned chicken', 620.00, 'Food-Name-2983.jpg', 4, 'Yes', 'Yes'),
(36, 'Fresh-fish', 'Fresh, flaky fish cooked to perfection – light, he...', 450.00, 'Food-Name-2274.webp', 4, 'Yes', 'Yes'),
(37, 'Beef-best', 'Unlike other Beef-best is unique', 570.00, 'Food-Name-618.jpg', 4, 'Yes', 'Yes'),
(38, 'Mutton', 'Succulent pieces of mutton slow cooked on bed of a...', 600.00, 'Food-Name-4274.jpg', 4, 'Yes', 'Yes'),
(39, 'Milk', 'Nutrient-rich liquid produced by mammals, commonly...', 122.00, 'Food-Name-8460.jiff', 5, 'Yes', 'Yes'),
(40, 'Yoghurt', 'Yoghurt is a nutritious, fermented dairy product r...', 150.00, 'Food-Name-9093.jpg', 5, 'Yes', 'Yes'),
(41, 'Pizza', 'Hot, cheesy pizza with a crispy crust and deliciou...', 325.00, 'Food-Name-2936.jpg', 9, 'Yes', 'Yes'),
(42, 'Special-Pizza', 'golden crust – our Special Pizza is a slice above ...', 490.00, 'Food-Name-9133.jpg', 9, 'Yes', 'Yes'),
(43, 'Pasta', 'Deliciously creamy and perfectly cooked pasta', 215.00, 'Food-Name-2518.jpg', 9, 'Yes', 'Yes'),
(44, 'best burger', 'Best Firewood Pizza in Town made with thin cheese', 850.00, 'Food-Name-4087.jpg', 9, 'Yes', 'Yes'),
(46, 'Orange', 'An orange is a juicy, tangy fruit bursting', 90.00, 'Food-Name-8436.jpg', 10, 'Yes', 'Yes'),
(47, 'Mango', 'A mango is a juicy, tropical fruit with a rich, sw...', 140.00, 'Food-Name-5807.jiff', 10, 'Yes', 'Yes'),
(48, 'Papaya', 'A papaya is a tropical fruit with a sweet, musky f...', 150.00, 'Food-Name-6958.jpg', 10, 'Yes', 'Yes'),
(49, 'Banana', 'Naturally sweet banana', 130.00, 'Food-Name-6034.jiff', 10, 'Yes', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `id` int(10) UNSIGNED NOT NULL,
  `food` varchar(150) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_date` datetime NOT NULL,
  `status` varchar(50) NOT NULL,
  `u_id` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `customer_name` varchar(150) NOT NULL,
  `customer_email` varchar(150) NOT NULL,
  `customer_contact` bigint(25) NOT NULL,
  `customer_address` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_food`
--
ALTER TABLE `tbl_food`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_food`
--
ALTER TABLE `tbl_food`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
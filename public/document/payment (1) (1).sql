-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 21, 2021 at 08:53 AM
-- Server version: 10.3.27-MariaDB-cll-lve
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skypearl_gopani`
--

-- --------------------------------------------------------

--
-- Table structure for table `expanse`
--

CREATE TABLE `expanse` (
  `id` bigint(20) NOT NULL,
  `pid` int(11) DEFAULT NULL,
  `customerid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `payment_amount` varchar(10) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `payment_date` date NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expanse`
--

INSERT INTO `expanse` (`id`, `pid`, `customerid`, `order_id`, `payment_amount`, `comment`, `payment_date`, `created_at`, `updated_at`) VALUES
(3, 38, 1, 1, '20', NULL, '2021-03-15', '2021-03-15 02:04:05', '2021-03-15 02:04:05'),
(4, 38, 2, 2, '20', NULL, '2021-03-15', '2021-03-15 02:05:02', '2021-03-15 02:05:02'),
(5, 38, 2, 3, '20', NULL, '2021-03-16', '2021-03-15 02:21:27', '2021-03-15 02:21:27'),
(6, 38, 1, NULL, '10', NULL, '2021-03-20', '2021-03-20 09:49:43', '2021-03-20 09:49:43'),
(7, 38, 1, NULL, '10', NULL, '2021-03-20', '2021-03-20 09:51:02', '2021-03-20 09:51:02'),
(8, 38, 1, NULL, '10', NULL, '2021-03-20', '2021-03-20 09:52:42', '2021-03-20 09:52:42'),
(9, 38, 1, NULL, '10', NULL, '2021-03-20', '2021-03-20 09:55:08', '2021-03-20 09:55:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `expanse`
--
ALTER TABLE `expanse`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `expanse`
--
ALTER TABLE `expanse`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2020 at 01:50 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spacedive`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `num` text DEFAULT NULL,
  `address` text NOT NULL,
  `cname` text NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `num`, `address`, `cname`, `email`, `phone`, `user_id`) VALUES
(1, 'Ahmed butt', 'asd', 'asd', 'asd', 'asd@gmail.com', '123123', 1),
(3, 'sa', 's', 's', 's', 's@gmail.com', 's', 1),
(4, 'sda', NULL, 'ds', '2', '123@admin.com', '2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `invoice_num` varchar(255) NOT NULL,
  `client` text DEFAULT NULL,
  `data` text NOT NULL,
  `total` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `final` tinyint(4) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `logo` text NOT NULL,
  `client_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_num`, `client`, `data`, `total`, `created_at`, `user_id`, `final`, `status`, `logo`, `client_id`) VALUES
(42, 'Invoice 1', NULL, '{\"_token\":\"DsQ6LdkVPAai5dBLeA8QeOeBW9EZ4qTubXyJKw5x\",\"id\":\"42\",\"invoice_num\":\"Invoice 1\",\"description\":null,\"date_issued\":\"2020-03-25\",\"date_due\":\"2020-03-25\",\"client\":null,\"reg_num\":null,\"address\":null,\"contact\":null,\"email\":null,\"phone\":null,\"exp_desc\":[null],\"exp_quan\":[\"1\"],\"exp_val\":[\"0\"],\"total_val\":\"0\",\"total\":\"0.00\",\"notes\":null,\"currency\":\"DKK\",\"submit\":\"draft\",\"logo\":{}}', '0.00', '2020-03-25 15:26:08', 1, 0, 'paid', '1585150082.png', NULL),
(43, 'Invoice 2', 'asd', '{\"_token\":\"l5hqSxHmw7M3k42CsaEL2JWGWsGXgtfI2fmqYzPk\",\"invoice_num\":\"Invoice 2\",\"description\":\"asd\",\"date_issued\":\"2020-03-29\",\"date_due\":\"2020-03-31\",\"client\":\"asd\",\"reg_num\":null,\"address\":null,\"contact\":null,\"email\":null,\"phone\":null,\"exp_desc\":[null],\"exp_quan\":[\"1\"],\"exp_val\":[\"123\"],\"tax1description\":null,\"tax1percent\":\"2\",\"total_val\":\"125.46\",\"total\":\"125.46\",\"notes\":null,\"currency\":\"DKK\",\"submit\":\"send\"}', '125.46', '2020-03-29 12:50:53', 1, 1, 'paid', '1585486253.png', 3),
(44, 'Invoice 3', 'asd', '{\"_token\":\"uBUZsnTXWUk5zjK3GBWlgxvMzidxpgI2NCGcBlKj\",\"invoice_num\":\"Invoice 3\",\"description\":null,\"date_issued\":\"2020-04-01\",\"date_due\":null,\"client\":\"asd\",\"reg_num\":null,\"address\":null,\"contact\":null,\"email\":null,\"phone\":null,\"exp_desc\":[null],\"exp_quan\":[\"1\"],\"exp_val\":[\"0\"],\"total_val\":\"0\",\"total\":\"0.00\",\"notes\":null,\"currency\":\"DKK\",\"submit\":\"send\"}', '0', '2020-04-01 11:15:08', 1, 1, 'pending', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `dob` date DEFAULT NULL,
  `image` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `gender` enum('male','female') DEFAULT 'male',
  `aboutme` text DEFAULT NULL,
  `city` text NOT NULL,
  `street` text NOT NULL,
  `zipcode` text NOT NULL,
  `country` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `email`, `number`, `password`, `created_at`, `dob`, `image`, `address`, `gender`, `aboutme`, `city`, `street`, `zipcode`, `country`) VALUES
(1, 'Ahmed sss', 'Butt', 'bahtasham@gmail.com', NULL, '$2y$10$vw6dXnLc8eEiCWbAczWusORyxCeqroyS4771z85kaHSkLH5oS8jNq', '2020-03-16 10:15:38', '2020-03-18', '1584532226.jpeg', '1as', 'male', 'sdasdasd', '12', '12', '12', '12'),
(3, '123', '321', '123@admin.com', '123', '$2y$10$O7kopqrnKqXFMJKXI2itkeKGje3UmCayqEE49lBVeb3rSkEYm.f0e', '2020-03-21 09:24:21', NULL, NULL, NULL, 'male', NULL, '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

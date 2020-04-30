-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2020 at 11:04 AM
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
  `client_id` int(11) DEFAULT NULL,
  `date_due` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_num`, `client`, `data`, `total`, `created_at`, `user_id`, `final`, `status`, `logo`, `client_id`, `date_due`) VALUES
(42, 'Invoice 1', NULL, '{\"_token\":\"DsQ6LdkVPAai5dBLeA8QeOeBW9EZ4qTubXyJKw5x\",\"id\":\"42\",\"invoice_num\":\"Invoice 1\",\"description\":null,\"date_issued\":\"2020-03-25\",\"date_due\":\"2020-03-25\",\"client\":null,\"reg_num\":null,\"address\":null,\"contact\":null,\"email\":null,\"phone\":null,\"exp_desc\":[null],\"exp_quan\":[\"1\"],\"exp_val\":[\"0\"],\"total_val\":\"0\",\"total\":\"0.00\",\"notes\":null,\"currency\":\"DKK\",\"submit\":\"draft\",\"logo\":{}}', '0.00', '2020-03-25 15:26:08', 1, 0, 'pending', '1585150082.png', NULL, '0000-00-00'),
(47, 'Invoice 1', NULL, '{\"client_id\":null,\"_token\":\"2vm16Tgvo20WeD3fSxhDRqnncTO6NyqpGEtO6Dtt\",\"invoice_num\":\"Invoice 1\",\"description\":null,\"date_issued\":\"2020-04-17\",\"date_due\":null,\"client\":null,\"reg_num\":null,\"address\":null,\"contact\":null,\"email\":null,\"phone\":null,\"exp_desc\":[null],\"exp_quan\":[\"1\"],\"exp_val\":[\"0\"],\"total_val\":\"0\",\"total\":\"0.00\",\"notes\":null,\"currency\":\"DKK\",\"submit\":\"send\"}', '0', '2020-04-17 15:45:52', 6, 1, 'pending', '', NULL, '0000-00-00'),
(48, 'Invoice 1', NULL, '{\"client_id\":null,\"_token\":\"Jr8NH8OCSp76mzsfuMqIaOWDaLqVyZQX209nOnWe\",\"invoice_num\":\"Invoice 1\",\"description\":\"asd\",\"date_issued\":\"2020-04-17\",\"date_due\":null,\"client\":null,\"reg_num\":null,\"address\":null,\"contact\":null,\"email\":null,\"phone\":null,\"exp_desc\":[null],\"exp_quan\":[\"1\"],\"exp_val\":[\"0\"],\"total_val\":\"0\",\"total\":\"0.00\",\"notes\":null,\"currency\":\"DKK\",\"submit\":\"send\"}', '0', '2020-04-17 15:56:11', 9, 1, 'pending', '', NULL, '0000-00-00'),
(49, 'Invoice 2', NULL, '{\"client_id\":null,\"_token\":\"nVzr0mLvrAPO5ifVG3oPzoZiCkCtcDSD2IREB0rd\",\"invoice_num\":\"Invoice 2\",\"description\":null,\"date_issued\":\"2020-04-20\",\"date_due\":null,\"client\":null,\"reg_num\":null,\"address\":null,\"contact\":null,\"email\":null,\"phone\":null,\"exp_desc\":[null],\"exp_quan\":[\"1\"],\"exp_val\":[\"120\"],\"total_val\":\"120\",\"total\":\"120.00\",\"notes\":null,\"currency\":\"DKK\",\"submit\":\"send\"}', '120', '2020-04-20 17:58:47', 1, 1, 'paid', '', NULL, '0000-00-00'),
(50, 'Invoice 3', NULL, '{\"client_id\":null,\"_token\":\"nVzr0mLvrAPO5ifVG3oPzoZiCkCtcDSD2IREB0rd\",\"invoice_num\":\"Invoice 3\",\"description\":null,\"date_issued\":\"2020-04-20\",\"date_due\":null,\"client\":null,\"reg_num\":null,\"address\":null,\"contact\":null,\"email\":null,\"phone\":null,\"exp_desc\":[null],\"exp_quan\":[\"1\"],\"exp_val\":[\"33329.68\"],\"total_val\":\"33329.68\",\"total\":\"33,329.68\",\"notes\":null,\"currency\":\"DKK\",\"submit\":\"send\"}', '33329.68', '2020-04-12 19:00:00', 1, 1, 'paid', '', NULL, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `data` text NOT NULL,
  `read` tinyint(4) NOT NULL DEFAULT 0,
  `url` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `data`, `read`, `url`, `created_at`, `updated_at`) VALUES
(1, 1, 'Invoice status changed', 'Invoice 2 status changed to paid', 1, '43', '2020-04-17 15:30:33', '2020-04-17 10:41:18'),
(2, 7, 'New User Registered', 'halima registered', 1, NULL, '2020-04-17 10:55:58', '2020-04-19 07:31:38'),
(3, 7, 'New Invoice Created', 'halima created new invoice.', 1, '48', '2020-04-17 10:56:11', '2020-04-17 10:57:55'),
(4, 7, 'New Invoice Created', 'Ahmed sss created new invoice.', 0, '49', '2020-04-20 12:58:47', '2020-04-20 12:58:47'),
(5, 7, 'New Invoice Created', 'Ahmed sss created new invoice.', 0, '50', '2020-04-20 12:59:01', '2020-04-20 12:59:01'),
(6, 7, 'New Invoice Created', 'Ahmed sss created new invoice.', 0, '51', '2020-04-24 15:44:12', '2020-04-24 15:44:12'),
(7, 7, 'New Invoice Created', 'Ahmed sss created new invoice.', 0, '52', '2020-04-24 16:03:18', '2020-04-24 16:03:18');

-- --------------------------------------------------------

--
-- Table structure for table `payment_for_registration`
--

CREATE TABLE `payment_for_registration` (
  `token` text NOT NULL,
  `plan_id` bigint(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL,
  `card` varchar(50) NOT NULL,
  `month` varchar(50) NOT NULL,
  `year` varchar(50) NOT NULL,
  `cvc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_for_registration`
--

INSERT INTO `payment_for_registration` (`token`, `plan_id`, `amount`, `status`, `card`, `month`, `year`, `cvc`) VALUES
('9xhWl4pl37GExIGMm719OqPAic4yMiWQyNJrVfYMrvNN1AoVn9TlFLGCrmT0', 2, '249.00', 'paid', '4242424242424242', '08', '2020', '254'),
('brrRk6T93A9T5Eva30DuPxOHMa41eDtV5vhlNm0d2f16lEfKIgE27qCW32oZ', 2, '249.00', 'paid', '4242424242424242', '08', '2020', '254'),
('uHa5YNTiIAXjd1itwxhzxV9gWyMOWbgus3vPw8aQLflrxNQ3Jx1VSOBRz3S3', 2, '249.00', 'paid', '4242424242424242', '09', '2020', '024'),
('e2hAr1aEdMinmcFXGjvgYZgpsY8V1typFSuOuY4xvo91IqEqJ6xKCukFI42R', 2, '249.00', 'paid', '4242424242424242', '09', '2020', '025'),
('DIoe7CaTQ0InWKjufRtG7cIq2NJgorc7xSKVfXISaNmwCRhkar03hC2IGxlS', 3, '399.00', 'paid', '4242424242424242', '09', '2020', '021'),
('xqDcOnkF4sNHGSVfpjI7qzUEkix9yIhYYuhwD0vkFtgGz9ghrebwpFj3OEPR', 2, '249.00', 'paid', '4242424242424242', '09', '2020', '025'),
('fE4aRrNKsmRRVszSiZ0oxIFW3weQiDK05uVIM6Rw9svRo4TnTneBDs8WpDqI', 2, '249.00', 'paid', '4242424242424242', '09', '2021', '015'),
('pKVQQgc4rkSoeiLLh4sJhnctqdL4CthNQsEm8Pf2RswtVuERt6Js1FnhFZGE', 4, '799.00', 'paid', '4242424242424242', '09', '2020', '265');

-- --------------------------------------------------------

--
-- Table structure for table `payment_histories`
--

CREATE TABLE `payment_histories` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `amount` bigint(20) NOT NULL,
  `card_number` bigint(20) NOT NULL,
  `cvc` bigint(20) NOT NULL,
  `month` bigint(20) NOT NULL,
  `year` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `plan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_histories`
--

INSERT INTO `payment_histories` (`id`, `user_id`, `amount`, `card_number`, `cvc`, `month`, `year`, `created_at`, `updated_at`, `plan_id`) VALUES
(1, 4, 30, 4242424242424242, 123, 11, 2020, '2020-04-05 09:40:06', '2020-04-11 09:36:17', 2),
(2, 5, 30, 4242424242424242, 522, 4, 2024, '2020-04-08 05:05:24', '2020-04-08 05:05:24', 0),
(3, 6, 249, 4242424242424242, 25, 9, 2020, '2020-04-11 04:28:37', '2020-04-11 09:36:23', 2),
(4, 6, 399, 4242424242424242, 21, 9, 2020, '2020-04-11 04:31:16', '2020-04-11 09:36:25', 2),
(5, 1, 0, 4242424242424242, 15, 5, 2020, '2020-04-13 09:34:19', '2020-04-13 09:34:19', 0),
(6, 1, 249, 4242424242424242, 25, 9, 2020, '2020-04-13 09:46:10', '2020-04-13 09:46:10', 0),
(7, 1, 249, 4242424242424242, 15, 9, 2021, '2020-04-13 09:48:07', '2020-04-13 09:48:07', 2),
(8, 1, 799, 4242424242424242, 265, 9, 2020, '2020-04-20 12:43:19', '2020-04-20 12:43:19', 4);

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` bigint(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `invoices` int(11) NOT NULL,
  `lists` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `title`, `amount`, `invoices`, `lists`) VALUES
(1, 'Spacedive Free', '0.00', 1, 'free Demo,Send 1st invoice for free,Secure payout for your eBooks,Full support & guidance,(No binding & no setup fee)'),
(2, 'Spacedive Starter', '249.00', 4, 'Get Started!,Send up to 4 invoices,Secure payout for your eBooks,Full support & guidance,(No binding & no setup fee)'),
(3, 'Spacedive Pro', '399.00', 8, 'Rockstar,Send up to 8 invoices,Secure payout for your eBooks,Full support & guidance,(No binding & no setup fee)'),
(4, 'Spacedive Xo', '799.00', 20, 'Super Pro,Send up to 20 invoices,Secure payout for your eBooks,Full support & guidance,(No binding & no setup fee)');

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
  `country` text NOT NULL,
  `card_number` varchar(50) DEFAULT NULL,
  `cvc` varchar(50) DEFAULT NULL,
  `ex_month` varchar(50) DEFAULT NULL,
  `ex_year` varchar(50) DEFAULT NULL,
  `plan_id` bigint(20) NOT NULL DEFAULT 1,
  `is_admin` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `email`, `number`, `password`, `created_at`, `dob`, `image`, `address`, `gender`, `aboutme`, `city`, `street`, `zipcode`, `country`, `card_number`, `cvc`, `ex_month`, `ex_year`, `plan_id`, `is_admin`) VALUES
(1, 'Ahmed sss', 'Butt', 'bahtasham@gmail.com', NULL, '$2y$10$giIKR6VSKtiCnDIftYh43OQ2kYYr7jOyh8k4/dZMNJnsJkwQmxzjm', '2020-03-16 10:15:38', '2020-03-18', '1584532226.jpeg', '1as', 'male', 'sdasdasd', '12', '12', '12', '12', '', '', '', '', 4, 0),
(6, 'Ahmed', 'Butt', 'admin@admin.com', 'asdasd', '$2y$10$ub4N1b3WTjSB03SWw419zee0QEf2R6Th5D9jgE8xVlCTW2LDijuuK', '2020-04-11 08:43:24', NULL, NULL, NULL, 'male', NULL, '', '', '', '', NULL, NULL, NULL, NULL, 3, 0),
(7, 'Admin', 'User', 'admin@spacedive.io', NULL, '$2y$10$ub4N1b3WTjSB03SWw419zee0QEf2R6Th5D9jgE8xVlCTW2LDijuuK', '2020-04-17 13:16:01', NULL, NULL, NULL, 'male', NULL, '', '', '', '', NULL, NULL, NULL, NULL, 1, 1),
(9, 'halima', 'sultan', 'halima@ertugul.com', '032456', '$2y$10$5z54Ey4cMB5Evpa5ClJtTuhhHrOuW9S8mG.PU7v/RyFTDKOK8SD0a', '2020-04-17 15:55:58', NULL, NULL, NULL, 'male', NULL, '', '', '', '', NULL, NULL, NULL, NULL, 1, 0);

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
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_histories`
--
ALTER TABLE `payment_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payment_histories`
--
ALTER TABLE `payment_histories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2020 at 02:41 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.3.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `currencyfair`
--

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `currencyFrom` varchar(5) NOT NULL,
  `currencyTo` varchar(5) NOT NULL,
  `amountSell` float NOT NULL,
  `amountBuy` float NOT NULL,
  `rate` float NOT NULL,
  `timePlaced` datetime NOT NULL DEFAULT current_timestamp(),
  `originatingCountry` varchar(5) NOT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'in_progress'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `userId`, `currencyFrom`, `currencyTo`, `amountSell`, `amountBuy`, `rate`, `timePlaced`, `originatingCountry`, `status`) VALUES
(1, 1, 'EUR', 'GBP', 1000, 747.1, 0.7471, '2020-11-17 00:58:27', 'FR', 'in_progress'),
(2, 1, 'INR', 'USD', 500, 150, 0.3, '2020-11-17 00:58:36', 'IN', 'in_progress'),
(3, 1, 'USD', 'EUR', 900, 200, 0.2, '2020-11-17 01:01:21', 'US', 'in_progress');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `last_login` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin123', 'Admin', '2020-11-17 08:11:41', '2020-11-16 02:22:27', '2020-11-16 09:20:30');

-- --------------------------------------------------------

--
-- Table structure for table `users_authentication`
--

CREATE TABLE `users_authentication` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expired_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `users_authentication`
--
ALTER TABLE `users_authentication`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users_authentication`
--
ALTER TABLE `users_authentication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2021 at 09:50 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `activity` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `time_log` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `activity`, `username`, `time_log`) VALUES
(1, 'Attempted Log in', 'melaniepev1', '2021-05-03 13:35:27'),
(2, 'Attempted Log in', 'melaniepev1', '2021-05-03 13:35:34'),
(3, 'Success Log in', 'root', '2021-05-03 13:35:39'),
(4, 'Logged out', 'root', '2021-05-03 13:35:40'),
(5, 'Attempted Log in', 'melaniepev1', '2021-05-03 13:42:28'),
(6, 'Success Log in', 'root', '2021-05-03 13:42:33'),
(7, 'Attempted Log in', 'jpmb0816', '2021-05-03 19:11:20'),
(8, 'Logged out', '', '2021-05-03 19:12:50'),
(9, 'Attempted Log in', 'jpmb0816', '2021-05-03 19:13:59'),
(10, 'Logged out', '', '2021-05-03 19:14:05'),
(11, 'Attempted Log in', 'jpmb0816', '2021-05-03 19:16:16'),
(12, 'Logged out', '', '2021-05-03 19:36:45'),
(13, 'Attempted Log in', 'jpmb0816', '2021-05-03 19:45:40'),
(14, 'Success Log in', 'jpmb0816', '2021-05-03 19:47:05'),
(15, 'Logged out', 'jpmb0816', '2021-05-03 19:47:14'),
(16, 'Attempted Log in', 'jpmb0816', '2021-05-03 19:47:40'),
(17, 'Success Log in', 'jpmb0816', '2021-05-03 19:47:49'),
(18, 'Logged out', 'jpmb0816', '2021-05-03 19:47:54'),
(19, 'Reset a Password', 'jpmb0816', '2021-05-03 19:50:05'),
(20, 'Attempted Log in', 'jpmb0816', '2021-05-03 19:50:15'),
(21, 'Success Log in', 'jpmb0816', '2021-05-03 19:50:20'),
(22, 'Logged out', 'jpmb0816', '2021-05-03 19:50:20');

-- --------------------------------------------------------

--
-- Table structure for table `code`
--

CREATE TABLE `code` (
  `id_code` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `code` varchar(6) NOT NULL,
  `created_at` datetime NOT NULL,
  `expiration` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `code`
--

INSERT INTO `code` (`id_code`, `user_id`, `code`, `created_at`, `expiration`) VALUES
(1, 8, 'eqshwj', '2021-05-03 20:45:12', '2021-05-03 20:50:12'),
(2, 8, 't91nfw', '2021-05-03 20:58:42', '2021-05-03 21:03:42'),
(3, 8, 'ctz84f', '2021-05-03 21:01:30', '2021-05-03 21:06:30'),
(4, 8, '6du4em', '2021-05-03 21:05:37', '2021-05-03 21:10:37'),
(5, 8, 'asxgkv', '2021-05-03 21:11:05', '2021-05-03 21:16:05'),
(6, 8, 'ajbkt2', '2021-05-03 21:35:35', '2021-05-03 21:40:35'),
(7, 8, 'q08r3c', '2021-05-03 21:42:29', '2021-05-03 21:47:29'),
(8, 9, '46pfzb', '2021-05-04 03:11:22', '2021-05-04 03:16:22'),
(9, 9, '1725bg', '2021-05-04 03:16:30', '2021-05-04 03:21:30'),
(10, 11, 'wiz9h2', '2021-05-04 03:45:40', '2021-05-04 03:50:40'),
(11, 11, 'b2gwh0', '2021-05-04 03:47:40', '2021-05-04 03:52:40'),
(12, 11, 'bfmzks', '2021-05-04 03:50:15', '2021-05-04 03:55:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(8, 'melaniepev1', '$2y$10$zlsXg.VjWXG2zJHDABIg7eTjcMa5c7AV3u7sXirP7QovWLLu0De0O', 'melaniepev@gmail.com', '2021-05-03 13:53:05'),
(11, 'jpmb0816', '8c202945672aa7aa741da7fdc18b93e4', 'johnpaulo.beyong0816@gmail.com', '2021-05-04 03:45:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `code`
--
ALTER TABLE `code`
  ADD PRIMARY KEY (`id_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `code`
--
ALTER TABLE `code`
  MODIFY `id_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

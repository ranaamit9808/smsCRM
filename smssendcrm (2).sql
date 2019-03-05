-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2019 at 08:05 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smssendcrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'deepika', '12cdeepi@gmail.com', '$2y$10$wens1nD0GwBHNJeVPs5VoOUQUUxPMEjjottZQBqx/R5YdJBGFRVDq', 'npIQK74mlHCnlhCmQAK4ypBx5kXRam', '2019-02-05 04:05:41', '2019-02-25 23:47:32');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `send_to` varchar(255) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `send_to`, `message`, `created_at`, `updated_at`) VALUES
(1, 7, '+91 93060 43593', 'test', '2019-02-05 07:36:30', '2019-02-05 07:36:30'),
(2, 7, '+91 93060 43593', 'test', '2019-02-05 07:38:29', '2019-02-05 07:38:29'),
(3, 7, '+91 93060 43593', 'test message', '2019-02-05 07:41:28', '2019-02-05 07:41:28'),
(4, 7, '+91 93060 43593', 'test message from smsCRM', '2019-02-05 07:43:16', '2019-02-05 07:43:16'),
(5, 7, '+91 93060 43593', 'TEST MESSAGE2 FROM SMSCRM', '2019-02-05 07:44:34', '2019-02-05 07:44:34'),
(6, 7, '+91 93060 43593', 'final test', '2019-02-05 07:46:29', '2019-02-05 07:46:29'),
(7, 1, '+91 93060 43593', 'test', '2019-02-06 10:26:56', '2019-02-06 10:26:56');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phones`
--

CREATE TABLE `phones` (
  `id` int(11) NOT NULL,
  `phone_number` bigint(20) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `assigned_from` date DEFAULT NULL,
  `assigned_till` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `phones`
--

INSERT INTO `phones` (`id`, `phone_number`, `status`, `user_id`, `assigned_from`, `assigned_till`, `created_at`, `updated_at`) VALUES
(6, 991234561113, 1, 3, '2019-02-10', '2019-02-28', '2019-02-26 06:44:57', '2019-02-26 06:44:57'),
(7, 99123456888, 1, 7, '2019-02-13', '2019-02-28', '2019-02-26 06:53:53', '2019-02-26 01:24:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` bigint(20) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `verified` int(11) NOT NULL DEFAULT '0' COMMENT 'verified=1',
  `deleted_at` int(11) DEFAULT NULL COMMENT 'deactivated=1',
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `birth_date`, `password`, `created_at`, `updated_at`, `verified`, `deleted_at`, `remember_token`) VALUES
(1, 'deepika', 'abc@gmail.com', 6757575776, '1995-10-10', '$2y$10$bT801YLZ4l4k4lI1C8jqFe0CEVY9lNXM2kxvDzOB1OCKbaHUMGxTm', '2019-02-04 20:11:19', '2019-02-04 20:11:19', 1, NULL, NULL),
(2, 'deep', 'abc1@gmail.com', 6757575776, '2019-02-20', '$2y$10$S/RhaKf2YjxzXJ70wTei9u7eZHp2fiJFdOE6s3HbfgeW1rQHnA81S', '2019-02-04 20:11:19', '2019-02-04 20:11:19', 0, NULL, 'L57K9z5ZY2JPA1UYrd28t8YFZh4yWMdkBAhmP8UKFdTDZQ4SZ1HKlsZIIAkd'),
(3, 'deep', 'abc2@gmail.com', 6757575776, NULL, '$2y$10$NbQpqTwPy2fwsG3yF.eIwe/5LffIwbpLXg.haEpE/fZ999TVYUZmq', '2019-02-04 20:11:19', '2019-02-05 04:43:53', 0, NULL, NULL),
(7, 'deepika', '12cdeepi@gmail.com', 3224242424, '1995-01-31', '$2y$10$NcnREQko1yiWVg06xT1V4e9le9VLb7ripM6i29tjW0x8l/OKGwInO', '2019-02-05 04:53:40', '2019-02-05 06:06:17', 1, NULL, 'RxTQqTCirOoZ20Paw4Rgjb9SC4z8YuToxmgvuXdPAWNK6W4EInjm2IPitvlA');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phones`
--
ALTER TABLE `phones`
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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phones`
--
ALTER TABLE `phones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

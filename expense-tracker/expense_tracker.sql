-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2026 at 05:08 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `expense_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `budgets`
--

CREATE TABLE `budgets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `color` varchar(7) DEFAULT '#6366f1',
  `icon` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `user_id`, `name`, `description`, `color`, `icon`, `created_at`) VALUES
(9, 2, 'Food & Dining', NULL, '#FF6B6B', 'utensils', '2026-06-18 18:04:54'),
(10, 2, 'Transportation', NULL, '#4ECDC4', 'car', '2026-06-18 18:04:54'),
(11, 2, 'Entertainment', NULL, '#FFE66D', 'film', '2026-06-18 18:04:54'),
(12, 2, 'Utilities', NULL, '#95E1D3', 'lightbulb', '2026-06-18 18:04:54'),
(13, 2, 'Health & Medical', NULL, '#FF6B9D', 'heart', '2026-06-18 18:04:54'),
(14, 2, 'Shopping', NULL, '#C06C84', 'shopping-bag', '2026-06-18 18:04:54'),
(15, 2, 'Education', NULL, '#6C5B7B', 'book', '2026-06-18 18:04:54'),
(16, 2, 'Other', NULL, '#A8DADC', 'tag', '2026-06-18 18:04:54'),
(17, 3, 'Food & Dining', NULL, '#FF6B6B', 'utensils', '2026-06-18 18:09:22'),
(18, 3, 'Transportation', NULL, '#4ECDC4', 'car', '2026-06-18 18:09:22'),
(19, 3, 'Entertainment', NULL, '#FFE66D', 'film', '2026-06-18 18:09:22'),
(20, 3, 'Utilities', NULL, '#95E1D3', 'lightbulb', '2026-06-18 18:09:22'),
(21, 3, 'Health & Medical', NULL, '#FF6B9D', 'heart', '2026-06-18 18:09:22'),
(22, 3, 'Shopping', NULL, '#C06C84', 'shopping-bag', '2026-06-18 18:09:22'),
(23, 3, 'Education', NULL, '#6C5B7B', 'book', '2026-06-18 18:09:22'),
(24, 3, 'Other', NULL, '#A8DADC', 'tag', '2026-06-18 18:09:22'),
(25, 4, 'Food & Dining', NULL, '#FF6B6B', 'utensils', '2026-06-18 18:19:06'),
(26, 4, 'Transportation', NULL, '#4ECDC4', 'car', '2026-06-18 18:19:06'),
(27, 4, 'Entertainment', NULL, '#FFE66D', 'film', '2026-06-18 18:19:06'),
(28, 4, 'Utilities', NULL, '#95E1D3', 'lightbulb', '2026-06-18 18:19:06'),
(29, 4, 'Health & Medical', NULL, '#FF6B9D', 'heart', '2026-06-18 18:19:06'),
(30, 4, 'Shopping', NULL, '#C06C84', 'shopping-bag', '2026-06-18 18:19:06'),
(31, 4, 'Education', NULL, '#6C5B7B', 'book', '2026-06-18 18:19:06'),
(32, 4, 'Other', NULL, '#A8DADC', 'tag', '2026-06-18 18:19:06'),
(33, 5, 'Food & Dining', NULL, '#FF6B6B', 'utensils', '2026-06-18 23:18:38'),
(34, 5, 'Transportation', NULL, '#4ECDC4', 'car', '2026-06-18 23:18:38'),
(35, 5, 'Entertainment', NULL, '#FFE66D', 'film', '2026-06-18 23:18:38'),
(36, 5, 'Utilities', NULL, '#95E1D3', 'lightbulb', '2026-06-18 23:18:38'),
(37, 5, 'Health & Medical', NULL, '#FF6B9D', 'heart', '2026-06-18 23:18:38'),
(38, 5, 'Shopping', NULL, '#C06C84', 'shopping-bag', '2026-06-18 23:18:38'),
(39, 5, 'Education', NULL, '#6C5B7B', 'book', '2026-06-18 23:18:38'),
(40, 5, 'Other', NULL, '#A8DADC', 'tag', '2026-06-18 23:18:38'),
(41, 6, 'Food & Dining', NULL, '#FF6B6B', 'utensils', '2026-06-19 12:12:34'),
(42, 6, 'Transportation', NULL, '#4ECDC4', 'car', '2026-06-19 12:12:34'),
(43, 6, 'Entertainment', NULL, '#FFE66D', 'film', '2026-06-19 12:12:34'),
(44, 6, 'Utilities', NULL, '#95E1D3', 'lightbulb', '2026-06-19 12:12:34'),
(45, 6, 'Health & Medical', NULL, '#FF6B9D', 'heart', '2026-06-19 12:12:34'),
(46, 6, 'Shopping', NULL, '#C06C84', 'shopping-bag', '2026-06-19 12:12:34'),
(47, 6, 'Education', NULL, '#6C5B7B', 'book', '2026-06-19 12:12:34'),
(48, 6, 'Other', NULL, '#A8DADC', 'tag', '2026-06-19 12:12:34'),
(49, 7, 'Food & Dining', NULL, '#FF6B6B', 'utensils', '2026-06-19 12:24:47'),
(50, 7, 'Transportation', NULL, '#4ECDC4', 'car', '2026-06-19 12:24:47'),
(51, 7, 'Entertainment', NULL, '#FFE66D', 'film', '2026-06-19 12:24:47'),
(52, 7, 'Utilities', NULL, '#95E1D3', 'lightbulb', '2026-06-19 12:24:47'),
(53, 7, 'Health & Medical', NULL, '#FF6B9D', 'heart', '2026-06-19 12:24:47'),
(54, 7, 'Shopping', NULL, '#C06C84', 'shopping-bag', '2026-06-19 12:24:47'),
(55, 7, 'Education', NULL, '#6C5B7B', 'book', '2026-06-19 12:24:47'),
(56, 7, 'Other', NULL, '#A8DADC', 'tag', '2026-06-19 12:24:47'),
(57, 8, 'Food & Dining', NULL, '#FF6B6B', 'utensils', '2026-06-19 12:25:01'),
(58, 8, 'Transportation', NULL, '#4ECDC4', 'car', '2026-06-19 12:25:01'),
(59, 8, 'Entertainment', NULL, '#FFE66D', 'film', '2026-06-19 12:25:01'),
(60, 8, 'Utilities', NULL, '#95E1D3', 'lightbulb', '2026-06-19 12:25:01'),
(61, 8, 'Health & Medical', NULL, '#FF6B9D', 'heart', '2026-06-19 12:25:01'),
(62, 8, 'Shopping', NULL, '#C06C84', 'shopping-bag', '2026-06-19 12:25:01'),
(63, 8, 'Education', NULL, '#6C5B7B', 'book', '2026-06-19 12:25:01'),
(64, 8, 'Other', NULL, '#A8DADC', 'tag', '2026-06-19 12:25:01'),
(65, 9, 'Food & Dining', NULL, '#FF6B6B', 'utensils', '2026-06-19 12:26:19'),
(66, 9, 'Transportation', NULL, '#4ECDC4', 'car', '2026-06-19 12:26:19'),
(67, 9, 'Entertainment', NULL, '#FFE66D', 'film', '2026-06-19 12:26:19'),
(68, 9, 'Utilities', NULL, '#95E1D3', 'lightbulb', '2026-06-19 12:26:19'),
(69, 9, 'Health & Medical', NULL, '#FF6B9D', 'heart', '2026-06-19 12:26:19'),
(70, 9, 'Shopping', NULL, '#C06C84', 'shopping-bag', '2026-06-19 12:26:19'),
(71, 9, 'Education', NULL, '#6C5B7B', 'book', '2026-06-19 12:26:19'),
(72, 9, 'Other', NULL, '#A8DADC', 'tag', '2026-06-19 12:26:19'),
(73, 10, 'Food & Dining', NULL, '#FF6B6B', 'utensils', '2026-06-19 14:27:16'),
(74, 10, 'Transportation', NULL, '#4ECDC4', 'car', '2026-06-19 14:27:16'),
(75, 10, 'Entertainment', NULL, '#FFE66D', 'film', '2026-06-19 14:27:16'),
(76, 10, 'Utilities', NULL, '#95E1D3', 'lightbulb', '2026-06-19 14:27:16'),
(77, 10, 'Health & Medical', NULL, '#FF6B9D', 'heart', '2026-06-19 14:27:16'),
(78, 10, 'Shopping', NULL, '#C06C84', 'shopping-bag', '2026-06-19 14:27:16'),
(79, 10, 'Education', NULL, '#6C5B7B', 'book', '2026-06-19 14:27:16'),
(80, 10, 'Other', NULL, '#A8DADC', 'tag', '2026-06-19 14:27:16'),
(81, 11, 'Food & Dining', NULL, '#FF6B6B', 'utensils', '2026-06-19 14:28:20'),
(82, 11, 'Transportation', NULL, '#4ECDC4', 'car', '2026-06-19 14:28:20'),
(83, 11, 'Entertainment', NULL, '#FFE66D', 'film', '2026-06-19 14:28:20'),
(84, 11, 'Utilities', NULL, '#95E1D3', 'lightbulb', '2026-06-19 14:28:20'),
(85, 11, 'Health & Medical', NULL, '#FF6B9D', 'heart', '2026-06-19 14:28:20'),
(86, 11, 'Shopping', NULL, '#C06C84', 'shopping-bag', '2026-06-19 14:28:20'),
(87, 11, 'Education', NULL, '#6C5B7B', 'book', '2026-06-19 14:28:20'),
(88, 11, 'Other', NULL, '#A8DADC', 'tag', '2026-06-19 14:28:20'),
(89, 12, 'Food & Dining', NULL, '#FF6B6B', 'utensils', '2026-06-19 14:33:06'),
(90, 12, 'Transportation', NULL, '#4ECDC4', 'car', '2026-06-19 14:33:06'),
(91, 12, 'Entertainment', NULL, '#FFE66D', 'film', '2026-06-19 14:33:06'),
(92, 12, 'Utilities', NULL, '#95E1D3', 'lightbulb', '2026-06-19 14:33:06'),
(93, 12, 'Health & Medical', NULL, '#FF6B9D', 'heart', '2026-06-19 14:33:06'),
(94, 12, 'Shopping', NULL, '#C06C84', 'shopping-bag', '2026-06-19 14:33:06'),
(95, 12, 'Education', NULL, '#6C5B7B', 'book', '2026-06-19 14:33:06'),
(96, 12, 'Other', NULL, '#A8DADC', 'tag', '2026-06-19 14:33:06');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `user_id`, `category_id`, `amount`, `description`, `date`, `payment_method`, `notes`, `created_at`, `updated_at`) VALUES
(1, 2, 9, 25.50, 'Lunch at restaurant', '2026-06-18', 'credit_card', '', '2026-06-18 18:21:25', '2026-06-18 18:21:25'),
(2, 4, 25, 25.50, 'Lunch', '2026-06-19', 'cash', '', '2026-06-18 18:30:49', '2026-06-18 18:30:49'),
(3, 5, 39, 5000.00, 'Payment for Tuition', '2026-06-18', 'cash', '', '2026-06-18 23:20:03', '2026-06-18 23:20:03'),
(4, 5, 37, 10000.00, 'Payment for Hospital Bills and Medicine needed', '2026-06-18', 'cash', '', '2026-06-18 23:21:58', '2026-06-18 23:21:58'),
(5, 5, 36, 5500.00, 'Payment for Electricity Bill', '2026-06-18', 'online', '', '2026-06-18 23:24:29', '2026-06-18 23:24:29'),
(6, 5, 38, 100000.00, 'Payment for Personal Belongings', '2026-06-18', 'credit_card', '', '2026-06-18 23:26:21', '2026-06-18 23:26:21'),
(7, 5, 34, 1800.00, 'Payment for Transportation', '2026-06-18', 'cash', '', '2026-06-19 01:01:36', '2026-06-19 01:01:36'),
(8, 5, 33, 8500.00, 'Lunch at Restaurant', '2026-06-19', 'online', '', '2026-06-19 01:03:14', '2026-06-19 01:03:14'),
(9, 5, 35, 890000.00, 'Entertainment Fee', '2026-06-19', 'debit_card', '', '2026-06-19 05:27:38', '2026-06-19 05:27:38'),
(10, 2, 11, 15.89, 'Movie Toy Story 5', '2026-06-18', 'online', 'SM Cinema', '2026-06-19 14:35:18', '2026-06-19 14:35:18'),
(11, 2, 15, 2000.00, 'Tuition Fee', '2026-06-17', 'cash', '', '2026-06-19 14:36:01', '2026-06-19 14:36:01');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expense_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `invoice_number` varchar(50) DEFAULT NULL,
  `vendor_name` varchar(100) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `user_id`, `expense_id`, `file_name`, `file_path`, `file_size`, `file_type`, `invoice_number`, `vendor_name`, `invoice_date`, `total_amount`, `uploaded_at`) VALUES
(1, 2, NULL, 'invoice_2_1781807086.pdf', '../uploads/invoices/invoice_2_1781807086.pdf', 78258, '0', 'INV-001', 'Restaurant Name', '2026-06-18', 25.50, '2026-06-18 18:24:46'),
(2, 5, NULL, 'invoice_5_1781831112.pdf', '../uploads/invoices/invoice_5_1781831112.pdf', 78258, '0', 'INV-001', 'Restaurant Name', '2026-06-18', 890009.00, '2026-06-19 01:05:12'),
(3, 5, NULL, 'invoice_5_1781832127.pdf', '../uploads/invoices/invoice_5_1781832127.pdf', 78258, '0', '', '', '2026-06-19', 0.00, '2026-06-19 01:22:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `phone`, `created_at`, `updated_at`) VALUES
(2, 'johnsmith', 'john@email.com', '$2y$12$ZIFz95V0c9q/9He7IWDcsuYI8/fsoENIeIq0RYnMhwR7fbNuMREoW', 'John Smith', '', '2026-06-18 18:04:54', '2026-06-18 18:04:54'),
(3, 'verifytest', 'verify@test.com', '$2y$12$kdJBrMO39jXtPePoI4CVEO6PyWhU6Z.xQ37x8BTNa8QT2j6sika1u', 'Verify Test', '', '2026-06-18 18:09:22', '2026-06-18 18:09:22'),
(4, 'newtest', 'newtest@test.com', '$2y$12$ZMGV9PaWXTXCzDqo55Kw9.AfAdPyCOx1AAZNvWFoG85r18S70JizS', 'New Test', '', '2026-06-18 18:19:06', '2026-06-18 18:19:06'),
(5, 'nikolai213123', 'nikolai@gmail.com', '$2y$12$fF99/B7zHjmkPcOilXxChumLHv/g9WGroF8OiBEGe3kW1iu6KCcaG', 'Nikolai', '', '2026-06-18 23:18:38', '2026-06-18 23:18:38'),
(6, 'testuser_demo_1', 'testuser_demo_1@example.com', '$2y$12$HAdmmuG3r2f3VwNgzsQeSefoMqyqasThe6/zXYNlGPgetne7oBw3S', 'Test User', '1234567890', '2026-06-19 12:12:34', '2026-06-19 12:12:34'),
(7, 'demo_user_2', 'demo_user_2@example.com', '$2y$12$sQ//F4Bh8IziximcGJirKuMDlvLPRgQXoM9g5uT7cqxmiiJCU/i1K', 'Demo User', '1234567890', '2026-06-19 12:24:47', '2026-06-19 12:24:47'),
(8, 'demo_user_3', 'demo_user_3@example.com', '$2y$12$l7NKrZlhlhEQzKyzmM0i1uX7XMZ6m2DZO34yAz3l902A4wpVPJFm6', 'Demo User', '1234567890', '2026-06-19 12:25:01', '2026-06-19 12:25:01'),
(9, 'schema_fix_user', 'schema_fix_user@example.com', '$2y$12$cYvE1DNgXthbT67U2VsNVuyUPt4gxMvuFT8iND9lPsb3X15Lu2lQO', 'Schema Fix User', '1234567890', '2026-06-19 12:26:19', '2026-06-19 12:26:19'),
(10, 'fetch_test_user', 'fetch_test_user@example.com', '$2y$12$6wOuvR4MXQjYR8oO6.sfouACWgp76oGc4AksU00yiP.sHbX9lPNlW', 'Fetch Test', '1234567890', '2026-06-19 14:27:16', '2026-06-19 14:27:16'),
(11, 'cors_user_1', 'cors_user_1@example.com', '$2y$12$rV3dsgswBqLW2IgPFU5g2epDERlFN2pRYHyu6f7fhSC/VguXxfcg6', 'Cors User', '1234567890', '2026-06-19 14:28:20', '2026-06-19 14:28:20'),
(12, 'Man123', 'man@gmail.com', '$2y$12$hvMpZ16BQrDaOkjVmKEA1eBgEkIZ65xqaTVOi8MblyaPLP0DfU1Rq', 'Man', '', '2026-06-19 14:33:06', '2026-06-19 14:33:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `budgets`
--
ALTER TABLE `budgets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `idx_user_date` (`user_id`,`date`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `expense_id` (`expense_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `budgets`
--
ALTER TABLE `budgets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `budgets`
--
ALTER TABLE `budgets`
  ADD CONSTRAINT `budgets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `budgets_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenses_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoices_ibfk_2` FOREIGN KEY (`expense_id`) REFERENCES `expenses` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

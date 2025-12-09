-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2025 at 01:59 PM
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
-- Table structure for table `approval_records`
--

CREATE TABLE `approval_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `expense_id` bigint(20) UNSIGNED NOT NULL,
  `approved_by` bigint(20) UNSIGNED NOT NULL,
  `decision` enum('approved','rejected') NOT NULL,
  `remarks` text DEFAULT NULL,
  `decision_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `approval_records`
--

INSERT INTO `approval_records` (`id`, `expense_id`, `approved_by`, `decision`, `remarks`, `decision_date`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'approved', NULL, '2025-11-01 04:52:01', '2025-11-01 04:52:01', '2025-11-01 04:52:01'),
(2, 2, 2, 'approved', NULL, '2025-11-01 04:52:30', '2025-11-01 04:52:30', '2025-11-01 04:52:30'),
(3, 3, 2, 'approved', NULL, '2025-11-01 04:52:32', '2025-11-01 04:52:32', '2025-11-01 04:52:32'),
(4, 4, 2, 'approved', NULL, '2025-11-01 04:53:04', '2025-11-01 04:53:04', '2025-11-01 04:53:04'),
(5, 5, 1, 'approved', NULL, '2025-11-01 06:19:17', '2025-11-01 06:19:17', '2025-11-01 06:19:17'),
(6, 6, 1, 'rejected', 'we', '2025-11-01 06:30:45', '2025-11-01 06:30:45', '2025-11-01 06:30:45'),
(7, 7, 1, 'rejected', NULL, '2025-11-01 06:36:14', '2025-11-01 06:36:14', '2025-11-01 06:36:14'),
(8, 8, 1, 'approved', NULL, '2025-11-03 20:13:05', '2025-11-03 20:13:05', '2025-11-03 20:13:05'),
(9, 9, 2, 'rejected', 'ulit ulit??', '2025-11-05 17:49:41', '2025-11-05 17:49:41', '2025-11-05 17:49:41'),
(10, 10, 2, 'approved', NULL, '2025-11-05 17:49:49', '2025-11-05 17:49:49', '2025-11-05 17:49:49'),
(11, 11, 2, 'approved', NULL, '2025-11-20 00:32:33', '2025-11-20 00:32:33', '2025-11-20 00:32:33'),
(12, 13, 1, 'rejected', 'ulit ulit??', '2025-11-20 01:00:54', '2025-11-20 01:00:54', '2025-11-20 01:00:54'),
(13, 14, 2, 'approved', NULL, '2025-11-20 01:42:51', '2025-11-20 01:42:51', '2025-11-20 01:42:51'),
(14, 15, 2, 'rejected', NULL, '2025-11-20 01:50:56', '2025-11-20 01:50:56', '2025-11-20 01:50:56');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `ip_address` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `model_type`, `model_id`, `old_values`, `new_values`, `ip_address`, `description`, `created_at`, `updated_at`) VALUES
(1, 3, 'created', 'App\\Models\\Expense', 1, NULL, '{\"category_id\":\"2\",\"title\":\"Gran Fare\",\"description\":\"Travel cost for meeting with client in Makati.\",\"amount\":\"450.00\",\"expense_date\":\"2025-08-07T00:00:00.000000Z\",\"notes\":null,\"user_id\":3,\"status\":\"pending\",\"updated_at\":\"2025-11-01T12:36:14.000000Z\",\"created_at\":\"2025-11-01T12:36:14.000000Z\",\"id\":1}', '127.0.0.1', 'Expense \'Gran Fare\' created for ₱450.00', '2025-11-01 04:36:14', '2025-11-01 04:36:14'),
(2, 3, 'created', 'App\\Models\\Expense', 2, NULL, '{\"category_id\":\"4\",\"title\":\"Laptop Repair\",\"description\":\"Replacement of damaged laptop battery\",\"amount\":\"3000.00\",\"expense_date\":\"2025-08-01T00:00:00.000000Z\",\"notes\":null,\"user_id\":3,\"status\":\"pending\",\"updated_at\":\"2025-11-01T12:37:09.000000Z\",\"created_at\":\"2025-11-01T12:37:09.000000Z\",\"id\":2}', '127.0.0.1', 'Expense \'Laptop Repair\' created for ₱3,000.00', '2025-11-01 04:37:09', '2025-11-01 04:37:09'),
(3, 3, 'created', 'App\\Models\\Expense', 3, NULL, '{\"category_id\":\"3\",\"title\":\"Team Lunch\",\"description\":\"Lunch out for staff after project completion.\",\"amount\":\"2000.00\",\"expense_date\":\"2025-10-01T00:00:00.000000Z\",\"notes\":null,\"user_id\":3,\"status\":\"pending\",\"updated_at\":\"2025-11-01T12:38:20.000000Z\",\"created_at\":\"2025-11-01T12:38:20.000000Z\",\"id\":3}', '127.0.0.1', 'Expense \'Team Lunch\' created for ₱2,000.00', '2025-11-01 04:38:20', '2025-11-01 04:38:20'),
(4, 1, 'updated', 'App\\Models\\Category', 3, '{\"id\":3,\"name\":\"Meals\",\"description\":\"Food and dining expenses\",\"monthly_limit\":\"2000.00\",\"is_active\":true,\"created_at\":\"2025-11-01T12:33:21.000000Z\",\"updated_at\":\"2025-11-01T12:33:21.000000Z\"}', '{\"id\":3,\"name\":\"Ma\",\"description\":\"Food and dining expenses\",\"monthly_limit\":\"2000.00\",\"is_active\":true,\"created_at\":\"2025-11-01T12:33:21.000000Z\",\"updated_at\":\"2025-11-01T12:39:43.000000Z\"}', '127.0.0.1', 'Category \'Ma\' updated', '2025-11-01 04:39:43', '2025-11-01 04:39:43'),
(5, 1, 'created', 'App\\Models\\Category', 5, NULL, '{\"name\":\"Travel\",\"description\":\"Business trips, lodging, or airfare for company activities.\",\"monthly_limit\":\"12000.00\",\"is_active\":true,\"updated_at\":\"2025-11-01T12:41:16.000000Z\",\"created_at\":\"2025-11-01T12:41:16.000000Z\",\"id\":5}', '127.0.0.1', 'Category \'Travel\' created', '2025-11-01 04:41:16', '2025-11-01 04:41:16'),
(6, 1, 'updated', 'App\\Models\\Category', 3, '{\"id\":3,\"name\":\"Ma\",\"description\":\"Food and dining expenses\",\"monthly_limit\":\"2000.00\",\"is_active\":true,\"created_at\":\"2025-11-01T12:33:21.000000Z\",\"updated_at\":\"2025-11-01T12:39:43.000000Z\"}', '{\"id\":3,\"name\":\"Meals\",\"description\":\"Food and dining expenses\",\"monthly_limit\":\"2000.00\",\"is_active\":true,\"created_at\":\"2025-11-01T12:33:21.000000Z\",\"updated_at\":\"2025-11-01T12:41:33.000000Z\"}', '127.0.0.1', 'Category \'Meals\' updated', '2025-11-01 04:41:33', '2025-11-01 04:41:33'),
(7, 3, 'created', 'App\\Models\\Expense', 4, NULL, '{\"category_id\":\"1\",\"title\":\"Printer Ink & Paper\",\"description\":\"Purchase of printing materials for reports and forms.\",\"amount\":\"1200.00\",\"expense_date\":\"2025-07-06T00:00:00.000000Z\",\"notes\":null,\"user_id\":3,\"status\":\"pending\",\"updated_at\":\"2025-11-01T12:43:00.000000Z\",\"created_at\":\"2025-11-01T12:43:00.000000Z\",\"id\":4}', '127.0.0.1', 'Expense \'Printer Ink & Paper\' created for ₱1,200.00', '2025-11-01 04:43:00', '2025-11-01 04:43:00'),
(8, 3, 'updated', 'App\\Models\\Expense', 1, '{\"id\":1,\"user_id\":3,\"category_id\":2,\"title\":\"Gran Fare\",\"description\":\"Travel cost for meeting with client in Makati.\",\"amount\":\"450.00\",\"expense_date\":\"2025-08-07T00:00:00.000000Z\",\"status\":\"pending\",\"receipt_path\":null,\"notes\":null,\"created_at\":\"2025-11-01T12:36:14.000000Z\",\"updated_at\":\"2025-11-01T12:36:14.000000Z\",\"deleted_at\":null}', '{\"id\":1,\"user_id\":3,\"category_id\":2,\"title\":\"Grab\\/Taxi Fare\",\"description\":\"Travel cost for meeting with client in Makati.\",\"amount\":\"450.00\",\"expense_date\":\"2025-08-07T00:00:00.000000Z\",\"status\":\"pending\",\"receipt_path\":null,\"notes\":null,\"created_at\":\"2025-11-01T12:36:14.000000Z\",\"updated_at\":\"2025-11-01T12:43:26.000000Z\",\"deleted_at\":null}', '127.0.0.1', 'Expense \'Grab/Taxi Fare\' updated', '2025-11-01 04:43:26', '2025-11-01 04:43:26'),
(9, 3, 'created', 'App\\Models\\Expense', 5, NULL, '{\"category_id\":\"2\",\"title\":\"Gasoline\",\"description\":\"Fuel refill for company car used in deliveries.\",\"amount\":\"2300.00\",\"expense_date\":\"2025-09-03T00:00:00.000000Z\",\"notes\":null,\"user_id\":3,\"status\":\"pending\",\"updated_at\":\"2025-11-01T12:44:02.000000Z\",\"created_at\":\"2025-11-01T12:44:02.000000Z\",\"id\":5}', '127.0.0.1', 'Expense \'Gasoline\' created for ₱2,300.00', '2025-11-01 04:44:02', '2025-11-01 04:44:02'),
(10, 3, 'created', 'App\\Models\\Expense', 6, NULL, '{\"category_id\":\"3\",\"title\":\"Client Meeting Snacks\",\"description\":\"Coffee and snacks served during client presentation.\",\"amount\":\"800.00\",\"expense_date\":\"2025-08-17T00:00:00.000000Z\",\"notes\":null,\"user_id\":3,\"status\":\"pending\",\"updated_at\":\"2025-11-01T12:46:32.000000Z\",\"created_at\":\"2025-11-01T12:46:32.000000Z\",\"id\":6}', '127.0.0.1', 'Expense \'Client Meeting Snacks\' created for ₱800.00', '2025-11-01 04:46:32', '2025-11-01 04:46:32'),
(11, 3, 'created', 'App\\Models\\Expense', 7, NULL, '{\"category_id\":\"1\",\"title\":\"Office chairs\",\"description\":\"New ergonomic chair for accounting staff.\",\"amount\":\"4800.00\",\"expense_date\":\"2025-11-01T00:00:00.000000Z\",\"notes\":null,\"user_id\":3,\"status\":\"pending\",\"updated_at\":\"2025-11-01T12:51:30.000000Z\",\"created_at\":\"2025-11-01T12:51:30.000000Z\",\"id\":7}', '127.0.0.1', 'Expense \'Office chairs\' created for ₱4,800.00', '2025-11-01 04:51:30', '2025-11-01 04:51:30'),
(12, 2, 'approved', 'App\\Models\\Expense', 1, '{\"status\":\"pending\"}', '{\"status\":\"approved\"}', '127.0.0.1', 'Expense \'Grab/Taxi Fare\' approved by Finance Staff', '2025-11-01 04:52:01', '2025-11-01 04:52:01'),
(13, 2, 'approved', 'App\\Models\\Expense', 2, '{\"status\":\"pending\"}', '{\"status\":\"approved\"}', '127.0.0.1', 'Expense \'Laptop Repair\' approved by Finance Staff', '2025-11-01 04:52:30', '2025-11-01 04:52:30'),
(14, 2, 'approved', 'App\\Models\\Expense', 3, '{\"status\":\"pending\"}', '{\"status\":\"approved\"}', '127.0.0.1', 'Expense \'Team Lunch\' approved by Finance Staff', '2025-11-01 04:52:32', '2025-11-01 04:52:32'),
(15, 2, 'approved', 'App\\Models\\Expense', 4, '{\"status\":\"pending\"}', '{\"status\":\"approved\"}', '127.0.0.1', 'Expense \'Printer Ink & Paper\' approved by Finance Staff', '2025-11-01 04:53:04', '2025-11-01 04:53:04'),
(16, 1, 'created', 'App\\Models\\Category', 6, NULL, '{\"name\":\"Utilities\",\"description\":\"Monthly expenses for electricity, water, and internet.\",\"monthly_limit\":\"6000.00\",\"is_active\":true,\"updated_at\":\"2025-11-01T12:54:14.000000Z\",\"created_at\":\"2025-11-01T12:54:14.000000Z\",\"id\":6}', '127.0.0.1', 'Category \'Utilities\' created', '2025-11-01 04:54:14', '2025-11-01 04:54:14'),
(17, 1, 'approved', 'App\\Models\\Expense', 5, '{\"status\":\"pending\"}', '{\"status\":\"approved\"}', '127.0.0.1', 'Expense \'Gasoline\' approved by Admin User', '2025-11-01 06:19:17', '2025-11-01 06:19:17'),
(18, 1, 'rejected', 'App\\Models\\Expense', 6, '{\"status\":\"pending\"}', '{\"status\":\"rejected\"}', '127.0.0.1', 'Expense \'Client Meeting Snacks\' rejected by Admin User', '2025-11-01 06:30:45', '2025-11-01 06:30:45'),
(19, 1, 'rejected', 'App\\Models\\Expense', 7, '{\"status\":\"pending\"}', '{\"status\":\"rejected\"}', '127.0.0.1', 'Expense \'Office chairs\' rejected by Admin User', '2025-11-01 06:36:14', '2025-11-01 06:36:14'),
(20, 3, 'created', 'App\\Models\\Expense', 8, NULL, '{\"category_id\":\"2\",\"title\":\"taxi fare\",\"description\":\"morning commute home to office\",\"amount\":\"500.00\",\"expense_date\":\"2025-11-03T00:00:00.000000Z\",\"notes\":\"499\",\"user_id\":3,\"status\":\"pending\",\"updated_at\":\"2025-11-03T11:45:41.000000Z\",\"created_at\":\"2025-11-03T11:45:41.000000Z\",\"id\":8}', '127.0.0.1', 'Expense \'taxi fare\' created for ₱500.00', '2025-11-03 03:45:41', '2025-11-03 03:45:41'),
(21, 3, 'updated', 'App\\Models\\Expense', 8, '{\"id\":8,\"user_id\":3,\"category_id\":2,\"title\":\"taxi fare\",\"description\":\"morning commute home to office\",\"amount\":\"500.00\",\"expense_date\":\"2025-11-03T00:00:00.000000Z\",\"status\":\"pending\",\"receipt_path\":null,\"notes\":\"499\",\"created_at\":\"2025-11-03T11:45:41.000000Z\",\"updated_at\":\"2025-11-03T11:45:41.000000Z\",\"deleted_at\":null}', '{\"id\":8,\"user_id\":3,\"category_id\":2,\"title\":\"Taxi fare\",\"description\":\"morning commute home to office\",\"amount\":\"500.00\",\"expense_date\":\"2025-11-03T00:00:00.000000Z\",\"status\":\"pending\",\"receipt_path\":null,\"notes\":\"499\",\"created_at\":\"2025-11-03T11:45:41.000000Z\",\"updated_at\":\"2025-11-03T11:46:00.000000Z\",\"deleted_at\":null}', '127.0.0.1', 'Expense \'Taxi fare\' updated', '2025-11-03 03:46:00', '2025-11-03 03:46:00'),
(22, 1, 'approved', 'App\\Models\\Expense', 8, '{\"status\":\"pending\"}', '{\"status\":\"approved\"}', '127.0.0.1', 'Expense \'Taxi fare\' approved by Admin User', '2025-11-03 20:13:05', '2025-11-03 20:13:05'),
(23, 3, 'created', 'App\\Models\\Expense', 9, NULL, '{\"category_id\":\"3\",\"title\":\"lunch meeting\",\"description\":\"for 10 people\",\"amount\":\"1500.00\",\"expense_date\":\"2025-11-06T00:00:00.000000Z\",\"notes\":\"totoo to hindi kita tinatarantado\",\"user_id\":3,\"status\":\"pending\",\"receipt_path\":\"receipts\\/xCg74Sjz4GeLyHEzltz1NPPPLPWQ3Knwu8euXuBG.png\",\"updated_at\":\"2025-11-06T01:47:42.000000Z\",\"created_at\":\"2025-11-06T01:47:42.000000Z\",\"id\":9}', '127.0.0.1', 'Expense \'lunch meeting\' created for ₱1,500.00', '2025-11-05 17:47:42', '2025-11-05 17:47:42'),
(24, 3, 'created', 'App\\Models\\Expense', 10, NULL, '{\"category_id\":\"3\",\"title\":\"lunch meeting\",\"description\":\"for 10 people\",\"amount\":\"1500.00\",\"expense_date\":\"2025-11-06T00:00:00.000000Z\",\"notes\":\"totoo to hindi kita tinatarantado\",\"user_id\":3,\"status\":\"pending\",\"receipt_path\":\"receipts\\/XnbwfA7GAVWgB9Ikn08SUbEhWwYxHIm1wWNGRXpb.png\",\"updated_at\":\"2025-11-06T01:47:45.000000Z\",\"created_at\":\"2025-11-06T01:47:45.000000Z\",\"id\":10}', '127.0.0.1', 'Expense \'lunch meeting\' created for ₱1,500.00', '2025-11-05 17:47:45', '2025-11-05 17:47:45'),
(25, 3, 'updated', 'App\\Models\\Expense', 10, '{\"id\":10,\"user_id\":3,\"category_id\":3,\"title\":\"lunch meeting\",\"description\":\"for 10 people\",\"amount\":\"1500.00\",\"expense_date\":\"2025-11-06T00:00:00.000000Z\",\"status\":\"pending\",\"receipt_path\":\"receipts\\/XnbwfA7GAVWgB9Ikn08SUbEhWwYxHIm1wWNGRXpb.png\",\"notes\":\"totoo to hindi kita tinatarantado\",\"created_at\":\"2025-11-06T01:47:45.000000Z\",\"updated_at\":\"2025-11-06T01:47:45.000000Z\",\"deleted_at\":null}', '{\"id\":10,\"user_id\":3,\"category_id\":3,\"title\":\"lunch meeting\",\"description\":\"for 10 people\",\"amount\":\"1600.00\",\"expense_date\":\"2025-11-06T00:00:00.000000Z\",\"status\":\"pending\",\"receipt_path\":\"receipts\\/XnbwfA7GAVWgB9Ikn08SUbEhWwYxHIm1wWNGRXpb.png\",\"notes\":\"totoo to hindi kita tinatarantado\",\"created_at\":\"2025-11-06T01:47:45.000000Z\",\"updated_at\":\"2025-11-06T01:48:09.000000Z\",\"deleted_at\":null}', '127.0.0.1', 'Expense \'lunch meeting\' updated', '2025-11-05 17:48:09', '2025-11-05 17:48:09'),
(26, 2, 'rejected', 'App\\Models\\Expense', 9, '{\"status\":\"pending\"}', '{\"status\":\"rejected\"}', '127.0.0.1', 'Expense \'lunch meeting\' rejected by Finance Staff', '2025-11-05 17:49:41', '2025-11-05 17:49:41'),
(27, 2, 'approved', 'App\\Models\\Expense', 10, '{\"status\":\"pending\"}', '{\"status\":\"approved\"}', '127.0.0.1', 'Expense \'lunch meeting\' approved by Finance Staff', '2025-11-05 17:49:49', '2025-11-05 17:49:49'),
(28, 1, 'created', 'App\\Models\\Category', 7, NULL, '{\"name\":\"panggago\",\"description\":\"mga kasinungalingan\",\"monthly_limit\":\"10000.00\",\"is_active\":false,\"updated_at\":\"2025-11-06T01:53:30.000000Z\",\"created_at\":\"2025-11-06T01:53:30.000000Z\",\"id\":7}', '127.0.0.1', 'Category \'panggago\' created', '2025-11-05 17:53:30', '2025-11-05 17:53:30'),
(29, 1, 'deleted', 'App\\Models\\Category', 7, '{\"id\":7,\"name\":\"panggago\",\"description\":\"mga kasinungalingan\",\"monthly_limit\":\"10000.00\",\"is_active\":false,\"created_at\":\"2025-11-06T01:53:30.000000Z\",\"updated_at\":\"2025-11-06T01:53:30.000000Z\"}', NULL, '127.0.0.1', 'Category \'panggago\' deleted', '2025-11-05 17:54:57', '2025-11-05 17:54:57'),
(30, 3, 'created', 'App\\Models\\Expense', 11, NULL, '{\"category_id\":\"1\",\"title\":\"Office Supplies Purchase\",\"amount\":\"1500.00\",\"expense_date\":\"2025-11-02T00:00:00.000000Z\",\"notes\":\"Purchased pens, paper, and folders for the accounting department.\",\"user_id\":3,\"status\":\"pending\",\"updated_at\":\"2025-11-06T12:53:53.000000Z\",\"created_at\":\"2025-11-06T12:53:53.000000Z\",\"id\":11}', '127.0.0.1', 'Expense \'Office Supplies Purchase\' created for ₱1,500.00', '2025-11-06 04:53:53', '2025-11-06 04:53:53'),
(31, 3, 'updated', 'App\\Models\\Expense', 11, '{\"id\":11,\"user_id\":3,\"category_id\":1,\"title\":\"Office Supplies Purchase\",\"description\":null,\"amount\":\"1500.00\",\"expense_date\":\"2025-11-02T00:00:00.000000Z\",\"status\":\"pending\",\"receipt_path\":null,\"notes\":\"Purchased pens, paper, and folders for the accounting department.\",\"created_at\":\"2025-11-06T12:53:53.000000Z\",\"updated_at\":\"2025-11-06T12:53:53.000000Z\",\"deleted_at\":null}', '{\"id\":11,\"user_id\":3,\"category_id\":1,\"title\":\"Office Supplies Purchase\",\"description\":\"Purchased pens, paper, and folders for the accounting department.\",\"amount\":\"1500.00\",\"expense_date\":\"2025-11-02T00:00:00.000000Z\",\"status\":\"pending\",\"receipt_path\":null,\"notes\":null,\"created_at\":\"2025-11-06T12:53:53.000000Z\",\"updated_at\":\"2025-11-06T12:54:21.000000Z\",\"deleted_at\":null}', '127.0.0.1', 'Expense \'Office Supplies Purchase\' updated.', '2025-11-06 04:54:22', '2025-11-06 04:54:22'),
(32, 2, 'approved', 'App\\Models\\Expense', 11, '{\"status\":\"pending\"}', '{\"status\":\"approved\"}', '127.0.0.1', 'Expense \'Office Supplies Purchase\' approved by Finance Staff', '2025-11-20 00:32:33', '2025-11-20 00:32:33'),
(33, 1, 'created', 'App\\Models\\Expense', 12, NULL, '{\"category_id\":\"6\",\"title\":\"Electricity Bill\",\"amount\":\"4500.00\",\"expense_date\":\"2025-02-11T00:00:00.000000Z\",\"notes\":null,\"user_id\":1,\"status\":\"pending\",\"updated_at\":\"2025-11-20T08:47:29.000000Z\",\"created_at\":\"2025-11-20T08:47:29.000000Z\",\"id\":12}', '127.0.0.1', 'Expense \'Electricity Bill\' created for ₱4,500.00', '2025-11-20 00:47:29', '2025-11-20 00:47:29'),
(34, 3, 'created', 'App\\Models\\Expense', 13, NULL, '{\"category_id\":\"6\",\"title\":\"Electricity Bill\",\"amount\":\"4500.00\",\"expense_date\":\"2025-10-02T00:00:00.000000Z\",\"notes\":null,\"user_id\":3,\"status\":\"pending\",\"updated_at\":\"2025-11-20T08:50:47.000000Z\",\"created_at\":\"2025-11-20T08:50:47.000000Z\",\"id\":13}', '127.0.0.1', 'Expense \'Electricity Bill\' created for ₱4,500.00', '2025-11-20 00:50:47', '2025-11-20 00:50:47'),
(35, 3, 'updated', 'App\\Models\\Expense', 13, '{\"id\":13,\"user_id\":3,\"category_id\":6,\"title\":\"Electricity Bill\",\"description\":null,\"amount\":\"4500.00\",\"expense_date\":\"2025-10-02T00:00:00.000000Z\",\"status\":\"pending\",\"receipt_path\":null,\"notes\":null,\"created_at\":\"2025-11-20T08:50:47.000000Z\",\"updated_at\":\"2025-11-20T08:50:47.000000Z\",\"deleted_at\":null}', '{\"id\":13,\"user_id\":3,\"category_id\":6,\"title\":\"Electricity Bill\",\"description\":\"1 month electricity expenses\",\"amount\":\"4500.00\",\"expense_date\":\"2025-10-02T00:00:00.000000Z\",\"status\":\"pending\",\"receipt_path\":null,\"notes\":null,\"created_at\":\"2025-11-20T08:50:47.000000Z\",\"updated_at\":\"2025-11-20T08:59:16.000000Z\",\"deleted_at\":null}', '127.0.0.1', 'Expense \'Electricity Bill\' updated.', '2025-11-20 00:59:16', '2025-11-20 00:59:16'),
(36, 3, 'updated', 'App\\Models\\Expense', 13, '{\"id\":13,\"user_id\":3,\"category_id\":6,\"title\":\"Electricity Bill\",\"description\":\"1 month electricity expenses\",\"amount\":\"4500.00\",\"expense_date\":\"2025-10-02T00:00:00.000000Z\",\"status\":\"pending\",\"receipt_path\":null,\"notes\":null,\"created_at\":\"2025-11-20T08:50:47.000000Z\",\"updated_at\":\"2025-11-20T08:59:16.000000Z\",\"deleted_at\":null}', '{\"id\":13,\"user_id\":3,\"category_id\":6,\"title\":\"Electricity Bill\",\"description\":\"1 month electricity expenses\",\"amount\":\"4500.00\",\"expense_date\":\"2025-10-02T00:00:00.000000Z\",\"status\":\"pending\",\"receipt_path\":null,\"notes\":null,\"created_at\":\"2025-11-20T08:50:47.000000Z\",\"updated_at\":\"2025-11-20T08:59:16.000000Z\",\"deleted_at\":null}', '127.0.0.1', 'Expense \'Electricity Bill\' updated.', '2025-11-20 00:59:18', '2025-11-20 00:59:18'),
(37, 1, 'updated', 'App\\Models\\Expense', 12, '{\"id\":12,\"user_id\":1,\"category_id\":6,\"title\":\"Electricity Bill\",\"description\":null,\"amount\":\"4500.00\",\"expense_date\":\"2025-02-11T00:00:00.000000Z\",\"status\":\"pending\",\"receipt_path\":null,\"notes\":null,\"created_at\":\"2025-11-20T08:47:29.000000Z\",\"updated_at\":\"2025-11-20T08:47:29.000000Z\",\"deleted_at\":null}', '{\"id\":12,\"user_id\":1,\"category_id\":6,\"title\":\"Electricity Bill\",\"description\":\"1 month bill\",\"amount\":\"4500.00\",\"expense_date\":\"2025-11-20T00:00:00.000000Z\",\"status\":\"pending\",\"receipt_path\":null,\"notes\":null,\"created_at\":\"2025-11-20T08:47:29.000000Z\",\"updated_at\":\"2025-11-20T09:00:11.000000Z\",\"deleted_at\":null}', '127.0.0.1', 'Expense \'Electricity Bill\' updated.', '2025-11-20 01:00:11', '2025-11-20 01:00:11'),
(38, 1, 'rejected', 'App\\Models\\Expense', 13, '{\"status\":\"pending\"}', '{\"status\":\"rejected\"}', '127.0.0.1', 'Expense \'Electricity Bill\' rejected by Admin User', '2025-11-20 01:00:54', '2025-11-20 01:00:54'),
(39, 8, 'created', 'App\\Models\\Expense', 14, NULL, '{\"category_id\":\"3\",\"title\":\"kath\",\"amount\":\"120.00\",\"expense_date\":\"2025-11-20T00:00:00.000000Z\",\"notes\":null,\"user_id\":8,\"status\":\"pending\",\"updated_at\":\"2025-11-20T09:41:10.000000Z\",\"created_at\":\"2025-11-20T09:41:10.000000Z\",\"id\":14}', '127.0.0.1', 'Expense \'kath\' created for ₱120.00', '2025-11-20 01:41:11', '2025-11-20 01:41:11'),
(40, 8, 'updated', 'App\\Models\\Expense', 14, '{\"id\":14,\"user_id\":8,\"category_id\":3,\"title\":\"kath\",\"description\":null,\"amount\":\"120.00\",\"expense_date\":\"2025-11-20T00:00:00.000000Z\",\"status\":\"pending\",\"receipt_path\":null,\"notes\":null,\"created_at\":\"2025-11-20T09:41:10.000000Z\",\"updated_at\":\"2025-11-20T09:41:10.000000Z\",\"deleted_at\":null}', '{\"id\":14,\"user_id\":8,\"category_id\":3,\"title\":\"kath\",\"description\":\"hakdog\",\"amount\":\"121.00\",\"expense_date\":\"2025-11-20T00:00:00.000000Z\",\"status\":\"pending\",\"receipt_path\":null,\"notes\":null,\"created_at\":\"2025-11-20T09:41:10.000000Z\",\"updated_at\":\"2025-11-20T09:41:45.000000Z\",\"deleted_at\":null}', '127.0.0.1', 'Expense \'kath\' updated.', '2025-11-20 01:41:45', '2025-11-20 01:41:45'),
(41, 2, 'approved', 'App\\Models\\Expense', 14, '{\"status\":\"pending\"}', '{\"status\":\"approved\"}', '127.0.0.1', 'Expense \'kath\' approved by Finance Staff', '2025-11-20 01:42:51', '2025-11-20 01:42:51'),
(42, 3, 'created', 'App\\Models\\Expense', 15, NULL, '{\"category_id\":\"2\",\"title\":\"Fare\",\"amount\":\"50.00\",\"expense_date\":\"2025-11-19T00:00:00.000000Z\",\"notes\":null,\"user_id\":3,\"status\":\"pending\",\"updated_at\":\"2025-11-20T09:48:56.000000Z\",\"created_at\":\"2025-11-20T09:48:56.000000Z\",\"id\":15}', '127.0.0.1', 'Expense \'Fare\' created for ₱50.00', '2025-11-20 01:48:56', '2025-11-20 01:48:56'),
(43, 3, 'updated', 'App\\Models\\Expense', 15, '{\"id\":15,\"user_id\":3,\"category_id\":2,\"title\":\"Fare\",\"description\":null,\"amount\":\"50.00\",\"expense_date\":\"2025-11-19T00:00:00.000000Z\",\"status\":\"pending\",\"receipt_path\":null,\"notes\":null,\"created_at\":\"2025-11-20T09:48:56.000000Z\",\"updated_at\":\"2025-11-20T09:48:56.000000Z\",\"deleted_at\":null}', '{\"id\":15,\"user_id\":3,\"category_id\":2,\"title\":\"Fare\",\"description\":null,\"amount\":\"55.00\",\"expense_date\":\"2025-11-19T00:00:00.000000Z\",\"status\":\"pending\",\"receipt_path\":null,\"notes\":null,\"created_at\":\"2025-11-20T09:48:56.000000Z\",\"updated_at\":\"2025-11-20T09:50:17.000000Z\",\"deleted_at\":null}', '127.0.0.1', 'Expense \'Fare\' updated.', '2025-11-20 01:50:17', '2025-11-20 01:50:17'),
(44, 2, 'rejected', 'App\\Models\\Expense', 15, '{\"status\":\"pending\"}', '{\"status\":\"rejected\"}', '127.0.0.1', 'Expense \'Fare\' rejected by Finance Staff', '2025-11-20 01:50:56', '2025-11-20 01:50:56');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `monthly_limit` decimal(12,2) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `monthly_limit`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Office Supplies', 'Items like pens, paper, and staplers', 5000.00, 1, '2025-11-01 04:32:57', '2025-11-01 04:32:57'),
(2, 'Transportation', 'Bus, train, and fuel expenses', 3000.00, 1, '2025-11-01 04:33:21', '2025-11-01 04:33:21'),
(3, 'Meals', 'Food and dining expenses', 2000.00, 1, '2025-11-01 04:33:21', '2025-11-01 04:41:33'),
(4, 'Maintenance', 'Equipment and repairs', 4000.00, 1, '2025-11-01 04:33:21', '2025-11-01 04:33:21'),
(5, 'Travel', 'Business trips, lodging, or airfare for company activities.', 12000.00, 1, '2025-11-01 04:41:16', '2025-11-01 04:41:16'),
(6, 'Utilities', 'Monthly expenses for electricity, water, and internet.', 6000.00, 1, '2025-11-01 04:54:14', '2025-11-01 04:54:14');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Finance', '2025-11-01 05:17:16', '2025-11-01 05:17:16'),
(2, 'HR', '2025-11-01 05:17:17', '2025-11-01 05:17:17'),
(3, 'IT', '2025-11-01 05:17:17', '2025-11-01 05:17:17');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `expense_date` date NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `receipt_path` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `user_id`, `category_id`, `title`, `description`, `amount`, `expense_date`, `status`, `receipt_path`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 2, 'Grab/Taxi Fare', 'Travel cost for meeting with client in Makati.', 450.00, '2025-08-07', 'approved', NULL, NULL, '2025-11-01 04:36:14', '2025-11-01 04:52:01', NULL),
(2, 3, 4, 'Laptop Repair', 'Replacement of damaged laptop battery', 3000.00, '2025-08-01', 'approved', NULL, NULL, '2025-11-01 04:37:09', '2025-11-01 04:52:30', NULL),
(3, 3, 3, 'Team Lunch', 'Lunch out for staff after project completion.', 2000.00, '2025-10-01', 'approved', NULL, NULL, '2025-11-01 04:38:20', '2025-11-01 04:52:32', NULL),
(4, 3, 1, 'Printer Ink & Paper', 'Purchase of printing materials for reports and forms.', 1200.00, '2025-07-06', 'approved', NULL, NULL, '2025-11-01 04:43:00', '2025-11-01 04:53:04', NULL),
(5, 3, 2, 'Gasoline', 'Fuel refill for company car used in deliveries.', 2300.00, '2025-09-03', 'approved', NULL, NULL, '2025-11-01 04:44:02', '2025-11-01 06:19:17', NULL),
(6, 3, 3, 'Client Meeting Snacks', 'Coffee and snacks served during client presentation.', 800.00, '2025-08-17', 'rejected', NULL, NULL, '2025-11-01 04:46:32', '2025-11-01 06:30:45', NULL),
(7, 3, 1, 'Office chairs', 'New ergonomic chair for accounting staff.', 4800.00, '2025-11-01', 'rejected', NULL, 'needed ', '2025-11-01 04:51:30', '2025-11-01 06:36:14', NULL),
(8, 3, 2, 'Taxi fare', 'morning commute home to office', 500.00, '2025-11-03', 'approved', NULL, '499', '2025-11-03 03:45:41', '2025-11-03 20:13:05', NULL),
(9, 3, 3, 'lunch meeting', 'for 10 people', 1500.00, '2025-11-06', 'rejected', 'receipts/xCg74Sjz4GeLyHEzltz1NPPPLPWQ3Knwu8euXuBG.png', 'totoo to hindi kita tinatarantado', '2025-11-05 17:47:42', '2025-11-05 17:49:41', NULL),
(10, 3, 3, 'lunch meeting', 'for 10 people', 1600.00, '2025-11-06', 'approved', 'receipts/XnbwfA7GAVWgB9Ikn08SUbEhWwYxHIm1wWNGRXpb.png', 'totoo to hindi kita tinatarantado', '2025-11-05 17:47:45', '2025-11-05 17:49:49', NULL),
(11, 3, 1, 'Office Supplies Purchase', 'Purchased pens, paper, and folders for the accounting department.', 1500.00, '2025-11-02', 'approved', NULL, NULL, '2025-11-06 04:53:53', '2025-11-20 00:32:33', NULL),
(12, 1, 6, 'Electricity Bill', '1 month bill', 4500.00, '2025-11-20', 'pending', NULL, NULL, '2025-11-20 00:47:29', '2025-11-20 01:00:11', NULL),
(13, 3, 6, 'Electricity Bill', '1 month electricity expenses', 4500.00, '2025-10-02', 'rejected', NULL, NULL, '2025-11-20 00:50:47', '2025-11-20 01:00:54', NULL),
(14, 8, 3, 'kath', 'hakdog', 121.00, '2025-11-20', 'approved', NULL, NULL, '2025-11-20 01:41:10', '2025-11-20 01:42:51', NULL),
(15, 3, 2, 'Fare', NULL, 55.00, '2025-11-19', 'rejected', NULL, NULL, '2025-11-20 01:48:56', '2025-11-20 01:50:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_24_124913_create_categories_table', 1),
(5, '2025_10_24_125108_create_expenses_table', 1),
(6, '2025_10_24_125345_create_approval_records_table', 1),
(7, '2025_10_24_125550_create_audit_logs_table', 1),
(8, '2025_10_27_124055_add_remarks_to_expenses_table', 1),
(9, 'create_departments_table', 1),
(10, '2025_11_01_125444_create_departments_table', 2),
(11, '2025_11_01_125815_add_department_to_users_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('employee','finance_staff','admin') NOT NULL DEFAULT 'employee',
  `department` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `department`, `is_active`, `remember_token`, `created_at`, `updated_at`, `department_id`) VALUES
(1, 'Admin User', 'admin@example.com', NULL, '$2y$12$0aubSACvDxqcBQJdO3PXRuYmA3CwdsyaGwYBy.vQ8yWxNQP6w/6D6', 'admin', NULL, 1, NULL, '2025-11-01 04:23:57', '2025-12-04 04:19:41', 1),
(2, 'Finance Staff', 'finance@test.com', NULL, '$2y$12$4dle4kOdrXG1JFuE3n3mQuz/zW6VrgXRGbovi715ZJvpfC6zc61p.', 'employee', NULL, 1, NULL, '2025-11-01 04:27:04', '2025-12-04 04:16:28', 1),
(3, 'pau', 'paulettesantor17@gmail.com', NULL, '$2y$12$5j6Weqeo916vj2AOoNNi0.vHNn0POtJgFiyyiPxeC4LxkVu5Qci52', 'employee', NULL, 1, NULL, '2025-11-01 04:32:01', '2025-11-01 04:32:01', NULL),
(6, 'Yoon Jeonghan', 'hannie@svt.com', NULL, '$2y$12$ejAQb1fleqhLizn92IFKPuDs0GMb.hMvNsEUDQBTbtvbQvmVMk1KS', 'admin', NULL, 1, NULL, '2025-11-06 05:38:27', '2025-11-06 05:38:27', NULL),
(7, 'Ginwin Quicay', 'ginwin@gmail.com', NULL, '$2y$12$6O1TfElFj6yMYc1tkbP70e/.gEmxwBEcII5gpd0L9qv/BTkCX4/lS', 'employee', NULL, 1, NULL, '2025-11-20 01:28:52', '2025-12-04 04:20:12', 3),
(8, 'Kathlaine Rojales', 'kath@gmail.com', NULL, '$2y$12$VNcvgVLPtyVtM49FM2yDwunuvl1Qkz36/56nv0rgj9U31GtUTOzVu', 'employee', NULL, 1, NULL, '2025-11-20 01:39:06', '2025-11-20 01:39:06', NULL),
(14, 'Test User', 'test@example.com', '2025-12-04 04:26:04', '$2y$12$gjF/CJFqy/ECEFiQLrgkBui/GDubwH0kzwqKEMetYVkpIBn2HrUCG', 'employee', NULL, 1, 'RgiPvvzloh', '2025-12-04 04:26:04', '2025-12-04 04:26:04', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approval_records`
--
ALTER TABLE `approval_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `approval_records_expense_id_foreign` (`expense_id`),
  ADD KEY `approval_records_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_user_id_foreign` (`user_id`),
  ADD KEY `expenses_category_id_foreign` (`category_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_department_id_foreign` (`department_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `approval_records`
--
ALTER TABLE `approval_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `approval_records`
--
ALTER TABLE `approval_records`
  ADD CONSTRAINT `approval_records_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `approval_records_expense_id_foreign` FOREIGN KEY (`expense_id`) REFERENCES `expenses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `expenses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

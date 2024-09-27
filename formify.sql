-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 27, 2024 at 12:17 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `formify`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` bigint NOT NULL,
  `form_id` bigint NOT NULL,
  `user_id` bigint NOT NULL,
  `key_answers` text COLLATE utf8mb4_general_ci NOT NULL,
  `answers` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` bigint NOT NULL,
  `user_id` bigint NOT NULL,
  `title` text COLLATE utf8mb4_general_ci NOT NULL,
  `slug` text COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `show_creator` tinyint NOT NULL,
  `answer_once` tinyint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint NOT NULL,
  `form_id` bigint NOT NULL,
  `question` text COLLATE utf8mb4_general_ci NOT NULL,
  `question_without_spaces` text COLLATE utf8mb4_general_ci NOT NULL,
  `question_type` text COLLATE utf8mb4_general_ci NOT NULL,
  `answers` text COLLATE utf8mb4_general_ci NOT NULL,
  `is_required` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `username` text COLLATE utf8mb4_general_ci NOT NULL,
  `profile` text COLLATE utf8mb4_general_ci,
  `password` text COLLATE utf8mb4_general_ci NOT NULL,
  `bio` text COLLATE utf8mb4_general_ci,
  `last_login` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `profile`, `password`, `bio`, `last_login`, `created_at`, `updated_at`) VALUES
(3193400286, 'Anggelika Septia Ningrum', 'Anggelika', '-', '$argon2i$v=19$m=65536,t=4,p=1$ckJ4Z0xobi95TncybXdhZw$PEESzJJQNFmIb4D5KhoVWdeFaVyLVPyLBYLF38Bk2Q4', '-', '2024-07-17 16:05:55', '2024-07-17 14:12:15', '2024-07-17 14:05:55'),
(3415797662, 'M Dzaki Ardiansyah', 'anggelikak', '-', '$argon2i$v=19$m=65536,t=4,p=1$cXROSkJLeWNLVWM5TTVTVQ$IjTrEnZdgugm9BJS0tUN0UNaqR8Fczm+yjVjcM2iK1g', '-', '0000-00-00 00:00:00', '2024-07-20 13:12:52', '2024-07-20 13:12:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forms_user_id_foreign` (`user_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_form_id_foreign` (`form_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `forms`
--
ALTER TABLE `forms`
  ADD CONSTRAINT `forms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

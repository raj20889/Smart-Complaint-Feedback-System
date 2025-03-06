-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2025 at 10:37 AM
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
-- Database: `complaint_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `status` enum('Pending','In Progress','Resolved') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `user_id`, `category`, `description`, `image_path`, `status`, `created_at`) VALUES
(6, 1, 'Hostel', '123', 'uploads/1741246291_Screenshot (1).png', 'Resolved', '2025-03-06 07:31:31'),
(7, 1, 'Classroom', '123', '', 'Pending', '2025-03-06 07:32:36'),
(8, 1, 'Hostel', 'hii', '', 'Pending', '2025-03-06 07:37:06'),
(9, 1, 'Hostel', 'jjj', '', 'Pending', '2025-03-06 07:39:42'),
(10, 3, 'Hostel', 'hh', '', 'Resolved', '2025-03-06 07:42:00'),
(11, 1, 'Classroom', 'qq', '', 'Resolved', '2025-03-06 07:58:49'),
(12, 12, 'Classroom', 'jdfnjbghfsjghdfjhbg', 'uploads/1741248104_Screenshot (1).png', 'Pending', '2025-03-06 08:01:44'),
(13, 1, 'Hostel', 'qqq', '', 'Resolved', '2025-03-06 08:07:48'),
(14, 1, 'Hostel', '11', '', 'Resolved', '2025-03-06 08:23:54'),
(15, 1, 'Hostel', '1', '', 'Pending', '2025-03-06 09:02:55'),
(16, 1, 'Hostel', '1', '', 'In Progress', '2025-03-06 09:17:48');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `complaint_id` int(11) NOT NULL,
  `reviewer_id` int(11) NOT NULL,
  `review_text` text NOT NULL,
  `reviewed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `complaint_id`, `reviewer_id`, `review_text`, `reviewed_at`) VALUES
(1, 15, 1, 'qqq', '2025-03-06 09:14:04'),
(2, 13, 1, 'gg', '2025-03-06 09:14:43'),
(3, 16, 1, 'nbewjbdfhjebwhf', '2025-03-06 09:33:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin') DEFAULT 'student'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Mohit Raj', 'rajm20889@gmail.com', '$2y$10$UsFsfk85xbXsr3NUyXfdBu9ulrqsqRJl.Zt7ZLGwPZw9Vk902xSv2', 'student'),
(2, 'Mohit Raj', 'payal@gmail.com', '$2y$10$p20EWtQTuMcS9hcv0yH/xeHplj2r9j9ty/adbBbKj4JiyP7QwaGtO', 'admin'),
(3, 'sumit', 'sumit.like.raj@gmail.com', '$2y$10$J92AwvxzsTEA5LgcXw7LT.SpQgipXMssFAh4EEF.lO4eNkARdf95a', 'student'),
(10, 'jon', 'rajm0889@gmail.com', '$2y$10$QDEPRoLRU91wg1s5Ri6m5On/Wug.g5JETv2v9.4DxQepIjiT8rW72', 'student'),
(11, 'jony', 'jondoe@gmail.com', '$2y$10$FQWc.Yteab5C9b93qWlBP.GbRc0BZBaner.PvWuLRG4JyakeIow0i', 'admin'),
(12, 'shah', 'shah@gmail.com', '$2y$10$z59yzmfet0GpuzV3k3jRLeXoKI0vNhdz10Q8s1MZeMcT3dQNJWpfe', 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `complaint_id` (`complaint_id`),
  ADD KEY `reviewer_id` (`reviewer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
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
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`complaint_id`) REFERENCES `complaints` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`reviewer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

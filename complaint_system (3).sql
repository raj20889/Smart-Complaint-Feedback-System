-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2025 at 09:06 PM
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
CREATE DATABASE IF NOT EXISTS `complaint_system` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `complaint_system`;

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

DROP TABLE IF EXISTS `complaints`;
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
(24, 15, 'Classroom', 'The classroom/lab is in poor condition with broken furniture, non-functional equipment, and an unhygienic environment.', 'uploads/1741434450_Screenshot 2024-10-01 235344.png', 'Pending', '2025-03-08 11:47:30'),
(25, 15, 'WiFi', 'The college Wi-Fi is slow or unavailable, making it difficult to access study materials and online resources.', '', 'In Progress', '2025-03-08 11:48:14'),
(26, 15, 'Hostel Warden', 'Frequent water or electricity shortages in the hostel are causing inconvenience to students.', '', 'Pending', '2025-03-08 11:48:57'),
(27, 15, 'Ragging', '– An incident of harassment/misconduct has occurred, requiring immediate attention for student safety.', '', 'Pending', '2025-03-08 11:50:25'),
(28, 15, 'Ragging', 'Incidents of ragging have been reported, creating an unsafe environment for students. Immediate action is required to prevent harassment and ensure student safety.', 'uploads/1741434739_no-to-ragging.jpg', 'In Progress', '2025-03-08 11:52:19'),
(29, 15, 'Food', 'mess is not opening in time.', '', 'Resolved', '2025-03-08 11:59:19'),
(30, 15, 'Water Supply', 'water is not coming in dlf hostel', 'uploads/1741435747_Screenshot 2025-03-07 190250.png', 'Resolved', '2025-03-08 12:09:07'),
(31, 15, 'Water Supply', 'water is not clean', '', 'In Progress', '2025-03-08 12:14:36'),
(32, 15, 'Hostel', 'owner chutia hai', '', 'Pending', '2025-03-08 16:17:39');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
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
(10, 28, 15, 'agree', '2025-03-08 11:59:41'),
(11, 30, 15, 'solve fast', '2025-03-08 12:09:31'),
(12, 31, 15, 'solve fast', '2025-03-08 12:14:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
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
(15, 'Mohit Raj', 'rajm20889@gmail.com', '$2y$10$phSndFLD9BTcUuR/T2ys9u.YPwLjN2388DpgzMCfUZbGEHYKGBHvi', 'student'),
(16, 'payal', 'payal@gmail.com', '$2y$10$EPAT.2Y/8PWPOnYnCuMfOekeWq2zP/9gUg50NkVctCfAgl2VeTUv6', 'admin'),
(17, 'jon', 'jon@gmail.com', '$2y$10$4gu16fUwedMhiZB4nPp5oud0eaVg5NRVkEBPtitBlSOKEHQ/2qUNa', 'student'),
(18, 'jon1@gmail.com', 'jon1@gmail.com', '$2y$10$0LThuOdO1ecmXsKE.1cPPedrJ8rsm2uoyKWsoA5AT3PnDW5BFLwJC', 'admin'),
(19, 'Mohit Raj', 'rajm2088@gmail.com', '$2y$10$X.ZrOEWautqZ.tK7q8old.N6jGq535SaK4CekwYpp9YJslIHdNkEO', 'student'),
(20, 'Mohit Raj', 'rajm2089@gmail.com', '$2y$10$q1gb5rB4bOZ.aKeBBWjFJeoSH3bdrkfdL5nOWI0dZE4Xr4kBwu.6i', 'student'),
(21, 'Mohit Raj', 'rajm0889@gmail.com', '$2y$10$wMw2SS9SiVTm4Azd7lI96eXRe7W9G2KdA4c0H8ay2ST7of8opX92u', 'student');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

DROP TABLE IF EXISTS `votes`;
CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `complaint_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `complaint_id`, `user_id`, `created_at`) VALUES
(18, 28, 15, '2025-03-08 11:59:30'),
(19, 30, 15, '2025-03-08 12:09:20'),
(20, 31, 15, '2025-03-08 12:14:47');

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
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_vote` (`complaint_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`complaint_id`) REFERENCES `complaints` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

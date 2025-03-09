-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2025 at 08:42 PM
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
(15, 'Mohit Raj', 'rajm20889@gmail.com', '$2y$10$phSndFLD9BTcUuR/T2ys9u.YPwLjN2388DpgzMCfUZbGEHYKGBHvi', 'student'),
(16, 'payal', 'payal@gmail.com', '$2y$10$EPAT.2Y/8PWPOnYnCuMfOekeWq2zP/9gUg50NkVctCfAgl2VeTUv6', 'admin'),
(17, 'jon', 'jon@gmail.com', '$2y$10$4gu16fUwedMhiZB4nPp5oud0eaVg5NRVkEBPtitBlSOKEHQ/2qUNa', 'student'),
(18, 'jon1@gmail.com', 'jon1@gmail.com', '$2y$10$0LThuOdO1ecmXsKE.1cPPedrJ8rsm2uoyKWsoA5AT3PnDW5BFLwJC', 'admin'),
(19, 'Mohit Raj', 'rajm2088@gmail.com', '$2y$10$X.ZrOEWautqZ.tK7q8old.N6jGq535SaK4CekwYpp9YJslIHdNkEO', 'student'),
(20, 'Mohit Raj', 'rajm2089@gmail.com', '$2y$10$q1gb5rB4bOZ.aKeBBWjFJeoSH3bdrkfdL5nOWI0dZE4Xr4kBwu.6i', 'student'),
(21, 'Mohit Raj', 'rajm0889@gmail.com', '$2y$10$wMw2SS9SiVTm4Azd7lI96eXRe7W9G2KdA4c0H8ay2ST7of8opX92u', 'student');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

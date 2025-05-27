-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2025 at 06:34 PM
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
-- Database: `music_website_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `bio` text NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(30) NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `image` varchar(1024) NOT NULL,
  `file` varchar(1024) NOT NULL,
  `category_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `views` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `date`) VALUES
(1, 'jarotvijasa', 'rajakindi09@gmail.com', '$2y$10$8VawR4iw3tPGmZ2cu95R/.Fcn8jBSJZw4r0/bho2EshlBz3ki2oZO', 'admin', '2025-05-26 18:01:18'),
(2, 'jarotvijasa', 'rajakindi09@gmail.com', '$2y$10$X7ntMBoj1m1qxDX53wRseeH.w6oMn7ba8Ptg9d0l5V13Y26Ic0Koe', 'admin', '2025-05-26 18:01:26'),
(3, 'jarotvijasa', 'jarotvijasa@gmail.com', '$2y$10$h9CP4MHyMGLQm3qoqgn6IO3iM3TLQD5w9axNF96YPy4LwV/xvdTmC', 'admin', '2025-05-27 15:01:21'),
(4, 'adam', 'adam@gmail.com', '$2y$10$fOwEwy1S30h44wavh9bVLeb3rDM0MI1XC.pTXxXRF.3AkxttIdDjq', 'user', '2025-05-27 15:01:22'),
(5, 'jarotvijasa', 'raja.avicenna@office.ui.ac.id', '$2y$10$W8sSNgFP4azfB6yg.HtVmOmu0S56wL0zTmIQQ1Ta9g6xFg07QJkAa', 'admin', '2025-05-27 15:01:27'),
(6, 'jarotvijasa', 'hanifalauddinakbar@gmail.com', '$2y$10$9BwUMGMrW0wZXXIlNQK4z.wxhBW2URCs1S6M5ecszcmrS7q3mcf2W', 'admin', '2025-05-27 15:01:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`),
  ADD KEY `disabled` (`disabled`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `artist_id` (`artist_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `views` (`views`),
  ADD KEY `date` (`date`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `email` (`email`),
  ADD KEY `role` (`role`),
  ADD KEY `date` (`date`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2025 at 01:38 PM
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
  `user_id` int(11) NOT NULL,
  `image` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `name`, `bio`, `user_id`, `image`) VALUES
(2, 'Ardhito Pramono', 'What is Lorem Ipsum?\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nThis is the end', 3, 'uploads/ardhiito.jpeg'),
(4, 'Nadif Basalamah', '', 3, 'uploads/nadif.jpeg'),
(5, 'Sabrina Carpenter', '', 3, 'uploads/sabrina.jpeg'),
(6, 'Tenxi', '', 3, 'uploads/tenxi.jpeg'),
(7, 'Lee Hi', '', 3, 'uploads/leehi2.jpeg'),
(8, 'Aziz Hendra', '', 3, 'uploads/aziz.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(30) NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `disabled`) VALUES
(1, 'Pop', 0),
(2, 'Country', 0),
(3, 'R&B', 0),
(4, 'Dance', 0);

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `image` varchar(1024) NOT NULL,
  `file` varchar(1024) NOT NULL,
  `category_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `views` int(11) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `title`, `user_id`, `artist_id`, `image`, `file`, `category_id`, `date`, `views`, `slug`, `featured`) VALUES
(1, 'Somebody\'s Pleasure', 3, 8, 'uploads/aziz.jpeg', 'uploads/SomebodyspleassureV2.mp3', 1, '2025-05-31 15:38:10', 8, 'somebodyspleasure', 1),
(3, 'Kasih Aba-aba', 3, 6, 'uploads/tenxi.jpeg', 'uploads/Kasih aba-aba.mp3', 1, '2025-05-31 19:17:11', 0, 'kasihaba-aba', 0),
(4, 'Nonsense', 3, 5, 'uploads/sabrina2.jpg', 'uploads/nonsense.mp3', 1, '2025-05-31 19:18:13', 1, 'nonsense', 1),
(5, 'Bergema Sampai Selamanya', 3, 4, 'uploads/bergema.jpg', 'uploads/bergema sampai selamanya.mp3', 2, '2025-05-31 19:19:11', 8, 'bergemasampaiselamanya', 1);

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
(1, 'jarotvijasa', 'rajakindi09@gmail.com', '$2y$10$s.dUM6/DkC3PYoypRJG51OPbIqj/JYojprFwgmpWKio/3/Su/qmXC', 'admin', '2025-05-26 18:01:18'),
(3, 'jarotvijasa', 'jarotvijasa@gmail.com', '$2y$10$h9CP4MHyMGLQm3qoqgn6IO3iM3TLQD5w9axNF96YPy4LwV/xvdTmC', 'admin', '2025-05-27 15:01:21'),
(4, 'adam', 'adam@gmail.com', '$2y$10$fOwEwy1S30h44wavh9bVLeb3rDM0MI1XC.pTXxXRF.3AkxttIdDjq', 'user', '2025-05-27 15:01:22'),
(5, 'jarotvijasa', 'raja.avicenna@office.ui.ac.id', '$2y$10$W8sSNgFP4azfB6yg.HtVmOmu0S56wL0zTmIQQ1Ta9g6xFg07QJkAa', 'user', '2025-05-27 15:01:27'),
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
  ADD KEY `date` (`date`),
  ADD KEY `title` (`title`),
  ADD KEY `slug` (`slug`),
  ADD KEY `featured` (`featured`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2022 at 08:45 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `forum`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `comment` varchar(500) NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `last_modified` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `post_id`, `user_id`, `likes`, `created`, `last_modified`) VALUES
(13, 'Komentaras', 10, 11, 0, '2022-03-17 21:20:15', '2022-03-19 17:20:29'),
(19, 'Labas adafsf', 23, 26, 0, '2022-03-21 19:01:47', '2022-03-21 18:01:53');

-- --------------------------------------------------------

--
-- Table structure for table `comm_likes`
--

CREATE TABLE `comm_likes` (
  `id` int(10) UNSIGNED NOT NULL,
  `comment_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `post` mediumtext NOT NULL,
  `likes` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `last_modified` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `post`, `likes`, `created`, `last_modified`) VALUES
(8, 7, 'Et reprehenderit quia cumque magna nemo debitis, Et reprehenderit quia cumque magna nemo debitis, Et reprehenderit quia cumque magna nemo debitis, Et reprehenderit quia cumque magna nemo debitis, Et reprehenderit quia cumque magna nemo debitis, Et reprehenderit quia cumque magna nemo debitis, Et reprehenderit quia cumque magna nemo debitis, Et reprehenderit quia cumque magna nemo debitis.\r\nPakeistas ir sitas', 0, '2022-03-14 20:03:21', '2022-03-16 19:12:36'),
(10, 11, 'Sapiente proident a minima explicabo Ducimus reiciendis eaque illum necessitatibus nisi et est veniam pariatur Irure', 0, '2022-03-14 21:28:30', '2022-03-15 20:11:19'),
(21, 20, 'Labore voluptas sunt eum quis nisi cum ut voluptatibus nostrud non est tempora dolor eos Nobis asperiores soluta beatae iste nostrud itaque voluptatibus impedit voluptate impedit', 0, '2022-03-17 21:24:56', '2022-03-17 21:24:56'),
(23, 26, 'Cupidatat sint minus dolor ratione aliquip dolorem adipisicing aut neque et voluptates maiores suscipit laboris nemo elit adsafasdf', 0, '2022-03-21 19:01:36', '2022-03-21 18:01:43');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL DEFAULT 2,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `last_modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `role_id`, `created`, `last_modified`) VALUES
(4, 'Paulius', 'Jasas', 'Paulinskiz', 'paulinskiz@forum.lt', '$2y$10$3op2Miu1QGOk734JO64Cmuh4snuFpPUsqmsdkI8yrUsjQ6RjS3CKm', 1, '2022-03-21 20:52:16', '2022-03-21 20:52:33'),
(7, 'test2', 'test', 'test', 'test@forum.lt', '$2y$10$PKAy/C.YSXT7enyi5PyMzum0q/l3FkZwNpe4nTETgZ8K0VWebVBrC', 2, '2022-03-13 20:16:14', '2022-03-16 21:18:53'),
(11, 'Laba', 'Diena', 'Labadiena', 'labas@forum.lt', '$2y$10$VcjP53NGTsIhLrLxfoMnOew2LpZtZt.4s2iVatHuJXhemXkBbG7b6', 2, '2022-03-13 20:17:53', '2022-03-13 21:41:36'),
(18, 'Leandra', 'Holcomb', 'sapiqovem', 'vane@mailinator.com', '$2y$10$KYqodr6tgKGHvl1UyQJERuSY0M9fq/CgKbnm5ZmzSAIw6UJZw3Qiq', 2, '2022-03-15 18:01:40', '2022-03-15 18:01:40'),
(20, 'Jacob', 'Baker', 'vaxav', 'ridaro@mailinator.com', '$2y$10$XR49qd/rOLnnJJHKdB1eyuNcbBZuYDWysGXOfDBqFxAj6fuVQxzsy', 2, '2022-03-15 18:03:06', '2022-03-15 18:03:06'),
(26, 'Paskaita', 'Kovasad', 'paskaita', 'paskaita@bit.lt', '$2y$10$eCR79S.T2dXWxDY1pu.oQeYFwjfR.RnkPQ.CksrN9fJdDsWXBP7g6', 2, '2022-03-21 19:00:59', '2022-03-21 19:02:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comm_likes`
--
ALTER TABLE `comm_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
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
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `comm_likes`
--
ALTER TABLE `comm_likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.4.15
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015 年 12 月 11 日 02:48
-- サーバのバージョン： 5.6.27
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nexseed_link`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `lessons`
--

CREATE TABLE IF NOT EXISTS `lessons` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `reserve_status_id` int(11) NOT NULL,
  `rand_str` varchar(20) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `lessons`
--

INSERT INTO `lessons` (`id`, `date`, `time_id`, `teacher_id`, `student_id`, `reserve_status_id`, `rand_str`, `created`, `modified`) VALUES
(7, '2015-12-15', NULL, 35, NULL, 1, NULL, '2015-11-21 14:54:20', '2015-12-02 02:38:08'),
(8, '2015-12-15', NULL, 36, NULL, 1, NULL, '2015-11-21 14:54:43', '2015-12-02 02:40:16'),
(9, '2015-12-15', NULL, 37, NULL, 1, NULL, '2015-11-21 14:54:50', '2015-12-02 02:41:04'),
(10, '2015-12-15', NULL, 35, NULL, 1, NULL, '2015-11-21 14:54:20', NULL),
(11, '2015-12-16', NULL, 35, 38, 2, 'PrJDxpz7', '2015-11-21 14:54:20', '2015-12-02 08:27:17'),
(13, '2015-12-16', NULL, 35, NULL, 1, NULL, '2015-11-21 14:54:20', '2015-12-02 02:48:02'),
(14, '2015-12-16', NULL, 35, NULL, 1, NULL, '2015-11-21 14:54:20', '2015-12-02 02:34:17'),
(30, '2015-12-19', NULL, 38, NULL, 1, NULL, '2015-12-09 22:45:00', NULL),
(32, '2015-12-17', 8, 40, 38, 2, 'XGOns9tH', '2015-12-10 10:48:31', '2015-12-10 03:18:21'),
(33, '2015-12-18', 3, 40, NULL, 1, NULL, '2015-12-10 10:49:58', NULL),
(34, '2015-12-18', 8, 40, NULL, 1, NULL, '2015-12-10 10:53:38', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `lesson_times`
--

CREATE TABLE IF NOT EXISTS `lesson_times` (
  `id` int(11) NOT NULL,
  `time` time NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `lesson_times`
--

INSERT INTO `lesson_times` (`id`, `time`, `created`, `modified`) VALUES
(3, '18:00:00', '2015-12-09 12:10:40', NULL),
(4, '18:30:00', '2015-12-09 12:11:02', NULL),
(7, '19:00:00', '2015-12-09 22:41:53', NULL),
(8, '19:30:00', '2015-12-09 22:41:53', NULL),
(10, '20:00:00', '2015-12-09 22:44:37', NULL),
(11, '20:30:00', '2015-12-09 22:44:37', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `reserve_statuses`
--

CREATE TABLE IF NOT EXISTS `reserve_statuses` (
  `id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `reserve_statuses`
--

INSERT INTO `reserve_statuses` (`id`, `status`, `created`, `modified`) VALUES
(1, '講師予約済み', '2015-11-23 12:23:33', NULL),
(2, 'マッチング済み', '2015-11-23 12:23:33', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `status`
--

INSERT INTO `status` (`id`, `name`, `user_id`, `created`, `modified`) VALUES
(1, 'admin', 1, '2015-11-23 12:22:08', NULL),
(2, 'future', 1, '2015-11-23 12:28:44', NULL),
(3, 'stay', 1, '2015-11-23 12:28:44', NULL),
(4, 'graduate', 1, '2015-11-23 12:29:04', NULL),
(5, 'teacher', 1, '2015-11-23 12:29:22', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `teacher_likes`
--

CREATE TABLE IF NOT EXISTS `teacher_likes` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `teacher_likes`
--

INSERT INTO `teacher_likes` (`id`, `student_id`, `teacher_id`, `created`) VALUES
(40, 38, 35, '2015-11-26'),
(43, 38, 37, '2015-11-26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lesson_times`
--
ALTER TABLE `lesson_times`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reserve_statuses`
--
ALTER TABLE `reserve_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_likes`
--
ALTER TABLE `teacher_likes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `lesson_times`
--
ALTER TABLE `lesson_times`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `reserve_statuses`
--
ALTER TABLE `reserve_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `teacher_likes`
--
ALTER TABLE `teacher_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=44;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

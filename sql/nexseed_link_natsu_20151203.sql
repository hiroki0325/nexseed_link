-- phpMyAdmin SQL Dump
-- version 4.4.15
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015 年 12 月 03 日 02:11
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
-- テーブルの構造 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `start_day` date DEFAULT NULL,
  `end_day` date DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `come_count` int(255) DEFAULT NULL,
  `time_count` int(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `fullname`, `nickname`, `email`, `password`, `start_day`, `end_day`, `status_id`, `picture`, `come_count`, `time_count`, `created`, `modified`) VALUES
(37, '来学予定者', NULL, 'future@', 'd848c9713eb1c248d99ae01d257fe9b269623d27', '2016-04-01', '2016-12-31', 2, '20151124125146エマワトソン.jpg', 0, 0, '2015-11-24 12:51:48', NULL),
(38, '在学生', NULL, 'stay@', '396f9974da4e60ff2d8ccc90121dbaf5d58ef9e6', '2015-11-24', '2016-03-26', 3, '20151124125306rather be.jpg', 0, 0, '2015-11-24 12:53:08', NULL),
(39, '卒業生', NULL, 'graduate@', '2c6a6bad65208ce9633ebe93d7f08dddb2705ef8', '2015-10-01', '2015-11-23', 4, '2015112412541502.jpg', 0, 0, '2015-11-24 12:54:17', NULL),
(40, 'teacher', NULL, 'teacher@', '4a82cb6db537ef6c5b53d144854e146de79502e8', NULL, NULL, 5, '2015112412554901.jpg', 0, 0, '2015-11-24 12:55:54', NULL),
(41, '管理者', NULL, 'admin@', 'd033e22ae348aeb5660fc2140aec35850c4da997', NULL, NULL, 1, '20151124125633', 0, 0, '2015-11-24 12:56:35', NULL),
(44, 'natsuki teruya', NULL, 'natsuki', 'a3b0ec2e068c3363638a0b85050d156aa0863f9d', '2015-12-02', '2015-12-31', 3, NULL, NULL, NULL, '2015-12-03 10:58:07', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `status`
--
ALTER TABLE `status`
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
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=45;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

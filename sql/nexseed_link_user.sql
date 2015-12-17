-- phpMyAdmin SQL Dump
-- version 4.4.15
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015 年 12 月 17 日 14:23
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
-- テーブルの構造 `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `notificaton_message_id` int(11) DEFAULT NULL,
  `logistic_post_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `lesson_id`, `notificaton_message_id`, `logistic_post_id`, `created`, `modified`) VALUES
(80, 57, NULL, 1, NULL, '2015-12-15 11:57:10', '2015-12-15 02:57:10'),
(81, 58, NULL, 1, NULL, '2015-12-15 12:25:25', '2015-12-15 03:25:25');

-- --------------------------------------------------------

--
-- テーブルの構造 `notification_message`
--

CREATE TABLE IF NOT EXISTS `notification_message` (
  `id` int(11) NOT NULL,
  `message` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `notification_message`
--

INSERT INTO `notification_message` (`id`, `message`) VALUES
(1, 'が新規登録されました'),
(2, 'レッスンを新しく追加しました'),
(3, '物流を新しく追加しました\r\n');

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
  `login_count` int(255) DEFAULT NULL,
  `visit_log_time` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `fullname`, `nickname`, `email`, `password`, `start_day`, `end_day`, `status_id`, `picture`, `login_count`, `visit_log_time`, `created`, `modified`) VALUES
(37, '来学予定者', 'futu', 'future@', 'd848c9713eb1c248d99ae01d257fe9b269623d27', '2016-04-01', '2016-12-31', 2, '20151124125146エマワトソン.jpg', 19, '2015-12-15 23:39:01', '2015-11-24 12:51:48', NULL),
(38, '在学生', 'stay', 'stay@', '396f9974da4e60ff2d8ccc90121dbaf5d58ef9e6', '2015-11-24', '2016-03-26', 3, '20151124125306rather be.jpg', 31, '2015-12-15 23:38:38', '2015-11-24 12:53:08', NULL),
(39, '卒業生', '', 'graduate@', '2c6a6bad65208ce9633ebe93d7f08dddb2705ef8', '2015-10-01', '2015-11-23', 4, '2015112412541502.jpg', 5, '2015-12-09 12:52:06', '2015-11-24 12:54:17', NULL),
(40, 'teacher', NULL, 'teacher@', '4a82cb6db537ef6c5b53d144854e146de79502e8', NULL, NULL, 5, '2015112412554901.jpg', 45, '2015-12-14 10:50:13', '2015-11-24 12:55:54', NULL),
(41, '管理者', NULL, 'admin@', 'd033e22ae348aeb5660fc2140aec35850c4da997', NULL, NULL, 1, '20151124125633', 97, '2015-12-15 23:14:00', '2015-11-24 12:56:35', NULL),
(44, 'natsuki teruya', 'nacky', 'natsuki', 'a3b0ec2e068c3363638a0b85050d156aa0863f9d', '2015-12-02', '2015-12-31', 3, '20151215172319写真（2015-11-30 12.16）.jpg', 1, '2015-12-15 17:49:51', '2015-12-03 10:58:07', NULL),
(45, 'nikumaki nikumaki', 'aa', 'nikumaki', '2906290e6a89af43b1edb51a9743e0397c89afb9', '2015-12-01', '2015-12-31', 3, '20151216102649写真（2015-11-30 12.16）.jpg', 1, NULL, '2015-12-03 12:41:35', NULL),
(46, 'shinya hirai', 'shinya', 'shinya@gmail.com', '3b2c6c10d0e78072d14e02cc4c587814d0f10f3a', '2015-12-08', '2015-12-23', 4, '20151208101529写真（2015-11-30 12.16）.jpg', 2, '2015-12-08 10:15:51', '2015-12-08 10:13:48', NULL),
(57, 'hoo hoo', NULL, 'hoo@', '10498db05e5431d69e147f4b174727f0fd8020a1', '2015-12-01', '2015-12-31', 3, NULL, 0, NULL, '2015-12-15 11:57:10', NULL),
(58, 'natsuki teruya', NULL, 'natsuki@', '8dd42334968c1baf25b2e8e27c9c2d4e48bba3a8', '2015-12-01', '2015-12-31', 3, NULL, 0, NULL, '2015-12-15 12:25:25', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_message`
--
ALTER TABLE `notification_message`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=82;
--
-- AUTO_INCREMENT for table `notification_message`
--
ALTER TABLE `notification_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=59;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

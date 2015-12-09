-- phpMyAdmin SQL Dump
-- version 4.4.15
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015 年 12 月 09 日 02:47
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
-- テーブルの構造 `candidates`
--

CREATE TABLE IF NOT EXISTS `candidates` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `insentive` varchar(255) NOT NULL,
  `payment` int(11) NOT NULL,
  `arrival_date` date NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  `desicion` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `candidates`
--

INSERT INTO `candidates` (`id`, `post_id`, `agent_id`, `insentive`, `payment`, `arrival_date`, `created`, `modified`, `desicion`) VALUES
(1, 19, 1, 'ごはん', 300, '2015-11-23', '2015-11-20 11:49:54', NULL, NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `comment_image` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `comment`, `comment_image`, `created`, `modified`) VALUES
(45, 70, 1, 'komennto', '', '2015-12-02 18:18:14', NULL),
(46, 70, 1, 'えええええええええええ', '', '2015-12-02 18:19:03', NULL),
(47, 70, 1, 'ddd', '03.jpg', '2015-12-02 18:19:14', NULL),
(48, 70, 1, 'yy', '05.jpg', '2015-12-02 18:24:25', NULL),
(49, 70, 1, 'eee', 'iphone.png', '2015-12-02 18:27:03', NULL),
(55, 75, 1, 'ほげほげ', '05.jpg', '2015-12-07 11:50:32', NULL),
(58, 75, 1, 'こんばんは', '', '2015-12-08 09:11:18', NULL),
(60, 75, 1, '狼', '04.jpg', '2015-12-08 17:56:58', NULL),
(61, 74, 1, 'ごちそうさまです', '', '2015-12-08 17:57:29', NULL),
(62, 74, 1, '投稿', '', '2015-12-08 21:46:50', NULL),
(65, 73, 1, 'こめんと', '', '2015-12-09 00:39:15', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `likes`
--

CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `logistic_posts`
--

CREATE TABLE IF NOT EXISTS `logistic_posts` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `candidate_id` int(11) DEFAULT NULL,
  `thing` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `insentive` varchar(255) NOT NULL,
  `payment` varchar(255) NOT NULL,
  `due` date NOT NULL,
  `like_sum` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  `accepted` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `logistic_posts`
--

INSERT INTO `logistic_posts` (`id`, `client_id`, `candidate_id`, `thing`, `category`, `image`, `insentive`, `payment`, `due`, `like_sum`, `created`, `modified`, `accepted`) VALUES
(78, 1, NULL, 'なるほどphp', '書籍', '01.jpg', 'ご飯たべにいく', '300', '2015-12-29', NULL, '2015-12-09 11:13:04', NULL, NULL),
(79, 1, NULL, 'おかか', '食べ物', '04.jpg', 'pesso多めにあげます', '300', '2015-12-23', NULL, '2015-12-09 11:13:56', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistic_posts`
--
ALTER TABLE `logistic_posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `logistic_posts`
--
ALTER TABLE `logistic_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=80;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

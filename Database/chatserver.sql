-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2015 at 06:37 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `chatserver`
--
CREATE DATABASE IF NOT EXISTS `chatserver` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `chatserver`;

-- --------------------------------------------------------

--
-- Table structure for table `available_user`
--

DROP TABLE IF EXISTS `available_user`;
CREATE TABLE IF NOT EXISTS `available_user` (
  `user_id` varchar(20) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `chat_history`
--

DROP TABLE IF EXISTS `chat_history`;
CREATE TABLE IF NOT EXISTS `chat_history` (
`id` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=324 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat_history`
--

INSERT INTO `chat_history` (`id`, `user_id`, `message`, `time`) VALUES
(315, 'john', 'Hi', '2015-03-18 13:09:37'),
(316, 'john', ':0', '2015-03-18 13:09:44'),
(317, 'john', ':o', '2015-03-18 13:09:52'),
(318, 'john', ' left the chat session.', '2015-03-18 13:10:08'),
(319, 'sid', ' left the chat session.', '2015-03-18 13:11:01'),
(320, 'shawn', ' left the chat session.', '2015-03-18 13:11:42'),
(321, 'sid', ' left the chat session.', '2015-03-18 13:17:18'),
(322, 'shawn', 'Hello', '2015-03-18 13:31:55'),
(323, 'shawn', ' left the chat session.', '2015-03-18 13:32:07');

-- --------------------------------------------------------

--
-- Table structure for table `friend_list`
--

DROP TABLE IF EXISTS `friend_list`;
CREATE TABLE IF NOT EXISTS `friend_list` (
  `req_user` varchar(20) NOT NULL,
  `rec_user` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friend_list`
--

INSERT INTO `friend_list` (`req_user`, `rec_user`) VALUES
('john', 'rahmi'),
('john', 'user'),
('ninja', 'john'),
('ninja', 'sid'),
('shawn', 'user'),
('sid', 'john'),
('sid', 'ninja'),
('sid', 'shawn'),
('user', 'sid');

-- --------------------------------------------------------

--
-- Table structure for table `friend_request`
--

DROP TABLE IF EXISTS `friend_request`;
CREATE TABLE IF NOT EXISTS `friend_request` (
  `req_user` varchar(20) NOT NULL,
  `rec_user` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `private_chat`
--

DROP TABLE IF EXISTS `private_chat`;
CREATE TABLE IF NOT EXISTS `private_chat` (
  `friend_one` varchar(20) NOT NULL,
  `friend_two` varchar(20) NOT NULL,
  `message` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `private_chat`
--

INSERT INTO `private_chat` (`friend_one`, `friend_two`, `message`, `time`) VALUES
('sid', 'john', 'hi', '2015-03-12 13:40:28'),
('sid', 'john', 'hello', '2015-03-12 13:40:38'),
('john', 'sid', 'hello sid', '2015-03-12 13:41:37'),
('sid', '123', 'hi', '2015-03-12 13:47:41'),
('sid', 'ninja', 'hi', '2015-03-12 15:16:18'),
('sid', 'ninja', 'hello', '2015-03-12 15:17:54'),
('ninja', 'sid', 'Hi sid', '2015-03-12 15:18:10'),
('ninja', 'sid', ':o', '2015-03-12 15:18:16'),
('sid', 'ninja', 'Hi', '2015-03-12 16:06:14'),
('sid', 'ninja', 'hello', '2015-03-12 16:10:07'),
('ninja', 'sid', 'Hi sid', '2015-03-12 16:23:06'),
('sid', 'ninja', 'hi', '2015-03-12 16:25:31'),
('sid', 'shawn', 'Hi', '2015-03-18 13:10:57'),
('shawn', 'user', 'hi', '2015-03-18 13:32:02');

-- --------------------------------------------------------

--
-- Table structure for table `unread_chat`
--

DROP TABLE IF EXISTS `unread_chat`;
CREATE TABLE IF NOT EXISTS `unread_chat` (
  `friend_one` varchar(20) NOT NULL,
  `friend_two` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unread_chat`
--

INSERT INTO `unread_chat` (`friend_one`, `friend_two`) VALUES
('shawn', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` varchar(20) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `Address` text NOT NULL,
  `email` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `Address`, `email`, `password`) VALUES
('john', 'john', 'doe', '', 'johndoe@yahoo.com', '123'),
('ninja', 'Ninja', 'T', '', 'nt@yahoo.com', 'abc'),
('rahmi', 'Marufa', 'Rahmi', '', 'tasneema.sust@gmail.', '1111111'),
('shawn', 'Shawn', 'Spenser', '', 'SSpenser@gmail.com', 'abc'),
('sid', 'Marufa', 'Rahmi', '', 'tasneema.sust@gmail.', '123456'),
('user', 'e', 'e', '', 'e', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `available_user`
--
ALTER TABLE `available_user`
 ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `chat_history`
--
ALTER TABLE `chat_history`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friend_list`
--
ALTER TABLE `friend_list`
 ADD PRIMARY KEY (`req_user`,`rec_user`);

--
-- Indexes for table `friend_request`
--
ALTER TABLE `friend_request`
 ADD PRIMARY KEY (`req_user`,`rec_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_history`
--
ALTER TABLE `chat_history`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=324;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

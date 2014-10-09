-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2014 at 10:30 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `xxs`
--

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `login_activity` datetime NOT NULL,
  `login_attempt` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `username`, `login_activity`, `login_attempt`) VALUES
(1, 'rusty', '2014-09-18 16:14:51', 1),
(2, 'rusty', '2014-09-18 16:27:09', 2),
(3, 'rusty', '2014-09-18 16:27:17', 3),
(4, 'rusty', '2014-09-18 16:27:22', 4),
(5, 'emma', '2014-09-22 18:18:07', 1),
(6, 'emma', '2014-09-22 18:19:01', 2),
(7, 'clau', '2014-09-22 18:21:09', 1),
(8, 'clau', '2014-09-22 18:22:01', 2),
(9, 'gigi', '2014-09-22 18:23:33', 1),
(10, 'ion', '2014-09-22 18:25:00', 1),
(11, 'jeni', '2014-09-22 18:27:29', 1),
(12, 'loko', '2014-09-22 18:35:11', 1),
(13, 'juno', '2014-09-22 18:36:10', 1),
(14, 'juno', '2014-09-22 18:39:10', 2),
(15, 'juno', '2014-09-22 18:39:15', 3),
(16, 'juno', '2014-09-22 18:39:19', 4),
(17, 'hanna', '2014-09-22 19:40:14', 1),
(18, 'hanna', '2014-09-22 19:44:10', 2),
(19, 'hanna', '2014-09-22 19:44:30', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `locked` int(11) NOT NULL,
  `logged` int(11) NOT NULL,
  `last_activity` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `locked`, `logged`, `last_activity`) VALUES
(2, 'rusty', '123456', 1, 0, '2014-09-25 10:27:36'),
(5, 'clau', '1234', 0, 0, '2014-09-22 20:24:09'),
(6, 'claudiu', '12345', 0, 0, '2014-09-23 01:22:01'),
(7, 'emma', 'emma', 0, 0, '2014-09-22 20:24:09'),
(8, 'gigi', '123', 0, 0, '2014-09-24 10:01:37'),
(9, 'ion', '12', 0, 0, '2014-09-22 20:24:09'),
(10, 'jeni', '123', 0, 0, '2014-09-22 20:24:09'),
(11, 'hanna', '123', 0, 0, '2014-09-22 20:24:09'),
(12, 'koko', '123', 0, 0, '2014-09-22 20:24:09'),
(13, 'loko', '123', 0, 0, '2014-09-22 20:24:09'),
(14, 'juno', '123', 0, 0, '2014-09-22 20:24:09'),
(15, 'tst', '123', 0, 0, '2014-09-22 20:24:09'),
(16, 'hamd', '123', 0, 0, '2014-09-22 20:24:09'),
(17, 'hams', '123', 0, 0, '2014-09-22 20:24:09'),
(18, 'hamk', '123', 0, 0, '2014-09-22 20:24:09'),
(19, 'eve', '123', 0, 0, '2014-09-25 09:33:45');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

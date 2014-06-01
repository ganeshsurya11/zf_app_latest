-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 01, 2014 at 04:44 PM
-- Server version: 5.5.32
-- PHP Version: 5.3.10-1ubuntu3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zf_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `gender`, `contact`, `email`, `city`, `country`, `role`) VALUES
(1, 'admin', '', 'male', '989898989', 'admin@gmail.com', 'pune,mumbai', '', 'admin'),
(2, 'yogesh', '34fb382763a18c3674530a8b110abde3', 'male', '8976609470', 'yg20031810@gmail.com', 'mumbai', 'maharashtra', 'user'),
(3, 'prakash', '', 'male', '978798+', 'ganesh@sdf.com', 'pune,mumbai', 'india', 'user'),
(4, 'sudan', '@@#$33#', 'male', '465656', 'sudna@sdfs.com', 'pune', 'india', 'admin'),
(5, 'sudan', '@@#$33#', 'male', '465656', 'sudna@sdfs.com', 'pune', 'india', 'admin'),
(6, 'sudan', '', 'male', '465656', 'sudna@sdfs.com', 'pune', 'india', 'admin'),
(7, 'vilas', '', 'male', '4545', 'sdfsf@sfs.com', 'pune,mumbai', 'india', 'user'),
(8, 'vilas', '', 'male', '4545', 'sdfsf@sfs.com', 'pune,mumbai', 'india', 'user'),
(9, 'siddarth', '', 'male', '6545', 'sa@ads', 'pune,mumbai', 'india', 'user'),
(10, 'raj', 'asfasdf', 'male', '454646', 'raj@sfsd.com', 'pune,mumbai', 'india', 'user'),
(11, 'raj', '#$#$', 'male', '97987987', 'raj@sfsdf.com', 'mumbai', 'russia', 'admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

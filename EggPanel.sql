-- EggPanel Database Creation Script

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

-- Change the following three names to change the database name
--
-- Database: `eggpanel`
--
CREATE DATABASE IF NOT EXISTS `eggpanel` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `eggpanel`;

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE `actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bot_id` int(11) NOT NULL,
  `command` varchar(255) NOT NULL,
  `arguments` varchar(255) DEFAULT NULL,
  `timestamp` int(11) NOT NULL,
  `executed` tinyint(1) NOT NULL,
  `pickup` int(11) DEFAULT NULL,
  `success` tinyint(1) DEFAULT NULL,
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `bots`
--

CREATE TABLE `bots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `key_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bot_id` int(11) NOT NULL,
  `last` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token_hash` text NOT NULL,
  `verified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

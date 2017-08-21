-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jan 21, 2017 at 08:57 AM
-- Server version: 10.0.29-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sukakpop_lumipop`
--

-- --------------------------------------------------------

--
-- Table structure for table `mycms_charts`
--

CREATE TABLE IF NOT EXISTS `mycms_charts` (
  `chart_id` varchar(50) NOT NULL,
  `chart_title` tinytext NOT NULL,
  `chart_album` varchar(50) NOT NULL,
  `chart_artist_band` varchar(50) NOT NULL,
  `chart_genre` varchar(15) NOT NULL,
  `ext_url` tinytext NOT NULL,
  `chart_lyric` text NOT NULL,
  `position` int(11) NOT NULL,
  `pre_position` int(11) NOT NULL,
  `sorting` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` varchar(30) NOT NULL,
  `modified_by` varchar(30) NOT NULL,
  `seo_url` tinytext NOT NULL,
  `seo_keywords` tinytext NOT NULL,
  `seo_desc` tinytext NOT NULL,
  `file_id` varchar(50) NOT NULL,
  `page` varchar(20) NOT NULL,
  `num_of_visitors` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL,
  `tag` tinytext NOT NULL,
  PRIMARY KEY (`chart_id`),
  KEY `file_id` (`file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- Table structure for table `mycms_comments`
--

CREATE TABLE IF NOT EXISTS `mycms_comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` tinytext NOT NULL,
  `comment_name` varchar(100) NOT NULL,
  `comment_email` varchar(100) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` varchar(30) NOT NULL,
  `modified_by` varchar(30) NOT NULL,
  `comment_status` varchar(9) NOT NULL,
  `comment_read` enum('0','1') NOT NULL DEFAULT '0',
  `content_id` varchar(50) NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `content_id` (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `mycms_contents`
--

CREATE TABLE IF NOT EXISTS `mycms_contents` (
  `content_id` varchar(50) NOT NULL,
  `content_title` tinytext NOT NULL,
  `content_description` longtext NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` varchar(30) NOT NULL,
  `modified_by` varchar(30) NOT NULL,
  `seo_url` tinytext NOT NULL,
  `seo_keywords` tinytext NOT NULL,
  `seo_desc` tinytext NOT NULL,
  `file_id` varchar(50) NOT NULL,
  `page` varchar(20) NOT NULL,
  `num_of_visitors` int(11) NOT NULL,
  `header` varchar(3) NOT NULL,
  `status` enum('0','1') NOT NULL,
  `tag` tinytext NOT NULL,
  `fresh_content` enum('no','yes') NOT NULL,
  PRIMARY KEY (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `mycms_fan_page`
--

CREATE TABLE IF NOT EXISTS `mycms_fan_page` (
  `fan_page_id` int(11) NOT NULL AUTO_INCREMENT,
  `fan_page_fb` tinytext NOT NULL,
  `fan_page_twitter` tinytext NOT NULL,
  `fan_page_gplus` tinytext NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` varchar(30) NOT NULL,
  `modified_by` varchar(30) NOT NULL,
  PRIMARY KEY (`fan_page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Table structure for table `mycms_files`
--

CREATE TABLE IF NOT EXISTS `mycms_files` (
  `file_id` varchar(50) NOT NULL,
  `name_orig` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(5) NOT NULL,
  `size` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` varchar(30) NOT NULL,
  `modified_by` varchar(30) NOT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `mycms_log`
--

CREATE TABLE IF NOT EXISTS `mycms_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `visit_to` varchar(50) NOT NULL,
  `detail` varchar(100) DEFAULT NULL,
  `ip_address` varchar(20) NOT NULL,
  `log_time` datetime NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11089 ;

--
-- Table structure for table `mycms_master_users`
--

CREATE TABLE IF NOT EXISTS `mycms_master_users` (
  `username` varchar(30) NOT NULL,
  `level` char(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mycms_master_users`
--

INSERT INTO `mycms_master_users` (`username`, `level`, `created_date`, `modified_date`) VALUES
('Qwerty', 'A', '2016-09-26 15:37:34', '2016-11-15 09:27:38');

-- --------------------------------------------------------

--
-- Table structure for table `mycms_master_users_profile`
--

CREATE TABLE IF NOT EXISTS `mycms_master_users_profile` (
  `profil_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`profil_id`),
  KEY `username` (`username`),
  KEY `file_id` (`file_id`),
  KEY `username_2` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Table structure for table `mycms_master_users_security`
--

CREATE TABLE IF NOT EXISTS `mycms_master_users_security` (
  `security_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `hash_1` varchar(64) NOT NULL,
  `hash_2` varchar(32) NOT NULL,
  PRIMARY KEY (`security_id`),
  KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `mycms_master_users_security`
--

INSERT INTO `mycms_master_users_security` (`security_id`, `username`, `hash_1`, `hash_2`) VALUES
(2, 'Qwerty', 'f4119112a846ee0aaa758ba201150efcd14e580a7acd9d8a416098bf60b37849', '43df45cb166912001502977e0c7ba34d');

-- --------------------------------------------------------

--
-- Table structure for table `mycms_pages`
--

CREATE TABLE IF NOT EXISTS `mycms_pages` (
  `page_id` int(11) NOT NULL,
  `page_title` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `page_url` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `is_parent` tinyint(1) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `show_menu` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `back_end` tinyint(1) NOT NULL COMMENT '1 jika untuk contributor',
  `front_end` tinyint(1) NOT NULL COMMENT '0 jika tidak ditampilkan, 1 jika ditampilkan',
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `modified_by` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `seo_title` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `seo_author` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `seo_keywords` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `seo_desc` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `show_in_homepage` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `default` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mycms_pages`
--

INSERT INTO `mycms_pages` (`page_id`, `page_title`, `page_url`, `is_parent`, `parent_id`, `show_menu`, `back_end`, `front_end`, `created_date`, `modified_date`, `created_by`, `modified_by`, `seo_title`, `seo_author`, `seo_keywords`, `seo_desc`, `show_in_homepage`, `default`) VALUES
(1, 'Home', 'home', 0, 0, '1', 1, 1, '2016-10-16 22:56:46', '2016-11-14 17:37:58', 'admin', 'yoga', 'Berita Selebriti, Film, K-Pop & Serial TV Korea', 'K-pop', 'berita k-pop, info k-pop, Selebriti k-pop, film korea, drama korea, serial drama korea, k-pop', 'Dapatkan Informasi Seputar Berita Selebriti, Film, K-Pop & Serial TV Korea Terbaru dan Terupdate. ', '0', '0'),
(2, 'Profile', 'profile', 0, 0, '1', 0, 1, '2016-10-17 11:47:00', '2016-10-27 22:35:53', 'admin', 'admin', 'Profil Selebriti Korea', 'K-pop', 'berita k-pop, info k-pop, Selebriti k-pop, film korea, drama korea, serial drama korea, k-pop', 'Dapatkan Informasi Seputar Berita Selebriti, Film, K-Pop & Serial TV Korea Terbaru dan Terupdate. ', '1', '0'),
(3, 'News', 'news', 0, 0, '1', 0, 1, '2016-10-18 09:43:34', '2016-10-20 17:16:02', 'admin', 'admin', 'Berita Selebriti, Film, K-Pop & Serial TV Korea', 'K-pop', 'berita k-pop, info k-pop, Selebriti k-pop, film korea, drama korea, serial drama korea, k-pop', 'Dapatkan Informasi Seputar Berita Selebriti, Film, K-Pop & Serial TV Korea Terbaru dan Terupdate. ', '1', '0'),
(4, 'Gossip', 'gossip', 0, 0, '1', 0, 1, '2016-10-04 15:25:22', '2016-10-04 15:25:22', 'admin', 'admin', 'Gossip Selebriti Korea', 'K-pop', 'berita k-pop, info k-pop, Selebriti k-pop, film korea, drama korea, serial drama korea, k-pop', 'Dapatkan Informasi Seputar Berita Selebriti, Film, K-Pop & Serial TV Korea Terbaru dan Terupdate. ', '1', '0'),
(5, 'Chart', 'chart', 0, 0, '1', 0, 1, '2016-10-04 15:25:22', '2016-10-04 15:25:22', 'admin', 'admin', 'Chart Musik Korea', 'K-pop', 'berita k-pop, info k-pop, Selebriti k-pop, film korea, drama korea, serial drama korea, k-pop', 'Dapatkan Informasi Seputar Berita Selebriti, Film, K-Pop & Serial TV Korea Terbaru dan Terupdate. ', '0', '0'),
(6, 'Article', 'article', 0, 0, '1', 1, 1, '2016-10-04 15:25:22', '2016-10-04 15:25:22', 'admin', 'admin', 'Artikel Selebriti, Film, K-Pop & Serial TV Korea', 'K-pop', 'berita k-pop, info k-pop, Selebriti k-pop, film korea, drama korea, serial drama korea, k-pop', 'Dapatkan Informasi Seputar Berita Selebriti, Film, K-Pop & Serial TV Korea Terbaru dan Terupdate. ', '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `mycms_subscriber`
--

CREATE TABLE IF NOT EXISTS `mycms_subscriber` (
  `subscriber_id` int(11) NOT NULL AUTO_INCREMENT,
  `subscriber_email` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`subscriber_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

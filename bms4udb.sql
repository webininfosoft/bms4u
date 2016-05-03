-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 01, 2016 at 08:51 PM
-- Server version: 5.5.45-cll-lve
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bms4udb`
--

-- --------------------------------------------------------

--
-- Table structure for table `authentications`
--

CREATE TABLE IF NOT EXISTS `authentications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `module_id` varchar(100) NOT NULL,
  `perm_view` int(11) NOT NULL DEFAULT '0',
  `perm_add` int(11) NOT NULL DEFAULT '0',
  `perm_update` int(11) NOT NULL DEFAULT '0',
  `perm_delete` int(11) NOT NULL DEFAULT '0',
  `perm_designation` int(11) NOT NULL,
  `perm_app_online` tinyint(4) NOT NULL DEFAULT '0',
  `perm_app_offline` tinyint(4) NOT NULL DEFAULT '0',
  `auth_type` enum('WEB','MOBILE') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=300 ;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE IF NOT EXISTS `branches` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `company_id` int(10) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `latitude` varchar(1000) DEFAULT NULL,
  `longitude` varchar(1000) DEFAULT NULL,
  `device_info` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `broadcasts`
--

CREATE TABLE IF NOT EXISTS `broadcasts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `message` text,
  `date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `btl_parents`
--

CREATE TABLE IF NOT EXISTS `btl_parents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `btl_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

--
-- Table structure for table `btl_promotions`
--

CREATE TABLE IF NOT EXISTS `btl_promotions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `address` varchar(250) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `btl_image` varchar(200) DEFAULT NULL,
  `btl_image_path` varchar(200) DEFAULT NULL,
  `btl_image_status` int(11) DEFAULT NULL,
  `sync_status` varchar(50) DEFAULT NULL,
  `sync_id` varchar(100) DEFAULT NULL,
  `devid` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `city` varchar(255) DEFAULT NULL,
  `stateid` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `company_module`
--

CREATE TABLE IF NOT EXISTS `company_module` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `module_id` varchar(100) DEFAULT NULL,
  `company_id` int(10) DEFAULT NULL,
  `created_ts` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `company_settings`
--

CREATE TABLE IF NOT EXISTS `company_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `retailer_per_page` int(10) DEFAULT NULL,
  `tracking_start_time` time DEFAULT NULL,
  `tracking_end_time` time DEFAULT NULL,
  `retailer_radius_check` int(10) DEFAULT NULL,
  `retailer_radius_enable` tinyint(4) DEFAULT '0',
  `tracking_interval` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `country` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE IF NOT EXISTS `designations` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `designation` varchar(100) NOT NULL,
  `company_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `designation` (`designation`,`company_id`),
  KEY `designation_2` (`designation`,`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `designations_parents`
--

CREATE TABLE IF NOT EXISTS `designations_parents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designation_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE IF NOT EXISTS `feedbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) DEFAULT NULL,
  `company_id` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `message` varchar(250) DEFAULT NULL,
  `sync_id` varchar(50) DEFAULT NULL,
  `sync_status` varchar(20) DEFAULT NULL,
  `created_at` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(50) NOT NULL,
  `module_name` varchar(255) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `submenu` tinyint(4) DEFAULT NULL,
  `web` tinyint(4) DEFAULT NULL,
  `mobile` tinyint(4) NOT NULL,
  `parent_id` tinyint(255) DEFAULT NULL,
  `module_type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `retailer_id` varchar(100) DEFAULT NULL,
  `product_ids` varchar(50) DEFAULT NULL,
  `qty` varchar(50) DEFAULT NULL,
  `prices` varchar(50) DEFAULT NULL,
  `order_amount` double DEFAULT NULL,
  `cheque_paid` double DEFAULT NULL,
  `cash_paid` double DEFAULT NULL,
  `credit` varchar(100) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  `net_amount` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `taxes` float DEFAULT NULL,
  `order_source` varchar(255) DEFAULT NULL,
  `sync_id` varchar(100) DEFAULT NULL,
  `sync_status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `sku` varchar(50) DEFAULT NULL,
  `qty_in_stock` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `discount` varchar(255) DEFAULT NULL,
  `remark` varchar(300) DEFAULT NULL,
  `product_image` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `retailers`
--

CREATE TABLE IF NOT EXISTS `retailers` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `sync_id` varchar(50) DEFAULT NULL,
  `sync_status` varchar(10) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `shop_name` varchar(255) DEFAULT NULL,
  `owner_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `landmark` varchar(100) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `owner_image` varchar(255) DEFAULT NULL,
  `shop_image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `devid` varchar(100) DEFAULT NULL,
  `distributer` varchar(20) DEFAULT NULL,
  `FOS` text,
  `deal_in` varchar(25) DEFAULT NULL,
  `categories` varchar(250) DEFAULT NULL,
  `turn_over` varchar(255) DEFAULT NULL,
  `alt_mobile` varchar(255) DEFAULT NULL,
  `web_latitude` double DEFAULT NULL,
  `web_longitude` double DEFAULT NULL,
  `app_address` text,
  `credit` varchar(255) DEFAULT NULL,
  `retailer_code` varchar(255) DEFAULT NULL,
  `owner_image_phone` varchar(150) DEFAULT NULL,
  `shop_image_phone` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `retailers_parents_users`
--

CREATE TABLE IF NOT EXISTS `retailers_parents_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `designation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `retailer_accounts`
--

CREATE TABLE IF NOT EXISTS `retailer_accounts` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `retailer_id` int(50) DEFAULT NULL,
  `company_id` int(50) DEFAULT NULL,
  `user_id` int(50) DEFAULT NULL,
  `old_credit` varchar(255) DEFAULT NULL,
  `new_credit` varchar(255) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `retailer_daily_visits`
--

CREATE TABLE IF NOT EXISTS `retailer_daily_visits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `retailer_id` varchar(50) DEFAULT NULL,
  `retailer_visit_image` varchar(100) DEFAULT NULL,
  `retailer_visit_image_path` varchar(100) DEFAULT NULL,
  `sync_status` varchar(10) DEFAULT NULL,
  `sync_id` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `country` int(11) unsigned DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `gcmid` text,
  `user_name` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `role` varchar(100) DEFAULT NULL,
  `token_id` int(10) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `confirm_password` varchar(255) DEFAULT NULL,
  `devid` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `login_status` tinyint(4) NOT NULL DEFAULT '0',
  `checkin_status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_name` (`user_name`,`user_password`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_parent`
--

CREATE TABLE IF NOT EXISTS `users_parent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_attendance`
--

CREATE TABLE IF NOT EXISTS `user_attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `user_image` varchar(100) DEFAULT NULL,
  `user_image_path` varchar(100) DEFAULT NULL,
  `time` datetime NOT NULL,
  `status` varchar(50) NOT NULL,
  `sync_status` varchar(15) DEFAULT NULL,
  `sync_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=98 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_current_locations`
--

CREATE TABLE IF NOT EXISTS `user_current_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `created_at` datetime NOT NULL,
  `device_id` varchar(50) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `accuracy` float DEFAULT NULL,
  `provider` varchar(50) DEFAULT NULL,
  `sync_id` varchar(100) DEFAULT NULL,
  `sync_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`created_at`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6578 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `latitude` varchar(1000) NOT NULL,
  `longitude` varchar(1000) NOT NULL,
  `device_info` text NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `profile_image` varchar(255) NOT NULL,
  `shop_photo` varchar(255) NOT NULL,
  `establishdate` date NOT NULL,
  `turnover` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `branch` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_retailers`
--

CREATE TABLE IF NOT EXISTS `user_retailers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `retailer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_tokens`
--

CREATE TABLE IF NOT EXISTS `user_tokens` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_name` (`user_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5005 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

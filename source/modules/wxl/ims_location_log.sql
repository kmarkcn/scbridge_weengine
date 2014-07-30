-- phpMyAdmin SQL Dump
-- http://www.phpmyadmin.net
--
-- 生成日期: 2013 年 07 月 15 日 15:08

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `ZSpyWjDMnfKDOqzsGZVl`
--

-- --------------------------------------------------------

--
-- 表的结构 `ims_location_log`
--

CREATE TABLE IF NOT EXISTS `ims_location_log` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT '用户编号',
  `openid` varchar(255) NOT NULL COMMENT '微信openid',
  `x` varchar(200) NOT NULL COMMENT 'x坐标',
  `y` varchar(200) NOT NULL COMMENT 'y坐标',
  `city` varchar(255) NOT NULL COMMENT '城市名称',
  `date` varchar(30) NOT NULL default '0' COMMENT '更新时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`openid`),
  KEY `email` (`city`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `ims_location_log`
--

INSERT INTO `ims_location_log` (`id`, `openid`, `x`, `y`, `city`, `date`) VALUES
(2, 'fromUser', '23.134521', '113.358803', '广东省,广州市,天河区,翠园路', '2013-07-15 15:05:03'),
(5, 'oBf6CjpuCv9LKoOfHLob_VwXU6lU', '40.804565', '111.702271', '内蒙古自治区,呼和浩特市,赛罕区,鄂尔多斯大街', '2013-07-15 14:38:27');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

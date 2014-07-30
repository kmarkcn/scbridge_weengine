-- phpMyAdmin SQL Dump
-- http://www.phpmyadmin.net
--
-- 生成日期: 2013 年 07 月 19 日 15:57

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `eItvfTJdIlRYxhcDaTjT`
--

-- --------------------------------------------------------

--
-- 表的结构 `ims_modules`
--

CREATE TABLE IF NOT EXISTS `ims_modules` (
  `mid` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL COMMENT '标识',
  `title` varchar(20) NOT NULL COMMENT '名称',
  `ability` varchar(20) NOT NULL COMMENT '功能描述',
  `description` varchar(200) NOT NULL COMMENT '介绍',
  `rulefields` tinyint(1) NOT NULL COMMENT '是否需要扩展规则字段',
  `settings` varchar(1000) NOT NULL default '' COMMENT '扩展设置项',
  `issettings` tinyint(1) unsigned NOT NULL default '0' COMMENT '是否有设置功能',
  `issystem` tinyint(1) unsigned NOT NULL default '0' COMMENT '是否是系统模块',
  PRIMARY KEY  (`mid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `ims_modules`
--

INSERT INTO `ims_modules` (`mid`, `name`, `title`, `ability`, `description`, `rulefields`, `settings`, `issettings`, `issystem`) VALUES
(9, 'wxl', '梦梦系统', '19.3cm开发的一些插件融合', '里面包括了人脸识别，听歌，LBS方面的功能。', 0, '', 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

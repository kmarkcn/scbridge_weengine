CREATE TABLE IF NOT EXISTS `ims_basic_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL DEFAULT '0',
  `content` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_cache` (
  `key` varchar(50) NOT NULL COMMENT '缓存键名',
  `value` varchar(2000) NOT NULL COMMENT '缓存内容',
  PRIMARY KEY (`key`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COMMENT='缓存表';

CREATE TABLE IF NOT EXISTS `ims_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID,0为第一级',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  `icon` varchar(100) NOT NULL DEFAULT '' COMMENT '分类图标',
  `description` varchar(100) NOT NULL DEFAULT '' COMMENT '分类描述',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_fans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from_user` varchar(50) NOT NULL COMMENT '用户的唯一身份ID',
  `realname` varchar(10) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `nickname` varchar(20) NOT NULL DEFAULT '' COMMENT '昵称',
  `avatar` varchar(100) NOT NULL DEFAULT '' COMMENT '头像',
  `qq` varchar(15) NOT NULL DEFAULT '' COMMENT 'QQ号',
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_log_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL COMMENT '微信号ID，关联wechats表',
  `from_user` varchar(50) NOT NULL COMMENT '用户的唯一身份ID',
  `lastupdate` int(10) unsigned NOT NULL COMMENT '用户最后发送信息时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_members` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户编号',
  `username` varchar(30) NOT NULL COMMENT '用户名',
  `password` varchar(200) NOT NULL COMMENT '用户密码',
  `salt` varchar(10) NOT NULL COMMENT '加密盐',
  `email` varchar(80) NOT NULL COMMENT '用户邮箱',
  `newpms` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '新pm数量',
  `avatar` varchar(200) NOT NULL DEFAULT '' COMMENT '用户头像',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '会员状态，0正常，-1禁用',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否管理员，1是，其他否',
  `joindate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户表';

CREATE TABLE IF NOT EXISTS `ims_member_status` (
  `uid` int(10) unsigned NOT NULL COMMENT '用户编号',
  `joinip` varchar(15) NOT NULL DEFAULT '' COMMENT '用户注册时IP',
  `lastvisit` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后一次登录时间',
  `lastip` varchar(15) NOT NULL DEFAULT '' COMMENT '最后一次登录IP',
  `lastpost` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后一次发表文章时间',
  `pquantity` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发表分享数量',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员状态附表';

CREATE TABLE IF NOT EXISTS `ims_modules` (
  `mid` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '标识',
  `title` varchar(20) NOT NULL COMMENT '名称',
  `ability` varchar(20) NOT NULL COMMENT '功能描述',
  `description` varchar(200) NOT NULL COMMENT '介绍',
  `rulefields` tinyint(1) NOT NULL COMMENT '是否需要扩展规则字段',
  `settings` varchar(1000) NOT NULL DEFAULT '' COMMENT '扩展设置项',
  `issettings` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有设置功能',
  `issystem` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否是系统模块',
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_music_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL COMMENT '规则ID',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '介绍',
  `url` varchar(300) NOT NULL DEFAULT '' COMMENT '音乐地址',
  `hqurl` varchar(300) NOT NULL DEFAULT '' COMMENT '高清地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_news_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL,
  `parentid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `thumb` varchar(60) NOT NULL,
  `content` varchar(2000) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_rule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0',
  `cid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',
  `name` varchar(50) NOT NULL DEFAULT '',
  `module` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_rule_keyword` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '规则ID',
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `module` varchar(50) NOT NULL COMMENT '对应模块',
  `content` varchar(255) NOT NULL COMMENT '内容',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型1匹配，2包含，3正则',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_settings` (
  `key` varchar(200) NOT NULL COMMENT '设置键名',
  `value` text NOT NULL COMMENT '设置内容，大量数据将序列化',
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_stat_keyword` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL COMMENT '所属帐号ID',
  `rid` int(10) unsigned NOT NULL COMMENT '规则ID',
  `kid` int(10) unsigned NOT NULL COMMENT '关键字ID',
  `hit` int(10) unsigned NOT NULL COMMENT '命中次数',
  `lastupdate` int(10) unsigned NOT NULL COMMENT '最后触发时间',
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_createtime` (`createtime`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_stat_msg_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL COMMENT '所属帐号ID',
  `rid` int(10) unsigned NOT NULL COMMENT '命中规则ID',
  `kid` int(10) unsigned NOT NULL COMMENT '命中关键字ID',
  `from_user` varchar(50) NOT NULL COMMENT '用户的唯一身份ID',
  `module` varchar(50) NOT NULL COMMENT '命中模块',
  `message` varchar(1000) NOT NULL COMMENT '用户发送的消息',
  `type` varchar(10) NOT NULL DEFAULT '' COMMENT '消息类型',
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_createtime` (`createtime`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_stat_rule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL COMMENT '所属帐号ID',
  `rid` int(10) unsigned NOT NULL COMMENT '规则ID',
  `hit` int(10) unsigned NOT NULL COMMENT '命中次数',
  `lastupdate` int(10) unsigned NOT NULL COMMENT '最后触发时间',
  `createtime` int(10) unsigned NOT NULL COMMENT '记录新建的日期',
  PRIMARY KEY (`id`),
  KEY `idx_createtime` (`createtime`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_userapi_cache` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(32) NOT NULL COMMENT 'apiurl缓存标识',
  `content` varchar(1000) NOT NULL COMMENT '回复内容',
  `lastupdate` int(10) unsigned NOT NULL COMMENT '最后更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_userapi_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL COMMENT '规则ID',
  `apiurl` varchar(300) NOT NULL DEFAULT '' COMMENT '接口地址',
  `default_text` varchar(100) NOT NULL DEFAULT '' COMMENT '默认回复文字',
  `default_apiurl` varchar(300) NOT NULL DEFAULT '' COMMENT '默认回复接口地址',
  `cachetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '返回数据的缓存时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_wechats` (
  `weid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hash` char(5) NOT NULL COMMENT '用户标识. 随机生成保持不重复',
  `uid` int(10) unsigned NOT NULL COMMENT '关联的用户',
  `token` varchar(32) NOT NULL COMMENT '随机生成密钥',
  `name` varchar(30) NOT NULL COMMENT '公众号名称',
  `fans` int(10) unsigned NOT NULL DEFAULT '0',
  `account` varchar(30) NOT NULL COMMENT '微信帐号',
  `original` varchar(50) NOT NULL,
  `signature` varchar(100) NOT NULL COMMENT '功能介绍',
  `country` varchar(10) NOT NULL,
  `province` varchar(3) NOT NULL,
  `city` varchar(15) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `welcome` varchar(1000) NOT NULL,
  `default` varchar(1000) NOT NULL,
  `default_period` tinyint(3) unsigned NOT NULL COMMENT '回复周期时间',
  `lastupdate` int(10) unsigned NOT NULL DEFAULT '0',
  `key` VARCHAR( 25 ) NOT NULL DEFAULT '' COMMENT '第三方用户唯一凭证',
  `secret` VARCHAR( 50 ) NOT NULL DEFAULT '' COMMENT '第三方用户唯一凭证密钥，既appsecret',
  PRIMARY KEY (`weid`),
  UNIQUE KEY `hash` (`hash`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_wechats_modules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `mid` int(10) unsigned NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL,
  `displayorder` tinyint(1) NOT NULL DEFAULT '-1' COMMENT '优先级',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_wxlbs`(
`id` int(10) not null auto_increment comment '地址编号',
`name` varchar(50) not null comment '地址名称',
`description` varchar(200) not null comment '地址描述',
`picture` varchar(50) DEFAULT NULL comment '封面图片',
`showpic` varchar(50) DEFAULT NULL comment '展示大图',
`x_axis` varchar(20) NOT NULL COMMENT 'x坐标',
`y_axis` varchar(20) NOT NULL COMMENT 'y坐标',
`status` tinyint(1) NOT NULL COMMENT '地址状态：1,启用 2,关闭',
`type` tinyint(1) NOT NULL COMMENT '商户类别：1,餐饮 2,娱乐,0其他',
`phone` varchar(20) not null comment '商户电话',
`displayorder` tinyint(3) NOT NULL COMMENT '显示顺序',
`weid` int(10) NOT NULL comment '所属帐号',
`lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
primary key(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `ims_wxwall_members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from_user` varchar(50) NOT NULL COMMENT '用户的唯一身份ID',
  `nickname` varchar(20) NOT NULL DEFAULT '' COMMENT '昵称',
  `avatar` varchar(100) NOT NULL DEFAULT '' COMMENT '头像',
  `rid` int(10) unsigned NOT NULL COMMENT '用户当前所在的微信墙话题',
  `isjoin` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否正在加入话题',
  `isblacklist` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户是否是黑名单',
  `lastupdate` int(10) unsigned NOT NULL COMMENT '用户最后发表时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_wxwall_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL COMMENT '规则ID',
  `from_user` varchar(50) NOT NULL COMMENT '用户的唯一ID',
  `content` varchar(1000) NOT NULL DEFAULT '' COMMENT '用户发表的内容',
  `type` varchar(10) NOT NULL COMMENT '发表内容类型',
  `isshow` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示',
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_wxwall_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL COMMENT '规则ID',
  `enter_tips` varchar(300) NOT NULL DEFAULT '' COMMENT '进入提示',
  `quit_tips` varchar(300) NOT NULL DEFAULT '' COMMENT '退出提示',
  `send_tips` varchar(300) NOT NULL DEFAULT '' COMMENT '发表提示',
  `quit_command` varchar(10) NOT NULL DEFAULT '' COMMENT '退出指令',
  `timeout` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '超时时间',
  `isshow` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否需要审核',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



/* scbridge tables start */
CREATE TABLE IF NOT EXISTS `ims_customer`(
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
`name` varchar(50) NOT NULL COMMENT '姓名',
`mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号码',
`email` varchar(50) NOT NULL DEFAULT '' COMMENT '电子邮箱',
`open_id` varchar(50) NOT NULL COMMENT '用户的唯一身份ID',
`account_balance` decimal(10,2) NOT NULL DEFAULT '0' COMMENT '账户余额',
`status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '用户状态，1正常，0注册未充值，-1错误',
`lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_order_info`(
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
`customer_id` int(10) unsigned NOT NULL COMMENT '用户ID',
`product_id` int(10) unsigned NOT NULL COMMENT '产品ID',
`product_quantity` int(10) unsigned NOT NULL COMMENT '购买数量',
`total_price` decimal(10,2) COMMENT '支付总价格',
`payment_status` int(10) unsigned COMMENT '支付状态',
`payment_type` int(10) unsigned COMMENT '支付类型',
`remarks` varchar(2000) NOT NULL COMMENT '备注',
`lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_goods`(
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
`name` varchar(50) NOT NULL COMMENT '商品名称',
`icon` varchar(100) NOT NULL COMMENT '产品图标',
`good_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '商品类型',
`price` decimal(10,2) NOT NULL COMMENT '支付总价格',
`good_stock` int(10) unsigned COMMENT '商品数量',
`brief_intro` varchar(100) NOT NULL COMMENT '商品简述',
`detailed_intro` varchar(3000) NOT NULL COMMENT '商品详细描述',
`remarks` varchar(2000) NOT NULL COMMENT '备注',
`lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
/* scbridge tables end */


CREATE TABLE IF NOT EXISTS `ims_hotel`(
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
`name` varchar(50) NOT NULL COMMENT '酒店名称',
`level` int(2) NOT NULL COMMENT '酒店等级',
`nation` varchar(50) NOT NULL COMMENT '所在国家',
`city` varchar(50) NOT NULL COMMENT '所在城市',
`address` varchar(200) NOT NULL COMMENT '具体地址',
`description` varchar(2000) NOT NULL COMMENT '酒店介绍',
`icon` varchar(100) COMMENT '酒店图片',
`lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `ims_hotel_room`(
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
`hotel_id` int(10) unsigned NOT NULL COMMENT '所属酒店ID',
`name` varchar(50) NOT NULL COMMENT '房间名称',
`icon` varchar(100) NOT NULL COMMENT '房间图标',
`is_meeting` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否是会议用，0为一般酒店房间，1为会议室',
`min_number` int(4) NOT NULL COMMENT '最少容纳人数',
`max_number` int(4) NOT NULL COMMENT '最多容纳人数',
`description` varchar(200) NOT NULL COMMENT '房间介绍',
`price_normal` decimal(10,2) NOT NULL COMMENT '正常单日价格',
`price_vip` decimal(10,2) NOT NULL COMMENT 'VIP单日价格',
`lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `ims_hotel_booking`(
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
`customer_id` int(10) unsigned NOT NULL COMMENT '用户ID',
`room_id` int(10) unsigned NOT NULL COMMENT '房间ID',
`hotels_account` int(2) NOT NULL COMMENT '房间数量',
`start_date` varchar(50) unsigned NOT NULL DEFAULT '0' COMMENT '入住日期',
`end_date` varchar(50) unsigned NOT NULL DEFAULT '0' COMMENT '退房日期',
`total_price` decimal(10,2) NOT NULL COMMENT '期间总价',
`status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '预定状态，0为正常，-1为已取消',
`remarks` varchar(2000) NOT NULL COMMENT '备注信息',
`lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


/*
	2014-08-08
	by terry
*/

ALTER TABLE `ims_hotel_room` MODIFY min_number int(4) COMMENT '最小人数';
ALTER TABLE `ims_hotel_room` MODIFY max_number int(4) COMMENT '最大人数';


/*
	2014-08-21
	by terry
	增加商品订单表
*/

CREATE TABLE IF NOT EXISTS `ims_goods_booking`(
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
`customer_id` int(10) unsigned NOT NULL COMMENT '用户ID',
`goods_id` int(10) unsigned NOT NULL COMMENT '商品ID',
`goods_number` int(2) NOT NULL COMMENT '商品数量',
`total_price` decimal(10,2) NOT NULL COMMENT '商品总价',
`status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '预定状态，0为正常，-1为已取消',
`address` varchar(2000) NOT NULL COMMENT '地址信息',
`lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

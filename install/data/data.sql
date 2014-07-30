INSERT INTO `ims_modules` (`mid`, `name`, `title`, `ability`, `description`, `rulefields`, `settings`, `issettings`, `issystem`) VALUES
(1, 'basic', '基本文字回复', '和您进行简单对话', '一问一答得简单对话. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的回复内容.', 1, '', 0, 1),
(2, 'news', '基本混合图文回复', '为你提供生动的图文资讯', '一问一答得简单对话, 但是回复内容包括图片文字等更生动的媒体内容. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的图文回复内容.', 1, '', 0, 1),
(3, 'simsimi', '小黄鸡自动回复', '最具智能化的自动陪聊系统', '一款趣味游戏，游戏中的机器人是一个能够和你聊天解闷的可爱机器人，为您的生活提供服务、甚至你还可以逗弄她，并且能实现自然语言的交互。', 0, '', 0, 0),
(4, 'music', '基本语音回复', '提供语音、音乐等音频类回复', '在回复规则中可选择具有语音、音乐等音频类的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝，实现一问一答得简单对话。', 1, '', 0, 1),
(5, 'wxapi', '乐享接口回复', '乐享微信营销管理平台与微擎管理系统的兼容服务', '微擎将试水与第三方管理平台进行战略融合，更好的服务于广大的微信公众平台用户。微擎内置模块的优先级高于其他平台接口，微擎无法处理的对话内容将交于第三方平台处理。', 0, '', 0, 0),
(6, 'userapi', '自定义接口回复', '更方便的第三方接口设置', '自定义接口又称第三方接口，可以让开发者更方便的接入微擎系统，高效的与微信公众平台进行对接整合。', 1, '', 1, 0),
(7, 'wxwall', '微信墙', '可以实时同步显示现场参与者发送的微信', '微信墙又称微信大屏幕，是在展会、音乐会、婚礼现场等场所展示特定主题微信的大屏幕，大屏幕上可以同步显示现场参与者发送的微信，使场内外观众能够第一时间传递和获取现场信息。', 1, '', 0, 0);
INSERT INTO `ims_wechats` (`weid`, `hash`, `uid`, `token`, `name`, `fans`, `account`, `original`, `welcome`, `default`, `default_period`, `lastupdate`) VALUES(1, '3f00e', 1, '7c14dfa66f7593f56be07127a6aa7f01', '默认公众号', 0, '默认公众号', '', '欢迎信息', '默认回复', 10, 0);
INSERT INTO `ims_rule` (`id`, `weid`, `name`, `module`) VALUES(1, 1, '默认文字回复', 'basic');
INSERT INTO `ims_rule` (`id`, `weid`, `name`, `module`) VALUES(2, 1, '默认图文回复', 'news');
INSERT INTO `ims_rule_keyword` (`id`, `rid`, `weid`, `module`, `content`, `type`) VALUES
(1, 1, 1, 'basic', '文字', 2),
(2, 2, 1, 'news', '图文', 2);
INSERT INTO `ims_basic_reply` (`id`, `rid`, `content`) VALUES(1, 1, '这里是默认文字回复');
INSERT INTO `ims_news_reply` (`id`, `rid`, `parentid`, `title`, `description`, `thumb`, `content`, `url`) VALUES(1, 2, 0, '这里是默认图文回复', '这里是默认图文描述', 'images/2013/01/d090d8e61995e971bb1f8c0772377d.png', '这里是默认图文原文这里是默认图文原文这里是默认图文原文', '');
INSERT INTO `ims_news_reply` (`id`, `rid`, `parentid`, `title`, `description`, `thumb`, `content`, `url`) VALUES(2, 2, 1, '这里是默认图文回复内容', '', 'images/2013/01/112487e19d03eaecc5a9ac87537595.jpg', '这里是默认图文回复原文这里是默认图文回复原文<br />', '');
INSERT INTO `ims_wechats_modules` (`weid`, `mid`, `enabled`, `displayorder`) VALUES
(1, 1, 1, -1),
(1, 2, 1, -1),
(1, 4, 1, -1);
INSERT INTO `ims_cache` (`key`, `value`) VALUES
('setting:stat', 'a:3:{s:11:"msg_history";s:1:"1";s:10:"msg_maxday";s:1:"0";s:9:"use_ratio";s:1:"1";}'),
('hooks:1', 'a:1:{s:6:"before";a:1:{i:0;a:2:{i:0;s:6:"wxwall";i:1;s:10:"hookBefore";}}}');
INSERT INTO `ims_settings` (`key`, `value`, `description`) VALUES
('stat', 'a:3:{s:11:"msg_history";s:1:"1";s:10:"msg_maxday";s:1:"0";s:9:"use_ratio";s:1:"1";}', '');

INSERT INTO `ims_property_website` (`id`, `module_name`, `parentid`) VALUES (1, '关于麓山物业', 0);
INSERT INTO `ims_property_website` (`id`, `module_name`, `parentid`) VALUES (2, '麓山国际社区', 0);
INSERT INTO `ims_property_website` (`id`, `module_name`, `parentid`) VALUES (3, '麓湖生态城', 0);
INSERT INTO `ims_property_website` (`id`, `module_name`, `parentid`) VALUES (4, '公司简介', 1);
INSERT INTO `ims_property_website` (`id`, `module_name`, `parentid`) VALUES (5, '公司荣誉', 1);
INSERT INTO `ims_property_website` (`id`, `module_name`, `parentid`) VALUES (6, '公司要闻', 1);
INSERT INTO `ims_property_website` (`id`, `module_name`, `parentid`) VALUES (7, '社区服务', 2);
INSERT INTO `ims_property_website` (`id`, `module_name`, `parentid`) VALUES (8, '温馨告知', 2);
INSERT INTO `ims_property_website` (`id`, `module_name`, `parentid`) VALUES (9, '业主留言', 2);
INSERT INTO `ims_property_website` (`id`, `module_name`, `parentid`) VALUES (10, '生活黄页', 2);
INSERT INTO `ims_property_website` (`id`, `module_name`, `parentid`) VALUES (11, '社区服务', 3);
INSERT INTO `ims_property_website` (`id`, `module_name`, `parentid`) VALUES (12, '温馨告知', 3);
INSERT INTO `ims_property_website` (`id`, `module_name`, `parentid`) VALUES (13, '业主留言', 3);
INSERT INTO `ims_property_website` (`id`, `module_name`, `parentid`) VALUES (14, '生活黄页', 3);
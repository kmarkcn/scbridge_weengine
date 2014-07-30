<?php 
/**
 * 更新系统配置
 * 更新模板缓存
 * 更新模块挂勾
 * ...
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */

if (checksubmit('submit')) {
	if (in_array('data', $_GPC['type'])) {
		setting_updatecache_data();
	}
	if (in_array('template', $_GPC['type'])) {
		setting_updatecache_tpl();
	}
	message('缓存更新成功！', create_url('setting/updatecache'));
} else {
	template('setting/updatecache');
}
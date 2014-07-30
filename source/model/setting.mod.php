<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');
/**
 * 从数据库中加载设置信息存至 cache 中 setting:分组下，并加载设置信息至全局变量 $_W['setting'] 下
 * @params 如果指定key，则单独加载某一项设置信息
 * @params mixed
 */
function setting_load($key = '') {
	global $_W;
	if(empty($key)) {
		cache_load('setting:');
		if(empty($_W['cache']['setting'])) {
			$sql = 'SELECT * FROM ' . tablename('settings');
			$ds = pdo_fetchall($sql);
			if(is_array($ds)) {
				foreach($ds as $k => &$v) {
					$v['value'] = iunserializer($v['value']);
					$_W['setting'][$v['key']] = $v;
					cache_write("setting:{$v['key']}", $v['value']);
				}
			}
		}
		$_W['setting'] = &$_W['cache']['setting'];
		return $_W['setting'];
	} else {
		cache_load("setting:{$key}");
		if(empty($_W['cache']['setting'][$key])) {
			$sql = 'SELECT * FROM ' . tablename('settings') . ' WHERE `key`=:key';
			$params = array();
			$params[':key'] = $key;
			$record = pdo_fetch($sql, $params);
			if(!empty($record)) {
				$record['value'] = iunserializer($record['value']);
				cache_write("setting:{$key}", $record['value']);
			}
		} else {
			$record['value'] = $_W['cache']['setting'][$key];
		}
		$_W['setting'] = &$_W['cache']['setting'];
		return $record['value'];
	}
}

/**
 * 将设置信息保存至数据库，将会同时更新全局变量 $_W['setting']，过期缓存
 * @param mixed $data 如果提供 $data，则将 $data 做为指定键的 $key 的值来更新
 * @param string $key 如果提供 $key，则至更新指定键名
 * @return void
 */
function setting_save($data = '', $key = '') {
	if (empty($data) && empty($key)) {
		return FALSE;
	}
	if (is_array($data) && empty($key)) {
		foreach ($data as $key => $value) {
			$record[] = "('$key', '".iserializer($value)."')";
		}
		if ($record) {
			$return = pdo_query("REPLACE INTO ".tablename('settings')." (`key`, `value`) VALUES " . implode(',', $record));
		}
		$return && cache_clean('setting');
	} else {
		$record = array();
		$record['key'] = $key;
		$record['value'] = iserializer($data);
		$return = pdo_insert('settings', $record, TRUE);
		$return && cache_delete("setting:{$key}");
	}
	return $return;
}

function setting_modules() {
	global $_W;
	$_W['setting']['modules'] = (array)pdo_fetchall("SELECT * FROM ".tablename('modules'), array(), 'name');
	return $_W['setting']['modules'];
}

function setting_updatecache_data() {
	global $_W;
	//更新帐号
	$sql = "SELECT * FROM " . tablename('wechats') . " WHERE uid = '{$_W['uid']}' ORDER BY `weid` DESC";
	$wechats = pdo_fetchall($sql, array(), 'weid');
	if(is_array($wechats)) {
		cache_write('setting:wechats', iserializer($wechats));
	}
	$modules = pdo_fetchall("SELECT * FROM " . tablename('modules') . ' ORDER BY `mid` ASC', array(), 'name');
	//根据帐号写入缓存
	if (!empty($wechats)) {
		foreach ($wechats as $index => $row) {
			$modulecache = array();
			$mymodules = pdo_fetchall("SELECT mid, enabled, displayorder FROM ".tablename('wechats_modules')." WHERE weid = '{$row['weid']}' AND enabled = '1'", array(), 'mid');
			if (!empty($mymodules)) {
				foreach ($modules as $name => $module) {
					if (empty($mymodules[$module['mid']])) {
						continue;
					}
					$mymodules[$module['mid']]['displayorder'] >= 0 && $module['displayorder'] = $mymodules[$module['mid']]['displayorder'];
					$modulecache[$module['name']] = $module;
				}
				if(is_array($modulecache)) {
					cache_write('setting:modules:'.$row['weid'], iserializer($modulecache));
				}
			}
		}
		unset($row);
	}
	//更新公告缓存
	cache_clean('announcement');
	if (!empty($modules) || !empty($wechats)) {
		foreach ($modules as $mid => $module) {
			$file = IA_ROOT . "/source/modules/{$module['name']}/processor.php";
			if (!file_exists($file)) {
				continue;
			}
			include_once $file;
		}
			
		$classes = get_declared_classes();
		$classnames = $hooks =array();
		$namekey = 'ModuleProcessor';
		$namekeyLen = strlen($namekey);
			
		foreach($classes as $classname) {
			if(substr($classname, -$namekeyLen) == $namekey) {
				$classnames[] = $classname;
			}
		}
		foreach($classnames as $index => $classname) {
			$methods = get_class_methods($classname);
			foreach($methods as $funcname) {
				preg_match('/hook(.*)/', $funcname, $match);
				if (empty($match[1])) {
					continue;
				}
				foreach ($wechats as $index => $row) {
					$hookname = strtolower($match[1]);
					$mymodules = pdo_fetchall("SELECT a.mid, b.name FROM ".tablename('wechats_modules')." AS a LEFT JOIN ".tablename('modules')." AS b ON a.mid = b.mid WHERE a.weid = '{$row['weid']}' AND a.enabled = '1'", array(), 'name');
					$modulename = strtolower(str_replace($namekey, '', $classname));
					if (in_array($modulename, array_keys($mymodules))) {
						$hooks[$row['weid']][$hookname][] = array($modulename, $funcname);
					}
				}
			}
		}
		if (!empty($hooks)) {
			foreach ($hooks as $weid => $hook) {
				cache_write('hooks:'.$weid, $hook);
			}
		}
	}
	//更新分类
	$cache = pdo_fetchall("SELECT * FROM ".tablename('category')." WHERE weid = '{$_W['weid']}'", array(), 'id');
	cache_write('category:'.$_W['weid'], $cache);
}

function setting_updatecache_tpl() {
	//更新模板
	rmdirs(IA_ROOT . '/data/tpl/default', true);
}

function setting_updatecache_hook($weid) {
	$mymodules = pdo_fetchall("SELECT a.mid, b.name FROM ".tablename('wechats_modules')." AS a LEFT JOIN ".tablename('modules')." AS b ON a.mid = b.mid WHERE a.weid = '{$weid}' AND a.enabled = '1'", array(), 'name');
	foreach ($mymodules as $mid => $module) {
		$file = IA_ROOT . "/source/modules/{$module['name']}/processor.php";
		if (!file_exists($file)) {
			continue;
		}
		include_once $file;
	}
		
	$classes = get_declared_classes();
	$classnames = $hooks =array();
	$namekey = 'ModuleProcessor';
	$namekeyLen = strlen($namekey);
		
	foreach($classes as $classname) {
		if(substr($classname, -$namekeyLen) == $namekey) {
			$classnames[] = $classname;
		}
	}
	foreach($classnames as $index => $classname) {
		$methods = get_class_methods($classname);
		foreach($methods as $funcname) {
			preg_match('/hook(.*)/', $funcname, $match);
			if (empty($match[1])) {
				continue;
			}
			$hookname = strtolower($match[1]);
			$modulename = strtolower(str_replace($namekey, '', $classname));
			if (in_array($modulename, array_keys($mymodules))) {
				$hooks[$hookname][] = array($modulename, $funcname);
			}
		}
	}
	if (!empty($hooks)) {
		cache_write('hooks:'.$weid, $hooks);
	}
}

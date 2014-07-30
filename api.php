<?php
/**
 * 接口文件
 * 
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
define('IN_IA', true); 
define('IA_ROOT', str_replace("\\",'/', dirname(__FILE__)));
define('MAGIC_QUOTES_GPC', (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) || @ini_get('magic_quotes_sybase'));
define('TIMESTAMP', time());
error_reporting(0);

$_W = array();
//兼容BAE平台
if (!empty($_SERVER['HTTP_BAE_ENV_APPID'])) {
	$_W['platform'] = 'bae';
	$_W['bae'] = TRUE;
}
if (!empty($_W['platform'])) {
	$configfile = IA_ROOT . "/data/config.{$_W['platform']}.php";
} else {
	$configfile = IA_ROOT . "/data/config.php";
}

if(!is_file($configfile) && file_exists(IA_ROOT . '/install/index.php')){
	exit('Access Denied');
}

$_W['timestamp'] = TIMESTAMP;
$_W['template']['current'] = 'default';
$_W['template']['source'] = IA_ROOT . '/themes';
$_W['template']['compile'] = IA_ROOT . '/data/tpl';

require $configfile;
require IA_ROOT . '/source/regular.inc.php';
require IA_ROOT . '/source/function/global.func.php';
require IA_ROOT . '/source/function/compat.func.php';
require IA_ROOT . '/source/function/file.func.php';
require IA_ROOT . '/source/function/template.func.php';
require IA_ROOT . '/source/function/pdo.func.php';
require IA_ROOT . '/source/function/communication.func.php';
require IA_ROOT . '/source/modules/engine.php';

$_W['token'] = token();
$pdo = $_W['pdo'] = null;
$_W['config'] = $config;
$_W['charset'] = $_W['config']['setting']['charset'];
unset($config);

require IA_ROOT . '/source/function/cache.func.php';
require IA_ROOT . '/source/model/setting.mod.php';
require IA_ROOT . '/source/model/member.mod.php';
require IA_ROOT . '/source/model/rule.mod.php';

if(!in_array($_W['config']['setting']['cache'], array('mysql', 'file'))) {
	$_W['config']['setting']['cache'] = 'mysql';
}
if(!empty($_W['setting']['template']['current'])) {
	$_W['template']['current'] = $_W['setting']['template']['current'];
}
if(!empty($_W['config']['memory_limit']) && function_exists('ini_get') && function_exists('ini_set')) {
	if(@ini_get('memory_limit') != $_W['config']['memory_limit']) {
		@ini_set('memory_limit', $_W['config']['memory_limit']);
	}
}
$sitepath = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
$_W['siteroot'] = htmlspecialchars('http://'.$_SERVER['HTTP_HOST'].$sitepath);
if($_SERVER['SERVER_PORT'] != '80' && empty($_W['platform'])) {
	$_W['siteroot'] .= ":{$_SERVER['SERVER_PORT']}/";
} else {
	$_W['siteroot'] .= '/';
}
$_W['attachurl'] = empty($_W['config']['upload']['attachurl']) ? $_W['siteroot'] . $_W['config']['upload']['attachdir'] : $_W['config']['upload']['attachurl'];
$_W['isajax'] = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
$_W['ispost'] = $_SERVER['REQUEST_METHOD'] == 'POST';
if(MAGIC_QUOTES_GPC) {
	$_GET = istripslashes($_GET);
	$_POST = istripslashes($_POST);
	$_COOKIE = istripslashes($_COOKIE);
}
$_GPC = array();
$cplen = strlen($_W['config']['cookie']['pre']);
foreach($_COOKIE as $key => $value) {
	if(substr($key, 0, $cplen) == $_W['config']['cookie']['pre']) {
		$_GPC[substr($key, $cplen)] = $value;
	}
}
unset($cplen);
$_GPC = array_merge($_GET, $_POST, $_GPC);

$sql = "SELECT `weid`,`hash`,`token`,`default_period` FROM " . tablename('wechats') . " WHERE `hash`=:hash LIMIT 1";
$_W['account'] = pdo_fetch($sql, array(':hash' => $_GPC['hash']));
if(empty($_W['account'])) {
	exit('Access Denied');
}
$_W['weid'] = $_W['account']['weid'];
$_W['account']['modules'] = member_modules();
setting_modules();
$engine = new WeEngine();
$engine->start();
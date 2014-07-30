<?php
/**
 * lbs设置
 * 
 * @author Guo Feng
 */

require './source/bootstrap.inc.php';

checklogin();
checkaccount();

$actions = array();
if(!empty($_W['uid'])) {
	$actions = array('display', 'post', 'delete');
	$action = in_array($_GPC['act'], $actions) ? $_GPC['act'] : 'display';
} else {
	header('Location: '.create_url('member/login', array('referer' => $_W['script_name'])));
}

$controller = 'lbs';
$nav[$action] = ' class="current"';
require router($controller, $action);
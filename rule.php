<?php
/**
 * 规则管理
 * 
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
require './source/bootstrap.inc.php';
checklogin();
checkaccount();
$actions = array('display', 'post', 'system', 'delete');
$action = in_array($_GPC['act'], $actions) ? $_GPC['act'] : 'display';
$controller = 'rule';
$nav[$action] = ' class="current"';
require router($controller, $action);

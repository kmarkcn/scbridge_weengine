<?php
/**
 * 用户管理
 * 
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
require './source/bootstrap.inc.php';
checklogin();
checkaccount();

$actions = array('designer', 'search');
$action = $_GET['act'];
$action = in_array($action, $actions) ? $action : 'designer';

$controller = 'menu';
$nav[$action] = ' class="current"';
require router($controller, $action);

<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');

function location_search($weid = 0) {
	global $_W;
	$sql = "SELECT * FROM " . tablename('wxlbs') . " WHERE weid = '$weid' ORDER BY `displayorder`";
	$ds = pdo_fetchall($sql, array(), 'name');
	return $ds;
}

function location_search_bytype($weid = 0, $type = 0) {
	global $_W;
	$sql = "SELECT * FROM " . tablename('wxlbs') . " WHERE weid = '$weid' and type = '$type' ORDER BY `displayorder`";
	$ds = pdo_fetchall($sql, array(), 'name');
	return $ds;
}
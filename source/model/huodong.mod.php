<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');

function huodong_search($weid = 0) {
	global $_W;
	$sql = "SELECT * FROM " . tablename('wxhuodong') . " WHERE weid = '$weid' ORDER BY `end_date` DESC";
	$ds = pdo_fetchall($sql, array(), 'id');
	return $ds;
}
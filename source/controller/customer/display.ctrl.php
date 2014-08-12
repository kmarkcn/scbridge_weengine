<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');
global $_W;

$sql_1 = "SELECT * FROM " . tablename('customer');
$customers = pdo_fetchall($sql_1);






template('customer/display');
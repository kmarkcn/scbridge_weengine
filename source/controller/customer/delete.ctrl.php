<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');
$id = intval($_GPC['id']);

$account = pdo_fetch("SELECT * FROM ".tablename('customer')." WHERE id = '$id'");
if (empty($account)) {
	message('抱歉，会员不存在或是已经被删除', create_url('customer/display'), 'error');
}
pdo_delete('customer', array('id' => $id));
message('会员信息删除成功！', create_url('customer/display'));


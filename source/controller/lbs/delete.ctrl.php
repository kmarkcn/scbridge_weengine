<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');
$id = intval($_GPC['id']);

$account = pdo_fetch("SELECT * FROM ".tablename('wxlbs')." WHERE id = '$id'");
if (empty($account)) {
	message('抱歉，商户不存在或是已经被删除', create_url('wxlbs/display'), 'error');
}
pdo_delete('wxlbs', array('id' => $id));
message('商户信息删除成功！', create_url('lbs/display'));


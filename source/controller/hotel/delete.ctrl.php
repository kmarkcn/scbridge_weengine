<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');
$id = intval($_GPC['id']);

$account = pdo_fetch("SELECT * FROM ".tablename('hotel')." WHERE id = '$id'");
if (empty($account)) {
	message('抱歉，酒店不存在或是已经被删除', create_url('hotel/display'), 'error');
}
pdo_delete('hotel', array('id' => $id));
pdo_delete('hotel_room', array('hotel_id' => $id));
message('酒店信息删除成功！', create_url('hotel/display'));


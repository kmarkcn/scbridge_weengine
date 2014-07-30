<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');
$id = intval($_GPC['room_id']);
$account = pdo_fetch("SELECT * FROM ".tablename('hotel_room')." WHERE id = '$id'");
if (empty($account)) {
	message('抱歉，房间不存在或是已经被删除', create_url('hotel/display'), 'error');
}
pdo_delete('hotel_room', array('id' => $id));
message('房间信息删除成功！', create_url('hotel/display'));



<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');
$id = intval($_GPC['id']);

$account = pdo_fetch("SELECT * FROM ".tablename('goods')." WHERE id = '$id'");
if (empty($account)) {
	message('抱歉，商品不存在或是已经被删除', create_url('goods/display'), 'error');
}
pdo_delete('goods', array('id' => $id));
message('商品信息删除成功！', create_url('goods/display'));


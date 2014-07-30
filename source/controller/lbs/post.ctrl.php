<?php
/**
 * @author Guo Feng
 */
defined('IN_IA') or exit('Access Denied');
$id = intval($_GPC['id']);

if (checksubmit('submit')) {
	if (empty($_GPC['name'])) {
		message('抱歉，请填写商户名称！');
	}
	$data = array(
		'name' => $_GPC['name'],
		'description' => $_GPC['description'],
		'address' => $_GPC['address'],
		'picture' => (!empty($_GPC['picture'])) ? $_GPC['picture'] : NULL,
		'showpic' => (!empty($_GPC['showpic'])) ? $_GPC['showpic'] : NULL,
		'x_axis' => $_GPC['x_axis'],
		'y_axis' => $_GPC['y_axis'],
		'phone' => $_GPC['phone'],
		'weid' => $_W['weid'],
		'status' => 1,
		'type' => $_GPC['type'],
		'displayorder' => $_GPC['displayorder'],
	);
	if (!empty($id)) {
		if (pdo_update('wxlbs', $data, array('id' => $id))) {
			message('更新商户成功！', create_url('lbs/display'));
		}
	} else {
		if (pdo_insert('wxlbs', $data)) {
			message('添加商户成功！', create_url('lbs/display'));
		}
	}
	message('商户管理操作失败！', create_url('lbs/display'), 'error');

} else {
	if (!empty($id)) {
		$loc = pdo_fetch("SELECT * FROM ".tablename('wxlbs')." WHERE id = '$id'");
	}
	template('lbs/post');
}
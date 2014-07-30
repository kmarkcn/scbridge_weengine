<?php
/**
 * @author Guo Feng
 */
defined('IN_IA') or exit('Access Denied');
$id = intval($_GPC['id']);

if (checksubmit('submit')) {
	//这里的控制器要判断是否含有提交这个选项，如果存在，那么进行数据处理，如果不存在，那么进行普通的显示页面
	$lastupdate=time();
	$lastupdate=date('y-m-d h:i:s',$lastupdate);
	

$data=array(
		'name'=>$_GPC['name'],
		'icon'=>(!empty($_GPC['picture'])) ? $_GPC['picture'] : NULL,
		'nation'=>$_GPC['nation'],
		'city'=>$_GPC['city'],
		'address'=>$_GPC['address'],
		'level'=>$_GPC['level'],
		'description'=>$_GPC['description'],
		'lastupdate'=>$lastupdate,
	);
	
	if(!empty($id)) {
		if (pdo_update('hotel', $data, array('id' => $id))) {
			message('更新酒店成功！', create_url('hotel/display'));
		}
	}else{
		if(pdo_insert('hotel', $data)) {
			message('添加酒店成功！', create_url('hotel/display'));
		}
	}
	
} else {
	if (!empty($id)) {
		$hotel = pdo_fetch("SELECT * FROM ".tablename('hotel')." WHERE id = '$id'");
	}
	template('hotel/post');
}
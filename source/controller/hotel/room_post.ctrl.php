<?php
defined('IN_IA') or exit('Access Denied');
$id = intval($_GPC['id']);
$room_id=$_GPC['room_id'];
if(checksubmit('submit')) {
	//这里的控制器要判断是否含有提交这个选项，如果存在，那么进行数据处理，如果不存在，那么进行普通的显示页面
	$lastupdate=time();
	$lastupdate=date('y-m-d h:i:s',$lastupdate);
	$data=array(
		'hotel_id'=>$id,
		'name'=>$_GPC['name'],
		'icon'=>(!empty($_GPC['picture'])) ? $_GPC['picture'] : NULL,
		'is_meeting'=>$_GPC['ismeeting'],
		'min_number'=>$_GPC['min_number'],
		'max_number'=>$_GPC['max_number'],
		'price_normal'=>$_GPC['price_normal'],
		'price_vip'=>$_GPC['price_vip'],
		'description'=>$_GPC['description'],
		'lastupdate'=>$lastupdate,
	);
	if(!empty($room_id)) {
		if (pdo_update('hotel_room', $data, array('id' => $room_id))) {
			message('更新房间成功！', create_url('hotel/display'));
		}
	}else{
		if(pdo_insert('hotel_room', $data)) {
			message('添加房间成功！', create_url('hotel/display'));
		}
	}

}else{
	$hotel = pdo_fetch("SELECT * FROM ".tablename('hotel')." WHERE id = '$id'");
	$room=pdo_fetch("SELECT * FROM ".tablename('hotel_room')." WHERE id = '$room_id'");
	template('hotel/room_post');
}
	

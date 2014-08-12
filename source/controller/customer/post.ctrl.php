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
		'good_type'=>$_GPC['good_type'],
		'price'=>$_GPC['price'],
		'brief_intro'=>$_GPC['brief_intro'],
		'detailed_intro'=>$_GPC['detailed_intro'],
		'good_stock'=>$_GPC['good_stock'],
		'remarks'=>$_GPC['remarks'],
		'lastupdate'=>$lastupdate,
	);
	
	if(!empty($id)) {
		if (pdo_update('goods', $data, array('id' => $id))) {
			message('更新商品成功！', create_url('goods/display'));
		}
	}else{
		if(pdo_insert('goods', $data)) {
			message('添加商品成功！', create_url('goods/display'));
		}
	}
	
} else {
	if (!empty($id)) {
		$goods = pdo_fetch("SELECT * FROM ".tablename('goods')." WHERE id = '$id'");
	}
	template('goods/post');
}
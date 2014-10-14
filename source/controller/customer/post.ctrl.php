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
	
/* if($_GPC['account_balance']>0){
	$_GPC['status'] = 1;
} */
	
$data=array(
		'name'=>$_GPC['name'],
		'mobile'=>$_GPC['mobile'],
		'status'=>$_GPC['status'],
		'account_balance'=>$_GPC['account_balance'],
		'lastupdate'=>$lastupdate,
	);
	
	if(!empty($id)) {
		if (pdo_update('customer', $data, array('id' => $id))) {
			message('更新资料成功！', create_url('customer/display'));
		}
	}
} else {
	if (!empty($id)) {
		$customer = pdo_fetch("SELECT * FROM ".tablename('customer')." WHERE id = '$id'");
	}
	template('customer/post');
}
<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');
$id = intval($_GPC['id']);
$type=$_GPC['type'];
if($type=="hotel")
{
    $account = pdo_fetch("SELECT * FROM ".tablename('hotel_booking')." WHERE id = '$id'");
    if (empty($account)) {
        message('抱歉，订单不存在或是已经被删除', create_url('booking/display'), 'error');
    }
    pdo_delete('hotel_booking', array('id' => $id));
    message('订单信息删除成功！', create_url('booking/display'));
}
else if($type=="goods")
{
   
    $account = pdo_fetch("SELECT * FROM ".tablename('goods_booking')." WHERE id = '$id'");
    if (empty($account)) {
        message('抱歉，订单不存在或是已经被删除', create_url('booking/display'), 'error');
    }
    pdo_delete('goods_booking', array('id' => $id));
    message('订单信息删除成功！', create_url('booking/display'));
    
}


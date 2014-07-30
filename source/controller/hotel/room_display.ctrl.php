<?php

defined('IN_IA') or exit('Access Denied');
$id = intval($_GPC['id']);
$hotel = pdo_fetch("SELECT * FROM ".tablename('hotel')." WHERE id = '$id'");

$page=$_GPC['page'];
//这里先要算一下总页数
$pagenum=6;
$sql_0="select count(*) as total_number from ims_hotel_room where hotel_id = ".$id;
$numbers=pdo_fetch($sql_0);
$page_total=ceil($numbers['total_number']/$pagenum);
if(empty($page)){
	$page=1;
}
if($page>=$page_total){
	$page=$page_total;
}
$page_pro=$page-1;
$page_next=$page+1;
//这个是查询当前旅游产品的信息
$start_num=($page-1)*$pagenum;
$sql_1 = "SELECT * FROM " . tablename('hotel_room')."where hotel_id= ".$id." limit ".$start_num.",".$pagenum;
$rooms = pdo_fetchall($sql_1);
template('hotel/room_display');


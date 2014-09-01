<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');
global $_W;
$id = $_GET['id'];


	

    $sql_2 = "SELECT * FROM  ims_goods_booking where id = {$id}";
    $goods = pdo_fetch($sql_2);
    $customerMsg = pe_fetchOneByField("customer","name,mobile","id",$goods['customer_id']);
    $goods["tel"] = $customerMsg["mobile"];
    $goods["cus"] = $customerMsg["name"];
    $goodMsg = pe_fetchOneByField("goods","name","id",$goods['goods_id']);
    $goods['name'] = $goodMsg["name"];
       
	
    
    template('booking/goods');



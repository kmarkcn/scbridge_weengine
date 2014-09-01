<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');
global $_W;



	$sql_1 = "SELECT * FROM ims_hotel_booking order by id desc";
    $hotels = pdo_fetchall($sql_1);
    foreach ($hotels  as $key =>$val)
    {
    	$customerMsg = pe_fetchOneByField("customer","name,mobile","id",$hotels[$key]['customer_id']);
    	$hotels[$key]["tel"] = $customerMsg["mobile"];
    	$hotels[$key]["name"] = $customerMsg["name"];
    	$hotelMsg = pe_fetchOneByField("hotel_room","hotel_id,name","id",$hotels[$key]['room_id']);
    	$hotels[$key]['room'] = $hotelMsg["name"];
    	$hotelMsgs = pe_fetchOneByField("hotel","name","id",$hotelMsg["hotel_id"]);
    	$hotels[$key]['hotel'] =$hotelMsgs['name'];
    }

    $sql_2 = "SELECT * FROM ims_goods_booking order by id desc";
    $goods = pdo_fetchall($sql_2);
    foreach ($goods  as $key =>$val)
    {
        $customerMsg = pe_fetchOneByField("customer","name,mobile","id",$goods[$key]['customer_id']);
        $goods[$key]["tel"] = $customerMsg["mobile"];
        $goods[$key]["cus"] = $customerMsg["name"];
        $goodMsg = pe_fetchOneByField("goods","name","id",$goods[$key]['goods_id']);
        $goods[$key]['name'] = $goodMsg["name"];
       
    }
    
    template('booking/display');



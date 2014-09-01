<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');
global $_W;

$id = $_GET['id'];

	$sql_1 = "SELECT * FROM  ims_hotel_booking where id = {$id}";
    $hotels = pdo_fetch($sql_1);
   
    	$customerMsg = pe_fetchOneByField("customer","name,mobile","id",$hotels['customer_id']);
    	$hotels["tel"] = $customerMsg["mobile"];
    	$hotels["name"] = $customerMsg["name"];
    	$hotelMsg = pe_fetchOneByField("hotel_room","hotel_id,name","id",$hotels['room_id']);
    	$hotels['room'] = $hotelMsg["name"];
    	$hotelMsgs = pe_fetchOneByField("hotel","name","id",$hotelMsg["hotel_id"]);
    	$hotels['hotel'] =$hotelMsgs['name'];
    

    
    template('booking/detail');



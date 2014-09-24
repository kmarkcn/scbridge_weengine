<?php
include_once ("WxPayHelper.php");

$commonUtil = new CommonUtil();


$options = array(
    'APPID' => 'wx630b00407e8a7d9b' ,
    'APPSERCERT' => '4c61880520f2f8946dcad5de98071dd8',
    'APPKEY' => 'TbUai9pHRVLwSV8JujYgTqk8gwDCoceBfnzt0Vo0OdBLHPU78wHMEecg8JcgOL7OZJuUt6yiUChYRxsnfrs0cP93hVUyyn5MQVR0zBf0yrY7U0HllxNTJycKXFjAMoSQ',
    'SIGNTYPE' => 'sha1',
    'PARTNERKEY' => '8e8a8f17d2ea8c30ee329947fc8751da'
);


$wxPayHelper = new WxPayHelper( $options);

$wxPayHelper->setParameter ( "bank_type", "WX" );
$wxPayHelper->setParameter ( "body", "测试商品" );
$wxPayHelper->setParameter ( "partner", "1220727201" );
$wxPayHelper->setParameter ( "out_trade_no", $commonUtil->create_noncestr () );
$wxPayHelper->setParameter ( "total_fee", "1" );
$wxPayHelper->setParameter ( "fee_type", "1" );
$wxPayHelper->setParameter ( "notify_url", "http://www.baidu.com" );
$wxPayHelper->setParameter ( "spbill_create_ip", '127.0.0.1');
$wxPayHelper->setParameter ( "input_charset", "UTF-8" );
$package = $wxPayHelper->create_biz_package ();







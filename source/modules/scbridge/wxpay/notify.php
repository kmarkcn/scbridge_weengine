<?php 
include_once("WxPay.config.php");

$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

$res = @simplexml_load_string($postStr,NULL,LIBXML_NOCDATA);
$res = json_decode(json_encode($res),true);
$OpenId = $res['OpenId'];  
$transaction_id = $_GET['transaction_id'];
$out_trade_no = $_GET['out_trade_no'];


//1. 获取access token
$appid = APPID;
$appsecret = APPSERCERT;
$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
$result = https_request($url);
$jsoninfo = json_decode($result, true);
$access_token = $jsoninfo["access_token"];

//2.准备参数
$deliver_timestamp = time();
//2.1构造最麻烦的app_signature
$obj['appid']               = APPID;
$obj['appkey']              = APPKEY;
$obj['openid']              = $OpenId;
$obj['transid']             = $transaction_id;
$obj['out_trade_no']        = $out_trade_no;
$obj['deliver_timestamp']   = $deliver_timestamp;
$obj['deliver_status']      = "1";
$obj['deliver_msg']         = "ok";
$app_signature = sha1("appid=".$obj['appid']."&appkey=".$obj['appkey'] ."&deliver_msg=ok&deliver_status=1&deliver_timestamp=".$deliver_timestamp."&openid=".$OpenId."&out_trade_no=".$out_trade_no."&transid=".$transaction_id);
$jsonmenu = '
 {
     "appid" : "'.$obj['appid'].'",
     "openid" : "'.$obj['openid'].'",
     "transid" : "'.$obj['transid'].'",
     "out_trade_no" : "'.$obj['out_trade_no'].'",
     "deliver_timestamp" : "'.$deliver_timestamp.'",
     "deliver_status" : "'.$obj['deliver_status'].'",
     "deliver_msg" : "'.$obj['deliver_msg'].'",
     "app_signature" : "'.$app_signature.'",
     "sign_method" : "sha1"
 }'; 



$url = "https://api.weixin.qq.com/pay/delivernotify?access_token=".$access_token;
$result = https_request($url, $jsonmenu);   
function https_request($url, $data = null){
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	if (!empty($data)){
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	}
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($curl);
	curl_close($curl);
	return $output;
} 
echo "success";

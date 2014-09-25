<?php
 //方倍工作室

 include_once("WxPayHelper.php");
 //接收微信后台发送过来的消息，该消息数据结构为XML，不是php默认的识别数据类型  
 $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];      
 //使用simplexml_load_string() 函数将接收到的XML消息数据载入对象$postObj中。  
 $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);   
 $OpenId = $postObj->postObj;
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
 $obj['appid']               = $appid;
 $obj['appkey']              = APPKEY;
 $obj['openid']              = $OpenId;
 $obj['transid']             = "1218614901201405273313473135";
 $obj['out_trade_no']        = "JfuKdiBig4zZnE4n";
 $obj['deliver_timestamp']   = $deliver_timestamp;
 $obj['deliver_status']      = "1";
 $obj['deliver_msg']         = "ok";

 $WxPayHelper = new WxPayHelper();
 //get_biz_sign函数受保护，需要先取消一下，否则会报错
 $app_signature  = $WxPayHelper->get_biz_sign($obj);

 //3. 将构造的json提交给微信服务器，查询
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
     "sign_method" : "SHA1"
 }';



 $url = "https://api.weixin.qq.com/pay/delivernotify?access_token=".$access_token;
 $result = https_request($url, $jsonmenu);
 var_dump($result);

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
 print_r($_GET);
 print_r($_POST);
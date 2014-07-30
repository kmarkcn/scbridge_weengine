<?php 
/**
 * 1、接收POST进来的xml数据处理
 * 2、查询接口得到数据
 * 3、返回给微擎结果
 */
//如果是引用本地文件，可直接使用微擎中的消息变量 $this->message
//如果是引用其它远程文件，此处只能得到POST过来的值自行解析数据

//$message = userApiUtility::parse($GLOBALS["HTTP_RAW_POST_DATA"]);
$message = $this->message;

$key=$message['content'];
$key2  = urldecode($key);//用户发送的关键词
$queryinfo = file_get_contents("http://www.vvdongli.com/inc/api.php?keyword='.$key2.'");


$row = json_decode($queryinfo, true);
$response = array();
if ($row['result']=="ture") {
	
	$response['FromUserName'] = $message['to'];
	$response['ToUserName'] = $message['from'];
	$response['MsgType'] = 'text';
	$response['Content'] = '';
	$response['Content'] = $row['content'] ;
}
return $response;
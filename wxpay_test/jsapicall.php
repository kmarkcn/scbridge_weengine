<?php
include_once("WxPayHelper.php");


$commonUtil = new CommonUtil();
$wxPayHelper = new WxPayHelper();


$wxPayHelper->setParameter("bank_type", "WX");
$wxPayHelper->setParameter("body", "test");
$wxPayHelper->setParameter("partner", "1220727201");
$wxPayHelper->setParameter("out_trade_no", $commonUtil->create_noncestr());
$wxPayHelper->setParameter("total_fee", "1");
$wxPayHelper->setParameter("fee_type", "1");
$wxPayHelper->setParameter("notify_url", "http://www.kmark.cn/we_scbridge/wxpay_test/jsapicall.php");
$wxPayHelper->setParameter("spbill_create_ip", "127.0.0.1");
$wxPayHelper->setParameter("input_charset", "GBK");
$str1 = $wxPayHelper->create_biz_package();
//$str2 = $wxPayHelper->notice_deliver_before();
//$str3 = $wxPayHelper->get_result_from_server();


?>
<html>
<script language="javascript">
function callpay()
{
	WeixinJSBridge.invoke('getBrandWCPayRequest',<?php echo $str1; ?>,function(res){
			//WeixinJSBridge.log(res.err_msg);
			//get_brand_wcpay_requestk
			//alert(res.err_msg);
			if(res.err_msg=='get_brand_wcpay_request:ok'){
				//调用发货通知借口
				<?php 
					print_r($_POST);
					print_r($_GET);
				?>
				  //window.location="http://www.kmark.cn/we_scbridge/index.php?act=module&name=scbridge&do=index";
			}else{
				alert('系统繁忙,支付失败!');
			}
	});
}
</script>
<body>
<button type="button" onclick="callpay()">wx pay test</button>
</body>
</html>
<style>
	button{
		position:relative;
		top:200px;
		left:100px;
	}
</style>
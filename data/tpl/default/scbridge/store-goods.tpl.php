<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE HTML> 
<html lang="en-us">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
<link rel="stylesheet" type="text/css" href="./resource/scbridge/css/public.css" />
<link rel="stylesheet" type="text/css" href="./resource/scbridge/css/store-goods.css" />
<script type="text/javascript" src="./resource/scbridge/js/jquery.min.js"></script>
<script type="text/javascript" src="./resource/scbridge/js/store.js"></script>
<title>商城</title>
</head>
<style>
.pr-li-02 a{
	color:#ffffff;
}
</style>
<body>
	<div class="ma">
    	<!--以下是头部-->
        <div class="public-head-father">
            <div class="public-head" style="padding-right:30%; padding-left: 10%;">
            	<?php echo $title;?>
                <a onclick='window.history.back(-1);'><img class="public-left"  src="./resource/scbridge/img/header-left.png"></a>
                
                <div class="public-right">
                	<ul class="pr-ul">
                    	<li class="pr-li-01">更多<br><img class="pr-img" src="./resource/scbridge/img/header-bottom.png"></li>
                        <li class="pr-li-02"><a href="./index.php?act=module&name=scbridge&do=shop_list&good_type=1">产品1</a></li>
                        <li class="pr-li-02"><a href="./index.php?act=module&name=scbridge&do=shop_list&good_type=2">产品2</a></li>
                        <li class="pr-li-02"><a href="./index.php?act=module&name=scbridge&do=shop_list&good_type=3">产品3</a></li>
                        <li class="pr-li-02"><a href="./index.php?act=module&name=scbridge&do=shop_list&good_type=4">产品4</a></li>
                        <li class="pr-li-02"><a href="./index.php?act=module&name=scbridge&do=shop_list&good_type=5">产品5</a></li>
                        <li class="pr-li-02"><a href="./index.php?act=module&name=scbridge&do=shop_list&good_type=6">产品6</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!--以上是头部-->
        <!--以下是中间内容-->
        <div class="sg-content">
        	<div class="sg-goods">
            	<h1 class="sg-h1"><?php echo $good['name'];?><p class="sg-p">单价&nbsp;: <span><?php echo $good['price'];?></span>&nbsp;&yen;</p></h1>
                <div style='padding:5px;'>
                	<?php echo $good['detailed_intro'];?>
                </div>
            </div>
            
        </div>
        <!--以上是中间内容-->
        <!--以下是预定-->
            <div class="public-reserve" style="position:relative; left:0; top:0;">
               <img class="public-btn-reserve" src="./resource/scbridge/img/buy.png" onclick="javascript:alert('支付宝');">
            </div>
        <!--以上是预定-->
      
</div>
</body>
</html>

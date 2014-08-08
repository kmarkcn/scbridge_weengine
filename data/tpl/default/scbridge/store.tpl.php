<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE HTML> 
<html lang="en-us">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
<link rel="stylesheet" type="text/css" href="./resource/scbridge/css/public.css" />
<link rel="stylesheet" type="text/css" href="./resource/scbridge/css/store.css" />
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
                <img class="public-left"  src="./resource/scbridge/img/header-left.png" onclick="javascript:window.history.back(-1);">
                
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
        <div class="s-content">
        	<img width="100%" src="./resource/scbridge/img/store/store_01.png" >
            <div class="s-c-body">
                <div class="s-list">
                    <!--以下是导航一-->
                    <div class="s-list-01">
                       <?php if(is_array($goods)) { foreach($goods as $re) { ?>
                        <a href="./index.php?act=module&name=scbridge&do=goods_content&good_id=<?php echo $re['id'];?>&good_type=<?php echo $good_type;?>">	
                            <div class="s-goods">
                                <img class="s-g-img" src="<?php echo $_W['attachurl'];?><?php echo $re['icon'];?>">
                                <ul class="s-ul">
                                    <li><h1><?php echo $re['name'];?></h1></li>
                                    <li style="margin-top:5px;">单价&nbsp;：<span><?php echo $re['price'];?></span>&nbsp;&yen;</li>
                                    <li><p><?php echo $re['brief_intro'];?></p></li>
                                </ul>
                            </div>
                        </a>
                       <?php } } ?>
                    </div>
                    <!--以上是导航一-->
                   
            	</div>

            </div>
        </div>
        <!--以上是中间内容-->
        
     
        
</div>
</body>
</html>

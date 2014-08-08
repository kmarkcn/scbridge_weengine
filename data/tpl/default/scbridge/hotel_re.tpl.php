<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE HTML> 
<html lang="en-us">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
<link rel="stylesheet" type="text/css" href="./resource/scbridge/css/public.css" />
<link rel="stylesheet" type="text/css" href="./resource/scbridge/css/hotel-reserve.css" />
<script type="text/javascript" src="./resource/scbridge/js/jquery.min.js"></script>
<title>homepage</title>
<style type="text/css">

</style>
</head>

<body>
	<div class="ma">
    	<!--以下是头部-->
        
        <!--以上是头部-->
        <!--以下是中间内容-->
        <div class="hr-content">
        	
            <div class="hr-goods">
            	<h1 class="hr-h1"><?php echo $hotel['name'];?></h1>
            	<img width="100%" src="<?php echo $_W['attachurl'];?><?php echo $hotel['icon'];?>">
            	<ul class="hr-ul">
                	<li>等级：<span><?php echo $hotel['level'];?></span></li>
                    <li>地址：<span><?php echo $hotel['address'];?></span></li>
                    <li>参考价(全天):<span><?php echo $hotel['pr_min'];?></span>&nbsp;元&nbsp;~&nbsp;<span><?php echo $hotel['pr_max'];?></span>&nbsp;元</li>
                    <li>容纳人数：<span><?php echo $hotel['num_min'];?></span>&nbsp;人&nbsp;~&nbsp;<span><?php echo $hotel['num_max'];?></span>&nbsp;人</li>
                    <li class="hr-li">
                    	<p>
                       		<?php echo $hotel['description'];?>
                        </p>
                    </li>
                </ul>
            </div>
            
            
        </div>
        
        <!--以上是中间内容-->
        
        <!--以下是预定-->
        <div class="public-reserve">
        	<a href="./index.php?act=module&name=scbridge&do=meeting_booking&h_id=<?php echo $hotel['id'];?>"><img class="public-btn-reserve" src="./resource/scbridge/img/hotel-reserve_03.png"></a>
        </div>
        <!--以上是预定-->
      
        
</div>
</body>
</html>

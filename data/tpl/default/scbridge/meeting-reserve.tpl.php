<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE HTML> 
<html lang="en-us">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
<link rel="stylesheet" type="text/css" href="./resource/scbridge/css/public.css" />
<link rel="stylesheet" type="text/css" href="./resource/scbridge/css/meeting-reserve.css" />
<script type="text/javascript" src="./resource/scbridge/js/jquery.min.js"></script>
<title>会议预定</title>
<style type="text/css">

</style>
</head>

<body>
	<div class="ma">
    	
        
        <!--以下是中间内容-->
        <div class="mr-content">
        	<img width="100%" src="./resource/scbridge/img/member-product/member- product_01.png">
            <div class="mr-c-body">
            	<?php if(is_array($hotels)) { foreach($hotels as $re) { ?>
            	<a href="./index.php?act=module&name=scbridge&do=hotel_contents&h_id=<?php echo $re['id'];?>">	
                    <div class="mr-goods">
                        <img class="mr-g-img" src="<?php echo $_W['attachurl'];?><?php echo $re['icon'];?>">
                        <ul class="mr-ul">
                        	<li><h1><?php echo $re['name'];?></h1></li>
                            <li><span>等级：<?php echo $re['level'];?>/豪华</span></li>
                            <li><span><?php echo $re['address'];?></span></li>
                            <li>最大可容纳：<span class="mr-red"><?php echo $re['max_num'];?></span>人</li>
                        </ul>
                        <div class="clear"></div>
                    </div>
                </a>
               <?php } } ?>
               
            </div>
        </div>
        <!--以上是中间内容-->
        
      
        
</div>
</body>
</html>

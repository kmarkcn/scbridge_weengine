<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE HTML> 
<html lang="en-us">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
<link rel="stylesheet" type="text/css" href="./resource/scbridge/css/public.css" />
<link rel="stylesheet" type="text/css" href="./resource/scbridge/css/member-product.css"/>
<script type="text/javascript" src="./resource/scbridge/js/jquery.min.js"></script>
<title>homepage</title>
</head>

<body>
  <div class="ma" style="height:100%">
    	
    <div class="toubu" style="padding-top:60px;">
      <img src="./resource/scbridge/img/member-product/member- product_01.png"width="100%">
    </div>
        <!--以上是头部-->
        <!--以下是中间内容-->
   
    
    <?php if(is_array($hotels)) { foreach($hotels as $re) { ?>
    <div class="zhongjian" >
      <div class="fangjian"><a href="#"><img style=" width:100%; height:100%;" src="<?php echo $_W['attachurl'];?><?php echo $re['icon'];?>" ></a></div>
      <div class="wenbeng"><h3><?php echo $re['name'];?></h3>
      <p style="line-height:18.5px;">
      	<?php echo(substr($re['description'],0,600));?>
      </p></div>
      <div class="mp-foot-father">
      	<div class="mp-foot">
        	<span class="mp-span-01">预订价&yen;<span><?php echo $re['price_normal'];?></span></span>
            <p class="mp-p1">
            	<span class="mp-span-bold">&yen;</span><span class="mp-span-01"><?php echo $re['price_vip'];?></span><br>
                会员价
            </p>
            <a href="./index.php?act=module&name=scbridge&do=hotel_content&h_id=<?php echo $re['id'];?>"><img class="mp-img" style="width:80px;" src="./resource/scbridge/img/member-product/member- product_04.png"></a>
        </div>
      </div>
    </div>
    
    <?php } } ?>
    
    
    
    	<div style="height:43px;"></div>
        <!--以上是中间内容-->
        
     
        
</div>
</body>
</html>

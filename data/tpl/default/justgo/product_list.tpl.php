<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE HTML> 
<html lang="en-us">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
<link href="./resource/justgo/css/jquery.flipcountdown.css" rel="stylesheet"/>
<script type="text/javascript" src="./resource/justgo/js/jquery.min.js"></script>
<script src="./resource/justgo/js/jquery.flipcountdown.js" type="text/javascript"></script>


<!-- <link href="./resource/justgo/css/slides_home.css" rel="stylesheet"/> -->
<!-- In-document CSS -->
<style>
  .departure_city {
    font: bold 20px "微软雅黑", sans-serif;
    line-height: 50px;
	color: #FFF;
  }
  .header_area {
    width: 100%;
    height: 50px;
    text-align: center;
    background-size: cover;
    background-image: url(./resource/justgo/img/product_list/header.png);
    position:fixed;
	left:0px;
	top:0px;
  }
  #product_list {
    margin-top: 60px;
	margin-bottom: 3%;
	text-align: center;
  }
  #detail_banner {
    padding-left: 5px;
    float: left;
    display: inline;
    font: bold 14px '微软雅黑', sans-serif;
    color: #FFF;
    line-height: 35px;  
  }

  .tra_list{
	margin-top:15px;
  	padding-bottom:15px;
  	border-bottom:1px solid #ccc;
  }
  .tra_list_con{
	width:90%;
	margin:auto;
  	margin-bottom:10px;
  	text-align:left;
  	font-size:14px;
  }
  .tra_list_con b{
	font-size:18px;
  }
.tra_list_con i{
	font-size:11px;
	font-style:normal;
  }
</style>
<title>当前旅游产品</title>
</head>

<body style="margin: 0px">
  <div class="header_area">
  	<a  href="./index.php?act=module&name=justgo&do=show">
  	<img src="./resource/justgo/img/product_list/details4.png" style='position:absolute;width:15px;height:25px;padding-top:12px;left:2%;'/>
  	</a>
    <span class="departure_city">成都出发</span> 
  </div>
  <?php if(is_array($travels)) { foreach($travels as $tr_re) { ?>
  <div id="product_list" >
  	<!-- loop starts here -->
    <div class='tra_list'>
      <!-- product show picture -->
      <a href="./index.php?act=module&name=justgo&do=show_travel_pic&id=<?php echo $tr_re['id'];?>"><img src="<?php echo $_W['attachurl'];?><?php echo $tr_re['product_pic0'];?>" width="90%"/></a>
      <!-- product details | should have paragraphs here.  -->
      <div class='tra_list_con'>
      	<b><?php echo $tr_re['product_name'];?></b>&nbsp;|&nbsp;全程<?php echo $tr_re['total'];?>天&nbsp;|&nbsp;出发日期(<?php echo(date('Y-m-d',$tr_re['departure_time']))?>)
      	<br/><i><?php echo(substr($tr_re['destination_info'],0,572));?>......</i>
      </div>
      <!-- confirm button -->
      <div style="text-align: right; padding-right: 5%">
        <a href="./index.php?act=module&name=justgo&do=show_detail&id=<?php echo $tr_re['id'];?>">
          <img src="./resource/justgo/img/product_list/confirm_button.png" width="30%">
        </a>
      </div>
    
    <div style="background-color:#C7000a; height: 35px; margin: 0 5% 0 5%">
      <!--<img src="img/product_list/detail_banner.png" width="60%"/> -->
      	<span id="detail_banner">
          说走价：<a style='font-size:22px;'><?php echo $tr_re['total_price'];?></a>&nbsp;&yen;
        </span>
        <div style="text-align: right; display: inline; padding-top: 5px; padding-right: 5px; float:right;" id="product_timeleft_<?php echo $tr_re['id'];?>">
        </div>
        <script>
       
        var NY = Math.round((new Date("<?php echo(date('m/d/Y h:i:s',$tr_re['deadline']))?>")).getTime()/1000);
		$("#product_timeleft_<?php echo $tr_re['id'];?>").flipcountdown({
			tick:function(){
				var nol = function(h){
					return h>9?h:'0'+h;
				}
				var	range  	= NY-Math.round((new Date()).getTime()/1000),
					secday  = 86400, sechour = 3600,
					days 	= parseInt(range/secday),
					
					thours	= parseInt((range%secday)/sechour) + days*24,
					hours   = thours > 48 ? 48 : thours,
					min		= parseInt(((range%secday)%sechour)/60),
					sec		= ((range%secday)%sechour)%60;
				return nol(thours)+' '+nol(min)+' '+nol(sec);
			},
			size:"xs"
		});
        </script>

	</div>
</div>
  <?php } } ?>
  
   
   </div>
</body>
</html>

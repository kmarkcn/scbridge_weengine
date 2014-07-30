<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE HTML> 
<html lang="en-us">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
<link href="./resource/justgo/css/jquery.flipcountdown.css" rel="stylesheet"/>
<script type="text/javascript" src="./resource/justgo/js/jquery.min.js"></script>
<script src="./resource/justgo/js/jquery.flipcountdown.js" type="text/javascript"></script>
<title>详细行程</title>
</head>
<style>
	body{
		background:#f2f2f2;
		font-size:12px;
		line-height:14px;
	}
  .confirm_schedule {
    font: bold 20px "微软雅黑", sans-serif;
    line-height:50px;
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
 
  #detail_banner {
    padding-left: 5px;
    float: left;
    display: inline;
    font: bold 14px '微软雅黑', sans-serif;
    color: #FFF;
    line-height: 35px;  
  }
  .show_box{
  	background:#fff;
  	border:1px solid #f2f2f2;
  	margin:2px 10px;
  	border-radius:2px;
  	margin-bottom:1px;
  	-webkit-box-shadow:0 1px 1px rgba(0,0,0,0.1);
  }
  .show_box .show_title{
  	font-size:14px;
  	height:36px;
  	padding-left:3px;
  	line-height:36px;
  	font-weight:normal;
  }
  .show_box .show_title b{
  	font-size:17px;
  }
  .show_box i{
  	display:inline-block;
  	width:18px;
  	height:36px;
  	float:right;
  	margin-top:4px;
  	margin-right:10px;
  }
  .show_con{
  	border-top:1px solid #f2f2f2;
  	line-height:20px;
  	padding-left:8px;
  }
</style>
<body style="margin: 0px">
  <div class="header_area">
  <a  href="./index.php?act=module&name=justgo&do=show_list">
  <img src="./resource/justgo/img/product_list/details4.png" style='position:absolute;width:15px;height:25px;padding-top:12px;left:2%;'/>
  </a>
  <span class="confirm_schedule">确认行程<input type='hidden' id='pro_id' value='<?php echo $travels['id'];?>'></span>
  </div>
  	<div style='text-align:center;margin-top:60px;'><img src="<?php echo $_W['attachurl'];?><?php echo $travels['product_pic0'];?>" width="100%"/></div>	
  	<div class='show_box'>
  		<div class='show_title'><b><?php echo $travels['return_city'];?></b>&nbsp;<?php echo $travels['departure_city'];?>-<?php echo $travels['destination'];?><i><img src='./resource/justgo/img/2.png' width='12' height='12'></i></div>
  		<div class='show_con'>
    	<b>出发城市</b>:<?php echo $travels['departure_city'];?><br/>
    	<b>出发时间</b>:<?php echo(date('Y-m-d',$travels['departure_time']));?><br/>
    	<b>返航城市</b>:<?php echo $travels['destination'];?><br/>
    	<b>返航时间</b>:<?php echo(date('Y-m-d',$travels['return_time']));?><br>
   		</div>	
  	</div>
  	
  	<div class='show_box'>
  		<div class='show_title'><b>目的地信息</b>&nbsp;<i><img src='./resource/justgo/img/2.png' width='12' height='12'></i></div>
  		<div class='show_con'>
    	<b>目的地城市</b>:<?php echo $travels['destination'];?><br/>
    	<b>目的地详情</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $travels['destination_info'];?>
    	</div>	
  	</div>
  
  		
  	<div class='show_box'>
  		<div class='show_title'><b>相关行程</b>&nbsp;<i><img src='./resource/justgo/img/1.png' width='12' height='12'></i></div>
  		<div class='show_con' style='display:none;'>
    			<?php if(is_array($travels['sc'])) { foreach($travels['sc'] as $re) { ?>
    				<span>第<?php echo $re['date_order'];?>天<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $re['name'];?></span><br/>
   			 	<?php } } ?>
   		</div>	
  	</div>
  
  
  	<div class='show_box'>
  		<div class='show_title'><b>相关酒店</b>&nbsp;<i><img src='./resource/justgo/img/1.png' width='12' height='12'></i></div>
  		<div class='show_con' style='display:none;'>
    			<?php if(is_array($travels['ho'])) { foreach($travels['ho'] as $rs) { ?>
    				<b>酒店名称</b>:<?php echo $rs['name'];?>(<?php echo $rs['room_type'];?>)<br/>
    				入住时间:<?php echo(date('Y-m-d',$rs['start_date']));?>至<?php echo(date('Y-m-d',$rs['end_date']));?>
    			<br/>
 				<?php } } ?>
   					
   		</div>	
  	</div>
  
  
  	<div class='show_box'>
  		<div class='show_title'><b>附加说明</b>&nbsp;<i><img src='./resource/justgo/img/1.png' width='12' height='12'></i></div>
  		<div class='show_con' style='display:none;'>
    			<b>费用说明</b>:<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    			<?php if(empty($travels['cost_explain'])) { ?>
  						暂无
  				<?php } else { ?>
    			<?php echo $travels['cost_explain'];?>
    			<?php } ?>
    			<br/>
    			<b>签证说明</b>:<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    			<?php if(empty($travels['visa_explain'])) { ?>
  						暂无
  				<?php } else { ?>
    			<?php echo $travels['visa_explain'];?>
    			<?php } ?>
    			<br/>
    			<b>预定需知</b>:<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    			<?php if(empty($travels['reserve_notice'])) { ?>
  						暂无
  				<?php } else { ?>
    			<?php echo $travels['reserve_notice'];?>
    			<?php } ?>
    			<br/>
   					
   		</div>	
  	</div>
  
  
  
  <div class='show_box' style='margin-bottom:30%;'>
  		<div class='show_title'><b>附加产品</b>&nbsp;<i><img src='./resource/justgo/img/1.png' width='12' height='12'></i></div>
  		<div class='show_con' style='display:none;padding-left:12px;'>
  					<?php if(empty($travels['com'])) { ?>
  						暂无
  					<?php } else { ?>
   					<?php if(is_array($travels['com'])) { foreach($travels['com'] as $re) { ?>
    					<?php echo $re['name'];?><br/>
   			 		<?php } } ?>
   			 		<?php } ?>
   		</div>	
  	</div>
  	
  	<div style='position:fixed;left:0px;bottom:0px;width:100%;'>
    <div style="text-align: right; padding-right: 5%;">
        	 
        	 <?php if(time()<=$travels['deadline']) { ?> 
					<a href="./index.php?act=module&name=justgo&do=product_booking&id=<?php echo $travels['id'];?>">
					<img src="./resource/justgo/img/product_list/confirm.png" width="30%" style='margin-top:10px;margin-right:-5px;'>
					</a>
			<?php } else { ?>  
		 			<img src="./resource/justgo/img/product_list/confirm_2.png" width="30%" style='margin-top:10px;margin-right:-5px;' onclick="javascript:alert('对不起，产品已过期！')">
			<?php } ?>
          
       		
    </div>
    
    <div style="background-color:#C7000a; height: 35px; margin: 0 5% 0 5%">
      <!--<img src="img/product_list/detail_banner.png" width="60%"/> -->
      	<span id="detail_banner">
          	说走价：<a style='font-size:22px;'><?php echo $travels['total_price'];?></a>&nbsp;&yen;
        </span>
        
        <div style="text-align: right; display: inline; padding-top: 5px; padding-right: 5px; float:right;" id="product_timeleft"></div>
        <script>
        var NY = Math.round((new Date("<?php echo(date('m/d/Y h:i:s',$travels['deadline']))?>")).getTime()/1000);
		$('#product_timeleft').flipcountdown({
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
 
</body>
</html>
<script src='./resource/script/jquery-1.7.2.min.js'></script>
<script>
	$('.show_title').click(function(){
		if(($(this).parent().find('.show_con').css('display'))=='none'){
			$(this).parent().find('.show_con').show();
			$(this).parent().find('img').attr('src','./resource/justgo/img/2.png');
		}else{
			$(this).parent().find('.show_con').hide();
			$(this).parent().find('img').attr('src','./resource/justgo/img/1.png');
		}
	})
</script>
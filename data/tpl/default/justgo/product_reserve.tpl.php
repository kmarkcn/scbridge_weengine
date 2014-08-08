<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE HTML> 
<html lang="en-us">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
<script type="text/javascript" src="./resource/justgo/js/jquery.min.js"></script>
<!-- <link href="css/slides_home.css" rel="stylesheet"/> -->
<!-- In-document CSS -->
<style>
   
</style>

<script type="text/javascript" src="js/jquery.min.js"></script>
<link href="./resource/justgo/css/product-reserve.css" rel="stylesheet"/>

<title>当前旅游产品</title>
</head>

<body style="margin: 0px;background:#f2f2f2;">
  <div class="header_a">
  	 <a  href="./index.php?act=module&name=justgo&do=show_detail&id=<?php echo $id;?>">
  	<img src="./resource/justgo/img/product_list/details4.png" style='position:absolute;width:15px;height:25px;padding-top:12px;left:2%;'/>
  	</a>
    <span class="departure_city">预定信息填写</span>
  </div>
  <div class="pr-content">
  	<table class="pr-table" cellpadding="0" cellspacing="0">
    	<tr>
        	<td class="pr-td1">姓名 : <input class="pr-input pr_name" type="text"></td>
        </tr>
        <tr>
        	<td class="pr-td1">电话 : <input class="pr-input pr_tel" type="telephone"></td>
        </tr>
        <tr>
        	<td class="pr-td1">邮箱 : <input class="pr-input pr_email" type="email"></td>
        </tr>
        <tr>
        	<td style="font-size:0.7em; color:#a9bbbf; text-align:center; padding:5%;color:red;">注：此为您下单后客服能更快的和您核实信息</td>
        </tr>
    </table>
  </div>
  <div class="pr-foot">
   	 <img style=" position:absolute; left:35%; width:34%;" src="./resource/justgo/img/product_list/confirm.png" id='confirm_booking'>
  </div>
  
</body>
</html>
<script>
$(function(){
	//pr-input-false
	confirm_mes=0;
	confirm_mes_1=0;
	confirm_mes_2=0;
	confirm_mes_3=0;
	$('.pr_name').blur(function(){
		if($(this).val()==''){
			$(this).addClass('pr-input-false');
			confirm_mes_1=0;
		}else{
			$(this).removeClass('pr-input-false');
			confirm_mes_1=1;
		}
	})
	
	$('.pr_tel').blur(function(){
		var tel=$(this).val();
		var preg=/^1[3458][0-9]\d{8}$/;
		if(preg.exec(tel)){
			$(this).removeClass('pr-input-false');	
			confirm_mes_2=1;
		}else{
			$(this).addClass('pr-input-false');
			confirm_mes_2=0;
		}
	})
	
	$('.pr_email').blur(function(){
		 if (/^[0-9a-z][_.0-9a-z-]{0,31}@([0-9a-z][0-9a-z-]{0,30}[0-9a-z]\.){1,4}[a-z]{2,4}$/.test($(this).val()) == false){
			 $(this).addClass('pr-input-false');
			 confirm_mes_3=0;
		 }else{
			 $(this).removeClass('pr-input-false');
			 confirm_mes_3=1;
		 }
	})
	
	$('#confirm_booking').click(function(){
		if(confirm_mes_3==1&&confirm_mes_2==1&&confirm_mes_1==1){
			confirm_mes=1;
		}else{
			confirm_mes=0;
		}
		if(confirm_mes==1){
			alert(1);
		}
	})
	
})
</script>
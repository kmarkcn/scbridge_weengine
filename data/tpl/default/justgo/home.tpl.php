<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE HTML> 
<html lang="en-us" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
 
<link href="./resource/justgo/css/slides_home.css" rel="stylesheet"/>
<title>说走就走-旅游平台</title>
</head>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="./resource/justgo/js/jquery.slides.min.js"></script>

<body>
<input type='hidden' value='<?php echo $pro_num;?>' id='pro_num'>
  <div style="
  	width: 99%; 
    height: 194px;
    background-image: url(./resource/justgo/img/slider.png);
    background-size: cover;" id='div_top'>
  <div>
    <div id="slides">
    <?php if(is_array($travels)) { foreach($travels as $re) { ?>
      	<a href="./index.php?act=module&name=justgo&do=show_travel_pic&id=<?php echo $re['id'];?>" style='margin:0px;display:block;width:100%;height:100%;'><img src="<?php echo $_W['attachurl'];?><?php echo $re['product_pic0'];?>" width='100%' height='85%'></a>
    <?php } } ?>
  	</div>
  </div>
  <div class="button-area">
    <div>
      <span style="display: inline">
        <a href="./index.php?act=module&name=justgo&do=show_list"><img src="./resource/justgo/img/48go.png" width="49.2%"></a>
        <a href="#"><img src="./resource/justgo/img/earlybird.png" width="49.2%"></a>
      </span>     
      <span style="display:inline; padding-top: 2%;">
        <a href="#"><img src="./resource/justgo/img/instruction.png" width="99.9%"></a>
      </span>
    </div>
  </div>
</body>
<script>
$(function(){
	if($('#pro_num').val()==1){
		$('#div_top').css('background-image','');
		$('#slides').css('display','block');
	}else{
		 $("#slides").slidesjs({
				width: 120,
				height: 78,
				navigation: false,
				pagination: {
				 active: true,
				 effect: "fade"
			    }
			  });
		
	}
 
});
</script>
</html>
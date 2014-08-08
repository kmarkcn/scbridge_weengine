<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE HTML> 
<html lang="en-us">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
<link href="./resource/justgo/css/swipe.css" rel="stylesheet"/>
</head>

<body>
<input type='hidden' value='<?php echo $id;?>' id='pro_id'>
<div id="slider" class="swipe">
  <ul>
    <li style="display:block">
      <div>
        <img src="<?php echo $_W['attachurl'];?><?php echo $travels['product_pic1'];?>" width="100%" height='100%'>
      </div>    
    </li>
    <li style="display:none">
      <div>
        <img src="<?php echo $_W['attachurl'];?><?php echo $travels['product_pic2'];?>" width="100%" height='100%'>
      </div>
    </li>
    <li style="display:none">
      <div>
        <img src="<?php echo $_W['attachurl'];?><?php echo $travels['product_pic3'];?>" width="100%" height='100%'>
      </div>
    </li>
  </ul>
</div>
<script type="text/javascript" src="./resource/justgo/js/jquery.min.js"></script>
<script src="./resource/justgo/js/swipe.js"></script>
<script>
$(function(){
	$('#slider img').each(function(){
		//$(this).css('width','100%');
		$(this).css('height','500px');
	})
})
var pro_id=($('#pro_id').val());
var mySwipe = new Swipe(document.getElementById("slider"),{
  startSlide: 0,
  speed: 900,
  auto: 500,
  continuous: false,
  disableScroll: false,
  stopPropagation: false,
  callback: function(index, elem) {
    if(elem == 2){
	  window.setTimeout("window.location='./index.php?act=module&name=justgo&do=product_content&id="+pro_id+"'",400); 
	}
  },
  transitionEnd: function(index, elem) {},	
});

</script>

</body> 
</html> 
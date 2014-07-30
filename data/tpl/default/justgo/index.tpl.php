<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE HTML> 
<html lang="en-us">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
<link href="./resource/justgo/css/swipe.css" rel="stylesheet"/>
</head>

<body>
<div id="slider" class="swipe">
  <ul>
    <li style="display:block">
      <div>
        <img src="./resource/justgo/img/front1.png" width="100%" height="100%">
      </div>    
    </li>
    <li style="display:none">
      <div>
        <img src="./resource/justgo/img/front2.png" width="100%" height="100%">
      </div>
    </li>
    <li style="display:none">
      <div>
        <img src="./resource/justgo/img/front3.png" width="100%" height="100%">
      </div>
    </li>
  </ul>
</div>
<script src="./resource/justgo/js/swipe.js"></script>
<script>
var mySwipe = new Swipe(document.getElementById("slider"),{
  startSlide: 0,
  speed: 600,
  auto: 5000,
  continuous: false,
  disableScroll: false,
  stopPropagation: false,
  callback: function(index, elem) {
    if(elem == 2){
	  window.setTimeout("window.location='./index.php?act=module&name=justgo&do=show'",3000); 
	}
  },
  transitionEnd: function(index, elem) {},	
});

</script>

</body> 
</html> 
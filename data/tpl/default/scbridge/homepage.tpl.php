<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE HTML> 
<html lang="en-us">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
<link rel="stylesheet" type="text/css" href="./resource/scbridge/css/homepage.css" />
<link rel="stylesheet" type="text/css" href="./resource/scbridge/css/public.css" />
<link href="./resource/scbridge/css/slides_home.css" rel="stylesheet"/>
<script type="text/javascript" src="./resource/scbridge/js/jquery.min.js"></script>
<script src="./resource/scbridge/js/jquery.slides.min.js"></script>
<title>homepage</title>
</head>

<body>
	<div class="father" style="background-color:black; height:100%;">
        <div class="head" >
            <div id="slides" style="position:relative;">
              <img src="./resource/scbridge/img/homepage/homepage_01.png">
              <img src="./resource/scbridge/img/homepage/homepage_01.png">
              <img src="./resource/scbridge/img/homepage/homepage_01.png">
            </div>
        </div>
        <div class="content" style="padding:2%;">
        	<div class="content-t">
            	<a  href="./index.php?act=module&name=scbridge&do=hotel_center"><img class="fl" style="width:52.5%;" src="./resource/scbridge/img/homepage/homepage_02.png"/></a>
            	<a  href="./index.php?act=module&name=scbridge&do=hotel_booking"><img class="fr" style="width:46%; margin-bottom:2%;" src="./resource/scbridge/img/homepage/homepage_03.png"/></a>
                <a  href="./index.php?act=module&name=scbridge&do=meeting_center"><img class="fr" style="width:46%;" src="./resource/scbridge/img/homepage/homepage_04.png"/></a>
                <div class="clear"></div>
            </div>
            <div class="content-c" style="margin-top:2%; margin-bottom:2%;">
          		<a href="./index.php?act=module&name=scbridge&do=shop_center"><img class="fl" style=" width:52.5%; margin-bottom:2%;" src="./resource/scbridge/img/homepage/homepage_05.png" /></a>
                <a href="./index.php?act=module&name=scbridge&do=member_center"><img class="fr" style=" width:46%;" src="./resource/scbridge/img/homepage/homepage_07.png" /></a>
                <a href="#"><img class="fl" style=" width:52.5%;" src="./resource/scbridge/img/homepage/homepage_06.png" /></a>
                <div class="clear"></div>
            </div>
            <div class="content-f">
            	<a href="#"><img style=" width:100%;" src="./resource/scbridge/img/homepage/homepage_08.png" /></a>
            </div>
        </div>
	</div>
<script>
$(function(){
  $("#slides").slidesjs({
	width: 50,
	height: 24,
	navigation: false,
	pagination: {
	 active: true,
	 effect: "fade"
    }
	,play: {
      active: false,
        // [boolean] Generate the play and stop buttons.
        // You cannot use your own buttons. Sorry.
      effect: "slide",
        // [string] Can be either "slide" or "fade".
      interval: 5000,
        // [number] Time spent on each slide in milliseconds.
      auto: true,
        // [boolean] Start playing the slideshow on load.
      swap: false,
        // [boolean] show/hide stop and play buttons
      pauseOnHover: true,
        // [boolean] pause a playing slideshow on hover
      restartDelay: 2500
        // [number] restart delay on inactive slideshow
    }
  });
});
</script>
</body>
</html>

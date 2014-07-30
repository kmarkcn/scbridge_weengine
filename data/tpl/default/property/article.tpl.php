<?php defined('IN_IA') or exit('Access Denied');?><?php include template('mobile/header_property', TEMPLATE_INCLUDEPATH);?>
<style type="text/css">
		.button_area {
			text-align:right; 
			margin-top:-120%; 
			padding-right: 11%; 
			padding-top: 35%;
		}
	</style>
    <div class="wrapper" id="container" style="background-color:#400000">
    	<div id="banner">
        	<img src="./resource/tencent/img/banner_1.png" width="100%">
        </div>
    	<div id="main_area" style="text-align:left; margin-left: 8%; margin-right:5%; margin-bottom: 8%">
        	<div id="header" style="font-size:24px; color:#c8b35a; line-height:30px">
            	<p style="padding-bottom: 5px; padding-top:10px;"><?php echo $article['title'];?></p>
            </div>
            <div id="content" style="font-size:18px; color:#dab7b7; line-height:20px; padding-bottom: 5px; padding-top:10px;" >
            	<?php echo $article['content'];?>
            </div>
        </div>
        <div id="foot">
            <img src="./resource/tencent/img/footer_1.png" width="100%">
        </div>
    </div>
</body>
</html>
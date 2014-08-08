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
    	<img src="./resource/tencent/img/pages/about.png" width="100%">
    	<div id="button_area" class="button_area">
        	<div>
            	<a href="<?php echo create_url('index/module', array('name' => 'property', 'do' => 'showcontent', 'category_id' => '4'))?>"><img src="./resource/tencent/img/buttons/com_intro.png" width="50%"></a>
            </div>
            <div>
            	<a href="<?php echo create_url('index/module', array('name' => 'property', 'do' => 'showcontent', 'category_id' => '5'))?>"><img src="./resource/tencent/img/buttons/com_honour.png" width="50%"></a>
            </div>
            <div>
            	<a href="<?php echo create_url('index/module', array('name' => 'property', 'do' => 'showcontent', 'category_id' => '6'))?>"><img src="./resource/tencent/img/buttons/com_news.png" width="50%"></a>
            </div>
        </div>
        <div id="foot" style="margin-top:10%">
	        <img src="./resource/tencent/img/footer_2.png" width="100%">
	    </div>
    </div>
</body>
</html>
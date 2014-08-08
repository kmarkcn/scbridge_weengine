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
    	<img src="./resource/tencent/img/pages/city.png" width="100%">
    	<div id="button_area" class="button_area" style="margin-top:-125%;">
        	<div>
            	<a href="<?php echo create_url('index/module', array('name' => 'property', 'do' => 'showcontent', 'category_id' => '11'))?>"><img src="./resource/tencent/img/buttons/inter_service.png" width="50%"></a>
            </div>
            <div>
            	<a href="<?php echo create_url('index/module', array('name' => 'property', 'do' => 'showcontent', 'category_id' => '12'))?>"><img src="./resource/tencent/img/buttons/inter_notice.png" width="50%"></a>
            </div>
            <div>
            	<a href="<?php echo create_url('index/module', array('name' => 'property', 'do' => 'showcontent', 'category_id' => '13'))?>"><img src="./resource/tencent/img/buttons/leave_message.png" width="50%"></a>
            </div>
            <div>
            	<a href="<?php echo create_url('index/module', array('name' => 'property', 'do' => 'showcontent', 'category_id' => '14'))?>"><img src="./resource/tencent/img/buttons/hotlink.png" width="50%"></a>
            </div>
        </div>
        <div id="foot" style="margin-top:10%">
            <img src="./resource/tencent/img/footer_1.png" width="100%">
        </div>
    </div>
</body>
</html>
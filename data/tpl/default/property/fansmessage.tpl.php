<?php defined('IN_IA') or exit('Access Denied');?><?php include template('mobile/header_property', TEMPLATE_INCLUDEPATH);?>

    <div class="wrapper" id="container" style="background-color:#400000">
    <div id="banner">
        	<img src="./resource/tencent/img/banner.png" width="100%">
    </div>
    <form id="applyform" action="<?php echo create_url('index/module', array('name' => 'property', 'do' => 'leavemessage', 'category_id' => $article['id']))?>">
    <div id="main_area" style="text-align:left; margin-left: 8%; margin-right:5%; margin-bottom: 8%">
        <div id="header" style="font-size:24px; color:#c8b35a; line-height:30px">
            	<p style="padding-bottom: 5px; padding-top:10px;"><?php echo $article['module_name'];?></p>
        </div>
        <div style="margin-top: 10px; font-size: 18px">
        <dl style="color:#e2d2c5;">
        	<dt>
        		姓名：
                <span><input id="username" type="text" name="username" class="mytxt"></span>
            </dt>
            <br>
            <dt>
            	电话：
                <span><input id="phone" type="text" name="phone" class="mytxt"></span>
            </dt>
            <br>
            <dt>
            	<span style="vertical-align: top;">内容：</span>
                <span><textarea id="content"  name="content" class="mytxt" style="height: 100px; width: 260px"></textarea></span>
            </dt>
        </dl>
        </div>
    </div>
    
	<div id="btnJoin" style="text-align: center;">
		<button type="submit" class="btn_strong" id="submitBtn" style="
		width: 30%;border: 0px solid #7d5252;color: #c8b35a;
		background: -webkit-gradient(linear,left top,left bottom,from(#7d5252),to(#400000));">提交</button>
	</div>
	<br>
	</form>
	
	<div id="foot">
            <img src="./resource/tencent/img/footer_1.png" width="100%">
    </div>
        
	<div id="message_area" style="display: none;">
        <div class="" id="success_dialog" style="top: 5%; width: 90%;">
            <a href="" class=""></a> 	
        </div>
	</div>
	
	</div>
	
	<script type="text/javascript">
	function validate(formData, jqForm, options) { 
	    for (var i=0; i < formData.length; i++) { 
	        if (!formData[i].value) { 
	            alert('请填写姓名和联系方式以及留言内容'); 
	            return false; 
	        } 
	    } 
	}
	
	$("#applyform").submit(function() {
		var options = {
			target: 	"#success_dialog",
			type:		"POST",
			beforeSubmit: validate,
			success: function(){
				alert('留言成功，感谢您的支持!');
				$('#submitBtn').attr("disabled",true);
			}
		}

		$("#applyform").ajaxSubmit(options);
		return false;
	});
	</script>
</body>
</html>
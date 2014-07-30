<?php defined('IN_IA') or exit('Access Denied');?><?php include template('mobile/header_tencent', TEMPLATE_INCLUDEPATH);?>
	<style type="text/css">
	.mytxt {
	    color:#333;
	    line-height:normal;
	    font-family:"Microsoft YaHei",Tahoma,Verdana,SimSun;
	    font-style:normal;
	    font-variant:normal;
	    font-size-adjust:none;
	    font-stretch:normal;
	    font-weight:normal;
	    margin-top:0px;
	    margin-bottom:0px;
	    margin-left:0px;
	    padding-top:4px;
	    padding-right:4px;
	    padding-bottom:4px;
	    padding-left:4px;
	    font-size:15px;
	    outline-width:medium;
	    outline-style:none;
	    outline-color:invert;
	    border-top-left-radius:3px;
	    border-top-right-radius:3px;
	    border-bottom-left-radius:3px;
	    border-bottom-right-radius:3px;
	    text-shadow:0px 1px 2px #fff;
	    background-attachment:scroll;
	    background-repeat:repeat-x;
	    background-position-x:left;
	    background-position-y:top;
	    background-size:auto;
	    background-origin:padding-box;
	    background-clip:border-box;
	    background-color:rgb(255,255,255);
	    margin-right:8px;
	    border-top-color:#ccc;
	    border-right-color:#ccc;
	    border-bottom-color:#ccc;
	    border-left-color:#ccc;
	    border-top-width:1px;
	    border-right-width:1px;
	    border-bottom-width:1px;
	    border-left-width:1px;
	    border-top-style:solid;
	    border-right-style:solid;
	    border-bottom-style:solid;
	    border-left-style:solid;
	}
	.mytxt:focus {
	     border: 1px solid #fafafa;
	    -webkit-box-shadow: 0px 0px 6px #007eff;
	     -moz-box-shadow: 0px 0px 5px #007eff;
	     box-shadow: 0px 0px 5px #007eff;   
	    
	}
	</style>
    <div class="photo_area">
        <div class="photo_show" onclick="">
            <img src="./resource/tencent/img/1009_v2.jpg" width="100%" alt=""/>
        </div>
    </div>
    <form id="applyform" action="<?php echo create_url('index/module', array('name' => 'huodong', 'do' => 'huodongsignup', 'huodong_id' => $huodong['id']))?>">
    <div class="box">
        <h3>请填写客户资料</h3>
        <dl class="act_rule">
        	<dt>姓名：</dt>
            <dd>
               <span><input id="username" type="text" name="username" class="mytxt"></span>
            </dd>
            <dt>电话：</dt>
            <dd>
               <span><input id="phone" type="text" name="phone" class="mytxt"></span>
            </dd>
        </dl>
    </div>
    
	<div id="btnJoin" class="act_join_btn" >
	<button type="submit" class="btn_strong" id="submitBtn" style="width: 96%;">报名确认</button>
	</div>
	</form>
	
	<div id="message_area" style="display: none;">
        <div class="" id="success_dialog" style="top: 5%; width: 90%;">
            <a href="" class=""></a> 	
        </div>
	</div>
	
	<script type="text/javascript">
	// prepare the form when the DOM is ready 
	/*$(document).ready(function() { 
	    // bind form using ajaxForm 
	    $('#applyform').ajaxForm( { beforeSubmit: validate } ); 
	});*/

	function validate(formData, jqForm, options) { 
	    // formData is an array of objects representing the name and value of each field 
	    // that will be sent to the server;  it takes the following form: 
	    // 
	    // [ 
	    //     { name:  username, value: valueOfUsernameInput }, 
	    //     { name:  password, value: valueOfPasswordInput } 
	    // ] 
	    // 
	    // To validate, we can examine the contents of this array to see if the 
	    // username and password fields have values.  If either value evaluates 
	    // to false then we return false from this method. 
	 
	    for (var i=0; i < formData.length; i++) { 
	        if (!formData[i].value) { 
	            alert('请填写姓名和联系方式'); 
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
				alert('报名成功，感谢您的支持!');
				$('#submitBtn').attr("disabled",true);
			}
		}

		$("#applyform").ajaxSubmit(options);
		return false;
	});
	</script>
<?php include template('mobile/footer_tencent', TEMPLATE_INCLUDEPATH);?>
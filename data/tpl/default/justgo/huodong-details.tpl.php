<?php defined('IN_IA') or exit('Access Denied');?><?php include template('mobile/header_tencent', TEMPLATE_INCLUDEPATH);?>
    <div class="photo_area" style="padding-top: 42px;">
        <div class="photo_show" onclick="">
            <img src="./resource/tencent/img/1009_v2.jpg" width="100%" alt=""/>
        </div>
    </div>
    <div class="box"><!-- 收起时加上样式box_up,展开时去掉 -->
        <h3>活动说明</h3>
        <dl class="act_rule">
            <dt>活动时间</dt>
            <dd>
                <p style="min-height:8px"><?php echo date('Y年m月d日', $huodong['start_date'])?> 至  <?php echo date('Y年m月d日', $huodong['end_date'])?></p>
            </dd>
            <dt>活动细节</dt>
            <dd>
                <p style="min-height:8px" id="details"><?php echo $huodong['description'];?></p>
            </dd>
        </dl>
    </div>

	<div id="container" class="wrapper">
	    <div id="navBar" class="rule_title" style="position:fixed;left:0;top:0;overflow:hidden;z-index:9;width:100%;">
	        <a id="btnBack" class="btn_back" onClick="history.go(-1)"><span>&lt;</span></a>
	        <h3 id="titleBar">活动介绍</h3>
	    </div>
	</div>
	<div id="pannelTip" class="box" style="display: none">
	    <div class="result">
	        <h4 id="pannelTitle" class="ico_success"></h4>
	        <div class="result_info">
	            <p id="pannelSubt"></p>
	            <p id="pannelSubt1"></p>
	        </div>
	    </div>
	</div>
	<?php if($huodong['status'] == '0') { ?>
		<h3 style="text-align: center;">活动尚未开始，敬请期待。</h3>
	<?php } else if($huodong['status'] == '1') { ?>
	<div id="btnJoin" class="act_join_btn" style="">
	    <a href="<?php echo create_url('index/module', array('name' => 'huodong', 'do' => 'huodonggosign', 'huodong_id' => $huodong['id']))?>" class="btn_strong">
	    	<span id="btnJoinT">我要报名</span>
	    </a>
	</div>
	<?php } else if($huodong['status'] == '2') { ?>
		<h3 style="text-align: center; color: red;">活动正在火热进行中。</h3>
	<?php } else if($huodong['status'] == '3') { ?>
		<h3 style="text-align: center;">活动已经结束，谢谢您的参与。</h3>
	<?php } ?>
	
	<br>

<script type="text/javascript">
	//将文章内图片按比例缩放
	$(document).ready(function() {
		(function() {
			$('.act_rule img').each(function(index) {
				var maxWidth = $('#details').width(); // 图片最大宽度
				var ratio = 0; // 缩放比例
				var width = $(this).width(); // 图片实际宽度
				var height = $(this).height(); // 图片实际高度

				if(width == 0) {
					$(this).css("width", maxWidth); // 设定实际显示宽度
				}

				// 检查图片是否超宽
				if(width > maxWidth){
					$(this).css("width", maxWidth); // 设定实际显示宽度
				}
			});
		})();
	});
</script>
<script type="text/javascript" src="./resource/tencent/controllers/act-detail.js?ver=1.1"></script>
<?php include template('mobile/footer_tencent', TEMPLATE_INCLUDEPATH);?>
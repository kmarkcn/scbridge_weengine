<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
	<script type="text/javascript" src="./resource/script/jquery.zclip.min.js"></script>
	<div id="main-column" class="container-12 clearfix member-center">
		<div class="column2 grid-3 alpha omega">
			<div class="area hot-tag">
				<h5>温馨告知</h5>
				<ul>
					<li><a href="<?php echo create_url('property')?>">返回</a></li>
					<li class="current"><a href="<?php echo create_url('index/module', array('name' => 'property', 'do' => 'noticeList', 'category_id' => $category_id))?>">查看所有告知</a></li>
					<li><a href="<?php echo create_url('index/module', array('name' => 'property', 'do' => 'noticeModify', 'category_id' => $category_id))?>">新增温馨告知</a></li>
				</ul>
			</div>
		</div>
		<div class="column1 grid-10 alpha omega">
		<div class="list">
				<?php if(is_array($list)) { foreach($list as $row) { ?>
				<div class="account_item clearfix">
					<div class="account_content clearfix">
						<div class="data fl">标题：<?php echo $row['title'];?></div>
						<div class="fr">
						<a href="<?php echo create_url('index/module', array('do' => 'noticeModify', 'name' => 'property', 'category_id' => $category_id, 'notice_id' => $row['id']))?>">编辑</a>
						&nbsp;
						<a onclick="return confirm('删除文章将不可恢复，确认吗？');return false;" href="<?php echo create_url('index/module', array('do' => 'noticeDelete', 'name' => 'property', 'category_id' => $category_id, 'notice_id' => $row['id']))?>">删除</a>
						</div>
					</div>
					<div class="account_desc clearfix" style="height:auto;">
							<div id="time_period_<?php echo $row['id'];?>">添加时间：<?php echo date('Y-m-d', $row['notice_date'])?></div> 
					</div>
				</div>
				
				<script type="text/javascript">
					$(function() {
						$("#api_<?php echo $row['weid'];?> button").zclip({
							path:'./resource/script/ZeroClipboard.swf',
							copy:$('#api_<?php echo $row['weid'];?> input').val()
						});
						$("#token_<?php echo $row['weid'];?> button").zclip({
							path:'./resource/script/ZeroClipboard.swf',
							copy:$('#token_<?php echo $row['weid'];?> input').val()
						});
					});
				</script>
				<?php } } ?>
			</div>
		</div>
	</div>
<?php include template('common/footer', TEMPLATE_INCLUDEPATH);?>
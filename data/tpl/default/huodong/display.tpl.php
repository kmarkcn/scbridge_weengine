<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
	<script type="text/javascript" src="./resource/script/jquery.zclip.min.js"></script>
	<div id="main-column" class="container-12 clearfix member-center">
		<div class="column2 grid-3 alpha omega">
			<?php include template('huodong/nav', TEMPLATE_INCLUDEPATH);?>
			
		</div>
		<div class="column1 grid-10 alpha omega">
			<div class="list">
				<?php if(is_array($list)) { foreach($list as $row) { ?>
				<div class="account_item clearfix">
					<div class="account_content clearfix">
						<div class="data fl"><?php echo $row['name'];?></div>
						<div class="fr">
						<a href="<?php echo create_url('index/module', array('do' => 'checksignuplist', 'name' => 'huodong', 'huodong_id' => $row['id']))?>">查看报名名单</a>
						&nbsp;
						<a href="<?php echo create_url('huodong/post', array('id' => $row['id']))?>">编辑</a>
						&nbsp;
						<a onclick="return confirm('删除活动将不可恢复，确认吗？');return false;" href="<?php echo create_url('huodong/delete', array('id' => $row['id']))?>">删除</a>
						</div>
					</div>
					<div class="account_desc clearfix" style="height:auto;">
						<div id="pic_<?php echo $row['id'];?>" style="height: 100%"><label>活动封面：</label><img width="100" src="<?php echo $_W['attachurl'];?><?php echo $row['picture'];?>"></div>
						</br>
						<div id="description_<?php echo $row['id'];?>">活动简介：<?php echo $row['brief'];?></div>
						<div id="time_period_<?php echo $row['id'];?>">活动时间：<?php echo date('Y-m-d', $row['start_date'])?> - <?php echo date('Y-m-d', $row['end_date'])?></div> 
						<div id="time_period_<?php echo $row['id'];?>">活动状态：
						<?php if($row['status'] == '0') { ?>
							未开始
						<?php } else if($row['status'] == '1') { ?>
							报名中
						<?php } else if($row['status'] == '2') { ?>
							活动中
						<?php } else if($row['status'] == '3') { ?>
							已结束
						<?php } ?>
						</div>
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

<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
	<div id="main-column" class="container-12 clearfix member-center">
		<div class="column2 grid-3 alpha omega">
			<?php include template('huodong/nav', TEMPLATE_INCLUDEPATH);?>
		</div>
		<div class="column1 grid-10 alpha omega">
			<div class="form">
				<div class="form_h">
				<?php if(empty($id)) { ?>
				<h6>添加活动</h6>
				<?php } else { ?>
				<h6>修改活动</h6>
				<?php } ?>
				</div>
				<form action="" method="post" onsubmit="return formcheck(this)">
				<input type="hidden" name="id" value="<?php echo $id;?>" />
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<th>活动名称</th>
					<td>
						<input type="text" name="name" class="txt grid-4 alpha pin" value="<?php echo $huodong['name'];?>" autofocus="autofocus" required="required"/>
					</td>
				</tr>
				<tr>
					<th>小图封面</th>
					<td>
						<div class="upload-area grid-5 pin"><span class="fr">图片建议尺寸：100像素 * 100像素</span>
						<input type="button"  id="loc-picture" fieldname="picture" class="upload-file-btn" value="上传"/>
						<?php if(!empty($huodong['picture'])) { ?>
						<div id="upload-file-view">	
						<div class="upload-view">
							<input type="hidden" name="picture" value="<?php echo $huodong['picture'];?>">
							<input type="hidden" id="picture-value" value="<?php echo $huodong['picture'];?>">
							<img width="100" src="<?php echo $_W['attachurl'];?><?php echo $huodong['picture'];?>">&nbsp;&nbsp;
							<a onclick="kindeditor_upload_delete(this, '<?php echo $huodong['picture'];?>')" href="javascript:;">删除</a>
						</div>
						</div>
						<?php } else { ?>
						<div id="upload-file-view"></div>
						<?php } ?>
						</div>
						<div class="notice">设置该活动的封面，使得此活动有一个直观的展示</div>
					</td>
				</tr>
				<tr>
					<th>活动简介</th>
					<td>
						<textarea name="brief" style="height: 100%" class="txt content" cols="40"><?php echo $huodong['brief'];?></textarea>
						<div class="notice">对该活动的一个简单介绍</div>
					</td>
				</tr>
				<tr>
					<th>活动时间</th>
					<td>
						<input type="text" class="txt grid-2 alpha pin datepicker" required id="date1" name="starttime" value="<?php if($huodong['start_date']) { ?><?php echo date('Y-m-d', $huodong['start_date'])?><?php } ?>" /> 至 &nbsp; 
						<input type="text" class="txt grid-2 alpha pin datepicker" required id="date2" name="endtime" value="<?php if($huodong['end_date']) { ?><?php echo date('Y-m-d', $huodong['end_date'])?><?php } ?>" />
					</td>
				</tr>
				<tr>
					<th>活动状态</th>
					<td>
						<select name="status" id="status">
							<?php if($huodong['status'] == '0') { ?>
								<option value="0" selected>
							<?php } else { ?>
								<option value="0">
							<?php } ?>未开始</option>
								
							<?php if($huodong['status'] == '1') { ?>
								<option value="1" selected>
							<?php } else { ?>
								<option value="1">
							<?php } ?>报名中</option>
							
							<?php if($huodong['status'] == '2') { ?>
								<option value="2" selected>
							<?php } else { ?>
								<option value="2">
							<?php } ?>活动中</option>
							
							<?php if($huodong['status'] == '3') { ?>
								<option value="3" selected>
							<?php } else { ?>
								<option value="3">
							<?php } ?>已结束</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>活动祥述</th>
					<td>
						<textarea name="description" class="richtext-clone" id="richtext_content" class="txt grid-5 alpha pin" style="height:50px; width:470px;"><?php echo $huodong['description'];?></textarea>
						<div class="notice">对该活动的一个详细介绍</div>
					</td>
				</tr>
				<tr>
					<th></th>
					<td>
						<input name="submit" type="submit" value="提交" class="mt10 btn grid-2 alpha" />
						<input type="hidden" name="token" value="<?php echo $_W['token'];?>" />
					</td>
				</tr>
				</table>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		//kindeditor('textarea:[class="richtext-clone"]');
		//这个[0]太威武！！！
		kindeditor_upload_image($('#loc-picture')[0]);
		kindeditor($('#richtext_content')[0]);
	</script>
<?php include template('common/footer', TEMPLATE_INCLUDEPATH);?>

<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
	<div id="main-column" class="container-12 clearfix member-center">
		<div class="column2 grid-3 alpha omega">
			<?php include template('hotel/nav', TEMPLATE_INCLUDEPATH);?>
		</div>
		<div class="column1 grid-10 alpha omega">
			<div class="form">
				<div class="form_h">
				<?php if(empty($id)) { ?>
				<h6>添加酒店</h6>
				<?php } else { ?>
				<h6>修改酒店</h6>
				<?php } ?>
				</div>
				<form action="" method="post" onsubmit="return formcheck(this)">
				<input type="hidden" name="id" value="<?php echo $id;?>" />
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<th>酒店信息</th>
					<td>
						<div style='border:1px solid #ddd;width:80%;padding:5px;font-size:13px;color:#888;'>
						名称&nbsp;&nbsp;<input type="text" name="name" class="" value="<?php echo $hotel['name'];?>" autofocus="autofocus" required="required"/>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;星级&nbsp;
							<select name='level'>
								<option value='1' 
									<?php if($hotel['level']=='1') { ?>
										selected='selected'
									<?php } else { ?>
									<?php } ?>
								>1星级</option>
								<option value='2'
									<?php if($hotel['level']=='2') { ?>
										selected='selected'
									<?php } else { ?>
									<?php } ?>
								>2星级</option>
								<option value='3'
									<?php if($hotel['level']=='3') { ?>
										selected='selected'
									<?php } else { ?>
									<?php } ?>
								>3星级</option>
								<option value='4'
									<?php if($hotel['level']=='4') { ?>
										selected='selected'
									<?php } else { ?>
									<?php } ?>
								>4星级</option>
								<option value='5'
									<?php if($hotel['level']=='5') { ?>
										selected='selected'
									<?php } else { ?>
									<?php } ?>
								>5星级</option>
							</select>
						<br/><br/>
						国家&nbsp;&nbsp;<input type="text" name="nation" class="" value="<?php echo $hotel['nation'];?>" autofocus="autofocus" required="required" style='width:80px;'/>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						城市&nbsp;&nbsp;<input type='text' style='width:80px;' name='city' autofocus="autofocus" required="required" value='<?php echo $hotel['city'];?>'>
						<br/><br/>
						地址&nbsp;&nbsp;<input type="text" name="address" class="" value="<?php echo $hotel['address'];?>" autofocus="autofocus" required="required" style='width:320px;'/>
						</div>	
					</td>
				</tr>
				<tr>
					<th>酒店图片</th>
					<td>
						<div class="upload-area grid-5 pin"><span class="fr">图片建议尺寸：150像素 * 150像素</span>
						<input type="button"  id="loc-picture" fieldname="picture" class="upload-file-btn" value="上传"/>
						<?php if(!empty($hotel['icon'])) { ?>
						<div id="upload-file-view">	
						<div class="upload-view">
							<input type="hidden" name="picture" value="<?php echo $hotel['icon'];?>">
							<input type="hidden" id="picture-value" value="<?php echo $hotel['icon'];?>">
							<img width="100" src="<?php echo $_W['attachurl'];?><?php echo $hotel['icon'];?>">&nbsp;&nbsp;
							<a onclick="kindeditor_upload_delete(this, '<?php echo $hotel['icon'];?>')" href="javascript:;">删除</a>
						</div>
						</div>
						<?php } else { ?>
						<div id="upload-file-view"></div>
						<?php } ?>
						</div>
						<div class="notice">设置该酒店的图片，有一个直观的展示</div>
					</td>
				</tr>
				
				<tr>
					<th>酒店简介</th>
					<td>
						<textarea name="description" class="richtext-clone" id="richtext_content" class="txt grid-5 alpha pin" style="height:50px; width:470px;"><?php echo $hotel['description'];?></textarea>
						<div class="notice">对该酒店的一个详细介绍</div>
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

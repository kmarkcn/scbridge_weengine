<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
	<div id="main-column" class="container-12 clearfix member-center">
		<div class="column2 grid-3 alpha omega">
			<?php include template('hotel/nav', TEMPLATE_INCLUDEPATH);?>
		</div>
		<div class="column1 grid-10 alpha omega">
			<div class="form">
				<div class="form_h">
				<h6>添加房间<a style='font-size:13px;color:red;'>(当前对应酒店:<?php echo $hotel['name'];?>)</a></h6>
				
				</div>
				<form action="" method="post" onsubmit="return formcheck(this)">
				<input type="hidden" name="id" value="<?php echo $id;?>" />
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<th>房间信息</th>
					<td>
						<div style='border:1px solid #ddd;width:80%;padding:5px;font-size:13px;color:#888;'>
						名称&nbsp;&nbsp;<input type="text" name="name" class="" value="<?php echo $room['name'];?>" autofocus="autofocus" required="required"/>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;类型&nbsp;
							<select name='ismeeting'>
								<option value='0' 
									<?php if($hotel['level']=='1') { ?>
										selected='selected'
									<?php } else { ?>
									<?php } ?>
								>普通房</option>
								<option value='1'
									<?php if($hotel['level']=='2') { ?>
										selected='selected'
									<?php } else { ?>
									<?php } ?>
								>会议室</option>
							</select>
						<br/><br/>
						容纳人数&nbsp;&nbsp;<input type="text" name="min_number" class="" value="<?php echo $room['min_number'];?>" autofocus="autofocus" required="required" style='width:50px;'/>
						到&nbsp;&nbsp;<input type='text' style='width:50px;' name='max_number' autofocus="autofocus" required="required" value='<?php echo $room['max_number'];?>'>(人)
						<br/><br/>
						非会员价&nbsp;&nbsp;<input type="text" name="price_normal" class="" value="<?php echo $room['price_normal'];?>" autofocus="autofocus" required="required" style='width:80px;'/>
						&yen;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						会员价&nbsp;&nbsp;<input type="text" name="price_vip" class="" value="<?php echo $room['price_vip'];?>" autofocus="autofocus" required="required" style='width:80px;'/>
						&yen;</div>	
					</td>
				</tr>
				<tr>
					<th>房间图片</th>
					<td>
						<div class="upload-area grid-5 pin"><span class="fr">图片建议尺寸：150像素 * 150像素</span>
						<input type="button"  id="loc-picture" fieldname="picture" class="upload-file-btn" value="上传"/>
						<?php if(!empty($room['icon'])) { ?>
						<div id="upload-file-view">	
						<div class="upload-view">
							<input type="hidden" name="picture" value="<?php echo $room['icon'];?>">
							<input type="hidden" id="picture-value" value="<?php echo $room['icon'];?>">
							<img width="100" src="<?php echo $_W['attachurl'];?><?php echo $room['icon'];?>">&nbsp;&nbsp;
							<a onclick="kindeditor_upload_delete(this, '<?php echo $room['icon'];?>')" href="javascript:;">删除</a>
						</div>
						</div>
						<?php } else { ?>
						<div id="upload-file-view"></div>
						<?php } ?>
						</div>
						<div class="notice">设置该房间的图片，有一个直观的展示</div>
					</td>
				</tr>
				
				<tr>
					<th>房间简介</th>
					<td>
						<textarea name="description" class="richtext-clone" id="richtext_content" class="txt grid-5 alpha pin" style="height:50px; width:470px;"><?php echo $room['description'];?></textarea>
						<div class="notice">对该房间的一个详细介绍</div>
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

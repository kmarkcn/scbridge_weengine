<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
	<div id="main-column" class="container-12 clearfix member-center">
		<div class="column2 grid-3 alpha omega">
			<?php include template('goods/nav', TEMPLATE_INCLUDEPATH);?>
		</div>
		<div class="column1 grid-10 alpha omega">
			<div class="form">
				<div class="form_h">
				<?php if(empty($id)) { ?>
				<h6>添加商品</h6>
				<?php } else { ?>
				<h6>修改商品</h6>
				<?php } ?>
				</div>
				<form action="" method="post" onsubmit="return formcheck(this)">
				<input type="hidden" name="id" value="<?php echo $id;?>" />
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<th>商品信息</th>
					<td>
						<div style='border:1px solid #ddd;width:80%;padding:5px;font-size:13px;color:#888;'>
						名称&nbsp;&nbsp;<input type="text" name="name" class="" value="<?php echo $goods['name'];?>" autofocus="autofocus" required="required"/>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;类型&nbsp;&nbsp;
							<select name='good_type'>
								<option>1</option>
								<option>2</option>
								<option>3</option>
								<option>4</option>
								<option>5</option>
								<option>6</option>
							</select>
						<br/><br/>
						数量&nbsp;&nbsp;<input type="text" name="good_stock" class="" value="<?php echo $goods['name'];?>" autofocus="autofocus" required="required" style='width:60px;'/>
						<a style='font-size:6px;'>(以所卖每份为单位)</a>
						&nbsp;&nbsp;价格&nbsp;&nbsp;<input type='text' style='width:80px;' name='price' autofocus="autofocus" required="required" value='<?php echo $goods['price'];?>'><a style='font-size:6px;'>(单位:元/份)</a>
						</div>
					</td>
				</tr>
				
				<tr>
					<th>商品图片</th>
					<td>
						<div class="upload-area grid-5 pin"><span class="fr">图片建议尺寸：100像素 * 100像素</span>
						<input type="button"  id="loc-picture" fieldname="picture" class="upload-file-btn" value="上传"/>
						<?php if(!empty($goods['icon'])) { ?>
						<div id="upload-file-view">	
						<div class="upload-view">
							<input type="hidden" name="picture" value="<?php echo $goods['icon'];?>">
							<input type="hidden" id="picture-value" value="<?php echo $goods['icon'];?>">
							<img width="100" src="<?php echo $_W['attachurl'];?><?php echo $goods['icon'];?>">&nbsp;&nbsp;
							<a onclick="kindeditor_upload_delete(this, '<?php echo $goods['icon'];?>')" href="javascript:;">删除</a>
						</div>
						</div>
						<?php } else { ?>
						<div id="upload-file-view"></div>
						<?php } ?>
						</div>
						<div class="notice">设置该商品的图片，有一个直观的展示</div>
					</td>
				</tr>
				
				<tr>
					<th>商品简叙</th>
					<td>
						<textarea name="brief_intro"  class="txt grid-5 alpha pin" style="height:50px; width:470px;"><?php echo $goods['brief_intro'];?></textarea>
					</td>
				</tr>
				
				<tr>
					<th>商品详细描述</th>
					<td>
						<textarea name="detailed_intro" class="richtext-clone" id="richtext_content" class="txt grid-5 alpha pin" style="height:200px; width:540px;"><?php echo $goods['detailed_intro'];?></textarea>
						<div class="notice">对该商品的一个详细介绍(可以编辑图片)</div>
					</td>
				</tr>
				
				<tr>
					<th>商品备注</th>
					<td>
						<textarea name="remarks"  class="txt grid-5 alpha pin" style="height:50px; width:470px;"><?php echo $goods['remarks'];?></textarea>
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

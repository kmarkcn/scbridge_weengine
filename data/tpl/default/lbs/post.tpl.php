<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
	<div id="main-column" class="container-12 clearfix member-center">
		<div class="column2 grid-3 alpha omega">
			<?php include template('lbs/nav', TEMPLATE_INCLUDEPATH);?>
		</div>
		<div class="column1 grid-10 alpha omega">
			<div class="form">
				<div class="form_h">
				<?php if(empty($id)) { ?>
				<h6>添加商户</h6>
				<?php } else { ?>
				<h6>修改商户</h6>
				<?php } ?>
				</div>
				<form action="" method="post" onsubmit="return formcheck(this)">
				<input type="hidden" name="id" value="<?php echo $id;?>" />
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<th>商户名称</th>
					<td>
						<input type="text" name="name" class="txt grid-4 alpha pin" value="<?php echo $loc['name'];?>" autofocus="autofocus" required="required"/>
						<div class="notice">您可以给此商户起一个名字, 方便下次修改和查看. </div>
					</td>
				</tr>
				<tr>
					<th>展示顺序</th>
					<td>
						<input type="text" name="displayorder" class="txt grid-1 alpha pin" required="required" value="<?php echo $loc['displayorder'];?>">
						<div class="notice">请输入0至99的数字，数字越小，显示越靠前</div>
					</td>
				</tr>
				<tr>
					<th>封面小图</th>
					<td>
						<div class="upload-area grid-5 pin"><span class="fr">图片建议尺寸：100像素 * 100像素</span>
						<input type="button"  id="loc-picture" fieldname="picture" class="upload-file-btn" value="上传"/>
						<?php if(!empty($loc['picture'])) { ?>
						<div id="upload-file-view">	
						<div class="upload-view">
							<input type="hidden" name="picture" value="<?php echo $loc['picture'];?>">
							<input type="hidden" id="picture-value" value="<?php echo $loc['picture'];?>">
							<img width="100" src="<?php echo $_W['attachurl'];?><?php echo $loc['picture'];?>">&nbsp;&nbsp;
							<a onclick="kindeditor_upload_delete(this, '<?php echo $loc['picture'];?>')" href="javascript:;">删除</a>
						</div>
						</div>
						<?php } else { ?>
						<div id="upload-file-view"></div>
						<?php } ?>
						</div>
						<div class="notice">设置该位置的封面，使得此位置有一个直观的展示</div>
					</td>
				</tr>
				<tr>
					<th>商户地址</th>
					<td>
						<input type="text" name="address" class="txt grid-4 alpha pin" value="<?php echo $loc['address'];?>" required="required"/>
						<div class="notice">商户的具体地址 </div>
					</td>
				</tr>
				<tr>
					<th>商户描述</th>
					<td>
						<textarea name="description" class="txt grid-4 alpha pin" required="required" style="height: 60px"><?php echo $loc['description'];?></textarea>
						<div class="notice">对该商户的一个详细介绍</div>
					</td>
				</tr>
				<tr>
					<th>联系电话</th>
					<td>
						<input type="text" name="phone" class="txt grid-2 alpha pin" value="<?php echo $loc['phone'];?>" required="required"/>
						<div class="notice">用于设置直接拨打电话 </div>
					</td>
				</tr>
				<tr>
					<th>商户类别</th>
					<td>
						<select name="type" id="type">
							<?php if($loc['type'] == '1') { ?>
								<option value="1" selected>
							<?php } else { ?>
								<option value="1">
							<?php } ?>美食</option>
								
							<?php if($loc['type'] == '2') { ?>
								<option value="2" selected>
							<?php } else { ?>
								<option value="2">
							<?php } ?>娱乐</option>	
												
							<?php if($loc['type'] == '3') { ?>
								<option value="3" selected>
							<?php } else { ?>
								<option value="3">
							<?php } ?>购物</option>
							
							<?php if($loc['type'] == '4') { ?>
								<option value="4" selected>
							<?php } else { ?>
								<option value="4">
							<?php } ?>休闲</option>
						</select>
						<div class="notice">凭借该选项进行类别筛选 </div>
					</td>
				</tr>
				<tr>
					<th>展示大图</th>
					<td>
						<div class="upload-area grid-5 pin"><span class="fr">图片建议尺寸：400像素 * 600像素</span>
						<input type="button"  id="loc-showpic" fieldname="showpic" class="upload-file-btn" value="上传"/>
						<?php if(!empty($loc['showpic'])) { ?>
						<div id="upload-file-view">	
						<div class="upload-view">
							<input type="hidden" name="showpic" value="<?php echo $loc['showpic'];?>">
							<input type="hidden" id="showpic-value" value="<?php echo $loc['showpic'];?>">
							<img width="100" src="<?php echo $_W['attachurl'];?><?php echo $loc['showpic'];?>">&nbsp;&nbsp;
							<a onclick="kindeditor_upload_delete(this, '<?php echo $loc['showpic'];?>')" href="javascript:;">删除</a>
						</div>
						</div>
						<?php } else { ?>
						<div id="upload-file-view"></div>
						<?php } ?>
						</div>
						<div class="notice">用于全屏展示该商户的形象</div>
					</td>
				</tr>
				<tr>
					<th>纬度</th>
					<td>
						<input type="text" name="x_axis" class="txt grid-4 alpha pin" value="<?php echo $loc['x_axis'];?>" required="required" pattern="[0-9]{2,3}.[0-9]{6,12}" title="请输入正确的经纬度数值"/>
						<div class="notice">该地点的纬度数值</div>
					</td>
				</tr>
				<tr>
					<th>经度</th>
					<td>
						<input type="text" name="y_axis" class="txt grid-4 alpha pin" value="<?php echo $loc['y_axis'];?>" required="required" pattern="[0-9]{2,3}.[0-9]{6,12}" title="请输入正确的经纬度数值"/>
						<div class="notice">该地点的经度数值，不知道经纬度点这里（百度地图）→<a href="http://www.gpsspg.com/maps.htm" target="blank">经纬度查询</a></div>
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
		kindeditor('textarea:[class="richtext-clone"]');
		//这个[0]太威武！！！
		kindeditor_upload_image($('#loc-picture')[0]);
		kindeditor_upload_image($('#loc-showpic')[0]);
	</script>
<?php include template('common/footer', TEMPLATE_INCLUDEPATH);?>

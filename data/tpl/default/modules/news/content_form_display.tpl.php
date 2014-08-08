<?php defined('IN_IA') or exit('Access Denied');?><?php if(empty($child)) { ?>
<?php $id = $id;?>
<?php $key = $_GPC['key'];?>
<?php $namesuffix = '-content-new['.$key.'][]'?>
<?php } else { ?>
<?php $id = 'add-row-news-'.$child['id'];?>
<?php $key = $child['parentid'];?>
<?php $namesuffix = '['.$child['id'].']'?>
<?php } ?>
<div class="news-item" id="<?php echo $id;?>">
	<div id="news-preview" class="clearfix" <?php if(empty($child)) { ?>style="display:none"<?php } ?>>
		<div class="news-thumb fl">
			<p class="news-default-tips" <?php if(!empty($child)) { ?>style="display:none"<?php } ?>>缩略图</p>
			<img class="i-img" src="<?php echo $_W['attachurl'];?><?php echo $child['thumb'];?>" id="news-preview-picture" width="100">
		</div>
		<div class="news-title-wrap">
			<h4 class="news-title" id="news-preview-title"><?php echo $child['title'];?></h4>
			<div><a href="javascript:;" onclick="edit_row('add-row-news-<?php echo $key;?>', '<?php echo $id;?>')">编辑</a>&nbsp;|&nbsp;<?php if(!empty($child)) { ?><a href="<?php echo create_url('index/module/delete', array('name' => 'news', 'id' => $child['id']))?>" onclick="if (confirm('删除操作不可恢复，确认删除吗？')){ajaxopen(this.href, function(){$('#add-row-news-<?php echo $child['id'];?>').remove();});}return false;">删除</a><?php } else { ?><a href="javascript:;" onclick="var i=confirm('删除操作不可恢复，确认删除吗？');if(i){$('#<?php echo $id;?>').remove()};return false;">删除</a><?php } ?></div>
		</div>
	</div>	
	<div id="news-form" class="form" <?php if(!empty($child)) { ?>style="display:none"<?php } ?>>
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr>
			<th>标题</th>
			<td>
				<input type="text" name="news-title<?php echo $namesuffix;?>" id="news-title" class="txt grid-5 alpha pin" value="<?php echo $child['title'];?>" />
			</td>
		</tr>
		<tr>
			<th>封面</th>
			<td>
				<div class="upload-area grid-5 pin"><span class="fr">大图片建议尺寸：100像素 * 100像素</span>
					<input type="button" id="news-picture" fieldname="news-picture<?php echo $namesuffix;?>" class="upload-file-btn" value="上传" style="display:none;" />
					<?php if(!empty($child)) { ?>
					<div id="upload-file-view">	
						<input type="hidden" name="news-picture-old[<?php echo $child['id'];?>]" value="<?php echo $child['thumb'];?>">
						<input type="hidden" id="news-picture-value" value="<?php echo $child['thumb'];?>">
						<img width="100" src="<?php echo $_W['attachurl'];?><?php echo $child['thumb'];?>">&nbsp;&nbsp;
						<a onclick="kindeditor_upload_delete(this, '<?php echo $child['thumb'];?>')" href="javascript:;">删除</a>
					</div>
					<?php } else { ?>
					<div id="upload-file-view"></div>
					<?php } ?>
				</div>
			</td>
		</tr>
		<tr>
			<th>原文</th>
			<td>
				<textarea name="news-content<?php echo $namesuffix;?>" cols="70" class="richtext-clone" style="height:50px; width:470px;"><?php echo $child['content'];?></textarea>
			</td>
		</tr>
		<tr>
		<th>来源</th>
		<td>
			<input type="text" name="news-url<?php echo $namesuffix;?>" class="txt grid-5 alpha pin" value="<?php echo $child['url'];?>" />
		</td>
		</tr>
		</table>
	</div>
</div>
<?php if(!empty($child)) { ?>
<script type="text/javascript">
var row = $('#<?php echo $id;?>');
kindeditor(row.find('textarea:[class="richtext-clone"]'));
kindeditor_upload_image(row.find('#news-picture')[0]);	
</script>
<?php } ?>
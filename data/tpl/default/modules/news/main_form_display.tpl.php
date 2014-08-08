<?php defined('IN_IA') or exit('Access Denied');?><?php if(empty($news)) { ?>
<?php $id = $id;?>
<?php $key = $_W['timestamp'];?>
<?php $namesuffix = '-new'?>
<?php } else { ?>
<?php $id = 'add-row-news-'.$news['id'];?>
<?php $key = $news['id'];?>
<?php $namesuffix = ''?>
<?php } ?>
<div id="<?php echo $id;?>" class="item">
	<span class="fr"><?php if(empty($news)) { ?><a href="javascript:;" onclick="if(confirm('删除操作不可恢复，确认删除吗？')){$('#<?php echo $id;?>').remove();};return false;">X</a><?php } else { ?><a href="<?php echo create_url('index/module/delete', array('name' => 'news', 'id' => $news['id']))?>" onclick="if (confirm('删除操作不可恢复，确认删除吗？')){ajaxopen(this.href, function(){$('#add-row-news-<?php echo $news['id'];?>').remove();});}return false;">X</a><?php } ?></span>
	<div id="news-item-main" class="news-item">
		<div id="news-preview" class="clearfix" <?php if(empty($news)) { ?>style="display:none;"<?php } ?>>
			<div class="news-cover fl">
				<p class="news-default-tips" <?php if(!empty($news['thumb'])) { ?> style="display:none;"<?php } ?>>封面图片</p>
				<img class="i-img" src="<?php echo $_W['attachurl'];?><?php echo $news['thumb'];?>" id="news-preview-picture">
			</div>
			<div class="news-content-wrap">
				<h4 class="news-title" id="news-preview-title"><?php echo $news['title'];?></h4>
				<div class="news-content" id="news-content"></div>
				<div><a href="javascript:;" onclick="edit_row('<?php echo $id;?>', 'news-item-main')">编辑</a></div>
			</div>
		</div>
		<div id="news-form" class="form" <?php if(!empty($news)) { ?>style="display:none;"<?php } ?>>
			<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr>
				<th>标题</th>
				<td>
					<input type="text" name="news-title<?php echo $namesuffix;?>[<?php echo $key;?>]" id="news-title" class="txt grid-5 alpha pin" value="<?php echo $news['title'];?>" />
				</td>
			</tr>
			<tr>
				<th>封面</th>
				<td>
					<div class="upload-area grid-5 pin"><span class="fr">大图片建议尺寸：700像素 * 300像素</span>
						<input type="button"  id="news-picture" fieldname="news-picture<?php echo $namesuffix;?>[<?php echo $key;?>]" class="upload-file-btn" value="上传" style="display:none;" />
						<?php if(!empty($news)) { ?>
						<div id="upload-file-view">	
							<input type="hidden" name="news-picture-old[<?php echo $key;?>]" value="<?php echo $news['thumb'];?>">
							<input type="hidden" id="news-picture-value" value="<?php echo $news['thumb'];?>">
							<img width="100" src="<?php echo $_W['attachurl'];?><?php echo $news['thumb'];?>">&nbsp;&nbsp;
							<a onclick="kindeditor_upload_delete(this, '<?php echo $news['thumb'];?>')" href="javascript:;">删除</a>
						</div>
						<?php } else { ?>
						<div id="upload-file-view"></div>
						<?php } ?>	
					</div>
				</td>
			</tr>
			<tr>
				<th>描述</th>
				<td>
					<textarea name="news-description<?php echo $namesuffix;?>[<?php echo $key;?>]" cols="50" class="txt content" style="height:50px; width:450px;"><?php echo $news['description'];?></textarea>
				</td>
			</tr>
			<tr>
				<th>原文</th>
				<td>
					<textarea name="news-content<?php echo $namesuffix;?>[<?php echo $key;?>]" cols="70" class="richtext-clone" style="height:50px; width:470px;"><?php echo $news['content'];?></textarea>
				</td>
			</tr>
			<tr>
				<th>来源</th>
				<td>
					<input type="text" name="news-url<?php echo $namesuffix;?>[<?php echo $key;?>]" class="txt grid-5 alpha pin" value="<?php echo $news['url'];?>" />
				</td>
			</tr>
		</table>
		</div>
	</div>
	<?php if(!empty($news)) { ?>
	<script type="text/javascript">
	var row = $('#<?php echo $id;?>');
	kindeditor(row.find('textarea:[class="richtext-clone"]'));
	kindeditor_upload_image(row.find('#news-picture')[0]);	
	</script>
	<?php } ?>
	<?php if(!empty($news['children'])) { ?>
	<?php if(is_array($news['children'])) { foreach($news['children'] as $child) { ?>
	<?php include template('modules/news/content_form_display', TEMPLATE_INCLUDEPATH);?>
	<?php } } ?>
	<?php } ?>
	<div class="mt10 form">
		<input name="news-add" type="button" value="添加内容" onclick="add_row_content(this, '<?php echo $key;?>')" class="mt10 btn alpha" />&nbsp;&nbsp;为当前图文信息增加多条内容
	</div> 
</div>


<?php defined('IN_IA') or exit('Access Denied');?><?php if(empty($item)) { ?>
<?php $id = $id;?>
<?php $key = $_W['timestamp'];?>
<?php $namesuffix = '-new';?>
<?php $switch = 'on new_add';?>
<?php } else { ?>
<?php $id = 'add-row-'.$item['id'];?>
<?php $key = $item['id'];?>
<?php $namesuffix = '';?>
<?php $switch = 'off';?>
<?php } ?>
<div id="<?php echo $id;?>" class="item <?php echo $switch;?>">
	<span class="fr">
		<a href="javascript:;" class="open_music">编辑</a>
		<?php if(empty($item)) { ?><a href="javascript:;" onclick="if(confirm('删除操作不可恢复，确认删除吗？')){$('#<?php echo $id;?>').remove();};return false;">删除</a><?php } else { ?><a href="<?php echo create_url('index/module/delete', array('name' => 'music', 'id' => $item['id']))?>" onclick="if (confirm('删除操作不可恢复，确认删除吗？')){ajaxopen(this.href, function(){$('#add-row-<?php echo $item['id'];?>').remove();});}return false;">删除</a><?php } ?>
	</span>

	<div id="music_off"><span class="music_button music_play" music_url="<?php echo $item['url'];?>" music_switch="1"></span><span class="music_title"><?php echo $item['title'];?></span><span class="jp" id="jp-<?php echo $item['id'];?>"></span></div>
	<div id="item-main">
		<div id="item-form" class="form">
			<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tbody>
			<tr>
				<th>音乐标题</th>
				<td>
					<input type="text" name="title<?php echo $namesuffix;?>[<?php echo $key;?>]" id="" class="txt grid-5 alpha pin" value="<?php echo $item['title'];?>">
					<div class="notice"><!--input name="" type="button" value="搜索" onclick="" class="mt10 btn alpha"-->如果搜索不到满意的音频文件，您也可以 <input type="button" id="item-attach" fieldname="attach<?php echo $namesuffix;?>[<?php echo $key;?>]" class="upload-file-btn" onclick="alert(1);" value="上传音乐" style="display:none;" /></div>
					<?php if(!empty($item)) { ?>
					<input type="hidden" name="url-old[<?php echo $key;?>]" value="<?php echo $item['url'];?>">
					<?php } ?>
				</td>
			</tr>
			<tr>
				<th>音乐链接</th>
				<td>
					<input type="text" name="url<?php echo $namesuffix;?>[<?php echo $key;?>]" id="item-url" class="txt grid-5 alpha pin" value="<?php echo $item['url'];?>">
					<div class="notice">常用格式：mp3，推荐使用搜狗音乐链接：http://mp3.sogou.com</div>
				</td>
			</tr>
			<tr>
				<th>高品质链接</th>
				<td>
					<input type="text" name="hqurl<?php echo $namesuffix;?>[<?php echo $key;?>]" id="" class="txt grid-5 alpha pin" value="<?php echo $item['hqurl'];?>">
					<div class="notice">没有高品质音乐链接，请留空。高质量音乐链接，WIFI环境优先使用该链接播放音乐</div>
				</td>
			</tr>
			<tr>
				<th>音乐描述</th>
				<td>
					<input type="text" name="description<?php echo $namesuffix;?>[<?php echo $key;?>]" id="" class="txt grid-5 alpha pin" value="<?php echo $item['description'];?>">
					<div class="notice">描述内容将出现在音乐名称下方，建议控制在20个汉字以内最佳</div>
				</td>
			</tr>
		</tbody>
		</table>
		</div>
	</div>
</div>
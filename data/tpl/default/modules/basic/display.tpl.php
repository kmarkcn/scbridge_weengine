<?php defined('IN_IA') or exit('Access Denied');?><input name="reply-add" type="button" value="添加" onclick="reply_add()" class="btn alpha" />
<div id="reply-list" class="list">
	<?php if(is_array($reply)) { foreach($reply as $row) { ?>
		<div id="add-row-basic-<?php echo $row['id'];?>" class="item clearfix">
			<div class="content">
				<div class="data fl">
				<input type="hidden" id="reply-value" value="<?php echo htmlspecialchars($row['content'])?>" name="reply[<?php echo $row['id'];?>]">
				<label for="label_<?php echo $row['id'];?>" id="reply-name"><?php echo $row['content'];?></label></div>
				<span id="confirm-delete"><a href="<?php echo create_url('index/module/delete', array('name' => 'basic', 'id' => $row['id']))?>" onclick="if (confirm('删除操作不可恢复，确认删除吗？')){ajaxopen(this.href, function(){$('#add-row-basic-<?php echo $row['id'];?>').remove();});}return false;" id="<?php echo $row['id'];?>" class="fr">删除</a><a style="margin-right:5px;" onclick="reply_edit(this.id)" id="<?php echo $row['id'];?>" href="javascript:;" class="fr">编辑</a>
				</span>
			</div>
		</div>
	<?php } } ?>
</div>

<div id="reply-add-dialog" class="form" style="display:none;">
	<table>
		<tr>
			<th>内容</th>
			<td>
				<textarea style="height:200px;" class="txt content" cols="70" id="reply-add-text"></textarea>
				<div class="notice">根据此处设置回复信息，可设置多个，随机显示。<a class="iconEmotion" href="javascript:;" inputId="reply-add-text">表情</a></div>
			</td>
		</tr>
		<tr>
			<th></th>
			<td><input name="reply-add" type="button" value="提交" onclick="reply_add_handler()" class="mt10 btn grid-2 alpha" /></td>
		</tr>
	</table>
</div>

<script type="text/javascript">
function reply_add_handler() {
	if (deleteid) {
		var curitem = $(document.getElementById('add-row-basic-'+deleteid));
		curitem.find('#reply-value').val(html_encode($('#reply-add-text').val()));
		curitem.find('#reply-name').html(html_encode($('#reply-add-text').val())); 
		deleteid = 0;
	} else {
		var id = Math.random();
		var html = '<div class="item clearfix" id="add-row-basic-'+id+'"><div class="content"><div class="data fl">'+
		'<input type="hidden" name="reply-new[]" id="reply-value" value="" />'+
		//'<input type="checkBox" id="label_'+id+'">&nbsp;'+
		'<label for="label_'+id+'"  id="reply-name">'+html_encode($('#reply-add-text').val())+'</label></div>'+
		'<a class="fr" href="javascript:;" id="'+id+'" onclick="if (confirm(\'删除操作不可恢复，确认删除吗？\')){$(this).parent().parent().remove();}">删除</a>'+
		'<a class="fr" href="javascript:;" id="'+id+'" onclick="reply_edit(this.id)" style="margin-right:5px;">编辑</a>'+  
		'</div>';
		$('#reply-list').append(html);
		var curitem = $(document.getElementById('add-row-basic-'+id));
		curitem.find('#reply-value').val(html_encode($('#reply-add-text').val()));
		curitem.find('#reply-name').html(html_encode($('#reply-add-text').val())); 
	}
	$('#reply-add-text').val('');
	$('#reply-add-dialog').dialog('close');
}

function reply_edit(id) {
	var curitem = $(document.getElementById('add-row-basic-'+id));
	var replyvalue = html_decode(curitem.find('#reply-value').val());
	$('#reply-add-text').val(replyvalue);
	deleteid = id;
	add_dialog('reply-add-dialog', '回复管理');
}

function reply_add() {
	$('#reply-add-text').val('');
	deleteid = 0;
	add_dialog('reply-add-dialog', '回复管理');
}
</script>
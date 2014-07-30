<?php defined('IN_IA') or exit('Access Denied');?><style type="text/css">
.news-item{ border-bottom: 1px solid #B8B8B8; padding: 10px 0;}
.news-cover, .news-thumb{height: 160px; width:300px; border: 1px solid #B8B8B8; overflow:hidden; }
	.news-thumb{ width:100px; height:100px;}
.news-cover .i-img{ width:300px;}
.news-thumb .i-img{ width:100px; height:100px;}
.news-default-tips{text-shadow:0 1px 1px white;background:#F5F6F7;display:block;text-align:center;color:#666;letter-spacing:5px;font-weight:bold;font-size:22px;line-height: 160px;}
	.news-thumb .news-default-tips{font-size: 16px;line-height: 100px; width: 100px;}
.news-content-wrap { margin:0 0 0 320px;} 
.news-title-wrap { margin:0 0 0 110px;}
</style>
<div id="append-list" class="list">
<?php if(!empty($reply)) { ?>
	<?php if(is_array($reply)) { foreach($reply as $news) { ?>
	<?php include template('modules/news/main_form_display', TEMPLATE_INCLUDEPATH);?>
	<?php } } ?>
<?php } ?>
</div>
<div class="item clearfix">
	<input name="news-add" type="button" value="添加图文消息" onclick="add_row('append-list')" class="btn alpha"  style="width:100%" />
</div>
<script type="text/javascript">
<?php if(empty($reply)) { ?>
add_row('append-list');
<?php } ?>
function add_row() {
	$.getJSON('<?php echo create_url('index/module/formdisplay', array('name' => 'news', 'tpl' => 'main'))?>', function(data){
		if (data.error === 0 && data.content.html != '') {
			update_list();
			$('#append-list').append(data.content.html);
			row = $('#'+data.content.id);
			kindeditor(row.find('textarea:[class="richtext-clone"]'));
			kindeditor_upload_image(row.find('#news-picture')[0]);	
		}
	});  
}

function add_row_content(obj, key) {
	
	$.getJSON('<?php echo create_url('index/module/formdisplay', array('name' => 'news', 'tpl' => 'content'))?>&key='+key, function(data){
		if (data.error === 0 && data.content.html != '') {
			update_list();
			$(data.content.html).insertBefore($(obj).parent());
			row = $('#'+data.content.id);
			kindeditor(row.find('textarea:[class="richtext-clone"]'));
			kindeditor_upload_image(row.find('#news-picture')[0]);	
		}
	});  	
}

function edit_row(parentid, id) {
	update_list();
	var parent = $('#'+parentid).find('#'+id);
	if (parent.length) {
		parent.find('#news-preview').hide().siblings().show();	
		parent.find('#news-preview-picture').hide().siblings().show();
	}	
}

function update_list() {
	$('#append-list').find('.news-item').each(function(){
		var preview = $(this).find('#news-preview');
		var form = $(this).find('#news-form');
		preview.show();
		form.hide();
		preview.find('#news-preview-title').length && preview.find('#news-preview-title').html(form.find("#news-title").val());
		(preview.find('#news-preview-picture').length && form.find("#news-picture-value").val()) && preview.find('#news-preview-picture').attr('src', '<?php echo $_W['attachurl'];?>' + form.find("#news-picture-value").val()).show().siblings().hide();
	});
}
</script>

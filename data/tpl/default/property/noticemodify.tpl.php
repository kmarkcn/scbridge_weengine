<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
	<script type="text/javascript" src="./resource/script/jquery.zclip.min.js"></script>
	<div id="main-column" class="container-12 clearfix member-center">
		<div class="column2 grid-3 alpha omega">
			<div class="area hot-tag">
				<h5>温馨告知</h5>
				<ul>
					<li><a href="<?php echo create_url('property')?>">返回</a></li>
					<li><a href="<?php echo create_url('index/module', array('name' => 'property', 'do' => 'noticeList', 'category_id' => $category_id))?>">查看所有告知</a></li>
					<li class="current"><a href="#">新增温馨告知</a></li>
				</ul>
			</div>
		</div>
		<div class="column1 grid-10 alpha omega">
		<div class="form">
				<div class="form_h">
				<h6><?php echo $title;?></h6>
				</div>
				<form action="" method="post" onsubmit="return formcheck(this)">
				<input type="hidden" name="$category_id" value="<?php echo $category_id;?>" />
				<input type="hidden" name="$notice_id" value="<?php echo $notice_id;?>" />
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<th>文章标题</th>
					<td>
						<input type="text" name="title" class="txt grid-4 alpha pin" value="<?php echo $entry['title'];?>" required="required"/>
						<div class="notice">请输入该温馨告知的标题</div>
					</td>
				</tr>
				<tr>
					<th>文章内容</th>
					<td>
						<textarea name="content" class="richtext-clone" id="richtext_content" class="txt grid-5 alpha pin" style="height:350px; width:470px;"><?php echo $entry['content'];?></textarea>
						<div class="notice">请输入该温馨告知的正文内容</div>
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
		<script type="text/javascript">
			kindeditor($('#richtext_content')[0]);
		</script>
	</div>
<?php include template('common/footer', TEMPLATE_INCLUDEPATH);?>
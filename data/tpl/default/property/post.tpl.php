<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
	<div id="main-column" class="container-12 clearfix member-center">
		<div class="column2 grid-3 alpha omega">
			<?php include template('property/nav', TEMPLATE_INCLUDEPATH);?>
		</div>
		<div class="column1 grid-10 alpha omega">
			<div class="form">
				<div class="form_h">
				<?php if(empty($id)) { ?>
				<h6>添加栏目</h6>
				<?php } else { ?>
				<h6>编辑栏目</h6>
				<?php } ?>
				</div>
				<form action="" method="post" onsubmit="return formcheck(this)">
				<input type="hidden" name="id" value="<?php echo $category_id;?>" />
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<th>栏目标题</th>
					<td>
						<input type="text" name="title" class="txt grid-4 alpha pin" value="<?php echo $entry['title'];?>" required="required"/>
						<div class="notice">请输入该栏目的标题</div>
					</td>
				</tr>
				<tr>
					<th>栏目内容</th>
					<td>
						<textarea name="content" class="richtext-clone" id="richtext_content" class="txt grid-5 alpha pin" style="height:350px; width:470px;"><?php echo $entry['content'];?></textarea>
						<div class="notice">请输入该栏目的正文内容</div>
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
		kindeditor($('#richtext_content')[0]);
	</script>
<?php include template('common/footer', TEMPLATE_INCLUDEPATH);?>

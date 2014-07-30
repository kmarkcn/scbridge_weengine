<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
	<div id="main-column" class="container-12 clearfix member-center">
		<div class="column2 grid-3 alpha omega">
			<?php include template('setting/nav', TEMPLATE_INCLUDEPATH);?>
		</div>
		<div class="column1 grid-10 alpha omega modules">
			<div class="form settype">
				<form action="" method="post" onsubmit="return formcheck(this)">
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr class="header">
					<td></td>
					<td>显示顺序</td>
					<td>分类名称</td>
					<td>设为栏目</td>
					<td style="width:70px;">操作</td>
				</tr>
				<?php if(is_array($category)) { foreach($category as $row) { ?>
					<tr class="hover">
						<td id="type_hover"><?php if(count($children[$row['id']]) > 0) { ?><a href="javascript:;">[+]</a><?php } ?></td>
						<td class="td60"><input class="order" type="text" name="displayorder[<?php echo $row['id'];?>]" value="<?php echo $row['displayorder'];?>" /></td>
						<td>
							<div class="td106 <?php if(!empty($row['parentid'])) { ?>type_child<?php } ?>">
								<?php echo $row['name'];?>
								<?php if(empty($row['parentid'])) { ?>
								<span class="addchildtype"><a href="<?php echo create_url('setting/category/post', array('parentid' => $row['id']))?>">添加子分类</a></span>
								<?php } ?>
							</div>
						</td>
						<td class="type_show"><?php echo $row['enabled'] ? '是' : '否'?></td>
						<td><a href="<?php echo create_url('setting/category/post', array('id' => $row['id']))?>">编辑</a>&nbsp;&nbsp;<a href="<?php echo create_url('setting/category/delete', array('id' => $row['id']))?>" onclick="return confirm('删除时此分类的子分类也将删除，确认删除此分类吗？');return false;">删除</a></td>
					</tr>
					<?php if(is_array($children[$row['id']])) { foreach($children[$row['id']] as $row) { ?>
					<tr class="hover">
						<td id="type_hover"></td>
						<td class="td60"><input class="order" type="text" name="displayorder[<?php echo $row['id'];?>]" value="<?php echo $row['displayorder'];?>" /></td>
						<td>
							<div class="td106 <?php if(!empty($row['parentid'])) { ?>type_child<?php } ?>">
								<?php echo $row['name'];?>
								<?php if(empty($row['parentid'])) { ?>
								<span class="addchildtype"><a href="<?php echo create_url('setting/category/post', array('parentid' => $row['id']))?>">添加子分类</a></span>
								<?php } ?>
							</div>
						</td>
						<td class="type_show"><?php echo $row['enabled'] ? '是' : '否'?></td>
						<td><a href="<?php echo create_url('setting/category/post', array('id' => $row['id']))?>">编辑</a>&nbsp;&nbsp;<a href="<?php echo create_url('setting/category/delete', array('id' => $row['id']))?>" onclick="return confirm('确认删除此分类吗？');return false;">删除</a></td>
					</tr>
					<?php } } ?>
				<?php } } ?>
				</table>
				<table>
				<tr>
					<td><div><span class="addnewtype"><a href="<?php echo create_url('setting/category/post')?>">添加新分类</a></span></div></td>
				</tr>
				<tr>
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
<?php include template('common/footer', TEMPLATE_INCLUDEPATH);?>
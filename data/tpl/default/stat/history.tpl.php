<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
	<div id="main-column" class="container-12 clearfix member-center">
		<div class="column2 grid-3 alpha omega">
			<?php include template('stat/nav', TEMPLATE_INCLUDEPATH);?>
		</div>
		<div class="column1 grid-10 alpha omega">
			<div class="floattop">
				<ul>
					<li><a <?php if($_GPC['searchtype'] == 'rule' || empty($_GPC['searchtype'])) { ?>class="current"<?php } ?> href="<?php echo create_url('stat/history/display', array('searchtype' => 'rule'))?>">已有规则回复</a></li>
					<li><a <?php if($_GPC['searchtype'] == 'default') { ?>class="current"<?php } ?> href="<?php echo create_url('stat/history/display', array('searchtype' => 'default'))?>">默认规则回复</a></li>
				</ul>
			</div>
			<div class="form manage_list">
				<div class="manage_search">
					<form action="" method="get">
					<input type="hidden" name="act" value="history" />
					<input type="hidden" name="searchtype" value="<?php echo $_GPC['searchtype'];?>" />
					<div class="title">搜索</div>
					<div class="main">
						<div class="con">
							<label for="kw">关键字</label>
							<input type="text" id="kw" class="txt grid-4 alpha pin" name="keyword" value="<?php echo $_GPC['keyword'];?>" style="width: 305px;" />
						</div>
						<div class="con">
							<label for="date1">时间范围</label>
							<input type="text" class="txt grid-2 alpha pin datepicker" id="date1" name="starttime" value="<?php echo date('Y-m-d', $starttime)?>" />
							<input type="text" class="txt grid-2 alpha pin datepicker" id="date2" name="endtime" value="<?php echo date('Y-m-d', $endtime)?>" />
						</div>
						<div class="con">
							<input type="submit" name="" value="搜索" class="grid-2 btn alpha fr" />
						</div>
					</div>
					</form>
				</div>

				<form action="" method="post" onsubmit="">
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr class="listHead">
						<td style="width:40px; padding-left:5px;">选择</td>
						<td style="width:80px;">用户</td>
						<td>内容</td>
						<td style="width:110px;">规则</td>
						<td style="width:80px;">模块</td>
						<td style="width:100px;">时间</td>
						<td style="width:110px;">操作</td>
					</tr>
					<?php if(is_array($list)) { foreach($list as $row) { ?>
					<tr class="list" id="list">
						<td><input type="checkbox" name="select[]" value="<?php echo $row['id'];?>" /></td>
						<td><a href="#" title="<?php echo $row['from_user'];?>"><?php echo cutstr($row['from_user'], 8)?></a></td>
						<td align="left"><?php echo $row['message'];?></td>
						<td><?php if(empty($row['rid'])) { ?>N/A<?php } else { ?><a target="_blank" href="<?php echo create_url('rule/post', array('id' => $row['rid']))?>"><?php echo cutstr($rules[$row['rid']]['name'], 6)?></a><?php } ?></td>
						<td><?php echo $row['module'];?></td>
						<td style="font-size:12px; color:#666;">
							<?php echo date('Y-m-d <br /> h:i:s', $row['createtime']);?>
						</td>
						<td>
					   		<a href="#">删除</a>
						</td>
					</tr>
					<?php } } ?>
					<tr>
						<td><?php echo $rules[$row['rid']]['module'];?></td>
						<td>

							<input type="submit" name="delete" value="提交" class="btn alpha" />
							<input type="hidden" name="token" value="<?php echo $_W['token'];?>" />
						</td>
					</tr>
				</table>
				</form>
			</div>
			<?php echo $pager;?>
		</div>
	</div>
<?php include template('common/footer', TEMPLATE_INCLUDEPATH);?>
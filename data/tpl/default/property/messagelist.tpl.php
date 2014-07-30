<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
	<div id="main-column" class="container-12 clearfix member-center">
		<div class="column2 grid-3 alpha omega">
			<div class="area hot-tag">
				<h5>业主留言</h5>
				<ul>
					<li><a href="<?php echo create_url('property')?>">返回</a></li>
					<li class="current"><a href="<?php echo create_url('index/module', array('do' => 'checkmessage', 'name' => 'property', 'category_id' => $category_id))?>">查看留言信息</a></li>
				</ul>
			</div>
		</div>
		<div class="column1 grid-10 alpha omega">
			<div class="form manage_list">
				<div class="manage_search">
					<form action="" method="get">
					<input type="hidden" name="act" value="module" />
					<input type="hidden" name="do" value="checkmessage" />
					<input type="hidden" name="name" value="property" />
					<input type="hidden" name="category_id" value="<?php echo $category_id;?>" />
					<div class="title">搜索</div>
					<div class="main">
						<div class="con">
							<label for="kw">姓名</label>
							<input type="text" id="kw" class="txt grid-2 alpha pin" name="keyword" value="<?php echo $_GPC['keyword'];?>" />
						</div>
						<div class="con">
							<label for="date1">时间范围</label>
							<input type="text" class="txt grid-2 alpha pin datepicker" id="date1" name="starttime" <?php if($starttime != 0) { ?> value="<?php echo date('Y-m-d', $starttime)?>" <?php } ?> />
							<input type="text" class="txt grid-2 alpha pin datepicker" id="date2" name="endtime" <?php if($endtime != 0) { ?> value="<?php echo date('Y-m-d', $endtime)?>" <?php } ?> />
						</div>
						<div class="con">
							<input type="submit" name="" value="搜索" class="grid-2 btn alpha fr"/>
						</div>
					</div>
					</form>
				</div>

				<form method="post" action="<?php echo create_url('index/module', array('do' => 'checkmessage', 'name' => 'property', 'category_id' => $category_id))?>">
					<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr class="listHead">
						<td style="width:20px; padding-left:5px;">选择</td>
						
						<td style="width:40px;">姓名</td>
						<td style="width:80px;">联系方式</td>
						<td style="width:80px;">留言内容</td>
						<td style="width:80px;">留言时间</td>
						
						<!-- <td style="width:130px;">操作</td>  -->
					</tr>
					<?php if(is_array($list)) { foreach($list as $row) { ?>
					<tr class="list" id="list">
						<td><input type="checkbox" name="select[]" value="<?php echo $row['id'];?>" /></td>
						
						<td><?php echo $row['name'];?></td>
						<td><?php echo $row['contact'];?></td>
						<td><?php echo $row['content'];?></td>
						<td><?php echo date('Y年m月d日', $row['message_time'])?></td>
						
						<!-- <td><a href="<?php echo create_url('financingDemand/info', array('demand_id' => $row['id']))?>">查看详细信息</a></td>  -->
					</tr>
					<?php } } ?>
					<tr>
						<td><input type="checkbox" onclick="selectall(this, 'select');" /></td>
						<td>

							<input type="submit" name="delete" value="删除" class="btn alpha" />
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
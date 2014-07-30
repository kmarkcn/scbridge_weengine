<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
	<div id="main-column" class="container-12 clearfix member-center">
		<div class="column2 grid-3 alpha omega">
			<div class="area hot-tag">
				<h5>大转盘获奖名单</h5>
				<ul>
					<li><a href="<?php echo create_url('rule/post', array('id' => $id))?>">返回规则</a></li>
					<li class="current"><a href="<?php echo create_url('index/module', array('do' => 'awardlist', 'name' => 'lotery', 'id' => $id))?>">中奖名单</a></li>
				</ul>
			</div>
		</div>
		<div class="column1 grid-10 alpha omega">
			<div class="form manage_list">
				<div class="manage_search">
                	<form action="" method="get">
                    <input type="hidden" name="act" value="module" />
					<input type="hidden" name="do" value="awardlist" />
					<input type="hidden" name="name" value="lotery" />
					<input type="hidden" name="id" value="<?php echo $id;?>" />
					<div class="title">搜索</div>
					<div class="main">
						<div class="con">
							<label for="kw">登记情况</label>
							<select name="isregister">
								<option value="">全部</option>
								<option value="1" <?php if($_GPC['isregister'] == 1) { ?> selected<?php } ?>>已登记</option>
								<option value="2" <?php if($_GPC['isregister'] == 2) { ?> selected<?php } ?>>未登记</option>
							</select>
						</div>
						<div class="con">
							<label for="kw">中奖情况</label>
							<select name="isaward">
								<option value="">全部</option>
								<option value="1" <?php if($_GPC['isaward'] == 1) { ?> selected<?php } ?>>已中奖</option>
								<option value="2" <?php if($_GPC['isaward'] == 2) { ?> selected<?php } ?>>未中奖</option>
								
							</select>
						</div>
						
						<div class="con">
							<label for="kw">个人信息</label>
							<select name="profile">
								<option value="" selected="selected">请选择搜索用户资料</option>
								<option <?php if($_GPC['profile'] == 'realname') { ?>selected<?php } ?> value="realname">姓名</option>
								<option <?php if($_GPC['profile'] == 'mobile') { ?>selected<?php } ?> value="mobile">手机</option>
								<option <?php if($_GPC['profile'] == 'qq') { ?>selected<?php } ?> value="qq">QQ</option>
							</select>
							<input type="text" name="profilevalue" value="<?php echo $_GPC['profilevalue'];?>"  class="txt grid-2 alpha pin" />
						</div>
						<div class="con">
							<label for="kw">中奖时间</label>
							<input type="text" class="txt grid-2 alpha pin datepicker" id="date1" name="starttime" value="<?php if($starttime) { ?><?php echo date('Y-m-d', $starttime)?><?php } ?>" />
							<input type="text" class="txt grid-2 alpha pin datepicker" id="date2" name="endtime" value="<?php if($endtime) { ?><?php echo date('Y-m-d', $endtime)?><?php } ?>" />
						</div>
						<div class="con">
							<label for="kw">奖品信息</label>
							<select name="award">
								<option value="" selected="selected">请选择搜索奖品资料</option>
								<option <?php if($_GPC['award'] == 'title') { ?>selected<?php } ?> value="title">名称</option>
								<option <?php if($_GPC['award'] == 'description') { ?>selected<?php } ?> value="description">描述</option>
							</select>
							<input type="text" name="awardvalue" value="<?php echo $_GPC['awardvalue'];?>" class="txt grid-2 alpha pin" />
						</div>
						<div class="con">
							<input type="submit" name="" value="搜索" class="grid-2 btn alpha fr" />
						</div>
					</div>
                    </form>
				</div>
				<form method="post">
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr class="listHead">
					<td style="width:40px; padding-left:5px;">选择</td>
					<td style="width:100px;">姓名</td>
					<td style="width:100px;">手机</td>
					<td style="width:100px;">QQ</td>
					<td style="width:150px;">奖品</td>
					<td>描述</td>
					<td style="width:150px;">获取时间</td>
					<td></td>
				</tr>
				<?php if(is_array($list)) { foreach($list as $row) { ?>
				<tr class="list" id="list">
					<td><input type="checkbox" name="select[]" value="<?php echo $row['id'];?>" /></td>
					<td><?php echo $row['realname'];?></td>
					<td><?php echo $row['mobile'];?></td>
					<td><?php echo $row['qq'];?></td>
					<td><?php echo $row['award'];?></td>
					<td><?php echo $row['description'];?></td>
					<td style="font-size:12px; color:#666;">
						<?php echo date('Y-m-d h:i:s', $row['createtime']);?>
					</td>
					<td><?php if(empty($row['status'])) { ?><a href="<?php echo create_url('index/module', array('do' => 'awardlist', 'name' => 'lotery', 'id' => $id, 'wid' => $row['id'], 'status' => 2))?>">标记领奖</a><?php } else if($row['status'] == 1) { ?><?php } else { ?><a href="<?php echo create_url('index/module', array('do' => 'awardlist', 'name' => 'lotery', 'id' => $id, 'wid' => $row['id'], 'status' => 0))?>">取消领奖</a><?php } ?></td>
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
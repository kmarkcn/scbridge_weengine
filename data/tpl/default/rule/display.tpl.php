<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
	<div id="main-column" class="container-12 clearfix member-center">
		<div class="column2 grid-3 alpha omega">
			<?php include template('rule/nav', TEMPLATE_INCLUDEPATH);?>
		</div>
		<div class="column1 grid-10 alpha omega">
			<div class="manage_search form" style="margin: 10px 20px 5px 20px;">
				<form action="" method="get">
				<input type="hidden" name="act" value="display">
				<input type="hidden" name="module" value="<?php echo $_GPC['module'];?>">
				<div class="title">搜索</div>
				<div class="main">
					<div class="con">
						<label for="" class="fl">模块类型</label>
						<div class="modules_menu fl">
							<?php $i=0;?>
							<?php if(is_array($mymodule)) { foreach($mymodule as $row) { ?>
							<?php if($row['issystem']) { ?><a href="<?php echo create_url('rule/display', array('module' => $row['name'], 'keyword' => $_GPC['keyword']))?>" <?php if($row['name']==$module) echo 'class=current';?>><?php echo $row['title'];?></a><?php } ?>
							<?php $i++;?>
							<?php } } ?>
							<a title="更多操作" href="#" class="modules_menu_button" onclick="return false;">更多<span></span></a>
						</div>
						<div class="modules_menu_hide" style="display:none;">
							<ul>
								<?php $i=0;?>
								<?php if(is_array($mymodule)) { foreach($mymodule as $row) { ?>
								<?php if(!$row['issystem']) { ?><li><a href="<?php echo create_url('rule/display', array('module' => $row['name'], 'keyword' => $_GPC['keyword']))?>" <?php if($row['name']==$module) echo 'class=current';?>><?php echo $row['title'];?></a></li><?php } ?>
								<?php $i++;?>
								<?php } } ?>
							</ul>
						</div>
					</div>
					<div class="con">
						<label for="kw">关键字</label>
						<input type="text" id="kw" class="txt grid-4 alpha pin" name="keyword" value="<?php echo $_GPC['keyword'];?>" style="width: 305px;">
					</div>
					<div class="con">
						<input type="submit" name="" value="搜索" class="grid-2 btn alpha fr">
					</div>
				</div>
				</form>
			</div>
			<div class="list">
				<?php if(is_array($list)) { foreach($list as $row) { ?>
				<div class="rule_item clearfix">
					<div class="rule_content clearfix" style="position:relative;padding-right:28px;">
						<div class="data fl"><?php if($row['cid']) { ?><?php if($cates[$row['cid']]['parent']) { ?><a href="#" style="margin-right:10px;font-weight:normal;color:#F60;">[<?php echo $cates[$row['cid']]['parent'];?>]</a><?php } ?><a href="#" style="margin-right:10px;font-weight:normal;color:#F60;">[<?php echo $cates[$row['cid']]['name'];?>]</a><?php } ?><?php echo $row['name'];?></div>
						<div class="fr">
							<a target="_blank" href="<?php echo create_url('stat/trend/rule', array('id' => $row['id']))?>">使用率走势</a>&nbsp;&nbsp;
							<a href="<?php echo create_url('rule/post', array('id' => $row['id']))?>">编辑</a>
							<a title="更多操作" href="#" class="more_menu_button" onclick="return false;"><span></span></a>
						</div>
						<div class="more_menu_list" style="display:none;">
							<ul>
								<li><a onclick="return confirm('删除规则将同时删除关键字与回复，确认吗？');return false;" href="<?php echo create_url('rule/delete', array('id' => $row['id'], 'type' => 'rule'))?>">删除规则</a></li>
								<?php if($row['module'] == 'wxwall') { ?>
								<li><a href="<?php echo create_url('index/module', array('do' => 'detail', 'name' => 'wxwall', 'id' => $row['id']))?>" target="_blank">查看内容</a></li>
								<li><a href="<?php echo create_url('index/module', array('do' => 'manage', 'name' => 'wxwall', 'id' => $row['id']))?>" target="_blank">审核内容</a></li>
								<li><a href="<?php echo create_url('index/module', array('do' => 'awardlist', 'name' => 'wxwall', 'id' => $row['id']))?>" target="_blank">中奖名单</a></li>
								<?php } ?>
								<?php if($row['module'] == 'egg') { ?>
								<li><a href="<?php echo create_url('index/module', array('do' => 'awardlist', 'name' => 'egg', 'id' => $row['id']))?>" target="_blank">中奖名单</a></li>
								<?php } ?>
							</ul>
						</div>
					</div>
					<div class="rule_desc clearfix" style="height:auto;line-height:25px;position:relative;">
						<?php if(is_array($row['keywords'])) { foreach($row['keywords'] as $kw) { ?>
					   <span class="rule_kw"> <?php echo $kw['content'];?></span>
						<?php } } ?>
						<div class="system_button">
								<?php if($wechat['welcomerid'] == $row['id']) { ?><a href="<?php echo create_url('rule/system/cancel', array('type' => 'welcome'))?>" onclick="ajaxopen(this.href, message);return false;" style="color:#FF3300" switch="1">取消欢迎信息</a><?php } else { ?><a href="<?php echo create_url('rule/system/set', array('id' => $row['id'], 'type' => 'welcome'))?>" onclick="ajaxopen(this.href, message);return false;" switch="0">设为欢迎信息</a><?php } ?>
								<?php if($wechat['defaultrid'] == $row['id']) { ?><a href="<?php echo create_url('rule/system/cancel', array('type' => 'default'))?>" onclick="ajaxopen(this.href, message);return false;" style="color:#FF3300" switch="1">取消默认回复</a><?php } else { ?><a href="<?php echo create_url('rule/system/set', array('id' => $row['id'], 'type' => 'default'))?>" onclick="ajaxopen(this.href, message);return false;" switch="0">设为默认回复</a><?php } ?>
						</div>
					</div>
				</div>
				<?php } } ?>
			</div>
			<div>
				<?php echo $pager;?>
			</div>
		</div>
	</div>
	<script>
	$(function() {
		//系统菜单
		$(".list .system_button").each(function(i) {
			$(this).find("a").each(function(k) {
				if($(this).attr("switch")=='1') $(this).show();
			});
		});
		$(".list").delegate(".rule_item", "hover", function(){
			$(this).find(".system_button a").each(function() {
				if($(this).attr("switch")!='1') $(this).toggle();
			});
		});
		//规则菜单
		$(".more_menu_button").each(function(i){
			$(this).click(function(event) {
				var e=window.event || event;
				if(e.stopPropagation){
					e.stopPropagation();
				}else{
					e.cancelBubble = true;
				}
				$(".more_menu_list").each(function(k) {if(k!=i){$(this).hide()}});
				$(this).parent().parent().find(".more_menu_list").toggle();
			});
		});
		//模块菜单
		$(".modules_menu_hide a").each(function() {
			if($(this).hasClass("current")) $(".modules_menu .modules_menu_button").addClass("current");
		});
		$(".modules_menu .modules_menu_button").mouseover(function(e){
			var x, y;
			var e = e||window.event;
			if(e.stopPropagation){
				e.stopPropagation();
			}else{
				e.cancelBubble = true;
			}
			$(".modules_menu_hide").show();
		});
		document.onclick = function(){
			$(".more_menu_list").each(function() {$(this).hide()});
			$(".modules_menu_hide").hide();
		};
	});
	</script>
<?php include template('common/footer', TEMPLATE_INCLUDEPATH);?>
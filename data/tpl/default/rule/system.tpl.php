<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
	<div id="main-column" class="container-12 clearfix member-center">
		<div class="column2 grid-3 alpha omega">
			<?php include template('rule/nav', TEMPLATE_INCLUDEPATH);?>
		</div>
		<div class="column1 grid-10 alpha omega">
			<div class="form">
				<form action="" method="post">
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<th>欢迎信息：</th>
						<td>
							<?php if($wechat['welcomerid']) { ?>
							<div class="rule_item clearfix" style="margin:0 !important; margin:0;">
								<div class="rule_content clearfix">
									<div class="data fl"><?php echo $wechat['welcome']['rule']['name'];?> <span style="font-size:12px;">（<?php echo $_W['setting']['modules'][$wechat['welcome']['rule']['module']]['title'];?>）</span></div>
									<div class="fr">
									<a href="<?php echo create_url('rule/post', array('id' => $wechat['welcome']['rule']['id']))?>">编辑/查看</a>
									&nbsp;
									<a onclick="return confirm('取消设置的系统回复，确认吗？');return false;" href="<?php echo create_url('rule/system/cancel', array('type' => 'welcome'))?>">取消</a>
									</div>
								</div>
								<div class="rule_desc clearfix" style="height:auto;line-height:25px;display:block;">
									<?php if(is_array($wechat['welcome']['keyword'])) { foreach($wechat['welcome']['keyword'] as $kw) { ?>
								   <span class="rule_kw"> <?php echo $kw['content'];?></span>
									<?php } } ?>
								</div>
							</div>
							<?php } else { ?><textarea name="welcome" id="welcome" cols="55" class="txt content" style="height:200px;"><?php echo $wechat['welcome'];?></textarea><?php } ?>
							<div class="notice">设置用户添加公众帐号好友时，发送的欢迎信息。<a class="iconEmotion" href="javascript:;" inputId="welcome">表情</a></div>
						</td>
					</tr>
					<tr>
						<th>默认回复：</th>
						<td>
							<?php if($wechat['defaultrid']) { ?>
							<div class="rule_item clearfix" style="margin:0 !important; margin:0;">
								<div class="rule_content clearfix">
									<div class="data fl"><?php echo $wechat['default']['rule']['name'];?> <span style="font-size:12px;">（<?php echo $_W['setting']['modules'][$wechat['default']['rule']['module']]['title'];?>）</span></div>
									<div class="fr">
									<a href="<?php echo create_url('rule/post', array('id' => $wechat['default']['rule']['id']))?>">编辑/查看</a>
									&nbsp;
									<a onclick="return confirm('取消设置的系统回复，确认吗？');return false;" href="<?php echo create_url('rule/system/cancel', array('type' => 'default'))?>">取消</a>
									</div>
								</div>
								<div class="rule_desc clearfix" style="height:auto;line-height:25px;display:block;">
									<?php if(is_array($wechat['default']['keyword'])) { foreach($wechat['default']['keyword'] as $kw) { ?>
									<span class="rule_kw"> <?php echo $kw['content'];?></span>
									<?php } } ?>
								</div>
							</div>
						   	<?php } else { ?><textarea name="default" id="default" cols="55" class="txt content" style="height:200px;"><?php echo $wechat['default'];?></textarea><?php } ?>
							<div class="notice">当匹配不到回复时，默认发送的内容。<a class="iconEmotion" href="javascript:;" inputId="default">表情</a></div>
						</td>
					</tr>
					<tr>
						<th>默认回复时间间隔：</th>
						<td><input type="text" name="default-period" class="txt grid-4 alpha pin" value="<?php echo $wechat['default_period'];?>" /><span>秒</span><div class="notice">此条设置只针对“默认回复”。设置“默认回复”对同一用户的回复间隔。为空表示不限制。</div></td>
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
<?php include template('common/footer', TEMPLATE_INCLUDEPATH);?>

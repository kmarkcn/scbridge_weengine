<?php defined('IN_IA') or exit('Access Denied');?><div class="area hot-tag">
	<h5>公众号管理</h5>
	<ul>
		<li <?php echo $nav['history'];?>><a href="<?php echo create_url('stat/history')?>">聊天记录</a></li>
		<li <?php echo $nav['rule'];?>><a href="<?php echo create_url('stat/rule')?>">规则使用率</a></li>
		<li <?php echo $nav['keyword'];?>><a href="<?php echo create_url('stat/keyword')?>">关键字使用率</a></li>
	</ul>
</div>

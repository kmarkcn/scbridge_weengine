<?php defined('IN_IA') or exit('Access Denied');?><div class="area hot-tag">
	<h5>订单管理</h5>
	<ul>
		 <li<?php if(empty($id)) { ?><?php echo $nav['display'];?><?php } ?>><a href="<?php echo create_url('booking/display')?>">查看订单</a></li>
	</ul>
</div>

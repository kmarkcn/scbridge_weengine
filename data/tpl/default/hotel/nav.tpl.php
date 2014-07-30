<?php defined('IN_IA') or exit('Access Denied');?><div class="area hot-tag">
	<h5>酒店管理</h5>
	<ul>
		 <li<?php if(empty($id)) { ?><?php echo $nav['post'];?><?php } ?>><a href="<?php echo create_url('hotel/post')?>">添加酒店</a></li>
		 <li<?php if(empty($id)) { ?><?php echo $nav['display'];?><?php } ?>><a href="<?php echo create_url('hotel/display')?>">查看酒店</a></li>
	</ul>
</div>

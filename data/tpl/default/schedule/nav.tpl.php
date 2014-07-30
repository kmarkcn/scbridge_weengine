<?php defined('IN_IA') or exit('Access Denied');?><div class="area hot-tag">
	<h5>行程管理</h5>
	<ul>
		 <li<?php if(empty($id)) { ?><?php echo $nav['post'];?><?php } ?>><a href="<?php echo create_url('schedule/post')?>">添加行程</a></li>
		 <li<?php if(empty($id)) { ?><?php echo $nav['display'];?><?php } ?>><a href="<?php echo create_url('schedule/display')?>">查看行程</a></li>
	</ul>
</div>

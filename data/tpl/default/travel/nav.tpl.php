<?php defined('IN_IA') or exit('Access Denied');?><div class="area hot-tag">
	<h5>旅游管理</h5>
	<ul>
		 <li<?php if(empty($id)) { ?><?php echo $nav['post'];?><?php } ?>><a href="<?php echo create_url('travel/post')?>">添加产品</a></li>
		 <li<?php if(empty($id)) { ?><?php echo $nav['display'];?><?php } ?>><a href="<?php echo create_url('travel/display')?>">查看产品</a></li>
	</ul>
</div>

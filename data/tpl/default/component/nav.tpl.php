<?php defined('IN_IA') or exit('Access Denied');?><div class="area hot-tag">
	<h5>模块管理</h5>
	<ul>
		 <li<?php if(empty($id)) { ?><?php echo $nav['post'];?><?php } ?>><a href="<?php echo create_url('component/post')?>">添加模块</a></li>
		 <li<?php if(empty($id)) { ?><?php echo $nav['display'];?><?php } ?>><a href="<?php echo create_url('component/display')?>">查看模块</a></li>
	</ul>
</div>

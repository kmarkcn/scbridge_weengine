<?php defined('IN_IA') or exit('Access Denied');?><div class="area hot-tag">
	<h5>商品管理</h5>
	<ul>
		 <li<?php if(empty($id)) { ?><?php echo $nav['post'];?><?php } ?>><a href="<?php echo create_url('goods/post')?>">添加商品</a></li>
		 <li<?php if(empty($id)) { ?><?php echo $nav['display'];?><?php } ?>><a href="<?php echo create_url('goods/display')?>">查看商品</a></li>
	</ul>
</div>

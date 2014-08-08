<?php defined('IN_IA') or exit('Access Denied');?><div class="area hot-tag">
	<h5>商户总览</h5>
	<ul>
		 <li<?php if(empty($id)) { ?><?php echo $nav['post'];?><?php } ?>><a href="<?php echo create_url('lbs/post')?>">添加商户</a></li>
		<li<?php if(empty($type)) { ?><?php echo $nav['display'];?><?php } ?>><a href="<?php echo create_url('lbs/display')?>">所有商户</a></li>
	</ul>
	<h5>商户分类</h5>
	<ul>
		 <li<?php if($type == '1') { ?> class="current" <?php } ?>><a href="<?php echo create_url('lbs/display', array('type' => 1))?>">美食</a></li>
		 <li<?php if($type == '2') { ?> class="current" <?php } ?>><a href="<?php echo create_url('lbs/display', array('type' => 2))?>">娱乐</a></li>
		 <li<?php if($type == '3') { ?> class="current" <?php } ?>><a href="<?php echo create_url('lbs/display', array('type' => 3))?>">购物</a></li>
		 <li<?php if($type == '4') { ?> class="current" <?php } ?>><a href="<?php echo create_url('lbs/display', array('type' => 4))?>">休闲</a></li>
	</ul>
</div>

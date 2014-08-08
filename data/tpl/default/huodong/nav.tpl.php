<?php defined('IN_IA') or exit('Access Denied');?><div class="area hot-tag">
	<h5>会员活动</h5>
	<ul>
		 <li<?php if(empty($id)) { ?><?php echo $nav['post'];?><?php } ?>><a href="<?php echo create_url('huodong/post')?>">添加活动</a></li>
		<li<?php if(empty($id)) { ?><?php echo $nav['display'];?><?php } ?>><a href="<?php echo create_url('huodong/display')?>">当前活动</a></li>
	</ul>
</div>

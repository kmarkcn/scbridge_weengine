<?php defined('IN_IA') or exit('Access Denied');?><div class="area hot-tag">
	<?php if(is_array($category)) { foreach($category as $row) { ?>
	<?php if(count($children[$row['id']]) > 0) { ?>
	<h5><?php echo $row['module_name'];?></h5>
		<?php if(is_array($children[$row['id']])) { foreach($children[$row['id']] as $row) { ?>
		<?php if($row['module_name'] == '业主留言') { ?>
		<li<?php echo $nav['property'];?> <?php if($category_id == $row['id']) { ?> class="current" <?php } ?> >
			<a href="<?php echo create_url('index/module', array('name' => 'property', 'do' => 'checkmessage', 'category_id' => $row['id']))?>" onclick="">
				<?php echo $row['module_name'];?>
			</a>
		</li>
		<?php } else if($row['module_name'] == '温馨告知') { ?>
		<li<?php echo $nav['property'];?> <?php if($category_id == $row['id']) { ?> class="current" <?php } ?> >
			<a href="<?php echo create_url('index/module', array('name' => 'property', 'do' => 'noticeList', 'category_id' => $row['id']))?>" onclick="">
				<?php echo $row['module_name'];?>
			</a>
		</li>
		<?php } else { ?>
		<li<?php echo $nav['property'];?> <?php if($category_id == $row['id']) { ?> class="current" <?php } ?> >
			<a href="<?php echo create_url('property/post', array('category_id' => $row['id']))?>">
				<?php echo $row['module_name'];?>
			</a>
		</li>
		<?php } ?>
		<?php } } ?>
	<?php } ?>
	<?php } } ?>
</div>

<?php defined('IN_IA') or exit('Access Denied');?><?php if(empty($item)) { ?>
<?php $namesuffix = '-new[(wrapitemid)]';?>
<?php $itemid = '(itemid)';?>
<?php } else { ?>
<?php $namesuffix = '['.$item['id'].']';?>
<?php $itemid = 'egg-item-' . $item['id'];?>
<?php } ?>
<div class="item eggs_prize eggs_prize_1">
	<table class="hd">
		<!-- 
		<tr>
			<th>是否实物：</th>
			<td id="award-inkind">
				<span class="fr"><?php if(empty($item)) { ?><a href="javascript:;" onclick="doDeleteItem('<?php echo $itemid;?>')">删除</a><?php } else { ?><a href="<?php echo create_url('index/module/delete', array('name' => 'lotery', 'id' => $item['id']))?>" onclick="doDeleteItem('<?php echo $itemid;?>', this.href)">删除</a><?php } ?></span>
				<label for="radio_1_<?php echo $itemid;?>" class="radio inline"><input type="radio" name="award-inkind<?php echo $namesuffix;?>" id="radio_1_<?php echo $itemid;?>" value="1" <?php if($item['inkind'] == 1) { ?> checked="checked"<?php } ?><?php if(!empty($item)) { ?> disabled=true<?php } ?> /> 是</label><label for="radio_0_<?php echo $itemid;?>" class="radio inline"><input type="radio" name="award-inkind<?php echo $namesuffix;?>" id="radio_0_<?php echo $itemid;?>" value="0" <?php if($item['inkind'] == 0) { ?> checked="checked"<?php } ?><?php if(!empty($item)) { ?> disabled=true<?php } ?> /> 否</label>
			</td>
		</tr>
		 -->
		<div class="hd">
			<span class="fr"><?php if(empty($item)) { ?><a href="javascript:;" onclick="if(confirm('删除操作不可恢复，确认删除吗？')){doDeleteItem('<?php echo $itemid;?>')};return false;">删除</a><?php } else { ?><a href="<?php echo create_url('index/module/delete', array('name' => 'lotery', 'id' => $item['id']))?>" onclick="if (confirm('删除操作不可恢复，确认删除吗？')){doDeleteItem('<?php echo $itemid;?>')}return false;">删除</a><?php } ?></span>
			<span class="fl">奖品<?php echo $prize;?></span>
		</div>
		<div class="con" id="award-inkind">
			<label class="fl">是否实物：</label>
			<input type="radio" name="award-inkind<?php echo $namesuffix;?>[<?php echo $key;?>]" id="radio_1_<?php echo $namesuffix;?><?php echo $key;?>" value="1" <?php if($item['inkind'] == 1) { ?> checked="checked"<?php } ?><?php if(!empty($item)) { ?> disabled=true<?php } ?> /> <label for="radio_1_<?php echo $namesuffix;?><?php echo $key;?>">是</label>
			<input type="radio" name="award-inkind<?php echo $namesuffix;?>[<?php echo $key;?>]" id="radio_0_<?php echo $namesuffix;?><?php echo $key;?>" value="0" <?php if($item['inkind'] == 0) { ?> checked="checked"<?php } ?><?php if(!empty($item)) { ?> disabled=true<?php } ?> /> <label for="radio_0_<?php echo $namesuffix;?><?php echo $key;?>">否</label>
		</div>
		
		<!-- 
		<tr>
			<th>奖品名称：</th>
			<td>
				<input type="text" value="<?php echo $item['title'];?>" style="width:275px;" name="award-title<?php echo $namesuffix;?>">
				<label style="display:inline-block;">中奖率：<input type="text" value="<?php echo $item['probalilty'];?>" name="award-probalilty<?php echo $namesuffix;?>" style="padding-right:30px;width:48px;"><em class="percentage">%</em></label>
				<label <?php if($item['inkind'] == 0) { ?>style="display:none;"<?php } else { ?>style="display:inline-block;"<?php } ?> class="num">数量：<input type="text" value="<?php echo $item['total'];?>" style="width:45px;" name="award-total<?php echo $namesuffix;?>"></label>
			</td>
		</tr>
		<tr>
			<th>奖品描述：</th>
			<td>
				<textarea style="height:80px;" name="award-description<?php echo $namesuffix;?>" class="fl" cols="70" id=""><?php echo $item['description'];?></textarea>
			</td>
		</tr>
                <tr>
			<th>奖励级别：</th>
			<td>
                <input class="fl" name="award-level<?php echo $namesuffix;?>" value="<?php echo $item['level'];?>" placeholder="请输入1－5的阿拉伯数字" />
			</td>
		</tr>
		<?php if($item['inkind'] == 0) { ?>
		<tr>
			<th>兑 换 码：</th>
			<td>
				<textarea style="height:80px;" class="fl" cols="70" id="" name="award-activation-code<?php echo $namesuffix;?>"><?php echo $item['activation_code'];?></textarea>
			</td>
		</tr>
		<tr>
			<th>激活地址：</th>
			<td>
				<input type="text" id="" class="fl" value="<?php echo $item['activation_url'];?>" name="award-activation-url<?php echo $namesuffix;?>">
			</td>
		</tr>
		<?php } ?>
		 -->
		<div class="con">
			<label class="fl">奖品名称：</label><input type="text" value="<?php echo $item['title'];?>" class="txt grid-2 alpha pin" name="award-title<?php echo $namesuffix;?>">
			<label>中奖率：</lable><input type="text" value="<?php echo $item['probalilty'];?>" name="award-probalilty<?php echo $namesuffix;?>" class="txt grid-1 alpha pin"><em class="percentage">%</em></label>
			<label <?php if($item['inkind'] == 0) { ?>style="display:none;"<?php } else { ?>style="display:inline-block;"<?php } ?> class="num">数量：<input type="text" value="<?php echo $item['total'];?>" style="width:45px;" class="txt alpha pin" name="award-total<?php echo $namesuffix;?>"></label>
		</div>
		<div class="con">
			<label class="fl">奖品描述：</label><textarea style="height:68px;width:420px;" name="award-description<?php echo $namesuffix;?>" class="fl txt content alpha pin" cols="60"><?php echo $item['description'];?></textarea>
		</div>
		<div class="con">
			<label class="fl">奖励级别：</label><input type="text" value="<?php echo $item['level'];?>" class="txt grid-2 alpha pin" name="award-level<?php echo $namesuffix;?>" placeholder="请输入1－5的阿拉伯数字">
		</div>
	</table>
</div>
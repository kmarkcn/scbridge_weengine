<?php defined('IN_IA') or exit('Access Denied');?><link type="text/css" rel="stylesheet" href="./source/modules/egg/template/common.css" />
<div class="item on new_add">
	<div id="item-main">
		<div class="form" id="item-form">
			<input type="hidden" name="reply_id" value="<?php echo $reply['id'];?>" />
				<table cellspacing="0" cellpadding="0" border="0" width="100%">
					<tbody>
						<tr>
							<th>查看内容</th>
							<td><a href="<?php echo create_url('index/module', array('do' => 'awardlist', 'name' => 'lotery', 'id' => $reply['rid']))?>">查看中奖名单</a></td>
						</tr>
						<tr>
							<th>活动图片</th>
							<td>
							<div class="upload-area grid-5 pin"><span class="fr">大图片建议尺寸：700像素 * 300像素</span>
								<input type="button"  id="egg-picture" fieldname="picture" class="upload-file-btn" value="上传" style="display:none;" />
								<?php if(!empty($reply)) { ?>
								<input type="hidden" name="picture-old" value="<?php echo $reply['picture'];?>">
								<div id="upload-file-view">
									<img width="100" src="<?php echo $_W['attachurl'];?><?php echo $reply['picture'];?>">&nbsp;&nbsp;
								</div>
								<?php } else { ?>
								<div id="upload-file-view"></div>
								<?php } ?>
							</div>
						</td>
						</tr>
						<tr>
							<th>活动简介</th>
							<td>
								<textarea style="height:150px;" name="description" class="txt content grid-5 alpha pin" cols="60"><?php echo $reply['description'];?></textarea>
								<div class="notice">用于图文显示的简介</div>
							</td>
						</tr>
						<tr>
							<th>活动规则</th>
							<td>
								<textarea id="rule" style="height:150px;" name="rule" class="txt content grid-5 alpha pin" cols="60"><?php echo $reply['rule'];?></textarea>
								<div class="notice">活动的相关说明和活动奖品介绍。</div>
							</td>
						</tr>
						<tr>
							<th>未中奖提示</th>
							<td>
								<textarea style="height:150px;" name="default_tips" class="txt content grid-5 alpha pin" cols="60"><?php echo $reply['default_tips'];?></textarea>
								<div class="notice">当用户未中奖时，返回给用户的提示信息。</div>
							</td>
						</tr>
						<tr>
							<th>每日抽奖次数</th>
							<td>
								<input type="text" value="<?php echo $reply['maxlottery'];?>" class="txt grid-5 alpha pin" name="maxlottery">
								<div class="notice">粉丝每日最多可以砸几次</div>
							</td>
						</tr>
						<tr>
							<th>中奖奖励积分</th>
							<td>
								<input type="text" value="<?php echo $reply['hitcredit'];?>" class="txt grid-5 alpha pin" name="hitcredit">
								<div class="notice">当用户中奖时，给予用户的积分。为0时表示不给。</div>
							</td>
						</tr>
						<tr>
							<th>未中奖奖励积分</th>
							<td>
								<input type="text" value="<?php echo $reply['misscredit'];?>" class="txt grid-5 alpha pin" name="misscredit">
								<div class="notice">当用户未中任何奖时，给予用户的积分。为0时表示不给。</div>
							</td>
						</tr>
						<tr>
						<th></th>
						<td>
							<input name="" type="button" onclick="add_row('append-list')" value="添加奖品" class="btn grid-2 alpha" />
						</td>
					</tr>
					</tbody>
				</table>
				<div id="append-list" class="list">
				<?php if(!empty($award)) { ?>
					<?php $prize = 1;?>
					<?php if(is_array($award)) { foreach($award as $item) { ?>
					<?php include $this->template('lotery:item');?>
					<?php $prize++;?>
					<?php } } ?>
				<?php } ?>
				</div>
		</div>
	</div>
</div>
			<script type="text/javascript">
			kindeditor($('#rule'));
			kindeditor_upload_image($('#egg-picture')[0]);

			/*
			var eggHandler = {
				'buildAddForm' : function(id, targetwrap) {
					var obj = buildAddForm(id, targetwrap);
					obj.html(obj.html().replace(/\(wrapitemid\)/gm, obj.attr('id')));
				}
			};

			
			function add_row() {
				$.getJSON('<?php echo create_url('index/module/formdisplay', array('name' => 'lotery'))?>', function(data){
					if (data.error === 0 && data.content.html != '') {
						$('#append-list').append(data.content.html);
						row = $('#'+data.content.id);
					}
				});
			}*/

			function add_row() {
				$.getJSON('<?php echo create_url('index/module/formdisplay', array('name' => 'lotery'))?>', function(data){
					if (data.error === 0 && data.content.html != '') {
						$('#append-list').append(data.content.html);
						row = $('#'+data.content.id);
					}
				});
			}
			
			//奖品类型切换
			$("#append-list").delegate("#award-inkind input", "click", function(){
				if($(this).val() == 0) {
					$(this).parents(".item").find(".num").css("display", "none");
					$(this).parents(".item").find("tr:eq(3),tr:eq(4)").show();
				} else {
					$(this).parents(".item").find(".num").css("display", "inline-block");
					$(this).parents(".item").find("tr:eq(3),tr:eq(4)").hide();
				}
			});
			</script>
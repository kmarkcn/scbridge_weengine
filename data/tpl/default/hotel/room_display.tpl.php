<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
	<div id="main-column" class="container-12 clearfix member-center">
		<div class="column2 grid-3 alpha omega">
			<?php include template('hotel/nav', TEMPLATE_INCLUDEPATH);?>
		</div>
		
		<div class="column1 grid-10 alpha omega">
			<div class="form">
				<div class="form_h">
					<h6>查看房间<a style='font-size:13px;color:red;'>(当前对应酒店:<?php echo $hotel['name'];?>)</a>
					</h6>
				</div>
				
				<?php if(is_array($rooms)) { foreach($rooms as $re) { ?>
				<div class='room_list'>
					<span>
						<a href="<?php echo create_url('hotel/room_post', array('room_id' => $re['id'],'id' => $hotel['id']))?>">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;
						<a onclick="return confirm('删除房间将不可恢复，确认吗？');return false;" href="<?php echo create_url('hotel/room_delete', array('room_id' => $re['id']))?>" style='margin-right:15px;'>删除</a>
					</span>
					<p class='ho_con_img'>
							<img  src="<?php echo $_W['attachurl'];?><?php echo $re['icon'];?>" width='60' height='60'>
					</p>
					<div class='room_con'>
						名称:<?php echo $re['name'];?><?php if($re['is_meeting']=='0') { ?>(普通房)<?php } else { ?>(会议室)<?php } ?><br/><br/>
						容纳人数:<?php echo $re['min_number'];?>至<?php echo $re['max_number'];?>人<br/><br/>
						会员价:<?php echo $re['price_vip'];?>&yen;
					</div>
				</div>
				
				<?php } } ?>
				<div style='clear:both;'></div>
				<h6>
							<a href='<?php echo create_url('hotel/room_display', array('id'=>$hotel['id'],'page' => $page_pro))?>'>上一页</a>
								<a style='color:red;'><?php echo $page;?></a>/<?php echo $page_total;?>
							<a href='<?php echo create_url('hotel/room_display', array('id'=>$hotel['id'],'page' => $page_next))?>'>下一页</a>
				</h6>
			</div>
		</div>
	</div>
<?php include template('common/footer', TEMPLATE_INCLUDEPATH);?>
<style>
.room_list{
	width:30%;
	display:inline-block;
	margin-bottom:10px;
	height:200px;
	margin-top:10px;
	float:left;
	background:#f8f8f8;
	margin-left:3%;
}
.room_list span{
	display:inline-block;
	width:100%;
	height:24px;
	line-height:24px;
	text-align:right;
	background:#d8d8d8;
}
.ho_con_img{
	text-align:center;
	display:inline-block;
	width:100%;
	margin-top:5px;
}
.room_con{
	text-align:center;
}
.form h6{
		text-align:center;
		font-size:14px;
	}
</style>
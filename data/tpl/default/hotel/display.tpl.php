<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
	<script type="text/javascript" src="./resource/script/jquery.zclip.min.js"></script>
	<div id="main-column" class="container-12 clearfix member-center">
		<div class="column2 grid-3 alpha omega">
			<?php include template('hotel/nav', TEMPLATE_INCLUDEPATH);?>
		</div>
		
		
		<div class="column1 grid-10 alpha omega">
			<!--遍历查询出来的数组-->
			<div class="list">
			
				<?php if(is_array($hotels)) { foreach($hotels as $re) { ?>
				<div class='ho_con'>
					<div class='ho_con_top'>
					<h5>
							<a href="<?php echo create_url('hotel/post', array('id' => $re['id']))?>">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;
							<a onclick="return confirm('删除酒店将不可恢复，确认吗？');return false;" href="<?php echo create_url('hotel/delete', array('id' => $re['id']))?>" style='margin-right:20px;'>删除</a>
					</h5>
						<span class='ho_con_img'>
							<img  src="<?php echo $_W['attachurl'];?><?php echo $re['icon'];?>" width='40' height='40'>
						</span>
					<div class='ho_info'>
						<h6>名称:<?php echo $re['name'];?>&nbsp;&nbsp;&nbsp;&nbsp;</a></h6>
						<h6>星级:<a style='color:red;'><?php echo $re['level'];?>星级</a></h6>
						<h6>城市:<?php echo $re['city'];?></h6>
						<h4>
							<a class='btn' style='margin-left:70px;' href="<?php echo create_url('hotel/room_display', array('id' => $re['id']))?>">查看房间</a>
							<a class='btn' href="<?php echo create_url('hotel/room_post', array('id' => $re['id']))?>">添加房间</a></h4>
					</div>
					
					
					</div>
				</div>
					
				
				
				<?php } } ?>
				<div style='clear:both;'>
					<h6>
							<a href='<?php echo create_url('hotel/display', array('page' => $page_pro))?>'>上一页</a>
								<a style='color:red;'><?php echo $page;?></a>/<?php echo $page_total;?>
							<a href='<?php echo create_url('hotel/display', array('page' => $page_next))?>'>下一页</a>
					</h6>
				</div>
			</div>
			
			
			
			
			
		</div>
	</div>
<?php include template('common/footer', TEMPLATE_INCLUDEPATH);?>
<style type='text/css'>
	.ho_con{
		border:1px solid #f2f2f2;
		width:300px;
		margin:auto;
		margin-bottom:30px;
		display:inline-block;
		float:left;
		margin:10px 40px;
		height:150px;
		background:#f8f8f8;
	}
	.ho_con_top{
		height:80px;
	}
	.ho_con_img{
		height:150px;
		width:150px;
		display:inline-block;
		position:relative;
		left:15px;
	}
	
	.ho_con .ho_info{
		position:relative;
		top:-150px;
		left:70px;
		width:70%;
	}
	.ho_con h5{
		font-size:12px;
		text-align:right;
		font-weigth:100;
		background:#d8d8d8;
		height:23px;
		padding-top:5px;
		
	}
	.ho_con h5 a{
		padding:4px;
		color:#7599DB;
	}
	.ho_con h4{
		text-align:center;
		margin-top:15px;
	}
	.ho_con h4 a{
		padding:4px;
		font-size:12px;
		clear:both;
		margin-left:20px;
		color:#fff;
	}
	.ho_con .ho_info h6{
		line-height:14px;
		font-size:10px;
		text-align:left;
	}
	.ho_des{
		border:1px solid #eee;
		position:relative;
		top:-50px;
		width:80%;
		margin:auto;
		text-align:left;
		margin-left:30px;
		padding:20px;
	}
	.list h6{
		text-align:center;
		font-size:14px;
	}
</style>
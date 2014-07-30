<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
	<script type="text/javascript" src="./resource/script/jquery.zclip.min.js"></script>
	<div id="main-column" class="container-12 clearfix member-center">
		<div class="column2 grid-3 alpha omega">
			<?php include template('booking/nav', TEMPLATE_INCLUDEPATH);?>
		</div>
		
		
		<div class="column1 grid-10 alpha omega">
			<!--遍历查询出来的数组-->
			
			<div class="list">
			
				
				<h6>
							<a href='<?php echo create_url('hotel/display', array('page' => $page_pro))?>'>上一页</a>
								<a style='color:red;'><?php echo $page;?></a>/<?php echo $page_total;?>
							<a href='<?php echo create_url('hotel/display', array('page' => $page_next))?>'>下一页</a>
				</h6>
			</div>
			
			
			
			
			
		</div>
	</div>
<?php include template('common/footer', TEMPLATE_INCLUDEPATH);?>
<style type='text/css'>
	.ho_con{
		border:1px solid #999;
		width:100%;
		margin:auto;
		margin-bottom:30px;
	}
	.ho_con_top{
		height:140px;
	}
	.ho_con_img{
		height:150px;
		width:150px;
		display:inline-block;
		position:relative;
		left:30px;
	}
	
	.ho_con .ho_info{
		position:relative;
		top:-150px;
		left:250px;
		width:70%;
	}
	.ho_con h5{
		font-size:12px;
		text-align:right;
		font-weigth:100;
		background:#ddd;
		height:23px;
		padding-top:5px;
		
	}
	.ho_con h5 a{
		padding:4px;
		color:#7599DB;
		
	}
	.ho_con .ho_info a{
		line-height:35px;
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
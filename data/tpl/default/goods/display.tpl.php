<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
	<script type="text/javascript" src="./resource/script/jquery.zclip.min.js"></script>
	<div id="main-column" class="container-12 clearfix member-center">
		<div class="column2 grid-3 alpha omega">
			<?php include template('goods/nav', TEMPLATE_INCLUDEPATH);?>
		</div>
		
		
		<div class="column1 grid-10 alpha omega">
			<!--遍历查询出来的数组-->
			<div class="list">
			
				<?php if(is_array($goods)) { foreach($goods as $re) { ?>
				<div class='ho_con'>
					<div class='ho_con_top'>
					<h5>
							<a href="<?php echo create_url('goods/post', array('id' => $re['id']))?>">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;
							<a onclick="return confirm('删除商品将不可恢复，确认吗？');return false;" href="<?php echo create_url('goods/delete', array('id' => $re['id']))?>" style='margin-right:40px;'>删除</a>
					</h5>
						<span class='ho_con_img'>
							<img  src="<?php echo $_W['attachurl'];?><?php echo $re['icon'];?>" width='40' height='40'>
						</span>
						<div class='ho_info'>
						<a><b>名称</b>：<?php echo $re['name'];?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a><b>类型</b>：<?php echo $re['good_type'];?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a><b>数量</b>：<?php echo $re['good_stock'];?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a><b>价格</b>：<?php echo $re['price'];?></a>
						</div>
					</div>
					
				</div>
				
				<?php } } ?>
				<h6>
							<a href='<?php echo create_url('goods/display', array('page' => $page_pro))?>'>上一页</a>
								<a style='color:red;'><?php echo $page;?></a>/<?php echo $page_total;?>
							<a href='<?php echo create_url('goods/display', array('page' => $page_next))?>'>下一页</a>
				</h6>
			</div>
			
			
			
			
			
		</div>
	</div>
<?php include template('common/footer', TEMPLATE_INCLUDEPATH);?>
<style type='text/css'>
	.ho_con{
		border:1px solid #f2f2f2;
		width:90%;
		margin:auto;
		margin-bottom:30px;
	}
	.ho_con_top{
		height:80px;
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
		left:160px;
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
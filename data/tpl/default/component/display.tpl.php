<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
	<script type="text/javascript" src="./resource/script/jquery.zclip.min.js"></script>
	<div id="main-column" class="container-12 clearfix member-center">
		<div class="column2 grid-3 alpha omega">
			<?php include template('component/nav', TEMPLATE_INCLUDEPATH);?>
		</div>
		
		
		<div class="column1 grid-10 alpha omega">
			<!--遍历查询出来的数组-->
			
			<div class="list">
			
				<?php if(is_array($ds)) { foreach($ds as $re) { ?>
				<div class='ho_con'>
					<div class='ho_con_top'>
						<h5>
							<a href="<?php echo create_url('component/post', array('id' => $re['id']))?>">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;
							<a onclick="return confirm('删除模块将不可恢复，确认吗？');return false;" href="<?php echo create_url('component/delete', array('id' => $re['id']))?>" style='margin-right:40px;'>删除</a>
						</h5>
					</div>	
						<div class='ho_info'>
							<b>模块名称</b>：<?php echo $re['name'];?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<b>模块价格</b>：<?php echo $re['price'];?>(元/人)
						</div>
					
				</div>
				
				<?php } } ?>
				<h6>
							<a href='<?php echo create_url('component/display', array('page' => $page_pro))?>'>上一页</a>
								<a style='color:red;'><?php echo $page;?></a>/<?php echo $page_total;?>
							<a href='<?php echo create_url('component/display', array('page' => $page_next))?>'>下一页</a>
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
	
	
	.ho_info{
		height:35px;
		padding-left:50px;
	}
	
	.ho_con_top h5{
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
	
	.list h6{
		text-align:center;
		font-size:14px;
	}
</style>
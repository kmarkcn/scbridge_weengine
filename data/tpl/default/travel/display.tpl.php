<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
	<script type="text/javascript" src="./resource/script/jquery.zclip.min.js"></script>
	<div id="main-column" class="container-12 clearfix member-center">
		<div class="column2 grid-3 alpha omega">
			<?php include template('travel/nav', TEMPLATE_INCLUDEPATH);?>
		</div>
		
		
		<div class="column1 grid-10 alpha omega">
			<!--遍历查询出来的数组-->
			
			<div class="list">
			
				<?php if(is_array($travels)) { foreach($travels as $re) { ?>
				<div class='ho_con'>
					<div class='ho_con_top'>
					<h5>
							<a href="<?php echo create_url('travel/post', array('id' => $re['id']))?>">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;
							<a onclick="return confirm('删除产品将不可恢复，确认吗？');return false;" href="<?php echo create_url('travel/delete', array('id' => $re['id']))?>" style='margin-right:40px;'>删除</a>
						</h5>
						<div style='margin-bottom:30px;'><b>&nbsp;&nbsp;&nbsp;产品名称:</b>
						<?php if($re['isHot'] == '1') { ?>  
								<a style='color:red;'>(热门产品)</a>
						<?php } else { ?>  
		 						(非热门产品)
						<?php } ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;截止时间:<?php echo(date('Y-m-d',$re['deadline']))?><?php if(time()<=$re['deadline']) { ?>  
								<a style='color:red;'>(非过期产品)</a>
						<?php } else { ?>  
		 						<a style='color:red;'>(过期产品)</a>
						<?php } ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						说走价:<a style='color:red;'><?php echo $re['total_price'];?></a>元</div>
						<div><b>&nbsp;&nbsp;&nbsp;图片展示</b>
							<img width='100' height='50' src="<?php echo $_W['attachurl'];?><?php echo $re['product_pic0'];?>" >
							<img width='100' height='100' src="<?php echo $_W['attachurl'];?><?php echo $re['product_pic1'];?>" >
							<img width='100' height='100' src="<?php echo $_W['attachurl'];?><?php echo $re['product_pic2'];?>" >
							<img width='100' height='100' src="<?php echo $_W['attachurl'];?><?php echo $re['product_pic3'];?>" >
						</div>
						<div style='margin-left:80px;margin-top:30px;'>
							<input type='button' value='出发信息' class='show_dep btn'>
							<input type='button' value='返航信息' class='show_ret btn'>
							<input type='button' value='目的地信息' class='show_des btn'>
							<input type='button' value='说明' class='show_rem btn'>
							<input type='button' value='关联行程' class='show_sch btn'">
							<input type='button' value='关联酒店' class='show_hot btn'>
							<input type='button' value='附加产品' class='show_com btn'>
							<div class='show_tr_info show_dep_1'>
								出发城市:<?php echo $re['departure_city'];?>	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;出发时间:<?php echo(date('Y-m-d',$re['departure_time']));?>	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;出发价格:<?php echo $re['departure_price'];?>元
							</div>
							<div class='show_tr_info show_ret_1'>
								返航城市:<?php echo $re['return_city'];?>	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;返航时间:<?php echo(date('Y-m-d',$re['return_time']));?>	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;返航价格:<?php echo $re['return_price'];?>元
							</div>
							<div class='show_tr_info show_des_1'>
								目的地:<?php echo $re['destination'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>信息:<?php echo $re['destination_info'];?>
							</div>
							<div class='show_tr_info show_rem_1'>
								费用说明:<?php echo $re['cost_explain'];?><br/><br/>
								签证说明:<?php echo $re['visa_explain'];?><br/><br/>
								预定需知:<?php echo $re['reserve_notice'];?><br/>	
							</div>
							<div class='show_tr_info show_sch_1' style='width:90%;margin-left:-50px;'>
								<?php if(is_array($re['sc'])) { foreach($re['sc'] as $res) { ?>
									<div>第<?php echo $res['date_order'];?>天<br/>&nbsp;&nbsp;<?php echo $res['name'];?></div>
								<?php } } ?>
							</div>
							<div class='show_tr_info show_hot_1'>
								<?php if(is_array($re['ho'])) { foreach($re['ho'] as $ren) { ?>
									<div><?php echo(date('Y-m-d',$ren['start_date']));?>至<?php echo(date('Y-m-d',$ren['end_date']));?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ren['name'];?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ren['room_type'];?></div>
								<?php } } ?>
							</div>
							<div class='show_tr_info show_com_1'>
								<?php if(is_array($re['com'])) { foreach($re['com'] as $rem) { ?>
									<a><?php echo $rem['name'];?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<?php } } ?>
							</div>
						</div>
						<br/>
					
					</div>
				</div>
				
				<?php } } ?>
				
				<h6>
							<a href='<?php echo create_url('travel/display', array('page' => $page_pro))?>'>上一页</a>
								<a style='color:red;'><?php echo $page;?></a>/<?php echo $page_total;?>
							<a href='<?php echo create_url('travel/display', array('page' => $page_next))?>'>下一页</a>
				</h6>
			</div>
			
			
			
			
			
		</div>
	</div>
<?php include template('common/footer', TEMPLATE_INCLUDEPATH);?>
<script>
$('.show_dep').toggle(
			function(){
				$('.show_tr_info').hide();
				$(this).parent().find('.show_dep_1').show();
			
			},
			function(){
				$(this).parent().find('.show_dep_1').hide();
			}
)
$('.show_ret').toggle(
			function(){
				$('.show_tr_info').hide();
				$(this).parent().find('.show_ret_1').show();
			},
			function(){
				$(this).parent().find('.show_ret_1').hide();
			}
)
$('.show_des').toggle(
			function(){
				$('.show_tr_info').hide();
				$(this).parent().find('.show_des_1').show();
			},
			function(){
				$(this).parent().find('.show_des_1').hide();
			}
)
$('.show_rem').toggle(
			function(){
				$('.show_tr_info').hide();
				$(this).parent().find('.show_rem_1').show();
			},
			function(){
				$(this).parent().find('.show_rem_1').hide();
			}
)
$('.show_sch').toggle(
			function(){
				$('.show_tr_info').hide();
				$(this).parent().find('.show_sch_1').show();
			},
			function(){
				$(this).parent().find('.show_sch_1').hide();
			}
)
$('.show_hot').toggle(
			function(){
				$('.show_tr_info').hide();
				$(this).parent().find('.show_hot_1').show();
			},
			function(){
				$(this).parent().find('.show_hot_1').hide();
			}
)
$('.show_com').toggle(
			function(){
				$('.show_tr_info').hide();
				$(this).parent().find('.show_com_1').show();
			},
			function(){
				$(this).parent().find('.show_com_1').hide();
			}
)
</script>
<style type='text/css'>
	.ho_con{
		border:1px solid #f2f2f2;
		width:90%;
		margin:auto;
		margin-bottom:20px;
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
		width:50%;
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
		padding:1px;
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
	.show_tr_info{
		margin-top:20px;
		padding:30px;
		border:1px solid #ddd;
		width:70%;
		text-align:left;
		display:none;
	}
	.list h6{
		text-align:center;
		font-size:14px;
	}
</style>
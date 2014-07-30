<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
	<div id="main-column" class="container-12 clearfix member-center">
		<div class="column2 grid-3 alpha omega">
			<?php include template('travel/nav', TEMPLATE_INCLUDEPATH);?>
		</div>
		<div class="column1 grid-10 alpha omega">
			<div class="form">
				<div class="form_h">
				<?php if(empty($id)) { ?>
				<h6>添加旅游</h6>
				<?php } else { ?>
				<h6>修改旅游</h6>
				<?php } ?>
				</div>
				<form action="" method="post" onsubmit="return formcheck(this)">
				<input type="hidden" name="id" value="<?php echo $id;?>" />
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<th>产品信息</th>
					<td>
						<div class='con'>
							产品名字&nbsp;<input type="text" name="product_name"  value="<?php echo $travel['product_name'];?>" autofocus="autofocus" required="required" style='width:300px;'/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<br/><br/>
							<input type='checkbox' value='1' name='isHot' 
								<?php if($travel['isHot']=='1') { ?>
									checked='onchekced'
								<?php } else { ?>
								<?php } ?>">
								热门产品
							
						<br/><br/>
						产品截止时间&nbsp;<input type="text" class="datepicker" required id="date5" name="deadline" value="<?php echo(date('Y-m-d',$travel['deadline']));?>" style='width:80px;'/>  
						
					</td>
				</tr>
					<tr>
					<th>图片展示</th>
					<td>
						<div class='con'>
						展示图片(小图片):
								<br/><br/>
								<div class="upload-area grid-5 pin"><span class="fr">建议尺寸：250像素 * 150像素</span>
								<input type="button"  id="loc-picture0" fieldname="product_pic0" class="upload-file-btn" value="上传"/>
								<?php if(!empty($travel['product_pic0'])) { ?>
								<div id="upload-file-view0">	
								<div class="upload-view">
								<input type="hidden" name="product_pic0" value="<?php echo $travel['product_pic0'];?>">
								<input type="hidden" id="picture-value0" value="<?php echo $travel['product_pic0'];?>">
								<img width="100" src="<?php echo $_W['attachurl'];?><?php echo $travel['product_pic0'];?>">&nbsp;&nbsp;
								<a onclick="kindeditor_upload_delete(this, '<?php echo $travel['product_pic0'];?>')" href="javascript:;">删除</a>
								</div>
								</div>
								<?php } else { ?>
								<div id="upload-file-view0"></div>
								<?php } ?>
								</div>
						
							
								<br/>
								<div>大图片展示1
								
								<div class="upload-area grid-5 pin"><span class="fr">建议尺寸：1181像素 * 1714像素</span>
						<input type="button"  id="loc-picture1" fieldname="product_pic1" class="upload-file-btn" value="上传"/>
						<?php if(!empty($travel['product_pic1'])) { ?>
						<div id="upload-file-view1">	
								<div class="upload-view">
								<input type="hidden" name="product_pic1" value="<?php echo $travel['product_pic1'];?>">
								<input type="hidden" id="picture-value1" value="<?php echo $travel['product_pic1'];?>">
								<img width="100" src="<?php echo $_W['attachurl'];?><?php echo $travel['product_pic1'];?>">&nbsp;&nbsp;
								<a onclick="kindeditor_upload_delete(this, '<?php echo $travel['product_pic1'];?>')" href="javascript:;">删除</a>
								</div>
						</div>	
						<?php } else { ?>
						<div id="upload-file-view1"></div>
						<?php } ?>
						
						
						</div>
						<br/>
						<div>大图片展示2
								
								<div class="upload-area grid-5 pin"><span class="fr">建议尺寸：1181像素 * 1714像素</span>
						<input type="button"  id="loc-picture2" fieldname="product_pic2" class="upload-file-btn" value="上传"/>
						<?php if(!empty($travel['product_pic2'])) { ?>
						<div id="upload-file-view2">	
								<div class="upload-view">
								<input type="hidden" name="product_pic2" value="<?php echo $travel['product_pic2'];?>">
								<input type="hidden" id="picture-value2" value="<?php echo $travel['product_pic2'];?>">
								<img width="100" src="<?php echo $_W['attachurl'];?><?php echo $travel['product_pic2'];?>">&nbsp;&nbsp;
								<a onclick="kindeditor_upload_delete(this, '<?php echo $travel['product_pic2'];?>')" href="javascript:;">删除</a>
								</div>
						</div>
						<?php } else { ?>
						<div id="upload-file-view2"></div>
						<?php } ?>
						
						
						</div>
						<br/>
						<div>大图片展示3
						
								
								<div class="upload-area grid-5 pin"><span class="fr">建议尺寸：1181像素 * 1714像素</span>
						<input type="button"  id="loc-picture3" fieldname="product_pic3" class="upload-file-btn" value="上传"/>
						<?php if(!empty($travel['product_pic3'])) { ?>
						<div id="upload-file-view3">	
								<div class="upload-view">
								<input type="hidden" name="product_pic3" value="<?php echo $travel['product_pic3'];?>">
								<input type="hidden" id="picture-value3" value="<?php echo $travel['product_pic3'];?>">
								<img width="100" src="<?php echo $_W['attachurl'];?><?php echo $travel['product_pic3'];?>">&nbsp;&nbsp;
								<a onclick="kindeditor_upload_delete(this, '<?php echo $travel['product_pic3'];?>')" href="javascript:;">删除</a>
								</div>
						</div>
						<?php } else { ?>
						<div id="upload-file-view3"></div>
						<?php } ?>
						</div>
						</div>
					</td>
				</tr>
				
				<tr>
					<th>航班信息</th>
					<td>
						<div class='con'>
						出发城市&nbsp;<input type='text' name='departure_city' style='width:100px;margin-bottom:10px;' autofocus="autofocus" required="required" value="<?php echo $travel['departure_city'];?>" >
						出发时间&nbsp;<input type="text" class="datepicker" required id="date1" name="departure_time" value="<?php echo(date('Y-m-d',$travel['departure_time']));?>" style='width:80px;'/>  
						出发价格&nbsp;<input type='text'  name='departure_price' style='width:60px;margin-bottom:10px;'  value="<?php echo $travel['departure_price'];?>">(单位:元)<br/>
						出发详情<span class='notice'>&nbsp;&nbsp;(出发细节说明)</span>
						<textarea name="departure_details"   class="txt grid-5 alpha pin" style="height:50px; width:470px;" autofocus="autofocus" ><?php echo $travel['departure_details'];?></textarea>
						<br/>
						返航城市&nbsp;<input type='text' name='return_city' style='width:100px;margin-bottom:10px;' autofocus="autofocus" required="required" value="<?php echo $travel['return_city'];?>" >
						返航时间&nbsp;<input type="text" class="datepicker" required id="date2" name="return_time" value="<?php echo(date('Y-m-d',$travel['return_time']));?>" style='width:80px;'/>  
						返航价格&nbsp;<input type='text'  name='return_price' style='width:60px;margin-bottom:10px;' autofocus="autofocus" required="required" value="<?php echo $travel['return_price'];?>">(单位:元)<br/>
						返航详情<span class='notice'>&nbsp;&nbsp;(返回细节说明)</span>
						<textarea name="return_details"  class="txt grid-5 alpha pin" style="height:50px; width:470px;"><?php echo $travel['return_details'];?></textarea>
						</div>
					</td>
				</tr>
				<tr>
					<th>目的地信息</th>
					<td>
						<div class='con'>
						目的地&nbsp;<input type='text' name='destination' style='width:160px;margin-bottom:10px;' autofocus="autofocus" required="required" value="<?php echo $travel['destination'];?>" ><br/>
					
						目的地信息<span class='notice'>&nbsp;&nbsp;(简单目的地介绍)</span>
						<textarea name="destination_info" class="richtext-clone" id="richtext_content2" class="txt grid-5 alpha pin" style="height:120px; width:470px;"><?php echo $travel['destination_info'];?></textarea>
						
						</div>
						
					</td>
				</tr>
				
				
				
				<tr>
					<th>费用说明</th>
					<td>
						费用详情<span class='notice'>&nbsp;&nbsp;(费用细节说明)</span>
						<textarea name="cost_explain"  class="txt grid-5 alpha pin" style="height:50px; width:470px;"><?php echo $travel['return_details'];?></textarea>
						</div>
					</td>
				</tr>
				
				<tr>
					<th>签证说明</th>
					<td>
						签证详情<span class='notice'>&nbsp;&nbsp;(签证细节说明)</span>
						<textarea name="visa_explain"  class="txt grid-5 alpha pin" style="height:50px; width:470px;"><?php echo $travel['return_details'];?></textarea>
						</div>
					</td>
				</tr>
				<tr>
					<th>预定需知</th>
					<td>
						</div>
						预定需知<span class='notice'>&nbsp;&nbsp;(预定细节)</span>
						<textarea name="reserve_notice"  class="txt grid-5 alpha pin" style="height:100px; width:470px;"><?php echo $travel['reserve_notice'];?></textarea>
						
						</div>
					</td>
				</tr>
				<tr>
					<th>备注</th>
					<td>
						备注<span class='notice'>&nbsp;&nbsp;(注意说明)</span>
						<textarea name="remarks"  class="txt grid-5 alpha pin" style="height:50px; width:470px;"><?php echo $travel['return_details'];?></textarea>
						</div>
						
					</td>
				</tr>
				<tr>
					<td colspan='2'>
						<input type='button' value='添加行程' class='mt10 btn grid-2 alpha' id='add_schedule'>
						<div style='margin-top:10px;display:none;font-size:8px;border:1px solid #ccc;' id='schedule_show' >
							<br/><br/><br/>
							&nbsp;&nbsp;天&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;数:&nbsp;<select name='orders' id='orders'>
											<option value='0'>请选择</option>
											<option value='1'>第1天</option>
											<option value='2'>第2天</option>
											<option value='3'>第3天</option>
											<option value='4'>第4天</option>
											<option value='5'>第5天</option>
											<option value='6'>第6天</option>
											<option value='7'>第7天</option>
											<option value='8'>第8天</option>
											<option value='9'>第9天</option>
								</select>
							<br/><br/>&nbsp;&nbsp;行&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;程:&nbsp;<select  id='schedules'>
										<option value='0'>请选择</option>
										<?php if(is_array($travel_schedule)) { foreach($travel_schedule as $tr) { ?>
											<option value="<?php echo $tr['id'];?>" class="sc_se_<?php echo $tr['id'];?>"><?php echo $tr['name'];?></option>
										<?php } } ?>
								</select>
								<input type='hidden' id='schedules_new' name='schedules_new' value='<?php echo $sche;?>'>
							<br/><br/><input type='button' value='添加' class='btn' id='schedule_right' style='width:50px;margin-left:40%;'>
						&nbsp;&nbsp;&nbsp;&nbsp;<font id='schedules_reminder' style='color:red;'></font>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan='2' style='padding-left:100px;'>
						
						<div id='schedule_div' style='width:400px;text-align:center;padding-left:50px;'>
						<table width='150%' id='tab_schedule' style='margin-left:-100px;'>
							<?php if(is_array($schedules)) { foreach($schedules as $new_td1) { ?>
								<tr><td>第<?php echo $new_td1['date_order'];?>天</td><td><?php echo $new_td1['name'];?></td><td><a class='delete' id="delete<?php echo $new_td1['date_order'];?><?php echo $new_td1['schedule_id'];?>">删除</a></td></tr>
							<?php } } ?>
						</table>
						
						</div>
						
					</td>
				</tr>
				
				
				<!--这里是添加酒店模块-->
				<tr>
					<td colspan='2'>
						<input type='button' value='添加酒店' class='mt10 btn grid-2 alpha' id='add_hotel'>
						<div style='margin-top:10px;display:none;border:1px solid #ccc;font-size:10px;' id='hotel_show' >
						<br/><br/>	
						&nbsp;&nbsp;酒店名称:
						<select id='hotel_name' name='hotel_name'>
										<option value='0'>请选择</option>
										<?php if(is_array($travel_hotel)) { foreach($travel_hotel as $tr) { ?>
											<option value="<?php echo $tr['id'];?>"><?php echo $tr['name'];?></option>
										<?php } } ?>
								</select>
						<br/><br/>&nbsp;&nbsp;房间类型:
								<select name='room_type' id='room_type'>
										<option value='0'>请选择</option>
										<option value='经济房'>经济房</option>
										<option value='豪华房'>豪华房</option>
										<option value='行政房'>行政房</option>
								</select>		
						<br/><br/>&nbsp;&nbsp;入住时间:
								<input type="text" class="datepicker"  id="date3" name="start_date" value="<?php echo $hotel['start_date'];?>" style='width:80px;'/>  
						<br/><br/>&nbsp;&nbsp;结束时间:
								<input type="text" class="datepicker"  id="date4" name="end_date" value="<?php echo $hotel['end_date'];?>" style='width:80px;'/>  
						(当晚还需入住)
						
						<br/><br/>		
						&nbsp;&nbsp;房间价格:&nbsp;<input type='text' name='per_night_price'  id='per_night_price' style='width:80px;'>(元/晚)
						<br/><br/>&nbsp;&nbsp;共&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;计:&nbsp;<input type='text' name='total_price' style='width:80px;'>(元)
						<br/><br/>&nbsp;&nbsp;备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注:&nbsp;<input type='text' name='remark' style='width:450px;'><br/>
						<br/><font id='hotel_reminder' style='color:red;padding-left:100px;'></font>
						<br/><input type='hidden' id='hotel_new' name='hotel_new' value='<?php echo $hots;?>'>
						
							&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' value='添加' class='btn' id='hotel_right' style='width:50px;margin-left:40%;'>
						&nbsp;&nbsp;&nbsp;&nbsp;
						</div>
					</td>
				</tr>
				
				
				<tr>
					<td colspan='2' style='padding-left:100px;'>
						<div id='hotel_div' style='width:400px;text-align:center;padding-left:50px;'>
						<table width='150%' id='tab_hotel' style='margin-left:-100px;'>
							
							<?php if(is_array($hotels)) { foreach($hotels as $reh) { ?>
								<tr>
								<td><?php echo $reh['name'];?></td><td><input type='hidden' class='cal_ho_price' value="<?php echo $reh['total_price'];?>"><?php echo $reh['room_type'];?></td><td><?php echo(date('Y-m-d',$reh['start_date']));?>至<?php echo(date('Y-m-d',$reh['end_date']));?></td><td><?php echo $reh['per_night_price'];?>(元/晚)</td><td><a class='delete'><input type='hidden' value="<?php echo $reh['id'];?>:<?php echo $reh['room_type'];?>:<?php echo(date('Y-m-d',$reh['start_date']))?>:<?php echo(date('Y-m-d',$reh['end_date']))?>:<?php echo $reh['per_night_price'];?>:<?php echo $reh['total_price'];?>:<?php echo $reh['remarks'];?>">删除</a></td>
								</tr>
									
							<?php } } ?>
						</table>
						</div>
					</td>
				</tr>
				
				
				<tr>
					<td colspan='2'>
						<br/>
						<input type='button' value='附加产品' class='mt10 btn grid-2 alpha' id='add_component'>
						<div style='margin-top:10px;display:none;font-size:8px;border:1px solid #ccc;' id='component_show' >
							<br/><br/><br/>&nbsp;&nbsp;&nbsp;可选产品:&nbsp;<select  id='components'>
										<option value='0'>请选择</option>
										<?php if(is_array($travel_component)) { foreach($travel_component as $tr) { ?>
											<option value="<?php echo $tr['id'];?>" class="sc_se_<?php echo $tr['id'];?>"><?php echo $tr['name'];?></option>
										<?php } } ?>
								</select>
								<input type='hidden' id='components_new' name='components_new' value='<?php echo $comp;?>'>
							<br/><br/><input type='button' value='添加' class='btn' id='component_right' style='width:50px;margin-left:40%;'>
						&nbsp;&nbsp;&nbsp;&nbsp;<font id='components_reminder' style='color:red;'></font>
						</div>
					</td>
				</tr>
				
				<tr>
					<td colspan='2' style='padding-left:100px;'>
						
						<div id='component_div' style='width:400px;text-align:center;padding-left:50px;'>
						<table width='150%' id='tab_component' style='margin-left:-100px;'>
							<?php if(is_array($components)) { foreach($components as $new_td1) { ?>
								<tr><td><?php echo $new_td1['name'];?></td><td><a class='delete' id="delete<?php echo $new_td1['component_id'];?>">删除</a></td></tr>
							<?php } } ?>
						</table>
						
						</div>
						
					</td>
				</tr>
				
				
				
				
				<tr>
					<td colspan='2' style='text-align:center;padding-left:60%;'>
						<input type='button' value='计算' class='mt10 btn grid-2 alpha' id='cal_total_price' style='width:50px;font-size:10px;text-align:center;'>
						<div id='total_price_show' style='height:42px;line-height:49px;text-align:left;'>说走价:<input style='width:70px;font-size:15px;color:red;' name='tr_total_price'>元
							<br/>(注：该价格不包括附加产品的价格)
						</div>
					</td>
				</tr>
				<tr>
					<th></th>
					<td>
						<br/><br/>
						<input name="submit" type="submit" value="提交" class="mt10 btn grid-2 alpha" id='product_submit'/>
						<input type="hidden" name="token" value="<?php echo $_W['token'];?>" />
					</td>
				</tr>
				
				</table>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		//kindeditor('textarea:[class="richtext-clone"]');
		//这个[0]太威武！！！
		$(function(){
			schedules=$('#schedules_new').val();
			components=$('#components_new').val();
			ho_pri=0;
		})
		
		kindeditor_upload_image($('#loc-picture0')[0]);
		kindeditor_upload_image($('#loc-picture1')[0]);
		kindeditor_upload_image($('#loc-picture2')[0]);
		kindeditor_upload_image($('#loc-picture3')[0]);
		kindeditor($('#richtext_content2')[0]);
		
		$('.show_info').mouseover(function(){
				$(this).find('a').show();
		})
		$('.show_info').mouseout(function(){
				$(this).find('a').hide();
		})
		
		$('#add_schedule').toggle(function(){$('#schedule_show').show();},function(){$('#schedule_show').hide();})
		$('#add_component').toggle(function(){$('#component_show').show();},function(){$('#component_show').hide();})
		
		
		
		//这里是如果选择框的内容改变，那么提示框里面的内容为空
		$('#orders').change(function(){
			$("#schedules_reminder").html('');
		})
		$('#schedules').change(function(){
			$('#schedules_reminder').html('');
		})
		$('#components').change(function(){
			$('#components_reminder').html('');
		})
		
		//这里是点击确认添加按钮事件
		$('#schedule_right').click(function(){
				var order=$('#orders').val();
				var schedule0=$('#schedules').val();
				//应该先判断这个数组里面是否已经存在这条数据，如果已经存在，则需要提示
				
				if(order=='0'){
					$("#schedules_reminder").html('(请选择天数)');
				}else if(schedule0=='0'){
					$("#schedules_reminder").html('(请选择行程)');
				}else{
					
								schedules+=order;
								schedules+=schedule0;
								$('#schedule_show').hide();
								$('#schedules_new').val(schedules);
								//这里还要动态的给展示页面添加一行
								//构造这个字符串
								var select_name_re=$("#schedules option:selected").text();
								//var select_name="#schedules .sc_se_"+schedule0;
								//var schedule_name=$(select_name).text();
								var new_td="<tr><td>第"+order+"天</td><td>"+select_name_re+"</td><td><a class='delete' id='delete"+order+schedule0+"'>删除</a></td></tr>";
								$('#tab_schedule').append(new_td);
						

				
					
				}
		})
	
		//现在这里是删除做出的反应
		$('#tab_schedule a').live("click",function(){
			//这里先要处理刚才动态生成的那个数组
			var date_day=($(this).attr('id').substring(6,7));
			var sche=($(this).attr('id').substring(7,8));
			//现在遍历动态生成的数组,然后改变它的值
			//alert(schedules);
			for(i=0;i<schedules.length;i++){
				if(schedules[i]==date_day && schedules[i+1]==sche){
					schedules_1=schedules.substring(0,i); 
					schedules_2=schedules.substring(i+2,schedules.length);
					schedules='';
					schedules=schedules_1+schedules_2;
					
					//这样的应该只有一次，然后再退出此次循环
					$('#schedules_new').val(schedules);
					break;
				}
			}
			$(this).parent().parent().remove();
			
		})
		
		//这里是关联附加产品模块
		$('#component_right').click(function(){
			
				var component0=$('#components').val();
				
				if(component0=='0'){
					$("#components_reminder").html('(请选择产品)');
				}else{
					components+=component0;
					$('#component_show').hide();
					$('#components_new').val(components);
					//这里还要动态的给展示页面添加一行
					//构造这个字符串
					var select_name_re=$("#components option:selected").text();
					//var select_name="#schedules .sc_se_"+schedule0;
					//var schedule_name=$(select_name).text();
					var new_td="<tr><td>"+select_name_re+"</td><td><a class='delete' id='delete"+component0+"'>删除</a></td></tr>";
					$('#tab_component').append(new_td);
				}
		})
		
		
		//现在这里是删除附加产品的反应
		$('#tab_component a').live("click",function(){
			//这里先要处理刚才动态生成的那个数组
			var component=($(this).attr('id').substring(6,7));
			//现在遍历动态生成的数组,然后改变它的值
			//alert(schedules);
			for(i=0;i<components.length;i++){
				if(components[i]==component){
					components_1=components.substring(0,i); 
					components_2=components.substring(i+1,components.length);
					components='';
					components=components_1+components_2;
					//这样的应该只有一次，然后再退出此次循环
					$('#components_new').val(components);
					break;
				}
			}
			$(this).parent().parent().remove();
		})
	</script>
	<script>
		hotels=$('#hotel_new').val();
		$('#add_hotel').toggle(function(){$('#hotel_show').show();},function(){$('#hotel_show').hide();})
		$('input[name=per_night_price]').change(function(){
			var start_date=$('input[name=start_date]').val();
			var end_date=$('input[name=end_date]').val();
			if(start_date==''){
				$('#hotel_reminder').html('请选择入住时间');
			}else if(end_date==''){
				$('#hotel_reminder').html('请选择结束时间');
			}else{
				//这里先进行时间的处理
				 var hotel_days=dateDiff(start_date,end_date)+1;
				 var total_price=hotel_days*$(this).val();
				 $('input[name=total_price]').val(total_price);
				 $('#hotel_reminder').html('');
			}
		})
		
		$('#cal_total_price').click(function(){
			//定义酒店总价格
			ho_pri=0;
			var de_price=parseInt(($('input[name=departure_price]').val()));
			var re_price=parseInt(($('input[name=return_price]').val()));
			($('.cal_ho_price')).each(function(){
				ho_pri+=parseInt($(this).val());
			})
			var tr_price=de_price+re_price+ho_pri;
			$('#total_price_show input').val(tr_price);
			
		})
		
		$('#hotel_right').click(function(){
			//先验证有没有选择酒店
			var hotel_name=$('#hotel_name').val();
			var hotel_name_re=$("#hotel_name option:selected").text();
			var room_type=$('#room_type').val();
			var per_night_price=$('#per_night_price').val();
			var start_date=$('input[name=start_date]').val();
			var end_date=$('input[name=end_date]').val();
			var total_price=$('input[name=total_price]').val();
			var remark=$('input[name=remark]').val();
			if(hotel_name==0){
				$('#hotel_reminder').html('请选择酒店');
			}else if(room_type==0){
				$('#hotel_reminder').html('请选择房间类型');
			}else{
				//我看这里还是只有构造字符串
				hotels+=hotel_name;
				hotels+=':';
				hotels+=room_type;
				hotels+=':';
				hotels+=start_date;
				hotels+=':';
				hotels+=end_date;
				hotels+=':';
				hotels+=per_night_price;
				hotels+=':';
				hotels+=total_price;
				hotels+=':';
				hotels+=remark;
				hotels+='/';
				var hotel_new='';
				hotel_new+=hotel_name;
				hotel_new+=':';
				hotel_new+=room_type;
				hotel_new+=":";
				hotel_new+=start_date;
				hotel_new+=":";
				hotel_new+=end_date;
				hotel_new+=":";
				hotel_new+=per_night_price;
				hotel_new+=":";
				hotel_new+=total_price;
				hotel_new+=":";
				hotel_new+=remark;
				//赋给隐藏的input
				$('#hotel_new').val(hotels);
				$('#hotel_show').hide();
				//还要添加table里面的一行
				var new_td1="<tr><td>"+hotel_name_re+"</td><td><input type='hidden' class='cal_ho_price' value="+total_price+">"+room_type+"</td><td>"+start_date+'至'+end_date+"</td>"+"<td>"+per_night_price+"(元/晚)</td>"+"<td><a class='delete'><input type='hidden' value="+hotel_new+" >删除</a></td>";
				$('#tab_hotel').append(new_td1);
				
			}
		})
		
		
		//这里是删除酒店事件
		$('#tab_hotel a').live('click',function(){
			var hotel_new=hotels.split('/');
			var hotel_pe=$(this).children('input').val();
			//alert(hotel_new+hotel_pe);
			for(var i=0;i<hotel_new.length-1;i++){
				if(hotel_new[i]==hotel_pe){
					//alert(1);
					hotel_new.splice(i,1);
					hotels=hotel_new.join('/');
					break;
				}
			}
			$(this).parent().parent().remove();
			$('#hotel_new').val(hotels);
		})		
		
		$('#product_submit').click(function(){
			ho_pri=0;
			var de_price=parseInt(($('input[name=departure_price]').val()));
			var re_price=parseInt(($('input[name=return_price]').val()));
			($('.cal_ho_price')).each(function(){
				ho_pri+=parseInt($(this).val());
			})
			var tr_price=de_price+re_price+ho_pri;
			$('#total_price_show input').val(tr_price);
		});
		
		 //判断是否为闰年
        function isLeapYear(year){
         if(year % 4 == 0 && ((year % 100 != 0) || (year % 400 == 0))){
              	return true;
         }
         		return false;
         }
         //判断前后两个日期
        function validatePeriod(fyear,fmonth,fday,byear,bmonth,bday){
         if(fyear < byear){
         	return true;
         }else if(fyear == byear){
         if(fmonth < bmonth){
            return true;
         } else if (fmonth == bmonth){
            if(fday <= bday){
             return true;
            }else {
             return false;
            }
         } else {
            return false;
         }
         }else {
         return false;
         }
         }
     //计算两个日期的差值
        function dateDiff(d1,d2){
             var disNum=compareDate(d1,d2);
             return disNum;
         }
         function compareDate(date1,date2)
         {
             var regexp=/^(\d{1,4})[-|\.]{1}(\d{1,2})[-|\.]{1}(\d{1,2})$/;
             var monthDays=[0,3,0,1,0,1,0,0,1,0,0,1];
             regexp.test(date1);
             var date1Year=RegExp.$1;
             var date1Month=RegExp.$2;
             var date1Day=RegExp.$3;

             regexp.test(date2);
             var date2Year=RegExp.$1;
             var date2Month=RegExp.$2;
             var date2Day=RegExp.$3;

         if(validatePeriod(date1Year,date1Month,date1Day,date2Year,date2Month,date2Day)){
         firstDate=new Date(date1Year,date1Month,date1Day);
              secondDate=new Date(date2Year,date2Month,date2Day);

              result=Math.floor((secondDate.getTime()-firstDate.getTime())/(1000*3600*24));
              for(j=date1Year;j<=date2Year;j++){
                  if(isLeapYear(j)){
                      monthDays[1]=2;
                  }else{
                      monthDays[1]=3;
                  }
                  for(i=date1Month-1;i<date2Month;i++){
                      result=result-monthDays[i];
                  }
              }
              return result;
         }else{
        	 $('#hotel_reminder').html('对不起第一个时间必须小于第二个时间，谢谢！');
             exit;
         }
         }

		    
	</script>
	<style type='text/css'>
		.con{
			border:1px solid #ddd;
			padding:20px;
		}
		 .delete{
			color:#7599DB;
		}
		.delete:hover{
			color:blue;
		}
		.schedule_show_data{
			width:120%;
			height:26px;
			background:#ddd;
			line-height:26px;
		}
		#tab_schedule  td{
			font-size:10px;
			background:#ddf;
			height:10px;
			line-height:10px;
			text-align:center;
			border-bottom:3px solid #fff;
			
		}
		#tab_hotel td{
			font-size:10px;
			background:#ddf;
			height:10px;
			line-height:10px;
			text-align:center;
			border-bottom:3px solid #fff;
		}
		#tab_component td{
			font-size:10px;
			background:#ddf;
			height:10px;
			line-height:10px;
			text-align:center;
			border-bottom:3px solid #fff;
		}
		
	</style>


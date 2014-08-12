<?php
/*
 * by Terry 2014-08-04
 */
defined('IN_IA') or exit('Access Denied');

class ScbridgeModule extends WeModule {
	
	
	public function fieldsFormDisplay($rid = 0) {
		
	}

	public function fieldsFormValidate($rid = 0) {
		return true;
	}

	public function fieldsFormSubmit($rid = 0) {
		
	}

	public function ruleDeleted($rid = 0) {
		
	}

	public function doFormDisplay() {

	}

	//主页的调用
	public function doindex() {
		global $_W, $_GPC;
		include $this->template('scbridge:homepage');
	
	}
	
	//酒店预订中心页面加载
	public function dohotel_center(){
		global $_W, $_GPC;
		//读取数据
		$sql_1 = "SELECT * FROM " . tablename('hotel');
		$hotels = pdo_fetchall($sql_1);
		//遍历数组，从数据库中选出最低的那个产品
		for($i=0;$i<count($hotels);$i++){
			$sql_2="SELECT min(price_vip) as pri,price_normal FROM".tablename('hotel_room')."where hotel_id= ".$hotels[$i]['id'];
			$pr=pdo_fetch($sql_2);
			$hotels[$i]['price_vip']=$pr['pri'];
			$hotels[$i]['price_normal']=$pr['price_normal'];
		}
		$title='酒店预订';
		include $this->template('scbridge:header');
		include $this->template('scbridge:member_product');
		include $this->template('scbridge:footer');
	}
	
	
	//酒店详细内容页面加载
	public function dohotel_content(){
		global $_W,$_GPC;
		$h_id=$_GPC['h_id'];
		$sql="SELECT * FROM ".tablename('hotel');
		$hotel=pdo_fetch($sql);
		switch ($hotel['level']){
			case 1:
				$hotel['level']='准4星';
				break;
			case 2:
				$hotel['level']='4星';
				break;
			case 3:
				$hotel['level']='准5星';
				break;
			case 4:
				$hotel['level']='精品';
				break;
			case 5:
				$hotel['level']='5星';
				break;
			case 6:
				$hotel['level']='奢华';
				break;
		}
		$sql_2="SELECT min(price_vip) as pri,max(price_vip) as pr FROM".tablename('hotel_room')."where hotel_id= ".$h_id;
		$ho=pdo_fetch($sql_2);
		$hotel['pr_min']=$ho['pri'];
		$hotel['pr_max']=$ho['pr'];
		$title='酒店预订';
		include $this->template('scbridge:header');
		include $this->template('scbridge:hotel-reserve');
		include $this->template('scbridge:footer');
		
	}
	//酒店预订信息填写页面加载
	public function dohotel_booking(){
		global $_W,$_GPC;
		$h_id=$_GPC['id'];
		include $this->template('scbridge:room-reserve');
	}
	
	//会议预定信息填写页面加载
	public function domeeting_booking(){
		global $_W,$_GPC;
		$h_id=$_GPC['id'];
		include $this->template('scbridge:meeting-reserve-write');
	}	
	
	//会议预定详细页面加载
	public function dohotel_contents(){
		global $_W,$_GPC;
		$h_id=$_GPC['h_id'];
		$sql="SELECT * FROM ".tablename('hotel');
		$hotel=pdo_fetch($sql);
		switch ($hotel['level']){
			case 1:
				$hotel['level']='准4星';
				break;
			case 2:
				$hotel['level']='4星';
				break;
			case 3:
				$hotel['level']='准5星';
				break;
			case 4:
				$hotel['level']='精品';
				break;
			case 5:
				$hotel['level']='5星';
				break;
			case 6:
				$hotel['level']='奢华';
				break;
		}
		$sql_2="SELECT min(price_vip) as pri,max(price_normal) as pr FROM".tablename('hotel_room')."where hotel_id= ".$h_id ." and is_meeting=1";
		$ho=pdo_fetch($sql_2);
		$hotel['pr_min']=$ho['pri'];
		$hotel['pr_max']=$ho['pr'];
		$sql_3="SELECT min(min_number) as pri,max(max_number) as pr FROM".tablename('hotel_room')."where hotel_id= ".$h_id ." and is_meeting=1";
		$ho=pdo_fetch($sql_3);
		$hotel['num_min']=$ho['pri'];
		$hotel['num_max']=$ho['pr'];
		$title='会议预订';
		include $this->template('scbridge:header');
		include $this->template('scbridge:hotel_re');
		include $this->template('scbridge:footer');
	
	}
	
	//会员注册页面加载
	public function dovip_register(){
		session_start();
		global $_W,$_GPC;
		$user_id=$_GPC['user_id'];
		if(empty($user_id)){
			$h_id=$_GPC['h_id'];
			//判断是否已经存在此用户
			$oppenid=$_SESSION['sc_user_oppenid'];
			$sql="select * from ims_customer where open_id = '{$oppenid}'";
			$result=pdo_fetch($sql);
			if(!empty($result)){
				$img_url=$_SESSION['sc_user_info']->headimgurl;
				include $this->template('scbridge:member_center');
				include $this->template('scbridge:footer');
			}else{
				$title='会员注册';
				$reminder='注册';
				include $this->template('scbridge:header');
				include $this->template('scbridge:register');
				include $this->template('scbridge:footer');
			}
		}else{
			//根据这个id选出数据
			$sql="select * from ims_customer where id = '{$user_id}'";
			$result=pdo_fetch($sql);
			$reminder='修改';
			include $this->template('scbridge:header');
			include $this->template('scbridge:register');
			include $this->template('scbridge:footer');
		}
		
	}
	
	//会员中心页面加载
	public function domember_center() {
		session_start();
		global $_W,$_GPC;
		$h_id=$_GPC['h_id'];
		//判断是否已经存在此用户
		$oppenid=$_SESSION['sc_user_oppenid'];
		$sql="select * from ims_customer where open_id = '{$oppenid}'";
		$result=pdo_fetch($sql);
		if(empty($result)){
			$title='会员注册';
			$reminder='注册';
			include $this->template('scbridge:header');
			include $this->template('scbridge:register');
			include $this->template('scbridge:header');
		}else{
			$img_url=$_SESSION['sc_user_info']->headimgurl;
			include $this->template('scbridge:member_center');
			include $this->template('scbridge:footer');
		}
	}
	
	//会员注册动作实现
	public function doregisterdo(){
		session_start();
		global $_W,$_GPC;
		//print_r($_POST);
		$lastupdate=time();
		$lastupdate=date('y-m-d h:i:s',$lastupdate);
		$name=$_GPC['user_name'];
		$user_id=$_GPC['user_id'];
		$mobile=$_GPC['user_tel'];
		$open_id=$_SESSION['sc_user_oppenid'];
		if(empty($name)||empty($mobile)){
			echo "<script language='javascript'>history.go(-1);alert('信息输入不能为空.');</script>";
			die();
		}
			
		if(empty($user_id)){
			$sql="insert into ims_customer(name,mobile,open_id,account_balance,status,lastupdate) values('{$name}','{$mobile}','{$open_id}','0','0','{$lastupdate}')";
			if(pdo_query($sql)){
				session_start();
				$oppenid=$_SESSION['sc_user_oppenid'];
				$sql="select * from ims_customer where open_id = '{$oppenid}'";
				$result=pdo_fetch($sql);
				$img_url=$_SESSION['sc_user_info']->headimgurl;
				include $this->template('scbridge:member_center');
			}
		}else{
			//这里是更新
			$sql="update ims_customer set name='{$name}',mobile='{$mobile}',lastupdate='{$lastupdate}'  where id= '{$user_id}'";
			if(pdo_query($sql)){
				$sql="select * from ims_customer where id= '{$user_id}'";
				$result=pdo_fetch($sql);
				$img_url=$_SESSION['sc_user_info']->headimgurl;
				include $this->template('scbridge:member_center');
			}
				
		}	
	}
	
	//会议中心页面加载
	public function domeeting_center(){
		global $_W,$_GPC;
		//这里要选出哪些酒店有会议室，然后列出来
		$sql="select h.name,h.level,h.icon,h.address,h.id  from ims_hotel as h join ims_hotel_room as r on h.id=r.hotel_id where r.is_meeting=1 ";
		$hotels=pdo_fetchall($sql);
		//循环遍历
		for($i=0;$i<count($hotels);$i++){
			$sql="select max(r.max_number) as max_num from  ims_hotel_room as r  where r.hotel_id = ".$hotels[$i]['id']." and r.is_meeting=1";
			$re=pdo_fetch($sql);
			$hotels[$i]['max_num']=$re['max_num'];
			switch ($hotels[$i]['level']){
				case 1:
				$hotel[$i]['level']='准4星';
				break;
			case 2:
				$hotel[$i]['level']='4星';
				break;
			case 3:
				$hotel[$i]['level']='准5星';
				break;
			case 4:
				$hotel[$i]['level']='精品';
				break;
			case 5:
				$hotel[$i]['level']='5星';
				break;
			case 6:
				$hotel[$i]['level']='奢华';
				break;
			}
		}
		$title='会议预定';
		include $this->template('scbridge:header');
		include $this->template('scbridge:meeting-reserve');
		include $this->template('scbridge:footer');
	}
	
	
	

	//加载充值页面
	public function domember_charge(){
		global $_W, $_GPC;
		$user_id=$_GPC['user_id'];
		if(!empty($user_id)){
			$sql="select * from ims_customer where id= '{$user_id}'";
			$result=pdo_fetch($sql);
			$reminder='充值';
			$img_url=$_SESSION['sc_user_info']->headimgurl;
			include $this->template('scbridge:member-pay');
		}
	}
	
	//充值动作执行
	public function dopaydo(){
		global $_W, $_GPC;
		$user_id=$_GPC['user_id'];
		$acc_number=$_POST['acc_number']*10000;
		//还是先查出来数据
		$sql="select * from ims_customer where id= '{$user_id}'";
		$re=pdo_fetch($sql);
		$acc_be=($re['account_balance']);
		$acc_ag=$acc_be+$acc_number;
		//现在插入数据
		$sql="update ims_customer set account_balance='{$acc_ag}',status='1'  where id= '{$user_id}'";
		if(pdo_query($sql)){
			$sql="select * from ims_customer where id= '{$user_id}'";
			$result=pdo_fetch($sql);
			$img_url=$_SESSION['sc_user_info']->headimgurl;
			include $this->template('scbridge:member_center');
			include $this->template('scbridge:footer');
		}
			
		
	}
	
	
	
	//商城导航页面加载
	public function doshop_center(){
		global $_W,$_GPC;
		$title='商城';
		include $this->template('scbridge:header');
		include $this->template('scbridge:store-nav');
		include $this->template('scbridge:footer');
	}
	
	
	//商品s展示页面加载
	public function doshop_list(){
		global $_W,$_GPC;
		$good_type=$_GPC['good_type'];
		$sql="select * from ims_goods where good_type= ".$good_type ." and good_stock > 0";
		$goods=pdo_fetchall($sql);
		switch ($good_type){
			case 1:
				$title='奢侈品';
				break;
			case 2:
				$title='贵金属';
				break;
			case 3:
				$title='当季水果';
				break;
			case 4:
				$title='生活用品';
				break;
			case 5:
				$title='酒水饮品';
				break;
			case 6:
				$title='其它产品';
				break;
		}
		include $this->template('scbridge:store');
		include $this->template('scbridge:footer');
	}
	
	
	//商品详细页面加载
	public function dogoods_content(){
		global $_W,$_GPC;
		$good_id=$_GPC['good_id'];
		$good_type=$_GPC['good_type'];
		$sql="select * from ims_goods where id= ".$good_id;
		$good=pdo_fetch($sql);
		switch ($good_type){
			case 1:
				$title='奢侈品';
				break;
			case 2:
				$title='贵金属';
				break;
			case 3:
				$title='当季水果';
				break;
			case 4:
				$title='生活用品';
				break;
			case 5:
				$title='酒水饮品';
				break;
			case 6:
				$title='其它产品';
				break;
		}
		include $this->template('scbridge:store-goods');
		include $this->template('scbridge:footer');
	}
	
}

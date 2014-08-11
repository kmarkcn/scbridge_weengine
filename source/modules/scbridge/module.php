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

	public function doindex() {
		global $_W, $_GPC;
		include $this->template('scbridge:homepage');
	
	}
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
		//print_r($hotels);
		$title='酒店预订';
		include $this->template('scbridge:header');
		include $this->template('scbridge:member_product');
		include $this->template('scbridge:footer');
	}
	
	public function dohotel_content(){
		global $_W,$_GPC;
		$h_id=$_GPC['h_id'];
		$sql="SELECT * FROM ".tablename('hotel');
		$hotel=pdo_fetch($sql);
		switch ($hotel['level']){
			case 1:
				$hotel['level']='一星级';
				break;
			case 2:
				$hotel['level']='二星级';
				break;
			case 3:
				$hotel['level']='三星级';
				break;
			case 4:
				$hotel['level']='四星级';
				break;
			case 5:
				$hotel['level']='五星级';
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
	
	public function dohotel_booking(){
		global $_W,$_GPC;
		$h_id=$_GPC['id'];
		include $this->template('scbridge:room-reserve');
	}
	
	public function domeeting_booking(){
		global $_W,$_GPC;
		$h_id=$_GPC['id'];
		include $this->template('scbridge:meeting-reserve-write');
	}	
	public function dohotel_contents(){
		global $_W,$_GPC;
		$h_id=$_GPC['h_id'];
		$sql="SELECT * FROM ".tablename('hotel');
		$hotel=pdo_fetch($sql);
		switch ($hotel['level']){
			case 1:
				$hotel['level']='一星级';
				break;
			case 2:
				$hotel['level']='二星级';
				break;
			case 3:
				$hotel['level']='三星级';
				break;
			case 4:
				$hotel['level']='四星级';
				break;
			case 5:
				$hotel['level']='五星级';
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
	
	public function dovip_register(){
		global $_W,$_GPC;
		$h_id=$_GPC['h_id'];
		$title='会员注册';
		include $this->template('scbridge:header');
		include $this->template('scbridge:register');
		include $this->template('scbridge:footer');
	}
	
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
					$hotels[$i]['level']='一星级';
					break;
				case 2:
					$hotels[$i]['level']='二星级';
					break;
				case 3:
					$hotels[$i]['level']='三星级';
					break;
				case 4:
					$hotels[$i]['level']='四星级';
					break;
				case 5:
					$hotels[$i]['level']='五星级';
					break;
			}
		}
		$title='会议预定';
		include $this->template('scbridge:header');
		include $this->template('scbridge:meeting-reserve');
		include $this->template('scbridge:footer');
	}
	
	
	
	public function domember_center() {
		global $_W, $_GPC;
		//$from_user是进入页面后自己做匹配
		$from_user=1;
		if(empty($from_user)){
			$title='会员注册';
			include $this->template('scbridge:header');
			include $this->template('scbridge:register');
			include $this->template('scbridge:header');
		}else{
			include $this->template('scbridge:member_center');
			include $this->template('scbridge:footer');
		}
	}
	
	public function domember_charge(){
		global $_W, $_GPC;
		include $this->template('scbridge:member-pay');
		
	}
	
	
	//商城导航
	public function doshop_center(){
		global $_W,$_GPC;
		$title='商城';
		include $this->template('scbridge:header');
		include $this->template('scbridge:store-nav');
		include $this->template('scbridge:footer');
	}
	
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
				$title='其他产品';
				break;
		}
		include $this->template('scbridge:store');
		include $this->template('scbridge:footer');
	}
	
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
				$title='其他产品';
				break;
		}
		include $this->template('scbridge:store-goods');
		include $this->template('scbridge:footer');
	}
	
}
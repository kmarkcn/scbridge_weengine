<?php
/*
 * by Terry 2014-08-04
 */
defined('IN_IA') or exit('Access Denied');
class ScbridgeModule extends WeModule {
	//定义酒店类型和商品类型
	public $arrBridge = array('1'=>'准4星','2'=>'4星','3'=>'准5星','4'=>'精品','5'=>'5星','6'=>'奢华',);
	public $arrGoods  = array('1'=>'奢侈品','2'=>'贵金属','3'=>'当季水果','4'=>'生活用品','5'=>'酒水饮品','6'=>'其它产品');
	
	public function fieldsFormDisplay($rid = 0) {}
	public function fieldsFormValidate($rid = 0) {return true;}
	public function fieldsFormSubmit($rid = 0) {}
	public function ruleDeleted($rid = 0) {}
	public function doFormDisplay() {}

	//主页的调用
	public function doindex() {
		global $_W, $_GPC;
		include $this->template('scbridge:homepage');
	}
	
	
	//酒店预订产品页面加载
	public function dohotel_center(){
		global $_W, $_GPC;
		$title='酒店预订';
		//取数据
		$hotels = pe_fetchAll('hotel');
		//遍历数组，从数据库中选出此酒店最低的那个产品价格
		for($i=0;$i<count($hotels);$i++){
			$str="min(price_vip) as pri,price_normal";
			$pr=pe_fetchOneByField('hotel_room',$str,'hotel_id',$hotels[$i]['id'],'','');
			$hotels[$i]['price_vip']=$pr['pri'];
			$hotels[$i]['price_normal']=$pr['price_normal'];
		}
		include $this->template('scbridge:header');
		include $this->template('scbridge:member_product');
		include $this->template('scbridge:footer');
	}
	
	
	//酒店详细内容页面加载
	public function dohotel_content(){
		global $_W,$_GPC;
		$title='酒店预订';
		$h_id=$_GPC['h_id'];
		$hotel=pe_fetchOneByField('hotel',"*",'id',$h_id,'','');
		$hotel['level']=pe_switchArr($hotel['level'],$this->arrBridge);
		$str="min(price_vip) as pri,max(price_vip) as pr";
		$ho=pe_fetchOneByField('hotel_room', $str, 'hotel_id', $h_id,'','');
		$hotel['pr_min']=$ho['pri'];
		$hotel['pr_max']=$ho['pr'];
		include $this->template('scbridge:header');
		include $this->template('scbridge:hotel-reserve');
		include $this->template('scbridge:footer');
		
	}
	
	
	
	//酒店预订信息填写页面加载
	public function dohotel_booking(){
		global $_W,$_GPC;
		$h_id=$_GPC['h_id'];
		$oppenid=$_SESSION['sc_user_oppenid'];
		$sql="select * from ims_customer where open_id = '{$oppenid}'";
		$result=pdo_fetch($sql);
		if(!empty($result)){
			$roomType=pe_fetchAllByField('hotel_room','id,name','hotel_id',$h_id,'is_meeting','0');
			include $this->template('scbridge:room-reserve');
		}else{
			$title='会员注册';
			$reminder='注册';
			include $this->template('scbridge:header');
			include $this->template('scbridge:register');
			include $this->template('scbridge:footer');
		}
		
	}
	
	
	//会议中心页面加载
	public function domeeting_center(){
		global $_W,$_GPC;
		$title='会议预定';
		//这里要选出哪些酒店有会议室，然后列出来
		$sql="select h.name,h.level,h.icon,h.address,h.id  from ims_hotel as h";
		$sql.=" join ims_hotel_room as r on h.id=r.hotel_id where r.is_meeting=1";
		$hotels=pdo_fetchall($sql);
		//循环遍历
		for($i=0;$i<count($hotels);$i++){
			$str="max(max_number) as max_num";
			$re=pe_fetchOneByField('hotel_room',$str,'hotel_id',$hotels[$i]['id'],'is_metting','1');
			$hotels[$i]['max_num']=$re['max_num'];
			$hotels[$i]['level']=pe_switchArr($hotels[$i]['level'],$this->arrBridge);
		}
		
		include $this->template('scbridge:header');
		include $this->template('scbridge:meeting-reserve');
		include $this->template('scbridge:footer');
	}
	
	
	//会议预定信息填写页面加载
	public function domeeting_booking(){
		global $_W,$_GPC;
		$h_id=$_GPC['h_id'];
		$oppenid=$_SESSION['sc_user_oppenid'];
		$sql ="select * from ims_customer where open_id = '{$oppenid}'";
		$result = pdo_fetch($sql);
		if(!empty($result)){
			$meetingType=pe_fetchAllByField('hotel_room','name,min_number,max_number,id','hotel_id',$h_id,'is_meeting','1');
			include $this->template('scbridge:meeting-reserve-write');
		}else{
			$title='会员注册';
			$reminder='注册';
			include $this->template('scbridge:header');
			include $this->template('scbridge:register');
			include $this->template('scbridge:footer');
		}
	}	
	
	//会议预定详细页面加载
	public function dohotel_contents(){
		global $_W,$_GPC;
		$title='会议预订';
		$h_id=$_GPC['h_id'];
		$hotel=pe_fetchOneByField('hotel',"*",'id',$h_id,'','');
		$hotel['level']=pe_switchArr($hotel['level'],$this->arrBridge);
		$str_1="min(price_vip) as pri,max(price_normal) as pr";
		$ho_1=pe_fetchOneByField('hotel_room',$str_1,'hotel_id',$h_id,'is_meeting','1');
		$hotel['pr_min']=$ho_1['pri'];
		$hotel['pr_max']=$ho_1['pr'];
		$str_2="min(min_number) as pri,max(max_number) as pr";
		$ho_2=pe_fetchOneByField('hotel_room',$str_2,'hotel_id',$h_id,'is_meeting','1');
		$hotel['num_min']=$ho_2['pri'];
		$hotel['num_max']=$ho_2['pr'];
		
		include $this->template('scbridge:header');
		include $this->template('scbridge:hotel_re');
		include $this->template('scbridge:footer');
	
	}
	
	
	//会员注册页面加载
	public function dovip_register(){
		session_start();
		global $_W,$_GPC;
		$h_id=$_GPC['h_id'];
		$user_id=$_GPC['user_id'];
		$oppenid=$_SESSION['sc_user_oppenid'];
		if(empty($user_id)){
			//判断是否已经存在此用户
			$sql="select * from ims_customer where open_id = {$oppenid}";
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
			$sql ="select * from ims_customer where open_id = '{$oppenid}'";
		    $result = pdo_fetch($sql);
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
		//echo($oppenid);
		$sql ="select * from ims_customer where open_id = {$oppenid}";
		$result = pdo_fetch($sql);
	   if(empty($result)){
			$title='会员注册';
			$reminder='注册';
			include $this->template('scbridge:header');
			include $this->template('scbridge:register');
			include $this->template('scbridge:header');
		}else{
		    //根据会员选择订单
		    $sql = "select * from ims_hotel_booking where customer_id = {$result['id']}";
		    $booking1 = pdo_fetchall($sql);
		    foreach ($booking1 as $key => $val)
		    {
		    	$sql =" select * from ims_hotel_room where id = {$val['room_id']}";
		    	$roomMsg = pdo_fetch($sql);
		    	$booking1[$key]['name'] = $roomMsg['name'];
		    	$booking1[$key]['img'] = $roomMsg['icon'];
		    	$booking1[$key]['hotel'] = $roomMsg['hotel_id'];
		    }
		    $sql ="select * from ims_goods_booking where customer_id = {$result['id']}";
		    $booking2 = pdo_fetchall($sql);
		    foreach ($booking2 as $key => $val)
		    {
		        $sql =" select * from ims_goods where id = {$val['goods_id']}";
		        $goodsMsg = pdo_fetch($sql);
		        $booking2[$key]['name'] = $goodsMsg['name'];
		        $booking2[$key]['img'] = $goodsMsg['icon'];
		        $booking2[$key]['goods'] = $goodsMsg['id'];
		        $booking2[$key]['dis'] = $goodsMsg['brief_intro'];
		    }
		    $img_url=$_SESSION['sc_user_info']->headimgurl;
		    //print_r($booking2);
			include $this->template('scbridge:member_center');
			include $this->template('scbridge:footer');
		}
	}
	
	
	//会员注册动作实现
	public function doregisterdo(){
		session_start();
		global $_W,$_GPC;
		$lastupdate=time();
		$lastupdate=date('y-m-d h:i:s',$lastupdate);
		$name=$_GPC['user_name'];
		$user_id=$_GPC['user_id'];
		$mobile=$_GPC['user_tel'];
		$oppenid=$_SESSION['sc_user_oppenid'];
		
		if(empty($name)||empty($mobile)){
			echo "<script language='javascript'>history.go(-1);alert('信息输入不能为空.');</script>";
			die();
		}
			
		if(empty($user_id)){
			$data=array(
				'name'=>$name,
				'mobile'=>$mobile,
				'open_id'=>$oppenid,
				'account_balance'=>'0',
				'status'=>'0',
				'lastupdate'=>$lastupdate
			);
			if(pdo_insert('customer', $data)){
				session_start();
				$sql ="select * from ims_customer where id = '{$user_id}'";
			    $result = pdo_fetch($sql);
				$img_url=$_SESSION['sc_user_info']->headimgurl;
				include $this->template('scbridge:member_center');
			}
		}else{
			//这里是更新
			$data=array(
					'name'=>$name,
					'mobile'=>$mobile,
					'lastupdate'=>$lastupdate
			);
			if(pdo_update('customer', $data, array('id' =>$user_id))){
			    $sql ="select * from ims_customer where id = '{$user_id}'";
			    $result = pdo_fetch($sql);
				$img_url=$_SESSION['sc_user_info']->headimgurl;
				include $this->template('scbridge:member_center');
			}
			
			
		}	
		
	}
	

	//加载充值页面
	public function domember_charge(){
		global $_W, $_GPC;
		$user_id=$_GPC['user_id'];
		if(!empty($user_id)){
		    $sql ="select * from ims_customer where id = '{$user_id}'";
		    $result = pdo_fetch($sql);
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
		$oppenid=$_SESSION['sc_user_oppenid'];
		//还是先查出来数据
		$sql="select * from ims_customer where id= '{$user_id}'";
		$re=pdo_fetch($sql);
		$acc_be=($re['account_balance']);
		$acc_ag=$acc_be+$acc_number;
		//现在插入数据
		$data=array(
			'account_balance'=>$acc_ag,
			'status'=>'1'
		);
		if(pdo_update('customer',$data, array('id' =>$user_id))){
			$result=pe_fetchOneByField('customer',"*",'open_id',$oppenid,'','');
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
	
	
	//商品展示页面加载
	public function doshop_list(){
		global $_W,$_GPC;
		$good_type=$_GPC['good_type'];
		$sql="select * from ims_goods where good_type= ".$good_type ." and good_stock > 0";
		$goods=pdo_fetchall($sql);
		$title=pe_switchArr($good_type,$this->arrGoods);
		include $this->template('scbridge:store');
		include $this->template('scbridge:footer');
	}
	
	
	//商品详细页面加载
	public function dogoods_content(){
		global $_W,$_GPC;
		$good_id=$_GPC['good_id'];
		$good_type=$_GPC['good_type'];
		$good=pe_fetchOneByField("goods","*",'id',$good_id,'','');
		$title=pe_switchArr($good_type,$this->arrGoods);
		include $this->template('scbridge:store-goods');
		include $this->template('scbridge:footer');
	}
	
	//商品购买信息填写页面
	public function dogoods_booking()
	{
	    global $_W,$_GPC;
	    $g_id=$_GPC['g_id'];
	    $oppenid=$_SESSION['sc_user_oppenid'];
	    $sql ="select * from ims_customer where open_id = '{$oppenid}'";
	    $result = pdo_fetch($sql);
	    if(!empty($result)){
            include $this->template('scbridge:store-reserve-write');
	    }else{
	        $title='会员注册';
	        $reminder='注册';
	        include $this->template('scbridge:header');
	        include $this->template('scbridge:register');
	        include $this->template('scbridge:footer');
	    }
	}
	
	
	//酒店确定支付信息函数
	public function doreserveDo()
	{
		global $_W,$_GPC;
		$open_id = $_SESSION['sc_user_oppenid'];
		$hotel_id = $_POST["hotelId"];
		$roomId = $_POST["roomType"];
		$startDate = $_POST["startDate"];
		$endDate = $_POST["endDate"];
		$customerName = $_POST['customerName'];
		$customerTel = $_POST["customerTel"];
		$remark = $_POST['remark'];
		$reserveType = $_POST['reserveType'];
		$goods_id = $_POST["goodsId"];
		$goodsNumber = $_POST["goodsNumber"];
		$address = $_POST["address"];
		$roomsNumber =$_POST['roomsNumber'];
		
		if($reserveType == "normalRoom")
		{
		    //先判断是否为空
		    if(empty($startDate)||empty($endDate)||empty($customerName)||empty($customerTel))
		    {
		        echo "<script>alert('信息输入不完整');window.history.back(-1);</script>";
		    }
		    else
		    {
		        
		        if(strtotime($startDate)<time() || strtotime($endDate)<time() || strtotime($startDate) > strtotime($endDate))
		        {
		                echo "<script>alert('预订时间不正确');window.history.back(-1);</script>";
		                die();
		        }
		        else
		        {
		            //先根据数据选出支付的钱和会员余额
		            $sql ="select * from ims_customer where open_id = '{$open_id}'";
		            $customerMsg = pdo_fetch($sql);
		            //print_r($customerMsg);
		            $balanceMoney = $customerMsg['account_balance'];
		            $customerId = $customerMsg['id'];
		            $roomMsg = pe_fetchOneByField("hotel_room","*","id",$roomId,"","");
		            $days = ((strtotime($endDate)-strtotime($startDate))/(3600*24))+1;
		            $needMoney = $roomMsg['price_vip'] * $roomsNumber * $days;
		            $mMoney = md5($needMoney);
		            $_SESSION["sc_customer_need_money"] = $needMoney;
		            $bMoney = md5($balanceMoney);
		            $_SESSION["sc_customer_balance_money"] = $balanceMoney;
		            $_SESSION["sc_customer_hotels_number"] =  $roomsNumber;
		            $payThing = "room";
		            include $this->template("scbridge:select-pay");
		        }
		    }
		}
		else if($reserveType == "meetingRoom")
		{
		    //print_r($_POST);
		    //先判断是否为空
		    if(empty($startDate)||empty($endDate)||empty($customerName)||empty($customerTel))
		    {
		        echo "<script>alert('信息输入不完整');window.history.back(-1);</script>";
		        die();
		    }
             else 
		    {
                if(strtotime($startDate)<time()|| strtotime($endDate)<time() || strtotime($startDate) > strtotime($endDate))
                {
                	echo "<script>alert('预订时间不正确');window.history.back(-1);</script>";
		            die();
                }
                else
                {
                    //先根据数据选出支付的钱和会员余额
                    $sql ="select * from ims_customer where open_id = '{$open_id}'";
                    $customerMsg = pdo_fetch($sql);
                    $balanceMoney = $customerMsg['account_balance'];
                    $customerId = $customerMsg['id'];
                    $roomMsg = pe_fetchOneByField("hotel_room","*","id",$roomId,"","");
                    $days = ((strtotime($endDate)-strtotime($startDate))/(3600*24))+1;
                    $needMoney = $roomMsg['price_vip'] * $roomsNumber * $days;
                    $mMoney = md5($needMoney);
                    $_SESSION["sc_customer_need_money"] = $needMoney;
                    $bMoney = md5($balanceMoney);
                    $_SESSION["sc_customer_balance_money"] = $balanceMoney;
                    $_SESSION["sc_customer_hotels_number"] =  $roomsNumber;
                    $payThing = "room";
                    include $this->template("scbridge:select-pay");
                }
		    }
		}else if($reserveType == "goodsRes")
		{
			//先判断是否为空
		//先判断是否为空
		    if(empty($address)||empty($customerName)||empty($customerTel))
		    {
		        echo "<script>alert('信息输入不完整');window.history.back(-1);</script>";
		    }
		    else
		    {
		    	//选择数量
		    	$result = pe_fetchOneByField("goods","*","id",$goods_id);
		    	if($result['good_stock']>=$goodsNumber)
		    	{
		    	    //加载确定支付页面
		    	    //先根据数据选出支付的钱和会员余额
		    	    $sql ="select * from ims_customer where open_id = '{$open_id}'";
		    	    $customerMsg = pdo_fetch($sql);
		    	    $balanceMoney = $customerMsg['account_balance'];
		    	    $customerId = $customerMsg['id'];
		    	    $goodsMsg = pe_fetchOneByField("goods","*","id",$goods_id,"","");
		    	    $needMoney = $goodsMsg['price']* $goodsNumber;
		    	    $mMoney = md5($needMoney);
		    	    $_SESSION["sc_customer_need_money"] = $needMoney;
		    	    $_SESSION["sc_customer_goods_number"] =  $goodsNumber;
		    	    $bMoney = md5($balanceMoney);
		    	    $_SESSION["sc_customer_balance_money"] = $balanceMoney;
		    	    $payThing = "goods";
		    	    include $this->template("scbridge:select-pay");
		    	}else
		    	{
		    	    echo "<script>alert('库存数量不够!');window.history.back(-1);</script>";
		    	}
		    	
		    }
		}
		
		
		
	}
	
	
	
	
	//支付函数
	public function docustomerPay()
	{
	    global $_W,$_GPC;
	    $hotel_id = $_POST["hotelId"];
	    $roomId = $_POST["roomId"];
	    $startDate = $_POST["startDate"];
	    $endDate = $_POST["endDate"];
	    $customerName = $_POST['customerName'];
	    $customerTel = $_POST["customerTel"];
	    $needMoney = $_POST['needMoney'];
	    $balanceMoney = $_POST['balanceMoney'];
	    $customerId = $_POST['customerId'];
	    $remark = $_POST['remark'];
	    $payTh = $_POST["payThing"];
	    $goods_id = $_POST["goods_id"];
	    $goodsNumber = $_SESSION["sc_customer_goods_number"];
	    $address = $_POST["address"];
	    $roomsNumber = $_SESSION["sc_customer_hotels_number"];
	    
	    if($payTh == 'room')
	    {
	        //判断金额是否正确
	        if(($needMoney == md5($_SESSION["sc_customer_need_money"])) &&
	                ($balanceMoney == md5($_SESSION["sc_customer_balance_money"])))
	        {
	            //判断余额是否充足
	            if($_SESSION["sc_customer_need_money"] <= $_SESSION["sc_customer_balance_money"])
	            {
	                //写入数据库
	                $lastupdate=time();
	                $lastupdate=date('y-m-d h:i:s',$lastupdate);
	                $data = array(
	                        "customer_id" => $customerId,
	                        "room_id" =>  $roomId,
	                        "start_date" => $startDate,
	                        "end_date" => $endDate,
	                        "total_price"=>$_SESSION["sc_customer_need_money"],
	                        "remarks"=>$remark,
	                        "status" =>"0",
	                        'lastupdate'=>$lastupdate,
	                        "hotels_account"=>$roomsNumber
	                );
	                if(pdo_insert('hotel_booking',$data))
	                {
	                    //余额减少
	                    $acc_ag = $_SESSION["sc_customer_balance_money"]
	                    - $_SESSION["sc_customer_need_money"];
	                    $data=array(
	                            'account_balance'=>$acc_ag,
	                            'status'=>'1'
	                    );
	                    pdo_update('customer',$data, array('id' =>$customerId));
	                    include $this->template("scbridge:success-reserve");
	                }
	                else
	                {
	                    include $this->template("scbridge:failure-pay");
	                }
	                 
	            }
	            else
	            {
	                include $this->template("scbridge:failure-money");
	            }
	        }
	        else
	        {
	            include $this->template("scbridge:failure-pay");
	    
	        }
	    }
	    else if($payTh == "goods")
	    {
	     	//这里是商品预订流程
	       //判断金额是否正确
    	    if(($needMoney == md5($_SESSION["sc_customer_need_money"])) && 
    	              ($balanceMoney == md5($_SESSION["sc_customer_balance_money"])))
    	    {
    	     	//判断余额是否充足
    	     	 if($_SESSION["sc_customer_need_money"] <= $_SESSION["sc_customer_balance_money"])
    	     	 {
    	     	     //写入数据库
    	     	     $lastupdate=time();
    	     	     $lastupdate=date('y-m-d h:i:s',$lastupdate);
    	     	     $data = array(
    	     	     	"customer_id" => $customerId,
    	     	        "goods_number" => $goodsNumber ,
    	     	        "goods_id"=>$goods_id,
    	     	        "total_price"=>$_SESSION["sc_customer_need_money"],    
    	     	        "status" =>"0",
    	     	        "address" => $address,    
    	     	        'lastupdate'=>$lastupdate   
    	     	     );
    	     	     if(pdo_insert('goods_booking',$data))
    	     	     {
    	     	         //余额减少
    	     	         $acc_ag = $_SESSION["sc_customer_balance_money"]
    	     	                 - $_SESSION["sc_customer_need_money"];
    	     	         $data=array(
    	     	                 'account_balance'=>$acc_ag,
    	     	                 'status'=>'1'
    	     	         );
    	     	         pdo_update('customer',$data, array('id' =>$customerId));
    	     	         //减少库存数量
    	     	         $goodsMsg = pe_fetchOneByField("goods","*","id",$goods_id,"","");
    	     	         $goodsNum = $goodsMsg['good_stock'] -  $_SESSION["sc_customer_goods_number"];
    	     	         $data=array(
    	     	                 'good_stock'=>$goodsNum
    	     	         );
    	     	         pdo_update('goods',$data, array('id' =>$goods_id));
    	     	         include $this->template("scbridge:success-reserve");  
    	     	     }
    	     	     else
    	     	     {
    	     	         include $this->template("scbridge:failure-pay");
    	     	     }
    	     	    
    	     	 }
    	     	 else
    	     	 {
    	     	    include $this->template("scbridge:failure-money");
    	     	 } 
    	    }
    	    else 
    	    {
    	    	include $this->template("scbridge:failure-pay");
    	    }    
    	        
	        
	    }
	}

	
	public function doroom_cancel(){
	    global $_W,$_GPC;
	    $bookingId = $_GPC['bookingid'];
	    $type = $_GPC['type'];
	    if(!empty($bookingId) && $type == 'hotel'){
	    	//现在先先判定时间是否过期
	    	$sql ="select * from ims_hotel_booking where id = {$bookingId}";
	        $bookingMsg = pdo_fetch($sql);
	        if(strtotime($bookingMsg['lastupdate']) < (time()-(2*3600))){
	            include $this->template("scbridge:failure-cancel");
	        }
	        else {
	        	//这里是取消动作执行
	        	//首先找到订单的价格，还原价格
	            $oppenid=$_SESSION['sc_user_oppenid'];
	            $sql ="select * from ims_customer where open_id = '{$oppenid}'";
	            $re = pdo_fetch($sql);
	            $acc_be=($re['account_balance']);
	            $acc_ag=$acc_be+$bookingMsg['total_price'];
	            //现在插入数据
	            $data=array(
	                    'account_balance'=>$acc_ag,
	                    'status'=>'1'
	            );
	            if(pdo_update('customer',$data, array('open_id' =>$oppenid))){
	                //删除这条订单
	                pdo_delete("hotel_booking",array('id'=>$bookingId ));
	                include $this->template("scbridge:success-cancel");
	            }
	        }
	    }
	}
	
	
}

<?php
/*
 * by Terry 2014-08-04
 */
require 'pm/class.phpmailer.php';
require 'pm/class.smtp.php';
require 'wxpay/WxPayHelper.php';

defined('IN_IA') or exit('Access Denied');

class ScbridgeModule extends WeModule
{
    // 定义酒店类型和商品类型
    public $arrBridge = array(
        '1' => '4星',
        '2' => '精品',
        '3' => '5星',
        '4' => '奢华'
    );

    public $arrGoods = array(
        '1' => '奢侈品',
        '2' => '贵金属',
        '3' => '当季水果',
        '4' => '生活用品',
        '5' => '酒水饮品',
        '6' => '其它产品'
    );

    public function fieldsFormDisplay($rid = 0)
    {}

    public function fieldsFormValidate($rid = 0)
    {
        return true;
    }

    public function fieldsFormSubmit($rid = 0)
    {}

    public function ruleDeleted($rid = 0)
    {}

    public function doFormDisplay()
    {}
    
    // 主页的调用
    public function doindex()
    {
        global $_W, $_GPC;
        include $this->template('scbridge:homepage');
    }
    
    // 酒店预订产品页面加载
    public function dohotel_center()
    {
        global $_W, $_GPC;
        $select_type = $_GPC['select_type'];
        $region = $_GPC['region'];
        $level = $_GPC['level'];
        if (empty($select_type)) {
            // 取数据
            $hotels = pe_fetchAll('hotel');
            // 遍历数组，从数据库中选出此酒店最低的那个产品价格
        } else 
            if ($select_type == 'normalRoom') {
                if ($region > 0 && $level == 0) {
                    $sql = "select * from ims_hotel where region = {$region}";
                    $hotels = pdo_fetchall($sql);
                } else 
                    if ($region == 0 && $level > 0) {
                        $sql = "select * from ims_hotel where level = {$level}";
                        $hotels = pdo_fetchall($sql);
                    } else 
                        if ($region > 0 && $level > 0) {
                            $sql = "select * from ims_hotel where level = {$level} and region = {$region}";
                            $hotels = pdo_fetchall($sql);
                        } else {
                            $hotels = pe_fetchAll('hotel');
                        }
            }
        $title = '酒店预订';
        for ($i = 0; $i < count($hotels); $i ++) {
            $str = "min(price_vip) as pri,price_normal";
            $pr = pe_fetchOneByField('hotel_room', $str, 'hotel_id', $hotels[$i]['id'], '', '');
            $hotels[$i]['price_vip'] = $pr['pri'];
            $hotels[$i]['price_normal'] = $pr['price_normal'];
        }
        include $this->template('scbridge:header');
        include $this->template('scbridge:member_product');
        include $this->template('scbridge:footer');
    }
    
    // 酒店详细内容页面加载
    public function dohotel_content()
    {
        global $_W, $_GPC;
        $title = '酒店预订';
        $h_id = $_GPC['h_id'];
        $hotel = pe_fetchOneByField('hotel', "*", 'id', $h_id, '', '');
        $hotel['level'] = pe_switchArr($hotel['level'], $this->arrBridge);
        $str = "min(price_vip) as pri,max(price_vip) as pr";
        $ho = pe_fetchOneByField('hotel_room', $str, 'hotel_id', $h_id, '', '');
        $hotel['pr_min'] = $ho['pri'];
        $hotel['pr_max'] = $ho['pr'];
        include $this->template('scbridge:header');
        include $this->template('scbridge:hotel-reserve');
        include $this->template('scbridge:footer');
    }
    
    // 酒店预订信息填写页面加载
    public function dohotel_booking()
    {
        global $_W, $_GPC;
        $h_id = $_GPC['h_id'];
        $oppenid = $_SESSION['sc_user_oppenid'];
        $sql = "select * from ims_customer where open_id = '{$oppenid}'";
        $result = pdo_fetch($sql);
        if (! empty($result)) {
            $roomType = pe_fetchAllByField('hotel_room', 'id,name,price_vip', 'hotel_id', $h_id, 'is_meeting', '0');
            // print_r($roomType);
            include $this->template('scbridge:room-reserve');
        } else {
            $title = '会员注册';
            $reminder = '注册';
            include $this->template('scbridge:header');
            include $this->template('scbridge:register');
            include $this->template('scbridge:footer');
        }
    }
    
    // 会议中心页面加载
    public function domeeting_center()
    {
        global $_W, $_GPC;
        $title = '会议预定';
        // 这里要选出哪些酒店有会议室，然后列出来
        $select_type = $_GPC['select_type'];
        $region = $_GPC['region'];
        $min_number = $_GPC['min_number'];
        if (empty($select_type)) {
            // 取数据
            $sql = "select h.name,h.level,h.icon,h.address,h.id  from ims_hotel as h";
            $sql .= " join ims_hotel_room as r on h.id=r.hotel_id where r.is_meeting=1";
            $hotels = pdo_fetchall($sql);
        } else 
            if ($select_type == 'meetingRoom') {
                if ($region > 0 && $min_number == 0) {
                    $sql = "select h.name,h.level,h.icon,h.address,h.id  from ims_hotel as h";
                    $sql .= " join ims_hotel_room as r on h.id=r.hotel_id where r.is_meeting=1 and h.region = {$region}";
                    $hotels = pdo_fetchall($sql);
                } else 
                    if ($region == 0 && $min_number > 0) {
                        $sql = "select h.name,h.level,h.icon,h.address,h.id  from ims_hotel as h";
                        $sql .= " join ims_hotel_room as r on h.id=r.hotel_id where r.is_meeting=1";
                        $hotels = pdo_fetchall($sql);
                        // 选出所有的酒店的房间的最小容纳人数
                        for ($i = 0; $i < count($hotels); $i ++) {
                            $str = "min(min_number) as min_num";
                            $re = pe_fetchOneByField('hotel_room', $str, 'hotel_id', $hotels[$i]['id'], 'is_meeting', '1');
                            $hotels[$i]['min_num'] = $re['min_num'];
                            $hotels[$i]['level'] = pe_switchArr($hotels[$i]['level'], $this->arrBridge);
                            // 这里要决定要不要保留这个
                            if ($hotels[$i]['min_num'] < $min_number) {
                                unset($hotels[$i]);
                            }
                        }
                    } else 
                        if ($region > 0 && $min_number > 0) {
                            $sql = "select h.name,h.level,h.icon,h.address,h.id  from ims_hotel as h";
                            $sql .= " join ims_hotel_room as r on h.id=r.hotel_id where r.is_meeting=1 and h.region = {$region} ";
                            $hotels = pdo_fetchall($sql);
                            // 选出所有的酒店的房间的最小容纳人数
                            for ($i = 0; $i < count($hotels); $i ++) {
                                $str = "min(min_number) as min_num";
                                $re = pe_fetchOneByField('hotel_room', $str, 'hotel_id', $hotels[$i]['id'], 'is_meeting', '1');
                                $hotels[$i]['min_num'] = $re['min_num'];
                                $hotels[$i]['level'] = pe_switchArr($hotels[$i]['level'], $this->arrBridge);
                                // 这里要决定要不要保留这个
                                if ($hotels[$i]['min_num'] < $min_number) {
                                    unset($hotels[$i]);
                                }
                            }
                        } else {
                            $sql = "select h.name,h.level,h.icon,h.address,h.id  from ims_hotel as h";
                            $sql .= " join ims_hotel_room as r on h.id=r.hotel_id where r.is_meeting=1";
                            $hotels = pdo_fetchall($sql);
                        }
            }
        
        // 循环遍历
        for ($i = 0; $i < count($hotels); $i ++) {
            $str = "max(max_number) as max_num";
            $re = pe_fetchOneByField('hotel_room', $str, 'hotel_id', $hotels[$i]['id'], 'is_meeting', '1');
            // print_r($re);
            $hotels[$i]['max_num'] = $re['max_num'];
            $hotels[$i]['level'] = pe_switchArr($hotels[$i]['level'], $this->arrBridge);
        }
        include $this->template('scbridge:header');
        include $this->template('scbridge:meeting-reserve');
        include $this->template('scbridge:footer');
        // print_r($hotels);
    }
    
    // 会议预定信息填写页面加载
    public function domeeting_booking()
    {
        global $_W, $_GPC;
        $h_id = $_GPC['h_id'];
        $oppenid = $_SESSION['sc_user_oppenid'];
        $sql = "select * from ims_customer where open_id = '{$oppenid}'";
        $result = pdo_fetch($sql);
        if (! empty($result)) {
            $meetingType = pe_fetchAllByField('hotel_room', 'name,min_number,max_number,id', 'hotel_id', $h_id, 'is_meeting', '1');
            include $this->template('scbridge:meeting-reserve-write');
        } else {
            $title = '会员注册';
            $reminder = '注册';
            include $this->template('scbridge:header');
            include $this->template('scbridge:register');
            include $this->template('scbridge:footer');
        }
    }
    
    // 会议预定详细页面加载
    public function dohotel_contents()
    {
        global $_W, $_GPC;
        $title = '会议预订';
        $h_id = $_GPC['h_id'];
        $hotel = pe_fetchOneByField('hotel', "*", 'id', $h_id, '', '');
        $hotel['level'] = pe_switchArr($hotel['level'], $this->arrBridge);
        $str_1 = "min(price_vip) as pri,max(price_normal) as pr";
        $ho_1 = pe_fetchOneByField('hotel_room', $str_1, 'hotel_id', $h_id, 'is_meeting', '1');
        $hotel['pr_min'] = $ho_1['pri'];
        $hotel['pr_max'] = $ho_1['pr'];
        $str_2 = "min(min_number) as pri,max(max_number) as pr";
        $ho_2 = pe_fetchOneByField('hotel_room', $str_2, 'hotel_id', $h_id, 'is_meeting', '1');
        $hotel['num_min'] = $ho_2['pri'];
        $hotel['num_max'] = $ho_2['pr'];
        
        include $this->template('scbridge:header');
        include $this->template('scbridge:hotel_re');
        include $this->template('scbridge:footer');
    }
    
    // 会员注册页面加载
    public function dovip_register()
    {
        session_start();
        global $_W, $_GPC;
        $h_id = $_GPC['h_id'];
        // 判断是否已经存在此用户
        $oppenid = $_SESSION['sc_user_oppenid'];
        $sql = "select * from ims_customer where open_id = '{$oppenid}'";
        $result = pdo_fetch($sql);
        if (! empty($result)) {
            // 根据会员选择订单
            $sql = "select * from ims_hotel_booking where customer_id = {$result['id']}";
            $booking1 = pdo_fetchall($sql);
            foreach ($booking1 as $key => $val) {
                $sql = " select * from ims_hotel_room where id = {$val['room_id']}";
                $roomMsg = pdo_fetch($sql);
                $booking1[$key]['name'] = $roomMsg['name'];
                $booking1[$key]['img'] = $roomMsg['icon'];
                $booking1[$key]['hotel'] = $roomMsg['hotel_id'];
            }
            $sql = "select * from ims_goods_booking where customer_id = {$result['id']}";
            $booking2 = pdo_fetchall($sql);
            foreach ($booking2 as $key => $val) {
                $sql = " select * from ims_goods where id = {$val['goods_id']}";
                $goodsMsg = pdo_fetch($sql);
                $booking2[$key]['name'] = $goodsMsg['name'];
                $booking2[$key]['img'] = $goodsMsg['icon'];
                $booking2[$key]['goods'] = $goodsMsg['id'];
                $booking2[$key]['dis'] = $goodsMsg['brief_intro'];
            }
            $img_url = $_SESSION['sc_user_info']->headimgurl;
            // print_r($booking2);
            include $this->template('scbridge:member_center');
            include $this->template('scbridge:footer');
        } else {
            $title = '会员注册';
            $reminder = '注册';
            include $this->template('scbridge:header');
            include $this->template('scbridge:register');
            include $this->template('scbridge:footer');
        }
    }
    
    // 会员修改信息页面加载
    public function doreset_msg()
    {
        session_start();
        global $_W, $_GPC;
        $u_id = $_GPC['user_id'];
        $sql = "select * from ims_customer where id = {$u_id}";
        $result = pdo_fetch($sql);
        $title = '会员注册';
        $reminder = '修改';
        include $this->template('scbridge:header');
        include $this->template('scbridge:register');
        include $this->template('scbridge:footer');
    }
    
    // 会员中心页面加载
    public function domember_center()
    {
        session_start();
        global $_W, $_GPC;
        $h_id = $_GPC['h_id'];
        // 判断是否已经存在此用户
        $oppenid = $_SESSION['sc_user_oppenid'];
        $sql = "select * from ims_customer where open_id = '{$oppenid}'";
        $result = pdo_fetch($sql);
        // print_r($oppenid);
        if (empty($result)) {
            $title = '会员注册';
            $reminder = '注册';
            include $this->template('scbridge:header');
            include $this->template('scbridge:register');
            include $this->template('scbridge:header');
        } else {
            // 根据会员选择订单
            $sql = "select * from ims_hotel_booking where customer_id = {$result['id']} order by id desc";
            $booking1 = pdo_fetchall($sql);
            foreach ($booking1 as $key => $val) {
                $sql = " select * from ims_hotel_room where id = {$val['room_id']}";
                $roomMsg = pdo_fetch($sql);
                $booking1[$key]['name'] = $roomMsg['name'];
                $booking1[$key]['img'] = $roomMsg['icon'];
                $booking1[$key]['hotel'] = $roomMsg['hotel_id'];
            }
            $sql = "select * from ims_goods_booking where customer_id = {$result['id']}";
            $booking2 = pdo_fetchall($sql);
            foreach ($booking2 as $key => $val) {
                $sql = " select * from ims_goods where id = {$val['goods_id']}";
                $goodsMsg = pdo_fetch($sql);
                $booking2[$key]['name'] = $goodsMsg['name'];
                $booking2[$key]['img'] = $goodsMsg['icon'];
                $booking2[$key]['goods'] = $goodsMsg['id'];
                $booking2[$key]['dis'] = $goodsMsg['brief_intro'];
            }
            $img_url = $_SESSION['sc_user_info']->headimgurl;
            // print_r($booking2);
            include $this->template('scbridge:member_center');
            include $this->template('scbridge:footer');
        }
    }
    
    // 会员注册动作实现
    public function doregisterdo()
    {
        session_start();
        global $_W, $_GPC;
        $lastupdate = time();
        $lastupdate = date('y-m-d h:i:s', $lastupdate);
        $name = $_GPC['user_name'];
        $user_id = $_GPC['user_id'];
        $mobile = $_GPC['user_tel'];
        $email = $_GPC['user_email'];
        $oppenid = $_SESSION['sc_user_oppenid'];
        
        if (empty($name) || empty($mobile)) {
            echo "<script language='javascript'>history.go(-1);alert('信息输入不能为空.');</script>";
            die();
        }
        // 进行正则匹配
        $rule = "/^((13[0-9])|147|(15[0-35-9])|180|182|(18[5-9]))[0-9]{8}$/A";
        if (! preg_match($rule, $mobile)) {
            echo "<script language='javascript'>history.go(-1);alert('手机号码不正确');</script>";
            die();
        }
        ;
        if (! empty($email)) {
            $zhengze = '/^[a-zA-Z0-9][a-zA-Z0-9._-]*\@[a-zA-Z0-9]+\.[a-zA-Z0-9\.]+$/A';
            if (! preg_match($zhengze, $email)) {
                echo "<script language='javascript'>history.go(-1);alert('邮箱格式不正确');</script>";
                die();
            }
        }
        
        if (empty($user_id)) {
            $data = array(
                'name' => $name,
                'mobile' => $mobile,
                'email' => $email,
                'open_id' => $oppenid,
                'account_balance' => '0',
                'status' => '0',
                'lastupdate' => $lastupdate
            );
            if (pdo_insert('customer', $data)) {
                $oppenid = $_SESSION['sc_user_oppenid'];
                $sql = "select * from ims_customer where open_id = '{$oppenid}'";
                $result = pdo_fetch($sql);
                $img_url = $_SESSION['sc_user_info']->headimgurl;
                include $this->template('scbridge:member_center');
                include $this->template('scbridge:footer');
            }
        } else {
            
            // 这里是更新
            $data = array(
                'name' => $name,
                'mobile' => $mobile,
                'email' => $email,
                'lastupdate' => $lastupdate
            );
            if (pdo_update('customer', $data, array(
                'id' => $user_id
            ))) {
                $oppenid = $_SESSION['sc_user_oppenid'];
                $sql = "select * from ims_customer where open_id = '{$oppenid}'";
                $result = pdo_fetch($sql);
                // 根据会员选择订单
                $sql = "select * from ims_hotel_booking where customer_id = {$result['id']} order by id desc";
                $booking1 = pdo_fetchall($sql);
                foreach ($booking1 as $key => $val) {
                    $sql = " select * from ims_hotel_room where id = {$val['room_id']}";
                    $roomMsg = pdo_fetch($sql);
                    $booking1[$key]['name'] = $roomMsg['name'];
                    $booking1[$key]['img'] = $roomMsg['icon'];
                    $booking1[$key]['hotel'] = $roomMsg['hotel_id'];
                }
                $sql = "select * from ims_goods_booking where customer_id = {$result['id']}";
                $booking2 = pdo_fetchall($sql);
                foreach ($booking2 as $key => $val) {
                    $sql = " select * from ims_goods where id = {$val['goods_id']}";
                    $goodsMsg = pdo_fetch($sql);
                    $booking2[$key]['name'] = $goodsMsg['name'];
                    $booking2[$key]['img'] = $goodsMsg['icon'];
                    $booking2[$key]['goods'] = $goodsMsg['id'];
                    $booking2[$key]['dis'] = $goodsMsg['brief_intro'];
                }
                $img_url = $_SESSION['sc_user_info']->headimgurl;
                // print_r($booking2);
                include $this->template('scbridge:member_center');
                include $this->template('scbridge:footer');
            }
        }
    }
    
    // 加载充值页面
    public function domember_charge()
    {
        // 加载支付文件
        global $_W, $_GPC;
        $user_id = $_GPC['user_id'];
        if (! empty($user_id)) {
            $sql = "select * from ims_customer where id = '{$user_id}'";
            $result = pdo_fetch($sql);
            $reminder = '确定';
            //这里是添加支付内容
            $img_url = $_SESSION['sc_user_info']->headimgurl;
            include $this->template('scbridge:member-pay');
        }
    }
    
    public function dopayresult(){
    	$this->dopaydo($_SESSION['sc_acc_number']);
    }
    
    // 充值动作执行
    public function dopaydo($acc_number)
    {
    	global $_W, $_GPC;
    	$acc_number = $acc_number;
    	$oppenid = $_SESSION['sc_user_oppenid'];
    	$sql = "select * from ims_customer where open_id = '{$oppenid}'";
    	$result = pdo_fetch($sql);
        $user_id = $result['id'];
        $oppenid = $_SESSION['sc_user_oppenid'];
        // 还是先查出来数据
        $sql = "select * from ims_customer where id= '{$user_id}'";
        $re = pdo_fetch($sql);
        $acc_be = ($re['account_balance']);
        $acc_ag = $acc_be + $acc_number;
        // 现在插入数据
        $data = array(
            'account_balance' => $acc_ag,
            'status' => '1'
        );
        if (pdo_update('customer', $data, array(
            'id' => $user_id
        ))) {
            $oppenid = $_SESSION['sc_user_oppenid'];
            $sql = "select * from ims_customer where open_id = '{$oppenid}'";
            $result = pdo_fetch($sql);
            
            // 根据会员选择订单
            $sql = "select * from ims_hotel_booking where customer_id = {$result['id']} order by id desc";
            $booking1 = pdo_fetchall($sql);
            foreach ($booking1 as $key => $val) {
                $sql = " select * from ims_hotel_room where id = {$val['room_id']}";
                $roomMsg = pdo_fetch($sql);
                $booking1[$key]['name'] = $roomMsg['name'];
                $booking1[$key]['img'] = $roomMsg['icon'];
                $booking1[$key]['hotel'] = $roomMsg['hotel_id'];
            }
            $sql = "select * from ims_goods_booking where customer_id = {$result['id']}";
            $booking2 = pdo_fetchall($sql);
            foreach ($booking2 as $key => $val) {
                $sql = " select * from ims_goods where id = {$val['goods_id']}";
                $goodsMsg = pdo_fetch($sql);
                $booking2[$key]['name'] = $goodsMsg['name'];
                $booking2[$key]['img'] = $goodsMsg['icon'];
                $booking2[$key]['goods'] = $goodsMsg['id'];
                $booking2[$key]['dis'] = $goodsMsg['brief_intro'];
            }
            $img_url = $_SESSION['sc_user_info']->headimgurl;
            // print_r($booking2);
            include $this->template('scbridge:success-pay');
            include $this->template('scbridge:footer');
        }
    }
    
    public function dopaytrue(){
    	session_start();
    	global $_W,$_GPC;
    	$user_id = $_GPC['user_id'];
    	if (! empty($user_id)) {
    		$sql = "select * from ims_customer where id = '{$user_id}'";
    		$result = pdo_fetch($sql);
    		$img_url = $_SESSION['sc_user_info']->headimgurl;
    		$acc_number = $_GPC['acc_number'] * 0.01;
    		$_SESSION['sc_acc_number'] = $acc_number;
    		$acc_new = $_GPC['acc_number'];
    		$commonUtil = new CommonUtil();
    		$wxPayHelper = new WxPayHelper();
    		$wxPayHelper->setParameter("bank_type", "WX");
    		$wxPayHelper->setParameter("body", "会员充值");
    		$wxPayHelper->setParameter("partner", "1220727201");
    		$wxPayHelper->setParameter("out_trade_no", $commonUtil->create_noncestr());
    		$wxPayHelper->setParameter('total_fee', "{$acc_new}");
    		$wxPayHelper->setParameter("fee_type", "1");
    		$wxPayHelper->setParameter("notify_url", "http://www.kmark.cn/we_scbridge/wxpay_test/notify.php");
    		$wxPayHelper->setParameter("spbill_create_ip", $_SERVER['REMOTE_ADDR']);
    		$wxPayHelper->setParameter("input_charset", "GBK");
    		$str1 = $wxPayHelper->create_biz_package();
    		include $this->template('scbridge:pay_true');
    	}
    	//include $this->template('scbridge:store-nav');
    }
    
    // 商城导航页面加载
    public function doshop_center()
    {
        global $_W, $_GPC;
        $title = '商城';
        include $this->template('scbridge:header');
        include $this->template('scbridge:store-nav');
        include $this->template('scbridge:footer');
    }
    
    // 商品展示页面加载
    public function doshop_list()
    {
        global $_W, $_GPC;
        $good_type = $_GPC['good_type'];
        $sql = "select * from ims_goods where good_type= " . $good_type . " and good_stock > 0";
        $goods = pdo_fetchall($sql);
        $title = pe_switchArr($good_type, $this->arrGoods);
        include $this->template('scbridge:store');
        include $this->template('scbridge:footer');
    }
    
    // 商品详细页面加载
    public function dogoods_content()
    {
        global $_W, $_GPC;
        $good_id = $_GPC['good_id'];
        $good_type = $_GPC['good_type'];
        $good = pe_fetchOneByField("goods", "*", 'id', $good_id, '', '');
        $title = pe_switchArr($good_type, $this->arrGoods);
        include $this->template('scbridge:store-goods');
        include $this->template('scbridge:footer');
    }
    
    // 商品购买信息填写页面
    public function dogoods_booking()
    {
        global $_W, $_GPC;
        $g_id = $_GPC['g_id'];
        $oppenid = $_SESSION['sc_user_oppenid'];
        $sql = "select * from ims_customer where open_id = '{$oppenid}'";
        $result = pdo_fetch($sql);
        if (! empty($result)) {
            include $this->template('scbridge:store-reserve-write');
        } else {
            $title = '会员注册';
            $reminder = '注册';
            include $this->template('scbridge:header');
            include $this->template('scbridge:register');
            include $this->template('scbridge:footer');
        }
    }
    
    // 酒店确定支付信息函数
    public function doreserveDo()
    {
        global $_W, $_GPC;
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
        $roomsNumber = $_POST['roomsNumber'];
        // $meetingName = $_POST['meetingName'];
        
        if ($reserveType == "normalRoom") {
            // 先判断是否为空
            if (empty($startDate) || empty($endDate) || empty($customerName) || empty($customerTel)) {
                echo "<script>alert('信息输入不完整');window.history.back(-1);</script>";
            } else {
                
                if (strtotime($startDate) < (time() - 3600 * 24) || strtotime($endDate) < (time() - 3600 * 24) || strtotime($startDate) >= strtotime($endDate)) {
                    echo "<script>alert('预订时间不正确');window.history.back(-1);</script>";
                    die();
                } else {
                    $timeNowHour = date("H", time());
                    $dateNow = date("Y-m-d", time());
                    if (($timeNowHour == "23") && ($dateNow == $startDate)) {
                        echo "<script>alert('今天太晚,只能预定明天的房间哟...');window.history.back(-1);</script>";
                        die();
                    } else {
                        // 先根据数据选出支付的钱和会员余额
                        $sql = "select * from ims_customer where open_id = '{$open_id}'";
                        $customerMsg = pdo_fetch($sql);
                        // print_r($customerMsg);
                        $balanceMoney = $customerMsg['account_balance'];
                        $customerId = $customerMsg['id'];
                        $roomMsg = pe_fetchOneByField("hotel_room", "*", "id", $roomId, "", "");
                        $days = ((strtotime($endDate) - strtotime($startDate)) / (3600 * 24));
                        $needMoney = $roomMsg['price_vip'] * $roomsNumber * $days;
                        $mMoney = md5($needMoney);
                        $_SESSION["sc_customer_need_money"] = $needMoney;
                        $bMoney = md5($balanceMoney);
                        $_SESSION["sc_customer_balance_money"] = $balanceMoney;
                        $_SESSION["sc_customer_hotels_number"] = $roomsNumber;
                        $payThing = "room";
                        include $this->template("scbridge:select-pay");
                    }
                }
            }
        } else 
            if ($reserveType == "meetingRoom") {
                // print_r($_POST);
                // 先判断是否为空
                if (empty($startDate) || empty($endDate) || empty($customerName) || empty($customerTel)) {
                    echo "<script>alert('信息输入不完整');window.history.back(-1);</script>";
                    die();
                } else {
                    if (strtotime($startDate) < (time() - 3600 * 24) || strtotime($endDate) < (time() - 3600 * 24) || strtotime($startDate) >= strtotime($endDate)) {
                        
                        echo "<script>alert('预订时间不正确');window.history.back(-1);</script>";
                        die();
                    } else {
                        
                        // 先根据数据选出支付的钱和会员余额
                        $sql = "select * from ims_customer where open_id = '{$open_id}'";
                        $customerMsg = pdo_fetch($sql);
                        $balanceMoney = $customerMsg['account_balance'];
                        $customerId = $customerMsg['id'];
                        $roomMsg = pe_fetchOneByField("hotel_room", "*", "id", $roomId, "", "");
                        $days = ((strtotime($endDate) - strtotime($startDate)) / (3600 * 24));
                        $needMoney = $roomMsg['price_vip'] * $roomsNumber * $days;
                        $mMoney = md5($needMoney);
                        $_SESSION["sc_customer_need_money"] = $needMoney;
                        $bMoney = md5($balanceMoney);
                        $_SESSION["sc_customer_balance_money"] = $balanceMoney;
                        $_SESSION["sc_customer_hotels_number"] = $roomsNumber;
                        $payThing = "room";
                        include $this->template("scbridge:select-pay");
                    }
                }
            } else 
                if ($reserveType == "goodsRes") {
                    // 先判断是否为空
                    // 先判断是否为空
                    if (empty($address) || empty($customerName) || empty($customerTel)) {
                        echo "<script>alert('信息输入不完整');window.history.back(-1);</script>";
                    } else {
                        // 选择数量
                        $result = pe_fetchOneByField("goods", "*", "id", $goods_id);
                        if ($result['good_stock'] >= $goodsNumber) {
                            // 加载确定支付页面
                            // 先根据数据选出支付的钱和会员余额
                            $sql = "select * from ims_customer where open_id = '{$open_id}'";
                            $customerMsg = pdo_fetch($sql);
                            $balanceMoney = $customerMsg['account_balance'];
                            $customerId = $customerMsg['id'];
                            $goodsMsg = pe_fetchOneByField("goods", "*", "id", $goods_id, "", "");
                            $needMoney = $goodsMsg['price'] * $goodsNumber;
                            $mMoney = md5($needMoney);
                            $_SESSION["sc_customer_need_money"] = $needMoney;
                            $_SESSION["sc_customer_goods_number"] = $goodsNumber;
                            $bMoney = md5($balanceMoney);
                            $_SESSION["sc_customer_balance_money"] = $balanceMoney;
                            $payThing = "goods";
                            include $this->template("scbridge:select-pay");
                        } else {
                            echo "<script>alert('库存数量不够!');window.history.back(-1);</script>";
                        }
                    }
                }
    }
    
    // 支付函数
    public function docustomerPay()
    {
        session_start();
        global $_W, $_GPC;
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
        
        if ($payTh == 'room') {
            // 判断金额是否正确
            if (($needMoney == md5($_SESSION["sc_customer_need_money"])) && ($balanceMoney == md5($_SESSION["sc_customer_balance_money"]))) {
                // 判断余额是否充足
                if ($_SESSION["sc_customer_need_money"] <= $_SESSION["sc_customer_balance_money"]) {
                    // 写入数据库
                    $lastupdate = time();
                    $lastupdate = date('y-m-d h:i:s', $lastupdate);
                    $data = array(
                        "customer_id" => $customerId,
                        "room_id" => $roomId,
                        "start_date" => $startDate,
                        "end_date" => $endDate,
                        "total_price" => $_SESSION["sc_customer_need_money"],
                        "remarks" => $remark,
                        "status" => "0",
                        'lastupdate' => $lastupdate,
                        "hotels_account" => $roomsNumber
                    );
                    if (pdo_insert('hotel_booking', $data)) {
                        // 这里选出数据构造你发邮件所需要的数据
                        // 根据房间id选出房间名字，酒店名字，预定时间，酒店地址，客户名字
                        $booking_id = pdo_insertid();
                        // 选出订单
                        $sql = 'select * from ims_hotel_booking where id = ';
                        $sql .= $booking_id;
                        $result = pdo_fetch($sql);
                        $data_arr = array(
                            'start_date' => $result['start_date'],
                            'end_date' => $result['end_date'],
                            'hotels_account' => $result['hotels_account']
                        );
                        // 根据roomid 找房子
                        $sql = "select * from ims_hotel_room where id = ";
                        $sql .= $result['room_id'];
                        $result = pdo_fetch($sql);
                        $data_arr['room'] = $result['name'];
                        $sql = "select * from ims_hotel where id = ";
                        $sql .= $result['hotel_id'];
                        $result = pdo_fetch($sql);
                        $data_arr['hotel'] = $result['name'];
                        $str_1 = $result['city'];
                        $str_1 .= $result['region'];
                        $str_1 .= $result['address'];
                        $data_arr['address'] = $str_1;
                        $oppenid = $_SESSION['sc_user_oppenid'];
                        $sql = "select * from ims_customer where open_id = '{$oppenid}'";
                        $result = pdo_fetch($sql);
                        $data_arr['customer'] = $result['name'];
                        $data_arr['email'] = $result['email'];
                        $data_arr['tel'] = $result['mobile'];
                        // print_r($data_arr);
                        // 余额减少
                        $acc_ag = $_SESSION["sc_customer_balance_money"] - $_SESSION["sc_customer_need_money"];
                        $data = array(
                            'account_balance' => $acc_ag,
                            'status' => '1'
                        );
                        pdo_update('customer', $data, array(
                            'id' => $customerId
                        ));
                        $str = "尊敬的" . $data_arr['customer'] . "(先生/女士)你好：<br/>&nbsp;&nbsp;&nbsp;&nbsp;你已经成功预定" . $data_arr['hotel'] . "的" . $data_arr['room'] . ",预定时间是";
                        $str .= $data_arr['start_date'] . "至" . $data_arr['end_date'] . ",预定房间数" . $data_arr['hotels_account'] . "间" . ",地点" . $data_arr['address'];
                        $str .= ".请您准时入住!<br/>&nbsp;&nbsp;&nbsp;&nbsp;如有问题，请致电13982054177!";
                        $str_2 = $data_arr['customer'] . "(先生/女士)已经预订" . $data_arr['hotel'] . "的" . $data_arr['room'] . ",预定时间是";
                        $str_2 .= $data_arr['start_date'] . "至" . $data_arr['end_date'] . ",预定房间数" . $data_arr['hotels_account'] . "间." . "<br/>电话:" . $data_arr['tel'];
                        // $this->dosendMail($str_2,"admin@scbridge.cn");
                        $this->dosendMail($str_2, "leozheng@scbridge.cn");
                        $this->dosendMail($str_2, "arielwoo@scbridge.cn");
                        $this->dosendMail($str_2, "cyndiliu@scbridge.cn");
                        try {
                            $this->dosendMail($str, $data_arr['email']);
                            include $this->template("scbridge:success-reserve");
                        } catch (phpmailerException $e) {
                            echo "<script>alert('已经成功预定,请注意修改你的邮箱地址,我们无法给你发邮件')</script>";
                            include $this->template("scbridge:success-reserve");
                        }
                    } else {
                        include $this->template("scbridge:failure-pay");
                    }
                } else {
                    include $this->template("scbridge:failure-money");
                }
            } else {
                include $this->template("scbridge:failure-pay");
            }
        } else 
            if ($payTh == "goods") {
                // 这里是商品预订流程
                // 判断金额是否正确
                if (($needMoney == md5($_SESSION["sc_customer_need_money"])) && ($balanceMoney == md5($_SESSION["sc_customer_balance_money"]))) {
                    // 判断余额是否充足
                    if ($_SESSION["sc_customer_need_money"] <= $_SESSION["sc_customer_balance_money"]) {
                        // 写入数据库
                        $lastupdate = time();
                        $lastupdate = date('y-m-d h:i:s', $lastupdate);
                        $data = array(
                            "customer_id" => $customerId,
                            "goods_number" => $goodsNumber,
                            "goods_id" => $goods_id,
                            "total_price" => $_SESSION["sc_customer_need_money"],
                            "status" => "0",
                            "address" => $address,
                            'lastupdate' => $lastupdate
                        );
                        if (pdo_insert('goods_booking', $data)) {
                            //
                            $booking_id = pdo_insertid();
                            // 选出订单
                            $sql = 'select * from ims_goods_booking where id = ';
                            $sql .= $booking_id;
                            $result = pdo_fetch($sql);
                            $data_arr = array(
                                'number' => $result['goods_number'],
                                'address' => $result['address']
                            );
                            // 根据roomid 找房子
                            $sql = "select * from ims_goods where id = ";
                            $sql .= $result['goods_id'];
                            $result = pdo_fetch($sql);
                            $data_arr['name'] = $result['name'];
                            $oppenid = $_SESSION['sc_user_oppenid'];
                            $sql = "select * from ims_customer where open_id = '{$oppenid}'";
                            $result = pdo_fetch($sql);
                            $data_arr['customer'] = $result['name'];
                            $data_arr['email'] = $result['email'];
                            $data_arr['tel'] = $result['mobile'];
                            // 余额减少
                            $acc_ag = $_SESSION["sc_customer_balance_money"] - $_SESSION["sc_customer_need_money"];
                            $data = array(
                                'account_balance' => $acc_ag,
                                'status' => '1'
                            );
                            pdo_update('customer', $data, array(
                                'id' => $customerId
                            ));
                            // 减少库存数量
                            $goodsMsg = pe_fetchOneByField("goods", "*", "id", $goods_id, "", "");
                            $goodsNum = $goodsMsg['good_stock'] - $_SESSION["sc_customer_goods_number"];
                            $data = array(
                                'good_stock' => $goodsNum
                            );
                            pdo_update('goods', $data, array(
                                'id' => $goods_id
                            ));
                            // 发送邮件
                            $str = "尊敬的" . $data_arr['customer'] . "(先生/女士)你好：<br/>&nbsp;&nbsp;&nbsp;&nbsp;你已经成功购买";
                            $str .= $data_arr['name'] . ".数量是" . $data_arr['number'] . ",你的地点是" . $data_arr['address'];
                            $str .= ".请您静静等候,我们尽快给您送到.<br/>如有问题，请致电13982054177";
                            $str_2 = $data_arr['customer'] . "(先生/女士)已经预订" . $data_arr['name'] . ",数量是" . $data_arr['number'] . ",地点是" . $data_arr['address'];
                            $str_2 .= "<br/>电话:" . $data_arr['tel'];
                            $this->dosendMail($str_2, "leozheng@scbridge.cn");
                            $this->dosendMail($str_2, "arielwoo@scbridge.cn");
                            $this->dosendMail($str_2, "cyndiliu@scbridge.cn");
                            try {
                                $this->dosendMail($str, $data_arr['email']);
                                include $this->template("scbridge:success-reserve");
                            } catch (phpmailerException $e) {
                                echo "<script>alert('已经成功购买,请注意修改你的邮箱地址,我们无法给你发邮件')</script>";
                                include $this->template("scbridge:success-reserve");
                            }
                        } else {
                            include $this->template("scbridge:failure-pay");
                        }
                    } else {
                        include $this->template("scbridge:failure-money");
                    }
                } else {
                    include $this->template("scbridge:failure-pay");
                }
            }
    }
    
    // 取消房间预订函数
    public function doroom_cancel()
    {
        global $_W, $_GPC;
        $bookingId = $_GPC['bookingid'];
        $type = $_GPC['type'];
        if (! empty($bookingId) && $type == 'hotel') {
            // 现在先先判定时间是否过期
            $sql = "select * from ims_hotel_booking where id = {$bookingId}";
            $bookingMsg = pdo_fetch($sql);
            
            if (strtotime($bookingMsg['lastupdate']) < (strtotime(date("y-m-d h:i:s")) - 7200)) {
                include $this->template("scbridge:failure-cancel");
            } else {
                // 这里是取消动作执行
                // 首先找到订单的价格，还原价格
                $oppenid = $_SESSION['sc_user_oppenid'];
                $sql = "select * from ims_customer where open_id = '{$oppenid}'";
                $re = pdo_fetch($sql);
                $acc_be = ($re['account_balance']);
                $acc_ag = $acc_be + $bookingMsg['total_price'];
                // 现在插入数据
                $data = array(
                    'account_balance' => $acc_ag,
                    'status' => '1'
                );
                if (pdo_update('customer', $data, array(
                    'open_id' => $oppenid
                ))) {
                    // 删除这条订单
                    pdo_delete("hotel_booking", array(
                        'id' => $bookingId
                    ));
                    // 实现发送邮件
                    $data_arr = array(
                        'start_date' => $bookingMsg['start_date'],
                        'end_date' => $bookingMsg['end_date']
                    );
                    // 根据roomid 找房子
                    $sql = "select * from ims_hotel_room where id = ";
                    $sql .= $bookingMsg['room_id'];
                    $result = pdo_fetch($sql);
                    $data_arr['room'] = $result['name'];
                    $sql = "select * from ims_hotel where id = ";
                    $sql .= $result['hotel_id'];
                    $result = pdo_fetch($sql);
                    $data_arr['hotel'] = $result['name'];
                    $str_1 = $result['city'];
                    $str_1 .= $result['region'];
                    $str_1 .= $result['address'];
                    $data_arr['address'] = $str_1;
                    $oppenid = $_SESSION['sc_user_oppenid'];
                    $sql = "select * from ims_customer where open_id = '{$oppenid}'";
                    $result = pdo_fetch($sql);
                    $data_arr['customer'] = $result['name'];
                    $data_arr['email'] = $result['email'];
                    $data_arr['tel'] = $result['mobile'];
                    $str = "尊敬的" . $data_arr['customer'] . "(先生/女士)你好：<br/>&nbsp;&nbsp;&nbsp;&nbsp;你已经成功取消" . $data_arr['hotel'] . "的" . $data_arr['room'] . "的预定";
                    $str .= ".时间是" . $data_arr['start_date'] . "至" . $data_arr['end_date'];
                    $str .= "<br/>如有问题，请致电13982054177!";
                    $str_2 = $data_arr['customer'] . "(先生/女士)已经取消" . $data_arr['hotel'] . "的" . $data_arr['room'] . "的预定";
                    $str_2 .= ".预定时间是" . $data_arr['start_date'] . "至" . $data_arr['end_date'] . "<br/>电话:" . $data_arr['tel'];
                    $this->dosendMail($str_2, "leozheng@scbridge.cn");
                    $this->dosendMail($str_2, "arielwoo@scbridge.cn");
                    $this->dosendMail($str_2, "cyndiliu@scbridge.cn");
                    try {
                        $this->dosendMail($str, $data_arr['email']);
                        include $this->template("scbridge:success-cancel");
                    } catch (phpmailerException $e) {
                        echo "<script>alert('已经成功取消,请注意修改你的邮箱地址,我们无法给你发邮件')</script>";
                        include $this->template("scbridge:success-cancel");
                    }
                    // $this->dosendMail($str_2,"admin@scbridge.cn");
                }
            }
        }
    }
    
    // 发送邮件函数
    public function dosendMail($str, $email)
    {
        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->CharSet = 'UTF-8'; // 设置邮件的字符编码，这很重要，不然中文乱码
        $mail->SMTPAuth = true; // 开启认证
        $mail->Port = 25;
        $mail->Host = "smtp.exmail.qq.com";
        $mail->Username = "admin@scbridge.cn";
        $mail->Password = "123Nimda";
        // $mail->IsSendmail(); //如果没有sendmail组件就注释掉，否则出现“Could not execute: /var/qmail/bin/sendmail ”的错误提示
        $mail->AddReplyTo("admin@scbridge.cn", "酒店预订中心"); // 回复地址
        $mail->From = "admin@scbridge.cn";
        // $mail->FromName = "www.phpddt.com";
        $to = $email;
        $mail->AddAddress($to);
        $mail->Subject = "通知";
        $mail->Body = $str;
        $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // 当邮件不支持html时备用显示，可以省略
        $mail->WordWrap = 300; // 设置每行字符串的长度
                                 // $mail->AddAttachment("f:/test.png"); //可以添加附件
        $mail->IsHTML(true);
        if ($mail->Send()) {
            return 1;
        } else {
            return 0;
        }
    }
}

<?php
/**
 * LBS处理类
 * 说明：当用户发送一条位置信息时，根据商户所存储的一系列店铺地址，匹配出距离最近的若干个店铺，以news的类型回复给客户，链接为路线图。
 * 
 * powered by Feng
 */
defined('IN_IA') or exit('Access Denied');

class WxlbsModuleProcessor extends WeModuleProcessor {
	public $name = 'wxlbsModuleProcessor';

	public function isNeedInitContext() {
		return 0;
	}

	function sortByDistance($a, $b) {
 		$distance_a = $a['distance'];
 		$distance_b = $b['distance'];
 		printf($distance_a + $distance_b);
 		if ($distance_a == $distance_b) {
 			return 0;
 		} else {
 			return ($distance_a > $distance_b) ? 1 : -1;
 		}
	}

	//二维数组排序
	function array_sort($arr,$keys,$type='asc'){
		$keysvalue = $new_array = array();
		foreach ($arr as $k=>$v){
			$keysvalue[$k] = $v[$keys];
		}
		if($type == 'asc'){
			asort($keysvalue);
		}else{
			arsort($keysvalue);
		}
		reset($keysvalue);
		foreach ($keysvalue as $k=>$v){
			$new_array[$k] = $arr[$k];
		}
		return $new_array;
	}
 	
	public function respond() {
		global $_W;
		$r['FromUserName'] = $this->message['to'];
		$r['ToUserName'] = $this->message['from'];

		$keyword =$this->message['content'];
		$tipinfo = "";
		$to = $this->message['to'];
		$from = $this->message['from'];
		
		if($this->message['type']=='location'){

			$x  = urldecode($this->message['location_x']);//获取微信按下的纬度
			$y  = urldecode($this->message['location_y']);//获取微信按下的经度

			$xy=$x.','.$y;
			$yx=$y.','.$x;
			
			/*----------查询数据库找到商家的地址列表----------*/
			$sqlLocations = "SELECT * FROM ims_wxlbs WHERE weid = '$_W[weid]'";
			$locationsArray = pdo_fetchall($sqlLocations);
			
			//给每个商户地址插入距离值
			foreach ($locationsArray as $index => &$location){
				$location['distance'] = $this->getDistanceBetweenPoints($location['x_axis'],$location['y_axis'],$x,$y);
			}
			
			//按照距离排序
			$orederedLocations = $this->array_sort($locationsArray,'distance');
			
			//构造路线图的方法 待研究
			
			//构造信息
			$r['MsgType'] = 'news';
        	$number = count($orederedLocations) < 3 ? count($orederedLocations) : 3;
        	$r['ArticleCount'] = $number;
        	
        	$count = 1;
			foreach ($orederedLocations as $location){
				$lng = $location['y_axis'];
        		$lat = $location['x_axis'];
        		if($count <= $number){
        			$r['Articles'][$count++] = array(
	        		'Title' => '距离'.$location['name']. '还有' .round($location['distance'], 2). '公里',
	        		'Description' => $location['description'],
	        		'PicUrl' => empty($location['picture']) ? 'http://api.map.baidu.com/staticimage?center='.$lng.','.$lat.'&markers='.$lng.','.$lat.'&zoom=14&dpiType=ph' : $_W['attachurl'].$location['picture'],
	        		//'Url' => $_W['siteroot'] . 'source/modules/wxlbs/baidumapDirection.php?t1='.$yx.'&t2='.$lng.','.$lat,
	        		'Url' => $_W['siteroot'] . create_url('index/module', array('do' => 'locationDetails', 'name' => 'wxlbs', 'locationId' => $location['id'], 't1' => $yx, 't2' => $lng.','.$lat)),
	        		'TagName' => 'item'
	        		);
        		}
			}
		}
		return $r;
	}
	
	public function isNeedSaveContext() {
		return false;
	}
	
	//计算地图2点之间的距离
	function getDistanceBetweenPoints($latitude1, $longitude1, $latitude2, $longitude2) {
	    $theta = $longitude1 - $longitude2;
	    $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
	    $miles = acos($miles);
	    $miles = rad2deg($miles);
	    $miles = $miles * 60 * 1.1515;
	    $kilometers = $miles * 1.609344;
	    //$meters = $kilometers * 1000; 
	    $distance = $kilometers;
	    return  $distance; 
	}
	
	/* 获取用户的信息
	 * @param  string $id 用户的fakeid
	 * @return [type]     [description]
	 */
	 function getUserInfo($fromfakeid)
	{
		global $_W;
		$username = $_W['account']['username'];
		$auth = $_W['cache']['wxauth'][$username];
		$url = WEIXIN_ROOT . '/cgi-bin/getcontactinfo?t=ajax-getcontactinfo&lang=zh_CN&fakeid='.$fromfakeid;
		$response = account_weixin_http($_W['account']['username'], $url);
		$html = json_decode($response['content'],true);
		return $html;
	}
	
}
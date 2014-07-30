<?php

 /* 
 感谢@珊瑚海qq543378251提供的LBS程序思路。
 本模块暂时提供LBS查询附近，以及听歌，和人脸识别系统
 powered by wangxinglin.com
 QQ:81324093 微信公众号：guanganba
 */
defined('IN_IA') or exit('Access Denied');




class WxlModuleProcessor extends WeModuleProcessor {
	public $name = 'Wxl';
	
	
	public function isNeedInitContext() {
		return 0;
	}
	
	public function respond() {
		global $_W;
		$keyword =$this->message['content'];
     $r['FromUserName'] = $this->message['to'];
		$r['ToUserName'] = $this->message['from'];
		$tipinfo = "";
		$to = $this->message['to'];
		$from = $this->message['from'];
    

		
		
		if($this->message['type']=='location'){
        $r['FromUserName'] = $this->message['to'];
		$r['ToUserName'] = $this->message['from'];
		
			 
		
		$tipinfo = "";
		$to = $this->message['to'];
		$from = $this->message['from'];
		
        $x  = urldecode($this->message['location_x']);//获取微信按下的纬度
 		$y  = urldecode($this->message['location_y']);//获取微信按下的经度
		$xy = $x.",".$y;
		$url = "http://api.map.baidu.com/geocoder/v2/?ak=05b16f0c022c323a701015e4ee789c0b&callback=renderReverse&location=".$xy."&output=xml&pois=0";
		$loc = file_get_contents($url);
		$loc = (array)simplexml_load_string($loc);
		$add = (array)$loc['result'];
		$streets = (array)$add['addressComponent'];
		$province = $streets['province'];
		$city = $streets['city'];
		$district = $streets['district'];
		$street = $streets['street'];	
		$cityall = $province.",".$city.",".$district.",".$street;
		/*==以上为获取到的地址信息，下面是数据库操作==*/
		$sql1="select * from ims_location_log where openid='$from'";
		$openid=mysql_query($sql1);
		$rowopenid = mysql_fetch_array($openid);
		//echo $rowopenid[1];
		if(!$rowopenid[1]){//openid记录不存在，增加记录
			$intosql="INSERT INTO `ims_location_log` (`id`, `openid` ,`x` ,`y` ,`city`,`date`) VALUES (NULL, '$from','$x','$y','$cityall',now())";
			mysql_query($intosql);
		}else{//openid记录存在，更新记录
			$update="update ims_location_log set x='$x',y='$y',city='$cityall',date=now() where openid='$from'";
			mysql_query($update);
		}
		$keys = array('公共厕所','美食','团购','按摩','ATM','银行','酒店','ktv','快餐','美发','还有更多其他好玩的等着你去发现！随意选择一个关键字试试吧！');
		$r['MsgType'] = 'news';
		$r['ArticleCount'] = 3;
		$r['Articles'][1] = array(
              'Title' => '尊敬的用户您好，您的位置我们已经记录！',
        		'Description' => '',
        		'PicUrl' => '',
        		'Url' => '',
        		'TagName' => 'item',
        	);
		
		 $r['Articles'][2] = array(
        		'Title' => '您当前位于：'.$cityall,
        		'Description' =>'.$cityall',
        		'PicUrl' => '',
        		'Url' => '',
        		'TagName' => 'item',
        	);
      
        $r['Articles'][3] = array(
        		'Title' => '回复下列关键字可以查询附近信息：'.implode("\n附近",$keys),
        		'Description' =>'',
        		'PicUrl' => '',
        		'Url' => '',
        		'TagName' => 'item',
        	);
			
		return $r;	
      }
	  	
	$content = trim($keyword);
  
    $shortcon = substr($content,0,6);
		
		if($shortcon == "附近")
    	{  	 
		
    	$key= str_replace('附近','',$content);
    	$keys = array('公共厕所','美食','团购','按摩','ATM','银行','酒店','ktv','快餐','美发','还有更多其他好玩的等着你去发现！随意选择一个关键字试试吧！');
    	if(!$key){
          $r['FromUserName'] = $this->message['to'];
		$r['ToUserName'] = $this->message['from'];
		$tipinfo = "";
		$to = $this->message['to'];
		$from = $this->message['from'];
    		$r['MsgType'] = 'text';
        	$r['Content'] ="不知道你想要找什么,请回复以下关键字查询:".implode("\n附近",$keys);
          return $r;
    	}
    	$sql3="select * from ims_location_log where openid='$from'";
		$openid2=mysql_query($sql3);
		$rowopenid2 = mysql_fetch_array($openid2);
		//echo $rowopenid2[1];
		if($rowopenid2[1]){//openid记录不存在，增加记录
			$x = $rowopenid2[2]+0.006603;
			$y = $rowopenid2[3]+0.006175;
			$city = $rowopenid2[4];
			$time = $rowopenid2[5];
			$xy=$x.','.$y;
			$yx=$y.','.$x;
			$lcadr="http://api.map.baidu.com/place/v2/search?ak=05b16f0c022c323a701015e4ee789c0b&output=json&query=".$key."&page_size=9&page_num=0&scope=2&location=".$xy."&radius=1000";
			$lcjson = json_decode(file_get_contents($lcadr),true);
			$total= $lcjson['total']<6 ? $lcjson['total'] : 6;
			if($lcjson['message'] !== 'ok'){
              	$r['FromUserName'] = $this->message['to'];
			$r['ToUserName'] = $this->message['from'];
			$tipinfo = "";
			$to = $this->message['to'];
			$from = $this->message['from'];
				$r['MsgType'] = 'text';
        		$r['Content'] ='搜索数据失败,请检测api是否可用!';
				return $r;
			}
			
			
        $r['FromUserName'] = $this->message['to'];
		$r['ToUserName'] = $this->message['from'];
		$tipinfo = "";
		$to = $this->message['to'];
		$from = $this->message['from'];
			$r['MsgType'] = 'news';
       		$r['ArticleCount'] =$total;
					
			foreach($lcjson['results'] as $k=>$v){
				$dis = $v['detail_info']['distance'];
				$adr = str_replace('广安','',$v['address']); //去掉长地址 可自行修改自己地区
				$nme = $v['name'];
				$tel = $v['telephone'];
				$lat = $v['location']['lat'];
				$lng = $v['location']['lng'];
				$_yx = $lng.','.$lat;
				$pic = $k==0? "http://api.map.baidu.com/staticimage?center=".$yx."&zoom=14&labels=".$_yx."&labelStyles=".urlencode($nme).",1,14,0xff0000,0xffffff,1":'';
				$title = array($nme. "(约{$dis}米)");
				if($adr) $title[] = $adr;
				if($tel) $title[] = $tel;
				$title = implode("\n",$title);
				$url =$v['detail_info']['detail_url'] ? $v['detail_info']['detail_url'] :'http://2.ga0826.duapp.com/baidumap.php?t1='.$yx.'&t2='.$lng.','.$lat;
				$data = array(
				'Title' => $title,
        		'Description' => "本次查询使用的是您于[".$time."]在[".$city."]记录的位置信息，如有变动请重新发送您的位置，谢谢！",
        		'PicUrl' => $pic,
        		'Url' => $url,
        		'TagName' => 'item',
				
				);
					$r['Articles'][] = $data;
				
			}
			
         // $r['Articles']=$row;
      
			return $r;
		}else{//openid记录存在，更新记录
          $r['FromUserName'] = $this->message['to'];
		$r['ToUserName'] = $this->message['from'];
		$tipinfo = "";
		$to = $this->message['to'];
		$from = $this->message['from'];
			$r['MsgType'] = 'text';
        		$r['Content'] ='我们还没有你位置记录,发送你的位置给我吧! 点左下角的"+"选择"位置"然后"发送"';
          return $r;
		}
		
		
    }
//人脸识别
  if  ($this->message['type']=='image'){
	$keyword =$this->message['picurl'];
   $queryinfo = file_get_contents("http://api2.sinaapp.com/recognize/picture/?appkey=1509109147&appsecert=b80f19d896eb7ca20ea919b12dc02053&reqtype=text&keyword=".$keyword);
	$row = json_decode($queryinfo,true);
	$r['FromUserName'] = $this->message['to'];
		$r['ToUserName'] = $this->message['from'];
		$tipinfo = "";
		$to = $this->message['to'];
		$from = $this->message['from'];
	$r['MsgType'] = 'text';
    $r['Content'] =$row['text']['content'];
	return $r;
	}

//听歌
if(strpos($keyword,"听歌")!==false){
        $key = str_replace("听歌","",$keyword);
         $urlstr = file_get_contents("http://api2.sinaapp.com/search/music/?appkey=0020130430&appsecert=fa6095e1133d28ad&reqtype=music&keyword=".$key);
				$arrayjson=json_decode($urlstr,true);
        $url=$arrayjson['music']['musicurl'];
		$r['FromUserName'] = $this->message['to'];
		$r['ToUserName'] = $this->message['from'];
		$tipinfo = "";
		$to = $this->message['to'];
		$from = $this->message['from'];
        $r['MsgType'] = 'music';
        
        $r['Music'] = array(
        	'Title'	=> $key,
        	'Description' => $key,
        	'MusicUrl' => $url,
          'HQMusicUrl'=> $url,
        );
		return $r;
      }	
	  
	  
	}
	
	public function isNeedSaveContext() {
		return false;
	}
	
}






date_default_timezone_set('PRC'); //设置时区为中国
$dbname = 'DKFxYikMUgiDIxmuEAsB';//这里填写你BAE数据库的名称
{  //连接数据库
//从环境变量里取出数据库连接需要的参数
$host = getenv('HTTP_BAE_ENV_ADDR_SQL_IP');
$port = getenv('HTTP_BAE_ENV_ADDR_SQL_PORT');
$user = getenv('HTTP_BAE_ENV_AK');
$pwd = getenv('HTTP_BAE_ENV_SK');

//接着调用mysql_connect()连接服务器/
$link = @mysql_connect("{$host}:{$port}",$user,$pwd,true);
if(!$link)
{
  die("Connect Server Failed: " . mysql_error($link));
}
//连接成功后立即调用mysql_select_db()选中需要连接的数据库
if(!mysql_select_db($dbname,$link))
{
  die("Select Database Failed: " . mysql_error($link));
}
}
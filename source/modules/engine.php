<?php
/**
 * 微擎模块核心类
 * 
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');

class WeEngine {

	private $token = '';
	private $events = array();
	private $modules = array();
	private $matcher = null;
	public $message = array();
	public $response = array();
	public $keyword = array();

	/**
	 * 构造新实例
	 * @param array $config 设置项
	 *  - token string 微信密钥
	 *  - matcher callable 此回调函数参数提供扫描目标字符串并按照关键字匹配出模块名称的能力, 参入为输入字符串, 返回结果为元组数据
	 *  - modules(optional) array 当前系统允许的模块集合, 不在此集合的模块不会进行处理, default welcome 模块不能禁用
	 *  - before(optional) 开始执行消息处理之前执行, 传递参数为消息对象. 参阅 WeUtility::parse 结果, 返回结果如果为 false 将中断执行
	 *  - after(optional) 完成消息处理之后执行, 传递参数为消息对象. 参阅 WeUtility::parse 结果, 返回结果如果为 false 将中断执行
	 */
	public function __construct() {
		global $_W;
		if(empty($_W['account']['token'])) {
			exit('initial missing token');
		}
		$this->token = $_W['account']['token'];
		$this->modules = array_keys(member_modules());
		$this->modules[] = 'welcome';
		$this->modules[] = 'default';
		$this->modules = array_unique($this->modules);
	}
	
	public function start() {
		if(empty($this->token)) {
			exit('Access Denied');
		}
		if(!WeUtility::checkSign($this->token)) {;
			exit('Access Denied');
		}
		if(strtolower($_SERVER['REQUEST_METHOD']) == 'get') {
			exit($_GET['echostr']);
		}
		if(strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
			$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
			$this->message = WeUtility::parse($postStr);
			if (empty($this->message)) {
				WeUtility::logging('waring', 'Request Failed');
				exit('Request Failed');
			}
			WeUtility::logging('trace', $this->message);
			$this->before();
			$this->response = $this->matcher();
			$this->response['content'] = $this->process();
			if(empty($this->response['content']) || ($this->response['content']['type'] == 'text' && empty($this->response['content']['content'])) || ($this->response['content']['type'] == 'news' && empty($this->response['content']['items']))) {
				$this->response['module'] = 'default';
				$this->response['content'] = $this->process();
			}
			$this->after();
			WeUtility::logging('response', $this->response);
			exit(WeUtility::response($this->response['content']));
		}
		WeUtility::logging('waring', 'Request Failed');
		exit('Request Failed');
	}

	/**
	 * 匹配关键字
	 * 匹配优先级:完全匹配，正则匹配，模糊匹配
	 * 多条关键字时，规则最多取5条，由具体模块来处理规则的选择
	 *
	 * @param string $input 用户输入的信息
	 * @return array 元组数据
	 * 		Array (
	 * 			modules => Array ( 
	 * 				模块名 => 模块名 
	 * 			) 
	 * 			rules => Array ( 
	 * 				模块名 => Array (
	 * 					属于此模块的规则id
	 * 				)
	 * 			) 
	 *		) 
	 */
	private function matcher() {
		$response = array('module' => '', 'rule' => '');
		if (method_exists($this, 'matcher'.$this->message['msgtype'])) {
			$response = call_user_func(array($this, 'matcher'.$this->message['msgtype']));
		}
		return $response;
	}
	/**
	 * 事件模块、规则匹配器
	 */
	private function matcherEvent() {
		$response = array('module' => '', 'rule' => '');
		if($this->message['event'] == 'subscribe') {
			//订阅
			$response['module'] = 'welcome';
		} elseif ($this->message['event'] == 'subscribe') {
			//退订
			
		} elseif($this->message['event'] == 'CLICK') {
			//菜单
			list($key, $rid, $module) = explode(':', $this->message['eventkey']);
			if (!empty($rid) && !empty($module)) {
				$response['module'] = $module;
				$response['rule'] = $rid;
			}
		}
		return $response;
	}

	private function matcherText() {
		$response = array('module' => '', 'rule' => '');
		$input = $this->message['content'];
		if (!isset($input)) {
			return $response;
		}
		global $_W;
		/*
		 * @TODO 需要增加缓存
		 */
		$condition = "`weid`='{$_W['weid']}'";
		$keywords = rule_keywords_search($condition . " AND `content` = '" . addslashes($input) . "'  AND (`type` = '1' OR `type` = '2')");
		if (empty($keywords)) {
			$needles = rule_keywords_search($condition . " AND `type` = '3'");
			foreach($needles as $needle) {
				if(preg_match($needle['content'], $input, $match) !== 0) {
					$keywords[] = array(
						'rid' => $needle['rid'],
						'content' => $needle['content'],
						'type' => $needle['type'],
						'module' => $needle['module'],
						'weid' => $needle['weid'],
					);
					break;
				}
			}
			if (empty($keywords)) {
				$needles = rule_keywords_search($condition . " AND `type` = '2'");
				$i = 1;
				foreach($needles as $needle) {
					if ($i >= 5) {
						break;
					}
					if(stripos($input, $needle['content']) !== false) {
						$keywords[] = array(
							'rid' => $needle['rid'],
							'content' => $needle['content'],
							'type' => $needle['type'],			
							'module' => $needle['module'],
							'weid' => $needle['weid'],
						);
						$i++;
					}
				}
			}
		}
		if (empty($keywords)) {
			return $response;
		}
		if (count($keywords) > 1) {
			srand((float) microtime() * 10000000);
			$index = array_rand($keywords);
			$this->keyword = $keywords[$index];
		} else {
			$this->keyword = $keywords[0];
		}
		$response = array(
			'module' => $this->keyword['module'],
			'rule' => $this->keyword['rid'],
		);
		return $response;
	}
	
	/**
	 * 地理位置信息处理
	 * 
	 * 此方法进行地理信息的初步处理和匹配，并返回期望处理的模块。结构与matcherText相似。
	 * $this->message保存用户发送过来的消息
	 */
	private function matcherLocation() {
		$response = array('module' => 'wxlbs', 'rule' => '');
		//处理代码
		return $response;
	}
	
	private function process() {
		$response = false;
		if (empty($this->response['module']) || !in_array($this->response['module'], $this->modules)) {
			return false;
		}
		$processor = WeUtility::createModuleProcessor($this->response['module']);
		$processor->message = $this->message;
		$processor->rule = $this->response['rule'];
		$response = $processor->respond();
		if(empty($response)) {
			return false;
		}
		return $response;
	}
	
	public function before() {
		global $_W;
		runhook('before');
		if (!empty($_W['account']['default_period'])) {
			$_W['cache']['default_period'] = TRUE;
			$row = pdo_fetch("SELECT id, lastupdate FROM ".tablename('log_message')." WHERE from_user = '{$this->message['from']}' AND weid = '{$_W['weid']}'");
			if (!empty($row)) {
				if (TIMESTAMP - intval($row['lastupdate']) > intval($_W['account']['default_period'])) {
					$_W['cache']['default_period'] = TRUE;
				} else {
					$_W['cache']['default_period'] = FALSE;
				}
			}
			if (!empty($row)) {
				pdo_update('log_message', array('lastupdate' => TIMESTAMP), array('id' => $row['id']));
			} else {
				pdo_insert('log_message', array('from_user' => $message['from'], 'lastupdate' => TIMESTAMP, 'weid' => $_W['weid']));
			}
		}
	}
	
	public function after() {
		global $_W;
		runhook('after');
		$this->stat();
	}
	
	public function stat() {
		global $_W;
		$stat = setting_load('stat');
		if (!empty($stat['msg_maxday']) && $stat['msg_maxday'] > 0) {
			pdo_delete('stat_msg_history', " createtime < ".TIMESTAMP.' - '. $stat['msg_maxday'] * 86400);
		}
		if ($stat['msg_history']) {
			switch ($this->message['type']) {
				case 'image':
					$content = $this->message['picurl'];
					break;
				case 'location':
					$content = iserializer(array('x' => $this->message['location_x'], 'y' => $this->message['location_y']));
					break;
				case 'link':
					$content = iserializer(array('title' => $this->message['title'], 'description' => $this->message['description'], 'link' => $this->message['link']));
					break;
				case 'event':
					$content = iserializer(array('event' => $this->message['event'], 'key' => $this->message['eventkey']));
					break;
				default:
					$content = $this->message['content'];	
			}
			pdo_insert('stat_msg_history', array(
				'weid' => $_W['weid'],
				'module' => $this->response['module'],
				'from_user' => $this->message['from'],
				'rid' => $this->response['rule'],
				'kid' => $this->keyword['id'],
				'message' => $content,
				'type' => $this->message['msgtype'],
				'createtime' => TIMESTAMP,
			));
		}
		if (!empty($stat['use_ratio'])) {
			$updateid = pdo_query("UPDATE ".tablename('stat_rule')." SET hit = hit + 1, lastupdate = '".TIMESTAMP."' WHERE rid = :rid AND createtime = :createtime", array(':rid' => $this->response['rule'], ':createtime' => strtotime(date('Y-m-d'))));
			if (empty($updateid)) {
				pdo_insert('stat_rule', array(
					'weid' => $_W['weid'],
					'rid' => $this->response['rule'],
					'createtime' => strtotime(date('Y-m-d')),
					'hit' => 1,
					'lastupdate' => TIMESTAMP,
				));
			}
			if (!empty($this->keyword['id'])) {
				$updateid = pdo_query("UPDATE ".tablename('stat_keyword')." SET hit = hit + 1, lastupdate = '".TIMESTAMP."' WHERE kid = :kid AND createtime = :createtime", array(':kid' => $this->keyword['id'], ':createtime' => strtotime(date('Y-m-d'))));
				if (empty($updateid)) {
					pdo_insert('stat_keyword', array(
						'weid' => $_W['weid'],
						'rid' => $this->response['rule'],
						'kid' => $this->keyword['id'],
						'createtime' => strtotime(date('Y-m-d')),
						'hit' => 1,
						'lastupdate' => TIMESTAMP,
					));
				}
			}
		}
	}
}

class WeUtility {
	public static function rootPath() {
		static $path;
		if(empty($path)) {
			$path = dirname(__FILE__);
			$path = str_replace('\\', '/', $path);
		}
		return $path;
	}

	public static function checkSign($token) {
		$signkey = array($token, $_GET['timestamp'], $_GET['nonce']);
		sort($signkey);
		$signString = implode($signkey);
		$signString = sha1($signString);
		if($signString == $_GET['signature']){
			return true;
		}else{
			return false;
		}
	}

	public static function createModuleProcessor($name) {
		$classname = "{$name}ModuleProcessor";
		if(!class_exists($classname)) {
			$file = WeUtility::rootPath() . "/{$name}/processor.php";
			if(!is_file($file)) {
				trigger_error('ModuleProcessor Definition File Not Found '.$file, E_USER_ERROR);
				return null;
			}
			require $file;
		}
		if(!class_exists($classname)) {
			trigger_error('ModuleProcessor Definition Class Not Found', E_USER_ERROR);
			return null;
		}
		$o = new $classname();
		if($o instanceof WeModuleProcessor) {
			return $o;
		} else {
			trigger_error('ModuleProcessor Class Definition Error', E_USER_ERROR);
			return null;
		}
	}

	/**
	 * 分析请求数据
	 * @param string $request 接口提交的请求数据
	 * 具体数据格式与微信接口XML结构一致
	 * 
	 * @return array 请求数据结构
	 */
	public static function parse($message) {
		$packet = array();
		if (!empty($message)){		 
			$obj = simplexml_load_string($message, 'SimpleXMLElement', LIBXML_NOCDATA);
			if($obj instanceof SimpleXMLElement) {
				$packet['from'] = strval($obj->FromUserName);
				$packet['to'] = strval($obj->ToUserName);
				$packet['time'] = strval($obj->CreateTime);
				$packet['type'] = strval($obj->MsgType);
				$packet['event'] = strval($obj->Event);
				
				foreach ($obj as $variable => $property) {
					$packet[strtolower($variable)] = (string)$property;
				}
				if($packet['type'] == 'event') {
					$packet['type'] = $packet['event'];
					unset($packet['content']);
				}
			}
		}
		return $packet;
	}

	/**
	 * 按照响应内容组装响应数据
	 * @param array $packet 响应内容
	 *
	 * @return string
	 */
	public static function response($packet) {
		if (!is_array($packet)) {
			return $packet;	
		}
		if(empty($packet['CreateTime'])) {
			$packet['CreateTime'] = time();
		}
		if(empty($packet['MsgType'])) {
			$packet['MsgType'] = 'text';
		}
		if(empty($packet['FuncFlag'])) {
			$packet['FuncFlag'] = 0;
		} else {
			$packet['FuncFlag'] = 1;
		}
		return self::array2xml($packet);
	}

	public static function beginContext($nextmodule = '', $expire = 3600) {
		global $_W;
		if(empty($nextmodule)) {
			$nextmodule = $_W['module'];
		}
		$_SESSION['contextmodule'] = $nextmodule;
		$_SESSION['contextexpire'] = TIMESTAMP + $expire;
	}

	public static function endContext() {
		
	}

	public static function inContext() {
		if(!empty($_SESSION['contextmodule']) && !empty($_SESSION['contextexpire'])) {
			return $_SESSION['contextexpire'] > TIMESTAMP;
		}
		return false;
	}

	public static function setContext($key, $value) {
		if(!WeUtility::inContext()) {
			return;
		}
	}

	public static function getContext($key) {
		if(!WeUtility::inContext()) {
			return null;
		}
	}
	
	public static function logging($level = 'info', $message = '') {
		if(!DEVELOPMENT) {
			return true;
		}
		$filename = IA_ROOT . '/data/logs/' . date('Ymd') . '.log';
		mkdirs(dirname($filename));
		$content = date('Y-m-d H:i:s') . " {$level} :\n------------\n";
		if(is_string($message)) {
			$content .= "String:\n{$message}\n";
		}
		if(is_array($message)) {
			$content .= "Array:\n";
			foreach($message as $key => $value) {
				$content .= sprintf("%s : %s ;\n", $key, $value);
			}
		}
		if($message == 'get') {
			$content .= "GET:\n";
			foreach($_GET as $key => $value) {
				$content .= sprintf("%s : %s ;\n", $key, $value);
			}
		}
		if($message == 'post') {
			$content .= "POST:\n";
			foreach($_POST as $key => $value) {
				$content .= sprintf("%s : %s ;\n", $key, $value);
			}
		}
		$content .= "\n";

		$fp = fopen($filename, 'a+');
		fwrite($fp, $content);
		fclose($fp);
	}
	
	public static function array2xml($arr, $level = 1, $ptagname = '') {
		$s = $level == 1 ? "<xml>" : '';
		foreach($arr as $tagname => $value) {
			if (is_numeric($tagname)) {
				$tagname = $value['TagName'];
				unset($value['TagName']);
			}
			if(!is_array($value)) {
				$s .= "<{$tagname}>".(!is_numeric($value) ? '<![CDATA[' : '').$value.(!is_numeric($value) ? ']]>' : '')."</{$tagname}>";
			} else {
				$s .= "<{$tagname}>".self::array2xml($value, $level + 1)."</{$tagname}>";
			}
		}
		$s = preg_replace("/([\x01-\x08\x0b-\x0c\x0e-\x1f])+/", ' ', $s);
		return $level == 1 ? $s."</xml>" : $s;
	}
}

/**
 * 功能模块定义, 用户定义独立的功能用于应答请求. 
 * 工作流程:
 *	  - 编辑匹配规则时, 如果 $isNeedExtendFields 为真, 则在编辑表单中嵌入并扩展所需的字段( 通过 fieldsFormDisplay, fieldsFormValidate fieldsFormSubmit 三个成员函数)
 *	  - 配置参数, 如果 $settings 不为空, 则在模块编辑的界面中按照 $settings 定义增加配置参数选项. 调用时包含 modules 目录下定义使用模块标识(tolowwer)为名的子目录中的文件.
 *		如: 如果 ChatRobot 模块存在配置项为 'settings' => '配置参数', 那么将在模块配置的界面中显示链接 "配置参数", 点击后的目标页面将会包含 /source/modules/chatrobot/settings.inc.php
 */
abstract class WeModule {

	/**
	 * 模块标识, 如ChatRobot, WeatherReporter; 与对应实现类名称对应 ChatRobotModule, WeatherReporterModule
	 */
	public $name;

	/**
	 * 模块名称, 如聊天 天气预报
	 */
	public $title;

	/**
	 * 功能描述, 用于自动生成菜单, 请使用动词描述此模块. 如 陪你聊天, 帮你查天气预报
	 */
	public $ability;

	/**
	 * 是否需要扩展规则匹配字段
	 */
	public $isNeedExtendFields;

	/**
	 * 需要显示的独立的配置参数页面
	 * 格式:
	 *	  配置项(亦即文件名) => 配置项名称
	 */
	public $settings;

	/**
	 * 需要附加至规则表单的字段内容, 编辑规则时如果类型为当前模型, 则调用此方法将返回内容附加至规则表单之后
	 * @param int $rid 如果操作为更新规则, 则此参数传递为规则编号, 如果为新建此参数为 0
	 * @return string 要附加的内容(html格式)
	 */
	abstract function fieldsFormDisplay($rid = 0);

	/**
	 * 验证附加至规则表单的字段内容, 编辑规则时如果类型为当前模型, 则在保存规则之前调用此方法验证自定义字段的有效性
	 * @param int $rid 如果操作为更新规则, 则此参数传递为规则编号, 如果为新建此参数为 0
	 * @return string 验证的结果, 如果为空字符串则表示验证成功, 否则返回验证失败的提示信息 
	 */
	abstract function fieldsFormValidate($rid = 0);

	/**
	 * 编辑规则时如果类型为当前模型, 则在提交成功后调用此方法
	 * @param int $rid 规则编号
	 * @return void
	 */
	abstract function fieldsFormSubmit($rid = 0);
	/**
	 * 在列表中删除规则如果类型为当前模型，则在删除成功后调用此方法，做一些删除清理工作。
	 * @param int $rid 规则id,必填值
	 * @return <boolean | error> 如果操作成功则返回True,否则返回error信息
	 */
	abstract function ruleDeleted($rid = 0);
	/**
	 * 模块设置时调用此方法用于显示表单项。
	 * @param array $settings
	 */
	public function settingsFormDisplay($settings = array()) {}
	
	public function template($filename, $flag = TEMPLATE_INCLUDEPATH) {
		global $_W;
		list($path, $filename) = explode(':', $filename);
		$source = IA_ROOT . "/source/modules/$path/template/{$filename}.html";  
		if(!is_file($source)) {
			$source = "{$_W['template']['source']}/{$_W['template']['current']}/{$filename}.html";
		}
		if(!is_file($source)) {
			exit("Error: template source '{$filename}' is not exist!");
		}
		$compile = "{$_W['template']['compile']}/{$_W['template']['current']}/{$path}/{$filename}.tpl.php";
		if (DEVELOPMENT || !is_file($compile) || filemtime($source) > filemtime($compile)) {
			template_compile($source, $compile);
		}
		switch ($flag) {
			case TEMPLATE_DISPLAY:
			default:
				extract($GLOBALS, EXTR_SKIP);
				include $compile;
				break;
			case TEMPLATE_FETCH:
				extract($GLOBALS, EXTR_SKIP);
				ob_start();
				ob_clean();
				include $compile;
				$contents = ob_get_contents();
				ob_clean();
				return $contents;
				break;
			case TEMPLATE_INCLUDEPATH:
				return $compile;
				break;
			case TEMPLATE_CACHE:
				exit('暂未支持');
				break;
		}
	}
}

/**
 * 模块处理程序, 当匹配此模块的消息到来时, 使用此对象处理对象并返回处理结果
 * 流程: 
 *	  - 系统会自自动初始化 $message, $inContext, $rule, $module 成员. 如果为上下文响应对话, 则不会初始化 $rule 成员
 *	  - 系统调用 isNeedInitContext 方法, 判断是否需要初始化上下文环境, 如果需要则 初始化 $contexts 成员
 *	  - 系统调用 respond 方法, 获取响应内容并返回给微信接口
 *	  - 系统调用 isNeedSaveContext 方法, 判断是否需要保存本次会话至上下文环境, 如果需要保存 则将上一步返回的响应内容保存至 $response 成员, 然乎将本实例保存至上下文对象中
 *	  - 调用结束
 *  注意:
 *	  此对象可能被序列化保存以达成上下文传递. 因此, 你可能需要使用魔术函数 __sleep 和 __wakeup 方法进行特定清理和初始化操作.
 */
abstract class WeModuleProcessor {
	/**
	 * 模块标识, 如ChatRobot, WeatherReporter; 与对应实现类名称对应 ChatRobotModuleProcessor, WeatherReporterModuleProcessor
	 */
	public $name;

	/**
	 * 本次请求消息, 此属性由系统初始化
	 */
	public $message;

	/**
	 * 本次对话是否未上下文响应对话
	 */
	public $inContext;

	/**
	 * 本次请求所匹配的规则, 此属性由系统初始化
	 */
	public $rule;

	/**
	 * 本次请求所匹配的处理模块, 此属性由系统初始化
	 */
	public $module;

	/**
	 * 响应内容, 注意此成员仅在对象作为上下文时有用. 系统不会使用此成员的内容响应至微信接口
	 */
	public $response;

	/**
	 * 本次处理的上下文环境, 说明:
	 * 上下文环境针对用户相关, 不同的用户保存为独立的上下文.
	 * 存储方式理解为 ModuleProcessor 对象栈, 即最后一次对话保存在栈顶, 第一次对话保存在栈底, 每个元素为一个 ModuleProcessor 对象实例
	 * 此成员仅按照 isNeedInitContext 方法方式初始化
	 */
	public $contexts;

	/**
	 * 判断处理程序是否需要上下文环境
	 * @return int 如果返回 0, 代表不需要上下文, 如果返回大于 0 的数值, 将初始化指定条数的上下文数据, 如果返回 -1 将处理所有上下文数据
	 */
	abstract function isNeedInitContext();

	/**
	 * 应答此条请求, 如果响应内容为空. 将越过此模块调用更低层的模块
	 * @return string
	 */
	abstract function respond();

	/**
	 * 判断是要需要保存本次对话至上下文环境
	 * @return bool
	 */
	abstract function isNeedSaveContext();
}

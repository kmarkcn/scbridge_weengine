<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');
$current['designer'] = ' class="current"';
checkaccount();
$menusetcookie = 'menuset' . $_W['weid'];
if($_W['ispost']) {
	if($_GPC['do'] == 'remove') {
		$token = client_token();
		$url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token={$token}";
		$content = ihttp_get($url);
		if(empty($content)) {
			message('接口调用失败，请重试！');
		}
		$dat = $content['content'];
		$result = @json_decode($dat, true);
		if($result['errcode'] == '0') {
			isetcookie($menusetcookie, '', -500);
			message('已经成功删除菜单， 请重新创建. ', create_url('menu'));
		} else {
			message('公众平台返回接口错误, 错误内容为: ' . $menus['errmsg']);
		}
	}
	if($_GPC['do'] == 'refresh') {
		isetcookie($menusetcookie, '', -500);
		message('已清空缓存， 将重新从公众平台接口获取菜单信息. ', create_url('menu'));
	}
	require model('rule');
	$mDat = $_GPC['do'];
	$menus = json_decode($mDat, true);
	if(!is_array($menus)) {
		message('操作非法.');
	}
	$ms = array();
	$ms['button'] = array();
	foreach($menus as $m) {
		if(empty($m['sub_button'])) {
			$rid = intval($m['rule']);
			$rule = rule_single($rid);
			$ms['button'][] = array(
				'type'=>'click',
				'name'=>urlencode($m['name']),
				'key'=>"{$m['key']}:{$m['rule']}:{$rule['rule']['module']}"
			);
		} else {
			$set = array();
			foreach($m['sub_button'] as $s) {
				$rid = intval($s['rule']);
				$rule = rule_single($rid);
				$set[] = array(
					'type'=>'click',
					'name'=>urlencode($s['name']),
					'key'=>"{$s['key']}:{$s['rule']}:{$rule['rule']['module']}"
				);
			}
			$ms['button'][] = array(
				'name'=>urlencode($m['name']),
				'sub_button'=>$set
			);
		}
	}
	$dat = json_encode($ms);
	$dat = urldecode($dat);
	$token = client_token();
	$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$token}";
	$content = ihttp_post($url, $dat);
	$dat = $content['content'];
	$result = @json_decode($dat, true);
	if($result['errcode'] == '0') {
		isetcookie($menusetcookie, '', -500);
		message('已经成功创建菜单. ', create_url('menu'));
	} else {
		message('公众平台返回接口错误, 错误内容为: ' . $menus['errmsg']);
	}
}
$dat = $_GPC[$menusetcookie];
if(empty($dat)) {
	$token = client_token();
	$url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token={$token}";
	$content = ihttp_get($url);
	if(empty($content)) {
		message('获取菜单数据失败，请重试！');
	}
	$dat = $content['content'];
}
$menus = @json_decode($dat, true);
if(empty($menus) || !is_array($menus)) {
	message('获取菜单数据失败，请重试！');
}
if($menus['errcode'] && !in_array($menus['errcode'], array(46003))) {
	message('公众平台返回接口错误, 错误内容为: ' . $menus['errmsg']);
}
if(is_array($menus['menu']['button'])) {
    foreach($menus['menu']['button'] as &$m) {
        $pieces = explode(':', $m['key'], 3);
        $m['key'] = $pieces[0];
        $m['rid'] = $pieces[1];
        foreach($m['sub_button'] as &$s) {
            $pieces = explode(':', $s['key'], 3);
            $s['key'] = $pieces[0];
            $s['rid'] = $pieces[1];
        }
    }
}
isetcookie($menusetcookie, $dat, 86400);
template('menu/designer');

function client_token() {
	global $_W;
	if (empty($_W['account']['key']) || empty($_W['account']['secret'])) {
		message('请填写公众号的appid及appsecret！', create_url('account/post', array('id' => $_W['weid'])), 'error');
	}
	$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$_W['account']['key']}&secret={$_W['account']['secret']}";
	$content = ihttp_get($url);
	if(empty($content)) {
		message('获取菜单数据失败，请重试！');
	}
	$token = @json_decode($content['content'], true);
	if(empty($token) || !is_array($token)) {
		message('获取菜单数据失败，请重试！');
	}
	$token = $token['access_token'];
	if(empty($token)) {
		message('获取菜单数据失败，请重试！');
	}
	return $token;
}

<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');

include model('rule');
$pindex = max(1, intval($_GPC['page']));
$psize = 20;
$module = empty($_GPC['module']) ? 'basic' : $_GPC['module'];
$list = rule_search("weid = '{$_W['weid']}' AND module = '$module' " . (!empty($_GPC['keyword']) ? " AND keyword LIKE '%{$_GPC['keyword']}%'" : ''), $pindex, $psize, $total);
$cids = $parentcates = array();
if (!empty($list)) {
	foreach($list as &$item) {
		$condition = "`rid`={$item['id']}";
		$item['keywords'] = rule_keywords_search($condition);
		!empty($item['cid']) && $cids[$item['cid']] = $item['cid'];
	}
}
if (!empty($cids)) {
	$cates = pdo_fetchall("SELECT name, parentid, id FROM ".tablename('category')." WHERE id IN (".implode(',', $cids).")", array(), 'id');
	foreach ($cates as $cate) {
		if (!empty($cate['parentid'])) {
			if (isset($cates[$cate['parentid']])) {
				$cates[$cate['id']]['parent'] = $cates[$cate['parentid']]['name'];
			} else {
				$temp = pdo_fetch("SELECT name, id FROM  ".tablename('category')." WHERE id = '{$cate['parentid']}' LIMIT 1");
				$cates[$temp['id']]['parent'] = $temp['name'];
			}
		}
	}
}
$types = array('', '等价', '包含', '正则表达式匹配');
$pager = pagination($total, $pindex, $psize);

$wechat = $_W['setting']['wechats'][$_W['weid']];
$temp = iunserializer($wechat['default']);
if (is_array($temp)) {
	$wechat['default'] = $temp;
	$wechat['defaultrid'] = $temp['id'];
}
$temp = iunserializer($wechat['welcome']);
if (is_array($temp)) {
	$wechat['welcome'] = $temp;
	$wechat['welcomerid'] = $temp['id'];
}

$mymodule = pdo_fetchall("SELECT * FROM ".tablename('modules')." AS a LEFT JOIN ".tablename('wechats_modules')." AS b ON a.mid = b.mid WHERE b.enabled = '1' AND b.weid = '{$_W['weid']}'");
template('rule/display');

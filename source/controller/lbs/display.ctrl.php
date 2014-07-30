<?php
/**
 * LBS
 */
defined('IN_IA') or exit('Access Denied');
include model('lbs');

$type = intval($_GPC['type']);

$list = empty($type) ? location_search($_W['weid']) : location_search_bytype($_W['weid'], $type);
template('lbs/display');
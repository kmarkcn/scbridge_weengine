<?php
/**
 * 活动模块
 *
 * [WeEngine System] Copyright (c) 2013 WE7.CC
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
	public function dohotel_center() {
		include $this->template('scbridge:hotel_product');
	}
	public function domember_center() {
		global $_W, $_GPC;
		if(empty($from_user)){
			include $this->template('scbridge:register');
		}else{
			include $this->template('scbridge:member_center');
		}
	}
	
	public function domember_rigister() {
		global $_W, $_GPC;
		include $this->template('scbridge:register');
	}
	
}
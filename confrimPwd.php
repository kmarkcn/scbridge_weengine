<?php
require './source/bootstrap.inc.php';
require_once IA_ROOT . '/source/model/member.mod.php';

$admin_pwd = $_POST['admin_pwd'];
global $_W,$_GPC;

if($admin_pwd == "scbridge"){
	echo("1");
}else{
	echo("0");
}


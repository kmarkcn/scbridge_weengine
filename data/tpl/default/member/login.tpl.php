<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
	<div id="main-single" class="container-12 form horizontal">
		<h5 class="login_bg">登录</h5>
		<form action="" method="post">
			<dl class="clearfix">
				<dt>用户名/邮箱</dt>
				<dd><input autocomplete="off" type="text" name="username" class="txt grid-4" /></dd>
				<dd></dd>
			</dl>
			<dl class="clearfix">
				<dt>密码</dt>
				<dd><input type="password" name="password" class="txt grid-4" /></dd>
				<dd></dd>
			</dl>
			<dl class="clearfix">
				<dt></dt>
				<dd><input type="submit" name="submit" class="btn grid-2 fl" value="登录"/><input type="hidden" name="token" value="<?php echo $_W['token'];?>" /></dd>
				<dd></dd>
			</dl>
		</form>
	</div>
<?php include template('common/footer', TEMPLATE_INCLUDEPATH);?>

<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
	<div id="main-column" class="container-12 clearfix member-center">
		<div class="column2 grid-3 alpha omega">
			<?php include template('account/nav', TEMPLATE_INCLUDEPATH);?>
		</div>
		<div class="column1 grid-10 alpha omega">
			<div class="form">
				<div class="form_h">
				<?php if(empty($id)) { ?>
				<h6>添加公众帐号</h6>
				<?php } else { ?>
				<h6>设置公众号</h6>
				<?php } ?>
				</div>
				<form action="" method="post" onsubmit="return formcheck(this)">
				<input type="hidden" name="id" value="<?php echo $wechat['weid'];?>" />
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<th>公众号名称</th>
					<td>
						<input type="text" name="name" class="txt grid-4 alpha pin" value="<?php echo $wechat['name'];?>" />
						<div class="notice">您可以给此公众号起一个名字, 方便下次修改和查看. </div>
					</td>
				</tr>
				<?php if(!empty($id)) { ?>
				<tr>
					<th style="color:red">接口地址</th>
					<td>
						<input type="text" class="txt grid-4 alpha pin" value="<?php echo $_W['siteroot'];?>api.php?hash=<?php echo $wechat['hash'];?>" readonly="readonly" />
						<div class="notice">设置“微信公众平台接口”配置信息中的接口地址</div>
					</td>
				</tr>
				<tr>
					<th style="color:red">微信Token</th>
					<td>
						<input type="text" name="wetoken" class="txt grid-4 alpha pin" value="<?php echo $wechat['token'];?>" readonly="readonly" /> <a href="javascript:;" onclick="tokenGen();">生成新的</a>
						<div class="notice">与微信公众平台接入设置值一致，必须为英文或者数字，长度为3到32个字符. 请妥善保管, Token 泄露将可能被窃取或篡改微信平台的操作数据.</div>
					</td>
				</tr>
				<?php } ?>
				<tr>
                    <th>公众号AppId</th>
					<td>
						<input type="text" name="key" class="txt grid-4 alpha pin" value="<?php echo $wechat['key'];?>" />
						<div class="notice">请填写微信公众平台后台的AppId</div>
					</td>
				</tr>
				<tr>
					<th>公众号AppSecret</th>
					<td>
						<input type="text" name="secret" class="txt grid-4 alpha pin" value="<?php echo $wechat['secret'];?>" />
						<div class="notice">请填写微信公众平台后台的AppSecret, 只有填写这两项才能管理自定义菜单</div>
					</td>
				</tr>
				<tr>
					<th>微信号</th>
					<td>
						<input type="text" name="account" class="txt grid-4 alpha pin" value="<?php echo $wechat['account'];?>" />
						<div class="notice">您的微信帐号，本平台支持管理多个微信公众号</div>
					</td>
				</tr>
				<tr>
					<th>原始帐号</th>
					<td>
						<input type="text" name="original" class="txt grid-4 alpha pin" value="<?php echo $wechat['original'];?>" />
						<div class="notice">微信公众帐号的原ID串，<a href="index.php?act=help&do=wx_uid" target="blank">怎么查看微信的原始帐号？</a></div>
					</td>
				</tr>
				<?php if(!empty($wechat['username'])) { ?>
				<tr>
					<th>二维码</th>
					<td>
						<img src="<?php echo $_W['attachurl'];?>/qrcode_<?php echo $wechat['weid'];?>.jpg?weid=<?php echo $wechat['account'];?>" width="150" />
					</td>
				</tr>
				<?php } ?>
				<?php if(!empty($wechat['username'])) { ?>
				<tr>
					<th>头像</th>
					<td>
						<img src="<?php echo $_W['attachurl'];?>/headimg_<?php echo $wechat['weid'];?>.jpg?weid=<?php echo $wechat['account'];?>" width="85" />
					</td>
				</tr>
				<?php } ?>
				</table>
				<div class="form_h">
				<h6>设置微信号<span>设置用户名密码后，程序会自动采集您的相关信息。还可以进行群发操作。</span></h6>
				</div>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<th>微信公众登录用户</th>
					<td>
						<input type="text" name="wxusername" id="username" class="txt grid-4 alpha pin" value="<?php echo $wechat['username'];?>" autocomplete="off" />
						<div class="notice"></div>
					</td>
				</tr>
				<tr>
					<th>微信公众登录密码</th>
					<td>
						<input type="password" name="wxpassword" class="txt grid-4 alpha pin" value="<?php if(!empty($wechat['password'])) { ?>******<?php } ?>" autocomplete="off"  />
						<div class="notice"></div>
					</td>
				</tr>
				<tr>
					<th>登录验证码</th>
					<td>
						<input type="text" name="verify" class="txt grid-1 alpha pin" value="" autocomplete="off" onfocus="verifyGen()"  />
						<img src="" id="imgverify"> <a href="javascript:;" onclick="verifyGen()">换一张</a>
						<div class="notice"></div>
					</td>
				</tr>
				<tr>
					<th></th>
					<td>
						<input type="checkbox" name="islogin" value="1" checked="checked" /> 是否验证登录
						<div class="notice">勾选此选项后，提交后将验证您的微信帐号。如果有任何异常信息，请取消此选项。</div>
					</td>
				</tr>
				<?php if(!empty($wechat['username'])) { ?>
				<tr>
					<th></th>
					<td>
						<a href="<?php echo create_url('account/sync', array('id' => $wechat['weid']))?>">同步微信公众平台帐号信息</a>
						<div class="notice">填写公众号帐号密码后，如果发现信息没有同步成功，请点击此选项进行手动同步。</div>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<th></th>
					<td>
						<input name="submit" type="submit" value="提交" class="mt10 btn grid-2 alpha" />
						<input type="hidden" name="token" value="<?php echo $_W['token'];?>" />
					</td>
				</tr>
				</table>
				</form>
			</div>
		</div>
	</div>
<?php include template('common/footer', TEMPLATE_INCLUDEPATH);?>

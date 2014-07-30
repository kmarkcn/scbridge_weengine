<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="format-detection" content="telephone=no" />
<title>预订</title>
<link rel="stylesheet" type="text/css" href="./resource/tencent/shop/styles/wei_dialog.css?v=1.0.1" />
<link rel="stylesheet" type="text/css" href="./resource/tencent/shop/styles/wei_canyin.css?v=1.0.11" />
<script src="./resource/tencent/shop/scripts/wei_webapp_v2_common.js?v=1.0.5"></script>
<script src="./resource/tencent/shop/scripts/wei_industry_common.js?v=1.0.5"></script>
<script src="./resource/tencent/shop/scripts/wei_dialog.js?v=1.0.0"></script>
<style>

</style>
</head>
<body id="page_order">

    <div class="footFix topSearch" data-indent="140" data-ffix-top="0" id="topSearch">
        <form method="post" action="<?php echo create_url('index/module', array('name' => 'shop', 'do' => 'shoplist'))?>">
            <div class="box">
                <p><input type="text" placeholder="搜索店名、地址..." name="keyword" value=""/></p>
                <span>
                    <input type="submit" value="搜索" onClick="if(_trim(document.getElementsByName('keyword')[0].value)){return this.form.submit();}else{return false}"/>
                    <input type="reset" value="取消" onClick="document.getElementsByName('keyword')[0].value='';return this.form.submit();"/>
                </span>
            </div>
        </form>
    </div>
    <?php if(is_array($list)) { foreach($list as $row) { ?>
	<section>
	<article>
	<span><img
		src="<?php echo $_W['attachurl'];?><?php echo $row['picture'];?>"/></span>
	<h1><?php echo $row['name'];?></h1>
	<p><?php echo $row['address'];?></p>
	</article>
	<ul>
		<li><a href="tel:<?php echo $row['phone'];?>" class="order">预订</a></li>
		<li><a
			href="http://bluesun.duapp.com/source/modules/wxlbs/baidumapLocation.php?t1=<?php echo $row['y_axis'];?>,<?php echo $row['x_axis'];?>&addr=<?php echo $row['address'];?>&name=<?php echo $row['name'];?>"
			class="gps">位置</a></li>
		<li><a href="<?php echo create_url('index/module', array('name' => 'shop', 'do' => 'shopshow', 'shop_id' => $row['id']))?>" class="reality">实景</a></li>
	</ul>
	</section>
	<?php } } ?>
            
    <script>
    var needLocate = 'no';
    needLocate = needLocate != 'no';

_onPageLoaded(function(){

    if (needLocate) {
        locate();
        return;
    }

    //修复滑动时搜索条(有较多输入内容)闪烁残缺的现象
    if (_env.ios){
        var ts = _q('.topSearch');
        var ts2 = ts.cloneNode();
        ts2.id = 'fixIOSTopSearch';
        ts2.style.zIndex = 98;
        ts2.innerHTML = '';
        ts.parentNode.appendChild(ts2);
    }

    (function() {

        // ios下系统默认弹窗
        if (_isIOS) {
            return null;
        }

        var orderBtns = _qAll('.order');
        
        for(var i=0;i<orderBtns.length;i++) {
            orderBtns[i].onclick = function(e) {
                var self = this;
                var phone = self.getAttribute('href').match(/\d*-?\d+/);
                if (!phone[0]) {phone[0]='';}
                MDialog.confirm(
                    '', '<span style="text-align:center !important;display:inline-block;width:205px;">是否拨打预订电话<br/>'+phone[0]+'？</span>', null,
                    '确定', function(){
                        isCancle = false;

                        location.href = self.getAttribute('href');
                    }, null,
                    '取消', null, null,
                    null, true, true
                );

                return false;
            }
        }
    })();
});


</script>
</body>
</html>
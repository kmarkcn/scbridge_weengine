<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="format-detection" content="telephone=no" />
<title><?php echo $title;?></title>
<link rel="stylesheet" type="text/css" href="./resource/tencent/shop/styles/wei_dialog.css?v=1.0.1" />
<link rel="stylesheet" type="text/css" href="./resource/tencent/shop/styles/wei_canyin.css?v=1.0.11" />
<script src="./resource/tencent/shop/scripts/wei_webapp_v2_common.js?v=1.0.5"></script>
<script src="./resource/tencent/shop/scripts/MTouchSlider.js?v=1.0.3"></script>
<script src="./resource/tencent/shop/scripts/wei_dialog.js?v=1.0.0"></script>

</head>
<body id="page_viewLarge" onorientationchange="window.location.reload()">

<section class="picBox"><div class="box">
    <div id="ts1" class="touchSlider" data-min-height="364" data-dot-color="#fff" data-drag-callback="showshopInfor">
        <div class="inner"><div class="sld_bar">
            <section class="sld_page">
                <figure>
                    <img src="<?php echo $_W['attachurl'];?><?php echo $shop['showpic'];?>" />
                </figure>
            </section>
                    </div></div>
        <div class="sldDotWarpper"><div class="sld_dots" data-relative-layout="1"></div></div>
        <div class="shopInforWrap">
            <div class="shopInfor"><?php echo $shop['description'];?><br/>
                                                                                                                                                                                                    
                            </div>

                            <div class="shopInfor"></div>
                            <div class="shopInfor"></div>
                            <div class="shopInfor"></div>
            
                    </div>
    </div>
</div></section>

<script>

window.addEventListener('DOMContentLoaded', function(){

    //遍历图片宽度为屏幕宽度
    _forEach('.sld_page img', function(autoImg){
        autoImg.style.width = window.innerWidth + "px";
    });
    //固定外层高度为屏幕高度
    var fixedHeight = _q('.picBox');
    fixedHeight.style.height = window.innerHeight + 'px';

    var _fixedSupport = _testFixedSupport();

    var ms = new MTouchSlider( document.querySelector('#ts1'), {
        pageCls: '.sld_page',
        barCls: '.sld_bar',
        dotsCls: '.sld_dots'
    });
    /**
    new MTouchSlider( document.querySelector('#ts2'), {
        pageCls: '.sld_page2',
        barCls: '.sld_bar2',
        dotsCls: '.sld_dots2'
    });
    */
    ms.setWidth(window.innerWidth);

    window.addEventListener(_touchSupport ? 'touchmove' : 'scroll', function(evt) {
        var bTop = _q('body').scrollTop;
        var wHt = window.innerHeight;
        var wWh = window.innerWidth;
        
        //分类标题浮动
        var t1 = _q('.outmenu').clientHeight + _q('.picBox').clientHeight;
        t1 = t1||150;
        var topul = _q('.slidetit');
        
        if (bTop > t1){         
            _addClass(topul.parentNode, 'fix');
            if (_fixedSupport){
                topul.style.position = 'fixed';
                topul.style.top = 0;
                topul.style.left = .5*(wWh-320) + 'px';
            }else{
                topul.style.top = (bTop-t1)+'px';
                topul.style.left = 0;
            }
        }else{
            _removeClass(topul.parentNode, 'fix');
            topul.style.top = 0;
            topul.style.left = 0;
            topul.style.position = 'relative';
        }   
    });
});
    var shopInfor = _qAll('.shopInfor');
    function showshopInfor(slider, page, idx) {
        for(var i = 0; i < shopInfor.length; i++) {
            if(i === idx) {
                shopInfor[i].style.display = '';
            } else {
                shopInfor[i].style.display = 'none';
            }
        }
    }
    showshopInfor(null, null, 0);

</script>
</body>
</html>
<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE HTML> 
<html lang="en-us">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
<link href="./resource/justgo/css/jquery.flipcountdown.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="./resource/justgo/css/product-content.css" />
<link rel="stylesheet" type="text/css" href="./resource/justgo/css/public.css" />

<script type="text/javascript" src="./resource/justgo/js/jquery.min.js"></script>
<script type="text/javascript" src="./resource/justgo/js/product-content.js"></script>
<script src="./resource/justgo/js/jquery.flipcountdown.js" type="text/javascript"></script>


<title>当前旅游产品</title>
</head>

<body>
	<div class="head" style='position:fixed;left:0px;top:0px;'>    	
        <h1 class="head-h1"><?php echo $travels['product_name'];?><input type='hidden' value='<?php echo $day;?>' id='cur_day'><input type='hidden' value='<?php echo $sche_num;?>' id='cal_total_days'><input type='hidden' value='<?php echo $travels['id'];?>' id='cur_travel'></h1> 
        <a class="head-l"  href="./index.php?act=module&name=justgo&do=show_list">
        	<img src="./resource/justgo/img/product_list/details4.png"/>
        </a>
        <div class="head-r">
        	<div class="head-r-child">
            	<span class="b-triangle"></span>
            </div>
            <ul class="head-nav">
            	<li class="li1"><a href="./index.php?act=module&name=justgo&do=product_content&id=<?php echo $travels['id'];?>&day=1">第一天</a></li>
            </ul>
        </div>
        
        	
    </div>
    <div class="content">
    	
    	
    	<div class="pc-goods" style='margin-top:80px;margin-bottom:30%;'>
    		<?php echo $schedule['content'];?>
        	<div style="clear:both;"></div>
        </div>
    	    <script>
    		$(function(){
    			$('.pc-goods img').each(function(){
    				var maxWidth = $('.pc-goods').width(); // 图片最大宽度
    				var ratio = 0; // 缩放比例
    				var width = $(this).width(); // 图片实际宽度
    				var height = $(this).height(); // 图片实际高度
					if(height>0){
						$(this).css("height",'100px');
					}
    				if(width == 0) {
    					$(this).css("width", maxWidth); // 设定实际显示宽度
    				}

    				// 检查图片是否超宽
    				if(width > maxWidth){
    					$(this).css("width", maxWidth); // 设定实际显示宽度
    				}
    			})
    			var cur_day=$('#cur_day').val();
    			if(cur_day==0){
    				cur_day=1;
    			}
    			cur_day-=1;
    			$('.head-nav li').each(function(){
    				$(this).css('display','none');
    				$(this).removeClass("head-nav-li");
    			})
    			//$(".head-nav li:eq("+cur_day+")").removeClass("head-nav-li");
    			$(".head-nav li:eq("+cur_day+")").css('display','block');
    			$(".head-nav li:eq("+cur_day+")").addClass("li1");
    		})
    		$('.head-r-child').click(function(){
				$('.head-nav li').each(function(){
					$(this).addClass("head-nav-li");
    				$(this).removeClass("li1");
    				$(this).css('display','block');
    			})
    			$(".head-nav li:eq(0)").removeClass("head-nav-li").addClass("li1");
    			
    			
    		})
    		</script>
    </div>
    <!--以下是底部确认支付按钮和倒计时-->
    <div class="foot" style='position:fixed;width:100%;bottom:0px;'>
              <div style="text-align: right; padding-right: 5%" >
                 <a href="./index.php?act=module&name=justgo&do=show_detail&id=<?php echo $travels['id'];?>">
                  <img src="./resource/justgo/img/product_list/confirm_button.png" width="30%" style='margin-bottom:5px;'>
                </a>
              </div>
              <!-- product details banner | this area should have 2 dynamic functions one is a drop-down table and the another is a count down clock numbers.-->
              <div style="background-color:#C7000a; height: 35px; margin: 0 5% 0 5%">
              <!--<img src="img/product_list/detail_banner.png" width="60%"/> -->
                <span id="detail_banner">
                  		说走价：<a style='font-size:22px;color:#fff;'><?php echo $travels['total_price'];?></a>&nbsp;&yen;
                </span>
                
                <div style="text-align: right; display: inline; padding-top: 5px; padding-right: 5px; float:right;" id="product_timeleft"></div>
                <script>
                var NY = Math.round((new Date("<?php echo(date('m/d/Y h:i:s',$travels['deadline']))?>")).getTime()/1000);
                $('#product_timeleft').flipcountdown({
                    tick:function(){
                        var nol = function(h){
                            return h>9?h:'0'+h;
                        }
                        var	range  	= NY-Math.round((new Date()).getTime()/1000),
                            secday  = 86400, sechour = 3600,
                            days 	= parseInt(range/secday),
                            
                            thours	= parseInt((range%secday)/sechour) + days*24,
                            hours   = thours > 48 ? 48 : thours,
                            min		= parseInt(((range%secday)%sechour)/60),
                            sec		= ((range%secday)%sechour)%60;
                        return nol(thours)+' '+nol(min)+' '+nol(sec);
                    },
                    size:"xs"
                });
                </script>
              </div>
    </div>
  	<!--以上是底部确认支付按钮和倒计时-->
  
  
</body>
</html>

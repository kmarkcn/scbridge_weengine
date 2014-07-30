<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="format-detection" content="telephone=no">

        <title>幸运大转盘抽奖</title>
        <link href="./source/modules/lotery/template/css/activity-style.css" rel="stylesheet" type="text/css">
    </head>

    <body class="activity-lottery-winning" >
        <div  class="main"  >
            <script type="text/javascript">
                var loadingObj = new loading(document.getElementById('loading'),{radius:20,circleLineWidth:8});   
                loadingObj.show();   
            </script>
            <div id="outercont"  >
                <div id="outer-cont">
                    <div id="outer"><img src="./source/modules/lotery/template/images/activity-lottery-5.png"></div>
                </div>
                <div id="inner-cont">
                    <div id="inner"><img src="./source/modules/lotery/template/images/activity-lottery-2.png"></div>
                </div>
            </div>
            <div class="content"  >
                <div class="boxcontent boxyellow"  id="result"  style="display:none"  >
                    <div class="box">
                        <div class="title-orange" style="color: black;"><span>恭喜你中奖了</span></div>
                        <div class="Detail">
                            <p>你中了：<span class="red" id="prizetype" ></span></p>
                            <p>奖品为：<span class="red" id="sncode" ></span></p>
                            <p class="red" id="red">我们已经记录下了你的中奖记录,首次中奖提交登记信息以获取奖品发放通知!  </p>
                            <?php if(!empty($member)) { ?>
                            <p>
                                <input class="pxbtn" name="提 交"  id="save-btnn" type="button" value="继续抽奖">
                                <input class="pxbtn" name="提 交"  id="save-btnm" type="button" value="修改登记信息">
                            </p>
                            <?php } else { ?>
                            <p>
                                <input class="pxbtn" name="提 交"  id="save-btn" type="button" value="提交登记信息">
                            </p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="boxcontent boxyellow">
                    <div class="box">
                        <div class="title-green" style="color: black; font-size: large;">活动说明：</div>
                        <div class="Detail">
                            <p><span><?php echo $lotery['description'];?></span></p>
                        </div>
                    </div>
                    <div class="box">
                        <div class="title-green" style="color: black; font-size: large;">游戏规则：</div>
                        <div class="Detail">
                            <?php echo $lotery['rule'];?>
                        </div>
                    </div>
                </div>
                
            </div>

        </div>

        <script src="./source/modules/lotery/template/js/jquery.js" type="text/javascript"></script> 
        <script type="text/javascript">


            $(function() {
                window.requestAnimFrame = (function() {
                    return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame ||
                        function(callback) {
                        window.setTimeout(callback, 1000 / 60)
                    }
                })();
                var totalDeg = 360 * 3 + 0;
                var steps = [];
                var lostDeg = [36, 96, 156, 216, 276,336];
                var prizeDeg = [6, 66, 126,186,246,306];
                var prize, sncode;
                var award;
                var now = 0;
                var a = 0.01;
                var outter, inner, timer, running = false;
                var url="<?php echo create_url('index/module', array('do' => 'getaward', 'name' => 'lotery', 'id' => $id, 'from_user' => $_GPC['from_user']))?>";
                function countSteps() {
                    var t = Math.sqrt(2 * totalDeg / a);
                    var v = a * t;
                    for (var i = 0; i < t; i++) {
                        steps.push((2 * v * i - a * i * i) / 2)
                    }
                    steps.push(totalDeg)
                }
                function step() {
                    outter.style.webkitTransform = 'rotate(' + steps[now++] + 'deg)';
                    outter.style.MozTransform = 'rotate(' + steps[now++] + 'deg)';
                    if (now < steps.length) {
                        running = true;
                        requestAnimFrame(step)
                    } else {
                        running = false;
                        setTimeout(function() {
                            if (prize != null) {  
                                $("#prizetype").text(prize+"等奖");
                                $("#result").slideToggle(500);
                                $("#outercont").slideUp(500)
                            } else {
                                alert("没有中奖，继续努力哦！")
                            }
                        },
                        200)
                    }
                }
                function start(deg) {
                    deg = deg || lostDeg[parseInt(lostDeg.length * Math.random())];
                    running = true;
                    clearInterval(timer);
                    totalDeg = 360 * 5 + deg;
                    steps = [];
                    now = 0;
                    countSteps();
                    requestAnimFrame(step)
                }
                window.start = start;
                outter = document.getElementById('outer');
                inner = document.getElementById('inner');
                i = 10;
                $("#inner").click(function() {
                    if (running) return;
                    if (prize != null) {
                        return
                    }
        
                    $.ajax({
                        url: url,
                        dataType: "json",
                        data: {
                            t: Math.random()
                        },
                        beforeSend: function() {
                            running = true;
                            timer = setInterval(function() {
                                i += 5;
                                outter.style.webkitTransform = 'rotate(' + i + 'deg)';
                                outter.style.MozTransform = 'rotate(' + i + 'deg)'
                            },
                            1)
                        },
                        success: function(data) {
                            if (data.message.status=="-1") {
                                alert(data.message.message)
                                clearInterval(timer);
                                return
                            }
                
                            if (data.message.status=="1") {
                                prize = parseInt(data.message.level);    
                                $("#sncode").text(data.message.award);
                                award = data.message.message;                          
                                start(prizeDeg[parseInt(prize)-1])
                            } else {
                                prize = null;
                                start()
                            }
                            running = false;
                        },
                        error: function() {
                            prize = null;
                            start();
                            running = false;
                        },
                        timeout: 1000
                    })
                })
            });
            $("#save-btn").bind("click",
            function() {
                var regUrl="<?php echo create_url('index/module', array('do' => 'register', 'name' => 'lotery', 'id' => $id, 'from_user' => $_GPC['from_user']))?>";
                window.location.href=regUrl;
            });

            $("#save-btnn").bind("click",
            function() {
                var lotUrl="<?php echo create_url('index/module', array('name' => 'lotery', 'do' => 'lottery', 'id' => $id, 'from_user' => $_GPC['from_user']))?>";
                window.location.href=lotUrl;
            });
             $("#save-btnm").bind("click",
            function() {
                var lotUrl="<?php echo create_url('index/module', array('name' => 'lotery', 'do' => 'register', 'id' => $id, 'from_user' => $_GPC['from_user']))?>";
                window.location.href=lotUrl;
            });
        </script>
    </body>
</html>
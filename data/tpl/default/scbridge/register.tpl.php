<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE HTML> 
<html lang="en-us">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
<link rel="stylesheet" type="text/css" href="./resource/scbridge/css/member-alter.css" />
<link rel="stylesheet" type="text/css" href="./resource/scbridge/css/public.css" />
<script type="text/javascript" src="./resource/scbridge/js/jquery.min.js"></script>
<title>homepage</title>
</head>

<body>
	<div class="ma">
    	<!--以下是头部-->
        <div class="public-head-father">
        	<div class="public-head">
                <a href="./index.php?act=module&name=scbridge&do=hotel_content&h_id=<?php echo $hotel['id'];?>"><img class="public-left"  src="./resource/scbridge/img/header-left.png"></a>
                会员中心
            </div>
        </div>
        <!--以上是头部-->
        <!--以下是中间内容-->
        <div class="ma-content">
            <table class="ma-table" cellpadding="0" cellspacing="0">
            	<tr>
                	<td class="ma-td2"><img style="width:46%;" src="./resource/scbridge/img/register/register_01.png"></td>
                </tr>
                <tr>
                	<td class="ma-td1" style="padding-top:12%;">手机号 : <input class="ma-input" type="telephone"></td>
                </tr>
                <tr>
                    <td class="ma-td1">姓&#12288;名 : <input class="ma-input /*ma-input-false*/" type="text"></td>
                </tr>
                <tr>
                    <td class="ma-td1">
                    	<a href="register-win.html" ><img style="width:57%; margin:10% 0 0 0;" src="./resource/scbridge/img/register/register_02.png"><a>
                    </td>
                </tr>
            </table>
         </div>
        
        <!--以上是中间内容-->
        
        
       <!--以下是浮动的底部-->
       <div class="public-foot">
       		<a href="#"><img class="public-foot-01" src="./resource/scbridge/img/member-center_16.png"></a>
            <a href="#"><img class="public-foot-02" src="./resource/scbridge/img/member-center_17.png"></a>
            <a href="#"><img class="public-foot-03" src="./resource/scbridge/img/member-center_18.png"></a>
       </div>
       <!--以上是浮动的底部 -->
        
</div>
</body>
</html>

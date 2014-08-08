<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE HTML> 
<html lang="en-us">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
<link rel="stylesheet" type="text/css" href="./resource/scbridge/css/public.css" />
<link rel="stylesheet" type="text/css" href="./resource/scbridge/css/room-reserve.css" />
<link rel="stylesheet" type="text/css" href="./resource/scbridge/css/lhgcalendar.css" />
<script type="text/javascript" src="./resource/scbridge/js/jquery.min.js"></script>
<script type="text/javascript" src="./resource/scbridge/js/lhgcore.min.js"> </script>
<script type="text/javascript" src="./resource/scbridge/js/lhgcalendar.min.js"> </script>
<script type="text/javascript" src="./resource/scbridge/js/public.js"> </script>

<title>会议预定填写</title>

</head>

<body>
	<div class="ma">
    	<!--以下是头部-->
        <div class="public-head-father" style="position:relative; left:0; top:0;">
            <div class="public-head">
                <img class="public-left"  src="./resource/scbridge/img/header-left.png" onclick="javascript:window.history.back(-1);">
                会议预定填写
            </div>
        </div>
        <!--以上是头部-->
        
        
        <!--以下是中间内容-->
        <div class="rr-content" style="padding:20px 0;">
        	
            <div class="rr-goods">
            	<table class="rr-table" cellpadding="0" cellspacing="0">
                	<tr>
                    	<td class="rr-td-01">会议日期</td>
                        <td><input class="rr-input-01" id="cal1" /></td>
                    </tr>
                    <tr>
                    	<td class="rr-td-01">结束日期</td>
                        <td><input class="rr-input-01" id="cal2" /></td>
                    </tr>
                    <tr>
                    	<td class="rr-td-01">议厅名称</td>
                        <td>
                        	<ul class="rr-select  rr-input-01 textfocus">
                            	<li>111听</li>
                                <li>222听</li>
                                <li>333听</li>
                            </ul>
                        	
                        </td>
                    </tr>
                    <tr>
                    	<td class="rr-td-01" style="color:red; height:20px;"></td>
                        <td class="rr-td-02" style="color:red; height:20px;">
                        	<span>(该厅可容纳<span>200</span>人)</span>
                            <span>(该厅可容纳<span>300</span>人)</span>
                            <span>(该厅可容纳<span>400</span>人)</span>
                            
                        </td>
                    </tr>
                    <tr>
                    	<td class="rr-td-01">姓<span style="color:transparent;">备注</span>名</td>
                        <td><input class="rr-input-01"/></td>
                    </tr>
                    <tr>
                    	<td class="rr-td-01">手<span style="color:transparent;">备注</span>机</td>
                        <td><input class="rr-input-01"/></td>
                    </tr>
                    <tr>
                    	<td class="rr-td-01">备<span style="color:transparent;">备注</span>注</td>
                        <td><textarea class="rr-area textfocus">选填项</textarea></td>
                    </tr>
                    <tr>
                    	<td class="rr-td-01"></td>
                        <td style="height:80px;"><a href="register.html"><img class="public-btn-reserve"  style="position:relative; left:0; top:0;" src="./resource/scbridge/img/hotel-reserve_03.png"></a></td>
                    </tr>
                </table>
            </div>
            
            
        </div>
        
        <!--以上是中间内容-->
        
        
        
        <!--以下是预定-->
        <!--以上是预定-->
        
        
       <!--以下是浮动的底部-->
       <div class="public-foot" style="position:relative; left:0; top:0;">
       		<a href="#"><img class="public-foot-01" src="./resource/scbridge/img/member-center_16.png"></a>
            <a href="#"><img class="public-foot-02" src="./resource/scbridge/img/member-center_17.png"></a>
            <a href="#"><img class="public-foot-03" src="./resource/scbridge/img/member-center_18.png"></a>
       </div>
       <!--以上是浮动的底部 -->
        
</div>
</body>
</html>

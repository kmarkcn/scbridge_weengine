<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<style type="text/css">
body, html,#allmap {
	width: 100%;
	height: 100%;
	overflow: hidden;
	hidden;margin:0;
}
#l-map{
	height:100%;
	width:78%;
	float:left;
	border-right:2px solid #bcbcbc;
}
#r-result{
	height:100%;
	width:20%;
	float:left;
}
</style>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=4b2dd1cd6b8fa9934bd59cd2221739dc"></script>
</head>
<body>
<div id="allmap"></div>
<?php
$t1 = $_GET['t1'];
$addr = $_GET['addr'];
$name = $_GET['name'];

echo '
<script type="text/javascript">
var map = new BMap.Map("allmap");

map.addControl(new BMap.NavigationControl());    
map.addControl(new BMap.ScaleControl());    
map.addControl(new BMap.OverviewMapControl());    

var point = new BMap.Point('.$t1.');
map.centerAndZoom(point, 15); 
var marker = new BMap.Marker(point); 
map.addOverlay(marker); 

var opts = {  
 width: 120,     
 height: 60,    
 title: "'.$name.'",  // 信息窗口标题 
}  
var infoWindow = new BMap.InfoWindow("'.$addr.'", opts);  // 创建信息窗口对象  
//map.openInfoWindow(infoWindow, map.getCenter());      // 打开信息窗口  

marker.addEventListener("click", function(){    
 map.openInfoWindow(infoWindow, map.getCenter());   
});    
</script>';
?>
</body>
</html>
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
$t1=$_GET['t1'];
$t2=$_GET['t2'];
echo '
<script type="text/javascript">
var map = new BMap.Map("allmap");
var mw1 = new BMap.Point('.$t1.');
var mw2 = new BMap.Point('.$t2.');
var w = new BMap.WalkingRoute(map, {renderOptions:{map: map, autoViewport: true}});
w.search(mw1, mw2);
</script>';
?>
</body>
</html>
<?php defined('IN_IA') or exit('Access Denied');?><?php include template('mobile/header_property', TEMPLATE_INCLUDEPATH);?>
<div class="photo_area">
        <div class="photo_show" onclick="">
            <img src="./resource/tencent/img/home_banner.png" width="100%" height="auto" alt=""/>
        </div>
    </div>


    <div class="wrapper" id="container" style="background-color:#400000; height: auto">
   	  <div id="button_area" style="padding-top: 30px; text-align:center;">
        	<div>
                <span style="display:inline">
                	<a href="<?php echo create_url('index/module', array('name' => 'property', 'do' => 'propertyabout'))?>"><img src="./resource/tencent/img/home_about.png" width="120px"></a>
                <span>
                <span>
                	<span style="position: absolute;">
                        <a href="<?php echo create_url('index/module', array('name' => 'property', 'do' => 'intercom'))?>"><img src="./resource/tencent/img/home_inter.png" width="157px"></a>                     
                    </span>
                    <span style="position: relative;">
                        <a href="<?php echo create_url('index/module', array('name' => 'property', 'do' => 'livingcity'))?>"><img src="./resource/tencent/img/home_city.png" width="157x"></a>                 
                	</span>
                </span>
            </div>
            <br>
            <div>
                <!--<span style="display:inline">
                	<a href="<?php echo create_url('index/module', array('name' => 'property', 'do' => 'charge'))?>"><img src="./resource/tencent/img/home_property.png" width="158" height="65px"></a>
                </span>
                <span>
                    <a href="#"><img src="./resource/tencent/img/home_repair.png" width="120" height="65px" style="margin-left: 1px; margin-top: 1px"></a>
                </span>-->
                <span style="display:inline">
                	<a href="tel:02885761222"><img src="./resource/tencent/img/tel_bak.png" width="283px"></a>
                </span>
           </div>
      </div>
        
    	<!-- <div id="contact" style="padding-top: 30px; text-align:center;">
        	<a href="tel:02885761222"><img src="./resource/tencent/img/tel.png" width="80%";></a>
        </div> -->
        
        <div id="foot">
        	<img src="./resource/tencent/img/footer.png" width="100%">
        </div>
    </div>
    
</body>
</html>
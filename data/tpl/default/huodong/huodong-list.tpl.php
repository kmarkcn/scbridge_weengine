<?php defined('IN_IA') or exit('Access Denied');?><?php include template('mobile/header_tencent', TEMPLATE_INCLUDEPATH);?>
    <div class="photo_area">
        <div class="photo_show" onclick="">
            <img src="./resource/tencent/img/1009_v2.jpg" width="100%" alt=""/>
        </div>
    </div>
    <div class="box">
        <ul class="box_list">
            <?php if(is_array($category)) { foreach($category as $row) { ?>
            <?php if($row['status'] == '3') { ?><li class="end">
            	<a href="<?php echo create_url('index/module', array('name' => 'huodong', 'do' => 'huodongdetails', 'huodong_id' => $row['id']))?>" onclick="">
            <?php } else { ?><li class="">
				<a href="<?php echo create_url('index/module', array('name' => 'huodong', 'do' => 'huodongdetails', 'huodong_id' => $row['id']))?>" onclick="">
			<?php } ?>                
                    <img src="<?php echo $_W['attachurl'];?><?php echo $row['picture'];?>" width="55" height="55" alt="" style="margin-right:5px"/>
                    <h4><?php echo $row['name'];?><?php if($row['status'] == '2') { ?><i class="ico_hot"></i><?php } ?></h4>
                    <p class="name"><?php echo $row['brief'];?></p>
                    <p class="weak">活动时间: <?php echo date('Y.m.d', $row['start_date'])?> - <?php echo date('Y.m.d', $row['end_date'])?></p>
                    <em>
                        <?php if($row['status'] == '0') { ?>
							未开始
						<?php } else if($row['status'] == '1') { ?>
							报名中
						<?php } else if($row['status'] == '2') { ?>
							活动中
						<?php } else if($row['status'] == '3') { ?>
							已结束
						<?php } ?>
                    </em>
                </a>
            </li>
            <?php } } ?>
        </ul>
    </div>
	
	<script type="text/javascript" src="./resource/tencent/controllers/act-list.js?ver=1.0"></script>
<?php include template('mobile/footer_tencent', TEMPLATE_INCLUDEPATH);?>
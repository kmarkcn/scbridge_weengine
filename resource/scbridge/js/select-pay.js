// JavaScript Document

$(function(){
	$('.pay_img').click(function(){
		
		$(this).addClass('pay_border').siblings().removeClass('pay_border');
	});
	//
	$('.sp_btn_sure').click(function(){
		var img_index = $('.pay_border').index();
		alert(img_index);
		
	});
})


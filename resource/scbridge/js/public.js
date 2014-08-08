// JavaScript Document


//日期插件的调用
J(function(){
	
	J('#cal1').calendar({ format:'yyyy年MM月dd日' });
	J('#cal2').calendar({ format:'yyyy年MM月dd日' });
	J('#cal3').calendar({ format:'yyyy年MM月dd日' });
	J('#cal4').calendar({ format:'yyyy年MM月dd日' });
});

$(function(){
	//预定界面房间和人数相关联
	var l = false;
	$('.rr-select').children('li')
				   .click(function(){
					   
					   
					   var a_index = $(this).index();
					   $('.rr-td-02').children()
					   				 .eq(a_index)
									 .show()
									 .siblings()
									 .hide();
					   
					   if(l){
						   $(this).siblings().hide();
					   		
							l = false;
							
					   }
					   else{
					   		$(this).siblings().show();
							l = true;
					   }
	})

})
	

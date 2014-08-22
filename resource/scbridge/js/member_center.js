

$(function(){
	$('#select_record').change(function(){
		var val = $('#select_record').val();
		if(val == 1){
			$('#hotel_record').show();
			$('#goods_record').hide();
		}
		else if(val == 2){
			$('#hotel_record').hide();
			$('#goods_record').show();
		}
	})
})

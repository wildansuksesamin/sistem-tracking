function cari_no_kendaraan(){

	var search_val = $('input#search_input').val();
	var target = $('div#search_result');
	var str = "<ul class='list-unstyled'>" ;

	target.html("");
		
	$.ajax({
	
		url : base_url+'/Ajax_request/request_car_list',
		data : { 'search_val' : search_val },
		method : 'GET',
		dataType : 'JSON',
		success : function(data){
		
			var count = data.length;
			var i ;
			
			for(i = 0 ; i<count ; i++ ){

				var _id = data[i].id;
				var _no_kendaraan = data[i].no_kendaraan;
				var _lat = data[i].lat;
				var _lgt = data[i].lgt;
				
				if(condition == 'report'){
					str += "<li class='item_list'>"+
								"<label><input class='id_cb' type='checkbox' value='"+_id+"'>"+
								"<small>"+_no_kendaraan+"</small></label></li>";
					
				}else{
					str += "<li class='item_list'>"+
								"<label><input class='id_cb' type='checkbox' value='"+_id+"'>"+
								"<small>"+_no_kendaraan+"</small></label>"+
									"<button id='"+_lat+"/"+_lgt+"' class='go_button btn btn-default'>"+
										"<span class='glyphicon glyphicon-arrow-right'></span>"+
									"</button></li>"
				}
			}
				
			str += '</ul>';
			target.html(str) ;	
				
		}
	});
		
}

$('document').ready(function(){
	$('div.tabs').show();
	
	$('input#search_input').focus(function(){
		$(this).css('background-color','#D4FFAA');
	});
	
	$('a.list_perusahaan').click(function(event){
		event.preventDefault();
		$(this).next().slideToggle(500);
	});
	
	$('a.my_tabs').click(function(event){
	
		event.preventDefault();
		$('div#search_result').html("");
		$('input.id_cb').prop('checked',false);
		$('div.tab_item').hide();
		$('input#search_input').attr('value','');
		
		var tabs_target = $(this).attr('href');
		
		$('div#'+tabs_target).show();
	});
	
	$('a#cari_car_list').click(function(event){
		event.preventDefault();
		cari_no_kendaraan();
	});

});
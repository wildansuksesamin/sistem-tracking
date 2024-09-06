var lintasan_s=new Array();
function initiate(){
	var center= new google.maps.LatLng(-6.155001,106.872021);
	var mapOption={
		zoom: 14,
		center: center,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	var transitLayer = new google.maps.TransitLayer();
	
	map1 = new google.maps.Map(document.getElementById('map1'), mapOption);	
	map2 = new google.maps.Map(document.getElementById('map2'), mapOption);
	map3 = new google.maps.Map(document.getElementById('map3'), mapOption);
	map4 = new google.maps.Map(document.getElementById('map4'), mapOption);
	
	transitLayer.setMap(map1);
	transitLayer.setMap(map2);
	transitLayer.setMap(map3);
	transitLayer.setMap(map4);
}

function datePicker(){
	$('input.date_picker').datepicker({
		dateFormat:"yy-mm-dd"
	});
}

function buat_lintasan(map,no_kendaraan,tanggal,index){
	$.ajax({
			url:base_url+"/Trail/lintasan",
			data :{ 'no_kendaraan' : no_kendaraan , 'tanggal' : tanggal },
			method :'GET',
			dataType : 'json',
			success : function(data){
				var koordinat= new Array();
				for(var d=0;d<data.length;d++){
					var pos=new google.maps.LatLng(data[d].lat,data[d].lgt);
					koordinat.push(pos);
				}
				lintasan=new google.maps.Polyline({
					path : koordinat,
					geodesic : true ,
					strokeColor : '#0000FF',
					strokeOpacity : 1.0,
					strokeWeight : 2
				});
				lintasan_s[index]=lintasan ;
				lintasan.setMap(map);
				map.setCenter(new google.maps.LatLng(data[0].lat,data[0].lgt));
			}
		});
}
		
$(document).ready(function(){

	datePicker();
	google.maps.event.addDomListener(window, 'load', initiate);
	
	$('button.view_full').click(function(){
		
		var parent=$(this).parent();
		var sibling_div=$(this).siblings('div');
		parent.attr('class','col-md-12').siblings().hide();
		sibling_div.attr('class','enlarge');
		
	});
	
	$('button.view_normal').click(function(){
		var parent=$(this).parent();
		var sibling_div=$(this).siblings('div');
		parent.attr('class','col-md-6').siblings().show();
		sibling_div.attr('class','normal');
	});
	
	$('button#view_trail_1').click(function(){
	
		if(lintasan_s[0]){lintasan_s[0].setMap(null);}
		var no_kendaraan=$('select#select_map1').val();
		var tanggal=$('input#date1').val();
		buat_lintasan(map1,no_kendaraan,tanggal,0);
		
	});
	
	$('button#view_trail_2').click(function(){
	
		if(lintasan_s[1]){lintasan_s[1].setMap(null);}
		var no_kendaraan=$('select#select_map2').val();
		var tanggal=$('input#date2').val();
		buat_lintasan(map2,no_kendaraan,tanggal,1);
		
	});
	
	$('button#view_trail_3').click(function(){
	
		if(lintasan_s[2]){lintasan_s[2].setMap(null);}
		var no_kendaraan=$('select#select_map3').val();
		var tanggal=$('input#date3').val();
		buat_lintasan(map3,no_kendaraan,tanggal,2);
		
	});
	
	$('button#view_trail_4').click(function(){
	
		if(lintasan_s[3]){lintasan_s[3].setMap(null);}
		var no_kendaraan=$('select#select_map4').val();
		var tanggal=$('input#date4').val();
		buat_lintasan(map4,no_kendaraan,tanggal,3);
		
	});
});
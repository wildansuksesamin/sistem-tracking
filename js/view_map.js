var container = document.getElementById("map_container");
var map;
var marker_arr = new Array();
var id_string = '';
var timeOut;
var marker_timeout;
var info_arr = new Array();

function showOnMap(){

	id_string='';
	var n;
	var nilai;
	var id_list=$('input.id_cb');
	
	for(n=0;n<id_list.length;n++){
		if(id_list[n].checked){
		
			nilai=id_list[n].value;
			id_string+= ","+nilai;
		}
	}
		
	if(id_string.length>1){
		clearMarker();
		clearTimeout(timeOut);
		var timeOut = setTimeout(function(){
			fmarker();
		},3000);
		
	}else{
		clearTimeout(timeOut);
		clearMarker();
	}		
}
	
function viewMap(){
		
	var center= new google.maps.LatLng(lat,lgt);
		var mapOption={
			zoom: 14,
			center: center,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
			
	map = new google.maps.Map(document.getElementById('map_container'), mapOption);
}

function getAlamat(position,index){
	
	var geocoder = new google.maps.Geocoder;
	geocoder.geocode({'location': position },function(result,status){
		if (status === google.maps.GeocoderStatus.OK) {
			if(result[1]){
				var addres = String(result[0].formatted_address);
				if(index != null){
					info_arr[index]+=addres;
				}
				//console.log(addres);
			}else{
				if(index != null){
					info_arr[index]+="Alamat Tidak Tersedia ";
				}
			}
		}else{
			if(index != null){
				info_arr[index]+="Geocoder Gagal Karena "+status;
			}
			//console.log(status);
		}
	});			
}

function fmarker(){
	
	clearTimeout(marker_timeout);
	clearMarker();
	
	if(id_string.length>3){
	
		var url = base_url+"/Map/setMarker?ids="+id_string+"&ts="+Math.random();
		
		$.ajax({
			url : base_url+"/Map/setMarker?ids="+id_string+"&ts="+Math.random(),
			data : { 'ids' : id_string , 'ts' : Math.random() },
			method : 'GET',
			dataType : 'json',
			success : function(data){
			
				var count=data.length;
				var i;
				
				var ltlg = new Array();
				var alamat = new Array();
				
				for(i=0;i<count;i++){
					
					var latlgt = { lat : parseFloat(data[i].lat), lng : parseFloat(data[i].lgt) };
					ltlg.push(latlgt);
					var pos = new google.maps.LatLng(data[i].lat,data[i].lgt);
					var id = data[i].id;
					var kecepatan = data[i].kecepatan;
					var task = data[i].task;
					var date = data[i].date_p;
					var no_kendaraan = data[i].no_kendaraan;
					var ico = base+"res/start.png";
					if(data[i].status == "0")ico = base+"res/stop.png";
					var markerImage = new google.maps.MarkerImage(ico, new google.maps.Size(60, 60), null, new google.maps.Point(0,0));
					
					var marker=new MarkerWithLabel({
					
							position:pos,
							map:map,
							icon:markerImage,
							labelContent : data[i].no_kendaraan,
							labelAnchor : new google.maps.Point(-34,-10),
							labelClass : "labels",
							labelStyle : {opacity:0.75},
							
					});
						
					marker_arr[i]=marker;
					
					var contents="<div id='info'><div class='info_header'><h5>"+no_kendaraan+"</h5></div><table>"+
						"<tr><td rowspan='6'><img src='"+base+"/res/4.png'></td><td><span> ID : </span></td><td><span>"+id+"</span></td></tr>"+
						"<tr><td><span>No Kendaraan : </span></td><td><span>"+no_kendaraan+"</span></td></tr>"+
						"<tr><td><span><span> Kecepatan : </span></td><td><span>"+kecepatan+" Km/Jam</span></td></tr>"+
						"<tr><td><span><span> Task : </span></td><td><span>"+task+"</span></td></tr>"+
						"<tr><td><span><span> Tanggal : </span></td><td><span>"+date+"</span></td></tr>"+
						"<tr><td colspan='5'></td></tr></table></div>";
						
					
					info_arr[i]=contents;
					getAlamat(pos,i);	
					(function(marker, i) {
						  // add click event
						google.maps.event.addListener(marker, 'click', function() {
							var info = info_arr[i];
								
							infowindow = new google.maps.InfoWindow({
									content: info
							});
								infowindow.open(map, marker);
							});
						})(marker, i);
					}
			}
		});
		marker_timeout = setTimeout(function(){
		return fmarker();
		},10000);
	}else{
		clearTimeout(marker_timeout);
	}
}
	
	
function clearMarker(){
	
	for(var s=0;s<marker_arr.length;s++){
			marker_arr[s].setMap(null);
	}
	marker_arr = new Array();
}
	
function pointer(lat,lgt){
		
	var mypos=new google.maps.LatLng(lat,lgt);
	map.setCenter(mypos,0);
	map.setZoom(14);
}
	
$('button#view_all').click(function(){
	id_string='';
	clearMarker();
	clearTimeout(marker_timeout);
	s_car_list();
	$('button.list_perusahaan').click(function(){
		$(this).next().toggle(100);
	});
});

$(document).ready(function(){
	
	google.maps.event.addDomListener(window, 'load', viewMap);
	
	//s_car_list();
	$('input.id_cb').change(function(){
		showOnMap();
	});
	
	$('button.go_button').click(function(){
		var position_string = $(this).attr('id');
		var position_arr = position_string
			.split('/')
			.map(function(n){
				return Number(n);
			});
		pointer(position_arr[0],position_arr[1]);
		//console.log(position_arr[0]+"--"+position_arr[1])
	});
	
	$('button#normal_map').hide();
	
	$('input#tracking').change(function(){
		
		var isChecked=$(this).is(':checked');
		
		if(!isChecked){
			clearTimeout(marker_timeout);
		}else{
			clearTimeout(marker_timeout);
			marker_timeout=setTimeout(function(){
				return fmarker();
			},10000);
		}

	});
	
	$('button#zoom_plus').click(function(){
		var mapZoom=map.getZoom();
		if(mapZoom != 21){
			map.setZoom(mapZoom + 1);
		}
	});
	
	$('button#zoom_minus').click(function(){
		var mapZoom=map.getZoom();
		if(mapZoom != 0){
			map.setZoom(mapZoom - 1);
		}
	});
	
	$('button#print_map').click(function(){
		var content=document.getElementById('map_container');
		var win=window.open();
		win.document.write(content.innerHTML);
		//win.print();
		//win.close();
	});
	
	$('button#full_map').click(function(){
		$('div#item_list').hide();
		$('div#map_control').attr('class','col-sm-12 col-md-12');
		$('button#normal_map').show();
		$(this).hide();
	});
	
	$('button#normal_map').click(function(){
		$('div#item_list').show();
		$('div#map_control').attr('class','col-sm-10 col-md-10');
		$('button#full_map').show();
		$(this).hide();
	});
});

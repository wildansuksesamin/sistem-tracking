var fields='';
var date='';
var ids='';
var header=new Array();
var tes='';
var for_report;

function s_car_list(){
	
	var str='';
	var count_list=list_data.length;
	var count_perusahaan=perusahaan.length;
	var c;
	var d;
	var obj_list_a;
	var onj_list_b
	
	$("div#list_view").html("");
	
	if(count_perusahaan>0){
		for(var x=0;x<count_perusahaan;x++){
		
			obj_list_a=perusahaan[x];
			
			var id_perusahaan=obj_list_a['id_perusahaan'];
			str+="<button id='"+id_perusahaan+"' class='list_perusahaan' style='width:100%;'>"+obj_list_a['nama_perusahaan']+"</button>"+
				"<ul class=list-unstyled>";
			for(var y=0;y<count_list;y++){
				obj_list_b=list_data[y];
				if(obj_list_b['id_perusahaan']==id_perusahaan){
					str+="<li class='item_list' id='"+y+"'>"+
					"<label><input class='id_cb' type='checkbox' onchange='getIds()' value='"+obj_list_b['id']+"'>"+
					"<small> "+obj_list_b['no_kendaraan']+"</small>"+
					"</label></li>"
				}
			}
			str+="</ul>";
		}
	}
		
	$("div#list_view").html(str);
}

function datePicker(){

	$('input#tanggal1').datepicker({
		dateFormat:"yy-mm-dd"
	});
	$('input#tanggal2').datepicker({
		dateFormat:"yy-mm-dd"
	});
	
}

function getIds(){
	
	ids='';
	var checkbox_id=$('input.id_cb');
	for(var cb=0;cb<checkbox_id.length;cb++){
		if(checkbox_id[cb].checked){
			ids +=','+checkbox_id[cb].value;
		}
	}	
}

function getFields(){
	
	fields='no_kendaraan';
	header=new Array();
	header.push('No Kendaraan');
	var field_e=$('input.fields_e');
	for(var xo=0;xo<field_e.length;xo++){
		if(field_e[xo].checked){
			fields+=','+field_e[xo].value;
			var name = field_e[xo].getAttribute("name")
			header.push(name);
		}
	}	
}

function getDate(){

	date = $('input#tanggal1').val()+'C'+$('input#tanggal2').val();
	
}

$(document).ready(function(){
	//s_car_list();
	datePicker();
	
	$('button#view_report').click(function(){
		getIds();
		getFields();
		getDate();
		
		$('div#report_view').html("");
		
		if((ids.length>4)&&(fields != 'no_kendaraan')&&($('input#tanggal1').val()!='')&&($('input#tanggal2').val()!='')){

			
			$.ajax({
				url : base_url+"/Report/generateReport",
				data : { 
					'ids' : ids ,
					'field' : fields , 
					'date' : date 
					},
				method :'GET',
				dataType : 'json',
				success : function(data){
					
					for_report=data;
					$.jsontotable(data, { id: '#report_view', header: false });
					var table=$('#report_view table');
					var head ='<thead><tr>';
					for(var tr=0;tr<header.length;tr++){
						head +='<th>'+header[tr]+'</th>'
					}
					head +='</tr></thead>';
					
					table.prepend(head);
					table.dataTable().addClass("table table-striped");
				
				},error : function(xhr,status){
					alert('Request GAGAL'+xhr+status);
				}
			});
			
		}else{
			alert("Data Tidak Lengkap");
		}
	});
	
	$('input#check_all').change(function(){
		$('input.fields_e').prop('checked',$(this).prop('checked'));
	});
	
	/*$('button.list_perusahaan').click(function(){
		$(this).next().toggle(100);
	});*/
	
});
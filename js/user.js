$(document).ready(function(){
	function cekForm(){
		var nama=$('input#nama').val();
		var email=$('input#email').val();
		var alamat=$('input#alamat').val();
	}
	
	function cekPassword(){
		var pass1=$('input#old_password').val();
		var new_pass1=$('input#new_password1').val();
		var new_pass2=$('input#new_password2').val();
		
		if(pass1.length < 5 || new_pass1.length < 5 || new_pass2.length <5){
			alert("minimal password 5 huruf");
			return false;
		}else if(new_pass1 != new_pass2){
			alert("Password baru harus sama");
			return false;
		}else{
			return true;
		}
	}
});
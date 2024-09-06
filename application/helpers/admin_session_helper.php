<?php
	class Admin_session{
	
		private $CI;
		
		public function __construct(){
			
		}
		
		public static function cekAdmin(){
			$CI =& get_instance();
			
			if($CI->session->admin==""){
				session_destroy();
				redirect('Admin');
				exit;
			}else{
				$CI->session->mark_as_temp('admin',300);
			}
		}
		
	}
?>
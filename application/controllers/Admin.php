
<?php
/*
/----------------------------------------------------------------------
/2015 m arif zainuddin , sozaemonafro@gmail.com
/Aplikasi web sederhana untuk tracking map
/author : m arif zainuddin
/cotact phone : 085711336281 
/email : sozaemonafro@gmail.com
----------------------------------------------------------------------
*/
require_once "Admin_base.php";

	class Admin extends Basic_Admin{
	
		function __construct(){
			parent::__construct();
			$this->init_load();
			
		}
		
		function init_load(){
			$this->load->model("MAdmin");
		}
		
		public function index($pesan="welcome admin"){
		
			
			$data["pesan"]=str_replace("_"," ",$pesan.$this->input->post("user"));
			
			if($this->input->post("submit")){
				
				if($this->MAdmin->login()){
					$this->session->admin = $this->input->post("user");
					redirect("Admin/adminMainPage");
					exit;
				}else{
					$data["pesan"]="Username dan Password Tidak Sesuai";
				}
			}
			session_destroy();
			$this->load->view("admin/login_admin.html",$data);
		}
		//----------------------sesi admin-------------------------------//
		
		public function adminMainPage(){
		
			$this->admin_session();
			$this->admin_sidebar();
			$this->load->view("admin/admin_main_page.html");
			
		}
		
		public function rubahPassword($pesan=""){
			$this->admin_session();
			$data["pesan"]=str_replace("_"," ",$pesan);
			$this->admin_sidebar();
			$this->load->view("admin/admin_rubah_password.html",$data);
		}
		
		public function gantiPassword(){
			$this->admin_session();
			$this->form_validation->set_rules(
				"old_password",
				"Password Lama",
				"required");
			$this->form_validation->set_rules(
				"passwrod_baru",
				"Password Baru",
				"required|min_length[6]");
			$this->form_validation->set_rules(
				"passwrod_baru2",
				"Password Konfirmasi",
				"required|min_length[6]|matches[passwrod_baru]");
			
			if($this->form_validation->run()==FALSE){
				$this->rubahPassword();
			}else{
				$this->MAdmin->gantiPassword();
			}
		}
		
		public function logout(){
		
			$this->session->admin="";
			session_destroy();
			redirect("Admin");
			exit;
		}
		
	}
?>
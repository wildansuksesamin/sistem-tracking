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

	class User extends CI_Controller{
		
		private $_main_template;
	
		function __construct(){
			parent::__construct();
			$this->init_load();
		}
		
		private function init_load(){
			$this->load->model('MUser');
			$this->load->helper('main_template');
			$this->_main_template = new Mtemplate();
		}
		
		public function index(){
		
			$this->editData();
			
		}
		
		private function editData($pesan=''){
		
			$this->cekSession();
			
			$data['pesan']=$pesan;
			
			if($this->input->post('submit')){
			
				if($this->MUser->updateData()){
					$data['pesan']="Data Berhasil Dirubah";
				}else{
					$data['pesan']="Data Gagal Dirubah";
				}
			}
			
			$user_data = $this->MUser->getUserData();
			
			foreach($user_data as $_u_data){
				$data['nama_depan']		= $_u_data['nama_depan'];
				$data['nama_belakang'] 	= $_u_data['nama_belakang'];
				$data['email']			= $_u_data['email'];
				$data['alamat']			= $_u_data['alamat'];
			}
			
			$data['javascript'] = array(
				'[home]js/jquery-ui/jquery-ui.js',
				'[home]js/bootstrap/js/bootstrap.min.js',
				'[home]js/user.js'
			);
			
			$this->_main_template->make_header();
			$this->load->view('user_edit.html',$data);
			$this->load->view('footer.html');
		}
		
		public function ubahPassword($pesan='Rubah_Password'){
		
			$data['pesan']=str_replace("_"," ",$pesan);
					
			$this->cekSession();
			if($this->input->post('submit')){
				$this->updatePassword();
			}
			$this->_main_template->make_header();
			$this->load->view('rubah_password.html',$data);
			$this->load->view('footer.html');
			
		}
		
		private function updatePassword(){
			
			$this->cekSession();
			$this->form_validation->set_rules(
				'old_password', 
				'Password Lama', 
				'required|min_length[5]|max_length[12]'
			);
			$this->form_validation->set_rules(
				'new_password1', 
				'Password Baru', 
				'required|min_length[5]|max_length[12]'
			);
			$this->form_validation->set_rules(
				'new_password2', 
				'Konfirmasi Password', 
				'required|min_length[5]|max_length[12]|matches[new_password1]'
			);
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->ubahPassword('Masih_Ada_Field_Yang_Tidak_Sesuai');
			}else if($this->MUser->updatePassword()){
				redirect('User/ubahPassword/Password_Telah_Diganti');
			}else{
				redirect('User/ubahPassword/Password_Gagal_Diganti');
			}
			
		}
			
		private function cekSession(){
			
			if($this->session->user == ""){
				redirect('Login');
				exit;
			}
			$this->session->mark_as_temp('user',300);
		}
		
		public function logOut(){
			$this->session->user="";
			session_destroy();
			redirect('Login');
		}
	}
?>
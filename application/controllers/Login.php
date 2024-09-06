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

	class Login extends CI_Controller{
		
		private $_template_helper;
		
		public function __construct(){
			parent::__construct();
			$this->init_login();
		}
		
		private function init_login(){
			$this->load->model('MLogin');
			$this->load->helper('main_template');
			$this->_template_helper=new Mtemplate();
		}
		
		function index(){
		
			$psn='Welcome';
			
			if($this->input->post('submit')){
			
				if($this->MLogin->CekLogin()){
					redirect('Map');
					exit;
				}else{
					$psn = 'Username dan Password Tidak Sesuai';
				}
			}

			$this->_template_helper->login_form($psn);
		}
		
		public function guest(){
			$this->session->user='guest';
			redirect('Map');
		}
		
		public function logOut(){
		
			session_destroy();
			redirect('Login');
			
		}
		
		public function forgetPassword(){
		
			
			$data['pesan']='Masukkan Username Dan Email Anda';
			
			if($this->input->post('submit')){
				$this->form_validation->set_rules(
					'username', 
					'Username', 
					'required|min_length[5]|max_length[12]'
				);
				
				$this->form_validation->set_rules(
					'email', 
					'Email', 
					'required|valid_email'
				);
				
				if ($this->form_validation->run() == FALSE){
					$data['pesan']='Masukkan Tidak Sesuai';
				}else{
					if($this->MLogin->cekEmail()){
						redirect('Login/buatPassword');
						exit;
					}else{
						$data['pesan']='Username dan Email Tidak Sesuai';
					}
				}
			}
			
			$this->load->view('lupa_password.html',$data);
		}
		
		public function buatPassword(){
			
			$data['info']='Masukkan Password Baru Anda';
			if($this->input->post('submit')){
				
				$this->form_validation->set_rules(
					'password_baru', 
					'Password', 
					'required',
					array(
						'required' => 'Anda Harus Mengisi %s.'
					)
				);
				$this->form_validation->set_rules(
					'password_baru2', 
					'Password Confirmation', 
					'required|matches[password_baru]',
				array(
					'required' => 'Anda Harus Mengisi %s.',
					'matches' => 'Password Harus Sama'
					)
				);
				
				if ($this->form_validation->run() == FALSE){
					$data['info']='Masukkan Anda Masih Ada Yang Salah';
				}else{
					if($this->MLogin->buatPasswordBaru()){
					
						$this->session->temp_user="";
						session_destroy();
						redirect('Login/passwordSucces');
						exit;
						
					}else{
						$data['info']='Kesalahan Password Gagal Dirubah';
					}
				}
				
			}
			
			$this->load->view('buat_password.html',$data);
		}
		
		public function passwordSucces(){
		
			$msg=array(
				'pesan'=>'Password Anda Telah Diganti',
				'link'=>'Login',
				'link_text'=>'Kembali Kehalaman Login'
				);
						
				$this->load->view('Pesan.html',$msg);
		}
	}
?>

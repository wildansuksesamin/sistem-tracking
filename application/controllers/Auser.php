<?php
	require_once 'Admin_base.php';
	
	class Auser extends Basic_Admin{
		
		public function __construct(){
			parent::__construct();
			$this->init_load();
		}
		
		function init_load(){
			$this->load->model('MAdmin');
			$this->load->library('table');
			$this->table->set_template(
				array(
					'table_open' => '<table class="table table-striped">'
				)
			);
		}
		
		public function addUser(){
		
			$this->admin_session();
			$data['client']=$this->MAdmin->getClient();
			$this->admin_sidebar();
			$this->load->view('admin/user/admin_add_user.html',$data);
			
		}
		
		public function tambahUser(){
		
			$this->form_validation->set_rules(
				'user',
				'Username',
				'required|min_length[3]|is_unique[user.username]'
				);
			$this->form_validation->set_rules(
				'password1',
				'Password',
				'required|min_length[3]'
				);
			$this->form_validation->set_rules(
				'password2',
				'Konfirmasi',
				'required|min_length[3]|matches[password1]'
				);
			$this->form_validation->set_rules(
				'nama_depan',
				'Nama Depan',
				'required|min_length[3]'
				);
			$this->form_validation->set_rules(
				'email','Email',
				'required|valid_email|is_unique[user.email]'
				);
			
			if($this->form_validation->run()==FALSE){
				$this->addUser();
			}else{
				$this->load->model('MAdmin');
				$this->MAdmin->addUser();
			}
			
		}
		
		public function viewUser($pesan="table data user"){
		
			$this->admin_session();
			
			$data['pesan']=str_replace("_"," ",$pesan);
			$data['heading'] = 'Daftar User';
			
			$user = $this->MAdmin->getUser();
			
			$this->table->set_heading('Nama Depan','Nama Belakang','Email','Telepon','Alamat','Operasi');
			
			foreach($user as $_usr){
			
				$this->table->add_row(
					$_usr['nama_depan'],
					$_usr['nama_belakang'],
					$_usr['email'],
					$_usr['telepon'],
					$_usr['alamat'],
					anchor(
						'Auser/deleteUser/'.$_usr['username'],
						'Hapus User',
						array(
							'class' => 'btn btn-danger'
						)
					)
				);
			}
			
			$this->admin_sidebar();
			$this->load->view('admin/table_view.html',$data);
			
		}
		
		public function deleteUser($username){

			$this->load->model('MAdmin');
			$this->MAdmin->hapusUser($username);
		
		}
		
	}
?>
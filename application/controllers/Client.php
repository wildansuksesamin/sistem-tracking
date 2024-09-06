<?php
	require_once 'Admin_base.php';
	
	class Client extends Basic_Admin{
	
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
		
		public function registrasi($pesan=""){
	
			$this->admin_session();
			$data['pesan']=str_replace("_"," ",$pesan);
			$this->admin_sidebar();
			$this->load->view('admin/client/admin_client_registrasi.html',$data);
		}
		
		public function tambahRegistrasi(){
		
			$this->form_validation->set_rules(
				'no_registrasi',
				'No Registrasi',
				'required|min_length[3]|is_unique[client.id_client]'
			);
			
			$this->form_validation->set_rules(
				'nama_client',
				'Nama Client',
				'required|min_length[3]|is_unique[client.nama_client]'
			);
			
			$this->form_validation->set_rules(
				'tanggal',
				'Tanggal',
				'required'
			);
			
			if($this->form_validation->run()==FALSE){
				$this->registrasi();
			}else{
				
				$this->MAdmin->addRegistrasi();
			}
		}
		
		public function viewregistrasi($pesan=""){
			$this->admin_session();
			
			$client = $this->MAdmin->getClient();
			
			$data['pesan']=str_replace("_"," ",$pesan);
			$data['heading'] = 'Daftar Client';
			$data['link'] = array(
				'Tambah Client' => 'Client/registrasi'
			);
			
			$this->table->set_heading('No Client','Nama Client','Tanggal','View Detail','Operasi');
			
			foreach($client as $_cl){
				
				$this->table->add_row(
					$_cl['id_client'],
					$_cl['nama_client'],
					$_cl['tanggal'],
					anchor(
						'Client/detailClient/'.$_cl['id_client'],
						'Detail',
						array(
							'class' => 'btn btn-default'
						)
					),
					anchor(
						'Client/deleteClient/'.$_cl['id_client'],
						'Hapus Client',
						array(
							'class' => 'btn btn-danger'
						)
					)
				);
			}
			
			$this->admin_sidebar();
			$this->load->view('admin/table_view.html',$data);
		}
		
		public function deleteClient($id_client){
		
			
			$this->MAdmin->hapusClient($id_client);
			
		}
		
		public function detailClient($id_client){
			$this->admin_session();
			
			$id_client = $this->encrypt->decode($id_client);
			
			$data['client'] = $this->MAdmin->getClient($id_client);
			$data['client_user'] = $this->MAdmin->clientUser($id_client);
			$data['client_perusahaan'] = $this->MAdmin->clientPerusahaan($id_client);
			
			$this->admin_sidebar();
			$this->load->view('admin/client/admin_client_detail.html',$data);
		}
		
	}
?>
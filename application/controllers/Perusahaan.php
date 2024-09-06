<?php
	require_once 'Admin_base.php';
	
	class Perusahaan extends Basic_Admin{
	
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
		
		public function viewPerusahaan($pesan = ""){
			
			$this->admin_session();
			
			$perusahaan = $this->MAdmin->getSubPerusahaan();
			$data['heading'] = 'Daftar Perusahaan';
			$data['link'] = array(
				'Tambah Perusahaan' => 'Perusahaan/addPerusahaan'
			);
			$data['pesan'] = $pesan ;
			$this->admin_sidebar();
			
			$this->table->set_heading(
				'ID Perusahaan',
				'Nama Perusahaan',
				'Nama Client',
				'Daftar Kendaraan',
				'Operasi'
			);
			
			foreach($perusahaan as $_prhs){
				
				$this->table->add_row(
					$_prhs['id_perusahaan'],
					$_prhs['nama_perusahaan'],
					$_prhs['nama_client'],
					anchor(
						'Perusahaan/detailSubPerusahaan/'.$_prhs['id_perusahaan'],
						'Daftar Kendaraan',
						array(
							'class'=> 'btn btn-default'
						)
					),
					anchor(
						'Perusahaan/hapusPerusahaan/'.$_prhs['id_perusahaan'],
						'Hapus',
						array(
							'class'=> 'btn btn-danger'
						)
					)
				);
			}
			$this->load->view('admin/table_view.html',$data);
		}
		
		public function hapusPerusahaan($id_perusahaan){
		
			$this->admin_session();
			
			if($this->MAdmin->deletePerusahaan($id_perusahaan)){
				redirect('Perusahaan/viewPerusahaan/Data_dihapus');
			}else{
				redirect('Perusahaan/viewPerusahaan/Operasi_gatal');
			}
		}
		public function addPerusahaan($pesan=""){
		
			$this->admin_session();
			
			$data['pesan'] = str_replace("_"," ",$pesan);
			$data['client'] = $this->MAdmin->getClient();
			$this->admin_sidebar();
			$this->load->view('admin/perusahaan/admin_add_perusahaan.html',$data);
			
		}
		
		public function tambahPerusahaan(){
		
			$this->form_validation->set_rules(
				'id_perusahaan',
				'ID Perusahaan',
				'required|min_length[3]|is_unique[sub_perusahaan.id_perusahaan]'
				);
				
			$this->form_validation->set_rules(
				'nama_perusahaan','Nama Perusahaan',
				'required|min_length[3]|is_unique[sub_perusahaan.nama_perusahaan]'
				);
			
			
			if($this->form_validation->run()==FALSE){
				$this->addPerusahaan("");
			}else{
				$this->MAdmin->addPerusahaan();
			}
			
		}
		
		public function detailSubPerusahaan($id_perusahaan){
			
			$this->admin_session();
			$data['detail_perusahaan'] = $this->MAdmin->getDetailSubPerusahaan($id_perusahaan);
			$this->admin_sidebar();
			$this->load->view('admin/kendaraan/admin_kendaraan_perusahaan.html',$data);
		}
		
	}
?>
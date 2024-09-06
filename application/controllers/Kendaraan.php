<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	require_once 'Admin_base.php';
	
	class Kendaraan extends Basic_Admin{
		
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
		
		public function viewKendaraan($pesan=""){
			$this->admin_session();

			$data['pesan']=str_replace("_"," ",$pesan);
			
			$kendaraan = $this->MAdmin->getKendaraan();
			$data['link'] = array(
				'Tambah Kendaraan' => 'Kendaraan/tambahKendaraan'
			);
			
			$data['heading'] = 'Daftar Kendaraan' ;
			
			$this->table->set_heading('Nama Perusahaan','No Kendaraan','Tipe Kendaraan','Operasi');
			
			foreach($kendaraan as $d_kendaraan){
			
				
				$this->table->add_row(
					$d_kendaraan['nama_perusahaan'],
					$d_kendaraan['no_kendaraan'],
					$d_kendaraan['tipe_kendaraan'],
					anchor(
						'Kendaraan/hapusKendaraan/'.$d_kendaraan['no_kendaraan'], 
						'Hapus',
						array(
							'class' => 'btn btn-danger'
						)
					)
				);
			}
			
			$this->admin_sidebar();
			$this->load->view('admin/table_view.html',$data);
			
		}
		
		public function tambahKendaraan($pesan=""){
		
			$this->admin_session();
			
			if($this->input->submit){
				$this->form_validation->set_rules(
					'no_kendaraan',
					'No Kendaraan',
					'required|min_length[3]|max_length[10]|is_unique[kendaraan.no_kendaraan]'
				);
				$this->form_validation->set_rules(
					'id_kendaraan',
					'ID Kendaraan',
					'required|min_length[3]|max_length[10]|is_unique[v_status.id]'
				);
				$this->form_validation->set_rules(
					'tipe_kendaraan',
					'Tipe Kendaraan',
					'required|min_length[3]|max_length[20]'
				);
				
				if($this->form_validation->run()==FALSE){
					$this->tambahKendaraan("");
					
				}else{
				
					$this->MAdmin->tambahKendaraan("Kendaraan_Berhasil_Ditambah");
				}
			}
			
			$data['pesan'] = str_replace("_"," ",$pesan);
			$data['sub_perusahaan'] = $this->MAdmin->getSubPerusahaan();
			
			$this->admin_sidebar();
			$this->load->view('admin/kendaraan/admin_add_kendaraan.html',$data);
			
		}
		
		private function addKendaraan(){
		
			$this->form_validation->set_rules(
				'no_kendaraan',
				'No Kendaraan',
				'required|min_length[3]|max_length[10]|is_unique[v_status.no_kendaraan]'
			);
			$this->form_validation->set_rules(
				'id_kendaraan',
				'ID Kendaraan',
				'required|min_length[3]|max_length[10]|is_unique[v_status.id]'
			);
			$this->form_validation->set_rules(
				'tipe_kendaraan',
				'Tipe Kendaraan',
				'required|min_length[3]|max_length[20]'
			);
			
			if($this->form_validation->run()==FALSE){
			
				$this->tambahKendaraan("");
				
			}else{

				$this->MAdmin->addKendaraan();
			}
		}
		
		public function hapusKendaraan($enc_no_kendaraan){
		
			$this->MAdmin->hapusKendaraan($no_kendaraan);
		}
		
	}
?>
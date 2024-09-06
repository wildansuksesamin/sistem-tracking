<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class MAdmin extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		
		public function login(){
			
			$admin=$this->input->post('user');
			$password=$this->input->post('password');
			$garam1="#!dfw$^";
			$garam2="^%RSs";
			$token=hash('ripemd128',$garam1.$password.$garam2);
			
			$result = $this->db->select('user,password')
				->where('user',$admin)
				->where('password',$token)
				->get('admin');
			
			if($result->num_rows()>0){
				return true;
			}else{
				return false;
			}
			
		}
		
		public function gantiPassword(){
		
			$admin=$this->session->admin;
			$password=$this->input->post('passwrod_baru');
			$password_lama=$this->input->post('old_password');
			$garam1="#!dfw$^";
			$garam2="^%RSs";
			$token=hash('ripemd128',$garam1.$password.$garam2);
			$old_token=hash('ripemd128',$garam1.$password_lama.$garam2);
			
			$cek_password = $this->db->select('user,password')
				->where('password',$token)
				->get('admin');
			
			if($cek_password->num_rows()==0){
				redirect('Admin/rubahPassword/Password_admin_lama_tidak_sesuai');
			}else{
				
				$hasil = $this->db->where('user',$admin)
					->update('admin',array('password'=>$token));
				
				if($hasil){
					redirect('Admin/rubahPassword/Password_admin_telah_dirubah');
				}
			}
		}
		
		public function getClient($id_client='kosong'){
		
			if($id_client!='kosong'){
			
				$this->db->select('id_client,tanggal,nama_client');
				$this->db->where('id_client',$id_client);
				$hasil=$this->db->get('client');
				
			}else{
			
				$this->db->select('id_client,tanggal,nama_client');
				$hasil=$this->db->get('client');
				
			}
		
			if($hasil->num_rows()>0){
				return $hasil->result_array();
			}
		}
		
		public function clientUser($id_client){
		
			$hasil = $this->db->select('nama_depan,nama_belakang,email,telepon,alamat')
				->where('id_client',$id_client)
				->get('user');
			
			return $hasil->result_array();
			
		}
		
		public function clientPerusahaan($id_client){
		
			$hasil = $this->db->select('id_perusahaan,nama_perusahaan')
				->where('id_client',$id_client)
				->get('sub_perusahaan');
			
			if($hasil->num_rows()>0){
				return $hasil->result_array();
			}
		}
		
		public function getSubPerusahaan(){
		

			$hasil = $this->db->select('sub_perusahaan.id_perusahaan, sub_perusahaan.nama_perusahaan, client.nama_client')
				->where('sub_perusahaan.id_client=client.id_client')
				->get('sub_perusahaan,client');
				
			if($hasil->num_rows()>0){
				return $hasil->result_array();
			}
		}
		
		public function addPerusahaan(){
		
			$id_perusahaan=$this->input->post('id_perusahaan');
			$nama_perusahaan=$this->input->post('nama_perusahaan');
			$id_client=$this->input->post('client');
			
			if($id_perusahaan === "" || $nama_perusahaan === ""){
				redirect('Perusahaan/addPerusahaan/Data_Tidak_lengkap');
				exit ;
			}
	
			$cek_id = $this->db->select('id_perusahaan')
				->where('id_perusahaan',$id_perusahaan)
				->get('sub_perusahaan');
			
			if($cek_id->num_rows()>0){ 
				redirect('Perusahaan/addPerusahaan/ID_tidak_tersedia'); 
				exit;
			}
			
			$input=array(
				'id_perusahaan' => $id_perusahaan,
				'nama_perusahaan' => $nama_perusahaan,
				'id_client' => $id_client
			);
			
			$result=$this->db->insert('sub_perusahaan',$input);
			
			if($result){
				redirect('Perusahaan/addPerusahaan/Berhasil_Menambah_data'); 
			}else{ 
				redirect('Perusahaan/addPerusahaan/Gagal_Menambah_data'); 
			};
			
		}
		
		public function getDetailSubPerusahaan($id_perusahaan){
		

			$hasil = $this->db->select('sub_perusahaan.nama_perusahaan,v_status.no_kendaraan,kendaraan.tipe_kendaraan')
				->where('sub_perusahaan.id_perusahaan=',$id_perusahaan)
				->where('v_status.id_perusahaan',$id_perusahaan)
				->where('v_status.no_kendaraan=kendaraan.no_kendaraan')		
				->get('sub_perusahaan,v_status,kendaraan');
				
			if($hasil){ 
				return $hasil->result_array(); 
			}
			
		}
		
		public function addUser(){
		
			$username=$this->input->post('user');
			$password1=$this->input->post('password1');
			$password2=$this->input->post('password2');
			
			if($password1 != $password2 || $password1=="" || $password2=="" || $username==""){
				redirect('Auser/viewUser/Data_tidak_lengkap');
				exit;
			}
			
			$garam1='!@dsrsd';
			$garam2='34aer2d';
				
			$token=hash('ripemd128',$garam1.$password1.$garam2);
			
			$nama_depan=($this->input->post('nama_depan') !="")?$this->input->post('nama_depan'):'kosong';
			$nama_belakang=($this->input->post('nama_belakang') !="")?$this->input->post('nama_belakang'):'kosong';
			$email=$this->input->post('email');
		
			if($email==""){ 
				redirect('Auser/viewUser/email_tidak_boleh_kosong');
			}
			
			$telepon=($this->input->post('tlp')!="")?$this->input->post('tlp'):'kosong';
			$alamat=($this->input->post('alamat')!="")?$this->input->post('alamat'):'kosong';
			$id_client=$this->input->post('client');
			
			$data=array(
				'username' => $username,
				'password' => $token,
				'nama_depan' => $nama_depan,
				'nama_belakang' => $nama_belakang,
				'email' => $email,
				'telepon'=> $telepon,
				'alamat' => $alamat,
				'id_client' => $id_client
			);
			
			$hasil=$this->db->insert('user',$data);
			
			if($hasil){
				redirect('Auser/viewUser/Berhasil_menambah_data');
			}else{
				redirect('Auser/viewUser/Gagal_menambah_data');
			}
		}
		
		public function getUser(){
		
			$result = $this->db->select('username,nama_depan,nama_belakang,email,telepon,alamat')
				->get('user');
			
			if($result->num_rows()>0){
				return $result->result_array();
			}
			
		}
		
		public function hapusUser($username){
		
			$hasil = $this->db->where('username',$username)
				->delete('user');
			
			if($hasil){
				redirect('Auser/viewUser/Berhasil_Menghapus_Entry');
			}else{
				redirect('Auser/viewUser/Gagal_Menghapus_Entry');
			}
		}
		
		public function addRegistrasi(){
		
			$no_client= $this->input->post('no_registrasi');
			$nama_client=$this->input->post('nama_client');
			$tanggal=$this->input->post('tanggal');
			
			if($no_client=="" || $tanggal == "" || $nama_client == "" ){
				redirect('Client/registrasi/Harap_isi_semua_field');
				exit;
			}
			
			$data=array(
				'id_client' => $no_client,
				'tanggal' => $tanggal,
				'nama_client' => $nama_client
			);
			
			$hasil=$this->db->insert('client',$data);
			
			if($hasil){
				redirect('Client/registrasi/Registrasi_berhasil');
			}else{ 
				redirect('Client/registrasi/Registrasi_gagal');
			}
		}
		
		public function hapusClient($id_client){
		
			$hasil = $this->db->where('id_client',$id_client)
				->delete('client');
			
			if($hasil){ 
				redirect('Client/registrasi/registrasi_dihapus');
			}else{
				redirect('Client/registrasi/registrasi_gagal_dihapus');
			}
		}
		
		public function getKendaraan(){
			
			$hasil = $this->db->select('sub_perusahaan.nama_perusahaan,v_status.no_kendaraan,kendaraan.tipe_kendaraan')
				->where('sub_perusahaan.id_perusahaan=v_status.id_perusahaan')
				->where('v_status.no_kendaraan=kendaraan.no_kendaraan')
				->get('sub_perusahaan,v_status,kendaraan');
			
			if($hasil){
				return $hasil->result_array();
			}
		}
		
		public function hapusKendaraan($no_kendaraan){
		
			$hasil2 = $this->db->where('no_kendaraan',$no_kendaraan)
				->delete('kendaraan');
			
			if($hasil2){ 
				redirect('Kendaraan/viewKendaraan/kendaraan_dihapus');
			}else{
				redirect('Kendaraan/viewKendaraan/kendaraan_gagal_dihapus');
			};
		}
		
		public function addKendaraan(){
		
			$no_kendaraan = $this->input->post('no_kendaraan');
			$id_kendaraan = $this->input->post('id_kendaraan');
			$tipe_kendaraan = $this->input->post('tipe_kendaraan');
			$id_perusahaan = $this->input->post('id_perusahaan');
			
			if($no_kendaraan == "" || $id_kendaraan=="" || $tipe_kendaraan == ""){
				redirect('Kendaraan/tambahKendaraan/Harap_Isi_Semua_field');
			}
			
			$cek_id_kendaraan = $this->db->select('id')
				->where('id',$id_kendaraan)
				->get('kendaraan');

			if($cek_id_kendaraan->num_rows()>0){
				redirect('Kendaraan/tambahKendaraan/ID_Tidak_Tersedia');
			}
			
			$get_id_client = $this->db->select('id_client')
				->where('id_perusahaan',$id_perusahaan)
				->get('sub_perusahaan');
			
			$get_id_client_result = $get_id_client->result_array();
			
			foreach($get_client_result as $get_client){
			
				$id_client = $get_client['id_client'];
			}
			
			$data = array(
				'no_kendaraan' => $no_kendaraan,
				'id_perusahaan' =>$id_perusahaan,
				'id' => $id_kendaraan,
				'id_client'=>$id_client
			);
			
			$insert1 = $this->db->insert('v_status',$data);
			
			$data2=array(
				'no_kendaraan' => $no_kendaraan,
				'tipe_kendaraan' => $tipe_kendaraan
			);
			
			$insert2 = $this->db->insert('kendaraan',$data2);
			
			if($insert1 && $insert2){
				redirect('Kendaraan/viewKendaraan/Berhasil_Menambah_Kendaraan');
			}else{
				redirect('Kendaraan/viewKendaraan/Gagal_Menambah_Kendaraan');
			}
		}
		
		public function deletePerusahaan($id_perusahaan){
			$delete_p = $this->db->where('id_perusahaan', $id_perusahaan)
				->delete('sub_perusahaan');
			
			if($delete_p){
				return true ;
			}else{
				return false;
			}
		}
	}
?>
<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class MLogin extends CI_Model{
	
		var $garam1='!@dsrsd';
		var $garam2='34aer2d';
		
		public function __construct(){
			parent::__construct();
		}
		
		public function CekLogin(){
		
			if($this->input->post('username') !="" && $this->input->post('password') != ""){
			
				$username=$this->input->post('username');
				$password=$this->input->post('password');
				
			
				$token=hash('ripemd128',$this->garam1.$password.$this->garam2);
				
				$result=$this->db->select('username,password,id_client')
									->where('username',$username)
									->where('password',$token)
									->get('user');
				
				if($result->num_rows()>0 || $result->num_rows() != 0){
				
					$hasil=$result->result_array();
					$this->session->user=$hasil[0]['username'];
					$this->session->client=$hasil[0]['id_client'];
					
					return true;
					
				}else{
					return false;
				}
			}else{
				return false ;
			}
		}
		
		public function cekEmail(){
		
			$username=$this->input->post('username');
			$email=$this->input->post('email');
			
			$cek_email=$this->db->where('username',$username)
								->where('email',$email)
								->get('user');
		
			
			if($cek_email->num_rows()>0){
				$this->session->temp_user=$username;
				return true;
			}else{
				return false;
			}
				
		}
		
		public function buatPasswordBaru(){
		
			$username=$this->session->temp_user;
			$password=$this->input->post('password_baru');
				
			$token=hash('ripemd128',$this->garam1.$password.$this->garam2);

			$data_update=array(
				'password'=>$token
			);
			
			$result=$this->db->where('username',$username)
							->update('user',$data_update);
			if($result){
				return true;
			}else{
				return false ;
			}
		}
		
		
	}
?>

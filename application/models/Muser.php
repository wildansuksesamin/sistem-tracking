<?php
	class Muser extends CI_Model{
		
		var $garam1='!@dsrsd';
		var $garam2='34aer2d';
		
		function __construct(){
		
			parent::__construct();
			
		}
		
		public function getUserData(){
		
			$user=$this->session->user ;
			
			//$query="SELECT nama_depan,nama_belakang,email,alamat FROM user WHERE username='".$user."'";
			$result=$this->db->select('nama_depan,nama_belakang,email,alamat')
							->where('username',$user)
							->get('user');
			
			//$result=$this->db->query($query);
			
			if($result->num_rows()>0){
				return $result->result_array();		
			}
			
		}
		
		public function cekUser($user,$password){
			
			$user=$this->session->user;
				
			$token=hash('ripemd128',$this->garam1.$password.$this->garam2);
			
			$cek_login=$this->db->select('username,password')
						->where('username',$user)
						->where('password',$token)
						->get('user');
			
			if($cek_login->num_rows()<1 || $cek_login->num_rows() != 1){
				return false ;
			}else{
				return true ;
			}
			
		}
		
		public function updatePassword(){
		
			$username = $this->session->user;
			$old_password = $this->input->post('old_password');
			$new_pass2 = $this->input->post('new_password2');
			
			$old_token = hash('ripemd128',$this->garam1.$old_password.$this->garam2);
			
			$cek_password = $this->db->select('username,password')
				->where('password',$old_token)
				->get('user');
			
			if($cek_password->num_rows()<1 || $cek_password->num_rows() != 1){
				return false ;
			}else{
			
				$token2=hash('ripemd128',$this->garam1.$new_pass2.$this->garam2);
				
				$hasil_update = $this->db->where('username',$username)
										->update('user',array('password'=>$token2));
					
				if($hasil_update){
					return true ;
				}else{
					return false ;
				}
			}
			
		}
		
		public function updateData(){
		
			$user=$this->session->user ;
			$new_nama_depan=$this->input->post('nama_depan');
			$new_nama_belakang=$this->input->post('nama_belakang');
			$new_email=$this->input->post('email');
			$new_alamat=$this->input->post('alamat');
			
			if($new_nama_depan != "" && $new_email != "" && $new_alamat != ""){
			
				$data = array(
					'nama_depan' => $new_nama_depan, 
					'nama_belakang' => $new_nama_belakang, 
					'email' => $new_email, 
					'alamat' => $new_alamat 
					);
					
				$result = $this->db->where('username',$user)
									->update('user',$data);
				//$result=$this->db->query($query);
				
				if($result){
					return true ;
					exit;
				}else{
					return false ;
					exit;
				}
			}
			
		}
		
	}
?>

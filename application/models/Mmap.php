<?php
	class MMap extends CI_Model{
		public function __construct(){
			parent::__construct();
		}
		
		public function getNamaPerusahaan(){
		
			$client=$this->session->client;
			$data = array();
			
			$result=$this->db->select('id_perusahaan,nama_perusahaan')
							->where('id_client',$client)
							->get('sub_perusahaan');
			
			if($result->num_rows()>0){
				return $result->result_array();		
			}
		}
		
		public function getData($id=null){
			
			$client=$this->session->client;
			
			if($client==""){
				redirect('Login');
				exit ;
			}
			
			$this->db->select('no_kendaraan,id,lat,lgt,id_perusahaan');
			$this->db->where('id_client',$client);
			
			if(!(is_null($id))){
				$this->db->like('no_kendaraan',$id,'after');
			}
			
			$result = $this->db->get('v_status');
			
			if($result->num_rows()>0){
				return $result->result_array();
			}
		}
		
		public function setMarker(){
		
			$ids;
			$fix_id;
			$data = array();
			if($_GET['ids']!=""){
				$ids=$_GET['ids'];
				$fix_id=substr($ids,1);
				$query="SELECT id,lat,lgt,kecepatan,task,date_p,status,no_kendaraan FROM v_status WHERE id IN (".$fix_id.")";
				$result=$this->db->query($query);
				
				if($result->num_rows()>0){
					return $result->result_array();
				}
				
			}
		}
	}
?>

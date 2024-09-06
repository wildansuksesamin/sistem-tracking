<?php
	class MTrail extends CI_Model{
	
		function __construct(){
			parent::__construct();
		}
		
		public function getVehicle(){
		
			$client=$this->session->client;
			
			$query="SELECT no_kendaraan FROM v_status WHERE id_client='".$client."'";
			
			$result=$this->db->query($query);
			
			if($result->num_rows()>0){
				return $result->result_array();		
			}
		}
		
		public function getKoordinate(){
		
			$no_kendaraan=(isset($_GET['no_kendaraan']))?$_GET['no_kendaraan']:'kosong';
			$tanggal=(isset($_GET['tanggal']))?$_GET['tanggal']:'kosong';
			
			if(($no_kendaraan != 'kosong' ) && ($tanggal != 'kosong')){
			
				$query="SELECT lat,lgt FROM track WHERE no_kendaraan ='".$no_kendaraan."' AND date_p='".$tanggal."'";
				$hasil=$this->db->query($query);
				
				if($hasil->num_rows()>0){
					return $hasil->result_array();
				}
			}
		}
		
	}
?>
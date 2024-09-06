<?php
	class MReport extends CI_Model{
		
			function __construct(){
			
				parent::__construct();
				
			}
			
			public function getData(){
			
				$user=$this->session->user;
			
				//$query="SELECT no_kendaraan,id FROM v_status WHERE username='".$user."'";
				$result=$this->db->select('no_kendaraan,id')
					->where('username',$user)
					->get('v_status');
				
				//$result=$this->db->query($query);
			
				if($result->num_rows()>0){
					return $result->result_array();		
				}
			}
			
			public function createReport(){

					
				$fix_id=substr($this->session->ids,1);
				$fix_field=$this->session->fields;
				$fix_date=explode("C",$this->session->dates);
					
				$query="SELECT ".$fix_field." FROM track WHERE ( date_p BETWEEN '".$fix_date[0]."' AND '".$fix_date[1]."' ) AND id IN ( ".$fix_id." )";
								
				$result=$this->db->query($query);
			
				if($result->num_rows()>0){
					
					return $result->result_array();		
						
				}
				
				
			}
	}
?>
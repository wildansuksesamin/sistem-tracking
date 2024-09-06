<?php
	class Ajax_request extends CI_Controller{
		
		function __construct(){
			parent::__construct();
		}
		
		function request_car_list(){
			$this->load->model('MMap');
			
			$search_request = $this->input->get('search_val');
			
			echo json_encode($this->MMap->getData($search_request));
		}
	}
?>
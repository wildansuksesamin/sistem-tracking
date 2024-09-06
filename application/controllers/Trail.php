<?php
/*
/----------------------------------------------------------------------
/2015 m arif zainuddin , sozaemonafro@gmail.com
/Aplikasi web sederhana untuk tracking map
/author : m arif zainuddin
/cotact phone : 085711336281 
/email : sozaemonafro@gmail.com
----------------------------------------------------------------------
*/
	class Trail extends CI_Controller{
	
		private $_main_templates;
		
		function __construct(){
			parent::__construct();
			$this->init_load();
		}
		
		private function init_load(){
		
			$this->load->model('Mtrail');
			$this->load->helper('main_template');
			
			$this->_main_templates =  new Mtemplate();
		}
		
		public function index(){
		
			$data['kendaraan'] = $this->Mtrail->getVehicle();
			
			$this->_main_templates->make_header();
			$this->load->view('trail.html',$data);
			$this->load->view('footer.html');
			
		}
		
		public function lintasan(){
			echo json_encode($this->MTrail->getKoordinate());
		}
	}
?>
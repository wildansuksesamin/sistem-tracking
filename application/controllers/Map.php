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
	class Map extends CI_Controller{
	
		private $_main_template;
		
		function __construct(){
			parent::__construct();
			$this->init_load();
		}
		
		function init_load(){
			$this->load->model('MMap');
			$this->load->helper('main_template');
			$this->_main_template = new Mtemplate();
		}

		public function index(){
		
			$user=$this->session->user;
			
			if($user===""){ 
				redirect('Login'); 
				exit ;
			}
			$data['javascript'] = array(
				'[home]js/bootstrap/js/bootstrap.min.js',
				'https://maps.googleapis.com/maps/api/js?sensor=false',
				'[home]js/markerWithLabel.js',
				'[home]js/view_map.js'
			);
			
			$this->_main_template->make_header();
			$this->_main_template->car_list('map');
			$this->load->view('map.html',$data);
			$this->load->view('footer.html');
			
		}
		
		public function setMarker(){
	
			echo json_encode($this->MMap->setMarker());
		}
			
	}
?>

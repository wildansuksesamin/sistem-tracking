<?php
	class Mtemplate{
		
		private $_ci;
		
		function __construct(){
			$this->_ci =& get_instance();
		}
		
		public function make_header(){
			$data['links'] = array(
				'Main Map'	=> 'Map/index',
				'Report' 	=> 'Report/index',
				'Trail' 	=> 'Trail/index'
			);
			
			$data['user_links'] = array(
				'View User'	=> 'User',
				'Log Out' 	=> 'User/Logout'
			);
			
			$data['css'] = array(
				'[home]js/DataTables/media/css/jquery.dataTables.css',
				'[home]js/jquery-ui/jquery-ui.min.css',
				'[home]js/bootstrap/css/bootstrap.min.css',
				'[home]css/map.css',
				'[home]css/report.css',
				'[home]css/trail.css'
			);
			
			$data['javascript']=array(
				'[home]js/jquery-1.11.1.min.js'
			);
			
			$this->_ci->load->view('basic/header.html',$data);
		}
		
		public function login_form($pesan){
		
			$login['psn']=$pesan ;
			
			$login['links']=array(
				'Tamu' => 'Login/guest',
				'Administrator' => 'Admin',
				'Lupa Password' => 'Login/forgetPassword',
			);
			
			$login['javascript']=array(
				'[home]js/jquery-1.11.1.min.js',
				'[home]js/bootstrap/js/bootstrap.min.js'
			);
			
			$login['css']=array(
				'[home]css/login.css',
				'[home]js/bootstrap/css/bootstrap.min.css'
			);
			
			$this->_ci->load->view('basic/login_form.html',$login);
		}
		
		public function car_list($view){
		
			$this->_ci->load->model('MMap');
			
			$car_list['f_view']			= $view;
			$car_list['n_perusahaan']	= $this->_ci->MMap->getNamaPerusahaan();
			$car_list['n_car_data']		= $this->_ci->MMap->getData();
			
			$this->_ci->load->view('basic/car_list.html',$car_list);
		}
	}
?>
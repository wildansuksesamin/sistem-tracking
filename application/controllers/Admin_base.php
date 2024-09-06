<?php
	abstract class Basic_Admin extends CI_Controller{
		
		function __construct(){
			parent::__construct();
			$this->load->library("encrypt");
		}
		
		protected abstract function init_load();
		
		protected function admin_session(){
			if($this->session->admin==="" ){
				session_destroy();
				redirect("Admin/index");
				exit;
			}else{
				$this->session->mark_as_temp("admin",300);
			}
		}
		
		protected function admin_sidebar(){
			$s_admin["javascript"] = array(
				"[home]/js/jquery-1.11.1.min.js",
				"[home]js/DataTables/media/js/jquery.dataTables.min.js"
			);
			
			$s_admin["css"] = array(
				"[home]css/admin.css",
				"[home]js/bootstrap/css/bootstrap.min.css",
				"[home]js/DataTables/media/css/jquery.dataTables.css"
			);
			
			$s_admin["links"] = array(
				"Log Out Admin" => "Admin/logout",
				"Rubah Password" => "Admin/rubahPassword",
				"Admin Main Page" => "Admin/adminMainPage",
				"Registrasi" => array(
					"Daftar Registrasi" => "Client/viewregistrasi",
					"Tambah Registrasi" => "Client/registrasi"
				),
				"User" => array(
					"View User" => "Auser/viewUser",
					"Tambah User" => "Auser/addUser"
				),
				"Kendaraan" => array(
					"Tampilkan Kendaraan" => "Kendaraan/viewKendaraan",
					"Tambah Kendaraan" => "Kendaraan/tambahKendaraan"
				),
				"Perusahaan" => array(
					"Tampilkan Perusahaan" => "Perusahaan/viewPerusahaan",
					"Tambah Perusahaan" => "Perusahaan/addPerusahaan"
				)
			);
			
			$this->load->view("admin/admin_sidebar_new.html",$s_admin);
		}
	}
?>
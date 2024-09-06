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
	class Report extends CI_Controller{

		private $_main_template;
		function __construct(){
		
			parent::__construct();
			date_default_timezone_set('Asia/Jakarta');
			$this->init_load();
			
		}
		
		private function init_load(){
		
			$this->load->model('MMap');
			$this->load->model('MReport');
			$this->load->helper('main_template');
			$this->_main_template=new Mtemplate();
		}
		
		public function index(){
				$this->report_frame();
		}
		
		private function report_frame(){
		
			$this->cekUser();
			
			$data['for_checkbox']=array(
				'lat'=>'Latitude',
				'lgt'=>'Langitute',
				'kecepatan'=>'Kecepatan',
				'task'=>'Task',
				'date_p'=>'Tanggal',
				'time_e'=>'Waktu'
			);
			
			$data['javascript']=array(
				'[home]js/jquery.jsontotable.min.js',
				'[home]js/DataTables/media/js/jquery.dataTables.js',
				'[home]js/jquery-ui/jquery-ui.js',
				'[home]js/bootstrap/js/bootstrap.min.js',
				'[home]js/report.js'
			);
			
			$this->_main_template->make_header();
			$this->_main_template->car_list('report');
			$this->load->view('report.html',$data);
			$this->load->view('footer.html');
		}
		
		public function generateReport(){
			
			$this->session->ids="";
			$this->session->fields="";
			$this->session->dates="";
			
			if ($this->input->get('ids')!="" && $this->input->get('field')!=="" && $this->input->get('date')!==""){
			
				$this->session->ids=$this->input->get('ids');
				$this->session->fields=$this->input->get('field');
				$this->session->dates=$this->input->get('date');
				
				echo json_encode($this->MReport->createReport());
				
			}else{
				echo json_encode(array('pesan'=>'Data Tidak Lengkap'));
				exit;
			}
			
		}
		
		public function createPDF(){
			
			$this->idSession();
			$this->cekUser();
			
			$data=$this->MReport->createReport();
			$for_header=explode(",",$this->session->fields);
			
			/* Set Up fpdf*/
			$this->load->library('fpdf17/fpdf');
			$this->fpdf->FPDF('L','mm','A4');
			$this->fpdf->AddPage();
			$this->fpdf->setFont('Arial','',16);
			$this->fpdf->SetFillColor(0,170,255);
			
			$this->fpdf->Cell(280,7,'Report Kendaraan',0,0,'C',false);
			$this->fpdf->ln(20);
			/* print author dan tanggal */
			
			
			$this->fpdf->Cell(40,7,'User',0,0,'L',false);
			$this->fpdf->Cell(80,7,$this->session->user,0,0,'L',false);
			$this->fpdf->ln(10);
			$this->fpdf->Cell(40,7,'Waktu',0,0,'L',false);
			$this->fpdf->Cell(80,7,date("D, d M Y H:i:s"),0,0,'L',false);
			$this->fpdf->ln(10);
			
			/* Bagian ini membentuk header tabel */
			$this->fpdf->setFont('Arial','B',16);
			$this->fpdf->Cell(10,7,'No',1,0,'C',true);
			
			for($c=0;$c<count($for_header);$c++){
				$header="";
	
				switch($for_header[$c]){
				
					case 'no_kendaraan':$header='No Kendaraan';break;
					case 'lat':$header='Latitute';break;
					case 'lgt':$header='Langitute';break;
					case 'kecepatan':$header='Kecepatan';break;
					case 'task':$header='Task';break;
					case 'date_p':$header='Tanggal';break;
					case 'time_e':$header='Waktu';break;
					
				}
				
				$this->fpdf->Cell(39,7,$header,1,0,'C',true);
			}
			
			$this->fpdf->ln();
			$this->fpdf->setFont('');
			$this->fpdf->SetFillColor(170,212,255);
			$is_fill=TRUE;
			
			/* Bagian ini menulis setiap data hasil query dan di hasilkan dengan bentuk tabel */
			
			for($d=0;$d<count($data);$d++){
			
				if(($d+1)%5==0 ){$is_fill=TRUE;}else{$is_fill=FALSE;}
				
				$this->fpdf->Cell(10,6,$d+1,1,0,'C',$is_fill);
				
				for($s=0;$s<count($for_header);$s++){
				
					$this->fpdf->Cell(39,6,$data[$d][$for_header[$s]],1,0,'C',$is_fill);
					
				}
				$this->fpdf->ln();
				
			}
			
			$this->fpdf->Output();
		}
		
		
		public function createExcel(){
		
			$this->idSession();
			$this->cekUser();
			
			$this->load->library('PHPExel/MyExcell');
			$data=$this->MReport->createReport();
			$for_header=explode(",",$this->session->fields);
			
			$header=array();
			$header[0]='No';
			
			for($k=0;$k<count($for_header);$k++){
				$head;
				switch($for_header[$k]){
					case 'no_kendaraan':$head='No Kendaraan';break;
					case 'lat':$head='Latitute';break;
					case 'lgt':$head='Langitute';break;
					case 'kecepatan':$head='Kecepatan';break;
					case 'task':$head='Task';break;
					case 'date_p':$head='Tanggal';break;
					case 'time_e':$head='Waktu';break;
				}
				
				$header[$k+1]=$head;
			}
			
			$exel=new MyExcell();
			
			$exel->sheetPages(0,'Report');
			$exel->sheetHeaderBold('Report Kendaraan','A1','H1',true,40);
			$exel->sheetHeader('User','A2','B2',false,18);
			$exel->sheetHeader($this->session->user,'C2','H2',false,18);
			$exel->sheetHeader('Waktu','A3','B3',false,18);
			$exel->sheetHeader(date("D, d M Y H:i:s"),'C3','H3',false,18);
			$exel->tableHeader(5,$header,14);
			$exel->tableContent(6,$data,$for_header);
			$exel->generateExcel('Report '.date("D, d M Y H:i:s"));
			
		}
		
		private function idSession(){
			if($this->session->ids=="" || $this->session->fields=="" || $this->session->dates==""){
				echo " Data Tidak Valid , Klik tombol Buat Report kemudian klik export PDF atau export Excel ";
				exit;
			}
			$this->session->mark_as_temp('ids',600);
			$this->session->mark_as_temp('fields',600);
			$this->session->mark_as_temp('dates',600);
		}
		
		private function cekUser(){
			if($this->session->user==""){
				redirect('Login');
				exit;
			}
		}
	}
?>
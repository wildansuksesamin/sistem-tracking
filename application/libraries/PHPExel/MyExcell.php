<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	require_once "PHPExcel.php";
	
	class MyExcell extends PHPexcel{
		
		var $excell;
		var $sheet;
		var $col_index=Array('A','B','C','D','E','F','G','H','I','J','K','L');
		
		public function __construct(){
		
			parent::__construct();
			
			$this->sheet=$this->getSheet(0);
			$cache=PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
			$cache_settings=array( ' memoryCacheSize '  => '16MB');
			
			PHPExcel_Settings::setCacheStorageMethod($cache, $cache_settings);
			
			$this->getProperties()
				->setCreator('M Arif Zainuddin')
				->setTitle('Report Excel')
				->setLastModifiedBy('M Arif Zainuddin')
				->setDescription('Report untuk file Excel')
				->setSubject('PHP Excel ')
				->setKeywords('excel php office report last position')
				->setCategory('Report');
		}
		
		public function sheetPages($sheet_index=0,$title){
		
			$this->sheet=$this->getSheet($sheet_index);
			$this->sheet->setTitle($title);
			
		}
		
		public function sheetHeaderBold($header,$col1,$col2,$color,$font_size){
		
			$text;
			$rich_text=new PHPExcel_RichText();
			$text=$rich_text->createTextRun($header);
			$text->getFont()
				->setBold(true);
			$text->getFont()
				->setSize($font_size);
			if($color==TRUE){
				$text->getFont()
				->setColor( new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_BLUE ) );
			}
			
			$this->sheet->mergeCells($col1.':'.$col2);
			$this->sheet->setCellValue($col1,$rich_text);
		}
		
		public function sheetHeader($header,$col1,$col2,$color,$font_size){
		
			$text;
			$rich_text=new PHPExcel_RichText();
			$text=$rich_text->createTextRun($header);
			$text->getFont()
				->setSize($font_size);
			
			if($color==TRUE){
				$text->getFont()
				->setColor( new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_BLUE ) );
			}
			
			$this->sheet
				->mergeCells($col1.':'.$col2);
			$this->sheet
				->setCellValue($col1,$rich_text);
		}
		
		public function tableHeader($row,$header,$font_size){
		
			$style=array(
				'font'=>array(
					'bold'=>true,
					'size'=>$font_size
				),
				'alignment'=>array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
				),
				'borders'=>array(
					'allborders'=>array(
						'style' => PHPExcel_Style_Border::BORDER_THICK
					)
				)
			);
		
			for($h=0;$h<count($header);$h++){
				$this->sheet
					->setCellValue($this->col_index[$h].$row,$header[$h]);
				$this->sheet
					->getStyle($this->col_index[$h].$row)
					->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('0000AAFF');
				$this->sheet
					->getStyle($this->col_index[$h].$row)
					->applyFromArray($style);
				$this->sheet
					->getColumnDimension($this->col_index[$h])
					->setAutoSize(true);
			}
		}
		
		public function tableContent($row,$data,$field){
			
			$style_row=array(
				'alignment'=>array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT),
				'borders'=>array('allborders'=>array('style' => PHPExcel_Style_Border::BORDER_THIN))
			);
		
			$color="";
			for($d=0;$d<count($data);$d++){
			
				if(($d+1)%5==0){$color="00AAFFD4";}else{$color="00AAD4FF";}
				
				$this->sheet
					->setCellValue('A'.$row,$d+1);
				$this->sheet
					->getStyle('A'.$row)
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB($color);
				$this->sheet
					->getStyle('A'.$row)
					->applyFromArray($style_row);
				
				for($s=0;$s<count($field);$s++){
				
					$this->sheet
						->setCellValue($this->col_index[$s+1].$row,$data[$d][$field[$s]]);
					$this->sheet
						->getStyle($this->col_index[$s+1].$row)
						->getFill()
						->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()
						->setARGB($color);
					$this->sheet
						->getStyle($this->col_index[$s+1].$row)
						->applyFromArray($style_row);
					
				}
				
				$row++;
			}
		}
		
		public function generateExcel($filename){
		
			$objWriter = PHPExcel_IOFactory::createWriter($this, 'Excel2007');
 
            //sesuaikan headernya 
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            //ubah nama file saat diunduh
            header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
            //unduh file
            $objWriter->save("php://output");
			
		}
			
	}
?>
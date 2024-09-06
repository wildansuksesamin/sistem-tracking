<?php
	require_once 'fpdf.php';
	
	class PDF extends FPDF{
	
		var $lebar_kolom ;
		
		function __construct(){
			parent::FPDF();
		}
		
		function MyHeader($title){
		
			$this->SetFont('Arial','B',24);
			$w = $this->GetStringWidth($title)+8 ;
			$this->SetX((210-$w)/2);
			$this->SetDrawColor(242,72,242);
			$this->SetFillColor(222,180,222);
			$this->Cell($w,20,$title,1,1,'C',true);
			$this->ln(10);
		}
		
		function ColoumnHeader($title){
		
			if(is_array($title))
			{
				$w = (225/(count($title)+1));
				$this->SetFont('Arial','B',12);
				$this->lebar_kolom = $w ;
				$this->SetFillColor(222,222,180);
				$this->Cell(10,7,'No',1,0,'L',true);
				for($i=0;$i<count($title);$i++)
				{
					$this->Cell($w,7,$title[$i],1,0,'L',true);
				}
			}
			else
			{
				$this->Cell(0,7,$title,1,0,'C',true);
			}
			$this->ln();
		}
		
		function GetLebarKolom(){
		
			return $this->lebar_kolom ;
		}
	}
?>
<?php
		session_start();
	include("../pcdmis/vendor/jquery/function.php");
		foreach ($_GET as $key => $data)
		{
		$code=$_GET[$key]=base64_decode(urldecode($data));
			
		}
		header('content-type: text/html; charset: utf-8');
		date_default_timezone_set("Asia/Manila");
		require_once '../Classes/PHPExcel.php';
		
	     $filename = "TRANSACTION REPORT BY DATE"; //your file name
		$objPHPExcel = new PHPExcel();
		
		//Merge cell
		$objPHPExcel->getActiveSheet(0)->mergeCells('A1:E1');
		$objPHPExcel->getActiveSheet(0)->mergeCells('A2:E2');
		$objPHPExcel->getActiveSheet(0)->mergeCells('A3:E3');
		$objPHPExcel->getActiveSheet(0)->mergeCells('A4:E4');
		$objPHPExcel->getActiveSheet(0)->mergeCells('A5:E5');
		$objPHPExcel->getActiveSheet(0)->mergeCells('A6:E6');
				
		
		
		//Center Alignment
		$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('A4:E4')->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('A5:E5')->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('A8:E8')->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('C9:D9')->getAlignment()->setHorizontal('center');
				
		//Set Column Width*/
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(75);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
		
	    //$objPHPExcel->getActiveSheet()->getDefaultRowDimension('A11:E11')->setRowHeight(30);
		
		
	
		//Code for Bold Style
			$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true); //Make heading font bold
			$objPHPExcel->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(true); //Make heading font bold
			$objPHPExcel->getActiveSheet()->getStyle('A3:E3')->getFont()->setBold(true); //Make heading font bold
			$objPHPExcel->getActiveSheet()->getStyle('A4:E4')->getFont()->setBold(true); //Make heading font bold
			$objPHPExcel->getActiveSheet()->getStyle('A5:E5')->getFont()->setBold(true); //Make heading font bold
			$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getFont()->setBold(true); //Make heading font bold
			
			$objPHPExcel->getActiveSheet()->setShowGridlines(False);
		
		//Wrap Text
		//$objPHPExcel->getActiveSheet()->getStyle('C8:D8')->getAlignment()->setWrapText(true);	
		
		
		/*Starting Data Border*/
		$styleHeader = array(
				'borders' => array(
				'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		  )
		);//Heading	
		
		
		
		
		$objPHPExcel->getActiveSheet()->getStyle('A8:C9')->applyFromArray($styleHeader);
		unset($styleHeader);
		
	
		
		//First Data
		$objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('A1', 'Republic of the Philippines');
		$objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('A2',  'Department of Education');
        $objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('A3',  'Region IX, Zamboanga Peninsula');
		$objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('A4',  'DIVISION OF DIPOLOG CITY');			
		$objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('A5',  'Dipolog City');			
		$objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('A6',  'TRANSACTION REPORT BY DATE');	


		
	$objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('A8',  'DATE AND TIME')
			->setCellValue('B8',  'TRANSACTION STATUS')
			->setCellValue('C8',  'STATION/SECTION');	
	$no=9;				
	 $history=mysqli_query($con,"SELECT * FROM tbl_transactions ORDER BY Date_time Desc");
			while ($rowhist=mysqli_fetch_array($history))
			  {
				   $From="";
				   
				 if ($rowhist['Trans_from']=="")
				 {
					$Query=mysqli_query($con,"SELECT * FROM tbl_school WHERE SchoolID='".$rowhist['SchoolID']."'");
					$rowque=mysqli_fetch_assoc($Query);	
					$From=$rowque['Abraviate']; 
				 }else{
					 $From=$rowhist['Trans_from']; 
				 }					 
				$objPHPExcel->setActiveSheetIndex(0) 
				->setCellValue('A'.$no, $rowhist['Date_time'])
				->setCellValue('B'.$no, $rowhist['Trans_Stats'])
				->setCellValue('C'.$no, $From );	
				$no++;				
			  }				  
					
		$objPHPExcel->getActiveSheet()->setTitle($filename); //give title to sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		header('Content-Type: text/xls');
		header("Content-Disposition: attachment;Filename=TRANSACTION REPORT BY DATE.xls");
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
		$objWriter->save('php://output');
		exit;
		
?>
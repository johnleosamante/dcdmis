<?php
		session_start();
		include("../../pcdmis/vendor/jquery/function.php");
		header('content-type: text/html; charset: utf-8');
		date_default_timezone_set("Asia/Manila");
		require_once '../Classes/PHPExcel.php';
		
	     $filename = "Applicant"; //your file name
		$objPHPExcel = new PHPExcel();
		
		//Center Alignment
		$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal('center');
		
		//Set Column Width*/
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
			
		//Code for Bold Style
			$objPHPExcel->getActiveSheet()->getStyle('A3:F3')->getFont()->setBold(true); //Make heading font bold
			$objPHPExcel->getActiveSheet()->setShowGridlines(False);
			
		/*Starting Data Border*/
		$styleHeader = array(
				'borders' => array(
				'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		  )
		);//Heading	
		
		$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->applyFromArray($styleHeader);
		unset($styleHeader);	
		
		//First Data
		$objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('A1', 'DepEd Pagadian City List of Applicant');
		$objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('A2',   $filename);

		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A3', 'Applicant No')
					->setCellValue('B3', 'Last Name')
					->setCellValue('C3', 'First Name');
					
					
		//Get data from the database
			$no=4;
			$myschool=mysqli_query($con,"SELECT * FROM tbl_applicant WHERE Category='ELEMENTARY' ORDER BY Last_Name Asc");
								
							
			while($row=mysqli_fetch_array($myschool))	
				{
				$styleData = array(
						'borders' => array(
						'allborders' => array(
					  'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				  )
				);
				
			$objPHPExcel->getActiveSheet()->getStyle('A'.$no.':D'.$no)->applyFromArray($styleData);
			unset($styleData);	
					
				$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A'.$no,$row['Appl_No'])
					->setCellValue('B'.$no, $row['Last_Name'])
					->setCellValue('C'.$no, $row['First_Name']);
					
				$no++;	
				}
			
		
		$objPHPExcel->getActiveSheet()->setTitle($filename); //give title to sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		header('Content-Type: text/csv');
		header("Content-Disposition: attachment;Filename=Applicant.xls");
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
		$objWriter->save('php://output');
		exit;
		
?>
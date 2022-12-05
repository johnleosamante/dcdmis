<?php
	session_start();
include("../../pcdmis/vendor/jquery/function.php");
	
		header('content-type: text/html; charset: utf-8');
		date_default_timezone_set("Asia/Manila");
		require_once '../Classes/PHPExcel.php';
		
	    $filename = 'VTS Report'; //your file name
		$objPHPExcel = new PHPExcel();
		
		//Set Column Width*/
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(77);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(21);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(22);
		
		
		
		//Center Alignment
		$objPHPExcel->getActiveSheet()->getStyle('A1:A6')->getAlignment()->setHorizontal('center');
		
		
				
		//Merging cell
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:F1');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:F2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:F3');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:F4');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:F6');
		
		
		
		//Fill Color		
		$objPHPExcel->getActiveSheet()->getStyle('A9:F9')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('#999999');
		
		//First Data font style
		$objPHPExcel->getActiveSheet()->getStyle("A1:A2")->getFont()->setBold(true)
                                ->setName('Old English Text MT')
                                ->setSize(11)
                                ->getColor()->setRGB('#000000');
		
											
		$objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('A1', 'Republic of the Philippines')
			->setCellValue('A2', 'Department of Education')
			->setCellValue('A3', 'REGION IX, ZAMOBOANGA PENINSULA')
			->setCellValue('A4', 'DIVISION OF PAGADIAN CITY');
			
			
		$objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('A6',"VEHICLE UTILIZATION SUMMARY REPORT");
			
			
		//Code for Bold Style
			$objPHPExcel->getActiveSheet()->getStyle('A9:F9')->getFont()->setBold(true); //Make heading font bold
			$objPHPExcel->getActiveSheet()->setShowGridlines(false);
			
			
		/*Starting Data Border*/
		$styleHeader = array(
				'borders' => array(
				'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		  )
		);//Heading	
		
		$objPHPExcel->getActiveSheet()->getStyle('A9:F9')->applyFromArray($styleHeader);
		unset($styleHeader);
		
		
		//First Data
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A9', '#')
					->setCellValue('B9', 'Date')
					->setCellValue('C9', 'Destination')
					->setCellValue('D9', 'Vehicel & Plate No.')
					->setCellValue('E9', 'Driver')
					->setCellValue('F9', 'Requested by');
					
					
		 $no=0;
		 $range=10;
		$request=mysqli_query($con,"SELECT * FROM tbl_vehicle_reservation INNER JOIN tbl_vehicle ON tbl_vehicle_reservation.VehicleCode = tbl_vehicle.VehicleCode WHERE tbl_vehicle_reservation.RequestStatus <> 'For Approval'");
		while($rowre=mysqli_fetch_array($request))
			{
				$styleData = array(
						'borders' => array(
						'allborders' => array(
					  'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				  )
				);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$range.':F'.$range)->applyFromArray($styleData);
			unset($styleData);	
			
			$no++;
			
			$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A'.$range, $no)
					->setCellValue('B'.$range, $rowre['RequestDate'])
					->setCellValue('C'.$range, $rowre['RequestDestination'])
					->setCellValue('D'.$range, $rowre['Vehicle_Description'].'-'.$rowre['PlateNo'])
					->setCellValue('E'.$range, $rowre['Driver'])
					->setCellValue('F'.$range, $rowre['Requestedby']);
					
			 $range++;
				
		}			
	
		$range=$range+5;	
			$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A'.$range,"Prepared by:");
					
			$range=$range+2;
			$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('B'.$range,$_SESSION['user_information']);
					
		$objPHPExcel->getActiveSheet()->setTitle($filename); //give title to sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		header('Content-Type: text/xls');
		header("Content-Disposition: attachment;Filename=$filename.xls");
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
		$objWriter->save('php://output');
		exit;
		
?>
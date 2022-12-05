<?php
		session_start();
		include("../../pcdmis/vendor/jquery/function.php");
		header('content-type: text/html; charset: utf-8');
		date_default_timezone_set("Asia/Manila");
		require_once '../Classes/PHPExcel.php';
		
	     $filename = "Division of Pagadian City"; //your file name
		$objPHPExcel = new PHPExcel();
		
		//merging
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:H1');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:H2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C3:G3');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:A4');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B3:B4');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H3:H4');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:A10');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A11:A20');
		
		//Center Alignment
		$objPHPExcel->getActiveSheet()->getStyle('A1:H20')->getAlignment()->setHorizontal('center');
		
		
		//Set Column Width*/
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(13);
		
		
		
		//Code for Bold Style
			$objPHPExcel->getActiveSheet()->getStyle('A3:H4')->getFont()->setBold(true); //Make heading font bold
			$objPHPExcel->getActiveSheet()->setShowGridlines(False);
			
		/*Starting Data Border*/
		$styleHeader = array(
				'borders' => array(
				'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		  )
		);//Heading	
		
		$objPHPExcel->getActiveSheet()->getStyle('A3:H4')->applyFromArray($styleHeader);
		unset($styleHeader);	
		
		//First Data
		$objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('A1', 'IPCRF Data Collection System (SY 2021-2022');
		$objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('A2', "Division of Pagadian City");

		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A3', 'Profecientcy')
					->setCellValue('B3', 'Position')
					->setCellValue('C3', 'Adjectival Rating')
					->setCellValue('h3', 'Total');
		
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('C4', 'Poor')
					->setCellValue('D4', 'UnSatisfactory')
					->setCellValue('E4', 'Satisfactory')
					->setCellValue('F4', 'Very Satisfactory')	
					->setCellValue('G4', 'Outstanding');	
		//Get data from the database
		
			
				$styleData = array(
						'borders' => array(
						'allborders' => array(
					  'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				  )
				);
				
			$objPHPExcel->getActiveSheet()->getStyle('A5:H20')->applyFromArray($styleData);
			unset($styleData);	
			//SPET 1	
			$poorSP1=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'SPET 1' AND RatingAdjective='P'");
			$USSP1=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'SPET 1' AND RatingAdjective='US'");
			$SSP1=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'SPET 1' AND RatingAdjective='S'");
			$VSSP1=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'SPET 1' AND RatingAdjective='VS'");
			$OSP1=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'SPET 1' AND RatingAdjective='O'");
			$totalSP1=mysqli_num_rows($poorSP1)+mysqli_num_rows($USSP1)+mysqli_num_rows($SSP1)+mysqli_num_rows($VSSP1)+mysqli_num_rows($OSP1);		
			
				$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A5',"PROFICIENT")
					->setCellValue('B5', "SPET 1")
					->setCellValue('C5', mysqli_num_rows($poorSP1))
					->setCellValue('D5', mysqli_num_rows($USSP1))
					->setCellValue('E5', mysqli_num_rows($SSP1))
					->setCellValue('F5', mysqli_num_rows($VSSP1))	
					->setCellValue('G5',mysqli_num_rows($OSP1))	
					->setCellValue('H5', $totalSP1);	
			//SPET 2	
            $poorSP2=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'SPET 2' AND RatingAdjective='P'");
			$USSP2=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'SPET 2' AND RatingAdjective='US'");
			$SSP2=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'SPET 2' AND RatingAdjective='S'");
			$VSSP2=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'SPET 2' AND RatingAdjective='VS'");
			$OSP2=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'SPET 2' AND RatingAdjective='O'");
			$totalSP2=mysqli_num_rows($poorSP2)+mysqli_num_rows($USSP2)+mysqli_num_rows($SSP2)+mysqli_num_rows($VSSP2)+mysqli_num_rows($OSP2);	
			
			$objPHPExcel->setActiveSheetIndex(0) 
					
					->setCellValue('B6', "SPET 2")
					->setCellValue('C6', mysqli_num_rows($poorSP2))
					->setCellValue('D6', mysqli_num_rows($USSP2))
					->setCellValue('E6', mysqli_num_rows($SSP2))
					->setCellValue('F6', mysqli_num_rows($VSSP2))	
					->setCellValue('G6', mysqli_num_rows($OSP2))	
					->setCellValue('H6', $totalSP2);	
			//SPET 3	
			$poorSP3=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'SPET 3' AND RatingAdjective='P'");
			$USSP3=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'SPET 3' AND RatingAdjective='US'");
			$SSP3=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'SPET 3' AND RatingAdjective='S'");
			$VSSP3=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'SPET 3' AND RatingAdjective='VS'");
			$OSP3=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'SPET 3' AND RatingAdjective='O'");
			$totalSP3=mysqli_num_rows($poorSP3)+mysqli_num_rows($USSP3)+mysqli_num_rows($SSP3)+mysqli_num_rows($VSSP3)+mysqli_num_rows($OSP3);
			
			$objPHPExcel->setActiveSheetIndex(0) 
					
					->setCellValue('B7', "SPET 3")
					->setCellValue('C7', mysqli_num_rows($poorSP3))
					->setCellValue('D7', mysqli_num_rows($USSP3))
					->setCellValue('E7', mysqli_num_rows($SSP3))
					->setCellValue('F7', mysqli_num_rows($VSSP3))	
					->setCellValue('G7', mysqli_num_rows($OSP3))	
					->setCellValue('H7', $totalSP3);	
					
		    //Teacher 1		
			$poor=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'TEACHER 1' AND RatingAdjective='P'");
			$US=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'TEACHER 1' AND RatingAdjective='US'");
			$S=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'TEACHER 1' AND RatingAdjective='S'");
			$VS=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'TEACHER 1' AND RatingAdjective='VS'");
			$O=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'TEACHER 1' AND RatingAdjective='O'");
			$totalT1=mysqli_num_rows($poor)+mysqli_num_rows($US)+mysqli_num_rows($S)+mysqli_num_rows($VS)+mysqli_num_rows($O);
			
			$objPHPExcel->setActiveSheetIndex(0) 
					
					->setCellValue('B8', "TEACHER I")
					->setCellValue('C8', mysqli_num_rows($poor))
					->setCellValue('D8', mysqli_num_rows($US))
					->setCellValue('E8', mysqli_num_rows($S))
					->setCellValue('F8', mysqli_num_rows($VS))	
					->setCellValue('G8',mysqli_num_rows($O))	
					->setCellValue('H8', $totalT1);	
			
			//Teacher 2			
			$poor2=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'TEACHER 2' AND RatingAdjective='P'");
			$US2=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'TEACHER 2' AND RatingAdjective='US'");
			$S2=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'TEACHER 2' AND RatingAdjective='S'");
			$VS2=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'TEACHER 2' AND RatingAdjective='VS'");
			$O2=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'TEACHER 2' AND RatingAdjective='O'");
			$totalT2=mysqli_num_rows($poor2)+mysqli_num_rows($US2)+mysqli_num_rows($S2)+mysqli_num_rows($VS2)+mysqli_num_rows($O2);			
			
			$objPHPExcel->setActiveSheetIndex(0) 
					
					->setCellValue('B9', "TEACHER II")
					->setCellValue('C9',  mysqli_num_rows($poor2))
					->setCellValue('D9',  mysqli_num_rows($US2))
					->setCellValue('E9',  mysqli_num_rows($S2))
					->setCellValue('F9',  mysqli_num_rows($VS2))	
					->setCellValue('G9', mysqli_num_rows($O2))	
					->setCellValue('H9', $totalT2);			
				
			//Teacher 3	
			$poor3=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'TEACHER 3' AND RatingAdjective='P'");
			$US3=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'TEACHER 3' AND RatingAdjective='US'");
			$S3=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'TEACHER 3' AND RatingAdjective='S'");
			$VS3=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'TEACHER 3' AND RatingAdjective='VS'");
			$O3=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'TEACHER 3' AND RatingAdjective='O'");
			$totalT3=mysqli_num_rows($poor3)+mysqli_num_rows($US3)+mysqli_num_rows($S3)+mysqli_num_rows($VS3)+mysqli_num_rows($O3);		
			
			$objPHPExcel->setActiveSheetIndex(0) 
					
					->setCellValue('B10', "TEACHER III")
					->setCellValue('C10',  mysqli_num_rows($poor3))
					->setCellValue('D10',  mysqli_num_rows($US3))
					->setCellValue('E10',  mysqli_num_rows($S3))
					->setCellValue('F10',  mysqli_num_rows($O3))	
					->setCellValue('G10', mysqli_num_rows($poor2))	
					->setCellValue('H10', $totalT3);	
			
            //HEAD TEACHER 1
			$poorHT1=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'HEAD TEACHER 1' AND RatingAdjective='P'");
			$USHT1=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'HEAD TEACHER 1' AND RatingAdjective='US'");
			$SHT1=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'HEAD TEACHER 1' AND RatingAdjective='S'");
			$VSHT1=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'HEAD TEACHER 1' AND RatingAdjective='VS'");
			$OHT1=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'HEAD TEACHER 1' AND RatingAdjective='O'");
			$totalHT1=mysqli_num_rows($poorHT1)+mysqli_num_rows($USHT1)+mysqli_num_rows($SHT1)+mysqli_num_rows($VSHT1)+mysqli_num_rows($OHT1);		
			
			$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A11',"HIGHLY PROFICIENT")
					->setCellValue('B11', "HEAD TEACHER I")
					->setCellValue('C11',  mysqli_num_rows($poorHT1))
					->setCellValue('D11',  mysqli_num_rows($USHT1))
					->setCellValue('E11',  mysqli_num_rows($SHT1))
					->setCellValue('F11',  mysqli_num_rows($VSHT1))	
					->setCellValue('G11', mysqli_num_rows($OHT1))	
					->setCellValue('H11', $totalHT1);	
			
			//HEAD TEACHER 2
			$poorHT2=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'HEAD TEACHER 2' AND RatingAdjective='P'");
			$USHT2=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'HEAD TEACHER 2' AND RatingAdjective='US'");
			$SHT2=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'HEAD TEACHER 2' AND RatingAdjective='S'");
			$VSHT2=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'HEAD TEACHER 2' AND RatingAdjective='VS'");
			$OHT2=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'HEAD TEACHER 2' AND RatingAdjective='O'");
			$totalHT2=mysqli_num_rows($poorHT2)+mysqli_num_rows($USHT2)+mysqli_num_rows($SHT2)+mysqli_num_rows($VSHT2)+mysqli_num_rows($OHT2);		
			
			$objPHPExcel->setActiveSheetIndex(0) 
					
					->setCellValue('B12', "HEAD TEACHER II")
					->setCellValue('C12',  mysqli_num_rows($poorHT2))
					->setCellValue('D12',  mysqli_num_rows($USHT2))
					->setCellValue('E12',  mysqli_num_rows($SHT2))
					->setCellValue('F12',  mysqli_num_rows($VSHT2))	
					->setCellValue('G12', mysqli_num_rows($OHT2))	
					->setCellValue('H12', $totalHT2);				
					
			//HEAD TEACHER 3
			$poorHT3=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'HEAD TEACHER 3' AND RatingAdjective='P'");
			$USHT3=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'HEAD TEACHER 3' AND RatingAdjective='US'");
			$SHT3=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'HEAD TEACHER 3' AND RatingAdjective='S'");
			$VSHT3=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'HEAD TEACHER 3' AND RatingAdjective='VS'");
			$OHT3=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'HEAD TEACHER 3' AND RatingAdjective='O'");
			$totalHT3=mysqli_num_rows($poorHT3)+mysqli_num_rows($USHT3)+mysqli_num_rows($SHT3)+mysqli_num_rows($VSHT3)+mysqli_num_rows($OHT3);		
			
			$objPHPExcel->setActiveSheetIndex(0) 
					
					->setCellValue('B13', "HEAD TEACHER III")
					->setCellValue('C13',  mysqli_num_rows($poorHT3))
					->setCellValue('D13',  mysqli_num_rows($USHT3))
					->setCellValue('E13',  mysqli_num_rows($SHT3))
					->setCellValue('F13',  mysqli_num_rows($VSHT3))	
					->setCellValue('G13', mysqli_num_rows($OHT3))	
					->setCellValue('H13', $totalHT2);				
			
			//HEAD TEACHER 4
			$poorHT4=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'HEAD TEACHER 4' AND RatingAdjective='P'");
			$USHT4=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'HEAD TEACHER 4' AND RatingAdjective='US'");
			$SHT4=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'HEAD TEACHER 4' AND RatingAdjective='S'");
			$VSHT4=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'HEAD TEACHER 4' AND RatingAdjective='VS'");
			$OHT4=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'HEAD TEACHER 4' AND RatingAdjective='O'");
			$totalHT4=mysqli_num_rows($poorHT4)+mysqli_num_rows($USHT4)+mysqli_num_rows($SHT4)+mysqli_num_rows($VSHT4)+mysqli_num_rows($OHT4);		
			
			$objPHPExcel->setActiveSheetIndex(0) 
					
					->setCellValue('B14', "HEAD TEACHER IV")
					->setCellValue('C14',  mysqli_num_rows($poorHT4))
					->setCellValue('D14',  mysqli_num_rows($USHT4))
					->setCellValue('E14',  mysqli_num_rows($SHT4))
					->setCellValue('F14',  mysqli_num_rows($VSHT4))	
					->setCellValue('G14', mysqli_num_rows($OHT4))	
					->setCellValue('H14', $totalHT4);				
						
			//HEAD TEACHER 5
			$poorHT5=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'HEAD TEACHER 5' AND RatingAdjective='P'");
			$USHT5=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'HEAD TEACHER 5' AND RatingAdjective='US'");
			$SHT5=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'HEAD TEACHER 5' AND RatingAdjective='S'");
			$VSHT5=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'HEAD TEACHER 5' AND RatingAdjective='VS'");
			$OHT5=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'HEAD TEACHER 5' AND RatingAdjective='O'");
			$totalHT5=mysqli_num_rows($poorHT5)+mysqli_num_rows($USHT5)+mysqli_num_rows($SHT5)+mysqli_num_rows($VSHT5)+mysqli_num_rows($OHT5);		
			
			$objPHPExcel->setActiveSheetIndex(0) 
					
					->setCellValue('B15', "HEAD TEACHER V")
					->setCellValue('C15',  mysqli_num_rows($poorHT5))
					->setCellValue('D15',  mysqli_num_rows($USHT5))
					->setCellValue('E15',  mysqli_num_rows($SHT5))
					->setCellValue('F15',  mysqli_num_rows($VSHT5))	
					->setCellValue('G15', mysqli_num_rows($OHT5))	
					->setCellValue('H15', $totalHT5);				
					
			//MASTER TEACHER 1
			$poorMT1=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'MASTER TEACHER 1' AND RatingAdjective='P'");
			$USMT1=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'MASTER TEACHER 1' AND RatingAdjective='US'");
			$SMT1=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'MASTER TEACHER 1' AND RatingAdjective='S'");
			$VSMT1=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'MASTER TEACHER 1' AND RatingAdjective='VS'");
			$OMT1=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'MASTER TEACHER 1' AND RatingAdjective='O'");
			$totalMT1=mysqli_num_rows($poorMT1)+mysqli_num_rows($USMT1)+mysqli_num_rows($SMT1)+mysqli_num_rows($VSMT1)+mysqli_num_rows($OMT1);		
			
						
			$objPHPExcel->setActiveSheetIndex(0) 
					
					->setCellValue('B16', "MASTER TEACHER I")
					->setCellValue('C16',  mysqli_num_rows($poorMT1))
					->setCellValue('D16',  mysqli_num_rows($USMT1))
					->setCellValue('E16',  mysqli_num_rows($SMT1))
					->setCellValue('F16',  mysqli_num_rows($VSMT1))	
					->setCellValue('G16', mysqli_num_rows($OMT1))	
					->setCellValue('H16', $totalMT1);				
						
			//MASTER TEACHER 2
			$poorMT2=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'MASTER TEACHER 2' AND RatingAdjective='P'");
			$USMT2=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'MASTER TEACHER 2' AND RatingAdjective='US'");
			$SMT2=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'MASTER TEACHER 2' AND RatingAdjective='S'");
			$VSMT2=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'MASTER TEACHER 2' AND RatingAdjective='VS'");
			$OMT2=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'MASTER TEACHER 2' AND RatingAdjective='O'");
			$totalMT2=mysqli_num_rows($poorMT2)+mysqli_num_rows($USMT2)+mysqli_num_rows($SMT2)+mysqli_num_rows($VSMT2)+mysqli_num_rows($OMT2);	
			
				$objPHPExcel->setActiveSheetIndex(0) 
					
					->setCellValue('B17', "MASTER TEACHER II")
					->setCellValue('C17',  mysqli_num_rows($poorMT2))
					->setCellValue('D17',  mysqli_num_rows($USMT2))
					->setCellValue('E17',  mysqli_num_rows($SMT2))
					->setCellValue('F17',  mysqli_num_rows($VSMT2))	
					->setCellValue('G17', mysqli_num_rows($OMT2))	
					->setCellValue('H17', $totalMT2);	
					
			//MASTER TEACHER 3
			$poorMT3=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'MASTER TEACHER 3' AND RatingAdjective='P'");
			$USMT3=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'MASTER TEACHER 3' AND RatingAdjective='US'");
			$SMT3=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'MASTER TEACHER 3' AND RatingAdjective='S'");
			$VSMT3=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'MASTER TEACHER 3' AND RatingAdjective='VS'");
			$OMT3=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'MASTER TEACHER 3' AND RatingAdjective='O'");
			$totalMT3=mysqli_num_rows($poorMT3)+mysqli_num_rows($USMT3)+mysqli_num_rows($SMT3)+mysqli_num_rows($VSMT3)+mysqli_num_rows($OMT3);	
			
			$objPHPExcel->setActiveSheetIndex(0) 
					
					->setCellValue('B18', "MASTER TEACHER III")
					->setCellValue('C18',  mysqli_num_rows($poorMT3))
					->setCellValue('D18',  mysqli_num_rows($USMT3))
					->setCellValue('E18',  mysqli_num_rows($SMT3))
					->setCellValue('F18',  mysqli_num_rows($VSMT3))	
					->setCellValue('G18', mysqli_num_rows($OMT3))	
					->setCellValue('H18', $totalMT3);	
				
			//Special Science TEACHER 1
			$poorSST1=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'SST 1' AND RatingAdjective='P'");
			$USSST1=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'SST 1' AND RatingAdjective='US'");
			$SSST1=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'SST 1' AND RatingAdjective='S'");
			$VSSST1=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'SST 1' AND RatingAdjective='VS'");
			$OSST1=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'SST 1' AND RatingAdjective='O'");
			$totalSST1=mysqli_num_rows($poorSST1)+mysqli_num_rows($USSST1)+mysqli_num_rows($SSST1)+mysqli_num_rows($VSSST1)+mysqli_num_rows($OSST1);	
			
			$objPHPExcel->setActiveSheetIndex(0) 
					
					->setCellValue('B19', "SPECIAL SCIENCE TEACHER I")
					->setCellValue('C19',  mysqli_num_rows($poorSST1))
					->setCellValue('D19',  mysqli_num_rows($USSST1))
					->setCellValue('E19',  mysqli_num_rows($SSST1))
					->setCellValue('F19',  mysqli_num_rows($VSSST1))	
					->setCellValue('G19', mysqli_num_rows($OSST1))	
					->setCellValue('H19', $totalSST1);
					
			//SPET 1V
			$poorSPET4=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'SPET 4' AND RatingAdjective='P'");
			$USSPET4=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'SPET 4' AND RatingAdjective='US'");
			$SSPET4=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'SPET 4' AND RatingAdjective='S'");
			$VSSPET4=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'SPET 4' AND RatingAdjective='VS'");
			$OSPET4=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports WHERE Position = 'SPET 4' AND RatingAdjective='O'");
			$totalSSPET4=mysqli_num_rows($poorSPET4)+mysqli_num_rows($USSPET4)+mysqli_num_rows($SSPET4)+mysqli_num_rows($VSSPET4)+mysqli_num_rows($OSPET4);	
			
			$objPHPExcel->setActiveSheetIndex(0) 
					
					->setCellValue('B20', "SPET IV")
					->setCellValue('C20',  mysqli_num_rows($poorSPET4))
					->setCellValue('D20',  mysqli_num_rows($USSPET4))
					->setCellValue('E20',  mysqli_num_rows($SSPET4))
					->setCellValue('F20',  mysqli_num_rows($VSSPET4))	
					->setCellValue('G20', mysqli_num_rows($OSPET4))	
					->setCellValue('H20', $totalSSPET4);			
				
				
				
		$objPHPExcel->getActiveSheet()->setTitle($filename); //give title to sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		header('Content-Type: text/csv');
		header("Content-Disposition: attachment;Filename=IPCRFConsol.xls");
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
		$objWriter->save('php://output');
		exit;
		
?>
<?php
	session_start();
    include("../../pcdmis/vendor/jquery/function.php");
	foreach ($_GET as $key => $data)
{
$url=$_GET[$key]=base64_decode(urldecode($data));
	
}
		header('content-type: text/html; charset: utf-8');
		date_default_timezone_set("Asia/Manila");
		require_once '../Classes/PHPExcel.php';
		
	     $filename =$url." Major Highest"; //your file name
		$objPHPExcel = new PHPExcel();
		
		//Center Alignment
		$objPHPExcel->getActiveSheet()->getStyle('A1:A10')->getAlignment()->setHorizontal('center');
		
		
		//Heading Alignment
		$objPHPExcel->getActiveSheet()->getStyle('E12:U14')->getAlignment()->setHorizontal('center');
				
		
		//Merging cell
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:U1');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:U2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:U3');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:U4');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:U6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A7:U7');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A10:U10');
		
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E12:H12');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('I12:K12');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('L12:M12');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('N12:O12');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('S12:T12');
		
		
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A12:A14');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B12:B14');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C12:C14');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D12:D14');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('P12:P13');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('Q12:Q14');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('R12:R14');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('U12:U14');
		
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E13:E14');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('L13:L14');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('S13:S14');
		
		
		//Set Column Width*/
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(35);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(6);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(6);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(6);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(6);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(6);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(6);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(6);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(6);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(6);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(6);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(6);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(10);
		
		//Fill Color		
		$objPHPExcel->getActiveSheet()->getStyle('A12:U14')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('#999999');
		
		//First Data font style
		$objPHPExcel->getActiveSheet()->getStyle("A1:A2")->getFont()->setBold(true)
                                ->setName('Old English Text MT')
                                ->setSize(11)
                                ->getColor()->setRGB('#000000');
		
					
		$objPHPExcel->getActiveSheet()->getStyle("A7")->getFont()->setItalic(true)
                                ->setName('Arial Rounded MT')
                                ->setSize(8)
                                ->getColor()->setRGB('#000000');
								
		$objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('A1', 'Republic of the Philippines')
			->setCellValue('A2', 'Department of Education')
			->setCellValue('A3', 'REGION IX, ZAMOBOANGA PENINSULA')
			->setCellValue('A4', 'DIVISION OF PAGADIAN CITY');
			
			
		$objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('A6',"2022 REGISTRY OF TEACHER 1 APPLICANTS - SECONDARY")
			->setCellValue('A7',"(per DepEd Order No. 7, s. 2015)")
			->setCellValue('A10',"EVALUATION AND SELECTION CRITERIA");
			
		//Code for Bold Style
			$objPHPExcel->getActiveSheet()->getStyle('A12:U12')->getFont()->setBold(true); //Make heading font bold
			$objPHPExcel->getActiveSheet()->setShowGridlines(false);
			
		/*Starting Data Border*/
		$styleHeader = array(
				'borders' => array(
				'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		  )
		);//Heading	
		
		$objPHPExcel->getActiveSheet()->getStyle('A12:U14')->applyFromArray($styleHeader);
		unset($styleHeader);
		
	
		
		//Set Wrap text
		$objPHPExcel->getActiveSheet()->getStyle('E12:U14')->getAlignment()->setWrapText(true);	
		
			
			
		//First Data
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A12', 'Name')
					->setCellValue('B12', 'Major')
					->setCellValue('C12', 'Contact#')
					->setCellValue('D12', 'Address')
					->setCellValue('E12', 'Education (20)')
					->setCellValue('I12', 'Teaching Experience (15)')
					->setCellValue('L12', 'LET/PBET (15)')
					->setCellValue('N12', 'Specialized T&S (10)')
					->setCellValue('P12', 'Sub Total')
					->setCellValue('Q12', 'Interview (10)')
					->setCellValue('R12', 'Demo Teachng (15)')
					->setCellValue('S12', 'Eng. Com Skls (15)')
					->setCellValue('U12', 'Grand Total');
					
					
		//Second Data
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('E13', 'GWA')
					->setCellValue('F13', 'Equiv')
					->setCellValue('G13', 'MA / PhD')
					->setCellValue('H13', 'Sub Total')
					->setCellValue('I13', 'Gen T E.')
					->setCellValue('J13', 'KVT/LGU')
					->setCellValue('K13', 'Sub Total')
					->setCellValue('L13', 'Rating')
					->setCellValue('M13', 'Equiv')
					->setCellValue('N13', 'Cert.')
					->setCellValue('O13', 'Demo')
					->setCellValue('S13', 'Rating')
					->setCellValue('T13', 'Equiv');
					
		//Third Data
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('F14', '18')
					->setCellValue('G14', '2')
					->setCellValue('H14', '20')
					->setCellValue('I14', '12')
					->setCellValue('J14', '3')
					->setCellValue('K14', '15')
					->setCellValue('M14', '15')
					->setCellValue('N14', '5')
					->setCellValue('O14', '5')
					->setCellValue('P14', '10')
					->setCellValue('S14', '10')
					->setCellValue('T14', '15');
													
		//Get data from the database
			$no=15;
			
			if ($url=='SCIENCE')
			{
			 $result=mysqli_query($con,"SELECT * FROM tbl_applicant INNER JOIN tbl_applicant_rating ON tbl_applicant.Appl_No = tbl_applicant_rating.ApplicanNo WHERE tbl_applicant.Status <> 'OLD' AND tbl_applicant.Category='".$_SESSION['ApplicantCat']."' AND tbl_applicant.Major LIKE '%".$url."%' ORDER BY tbl_applicant_rating.OverALL Desc");
			}else{	
			  $result=mysqli_query($con,"SELECT * FROM tbl_applicant INNER JOIN tbl_applicant_rating ON tbl_applicant.Appl_No = tbl_applicant_rating.ApplicanNo WHERE tbl_applicant.Status <> 'OLD' AND tbl_applicant.Category='".$_SESSION['ApplicantCat']."' AND tbl_applicant.Major='".$url."' ORDER BY tbl_applicant_rating.OverALL Desc");
			}
			 	
			while($row=mysqli_fetch_array($result))
			{
				$styleData = array(
						'borders' => array(
						'allborders' => array(
					  'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				  )
				);
			
			$MName=mb_strimwidth($row['Middle_Name'],0,1);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$no.':U'.$no)->applyFromArray($styleData);
			unset($styleData);	
			
            //Rating data
			$myrating=mysqli_query($con,"SELECT * FROM tbl_applicant_rating WHERE ApplicanNo='".$row['Appl_No']."' LIMIT 1");
			$rowrate=mysqli_fetch_assoc($myrating);
					
				$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A'.$no,$row['Last_Name'].', '.$row['First_Name'].' '.$MName.'.')
					->setCellValue('B'.$no, strtoupper($row['Major']))
					->setCellValue('C'.$no, $row['Contact_No'])
					->setCellValue('D'.$no, $row['Home_Address'])
					->setCellValue('E'.$no, $rowrate['One'])
					->setCellValue('F'.$no, $rowrate['EdEquiv'])	
					->setCellValue('G'.$no, $rowrate['Three'])	
					->setCellValue('H'.$no, $rowrate['EdSubTotal'])	
					->setCellValue('I'.$no, $rowrate['Five'])	
					->setCellValue('J'.$no, $rowrate['Six'])	
					->setCellValue('K'.$no, $rowrate['TeachSubTotal'])	
					->setCellValue('L'.$no, $rowrate['Eight'])	
					->setCellValue('M'.$no, $rowrate['RateEquive'])
					->setCellValue('N'.$no, $rowrate['Ten'])
					->setCellValue('O'.$no, $rowrate['Eleven'])
					->setCellValue('P'.$no, $rowrate['SpecialSubTotal'])
					->setCellValue('Q'.$no, $rowrate['Thirteen'])
					->setCellValue('R'.$no, $rowrate['Fourteen'])
					->setCellValue('S'.$no, $rowrate['Fifteen'])
					->setCellValue('T'.$no, $rowrate['EngEval'])
					->setCellValue('U'.$no, $rowrate['OverALL'])
					;	
					
					$no++;	
				}
			
		$no=$no+3;
		
		//First Layer Signature		
		//Name of First Signature 
		$objPHPExcel->getActiveSheet()->getStyle('A'.$no.':C'.$no)->getAlignment()->setHorizontal('center');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$no.':C'.$no);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$no)->getFont()->setBold(true)
                                ->setName('Arial')
                                ->setSize(11)
                                ->getColor()->setRGB('#000000');
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A'.$no, 'JAMES E. MARQUEZ, EdD');
					
					
		//Name of Second Signature 
		$objPHPExcel->getActiveSheet()->getStyle('E'.$no.':J'.$no)->getAlignment()->setHorizontal('center');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$no.':J'.$no);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$no)->getFont()->setBold(true)
                                ->setName('Arial')
                                ->setSize(11)
                                ->getColor()->setRGB('#000000');
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('E'.$no, 'DOMINIC A. SARAYAN');		

					
		//Name of Third Signature 
		$objPHPExcel->getActiveSheet()->getStyle('O'.$no.':R'.$no)->getAlignment()->setHorizontal('center');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('O'.$no.':R'.$no);
		$objPHPExcel->getActiveSheet()->getStyle('O'.$no)->getFont()->setBold(true)
                                ->setName('Arial')
                                ->setSize(11)
                                ->getColor()->setRGB('#000000');
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('O'.$no, 'JEESREL G. HIMANG');		
	
		
		//First Position
		$no++;
		$objPHPExcel->getActiveSheet()->getStyle('A'.$no.':C'.$no)->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('A'.$no)->getFont()->setBold(false)
                                ->setName('Arial')
                                ->setSize(9)
                                ->getColor()->setRGB('#000000');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$no.':C'.$no);
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A'.$no, 'SSP IV, NAPSHII President');
					
		
	
		//Second Position
		$objPHPExcel->getActiveSheet()->getStyle('E'.$no.':J'.$no)->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('E'.$no)->getFont()->setBold(false)
                                ->setName('Arial')
                                ->setSize(9)
                                ->getColor()->setRGB('#000000');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$no.':J'.$no);
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('E'.$no, 'Teachers\' Ass. Representative');
					
		
		//Third Position
		$objPHPExcel->getActiveSheet()->getStyle('O'.$no.':R'.$no)->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('O'.$no)->getFont()->setBold(false)
                                ->setName('Arial')
                                ->setSize(9)
                                ->getColor()->setRGB('#000000');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('O'.$no.':R'.$no);
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('O'.$no, 'Sec. FPTA-President');
		
		$no=$no+5;
		
		//Second Layer Signature		
		//Name of First Signature 
		$objPHPExcel->getActiveSheet()->getStyle('A'.$no.':C'.$no)->getAlignment()->setHorizontal('center');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$no.':C'.$no);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$no)->getFont()->setBold(true)
                                ->setName('Arial')
                                ->setSize(11)
                                ->getColor()->setRGB('#000000');
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A'.$no, 'JUSERE ANN C. BASAYA, EdD');
					
		$no++;
		
					
		//Name of Second Signature 
		$objPHPExcel->getActiveSheet()->getStyle('E'.$no.':J'.$no)->getAlignment()->setHorizontal('center');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$no.':J'.$no);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$no)->getFont()->setBold(true)
                                ->setName('Arial')
                                ->setSize(11)
                                ->getColor()->setRGB('#000000');
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('E'.$no, 'SALEM T. UYAG');		

					
		//Name of Third Signature 
		$objPHPExcel->getActiveSheet()->getStyle('O'.$no.':R'.$no)->getAlignment()->setHorizontal('center');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('O'.$no.':R'.$no);
		$objPHPExcel->getActiveSheet()->getStyle('O'.$no)->getFont()->setBold(true)
                                ->setName('Arial')
                                ->setSize(11)
                                ->getColor()->setRGB('#000000');
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('O'.$no, 'RAQUEL R. YAP');		
	
		
		//First Position
		$no++;
		$objPHPExcel->getActiveSheet()->getStyle('A'.$no.':C'.$no)->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('A'.$no)->getFont()->setBold(false)
                                ->setName('Arial')
                                ->setSize(9)
                                ->getColor()->setRGB('#000000');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$no.':C'.$no);
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A'.$no, 'Education Program Supervisor');
					
		
	
		//Second Position
		$objPHPExcel->getActiveSheet()->getStyle('E'.$no.':J'.$no)->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('E'.$no)->getFont()->setBold(false)
                                ->setName('Arial')
                                ->setSize(9)
                                ->getColor()->setRGB('#000000');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$no.':J'.$no);
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('E'.$no, 'Education Program Supervisor');
					
		
		//Third Position
		$objPHPExcel->getActiveSheet()->getStyle('O'.$no.':R'.$no)->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('O'.$no)->getFont()->setBold(false)
                                ->setName('Arial')
                                ->setSize(9)
                                ->getColor()->setRGB('#000000');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('O'.$no.':R'.$no);
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('O'.$no, 'Education Program Supervisor');
					
		
		$no=$no+5;
		
		//Fourth Layer Signature		
		//Name of Fourth Signature 
		$objPHPExcel->getActiveSheet()->getStyle('A'.$no.':U'.$no)->getAlignment()->setHorizontal('center');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$no.':U'.$no);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$no)->getFont()->setBold(true)
                                ->setName('Arial')
                                ->setSize(11)
                                ->getColor()->setRGB('#000000');
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A'.$no, 'MA. COLLEEN L. EMORICHA, EdD., CESE');
		
		$no++;
		$objPHPExcel->getActiveSheet()->getStyle('A'.$no.':U'.$no)->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('A'.$no)->getFont()->setBold(false)
                                ->setName('Arial')
                                ->setSize(9)
                                ->getColor()->setRGB('#000000');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$no.':U'.$no);
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A'.$no, 'Assistant Schools Division Superintendent- Chairman');
					
		$no=$no+3;
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('D'.$no, 'Approved by:');
		
	    $no=$no+2;
		$objPHPExcel->getActiveSheet()->getStyle('A'.$no.':U'.$no)->getAlignment()->setHorizontal('center');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$no.':U'.$no);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$no)->getFont()->setBold(true)
                                ->setName('Arial')
                                ->setSize(11)
                                ->getColor()->setRGB('#000000');
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A'.$no, 'MA. LIZA R. TABILON, EdD., CESO V');
		
		$no++;
		$objPHPExcel->getActiveSheet()->getStyle('A'.$no.':U'.$no)->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('A'.$no)->getFont()->setBold(false)
                                ->setName('Arial')
                                ->setSize(9)
                                ->getColor()->setRGB('#000000');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$no.':U'.$no);
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A'.$no, 'Schools Division Superintendent');
		
		
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
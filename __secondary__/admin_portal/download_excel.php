<?php
		session_start();
	include("../../pcdmis/vendor/jquery/function.php");
		foreach ($_GET as $key => $data)
		{
		$code=$_GET[$key]=base64_decode(urldecode($data));
			
		}
		header('content-type: text/html; charset: utf-8');
		date_default_timezone_set("Asia/Manila");
		require_once '../Classes/PHPExcel.php';
		
	     $filename = "RAT_RESULT"; //your file name
		$objPHPExcel = new PHPExcel();
		$_SESSION['SubCode']=$code;
		$_SESSION['GLevel']=$_GET['GLevel'];
		//Merge cell
		$objPHPExcel->getActiveSheet(0)->mergeCells('A1:E1');
		$objPHPExcel->getActiveSheet(0)->mergeCells('A2:E2');
		$objPHPExcel->getActiveSheet(0)->mergeCells('A3:E3');
		$objPHPExcel->getActiveSheet(0)->mergeCells('A4:E4');
		$objPHPExcel->getActiveSheet(0)->mergeCells('A5:E5');
		$objPHPExcel->getActiveSheet(0)->mergeCells('A6:E6');
		$objPHPExcel->getActiveSheet(0)->mergeCells('C11:D11');
		$objPHPExcel->getActiveSheet(0)->mergeCells('A11:A12');
		$objPHPExcel->getActiveSheet(0)->mergeCells('B11:B12');
		$objPHPExcel->getActiveSheet(0)->mergeCells('E11:E12');
		
		
		
		//Center Alignment
		$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('A4:E4')->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('A5:E5')->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('A11:E11')->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('C12:D12')->getAlignment()->setHorizontal('center');
				
		//Set Column Width*/
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(21);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(75);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
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
		$objPHPExcel->getActiveSheet()->getStyle('C11:D11')->getAlignment()->setWrapText(true);	
		$objPHPExcel->getActiveSheet()->getStyle('E11')->getAlignment()->setWrapText(true);	

		
		/*Starting Data Border*/
		$styleHeader = array(
				'borders' => array(
				'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		  )
		);//Heading	
		
		/*Starting Data Border*/
		$styleHeader1 = array(
				'borders' => array(
				'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		  )
		);//Heading	
		
		
		$objPHPExcel->getActiveSheet()->getStyle('A11:E11')->applyFromArray($styleHeader);
		unset($styleHeader);
		
		$objPHPExcel->getActiveSheet()->getStyle('A12:E12')->applyFromArray($styleHeader1);
		unset($styleHeader1);
		
		
		//Query for subject
	$subject=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_subject WHERE RATSubCode ='".$code."' AND Exam_Status='".$_SESSION['rat_status']."'LIMIT 1");
	$rowsub=mysqli_fetch_assoc($subject);
	
	//Variable
	$total=$percent=$TotalPercent=$SubPercent=$SubTotal= $Totallearner=0; 
	$remarkdata="";
	
	//Query for Learner
	$learner=mysqli_query($con,"SELECT * FROM tbl_assessment_rat INNER JOIN tbl_learners ON  tbl_assessment_rat.LRN = tbl_learners.lrn WHERE tbl_learners.Grade='4'");
	$Totallearner=mysqli_num_rows($learner);
		
		
		//First Data
		$objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('A1', 'Republic of the Philippines');
		$objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('A2',  'Department of Education');
        $objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('A3',  'Region IX, Zamboanga Peninsula');
		$objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('A4',  'DIVISION OF PAGADIAN CITY');			
		$objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('A5',  'Pagadian City');			
		$objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('A6',  'TEST ITEM MASTERY LEVEL');	


		$objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('A7',  'LEARNING AREA:')
			->setCellValue('B7', $rowsub['Learning_Areas'].' '.$_SESSION['GLevel']);	
		$objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('A8',  'TOTAL # OF EXAMINEES:')	
			->setCellValue('B8',  $Totallearner.' Learners');	
		$objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('A9',  'TOTAL # OF ITEMS:')
			->setCellValue('B9',  $rowsub['No_of_Items'].' Items');	
			
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A11', 'Test Item No.')
					->setCellValue('B11', 'Learning Competencies')
					->setCellValue('C11', 'Total # of Examinees with correct responses')
					->setCellValue('E11', 'Interpretations *Mastered *Closely Approximating Mastery *Moving Towards Mastery *Average *Low *Very Low *Absolutely No Mastery');
					
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('C12', 'Total')
					->setCellValue('D12', '%');
					
		//Get data from the database
		$no=13;
		$Itime=1;
				
	
		
			
		$mylearner=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_questionaires WHERE tbl_assessment_rat_questionaires.SubCode='".$code."'");
								
							
			while($row=mysqli_fetch_array($mylearner))	
				{
				
				$styleData = array(
						'borders' => array(
						'allborders' => array(
					  'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				  )
				);
				
			//Remarks Data
			if ($Totallearner<>0)
			{				
			$percent=number_format(($row['NoOfCorrect']/$Totallearner)*100,0);
		    }
  		  if ($percent>=96 AND $percent<=100)
				{
				  $remarkdata='MASTERED';
				}elseif ($percent>=86 AND $percent<=95)
				{
					$remarkdata='CLOSELY APPROXIMATING MASTERY';
				}elseif ($percent>=66 AND $percent<=85)
				{
				  $remarkdata='MOVING TOWARDS MASTERY';
				}elseif ($percent>=35 AND $percent<=65)
				{
				$remarkdata='AVERAGE';
				}elseif ($percent>=15 AND $percent<=34)
				{
					$remarkdata='LOW';
				}elseif ($percent>=5 AND $percent<=14)
				{
					$remarkdata='VERY LOW';
				}elseif ($percent>=0 AND $percent<=4)
				{
				$remarkdata='ABSOLUTELY NO MASTERY';
				}	
				
			$objPHPExcel->getActiveSheet()->getStyle('A'.$no)->getAlignment()->setHorizontal('center');
			$objPHPExcel->getActiveSheet()->getStyle('C'.$no)->getAlignment()->setHorizontal('center');
			$objPHPExcel->getActiveSheet()->getStyle('D'.$no)->getAlignment()->setHorizontal('center');
			$objPHPExcel->getActiveSheet()->getStyle('E'.$no)->getAlignment()->setHorizontal('center');
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$no.':E'.$no)->applyFromArray($styleData);
			unset($styleData);	
					
				$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A'.$no,$Itime)
					->setCellValue('B'.$no, $row['Questionnairs'])
					->setCellValue('C'.$no, $row['NoOfCorrect'])
					->setCellValue('D'.$no, $percent.' %')
					->setCellValue('E'.$no, $remarkdata);	
					$no++;
				$Itime++;	

	$total=$total+$row['NoOfCorrect'];
	$SubPercent=$SubPercent+$percent;				
				}	
	
	$SubTotal=$Totallearner * $rowsub['No_of_Items'];
		if ($SubTotal<>0)
			{
				$TotalPercent= ($total/$SubTotal)*100;
			}
		if ($TotalPercent>=96 AND $TotalPercent<=100)
			{
			$remarkdata='MASTERED';
			}elseif ($TotalPercent>=86 AND $TotalPercent<=95)
			{
			$remarkdata='CLOSELY APPROXIMATING MASTERY';
			}elseif ($TotalPercent>=66 AND $TotalPercent<=85)
			{
			$remarkdata='MOVING TOWARDS MASTERY';
			}elseif ($TotalPercent>=35 AND $TotalPercent<=65)
			{
			$remarkdata='AVERAGE';
			}elseif ($TotalPercent>=15 AND $TotalPercent<=34)
			{
			$remarkdata='LOW';
			}elseif ($TotalPercent>=5 AND $TotalPercent<=14)
		    {
			$remarkdata='VERY LOW';
			}elseif ($TotalPercent>=0 AND $TotalPercent<=4)
			{
			$remarkdata='ABSOLUTELY NO MASTERY';
			}	
										
	$mainscore=$mps=0;
	
	$styleData1 = array(
						'borders' => array(
						'allborders' => array(
					  'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				  )
				);
				
		
	$objPHPExcel->getActiveSheet(0)->mergeCells('A'.$no.':B'.$no);		
	$objPHPExcel->getActiveSheet()->getStyle('C'.$no)->getAlignment()->setHorizontal('center');
	$objPHPExcel->getActiveSheet()->getStyle('D'.$no)->getAlignment()->setHorizontal('center');
	$objPHPExcel->getActiveSheet()->getStyle('E'.$no)->getAlignment()->setHorizontal('center');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$no)->getAlignment()->setHorizontal('right');
	
	$objPHPExcel->getActiveSheet()->getStyle('A'.$no.':E'.$no)->applyFromArray($styleData1);
	unset($styleData1);	
	
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A'.$no,'TOTAL')
					->setCellValue('C'.$no, $total)
					->setCellValue('D'.$no,number_format($TotalPercent,1).' %')
					->setCellValue('E'.$no,$remarkdata);
					
		$no++;
		$no++;
		$objPHPExcel->getActiveSheet(0)->mergeCells('A'.$no.':E'.$no);		
		$objPHPExcel->getActiveSheet()->getStyle('A'.$no)->getAlignment()->setHorizontal('center');
		
		//initialize
		$mainscore=$mps=0;
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A'.$no,'MEAN PERCENTAGE SCORE');
					
				
	
		$no++;
		//Put border			
				$styleData2 = array(
						'borders' => array(
						'allborders' => array(
					  'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				  )
				);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$no.':G'.$no)->applyFromArray($styleData2);
	unset($styleData2);
	//Set Center
	
	$objPHPExcel->getActiveSheet()->getStyle('A'.$no.':G'.$no)->getAlignment()->setHorizontal('center');
		
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A'.$no,'No')
					->setCellValue('B'.$no,'Grade Level')
					->setCellValue('C'.$no,'No. of Students')
					->setCellValue('D'.$no,'No. of Items')
					->setCellValue('E'.$no,'Total Scores')
					->setCellValue('F'.$no,'Mean Score')
					->setCellValue('G'.$no,'MPS');
					
									
					
		$no++;
		
		//Put border
					$styleData3 = array(
						'borders' => array(
						'allborders' => array(
					  'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				  )
				);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$no.':G'.$no)->applyFromArray($styleData3);
	unset($styleData3);		
	$objPHPExcel->getActiveSheet()->getStyle('A'.$no.':G'.$no)->getAlignment()->setHorizontal('center');
	
	
		//Put data
		if($Totallearner<>0)
		{
		$mainscore=$total/$Totallearner;
		}
		$mps=($mainscore/$rowsub['No_of_Items'])*100;
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A'.$no,'1')
					->setCellValue('B'.$no,'Grade '.$_SESSION['GLevel'])
					->setCellValue('C'.$no,$Totallearner)
					->setCellValue('D'.$no,$rowsub['No_of_Items'])
					->setCellValue('E'.$no,number_format($total,0))
					->setCellValue('F'.$no,number_format($mainscore,1))
					->setCellValue('G'.$no,number_format($mps,1).'%');
					
					
					
		$objPHPExcel->getActiveSheet()->setTitle($filename); //give title to sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		header('Content-Type: text/xls');
		header("Content-Disposition: attachment;Filename=DepEd-RAT.xls");
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
		$objWriter->save('php://output');
		exit;
		
?>
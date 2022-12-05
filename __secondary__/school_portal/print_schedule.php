
<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");

	require("../../pcdmis/fpdf.php"); 
   //Images
	$img1='../../pcdmis/shs/h1.png';	
	$img2='../../pcdmis/logo/logo.png';	
 	//New PDF File		 
		$pdf =new FPDF('P','mm','Legal');
	//Add New Page
		$pdf->AliasNbPages('{pages}');
		$pdf->AddPage();
		
	$pdf->Image($img1,40,10,20);
	$pdf->Image($img2,155,10,20);
	//Set Font  10	
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'Republic of the Philippines',0,1,'C');
	$pdf->Cell(0,5,'Department of Education',0,1,'C');
	$pdf->Cell(0,5,'Region IX, Zamboanga Peninsula',0,1,'C');
	$pdf->Cell(0,5,'DIVISION OF PAGADIAN CITY',0,1,'C');
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->Cell(0,4,$_SESSION['SchoolName'],0,1,'C');
	$pdf->Cell(0,4,$_SESSION['Address'],0,1,'C');
	$pdf->Cell(0,3,'',0,1,'C');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'CLASS PROGRAM',0,1,'C');
	
	//Section data
	$emp_info=mysqli_query($con,"SELECT * FROM tbl_section INNER JOIN tbl_employee ON tbl_section.Emp_ID = tbl_employee.Emp_ID INNER JOIN tbl_station ON tbl_employee.Emp_ID =tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND tbl_section.School_Year ='".$_SESSION['year']."' AND tbl_section.SecCode='".$_SESSION['sec_id']."' ORDER BY tbl_section.SecDesc Asc")or die ('Error Adding Section');
	$data=mysqli_fetch_assoc($emp_info);
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->Cell(40,5,'SECTION NAME: ',0,0);
	$pdf->Cell(40,5,$data['SecDesc'],0,1);
	$pdf->Cell(40,5,'GRADE LEVEL:',0,0);
	   if ($data['Grade']=='Kinder')
			{	
			$pdf->Cell(40,5,$data['Grade'],0,1);							
			}else{
			$pdf->Cell(40,5,'GRADE '.$data['Grade'],0,1);								
			}
	
	$pdf->Cell(40,5,'CLASS ADVISER: ',0,0);
	$pdf->Cell(40,5,$data['Emp_LName'].', '.$data['Emp_FName'],0,1);
	$pdf->Cell(40,5,'POSITION: ',0,0);
	$pdf->Cell(40,5,$data['Job_description'],0,1);
	$pdf->Cell(40,5,'ROOM LOCATION: ',0,0);
	$pdf->Cell(40,5,$data['Room_location'],0,1);
	
	
	$pdf->Cell(0,5,'',0,1,'L');
	$pdf->Cell(7,10,'#',1,0,'C');
	$pdf->Cell(85,10,'LEARNING AREAS',1,0);
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->Multicell(60,5,'SCHEDULE',1,'C');
	$pdf->Cell(92,10,"",0,0);
	$pdf->Cell(20,5,"TIME",1,0,'C');
	$pdf->Cell(20,5,"DAY",1,0,'C');
	$pdf->Cell(20,5,"ROOM",1,0,'C');
	$pdf->SetXY($xPos+60,$yPos);
	$pdf->Multicell(50,10,'TEACHER',1,'C');
	
	
	$pdf->SetFont('Arial','',8);
	  if ($data['Grade']==11 || $data['Grade']==12)
		{
			$no=0;
			$requery=mysqli_query($con,"SELECT * FROM class_program INNER JOIN tbl_senior_sub_strand ON class_program.SubNo=tbl_senior_sub_strand.StrandsubCode INNER JOIN tbl_section ON class_program.SecCode=tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID=tbl_employee.Emp_ID WHERE class_program.SecCode='".$_SESSION['sec_id']."' AND class_program.Semester='".$_SESSION['Sem']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['school_id']."'");
			while($drow=mysqli_fetch_array($requery))
			{
				$no++;
				$pdf->Cell(7,10,$no,1,0,'C');
				$pdf->Cell(85,10,$drow['LearningAreas'],1,0);
				$pdf->Cell(20,10,$drow['SecTime'],1,0,'C');
				$pdf->Cell(20,10,$drow['SecDay'],1,0,'C');
				$pdf->Cell(20,10,$drow['SecDesc'],1,0,'C');
				$pdf->Cell(50,10,$drow['Emp_LName'].', '.$drow['Emp_FName'],1,1);
				
			}
		}elseif ($data['Grade']>=7 AND $data['Grade']<=10){
			$no=0;
			$requery=mysqli_query($con,"SELECT * FROM class_program INNER JOIN tbl_jhs_subject ON class_program.SubNo=tbl_jhs_subject.SubNo INNER JOIN tbl_section ON class_program.SecCode=tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID=tbl_employee.Emp_ID WHERE class_program.SecCode='".$_SESSION['sec_id']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['school_id']."'");
			while($drow=mysqli_fetch_array($requery))
			{
				$no++;
				$pdf->Cell(7,10,$no,1,0,'C');
				$pdf->Cell(85,10,$drow['LearningAreas'],1,0);
				$pdf->Cell(20,10,$drow['SecTime'],1,0);
				$pdf->Cell(20,10,$drow['SecDay'],1,0);
				$pdf->Cell(20,10,$drow['SecDesc'],1,0);
				$pdf->Cell(50,10,$drow['Emp_LName'].', '.$drow['Emp_FName'],1,1);
			}
			}else{
				$no=0;
				$requery=mysqli_query($con,"SELECT * FROM class_program INNER JOIN tbl_element_subject ON class_program.SubNo=tbl_element_subject.SubNo INNER JOIN tbl_section ON class_program.SecCode=tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID=tbl_employee.Emp_ID WHERE class_program.SecCode='".$_SESSION['sec_id']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['school_id']."'");
				while($drow=mysqli_fetch_array($requery))
					{
						$no++;
						$pdf->Cell(7,10,$no,1,0,'C');
						$pdf->Cell(85,10,$drow['LearningAreas'],1,0);
						$pdf->Cell(20,10,$drow['SecTime'],1,0);
						$pdf->Cell(20,10,$drow['SecDay'],1,0);
						$pdf->Cell(20,10,$drow['SecDesc'],1,0);
						$pdf->Cell(50,10,$drow['Emp_LName'].', '.$drow['Emp_FName'],1,1);
				    }
			}
	
	$pdf->Cell(0,3,'',0,1,'C');
	$pdf->Cell(30,5,'System Generated: ',0,0,'L');
	$pdf->Cell(65,5,date("l").', '. date("F d, Y"),0,1,'L');
		
	//Display the Output data
	$pdf->Output();
?>
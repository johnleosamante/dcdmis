<?php
session_start();
include_once("../../pcdmis/vendor/jquery/function.php");

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
										
	$qual=mysqli_query($con,"SELECT * FROM tbl_section WHERE tbl_section.SecCode='".$_SESSION['SecCode']."' AND tbl_section.SchoolID='".$_SESSION['school_id']."' AND tbl_section.School_Year ='".$_SESSION['year']."'  LIMIT 1");
	$data=mysqli_fetch_assoc($qual);
	$pdf->SetFont('Arial','i',10);
	$pdf->Cell(15,4,'GRADE: ',0,0,'L');
	$pdf->Cell(0,4,$data['Grade'],0,1,'L');
	$pdf->Cell(0,4,'SECTION: '.$data['SecDesc'],0,1,'L');
	$pdf->Cell(0,4,'ADVISER: '.$_SESSION['Adviser'],0,1,'L');
	
	
	$pdf->Cell(0,3,'',0,1,'C');
	$pdf->SetFont('Arial','',10);
	
	$pdf->Cell(23,5,'LRN',1,0,'C');
	$pdf->Cell(30,5,'Last Name',1,0,'C');
	$pdf->Cell(30,5,'First Name',1,0,'C');
	$pdf->Cell(30,5,'Middle Name',1,0,'C');
	$pdf->Cell(15,5,'Sex',1,0,'C');
	$pdf->Cell(70,5,'Address',1,1,'C');
	//Display data from database
	$pdf->SetFont('Arial','',8);
	if ($data['Grade']=='11' || $data['Grade']=='12')
	{
			if ($_SESSION['Sem']=='First Semester')
			{
				$myinfo=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn = tbl_student.lrn WHERE first_semester.SecCode='".$_SESSION['SecCode']."' AND first_semester.school_year='".$_SESSION['year']."' AND first_semester.SchoolID='".$_SESSION['school_id']."'");
	
			}elseif ($_SESSION['Sem']=='Second Semester')
			{
				$myinfo=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn = tbl_student.lrn WHERE second_semester.SecCode='".$_SESSION['SecCode']."' AND second_semester.school_year='".$_SESSION['year']."' AND second_semester.SchoolID='".$_SESSION['school_id']."'");
			}
	}else{
		$myinfo=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn = tbl_student.lrn WHERE tbl_learners.SecCode='".$_SESSION['SecCode']."' AND tbl_learners.school_year='".$_SESSION['year']."' AND tbl_learners.SchoolID='".$_SESSION['school_id']."'");
			
	}
	
	while($row=mysqli_fetch_array($myinfo))
		{
			$pdf->Cell(23,5,$row['lrn'],1,0,'C');
			$pdf->Cell(30,5,utf8_encode($row['Lname']),1,0,'L');
			$pdf->Cell(30,5,utf8_encode($row['FName']),1,0,'L');
			$pdf->Cell(30,5,utf8_encode($row['MName']),1,0,'L');
			$pdf->Cell(15,5,$row['Gender'],1,0,'L');
			$pdf->Cell(70,5,$row['Home_Address'],1,1,'L');
		}
		
	$pdf->Cell(0,5,' ',0,1,'L');
	$pdf->Cell(30,5,'System Generated: ',0,0,'L');
	$pdf->Cell(65,5,date("l").', '. date("F d, Y"),0,1,'L');
		
	//Display the Output data
	$pdf->Output();
?>
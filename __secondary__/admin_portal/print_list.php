
<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
require('../pcdmis/code128.php');
$pdf=new PDF_Code128('P','mm','Legal');
date_default_timezone_set("Asia/Manila");
$img1='../pcdmis/shs/h1.png';	
$img2='../pcdmis/logo/logo.png';

//Add New Page
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();
$pdf->Image($img1,165,10,20);
$pdf->Image($img2,30,10,20);



	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'Republic of the Philippines',0,1,'C');
	$pdf->Cell(0,5,'Department of Education',0,1,'C');
	$pdf->Cell(0,5,'Region IX, Zamboanga Peninsula',0,1,'C');
	$pdf->Cell(0,5,'DIVISION OF DIPOLOG CITY',0,1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,5,'Dipolog City',0,1,'C');
	$pdf->Cell(0,3,'',0,1);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(0,5,'REGIONAL ACHIEVEMENT TEST (RAT)',0,1,'C');
	$pdf->Cell(0,3,'',0,1);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'MASTERLIST OF EXAMINEES',0,1,'C');
	$pdf->Cell(0,3,'',0,1);

	//Learner Information
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'',0,1);
	//Search by Learner
		$pdf->Cell(10,5,'#',1,0,'C');	
		$pdf->Cell(65,5,'Examinees Name',1,0);	
		$pdf->Cell(25,5,'Grade Level',1,0);	
		$pdf->Cell(95,5,'School',1,1);
		
	$no=0;		
	
	$learnersearch=mysqli_query($con,"SELECT * FROM tbl_assessment_rat INNER JOIN tbl_student ON tbl_assessment_rat.LRN =tbl_student.lrn INNER JOIN tbl_school ON tbl_assessment_rat.SchoolID = tbl_school.SchoolID INNER JOIN tbl_registration ON tbl_assessment_rat.LRN = tbl_registration.lrn WHERE tbl_registration.school_year='".$_SESSION['year']."' AND tbl_assessment_rat.School_Year='".$_SESSION['year']."' ORDER BY tbl_student.Lname Asc");
	while($rowlearner=mysqli_fetch_array($learnersearch))
	{
		$no++;
		
		$middle=mb_strimwidth($rowlearner['MName'],0,1);
		$pdf->Cell(10,5,$no,1,0,'C');	
		$pdf->Cell(65,5,utf8_decode($rowlearner['Lname'].', '.$rowlearner['FName']),1,0);	
		$pdf->Cell(25,5,'Grade '.$rowlearner['Grade'],1,0);	
		$pdf->Cell(95,5,$rowlearner['SchoolName'],1,1);	
	}
	$pdf->Cell(0,5,'********************Nothing Follows*****************************',1,1,'C');	
	$pdf->Cell(0,5,'System Generated as of '.date("F d, Y @ H:i:s"),0,1);	
	
	

	//Display the Output data
	$pdf->Output();
?>
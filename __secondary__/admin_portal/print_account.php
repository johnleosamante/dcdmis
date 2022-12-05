
<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
require('../pcdmis/code128.php');
$pdf=new PDF_Code128('P','mm','Legal');

//Add New Page
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();



	$pdf->SetFont('Arial','',10);
	
	//Learners information
	$result=mysqli_query($con,"SELECT * FROM tbl_assessment_rat INNER JOIN tbl_student ON tbl_assessment_rat.LRN=tbl_student.lrn INNER JOIN tbl_school ON tbl_assessment_rat.SchoolID =tbl_school.SchoolID");
	while($row=mysqli_fetch_array($result))
	{
	$glrn=mb_strimwidth($row['lrn'],6,6);
	$pdf->Cell(0,5,'DEPED-PAGADIAN CITY DIVISION',0,1,'C');
	$pdf->Cell(0,5,'BUREAU OF EDUCATION ASSESSMENT',0,1,'C');
	$pdf->Cell(0,5,'Regional Achievment Test',0,1,'C');
	
	$pdf->Cell(0,5,'LOGIN STUB',0,1,'C');
	$pdf->Cell(0,3,'',0,1);
	$pdf->Cell(40,5,'LRN: '.$row['lrn'],0,0);
	$pdf->Cell(70,5,'Fullname: '.$row['Lname'].', '.$row['FName'],0,0);
	$pdf->Cell(0,5,'Grade Level: Grade '.$row['YLevel'],0,1);
	$pdf->Cell(0,5,'Name of School: '.$row['SchoolName'],0,1);
	$pdf->Cell(0,5,'Username: '.$row['DepedEmail'],0,1);
	$pdf->Cell(0,5,'Password: '.$glrn,0,1);
	$pdf->Cell(0,0,'',1,1,'C');
	$pass=md5($glrn);
	mysqli_query($con,"UPDATE tbl_assessment_rat SET learner_password='".$pass."' WHERE LRN ='".$row['lrn']."' LIMIT 1");
	}
	
	

	//Display the Output data
	$pdf->Output();
?>
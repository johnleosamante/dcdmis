<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");

require('../pcdmis/code128.php');
$pdf=new PDF_Code128('P','mm','Legal');

$img1='../pcdmis/shs/h1.png';	
$img2='../pcdmis/logo/logo.png';

//Add New Page
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();
$pdf->SetFont('Arial','',10);

//Display Images
$pdf->Image($img1,145,10,20);
$pdf->Image($img2,50,10,20);


//Header Information
	$pdf->Cell(0,5,'Republic of the Philippines',0,1,'C');
	$pdf->Cell(0,5,'Department of Education',0,1,'C');
	$pdf->Cell(0,5,'Region IX, Zamboanga Peninsula',0,1,'C');
	$pdf->Cell(0,5,'DIVISION OF DIPOLOG CITY',0,1,'C');
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(0,5,'Dipolog City',0,1,'C');
	
	
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->Cell(0,5,'Enrolment Summary by School as of '.date("F d, Y"),0,1,'C');	
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(10,5,'#',1,0,'C');	
	$pdf->Cell(90,5,'School Name',1,0,'C');	
	$pdf->Cell(20,5,'Male',1,0,'C');	
	$pdf->Cell(20,5,'Female',1,0,'C');	
	$pdf->Cell(20,5,'Total',1,0,'C');	
	$pdf->Cell(40,5,'Principal',1,1,'C');	
	$no=$overall=$male=$female=0;
	$myinfo=mysqli_query($con,"SELECT * FROM tbl_school INNER JOIN tbl_employee ON tbl_school.Incharg_ID=tbl_employee.Emp_ID WHERE tbl_school.School_Category <>'Division' ORDER BY tbl_school.SchoolName Asc");
		while($row=mysqli_fetch_array($myinfo))
			{
				$no++; 
				$myenrol=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.SchoolID='".$row['SchoolID']."' AND tbl_registration.school_year='".date("Y")."'");
				$mymale=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.SchoolID='".$row['SchoolID']."' AND tbl_registration.school_year='".date("Y")."' AND tbl_student.Gender='MALE'");
				$myfemale=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.SchoolID='".$row['SchoolID']."' AND tbl_registration.school_year='".date("Y")."' AND tbl_student.Gender='FEMALE'");
									
				$pdf->Cell(10,5,$no,1,0,'C');	
				$pdf->Cell(90,5,strtoupper($row['SchoolName']),1,0);	
				$pdf->Cell(20,5,number_format(mysqli_num_rows($mymale),0),1,0,'R');	
				$pdf->Cell(20,5,number_format(mysqli_num_rows($myfemale),0),1,0,'R');	
				$pdf->Cell(20,5,number_format(mysqli_num_rows($myenrol),0),1,0,'R');	
				$pdf->Cell(40,5,$row['Emp_LName'].', '.$row['Emp_FName'],1,1);	
				$overall=$overall+mysqli_num_rows($myenrol);
	       }
				$pdf->Cell(100,5,"Total:",1,0);	
				$pdf->Cell(20,5,"",1,0);	
				$pdf->Cell(20,5,"",1,0);	
				$pdf->Cell(20,5,number_format($overall,0),1,1,'R');
//View Output
$pdf->Output();
?>

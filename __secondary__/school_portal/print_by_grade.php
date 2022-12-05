<?php
session_start();
include("../vendor/jquery/function.php");

	require("../fpdf.php"); 
   //Images
	$img1='../shs/h1.png';	
	$img2='../logo/logo.png';	
 	//New PDF File		 
		$pdf =new FPDF('P','mm','Legal');
	//Add New Page
		$pdf->AliasNbPages('{pages}');
		$pdf->AddPage();
		
	$pdf->Image($img1,40,10,20);
	$pdf->Image($img2,155,10,15);
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
	$pdf->SetFont('Arial','i',10);
	$pdf->Cell(0,4,'List of Learner Registered',0,1,'L');
	$pdf->Cell(15,4,'Grade: ',0,0,'L');
	$pdf->Cell(0,4,$_SESSION['Grade'],0,1,'L');
	
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
	$myinfo=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='".$_SESSION['Grade']."' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."'");
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
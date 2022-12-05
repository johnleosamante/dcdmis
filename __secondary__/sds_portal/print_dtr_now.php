<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
date_default_timezone_set("Asia/Manila");
require('../../pcdmis/code128.php');
$pdf=new PDF_Code128('P','mm','Legal');

$img1='../../pcdmis/shs/h1.png';	
$img2='../../pcdmis/logo/logo.png';

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
	$pdf->Cell(0,5,'DIVISION OF PAGADIAN CITY',0,1,'C');
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(0,5,'Pagadian City',0,1,'C');
	$pdf->Cell(0,5,'',0,1);
	
	$pdf->SetFont('Arial','',10);
	$date = date('F j\, Y', strtotime($_SESSION['currentdate']));				
	$pdf->Cell(0,5,'DAILY TIME RECORDS AS OF '.$date ,0,1,'C');
	$pdf->Cell(0,5,'',0,1);
	$pdf->Cell(20,10,'#',1,0,'C');
	$pdf->Cell(70,10,'NAME',1,0);
	$pdf->Cell(50,5,'MORNING LOGS',1,0,'C');
	$pdf->Cell(50,5,'AFTERNOON LOGS',1,1,'C');
	$pdf->Cell(90,5,'',0,0,'C');
	$pdf->Cell(25,5,'IN',1,0,'C');
	$pdf->Cell(25,5,'OUT',1,0,'C');
	$pdf->Cell(25,5,'IN',1,0,'C');
	$pdf->Cell(25,5,'OUT',1,1,'C');
	$pdf->SetFont('Arial','',9);

		$no=0;
								
		$mydtrrecord=mysqli_query($con,"SELECT * FROM tbl_dtr INNER JOIN tbl_employee ON tbl_dtr.Emp_ID=tbl_employee.Emp_ID WHERE tbl_dtr.DTRDate = '".$_SESSION['currentdate']."' ORDER BY tbl_dtr.TimeINAM Asc");
			while($DTRRow=mysqli_fetch_array($mydtrrecord))
			{
				$no++;
				$pdf->Cell(20,5,$no,1,0,'C');
				$pdf->Cell(70,5,$DTRRow['Emp_LName'].', '.$DTRRow['Emp_FName'],1,0);
				$pdf->Cell(25,5,$DTRRow['TimeINAM'],1,0,'C');
				$pdf->Cell(25,5,$DTRRow['TimeOUTAM'],1,0,'C');
				$pdf->Cell(25,5,$DTRRow['TimeINPM'],1,0,'C');
				$pdf->Cell(25,5,$DTRRow['TimeOUTPM'],1,1,'C');
										
			}
			
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->Cell(0,5,'System Generated as of '.date('F j\, Y').' @ '.date("h:i A"),0,1);
	
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->Cell(0,5,'Prepared by:',0,1,'L');
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->Cell(20,5,'',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(0,5,$_SESSION['user_information'],0,1);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(20,5,'',0,0);
	$pdf->Cell(0,5,$_SESSION['user_discription'],0,1);
//View Output
$pdf->Output();
?>

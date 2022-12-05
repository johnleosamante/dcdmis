<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
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
	
	
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->Cell(0,5,'List of Division Personnel',0,1,'C');	
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(10,5,'#',1,0,'C');	
	$pdf->Cell(50,5,'Name',1,0,'C');	
	$pdf->Cell(70,5,'Position',1,0,'C');	
	$pdf->Cell(60,5,'Office',1,1,'C');	
	$no=0;
	$myinfo=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID =tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE  tbl_station.Emp_Station='123131' ORDER BY Emp_LName Asc")or die ("Retirees Information error");
		while($row=mysqli_fetch_array($myinfo))
			{
				$no=$no+1;                   
				$pdf->Cell(10,5,$no,1,0,'C');	
				$pdf->Cell(50,5,$row['Emp_LName'].','.$row['Emp_FName'],1,0);	
				$pdf->Cell(70,5,$row['Job_description'],1,0);	
				$pdf->Cell(60,5,'',1,1,'C');	
	       }
	
//View Output
$pdf->Output();
?>

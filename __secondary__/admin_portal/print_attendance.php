<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
header('content-type:text/html;charset=utf-8');
require("../pcdmis/fpdf.php"); 

$img1='../pcdmis/shs/h1.png';	
$img2='../pcdmis/logo/logo.png';	


 	//New PDF File		 
		$pdf =new FPDF('L','mm','A4');
	
	//Add New Page
		$pdf->AddPage();
	//Set Font  10	
		$pdf->SetFont('Arial','B',8);
	// Logo
	$pdf->Image($img1,180,10,20);
	$pdf->Image($img2,100,10,20);
	//$pdf->Image($img3,165,50,30);
	//Data
	$pdf->Cell(0,5,'Republic of the Philippines',0,1,'C');
	$pdf->Cell(0,5,'DEPARTMENT OF EDUCATION',0,1,'C');
	$pdf->Cell(0,5,'Division of Pagadian City',0,1,'C');
	$pdf->Cell(0,15,'',0,1,'C');
	$pdf->Cell(0,5,'List of Attendance',0,1);
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(10,10,'#',1,0,'C');
	$pdf->Cell(50,10,'Name',1,0,'C');
	$pdf->Cell(60,10,'School Name',1,0,'C');
	$pdf->Cell(35,10,'Date',1,0,'C');
	$pdf->Cell(50,5,'Morning Session',1,0,'C');
	$pdf->Cell(50,5,'Afternoon Session',1,1,'C');
	$pdf->Cell(155,5,'',0,0,'C');
	$pdf->Cell(25,5,'IN',1,0,'C');
	$pdf->Cell(25,5,'OUT',1,0,'C');
	$pdf->Cell(25,5,'IN',1,0,'C');
	$pdf->Cell(25,5,'OUT',1,1,'C');
	$no=0;
  $result=mysqli_query($con,"SELECT * FROM tblseminar_attendance INNER JOIN tbl_employee ON tblseminar_attendance.Emp_ID = tbl_employee.Emp_ID INNER JOIN tbl_station ON  tblseminar_attendance.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID");
									
	while($row=mysqli_fetch_array($result))
	{
		$no++;
		$pdf->Cell(10,10,$no,1,0,'C');
		$pdf->Cell(50,10,$row['Emp_FName'].' '.$row['Emp_LName'],1,0,'C');
		$pdf->Cell(60,10,$row['SchoolName'],1,0,'C');
		$pdf->Cell(35,10,$row['datestart'],1,0,'C');	
		$pdf->Cell(35,10,$row['MorningIN'],1,0,'C');	
		$pdf->Cell(35,10,$row['MorningOUT'],1,0,'C');	
		$pdf->Cell(35,10,$row['AfternoonIN'],1,0,'C');	
		$pdf->Cell(35,10,$row['AfternoonAOUT'],1,1,'C');	
	}	
	$pdf->Cell(25,5,'******************Nothing Follows***************',1,1,'C');	
	
		//Display the Output data
	$pdf->Output();
?>
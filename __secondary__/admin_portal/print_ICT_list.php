<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
header('content-type:text/html;charset=utf-8');
require("../pcdmis/fpdf.php"); 

$img1='../pcdmis/shs/h1.png';	
$img2='../pcdmis/logo/logo.png';	


 	//New PDF File		 
		$pdf =new FPDF();
	
	//Add New Page
		$pdf->AddPage();
	//Set Font  10	
		$pdf->SetFont('Arial','B',8);
	// Logo
	$pdf->Image($img1,165,10,20);
	$pdf->Image($img2,20,10,20);
	//$pdf->Image($img3,165,50,30);
	//Data
	$pdf->Cell(0,5,'Republic of the Philippines',0,1,'C');
	$pdf->Cell(0,5,'DEPARTMENT OF EDUCATION',0,1,'C');
	$pdf->Cell(0,5,'Division of Dipolog City',0,1,'C');
	$pdf->Cell(0,15,'',0,1,'C');
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(10,5,'#',1,0,'C');
	$pdf->Cell(60,5,'Name',1,0,'C');
	$pdf->Cell(70,5,'Station',1,0,'C');
	$pdf->Cell(30,5,'Contact No',1,1,'C');
	$no=0;
		$recstudent=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID INNER JOIN tbl_user ON tbl_employee.Emp_ID=tbl_user.usercode WHERE tbl_user.position ='ICT COORDINATOR' AND tbl_station.Emp_Category ='TEACHER' ORDER BY tbl_employee.Emp_LName Asc")or die ("School Table not found!");
									
			while($r = mysqli_fetch_assoc($recstudent)) 
			{
				$no++;
				
				$pdf->Cell(10,5,$no,1,0,'C');
				$pdf->Cell(60,5,utf8_encode($r['Emp_LName'].', '.$r['Emp_FName']),1,0);
				$pdf->Cell(70,5,$r['SchoolName'],1,0);
				$pdf->Cell(30,5,$r['Emp_Cell_No'],1,1);
				
                                    
			}			
		
		//Display the Output data
	$pdf->Output();
?>
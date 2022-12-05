
<?php
session_start();
include("../vendor/jquery/function.php");
require('../code128.php');


$pdf=new PDF_Code128('P','mm','Legal');


$img2='../shs/h1.png';	
$img1='../logo/logo.png';

//Add New Page
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();
$pdf->Image($img1,148,10,20);
$pdf->Image($img2,50,10,20);



	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'Republic of the Philippines',0,1,'C');
	$pdf->Cell(0,5,'Department of Education',0,1,'C');
	$pdf->Cell(0,5,'Region IX, Zamboanga Peninsula',0,1,'C');
	$pdf->Cell(0,5,'DIVISION OF PAGADIAN CITY',0,1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,5,'Pagadian City',0,1,'C');
	$pdf->Cell(0,3,'',0,1);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(0,5,"LRMS SUMMARY REPORT",0,1,'C');
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(0,5,"(LIST OF REGISTERED PRINCIPAL'S)",0,1,'C');
	
	
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,0,'',1,1);
	$pdf->Cell(60,5,'',0,0,'l');
	$pdf->Cell(0,5,date("F d, Y"),0,1,'R');
	$pdf->Cell(0,5,'',0,1);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(8,5,'#',1,0,'C');
	$pdf->Cell(62,5,'Name of Teacher In-charge',1,0,'L');
	$pdf->Cell(96,5,'Name of School',1,0,'L');
	$pdf->Cell(30,5,'Contact #',1,1,'L');
	$no=0;
	$result=mysqli_query($con,"SELECT * FROM tbl_school INNER JOIN tbl_employee ON tbl_school.Incharg_ID=tbl_employee.Emp_ID INNER JOIN tbl_user ON tbl_school.Incharg_ID = tbl_user.usercode ORDER BY tbl_employee.Emp_LName Asc");
	while($row=mysqli_fetch_array($result))
	{
		$no++;
	$pdf->Cell(8,5,$no,1,0,'C');
	$pdf->Cell(62,5,$row['Emp_LName'].', '.$row['Emp_FName'],1,0,'L');
	$pdf->Cell(96,5,$row['SchoolName'],1,0,'L');
	$pdf->Cell(30,5,$row['Emp_Cell_No'],1,1,'L');
	}
	$pdf->Cell(0,10,"-------------Nothing follows--------------",1,1,'C');
		
	$pdf->Cell(0,10,"",0,1);
	$pdf->Cell(0,15,"Prepared by:",0,1);
	$pdf->Cell(30,5,"",0,0,'C');
	$pdf->Cell(40,5,$_SESSION['prepared'],0,1,'C');
	
		
	//Display the Output data
	$pdf->Output();
?>
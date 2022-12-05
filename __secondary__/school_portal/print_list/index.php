
<?php
session_start();
include("../../../pcdmis/vendor/jquery/function.php");

	require("../../../pcdmis/fpdf.php"); 
   //Images
	$img1='../../../pcdmis/shs/h1.png';	
	$img2='../../../pcdmis/logo/logo.png';	
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
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'Statement of Account as of '. date("F d, Y"),0,1,'C');
	
	
	
	$pdf->Cell(0,3,'',0,1,'C');
	$pdf->Cell(30,5,'System Generated: ',0,0,'L');
	$pdf->Cell(65,5,date("l").', '. date("F d, Y"),0,1,'L');
		
	//Display the Output data
	$pdf->Output();
?>
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
	
	
	
	
//View Output
$pdf->Output();
?>

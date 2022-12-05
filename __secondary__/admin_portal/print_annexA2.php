
<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
foreach ($_GET as $key => $data)
{
$url=$_GET[$key]=base64_decode(urldecode($data));
	
}
require('../pcdmis/code128.php');


$pdf=new PDF_Code128('L','mm','Letter');


$img1='../pcdmis/shs/h1.png';	
$img2='../pcdmis/logo/logo.png';


//Add New Page
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();
$pdf->Image($img1,175,10,20);
$pdf->Image($img2,80,10,20);



	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'Annex A.2',0,1,'R');
	$pdf->Cell(0,5,'Republic of the Philippines',0,1,'C');
	$pdf->Cell(0,5,'Department of Education',0,1,'C');
	$pdf->Cell(0,5,'Region IX, Zamboanga Peninsula',0,1,'C');
	$pdf->Cell(0,5,'DIVISION OF PAGADIAN CITY',0,1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,5,'Pagadian City',0,1,'C');
	$pdf->Cell(0,3,'',0,1);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(0,5,'SEMI-EXPENDABLE PROPERTY LEDGER CARD',0,1,'C');
	$pdf->Cell(0,1,'',0,1);
	$pdf->SetFont('Arial','',8);
	$myschool=mysqli_query($con,"SELECT * FROM tbl_school WHERE SchoolID='".$_SESSION['current_id']."' LIMIT 1");
	$rowschool=mysqli_fetch_assoc($myschool);
    
	$pdf->Cell(200,10,'Entity Name: '.$rowschool['SchoolName'],0,0);
	$pdf->Cell(60,10,'Fund Cluster: ',0,1);
	
	$pdf->Cell(160,7,'Semi-expendable Property:',1,0);
	$pdf->Cell(100,7,'Semi-expendable Property No.:',1,1);
	$pdf->Cell(160,7,'Description:',1,0);
	$pdf->Cell(50,7,'UACS Object Code:',1,0);
	$pdf->Cell(50,7,'Repair History:',1,1);
	
	
	 $pdf->Cell(20,10,'Date',1,0,'C');
    $pdf->Cell(40,10,'Reference',1,0,'C');
    $pdf->Cell(60,5,'Receipt',1,1,'C');
	$pdf->Cell(10,5,'QTY',1,0,'C');
	$pdf->Cell(25,5,'Unit Cost',1,0,'C');
	$pdf->Cell(25,5,'Total Cost',1,1,'C');
	
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	
		
 
 
	//Display the Output data
	$pdf->Output();
?>
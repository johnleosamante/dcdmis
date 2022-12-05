
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
	$pdf->Cell(0,5,'Annex A.1',0,1,'R');
	$pdf->Cell(0,5,'Republic of the Philippines',0,1,'C');
	$pdf->Cell(0,5,'Department of Education',0,1,'C');
	$pdf->Cell(0,5,'Region IX, Zamboanga Peninsula',0,1,'C');
	$pdf->Cell(0,5,'DIVISION OF PAGADIAN CITY',0,1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,5,'Pagadian City',0,1,'C');
	$pdf->Cell(0,3,'',0,1);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(0,5,'SEMI-EXPENDABLE PROPERTY CARD',0,1,'C');
	$pdf->Cell(0,1,'',0,1);
	$pdf->SetFont('Arial','',8);
	$myschool=mysqli_query($con,"SELECT * FROM tbl_school WHERE SchoolID='".$_SESSION['current_id']."' LIMIT 1");
	$rowschool=mysqli_fetch_assoc($myschool);
    
	//View Record
	
	$annexa1=mysqli_query($con,"SELECT * FROM tbl_sep_annexa1 WHERE SEP_SchoolID ='".$_SESSION['current_id']."' AND CardCode='".$_GET['code']."' LIMIT 1");
	$rowann=mysqli_fetch_assoc($annexa1);
	$pdf->Cell(200,10,'Entity Name: '.$rowschool['SchoolName'],0,0);
	$pdf->Cell(60,10,'Fund Cluster: '.$rowann['Fund_cluster'],0,1);
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->Cell(165,7,'Semi-expendable Property:'.$rowann['SEP'],1,1);
	$pdf->Cell(165,7,'Description: '.$rowann['SEP_Description'],1,1);
	$pdf->SetXY($xPos+165,$yPos);
    $pdf->Multicell(100,14,'Semi-expendable Property Number: '.$rowann['SEPNo'],1);
    $pdf->Cell(20,10,'Date',1,0,'C');
    $pdf->Cell(40,10,'Reference',1,0,'C');
    $pdf->Cell(65,5,'Receipt',1,0,'C');
    $pdf->Cell(70,5,'Issue/Transfer/Disposal',1,0,'C');
    $pdf->Cell(20,5,'Balance',1,0,'C');
    $pdf->Cell(25,10,'Amount',1,0,'C');
    $pdf->Cell(25,10,'Remarks',1,1,'C');
	
	$pdf->SetXY($xPos+60,$yPos+19);
	$pdf->Cell(15,5,'QTY',1,0,'C');
	$pdf->Cell(25,5,'Unit Cost',1,0,'C');
	$pdf->Cell(25,5,'Total Cost',1,0,'C');
	$pdf->Cell(20,5,'Item No',1,0,'C');
	$pdf->Cell(20,5,'QTY',1,0,'C');
	$pdf->Cell(30,5,'Office/Officer',1,0,'C');
	$pdf->Cell(20,5,'QTY',1,1,'C');
   //Get data
   $myrecord=mysqli_query($con,"SELECT * FROM tbl_sep_annexa1_card WHERE SEPCode='".$_GET['code']."'");
   while($rewdata=mysqli_fetch_array($myrecord))
   {
	   $myoffice=mysqli_query($con,"SELECT * FROM tbl_sep_annexa1_card_records  WHERE CardNo='".$rewdata['CardNo']."'AND SEPCode='".$_GET['code']."'");
	   $rowoff=mysqli_fetch_assoc($myoffice);
	   $balance=$rewdata['Received_QTY']-mysqli_num_rows($myoffice);
	   $subtotal=$rewdata['Received_QTY']*$rewdata['Received_unit_cost'];
	    $pdf->Cell(20,5,$rewdata['Date_received'],1,0,'C');  
	    $pdf->Cell(40,5,$rewdata['Reference'],1,0,'C');  
	    $pdf->Cell(15,5,$rewdata['Received_QTY'],1,0,'C');  
	    $pdf->Cell(25,5,number_format($rewdata['Received_unit_cost'],2),1,0,'C');  
	    $pdf->Cell(25,5,number_format($subtotal,2),1,0,'C');  
	    $pdf->Cell(20,5,$rowoff['Trans_Item_no'],1,0,'C');  
	    $pdf->Cell(20,5,$rowoff['Trans_QTY'],1,0,'C');  
	    $pdf->Cell(30,5,$rowoff['Trans_Office'],1,0,'C');  
	    $pdf->Cell(20,5,$balance,1,0,'C');  
	    $pdf->Cell(25,5,number_format($balance * $rewdata['Received_unit_cost'],2),1,0,'C');  
	    $pdf->Cell(25,5,$rewdata['Remarks'],1,1,'C');  
   }
	//Display the Output data
	$pdf->Output();
?>
<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
$result=mysqli_query($con,"SELECT * FROM tbl_employee WHERE Emp_ID='".$_SESSION['EmpID']."'");
$row=mysqli_fetch_assoc($result);

require('../../pcdmis/code128.php');
$pdf=new PDF_Code128('P','mm','Legal');
//set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';
    include "../../pcdmis/qrlib.php";    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    $finame = $PNG_TEMP_DIR.$_SESSION['EmpID'].'.png';
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    $matrixPointSize = 5;
   $_REQUEST['data']=$_SESSION['EmpID'];
    if (isset($_REQUEST['data'])) {        
        // user data
        $finame = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_REQUEST['data'], $finame, $errorCorrectionLevel, $matrixPointSize, 2);    
    } else {    
        QRcode::png('PHP QR Code :)', $finame, $errorCorrectionLevel, $matrixPointSize, 2);    
    }    





	//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
	
	
	$img1='../../pcdmis/shs/h1.png';	
	$img2='../../pcdmis/logo/logo.png';
	$img3=$PNG_WEB_DIR.basename($finame);	
	$img4='../../pcdmis/shs/offices.png';	
 	//New PDF File		 
		$pdf =new FPDF('P','mm','A4');
	
	//Add New Page
		$pdf->AliasNbPages('{pages}');
		$pdf->AddPage();
	
	//Set Font  10	
	$pdf->Image($img1,165,10,20);
	$pdf->Image($img2,30,10,20);
	$pdf->Image($img3,10,250,23);
	$pdf->Image($img4,35,250,120);
	
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'Republic of the Philippines',0,1,'C');
	$pdf->Cell(0,5,'Department of Education',0,1,'C');
	$pdf->Cell(0,5,'Region IX, Zamboanga Peninsula',0,1,'C');
	$pdf->Cell(0,5,'DIVISION OF PAGADIAN CITY',0,1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,5,'Pagadian City',0,1,'C');
	$pdf->Cell(0,5,'',0,1);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(0,5,'GRADE SHEETS',0,1,'C');
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(0,5,'(To be accomplish by Teacher)',0,1,'C');
	$pdf->Cell(0,5,'',0,1);
	$pdf->SetFont('Arial','',9);
	
	
	$pdf->Cell(0,0,'',1,1,'C');
	//Display the Output data
	$pdf->Output();
?>
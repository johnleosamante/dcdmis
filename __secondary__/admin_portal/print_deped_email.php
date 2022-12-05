
<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
require('../pcdmis/code128.php');
date_default_timezone_set("Asia/Manila");

$code="DepedEmail";
$pdf=new PDF_Code128('P','mm','Legal');

//set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';
    include "../pcdmis/qrlib.php";    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    $finame = $PNG_TEMP_DIR.$code.'.png';
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    $matrixPointSize = 5;
   $_REQUEST['data']=$code;
    if (isset($_REQUEST['data'])) {        
        // user data
        $finame = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_REQUEST['data'], $finame, $errorCorrectionLevel, $matrixPointSize, 2);    
    } else {    
        QRcode::png('PHP QR Code :)', $finame, $errorCorrectionLevel, $matrixPointSize, 2);    
    }    

$img1='../pcdmis/shs/h1.png';	
$img2='../pcdmis/logo/logo.png';


//Add New Page
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();
$pdf->Image($img1,165,10,20);
$pdf->Image($img2,30,10,20);


	$pdf->SetFont('Arial','',12);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'Republic of the Philippines',0,1,'C');
	$pdf->Cell(0,5,'Department of Education',0,1,'C');
	$pdf->Cell(0,5,'Region IX, Zamboanga Peninsula',0,1,'C');
	$pdf->Cell(0,5,'DIVISION OF DIPOLOG CITY',0,1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,5,'Dipolog City',0,1,'C');
	$pdf->Cell(0,3,'',0,1);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(0,5,'LIST OF DEPED EMAIL',0,1,'C');
	
	
	$pdf->Cell(0,1,'',0,1);
	$pdf->Cell(0,0,'',1,1);
	$pdf->Cell(0,5,'',0,1);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(10,5,'#',1,0,'C');
	$pdf->Cell(100,5,'Name',1,0);
	$pdf->Cell(90,5,'Deped Email',1,1);
	$no=0;
	$result=mysqli_query($con,"SELECT * FROM tbl_employee ORDER BY Emp_LName Asc");
	while ($row=mysqli_fetch_array($result))
	{
		$no++;
		$pdf->Cell(10,5,$no,1,0,'C');
		$pdf->Cell(100,5,$row['Emp_LName'].', '.$row['Emp_FName'],1,0);
		$pdf->Cell(90,5,$row['Emp_Email'],1,1);
	}
	$pdf->Cell(200,5,'*********************************Nothing Follows********************************',1,1,'C');
	$pdf->Cell(0,5,'',0,1);
	$pdf->Cell(0,5,'System Generated as of '.date("F d, Y").' @ '.date("H:i:s"),0,1);
	
	//Display the Output data
	$pdf->Output();
?>
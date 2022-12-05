
<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
require('../pcdmis/code128.php');


foreach ($_GET as $key => $data)
{
$code=$_GET[$key]=base64_decode(urldecode($data));
	
}
$pdf=new PDF_Code128('L','mm','Legal');

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
//$img3=$PNG_WEB_DIR.basename($finame);
//$img4='../../pcdmis/shs/offices.png';	

//Add New Page
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();
$pdf->Image($img1,165,10,20);
$pdf->Image($img2,30,10,20);
//$pdf->Image($img3,10,240,30);
//$pdf->Image($img4,90,240,120);

	
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'Republic of the Philippines',0,1,'C');
	$pdf->Cell(0,5,'Department of Education',0,1,'C');
	$pdf->Cell(0,5,'Region IX, Zamboanga Peninsula',0,1,'C');
	$pdf->Cell(0,5,'DIVISION OF PAGADIAN CITY',0,1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,5,'Pagadian City',0,1,'C');
	$pdf->Cell(0,3,'',0,1);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(0,5,'LIST OF SCHOOL FOR BATCH '.$code,0,1,'C');
	
	$pdf->Cell(0,1,'',0,1);
	$pdf->Cell(0,0,'',1,1);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,2,'',0,1);
	$pdf->Cell(60,5,'',0,0,'l');
	$pdf->Cell(0,5,date("F d, Y"),0,1,'R');
	$pdf->Cell(0,5,'',0,1);
	
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(10,5,'#',1,0,'C');
	$pdf->Cell(80,5,'School Name',1,0,'C');
	$pdf->Cell(50,5,'Date Delivered',1,0,'C');
	$pdf->Cell(95.5,5,'Package Type',1,0,'C');
	$pdf->Cell(25,5,'D.R',1,0,'C');
	$pdf->Cell(25,5,'I.A.R',1,0,'C');
	$pdf->Cell(25,5,'I.R.P',1,0,'C');
	$pdf->Cell(25,5,'PTR',1,1,'C');
	
	//Record List
	$no=0;
	$result=mysqli_query($con,"SELECT * FROM tbl_batches INNER JOIN tbl_school ON tbl_batches.SchoolID = tbl_school.SchoolID WHERE tbl_batches.BatchNo='".$code."'");
    while($row=mysqli_fetch_array($result))
	{
		$no++;
		$pdf->Cell(10,5,$no,1,0,'C');
		$pdf->Cell(80,5,$row['SchoolName'],1,0,'C');
		$pdf->Cell(50,5,$row['YearDelivered'],1,0,'C');
		$pdf->Cell(95.5,5,$row['PackageType'],1,0,'C');
		$pdf->Cell(25,5,$row['DR_Available'],1,0,'C');
		$pdf->Cell(25,5,$row['IAR_Available'],1,0,'C');
		$pdf->Cell(25,5,$row['IRP_Available'],1,0,'C');
		$pdf->Cell(25,5,$row['PTR_Available'],1,1,'C');
	}		
	$pdf->Cell(0,5,"***************Nothing Follows*****************",1,1,'C');
	$pdf->Cell(0,15,'',0,1);
	$pdf->Cell(0,5,'Prepared by:',0,1);
	$pdf->Cell(20,5,'',0,0);
	$pdf->Cell(0,5,'JOSE MARI M. APILAN',0,1);
	$pdf->Cell(20,5,'',0,0);
	$pdf->Cell(0,5,'Division ITO',0,1);
	//Display the Output data
	$pdf->Output();
?>
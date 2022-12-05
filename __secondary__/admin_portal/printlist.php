
<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
require('../../pcdmis/code128.php');
date_default_timezone_set("Asia/Manila");

$pdf=new PDF_Code128('P','mm','Legal');

//set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';
    include "../../pcdmis/qrlib.php";    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    $finame = $PNG_TEMP_DIR.$_SESSION['SubCode'].'.png';
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    $matrixPointSize = 5;
   $_REQUEST['data']=$_SESSION['SubCode'];
    if (isset($_REQUEST['data'])) {        
        // user data
        $finame = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_REQUEST['data'], $finame, $errorCorrectionLevel, $matrixPointSize, 2);    
    } else {    
        QRcode::png('PHP QR Code :)', $finame, $errorCorrectionLevel, $matrixPointSize, 2);    
    }    

$img1='../../pcdmis/shs/h1.png';	
$img2='../../pcdmis/logo/logo.png';
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
	$pdf->Cell(0,5,$_SESSION['SchoolName'],0,1,'C');
	$pdf->Cell(0,1,'',0,1);
	$pdf->Cell(0,0,'',1,1);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,2,'',0,1);
	$pdf->Cell(60,5,'',0,0,'l');
	$pdf->Cell(0,5,date("F d, Y"),0,1,'R');
	$pdf->Cell(0,5,'',0,1);
	$pdf->Cell(0,5,'List of Examinee',0,1);
	$pdf->Cell(15,5,'Subject:',0,0);
	$pdf->Cell(20,5, $_SESSION['Subject'],0,1);
	$pdf->Cell(0,5,'',0,1);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(10,5,'#',1,0,'C');
	$pdf->Cell(76,5,'Participant Name',1,0);
	$pdf->Cell(25,5,'Grade Level',1,0,'C');
	$pdf->Cell(30,5,'Date Answer',1,0,'C');
	$pdf->Cell(25,5,'Item',1,0,'C');
	$pdf->Cell(25,5,'Score',1,1,'C');
	
	//Record
	$no=0;
	$list=mysqli_query($con,"SELECT * FROM tbl_pisa_participant WHERE SchoolID='".$_SESSION['SchoolID']."'");
	while($row=mysqli_fetch_array($list))
	{
	$no++;
	$myscore=mysqli_query($con,"SELECT * FROM tbl_pisa_monitoring WHERE tbl_pisa_monitoring.SchoolID='".$_SESSION['SchoolID']."' AND tbl_pisa_monitoring.LRN='".$row['LRN']."' AND SubCode='".$_SESSION['SubCode']."' AND date_taken='".date("Y-m-d")."' LIMIT 1");
	$rowscore=mysqli_fetch_assoc($myscore);
	$pdf->Cell(10,5,$no,1,0,'C');
	$pdf->Cell(76,5,$row['ParticipantName'],1,0);
	$pdf->Cell(25,5,$row['Grade_Level'],1,0,'C');
	$pdf->Cell(30,5,$rowscore['date_taken'],1,0,'C');
	$pdf->Cell(25,5,$rowscore['ItemNo'],1,0,'C');
	$pdf->Cell(25,5,$rowscore['Score'],1,1,'C');
	}
	$pdf->Cell(0,5,'*********************************Nothing follows****************************************',0,1,'C');
	$pdf->Cell(0,5,'System Generated as of '.date("F d, Y @ H:i:s"),0,1);
	$pdf->Cell(0,5,'',0,1);
	$pdf->Cell(0,5,'Prepared by:',0,1);
	$pdf->Cell(0,5,'',0,1);
	$pdf->Cell(0,5,'JOEL D. BATERNA',0,1);
	$pdf->Cell(0,5,'Division ITO',0,1);
	//Display the Output data
	$pdf->Output();
?>

<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
require('../../pcdmis/code128.php');
foreach ($_GET as $key => $data)
{
$url=$_GET[$key]=base64_decode(urldecode($data));
	
}

$pdf=new PDF_Code128('L','mm','letter');
$datalink='http://depedpagadian.org/pcdmis/certificate_verifier/index.php?code='.$_GET['certificate'];
//set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';
    include "../../pcdmis/qrlib.php";    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    $finame = $PNG_TEMP_DIR.$datalink.'.png';
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    $matrixPointSize = 5;
	
   $_REQUEST['data']=$datalink;
    if (isset($_REQUEST['data'])) {        
        // user data
        $finame = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_REQUEST['data'], $finame, $errorCorrectionLevel, $matrixPointSize, 2);    
    } else {    
        QRcode::png('PHP QR Code :)', $finame, $errorCorrectionLevel, $matrixPointSize, 2);    
    }    

$data=mysqli_query($con,"SELECT * FROM tbl_speaker_seminar WHERE  tbl_speaker_seminar.SpkCode='".$url."' LIMIT 1");
$rowdata=mysqli_fetch_assoc($data);
$img1=$rowdata['SpkCertificate'];

$img2=$PNG_WEB_DIR.basename($finame);


//Add New Page
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();
$pdf->SetFont('Arial','B',20);
	
$pdf->Image($img1,4,4,260);
$pdf->Image($img2,230,173,25);


	
	
	//Display the Output data
	$pdf->Output();
?>
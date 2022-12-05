
<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
require('../../pcdmis/code128.php');


foreach ($_GET as $key => $data)
{
$code=$_GET[$key]=base64_decode(urldecode($data));
	
}
$pdf=new PDF_Code128('P','mm','Legal');

//set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';
    include "../../pcdmis/qrlib.php";    
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

	$result=mysqli_query($con,"SELECT * FROM tbl_seminar WHERE Training_Code ='".$code."' LIMIT 1");
	$row=mysqli_fetch_assoc($result);
	$img1=$PNG_WEB_DIR.basename($finame);
	$img2=$row['CertifacateofApperance'];

	//Add New Page
	$pdf->AliasNbPages('{pages}');
	$pdf->AddPage();
	$pdf->Image($img2,0,4,210);
	$pdf->Image($img2,0,180,210);
	$pdf->Image($img1,180,145,30);
	$pdf->Image($img1,180,320,30);


	

	
	
	$pdf->SetFont('Arial','B',10);
	
	//Display the Output data
	$pdf->Output();
?>
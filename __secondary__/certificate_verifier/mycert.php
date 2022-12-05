
<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
require('../pcdmis/code128.php');
ini_set('memory_limit', '1024M');
foreach ($_GET as $key => $data)
{
$url=$_GET[$key]=base64_decode(urldecode($data));
	
}

$pdf=new PDF_Code128('L','mm','letter');
$datalink='http://124.73.83.183/pcdmis/certificate_verifier/index.php?code='.$url;
//set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';
    include "qrlib.php";    
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

$img1='../logo/certificate.png';	
$img2=$PNG_WEB_DIR.basename($finame);


//Add New Page
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();
$pdf->SetFont('Arial','B',20);
	
$pdf->Image($img1,4,4,260);
$pdf->Image($img2,230,183,25);
$pdf->Cell(0,100,'',0,1);
$data=mysqli_query($con,"SELECT * FROM tbl_seminar_participant INNER JOIN tbl_employee ON tbl_seminar_participant.Emp_ID = tbl_employee.Emp_ID  WHERE tbl_seminar_participant.Emp_ID='".$url."' LIMIT 1");
$rowdata=mysqli_fetch_assoc($data);
$middleName=mb_strimwidth($rowdata['Emp_MName'],0,1);
$pdf->Cell(0,10,$rowdata['Emp_FName'].' '.$middleName.'. '.$rowdata['Emp_LName'],0,1,'C');
$pdf->SetFont('Arial','i',14);
$pdf->Cell(0,7,'for actively participating and completing the requirements of the pre-implementation component of the',0,1,'C');
$pdf->Cell(0,7,$rowdata['Title_of_training'],0,1,'C');
$pdf->SetFont('Arial','',14);
$pdf->Cell(0,7,'',0,1);
$pdf->Cell(145,10,$rowdata['Training_Rating'],0,1,'R');
$pdf->Cell(0,7,'',0,1);
$pdf->Cell(117,10,date("d"),0,0,'R');
$pdf->Cell(33,10,date("F"),0,1,'R');
	
	$code=$url;
	$pdf->Code128(40,242,$code,50,25);
	
	//Display the Output data
	$pdf->Output();
?>
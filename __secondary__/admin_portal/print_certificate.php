
<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
require('../pcdmis/code128.php');
foreach ($_GET as $key => $data)
{
$url=$_GET[$key]=base64_decode(urldecode($data));
	
}

$pdf=new PDF_Code128('L','mm','A4');
$datalink='../certificate_verifier/index.php?code='.$_GET['certificate'];
//set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';
     include "../pcdmis/qrlib.php";   
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
$retrain=mysqli_query($con,"SELECT * FROM tbl_seminar WHERE Training_Code ='".$_SESSION['TrainingCode']."' LIMIT 1");
$mytrain=mysqli_fetch_assoc($retrain);
$img1="../".$mytrain['Certificate'];	
$img2=$PNG_WEB_DIR.basename($finame);
$img3="../pcdmis/sdssignature/bluesig.png";


//Add New Page
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();
$pdf->SetFont('Arial','B',20);
	
$pdf->Image($img1,4,4,288);


$data=mysqli_query($con,"SELECT * FROM tbl_seminar_participant INNER JOIN tbl_employee ON tbl_seminar_participant.Emp_ID = tbl_employee.Emp_ID WHERE tbl_seminar_participant.Emp_ID='".$url."' LIMIT 1");
$rowdata=mysqli_fetch_assoc($data);
$middleName=mb_strimwidth($rowdata['Emp_MName'],0,1);


if ($mytrain['Category']=='LDM')
{
$pdf->Image($img2,230,183,25);
$pdf->Cell(0,100,'',0,1);
$pdf->Cell(0,10,utf8_decode($rowdata['Emp_FName'].' '.$middleName.'. '.$rowdata['Emp_LName']),0,1,'C');
$pdf->SetFont('Arial','',14);
$pdf->Cell(0,20,'',0,1);
$pdf->Cell(145,10,$rowdata['Training_Rating'],0,1,'R');
$pdf->Cell(0,7,'',0,1);
$pdf->Cell(117,10,date("d"),0,0,'R');
$pdf->Cell(33,10,date("F"),0,1,'R');

}else{

$pdf->Image($img2,10,170,30);
$pdf->SetFont('Arial','BU',25);
$pdf->Cell(0,90,'',0,1);
$pdf->Cell(0,10,utf8_decode($rowdata['Emp_FName'].' '.$middleName.'. '.$rowdata['Emp_LName']),0,1,'C');	
$pdf->Cell(0,5,'',0,1);
$pdf->SetFont('Arial','',14);

//$pdf->Cell(0,6,'for having actively participated and completed the 3 day seminar',0,1,'C');
//$pdf->Write(6,strtoupper($mytrain['Title_of_training']));
//$pdf->Cell(0,5,'',0,1);
//$pdf->Cell(0,6,"Conducted by the INFORMATION AND COMMUNICATION TECHNOLOGY (ICTS) on December 15, 16 & 22, 2021 equipping, capacitating and updating the teacher on approaches and innovations thereby facilitating learning and improving performance by managing appropriate technological processes and recoursces.",0,1,'C');
$pdf->Cell(0,33,'',0,1);
}

//$pdf->Cell(0,26,'',0,1);
//$pdf->SetFont('Arial','B',16);
//$pdf->Cell(0,5,"DR. DANNY B. CORDOVA , CESO VI",0,1,'C');	
//$pdf->SetFont('Arial','',14);
//$pdf->Cell(0,5,"Schools Division Superintendent",0,1,'C');	
//$pdf->Image($img3,128,167,35);	
//Display the Output data
$pdf->Output();
?>
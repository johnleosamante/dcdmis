
<?php
session_start();
include("../vendor/jquery/function.php");
require('../code128.php');

foreach ($_GET as $key => $data)
{
$code=$_GET[$key]=base64_decode(urldecode($data));
	
}

$pdf=new PDF_Code128('P','mm','Legal');

//set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';
    include "qrlib.php";    
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

$img1='../shs/h1.png';	
$img2='../logo/logo.png';
$img3=$PNG_WEB_DIR.basename($finame);
$img4='../shs/offices.png';	

//Add New Page
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();

$rat=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_status LIMIT 1");
$rowstatus=mysqli_fetch_assoc($rat);


$pdf->Image($img1,165,10,20);
$pdf->Image($img2,30,10,20);

	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'Republic of the Philippines',0,1,'C');
	$pdf->Cell(0,5,'Department of Education',0,1,'C');
	$pdf->Cell(0,5,'Region IX, Zamboanga Peninsula',0,1,'C');
	$pdf->Cell(0,5,'DIVISION OF PAGADIAN CITY',0,1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,5,'Pagadian City',0,1,'C');
	$pdf->Cell(0,3,'',0,1);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(0,5,'REGIONAL ACHIEVEMENT TEST (RAT)',0,1,'C');
	$pdf->Cell(0,3,'',0,1);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,strtoupper($_SESSION['SchoolName']),0,1,'C');
	$pdf->Cell(0,5,strtoupper($_SESSION['Address'].' - '.$_SESSION['DName'] ),0,1,'C');
	$pdf->Cell(0,3,'',0,1);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,'ALL LEARNING AREAS',0,1,'C');
	$pdf->Cell(0,3,'',0,1);
	$pdf->Cell(0,0,'',1,1);

//Learner Information
 $myname=mysqli_query($con,"SELECT * FROM tbl_student WHERE lrn='".$code."' LIMIT 1");
 $rowname=mysqli_fetch_assoc($myname);
 $Middle=mb_strimwidth($rowname['MName'],0,1);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(0,5,'',0,1);
	$pdf->Cell(15,10,'NAME: ',0,0);
	$pdf->Cell(70,10,strtoupper($rowname['FName'].' '.$Middle.'. '.$rowname['Lname']),0,0);
	$pdf->Cell(30,10,'GRADE LEVEL: ',0,0);
	$pdf->Cell(25,10,'GRADE '.$_GET['YLevel'],0,1);
	$pdf->Cell(0,3,'',0,1);

$pdf->SetFont('Arial','',11);	
$pdf->Cell(170,10,"LEARNG AREAS",1,0);
$pdf->Cell(30,10,"SCORE/ITEM",1,1,'C');
$TotalScore=$TotalItem=0;
$mysubject=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_subject INNER JOIN tbl_assessment_rat_learner_score ON tbl_assessment_rat_subject.RATSubCode = tbl_assessment_rat_learner_score.SubCode WHERE tbl_assessment_rat_subject.Exam_Status='".$rowstatus['Exam_Status']."' AND tbl_assessment_rat_subject.Grade_Level='".$_GET['YLevel']."' AND tbl_assessment_rat_learner_score.lrn='".$code."' GROUP BY tbl_assessment_rat_learner_score.SubCode");
while ($rowsub=mysqli_fetch_array($mysubject))
{

	//Subject Information
	$pdf->Cell(170,10,$rowsub['Learning_Areas'],1,0);
	$pdf->Cell(30,10,$rowsub['Score']."/".$rowsub['Item'],1,1,'C');
	$TotalScore=$TotalScore+$rowsub['Score'];
	$TotalItem=$TotalItem+$rowsub['Item'];
}
$pdf->Cell(170,10,"TOTAL: ",1,0);
	$pdf->Cell(30,10,$TotalScore."/".$TotalItem,1,1,'C');
//Prapered by
	$pdf->Cell(0,15,'',0,1);
	$pdf->Cell(0,5,'Prepared by:',0,1);
	$pdf->Cell(30,5,"",0,0,'C');
	$pdf->Cell(40,5, $_SESSION['Principal'],0,1,'C');
	$pdf->Cell(30,5,"",0,0,'C');
	if ( $_SESSION['PrinCat']=="TEACHER" ||  $_SESSION['PrinCat']=="Teacher")
	{
	$pdf->Cell(40,5,"Teacher In-charge",0,1,'C');	
	}else{
	$pdf->Cell(40,5,"School Principal",0,1,'C');
	}	
	//Display the Output data
	$pdf->Output();
?>
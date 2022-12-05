
<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
require('../../pcdmis/code128.php');
$MTotalG3=0;$MTotalG6=5;$MTotalG10=0;$MTotalG12=0;
$CAMTotalG3=0;$CAMTotalG6=9;$CAMTotalG10=17;$CAMTotalG12=0;
$MTMTotalG3=0;$MTMTotalG6=12;$MTMTotalG10=12;$MTMTotalG12=25;
$ATotalG3=0;$ATotalG6=11;$ATotalG10=14;$ATotalG12=19;
$LTotalG3=0;$LTotalG6=3;$LTotalG10=10;$LTotalG12=13;
$ANMTotalG3=0;$ANMTotalG6=0;$ANMTotalG10=$ANMTotalG12=4;

$pdf=new PDF_Code128('L','mm','A4');

//set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';
    include "qrlib.php";    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    $finame = $PNG_TEMP_DIR.$_SESSION['CurrentExam'].'.png';
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    $matrixPointSize = 5;
   $_REQUEST['data']=$_SESSION['CurrentExam'];
    if (isset($_REQUEST['data'])) {        
        // user data
        $finame = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_REQUEST['data'], $finame, $errorCorrectionLevel, $matrixPointSize, 2);    
    } else {    
        QRcode::png('PHP QR Code :)', $finame, $errorCorrectionLevel, $matrixPointSize, 2);    
    }    

$img1='../../pcdmis/shs/h1.png';	
$img2='../../pcdmis/logo/logo.png';
$img3=$PNG_WEB_DIR.basename($finame);
$img4='../../pcdmis/shs/offices.png';	

//Add New Page
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();
$pdf->Image($img1,180,10,20);
$pdf->Image($img2,95,10,20);
$pdf->Image($img3,250,170,30);
//$pdf->Image($img4,90,240,120);

	$pdf->SetFont('Arial','',12);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'Republic of the Philippines',0,1,'C');
	$pdf->Cell(0,5,'Department of Education',0,1,'C');
	$pdf->Cell(0,5,'Region IX, Zamboanga Peninsula',0,1,'C');
	$pdf->Cell(0,5,'DIVISION OF PAGADIAN CITY',0,1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,5,'Pagadian City',0,1,'C');
	$pdf->Cell(0,3,'',0,1);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(0,5,$_SESSION['CurrentExam'].' SUMMARY REPORT',0,1,'C');
	
	
	$pdf->Cell(0,1,'',0,1);
	$pdf->Cell(0,0,'',1,1);
	$pdf->Cell(0,2,'',0,1);
	$pdf->SetFont('Arial','B',10);
		
	$pdf->Cell(0,2,'',0,1);
	$pdf->Cell(60,5,'',0,0,'l');
	$pdf->Cell(0,5,date("F d, Y"),0,1,'R');
	$pdf->Cell(0,5,'',0,1);
	
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(70,20,$_SESSION['CurrentExam'],1,0,'C');
	$pdf->Cell(70,10,'SY 2018-2019',1,0,'C');
	$pdf->Cell(70,10,'SY 2019-2020',1,0,'C');
	$pdf->Cell(70,10,'SY 2020-2021',1,1,'C');
	$pdf->Cell(70,10,'',0,0,'C');
	$pdf->Cell(17.5,10,'G3',1,0,'C');
	$pdf->Cell(17.5,10,'G6',1,0,'C');
	$pdf->Cell(17.5,10,'G10',1,0,'C');
	$pdf->Cell(17.5,10,'G12',1,0,'C');
	$pdf->Cell(17.5,10,'G3',1,0,'C');
	$pdf->Cell(17.5,10,'G6',1,0,'C');
	$pdf->Cell(17.5,10,'G10',1,0,'C');
	$pdf->Cell(17.5,10,'G12',1,0,'C');
	$pdf->Cell(17.5,10,'G3',1,0,'C');
	$pdf->Cell(17.5,10,'G6',1,0,'C');
	$pdf->Cell(17.5,10,'G10',1,0,'C');
	$pdf->Cell(17.5,10,'G12',1,1,'C');
	
	$pdf->Cell(70,10,'Mastered (96-100%)',1,0);
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,$MTotalG3,1,0,'C');
	$pdf->Cell(17.5,10,$MTotalG6,1,0,'C');
	$pdf->Cell(17.5,10,$MTotalG10,1,0,'C');
	$pdf->Cell(17.5,10,$MTotalG12,1,1,'C');
	
	$pdf->Cell(70,10,'Closely Approximating Mastery (86-95%)',1,0);
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,$CAMTotalG3,1,0,'C');
	$pdf->Cell(17.5,10,$CAMTotalG6,1,0,'C');
	$pdf->Cell(17.5,10,$CAMTotalG10,1,0,'C');
	$pdf->Cell(17.5,10,$CAMTotalG12,1,1,'C');
	
	$pdf->Cell(70,10,'Moving Towards Mastery (66-85%)',1,0);
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,$MTMTotalG3,1,0,'C');
	$pdf->Cell(17.5,10,$MTMTotalG6,1,0,'C');
	$pdf->Cell(17.5,10,$MTMTotalG10,1,0,'C');
	$pdf->Cell(17.5,10,$MTMTotalG12,1,1,'C');
	
	$pdf->Cell(70,10,'Average (35-65%)',1,0);
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,$ATotalG3,1,0,'C');
	$pdf->Cell(17.5,10,$ATotalG6,1,0,'C');
	$pdf->Cell(17.5,10,$ATotalG10,1,0,'C');
	$pdf->Cell(17.5,10,$ATotalG12,1,1,'C');
	
	$pdf->Cell(70,10,'Low (15-34%)',1,0);
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,$LTotalG3,1,0,'C');
	$pdf->Cell(17.5,10,$LTotalG6,1,0,'C');
	$pdf->Cell(17.5,10,$LTotalG10,1,0,'C');
	$pdf->Cell(17.5,10,$LTotalG12,1,1,'C');
	
		
	$pdf->Cell(70,10,'Absolutely No Mastery (0-14%)',1,0);
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,'N/A',1,0,'C');
	$pdf->Cell(17.5,10,$ANMTotalG3,1,0,'C');
	$pdf->Cell(17.5,10,$ANMTotalG6,1,0,'C');
	$pdf->Cell(17.5,10,$ANMTotalG10,1,0,'C');
	$pdf->Cell(17.5,10,$ANMTotalG12,1,1,'C');
	
	
	//Nothing follows
	$pdf->Cell(0,5,'',0,1);
	$pdf->Cell(0,5,'***************************************Nothing follows*************************************************',0,1,'C');
	$pdf->Cell(0,15,'',0,1);
	$pdf->Cell(0,5,'Prepared by:',0,1);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'',0,1);
	$pdf->Cell(20,5,'',0,0);
	$pdf->Cell(50,5,$_SESSION['user_information'],0,1,'C');
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(20,5,'',0,0);
	$pdf->Cell(50,5,$_SESSION['user_discription'],0,1,'C');
	
	//Barcode
	//$pdf->Cell(0,0,'',1,1);
	//$code=$_SESSION['CurrentExam'];
	//$pdf->Code128(240,170,$code,50,25);
	$pdf->SetFont('Arial','B',10);
	
	//Display the Output data
	$pdf->Output();
?>
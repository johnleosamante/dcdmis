
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
	$pdf->Cell(0,5,$_SESSION['CurrentExam'].' MPS SUMMARY REPORT',0,1,'C');
	
	
	$pdf->Cell(0,1,'',0,1);
	$pdf->Cell(0,0,'',1,1);
	$pdf->Cell(0,2,'',0,1);
	$pdf->SetFont('Arial','B',10);
		
	$pdf->Cell(0,2,'',0,1);
	$pdf->Cell(60,5,'',0,0,'l');
	$pdf->Cell(0,5,date("F d, Y"),0,1,'R');
	$pdf->Cell(0,5,'',0,1);
	
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(10,10,"#",1,0,'C');
	$pdf->Cell(40,10,'GRADE LEVEL',1,0,'C');
	$pdf->Cell(40,10,'# OF LEARNER',1,0,'C');
	$pdf->Cell(40,10,'# OF ITEMS',1,0,'C');
	$pdf->Cell(40,10,'TOTAL SCORES',1,0,'C');
	$pdf->Cell(40,10,'MEAN SCORES',1,0,'C');
	$pdf->Cell(40,10,'MPS',1,1,'C');
	$no=$TotalScore=$meanscore=$mps=0;
	$gradelevel=mysqli_query($con,"SELECT * FROM tbl_assessment_grade_level_recipient WHERE Exam_type='".$_SESSION['assessment']."' AND School_Year='".$_SESSION['year']."'");
	while ($rowGL=mysqli_fetch_array($gradelevel))
	{
		$no++;
		$learner=mysqli_query($con,"SELECT * FROM tbl_assessment_rat WHERE YLevel='".$rowGL['Grade_Level']."' AND Exam_Code='".$_SESSION['assessment']."' AND School_Year='".$_SESSION['year']."'");
		$noofitems=0;
		$SubItem=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_subject WHERE Exam_Code='".$_SESSION['assessment']."' AND Grade_Level='".$rowGL['Grade_Level']."' AND Exam_Status='".$_SESSION['rat_status']."'");
		while($rowitem=mysqli_fetch_array($SubItem))
		{
			$noofitems=$noofitems+$rowitem['No_of_Items'];
		}
		$pdf->Cell(10,10,$no,1,0,'C');
		$pdf->Cell(40,10,'GRADE '.$rowGL['Grade_Level'],1,0,'C');
		$pdf->Cell(40,10,mysqli_num_rows($learner),1,0,'C');
		$pdf->Cell(40,10,$noofitems,1,0,'C');
		$pdf->Cell(40,10,$TotalScore,1,0,'C');
		$pdf->Cell(40,10,$meanscore,1,0,'C');
		$pdf->Cell(40,10,$mps,1,1,'C');
	}
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
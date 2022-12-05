
<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
require('../../pcdmis/code128.php');


foreach ($_GET as $key => $data)
{
$code=$_GET[$key]=base64_decode(urldecode($data));
	
}
$pdf=new PDF_Code128('P','mm','Letter');

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

$img1='../../pcdmis/shs/h1.png';	
$img2='../../pcdmis/logo/logo.png';
$img3=$PNG_WEB_DIR.basename($finame);
$img4='../../pcdmis/shs/offices.png';	

//Add New Page
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();
$pdf->Image($img1,165,10,20);
$pdf->Image($img2,30,10,20);
$pdf->Image($img3,10,240,30);
$pdf->Image($img4,90,240,120);

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
	$pdf->Cell(0,5,'DOCUMENT TRACKING SYSTEM',0,1,'C');
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(0,5,'(Attachment)',0,1,'C');
	
	$pdf->Cell(0,1,'',0,1);
	$pdf->Cell(0,0,'',1,1);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,2,'',0,1);
	$pdf->Cell(0,5,strtoupper($_SESSION['SchoolName']),0,1,'C');
	$pdf->Cell(0,5,strtoupper($_SESSION['Address']),0,1,'C');
	$pdf->Cell(0,5,strtoupper($_SESSION['DName']),0,1,'C');
	$pdf->Cell(0,2,'',0,1);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(15,5,'Ctrl #:',0,0);
	$pdf->Cell(30,5,$_GET['Code'],0,1);
	
	$pdf->Cell(0,2,'',0,1);
	$pdf->Cell(60,5,'',0,0,'l');
	$pdf->Cell(0,5,date("F d, Y"),0,1,'R');
	$pdf->Cell(0,5,'',0,1);
	$pdf->SetFont('Arial','',10);
	
	
	$datereg=mysqli_query($con,"SELECT * FROM tbl_transactions WHERE tbl_transactions.TransCode='".$code."' LIMIT 1");
	$row=mysqli_fetch_assoc($datereg);
	$pdf->Cell(0,1,'',0,1);
	$pdf->Cell(0,5,'',0,1);
	
	$pdf->Write(5,$row['Title']);
	$pdf->Cell(0,1,'',0,1);
	$pdf->Cell(0,10,'',0,1);
	
	$pdf->Cell(0,10,'EVALUATION FORM:',0,1);
	$pdf->Cell(0,5,'_______________________       ___________________________        ____________________     ___________________',0,1);
	$pdf->Cell(0,5,'_______________________       ___________________________        ____________________     ___________________',0,1);
	$pdf->Cell(0,5,'_______________________       ___________________________        ____________________     ___________________',0,1);
	$pdf->Cell(0,5,'_______________________       ___________________________        ____________________     ___________________',0,1);
	$pdf->Cell(0,5,'_______________________       ___________________________        ____________________     ___________________',0,1);
	$pdf->Cell(0,5,'_______________________       ___________________________        ____________________     ___________________',0,1);
	$pdf->Cell(0,5,'_______________________       ___________________________        ____________________     ___________________',0,1);
	
	
	//Prapered by
	$pdf->Cell(0,5,'',0,1);
	$pdf->Cell(0,5,'Prepared by:',0,1);
	$pdf->Cell(30,5,"",0,0,'C');
	$pdf->Cell(40,5, $_SESSION['Principal'],0,1,'C');
	$pdf->Cell(30,5,"",0,0,'C');
	if ( $_SESSION['PrinCat']=="TEACHER" ||  $_SESSION['PrinCat']=="Teacher")
	{
	$pdf->Cell(40,5,"Teacher In-charge",0,1,'C');	
	}else{
	$pdf->Cell(40,5,$_SESSION['Job'],0,1,'C');
	}
	//Section Visited
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,5,'',0,1);
	$pdf->Cell(0,0,'',1,1);
	$pdf->Cell(0,5,'TRANSACTION FLOW',0,1);
	$pdf->Cell(20,5,'Sequence No.',1,0,'C');
	$pdf->Cell(40,5,'Destination Section',1,1,'C');
		
	$destination=mysqli_query($con,"SELECT * FROM tbl_transaction_flow WHERE tbl_transaction_flow.SchoolID ='".$_SESSION['school_id']."' AND TransactionCode='".$code."' ORDER BY tbl_transaction_flow.SequenceNo Asc");
		while($row=mysqli_fetch_array($destination))
			{
				$pdf->Cell(20,5,$row['SequenceNo'],1,0,'C');
				$pdf->Cell(40,5,$row['Destination_section'],1,1,'C');
					
			}
	
	
	$code=$_GET['Code'];
	$pdf->Code128(40,242,$code,50,25);
	
	//Display the Output data
	$pdf->Output();
?>
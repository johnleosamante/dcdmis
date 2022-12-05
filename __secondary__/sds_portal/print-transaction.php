
<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
require('../pcdmis/code128.php');


foreach ($_GET as $key => $data)
{
$code=$_GET[$key]=base64_decode(urldecode($data));
	
}
$pdf=new PDF_Code128('P','mm','Letter');

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
$img3=$PNG_WEB_DIR.basename($finame);
$img4='../pcdmis/shs/offices.png';	

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
	$pdf->Cell(0,5,'DIVISION OF DIPOLOG CITY',0,1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,5,'Dipolog City',0,1,'C');
	$pdf->Cell(0,3,'',0,1);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(0,5,'DOCUMENT TRACKING SYSTEM',0,1,'C');
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(0,5,'(Attachment)',0,1,'C');
	
	$pdf->Cell(0,1,'',0,1);
	$pdf->Cell(0,0,'',1,1);
	$pdf->Cell(0,2,'',0,1);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(15,5,'Ctrl #:',0,0);
	$pdf->Cell(30,5,$_GET['Code'],0,1);
	

	$pdf->Cell(0,2,'',0,1);
	$pdf->Cell(60,5,'Action Slip',0,0,'l');
	$pdf->Cell(0,5,date("F d, Y"),0,1,'R');
	$pdf->Cell(0,5,'',0,1);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'To:_______________',0,1);
	$pdf->Cell(0,2,'',0,1);
	$pdf->Cell(148,5,'For:',0,0);
	$pdf->Cell(50,5,"Transaction Flow",1,1,'C');
	$pdf->Cell(4,4,'',1,0);
	$pdf->Cell(70,5,'Appropriate Action',0,0);
	$pdf->Cell(4,4,'',1,0);
	$pdf->Cell(70,5,'Comments and recommendations',0,0);
	$dentinyone=mysqli_query($con,"SELECT * FROM tbl_transaction_flow WHERE tbl_transaction_flow.SchoolID ='123131' AND tbl_transaction_flow.TransactionCode='".$code."' AND tbl_transaction_flow.SequenceNo='1' ORDER BY tbl_transaction_flow.SequenceNo Asc ");
	$rowdenone=mysqli_fetch_assoc($dentinyone);
	$pdf->Cell(10,5,'1',1,0,'C');
	$pdf->Cell(40,5,$rowdenone['Destination_section'],1,1);
	
	$pdf->Cell(4,4,'',1,0);
	$pdf->Cell(70,5,'Filing',0,0);
	$pdf->Cell(4,4,'',1,0);
	$pdf->Cell(70,5,'Endorsement',0,0);
	
	$dentinytwo=mysqli_query($con,"SELECT * FROM tbl_transaction_flow WHERE tbl_transaction_flow.SchoolID ='123131' AND tbl_transaction_flow.TransactionCode='".$code."' AND tbl_transaction_flow.SequenceNo='2' ORDER BY tbl_transaction_flow.SequenceNo Asc ");
	$rowdentwo=mysqli_fetch_assoc($dentinytwo);
	$pdf->Cell(10,5,'2',1,0,'C');
	$pdf->Cell(40,5,$rowdentwo['Destination_section'],1,1);
	
	$pdf->Cell(4,4,'',1,0);
	$pdf->Cell(70,5,'Investigation',0,0);
	$pdf->Cell(4,4,'',1,0);
	$pdf->Cell(70,5,'Notation/Attestation',0,0);
	
	$dentinythree=mysqli_query($con,"SELECT * FROM tbl_transaction_flow WHERE tbl_transaction_flow.SchoolID ='123131' AND tbl_transaction_flow.TransactionCode='".$code."' AND tbl_transaction_flow.SequenceNo='3' ORDER BY tbl_transaction_flow.SequenceNo Asc ");
	$rowdenthree=mysqli_fetch_assoc($dentinythree);
	$pdf->Cell(10,5,'3',1,0,'C');
	$pdf->Cell(40,5,$rowdenthree['Destination_section'],1,1);
	
	$pdf->Cell(4,4,'',1,0);
	$pdf->Cell(70,5,'Reply/Response',0,0);
	$pdf->Cell(4,4,'',1,0);
	$pdf->Cell(70,5,'Reproduction/Dissemination',0,0);
	
	$dentiny4=mysqli_query($con,"SELECT * FROM tbl_transaction_flow WHERE tbl_transaction_flow.SchoolID ='123131' AND tbl_transaction_flow.TransactionCode='".$code."' AND tbl_transaction_flow.SequenceNo='4' ORDER BY tbl_transaction_flow.SequenceNo Asc ");
	$rowden4=mysqli_fetch_assoc($dentiny4);
	
	$pdf->Cell(10,5,'4',1,0,'C');
	$pdf->Cell(40,5,$rowden4['Destination_section'],1,1);
	
	$pdf->Cell(4,4,'',1,0);
	$pdf->Cell(70,5,'Others_________________________',0,0);
	$pdf->Cell(4,4,'',1,0);
	$pdf->Cell(70,5,'Signature/Approval',0,0);
	
	$dentiny5=mysqli_query($con,"SELECT * FROM tbl_transaction_flow WHERE tbl_transaction_flow.SchoolID ='123131' AND tbl_transaction_flow.TransactionCode='".$code."' AND tbl_transaction_flow.SequenceNo='5' ORDER BY tbl_transaction_flow.SequenceNo Asc ");
	$rowden5=mysqli_fetch_assoc($dentiny5);
	
	$pdf->Cell(10,5,'5',1,0,'C');
	$pdf->Cell(40,5,$rowden5['Destination_section'],1,1);
	
	
	$pdf->Cell(4,4,'',1,0);
	$pdf->Cell(144,5,'Remarks________________________',0,0);
	
	$dentiny6=mysqli_query($con,"SELECT * FROM tbl_transaction_flow WHERE tbl_transaction_flow.SchoolID ='123131' AND tbl_transaction_flow.TransactionCode='".$code."' AND tbl_transaction_flow.SequenceNo='6' ORDER BY tbl_transaction_flow.SequenceNo Asc ");
	$rowden6=mysqli_fetch_assoc($dentiny6);
	
	$pdf->Cell(10,5,'6',1,0,'C');
	$pdf->Cell(40,5,$rowden6['Destination_section'],1,1);
	$pdf->Cell(0,25,'',0,1);
	$pdf->Cell(0,7,'',0,1);	
	$pdf->Cell(0,5,'DANNY B. CORDOVA, Ed.D, CESO VI',0,1,'C');
	$pdf->SetFont('Arial','i',8);
	$pdf->Cell(0,5,'Schools Division Superintendent',0,1,'C');
	
	$pdf->SetFont('Arial','',12);
	$datereg=mysqli_query($con,"SELECT * FROM tbl_transactions WHERE tbl_transactions.TransCode='".$code."' LIMIT 1");
	$row=mysqli_fetch_assoc($datereg);
	$pdf->Cell(0,1,'',0,1);
	$pdf->Cell(0,5,'------------------------------------------------------------------------------------------------------------------------------------',0,1);
	//$pdf->Cell(0,5,$row['Title'],0,1,'C');
	$pdf->Write(5,$row['Title']);
	$pdf->Cell(0,1,'',0,1);
	$pdf->Cell(0,10,'------------------------------------------------------------------------------------------------------------------------------------',0,1);
	
	//Barcode
	//$pdf->Cell(0,0,'',1,1);
	//$code=$code;
	$pdf->Code128(40,242,$code,50,25);
	$pdf->SetFont('Arial','B',10);
	
	//Display the Output data
	$pdf->Output();
?>
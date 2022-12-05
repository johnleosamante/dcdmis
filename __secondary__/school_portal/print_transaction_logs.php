
<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
require('../../pcdmis/code128.php');



$pdf=new PDF_Code128('P','mm','Letter');

//set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';
    include "../../pcdmis/qrlib.php";    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    $finame = $PNG_TEMP_DIR.$_SESSION['TransCode'].'.png';
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    $matrixPointSize = 5;
   $_REQUEST['data']=$_SESSION['TransCode'];
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
	$pdf->Cell(0,5,'(Transaction Logs)',0,1,'C');
	
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
	$pdf->Cell(30,5,$_SESSION['TransCode'],0,1);
	
	$pdf->Cell(0,2,'',0,1);
	$pdf->Cell(60,5,'',0,0,'l');
	$pdf->Cell(0,5,date("F d, Y"),0,1,'R');
	$pdf->Cell(0,5,'',0,1);
	$pdf->SetFont('Arial','',10);
	
	
	$datereg=mysqli_query($con,"SELECT * FROM tbl_transactions WHERE tbl_transactions.TransCode='".$_SESSION['TransCode']."' LIMIT 1");
	$row=mysqli_fetch_assoc($datereg);
	$pdf->Cell(0,1,'',0,1);
	$pdf->Cell(0,5,'',0,1);
	
	$pdf->Write(5,$row['Title']);
	$pdf->Cell(0,1,'',0,1);
	$pdf->Cell(0,5,'',0,1);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(0,10,'TRANSACTION LOGS:',0,1);
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->Cell(10,10,'#',1,0,'C');
	$pdf->Cell(40,10,'Date and Time Recieved',1,0,'C');
	$pdf->Cell(50,10,'Recieved by',1,0);
	$pdf->Cell(60,5,'Offices',1,1,'C');
	$pdf->Cell(100,5,'',0,0,'C');
	$pdf->Cell(30,5,'From',1,0,'C');
	$pdf->Cell(30,5,'To',1,1,'C');
	$pdf->SetXY($xPos+160,$yPos);
	$pdf->Multicell(40,10,'Status',1);
	
	
	$no=0;
	$data=mysqli_query($con,"SELECT * FROM tbl_transactions_log INNER JOIN tbl_employee ON tbl_transactions_log.Recieved_by = tbl_employee.Emp_ID WHERE tbl_transactions_log.Transaction_code='".$_SESSION['TransCode']."' ORDER BY tbl_transactions_log.Date_recieved Desc");
	while($row=mysqli_fetch_array($data))
	 {
		$no++;
	   $pdf->Cell(10,5,$no,1,0,'C');
	   $pdf->Cell(40,5,$row['Date_recieved'],1,0,'C');
	   $pdf->Cell(50,5,$row['Emp_LName'].', '.$row['Emp_FName'],1,0);
	   $pdf->Cell(30,5,$row['From_office'],1,0,'C');
	   $pdf->Cell(30,5,$row['Forwarded_to'],1,0,'C');
	   $pdf->Cell(40,5,$row['Trans_status'],1,1);
	 }
	
	
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
	
	
	$code=$_SESSION['TransCode'];
	$pdf->Code128(40,242,$code,50,25);
	
	//Display the Output data
	$pdf->Output();
?>
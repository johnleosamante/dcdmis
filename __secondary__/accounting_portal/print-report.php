
<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
require('../pcdmis/code128.php');

$pdf=new PDF_Code128('P','mm','Letter');

//set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';
      include "../pcdmis/qrlib.php";      
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    $finame = $PNG_TEMP_DIR.$_GET['id'].'.png';
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    $matrixPointSize = 5;
   $_REQUEST['data']=$_GET['id'];
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
	$pdf->Cell(0,5,'TRANSACTION SUMMARY REPORT',0,1,'C');
	
	
	$pdf->Cell(0,1,'',0,1);
	$pdf->Cell(0,0,'',1,1);
	$pdf->Cell(0,2,'',0,1);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(15,5,'Ctrl #:',0,0);
	$pdf->Cell(30,5,$_GET['id'],0,1);
	
	$pdf->Cell(0,2,'',0,1);
	$pdf->Cell(60,5,'',0,0,'l');
	$pdf->Cell(0,5,date("F d, Y"),0,1,'R');
	$pdf->Cell(0,5,'',0,1);
	
	
	$pdf->Cell(0,5,'TRANSACTION DETAILS',0,1);
	$pdf->Cell(0,3,'',0,1);
	$pdf->SetFont('Arial','',10);
	$datereg=mysqli_query($con,"SELECT * FROM tbl_transactions WHERE tbl_transactions.TransCode='".$_GET['id']."' LIMIT 1");
	$row=mysqli_fetch_assoc($datereg);
	
	$pdf->Cell(40,5,'Date/Time Created:',0,0);
	$pdf->Cell(50,5,$row['Date_time'],0,0);
	$pdf->Cell(25,5,'From:',0,0,'R');
	$pdf->Cell(40,5,$row['Trans_from'].' SECTION',0,1);
	$pdf->Cell(0,3,'',0,1);
	$pdf->Cell(0,1,'',0,1);
	$pdf->Write(5,$row['Title']);
	$pdf->Cell(0,1,'',0,1);
	$pdf->Cell(0,10,'',0,1);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,5,'TRANSACTION LOGS',0,1);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(10,10,'#',1,0,'C');
	$pdf->Cell(40,10,'Date/Time Created',1,0,'C');
	$pdf->Cell(50,10,'Received by',1,0,'C');
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->Multicell(50,5,"Offices",1,'C');
	$pdf->Cell(100,10,"",0,0);
	$pdf->Cell(25,5,"From",1,0,'C');	
	$pdf->Cell(25,5,"To",1,1,'C');
	$pdf->SetXY($xPos+50,$yPos);
	$pdf->Multicell(46,10,'Remark',1,'C');
	
	
	//generate data from the logs
	$pdf->SetFont('Arial','',8);
	$no=0;
	$data=mysqli_query($con,"SELECT * FROM tbl_transactions_log INNER JOIN tbl_employee ON tbl_transactions_log.Recieved_by = tbl_employee.Emp_ID WHERE tbl_transactions_log.Transaction_code='".$_SESSION['Transcode']."'");
	 while($row=mysqli_fetch_array($data))
	{
		$no++;
		$pdf->Cell(10,5,$no,1,0,'C');
		$pdf->Cell(40,5,$row['Date_recieved'],1,0,'C');
		$pdf->Cell(50,5,$row['Emp_LName'].', '.$row['Emp_FName'],1,0);
		$pdf->Cell(25,5,$row['From_office'],1,0);
		$pdf->Cell(25,5,$row['Forwarded_to'],1,0);
		$pdf->Cell(46,5,$row['Trans_status'],1,1);
	}
	//Nothing follows
	$pdf->Cell(0,5,'***************************************Nothing follows*************************************************',1,1,'C');
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
	$code=$_GET['id'];
	$pdf->Code128(40,242,$code,50,25);
	$pdf->SetFont('Arial','B',10);
	
	//Display the Output data
	$pdf->Output();
?>
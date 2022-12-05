
<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
require('../pcdmis/code128.php');


foreach ($_GET as $key => $data)
{
$code=$_GET[$key]=base64_decode(urldecode($data));
	
}

$pdf=new PDF_Code128('P','mm','A4');

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

	
//Get data from database
$result=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID WHERE tbl_employee.Emp_ID='".$code."' LIMIT 1");
$row=mysqli_fetch_assoc($result);
$MiddleName=mb_strimwidth($row['Emp_MName'],0,1);
//Display images
$img1='../pcdmis/IDTemplate/2021/Official ID for template.jpg';	
$img3=$PNG_WEB_DIR.basename($finame);
$img6=$PNG_WEB_DIR.basename($finame);

$img5='../pcdmis/IDTemplate/2021/Official ID for template.jpg';	
if ($row['Picture']<>NULL)
	 {
		 $img2='../pcdmis/images/'.$row['Picture'];
		 $img4='../pcdmis/images/'.$row['Picture'];
        
	 }else{
		  $img2='../pcdmis/logo/user.png';
		  $img4='../pcdmis/logo/user.png';
		 
	 }


//Add New Page
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();
$pdf->Image($img1,4,10,100);
$pdf->Image($img5,105,10,100);
$pdf->Image($img2,63,100,40);
$pdf->Image($img3,5,112,40);
$pdf->Image($img6,110,112,40);
$pdf->Image($img4,165,100,40);

//Font size
$pdf->SetFont('Arial','B',24);	
						
$pdf->Cell(0,42,"",0,1);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(-4,10,"",0,0);
$pdf->Cell(103,10,$row['Emp_LName'].',',0,0);
$pdf->Cell(100,10,$row['Emp_LName'].',',0,1);
$pdf->SetFont('Arial','B',14);		
$pdf->Cell(-4,10,"",0,0);
$pdf->Cell(103,7,$row['Emp_FName'].' '.$MiddleName.'. ',0,0);
$pdf->Cell(100,7,$row['Emp_FName'].' '.$MiddleName.'. ',0,1);
$pdf->SetFont('Arial','B',10);		
$pdf->Cell(0,3,"",0,1);	
$pdf->Cell(-4,10,"",0,0);
$pdf->Cell(103,5,"DISTRICT 4",0,0);	
$pdf->Cell(100,5,"DISTRICT 4",0,1);	
$pdf->SetFont('Arial','B',15);	
$pdf->Cell(-4,7,"",0,0);
$xPos=$pdf->GetX();
$yPos=$pdf->GetY();
//$pdf->Multicell(90,5,strtoupper($row['SchoolName']),0);	
$pdf->Cell(103,5,strtoupper($row['SchoolName']),0,0);	
$pdf->Cell(100,7,strtoupper($row['SchoolName']),0,1);
$pdf->Cell(0,3,"",0,1);		
$pdf->Cell(35,7,"",0,0);
$pdf->Cell(103,7,$row['Emp_ID'],0,0);	
$pdf->Cell(55,7,$row['Emp_ID'],0,1);	

$pdf->Cell(0,5,"",0,1);	
//$pdf->TextWithDirection(110,50,'world!','L');




	//Display the Output data
	$pdf->Output();
?>
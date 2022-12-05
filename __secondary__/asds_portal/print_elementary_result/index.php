
<?php
session_start();
include("../../../pcdmis/vendor/jquery/function.php");
foreach ($_GET as $key => $data)
{
$url=$_GET[$key]=base64_decode(urldecode($data));
	
}
require('../../../pcdmis/code128.php');


$pdf=new PDF_Code128('P','mm','Letter');

//set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';
    include "../../../pcdmis/qrlib.php";    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    $finame = $PNG_TEMP_DIR.$_SESSION['ApplicanNo'].'.png';
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    $matrixPointSize = 5;
   $_REQUEST['data']=$_SESSION['ApplicanNo'];
    if (isset($_REQUEST['data'])) {        
        // user data
        $finame = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_REQUEST['data'], $finame, $errorCorrectionLevel, $matrixPointSize, 2);    
    } else {    
        QRcode::png('PHP QR Code :)', $finame, $errorCorrectionLevel, $matrixPointSize, 2);    
    }    

$img1='../../../pcdmis/shs/h1.png';	
$img2='../../../pcdmis/logo/logo.png';
$img3=$PNG_WEB_DIR.basename($finame);
$img4='../../../pcdmis/shs/offices.png';	

//Add New Page
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();
$pdf->Image($img2,150,10,20);
$pdf->Image($img1,50,10,20);
//$pdf->Image($img3,10,240,30);
//$pdf->Image($img4,90,240,120);

    $grandtotal=0;
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
	$pdf->Cell(0,5,date("Y").' REGISTRY OF TEACHER 1 APPLICANT - '.$_SESSION['ApplicantCat'],0,1,'C');
	$pdf->SetFont('Arial','i',6);
	$pdf->Cell(0,5,'(per DepEd Order No. 7, s. 2015)',0,1,'C');
	
	$pdf->Cell(0,1,'',0,1);
	$pdf->Cell(0,0,'',1,1);
	$pdf->Cell(0,2,'',0,1);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,date("F d, Y"),0,1,'R');
	$pdf->Cell(0,5,'',0,1);
	$result=mysqli_query($con,"SELECT * FROM tbl_applicant WHERE Appl_No='".$_SESSION['ApplicanNo']."'");
	$row=mysqli_fetch_assoc($result);
	$MName=mb_strimwidth($row['Middle_Name'],0,1);
	$pdf->Cell(20,5,"NAME: ",0,0);
	$pdf->Cell(50,5,$row['First_Name'].' '.$MName.'. '.$row['Last_Name'],0,1);
	$pdf->Cell(20,5,"MAJOR: ",0,0);
	$pdf->Cell(20,5,$row['Major'],0,1);
	$pdf->Cell(0,5,'',0,1);
	$myscore=mysqli_query($con,"SELECT * FROM tbl_applicant_rating WHERE ApplicanNo='".$_SESSION['ApplicanNo']."'");
	$rowscore=mysqli_fetch_assoc($myscore);
	
	//Education information
	$pdf->Cell(60,5,"EDUCATION (20 Points) ",0,0,'C');
	$pdf->Cell(80,5,"TEACHING EXPERIENCE (15 Points) ",0,0,'C');
	$pdf->Cell(60,5,"LET/PBET (15 Points) ",0,1,'C');
	$pdf->Cell(0,5,'',0,1);
	
	//Education information
	$pdf->Cell(30,5,"GWA Rating: ",0,0);
	$pdf->Cell(25,5,$rowscore['One'],1,0,'R');
	
	//Teaching data
	$pdf->Cell(20,5,"",0,0);
	$pdf->Cell(30,5,"Gen T E.(12): ",0,0);
	$pdf->Cell(25,5,$rowscore['Five'],1,0,'R');
	
	//LET Data
	$pdf->Cell(15,5,"",0,0);
	$pdf->Cell(25,5,"Rating: ",0,0);
	$pdf->Cell(25,5,$rowscore['Eight'],1,1,'R');
	
	//Education information
	$pdf->Cell(0,2,'',0,1);
	$pdf->Cell(30,5,"Equivalent(18): ",0,0);
	$pdf->Cell(25,5,$rowscore['EdEquiv'],1,0,'R');
	
	//Teaching data
	$pdf->Cell(20,5,"",0,0);
	$pdf->Cell(30,5,"KVT/ LGU(3): ",0,0);
	$pdf->Cell(25,5,$rowscore['Six'],1,0,'R');

    //LET Data
	$pdf->Cell(15,5,"",0,0);
	$pdf->Cell(25,5,"Equivalent(15): ",0,0);
	$pdf->Cell(25,5,$rowscore['RateEquive'],1,1,'R');

   //Education information
	$pdf->Cell(0,2,'',0,1);
	$pdf->Cell(30,5,"MA/PhD(2): ",0,0);
	$pdf->Cell(25,5,$rowscore['Three'],1,0,'R');
	
	//Teaching data
	//$pdf->Cell(20,5,"",0,0);
	//$pdf->Cell(30,5,"Gen T E.(12): ",0,0);
	//$pdf->Cell(25,5,$rowscore['Five'],1,1,'R');
	
	//Teaching data
	$pdf->Cell(20,5,"",0,0);
	$pdf->Cell(30,5,"Sub Total(15): ",0,0);
	$pdf->Cell(25,5,$rowscore['TeachSubTotal'],1,1,'R');
	
	//Education information
	$pdf->Cell(0,2,'',0,1);
	$pdf->Cell(30,5,"Sub Total(20): ",0,0);
	$pdf->Cell(25,5,$rowscore['EdSubTotal'],1,0,'R');
	
	$pdf->Cell(0,10,'',0,1);
	
	//Specialized information
	$pdf->Cell(70,5,"SPECIALIZED T & S (10 Points) ",0,0,'C');
	$pdf->Cell(80,5,"ENGLISH COMMUNICATION SKILLS (15) ",0,1,'C');
	
	$pdf->Cell(0,5,'',0,1);
	
	//Specialized data
	$pdf->Cell(35,5,"Certificate(5) ",0,0);
	$pdf->Cell(25,5,$rowscore['Ten'],1,0,'R');
	
	//English Information
	$pdf->Cell(20,5,"",0,0);
	$pdf->Cell(30,5,"Rating ",0,0);
	$pdf->Cell(25,5,$rowscore['Fifteen'],1,1,'R');
	$pdf->Cell(0,2,'',0,1);
	
	//Specialized data
	$pdf->Cell(35,5,"Demo (5)",0,0);
	$pdf->Cell(25,5,$rowscore['Eleven'],1,0,'R');
	
	//English Information
	$pdf->Cell(20,5,"",0,0);
	$pdf->Cell(30,5,"Equivalent (15) ",0,0);
	$pdf->Cell(25,5,$rowscore['EngEval'],1,1,'R');
	$pdf->Cell(0,2,'',0,1);
	
	//Specialized data
	$pdf->Cell(35,5,"Sub Total (10)",0,0);
	$pdf->Cell(25,5,$rowscore['SpecialSubTotal'],1,1,'R');
	$pdf->Cell(0,2,'',0,1);	
	
	//Specialized data
	$pdf->Cell(35,5,"Interview (10)",0,0);
	$pdf->Cell(25,5,$rowscore['Thirteen'],1,1,'R');
	$pdf->Cell(0,2,'',0,1);	
	
	//Specialized data
	$pdf->Cell(35,5,"Demo Teachng (15)",0,0);
	$pdf->Cell(25,5,$rowscore['Fourteen'],1,1,'R');
	$pdf->Cell(0,2,'',0,1);	
	
	//Specialized data
	$pdf->Cell(35,5,"Mother Tongue (5)",0,0);
	$pdf->Cell(25,5,$rowscore['MotherTongue'],1,1,'R');
	$pdf->Cell(0,2,'',0,1);	
	$subtotal=$rowscore['Fourteen']+$rowscore['MotherTongue'];
	//Specialized data
	$pdf->Cell(35,5,"Sub Total:",0,0);
	$pdf->Cell(25,5,$subtotal,1,1,'R');
	$pdf->Cell(0,5,'',0,1);	
	$pdf->Cell(0,0,'',1,1);	
	$pdf->Cell(0,5,'',0,1);	
	 $grandtotal= $rowscore['EdSubTotal'] + $rowscore['TeachSubTotal'] + $rowscore['RateEquive'] + $rowscore['SpecialSubTotal'] + $rowscore['EngEval']+ $rowscore['Thirteen']+$subtotal;
						  
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(150,5,"Grand Total:",0,0);
	$pdf->Cell(40,5,number_format($grandtotal,2),1,1,'R');
	$pdf->Cell(0,5,'',0,1);	
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'**********************************Nothing Follows****************************',0,1,'C');	
	$pdf->Cell(0,25,'',0,1);	
	$pdf->Cell(0,5,'MA. COLLEEN L. EMORICHA,EdD,CESE',0,1,'C');
	$pdf->Cell(0,5,'Asst. Schools Division Superintendent',0,1,'C');
	$pdf->Cell(0,5,'CHAIRMAN',0,1,'C');
	
	//Display the Output data
	$pdf->Output();
?>
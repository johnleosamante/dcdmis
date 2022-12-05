
<?php
session_start();
include("../../../pcdmis/vendor/jquery/function.php");
foreach ($_GET as $key => $data)
{
$url=$_GET[$key]=base64_decode(urldecode($data));
	
}
require('../../../pcdmis/code128.php');


$pdf=new PDF_Code128('L','mm','Legal');

$img1='../../../pcdmis/shs/h1.png';	
$img2='../../../pcdmis/logo/logo.png';


//Add New Page
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();
$pdf->Image($img2,225,10,20);
$pdf->Image($img1,110,10,20);


    $grandtotal=0;
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'Republic of the Philippines',0,1,'C');
	$pdf->Cell(0,5,'Department of Education',0,1,'C');
	$pdf->Cell(0,5,'Region IX, Zamboanga Peninsula',0,1,'C');
	$pdf->Cell(0,5,'DIVISION OF PAGADIAN CITY',0,1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,5,'Pagadian City',0,1,'C');
	$pdf->Cell(0,3,'',0,1);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(0,5,date("Y").' REGISTRY OF TEACHER 1 APPLICANTS - '.$_SESSION['ApplicantCat'],0,1,'C');
	$pdf->SetFont('Arial','i',6);
	$pdf->Cell(0,5,'(per DepEd Order No. 7, s. 2015)',0,1,'C');
	
	$pdf->Cell(0,3,'',0,1);
		
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,5,'EVALUATION AND SELECTION CRITERIA',0,1,'C');
	//$pdf->Cell(0,2,'',0,1);
	$pdf->SetFont('Arial','',7);
	
	$pdf->Cell(36,15,'NAME',1,0);
	$pdf->Cell(18,15,'CONTACT #',1,0,'C');
	$pdf->Cell(35,15,'ADDRESS',1,0,'C');
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->Multicell(43,5,'Education (20)',1,'C');
	
	//Next Layer
	$pdf->Cell(89,5,'',0,0,'C');
	$pdf->Cell(8,10,'GWA',1,0,'C');
	$pdf->Cell(10,5,'Equiv',1,0,'C');
	$pdf->Cell(12,5,'MA/PhD',1,0,'C');
	$pdf->Cell(13,5,'Sub Total',1,0,'C');
	$pdf->Cell(12,5,'Gen T E.',1,0,'C');
	$pdf->Cell(12,5,'KVT/LGU',1,0,'C');
	$pdf->Cell(13,5,'Sub Total',1,0,'C');
	$pdf->Cell(12,10,'Rating',1,0,'C');
	$pdf->Cell(12,5,'Equiv',1,0,'C');
	$pdf->Cell(12.5,5,'Cert.',1,0,'C');
	$pdf->Cell(12.5,5,'Demo',1,0,'C');
	$pdf->Cell(78,5,'',0,0,'C');
	$pdf->Cell(12.5,10,'Rating',1,0,'C');
	$pdf->Cell(12.5,5,'Equiv',1,1,'C');
	
		//Next Layer
	$pdf->Cell(81,5,'',0,0,'C');
	$pdf->Cell(16,5,'',0,0,'C');
	$pdf->Cell(10,5,'18',1,0,'C');
	$pdf->Cell(12,5,'2',1,0,'C');
	$pdf->Cell(13,5,'20',1,0,'C');
	$pdf->Cell(12,5,'12',1,0,'C');
	$pdf->Cell(12,5,'3',1,0,'C');
	$pdf->Cell(13,5,'15',1,0,'C');
	$pdf->Cell(12,10,'',0,0,'C');
	$pdf->Cell(12,5,'15 ',1,0,'C');
	$pdf->Cell(12.5,5,'5',1,0,'C');
	$pdf->Cell(12.5,5,'5',1,0,'C');
	$pdf->Cell(13,5,'10',1,0,'C');
	$pdf->Cell(17,5,'10',1,0,'C');
	$pdf->Cell(24,5,'5',1,0,'C');
	$pdf->Cell(24,5,'15',1,0,'C');
	$pdf->Cell(12.5,5,'',0,0,'C');
	$pdf->Cell(12.5,5,'15',1,1,'C');
	
	//Next Layer
	$pdf->SetXY($xPos+43,$yPos);
	$pdf->Cell(37,5,'Teaching Experience (15)',1,0,'C');
	$pdf->Cell(24,5,'LET/PBET (15)',1,0,'C');
	$pdf->Cell(25,5,'Specialized T&S (10)',1,0,'C');
	$pdf->Cell(13,10,'Sub Total ',1,0,'C');
	$pdf->Cell(17,10,'Interview (10) ',1,0,'C');
	$pdf->Cell(24,10,'MotherTongue (5) ',1,0,'C');
	$pdf->Cell(24,10,'Demo Teachng (15) ',1,0,'C');
	$pdf->Cell(25,5,'Eng. Com Skls (15) ',1,0,'C');
	$pdf->Cell(15,15,'Grand Total ',1,1,'C');
	
	
	$pdf->SetFont('Arial','',6);
	//Get data from database
	$no=0;
	
	 $result=mysqli_query($con,"SELECT * FROM tbl_applicant WHERE Status <> 'OLD' AND Category='".$_SESSION['ApplicantCat']."' ORDER BY Major,Last_Name Asc");
	
	while($row=mysqli_fetch_array($result))
	{
		$no++;
		$GrandTotal=0;
		$MName=mb_strimwidth($row['Middle_Name'],0,1);
		
	    $pdf->Cell(36,5,utf8_decode($row['Last_Name'].', '.$row['First_Name'].' '.$MName.'.'),1,0);
	    $pdf->Cell(18,5,$row['Contact_No'],1,0,'C');
		$pdf->SetFont('Arial','',5);
	    $pdf->Cell(35,5,$row['Home_Address'],1,0);
		$pdf->SetFont('Arial','',6);
		//Rating data
		$myrating=mysqli_query($con,"SELECT * FROM tbl_applicant_rating WHERE ApplicanNo='".$row['Appl_No']."' LIMIT 1");
		$rowrate=mysqli_fetch_assoc($myrating);
		$GrandTotal= $rowrate['EdSubTotal'] + $rowrate['TeachSubTotal'] + $rowrate['RateEquive'] + $rowrate['SpecialSubTotal'] + $rowrate['EngEval']+ $rowrate['Thirteen']+ $rowrate['Fourteen'];
						  
		$pdf->Cell(8,5,number_format($rowrate['One'],2),1,0,'C');
		$pdf->Cell(10,5,number_format($rowrate['EdEquiv'],2),1,0,'C');
		$pdf->Cell(12,5,number_format($rowrate['Three'],2),1,0,'C');
		$pdf->Cell(13,5,number_format($rowrate['EdSubTotal'],2),1,0,'C');
		$pdf->Cell(12,5,number_format($rowrate['Five'],2),1,0,'C');
		$pdf->Cell(12,5,number_format($rowrate['Six'],2),1,0,'C');
		$pdf->Cell(13,5,number_format($rowrate['TeachSubTotal'],2),1,0,'C');
		$pdf->Cell(12,5,number_format($rowrate['Eight'],2),1,0,'C');
		$pdf->Cell(12,5,number_format($rowrate['RateEquive'],2),1,0,'C');
		$pdf->Cell(12.5,5,number_format($rowrate['Ten'],2),1,0,'C');
		$pdf->Cell(12.5,5,number_format($rowrate['Eleven'],2),1,0,'C');
		$pdf->Cell(13,5,number_format($rowrate['SpecialSubTotal'],2),1,0,'C');
		$pdf->Cell(17,5,number_format($rowrate['Thirteen'],2),1,0,'C');
		$pdf->Cell(24,5,number_format($rowrate['MotherTongue'],2),1,0,'C');
		$pdf->Cell(24,5,$rowrate['Fourteen'],1,0,'C');
		$pdf->Cell(12.5,5,number_format($rowrate['Fifteen'],2),1,0,'C');
		$pdf->Cell(12.5,5,number_format($rowrate['EngEval'],2),1,0,'C');
		$pdf->Cell(15,5,number_format($GrandTotal,2),1,1,'C');
		
	}
	//$pdf->Cell(0,5,'',0,1,'C');	
	$pdf->Cell(0,5,'***********************Nothing Follows***********************',0,1,'C');
	//$pdf->Cell(0,3,'',0,1,'C');	
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,5,'DIVISION SELECTION AND SCREENING COMMITTEE:',0,1,'C');
	$pdf->Cell(0,3,'',0,1,'C');
	$pdf->SetFont('Arial','B',10);
	
	//First Line Signature	
	$pdf->Cell(70,5,'PEDRITA H. BALDOZA, EdD',0,0,'C');
	$pdf->Cell(30,5,'',0,0,'C');
	$pdf->Cell(70,5,'BRENDA LEE T. ALCASID',0,0,'C');
	$pdf->Cell(30,5,'',0,0,'C');
	$pdf->Cell(70,5,'JEESREL G. HIMANG',0,1,'C');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(70,5,'PESFA President',0,0,'C');
	$pdf->Cell(30,5,'',0,0,'C');
	$pdf->Cell(70,5,'VP-PETA-MT',0,0,'C');
	$pdf->Cell(30,5,'',0,0,'C');
	$pdf->Cell(70,5,'FPTA-President',0,1,'C');
	
	//Second Line Signature
	$pdf->Cell(0,3,'',0,1,'C');
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(40,5,'',0,0,'C');
	$pdf->Cell(70,5,'JOCELYN T. PEREZ, EdD',0,0,'C');
	$pdf->Cell(130,5,'',0,0,'C');
	$pdf->Cell(70,5,'HONEY SAHARA B. ALEMAN',0,1,'C');
	
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(40,5,'',0,0,'C');
	$pdf->Cell(70,5,'Education Program Supervisor',0,0,'C');
	$pdf->Cell(130,5,'',0,0,'C');
	$pdf->Cell(70,5,'Education Program Specialized',0,1,'C');
	
	
	//Third Line Signature

 
	$pdf->Cell(0,2,'',0,1,'C');
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,'MA. COLLEEN L. EMORICHA, EdD., CESE',0,1,'C');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'Assistant Schools Division Superintendent- Chairman',0,1,'C');
	
	//Approved by SDS
	$pdf->Cell(0,3,'',0,1,'C');
    $pdf->Cell(100,5,'',0,0);
    $pdf->Cell(0,5,'Approved by:',0,1);
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,'MA. LIZA R. TABILON, EdD., CESO V',0,1,'C');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'Schools Division Superintendent',0,1,'C');
	
	
	
	//Display the Output data
	$pdf->Output();
?>
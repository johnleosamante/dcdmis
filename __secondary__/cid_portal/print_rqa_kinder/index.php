
<?php
session_start();
include("../../../pcdmis/vendor/jquery/function.php");
foreach ($_GET as $key => $data)
{
$url=$_GET[$key]=base64_decode(urldecode($data));
	
}
require('../../../pcdmis/code128.php');


$pdf=new PDF_Code128('P','mm','Legal');



$img1='../../../pcdmis/shs/h1.png';	
$img2='../../../pcdmis/logo/logo.png';

//Add New Page
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();
$pdf->Image($img2,150,10,20);
$pdf->Image($img1,50,10,20);

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
	$pdf->Cell(0,5,date("Y").' RQA FOR KINDER SCHOOL TEACHER 1 POSITION',0,1,'C');
	$pdf->SetFont('Arial','i',8);
	$pdf->Cell(0,5,'(per DepEd Order No. 7, s. 2016)',0,1,'C');
	$pdf->Cell(0,2,'',0,1);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(0,5,$_SESSION['sy'],0,1,'C');
	
	$pdf->Cell(0,2,'',0,1);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,date("F d, Y"),0,1,'R');
	$pdf->Cell(0,3,'',0,1);
	
	//Save Score for english subject
	
	$result=mysqli_query($con,"SELECT * FROM tbl_applicant WHERE Status <> 'OLD' AND Category='KINDER' ORDER BY Last_Name Asc");
	
	while($row=mysqli_fetch_array($result))
	{
		//Rating data
		$GrandTotal=0;
		$myrating=mysqli_query($con,"SELECT * FROM tbl_applicant_rating WHERE ApplicanNo='".$row['Appl_No']."' LIMIT 1");
		$rowrate=mysqli_fetch_assoc($myrating);
		$GrandTotal= $rowrate['EdSubTotal'] + $rowrate['TeachSubTotal'] + $rowrate['RateEquive'] + $rowrate['SpecialSubTotal'] + $rowrate['EngEval']+ $rowrate['Thirteen']+ $rowrate['Fourteen'];
		if ($GrandTotal>=70)
		{
			$rqalist=mysqli_query($con,"SELECT * FROM tbl_rqa_list WHERE ApplicantNo ='".$row['Appl_No']."' AND Year='".date("Y")."' LIMIT 1");
			if (mysqli_num_rows($rqalist)==0)
			{
				mysqli_query($con,"INSERT INTO  tbl_rqa_list VALUES(NULL,'".$GrandTotal."','".$row['Major']."','".date("Y")."','".$row['Appl_No']."')");
			}elseif (mysqli_num_rows($rqalist)==1){
				mysqli_query($con,"UPDATE tbl_rqa_list SET Scores='".$GrandTotal."' WHERE ApplicantNo ='".$row['Appl_No']."' AND Year='".date("Y")."' LIMIT 1");
			}
		}
	}
	
	$pdf->SetFont('Arial','',9);
	//List of Participant
	$pdf->Cell(10,5,'NO',1,0,'C');
	$pdf->Cell(90,5,'NAME',1,0);

	$pdf->Cell(30,5,'GRAND TOTAL',1,0,'C');
	$pdf->Cell(20,5,'RANK',1,1,'C');
	
	
	 $no=$rank=$rows = 0;
	 $last_score = false;
	
	$myrank=mysqli_query($con,"SELECT * FROM tbl_rqa_list INNER JOIN tbl_applicant ON tbl_rqa_list.ApplicantNo = tbl_applicant.Appl_No WHERE tbl_applicant.Status <> 'OLD' AND tbl_applicant.Category='KINDER' ORDER BY tbl_rqa_list.Scores Desc");
	
	while($newrank=mysqli_fetch_array($myrank))
	{
		$no++;	
		$MName=mb_strimwidth($newrank['Middle_Name'],0,1);
		$pdf->Cell(10,5,$no,1,0,'C');
	    $pdf->Cell(90,5,utf8_decode($newrank['Last_Name'].', '.$newrank['First_Name'].' '.$MName.'.'),1,0);
	   	
	    $pdf->Cell(30,5,number_format($newrank['Scores'],2),1,0,'C');
		$rows++;
		if( $last_score!= $newrank['Scores'] ){
		  $last_score = $newrank['Scores'];
		  $rank = $rows;
		}
		
	    $pdf->Cell(20,5,$rank,1,1,'C');
	}
    $pdf->Cell(0,5,'',0,1,'C');	
	$pdf->Cell(0,5,'***********************Nothing Follows***********************',0,1,'C');
	$pdf->Cell(0,10,'',0,1,'C');	
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(0,5,'DIVISION SELECTION AND SCREENING COMMITTEE:',0,1,'C');
	$pdf->Cell(0,15,'',0,1,'C');
	$pdf->SetFont('Arial','B',10);
	
	//First Line Signature	
	$pdf->Cell(50,5,'PEDRITA H. BALDOZA, EdD',0,0,'C');
	$pdf->Cell(10,5,'',0,0,'C');
	$pdf->Cell(60,5,'BRENDA LEE T. ALCASID',0,0,'C');
	$pdf->Cell(10,5,'',0,0,'C');
	$pdf->Cell(60,5,'JEESREL G. HIMANG',0,1,'C');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(50,5,'PESFA President',0,0,'C');
	$pdf->Cell(10,5,'',0,0,'C');
	$pdf->Cell(60,5,'VP-PETA-MT',0,0,'C');
	$pdf->Cell(10,5,'',0,0,'C');
	$pdf->Cell(60,5,'FPTA-President',0,1,'C');
	
	//Second Line Signature
	$pdf->Cell(0,10,'',0,1,'C');
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(20,5,'',0,0,'C');
	$pdf->Cell(50,5,'JOCELYN T. PEREZ, EdD',0,0,'C');
	$pdf->Cell(50,5,'',0,0,'C');
	$pdf->Cell(50,5,'HONEY SAHARA B. ALEMAN',0,1,'C');
	
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(20,5,'',0,0,'C');
	$pdf->Cell(50,5,'Education Program Supervisor',0,0,'C');
	$pdf->Cell(50,5,'',0,0,'C');
	$pdf->Cell(50,5,'Education Program Specialized',0,1,'C');
	
	//Third Line Signature
	$pdf->Cell(0,15,'',0,1,'C');
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,5,'MA. COLLEEN L. EMORICHA, EdD., CESE',0,1,'C');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'Assistant Schools Division Superintendent- Chairman',0,1,'C');
	
   //Fourth Line Signature
    $pdf->Cell(0,15,'',0,1,'C');
    $pdf->Cell(30,5,'',0,0,'C');
	$pdf->Cell(10,5,'',0,0,'C'); 
    $pdf->Cell(0,5,'Approved by:',0,1);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,5,'',0,1,'C');
	
	$pdf->Cell(0,5,'MA. LIZA R. TABILON, EdD., CESO V',0,1,'C');
	$pdf->SetFont('Arial','',10);
	
	$pdf->Cell(0,5,'Schools Division Superintendent',0,1,'C');
 
	//Display the Output data
	$pdf->Output();
?>
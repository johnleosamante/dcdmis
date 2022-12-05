
<?php
session_start();
include("../../../pcdmis/vendor/jquery/function.php");
foreach ($_GET as $key => $data)
{
$url=$_GET[$key]=base64_decode(urldecode($data));
	
}
require('../../../pcdmis/code128.php');


$pdf=new PDF_Code128('P','mm','Legal');


 $mysubject=mysqli_query($con,"SELECT * FROM tbl_ranking_subject ORDER BY RankSubject Asc");
 while($rowsub=mysqli_fetch_array($mysubject))
 {

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
	$pdf->Cell(0,5,date("Y").' RQA FOR JUNIOR HIGH SCHOOL TEACHER 1 POSITION',0,1,'C');
	$pdf->SetFont('Arial','i',8);
	$pdf->Cell(0,5,'(per DepEd Order No. 7, s. 2016)',0,1,'C');
	$pdf->Cell(0,2,'',0,1);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(0,5,$_SESSION['sy'],0,1,'C');
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(0,5,$rowsub['RankSubject'],0,1,'C');
	$pdf->Cell(0,2,'',0,1);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,date("F d, Y"),0,1,'R');
	$pdf->Cell(0,3,'',0,1);
	
	//Save Score for english subject
	if ($rowsub['RankSubject']=='SCIENCE')
	{
	$result=mysqli_query($con,"SELECT * FROM tbl_applicant WHERE Status <> 'OLD' AND Major LIKE '%".$rowsub['RankSubject']."%' ORDER BY Last_Name Asc");	
	}else{
	$result=mysqli_query($con,"SELECT * FROM tbl_applicant WHERE Status <> 'OLD' AND Major='".$rowsub['RankSubject']."' ORDER BY Last_Name Asc");
	}
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
	$pdf->Cell(100,5,'NAME',1,0);
	$pdf->Cell(50,5,'MAJOR',1,0,'C');
	$pdf->Cell(40,5,'GRAND TOTAL',1,1,'C');
	
	
	
	 $no=$rank=$rows = 0;
	 $last_score = false;
	 if ($rowsub['RankSubject']=='SCIENCE')
	{
	$myrank=mysqli_query($con,"SELECT * FROM tbl_rqa_list INNER JOIN tbl_applicant ON tbl_rqa_list.ApplicantNo = tbl_applicant.Appl_No WHERE tbl_applicant.Status <> 'OLD' AND tbl_applicant.Major LIKE '%".$rowsub['RankSubject']."%' AND tbl_rqa_list.Scores >=70 ORDER BY tbl_rqa_list.Scores Desc");
	}else{	
	$myrank=mysqli_query($con,"SELECT * FROM tbl_rqa_list INNER JOIN tbl_applicant ON tbl_rqa_list.ApplicantNo = tbl_applicant.Appl_No WHERE tbl_applicant.Status <> 'OLD' AND tbl_applicant.Major='".$rowsub['RankSubject']."' AND tbl_rqa_list.Scores >=70 ORDER BY tbl_rqa_list.Scores Desc");
	}
	while($newrank=mysqli_fetch_array($myrank))
	{
		$no++;	
		$MName=mb_strimwidth($newrank['Middle_Name'],0,1);
		
	    $pdf->Cell(100,5,utf8_decode($newrank['Last_Name'].', '.$newrank['First_Name'].' '.$MName.'.'),1,0);
	    $pdf->Cell(50,5,strtoupper($newrank['Major']),1,0,'C');		
	    $pdf->Cell(40,5,number_format($newrank['Scores'],2),1,1,'C');
		$rows++;
		if( $last_score!= $newrank['Scores'] ){
		  $last_score = $newrank['Scores'];
		  $rank = $rows;
		}
		
	 
	}
    $pdf->Cell(0,5,'',0,1,'C');	
	$pdf->Cell(0,5,'***********************Nothing Follows***********************',0,1,'C');
	$pdf->Cell(0,10,'',0,1,'C');	
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(0,5,'DIVISION SELECTION AND SCREENING COMMITTEE:',0,1,'C');
	$pdf->Cell(0,15,'',0,1,'C');
	$pdf->SetFont('Arial','B',10);
	
	//First Line Signature	
	$pdf->Cell(70,5,'JAMES E. MARQUEZ, EdD',0,0,'C');
	$pdf->Cell(70,5,'DOMINIC A. SARAYAN',0,0,'C');
	$pdf->Cell(70,5,'JEESREL G. HIMANG',0,1,'C');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(70,5,'SSP IV, NAPSHII President-Mem.',0,0,'C');
	$pdf->Cell(70,5,'Teachers\' Ass. Rep.-Mem.',0,0,'C');
	$pdf->Cell(70,5,'Sec. FPTA-President-Mem.',0,1,'C');
	
	//Second Line Signature
	$pdf->Cell(0,15,'',0,1,'C');
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(70,5,'JUSERE ANN C. BASAYA, EdD',0,0,'C');
	$pdf->Cell(70,5,'SALEM T. UYAG',0,0,'C');
	$pdf->Cell(70,5,'RAQUEL R. YAP',0,1,'C');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(70,5,'Education Program Supervisor- Mem.',0,0,'C');
	$pdf->Cell(70,5,'Education Program Supervisor- Mem.',0,0,'C');
	$pdf->Cell(70,5,'Education Program Supervisor- Mem.',0,1,'C');
	
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
 }
	//Display the Output data
	$pdf->Output();
?>
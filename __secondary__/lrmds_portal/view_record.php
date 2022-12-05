<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");



foreach ($_GET as $key => $data)
{
$id=$_GET[$key]=base64_decode(urldecode($data));
	
}
require('../../pcdmis/code128.php');
header('content-type: text/html; charset: utf-8');
$mysched=mysqli_query($con,"SELECT * FROM tbl_distribution_schedule");
$rowdata=mysqli_fetch_assoc($mysched);
$_SESSION['quarter']=$rowdata['QuarterNo'];					 		
$_SESSION['week']=$rowdata['WeekNo'];	
$pdf=new PDF_Code128('P','mm','Letter');


$img1='../../pcdmis/shs/h1.png';	
$img2='../../pcdmis/logo/logo.png';

//Add New Page
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();
$pdf->Image($img1,165,10,20);
$pdf->Image($img2,30,10,20);



	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'Republic of the Philippines',0,1,'C');
	$pdf->Cell(0,5,'Department of Education',0,1,'C');
	$pdf->Cell(0,5,'Region IX, Zamboanga Peninsula',0,1,'C');
	$pdf->Cell(0,5,'DIVISION OF PAGADIAN CITY',0,1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,5,'Pagadian City',0,1,'C');
	$pdf->Cell(0,3,'',0,1);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,5,'LRMS SUMMARY REPORT FOR  '.strtoupper($_SESSION['quarter'].' QUARTER - '.$_SESSION['week']),0,1,'C');
	
	
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,0,'',1,1);
	$pdf->Cell(60,5,'',0,0,'l');
	$pdf->Cell(0,5,date("F d, Y"),0,1,'R');
	$pdf->Cell(0,5,'',0,1);
	$result=mysqli_query($con,"SELECT * FROM tbl_school INNER JOIN tbl_employee ON tbl_school.Incharg_ID = tbl_employee.Emp_ID WHERE SchoolID='".$_SESSION['SchoolID']."' LIMIT 1");
	$row=mysqli_fetch_assoc($result);
	$pdf->Cell(0,5,strtoupper($row['SchoolName']),0,1);
	$pdf->Cell(0,5,$row['Address'],0,1);
	$pdf->Cell(0,5,'',0,1);
	$pdf->SetFont('Arial','',8);
	if ($row['School_Category']=='Elementary')
	{
	$pdf->Cell(25,10,"GRADE LEVEL",1,0,'C');
	$pdf->Cell(25,10,"# OF LEARNERS",1,0,'C');
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->Multicell(123,5,"ELEMENTARY LEARNING AREAS",1,'C');
	$pdf->Cell(50,10,"",0,0);
	$pdf->Cell(11.18,5,'Eng',1,0,'C');
	$pdf->Cell(11.18,5,'Sci',1,0,'C');
	$pdf->Cell(11.18,5,'Math',1,0,'C');
	$pdf->Cell(11.18,5,'Fil',1,0,'C');
	$pdf->Cell(11.18,5,'Ar.Pan',1,0,'C');
	$pdf->Cell(11.18,5,'ESP',1,0,'C');
	$pdf->Cell(11.18,5,'TLE',1,0,'C');
	$pdf->Cell(11.18,5,'MAPEH',1,0,'C');
	$pdf->Cell(11.18,5,'M.T',1,0,'C');
	$pdf->Cell(11.18,5,'R.O',1,0,'C');
	$pdf->Cell(11.18,5,'P.R',1,0,'C');
	$pdf->SetXY($xPos+123,$yPos);
	$pdf->Cell(23,10,"TOTAL",1,1,'C');
	
	$total=$noOfLeaner=$totaleng=$totalscien=$totalMath=$totalFil=$subtotal=$totalRO=$totalPR=0;
	$totalAral=$totalEsp=$totaltle=$totalmusic=$totalarts=$totalpe=$totalhealth=$totalThematic=0;
		
		$mysubject=mysqli_query($con,"SELECT * FROM tbl_elementary_subject WHERE SchoolID ='".$_SESSION['SchoolID']."' AND WeekNo ='".$_SESSION['week']."' AND QuarterNo ='".$_SESSION['quarter']."' ORDER BY GradeLevel Asc");
		while($rowelemsub=mysqli_fetch_array($mysubject))
		{
			$total=	$rowelemsub['English'] + $rowelemsub['Science'] + $rowelemsub['Math'] + $rowelemsub['Filipino'] + $rowelemsub['AralPan'] + $rowelemsub['ESP'] + $rowelemsub['TLE'] + $rowelemsub['MAPEH'] + $rowelemsub['Mother_tongue']+$rowelemsub['Project_Rush']+$rowelemsub['RO_Thematic'];
			if ($rowelemsub['GradeLevel']=='Kinder')
			{
			$pdf->Cell(25,5,$rowelemsub['GradeLevel'],1,0,'C');	
			}else{				
			$pdf->Cell(25,5,'Grade '.$rowelemsub['GradeLevel'],1,0,'C');
			}
			$pdf->Cell(25,5,$rowelemsub['No_of_learner'],1,0,'C');
			$pdf->Cell(11.18,5,$rowelemsub['English'],1,0,'C');
			$pdf->Cell(11.18,5,$rowelemsub['Science'],1,0,'C');
			$pdf->Cell(11.18,5,$rowelemsub['Math'],1,0,'C');
			$pdf->Cell(11.18,5,$rowelemsub['Filipino'],1,0,'C');
			$pdf->Cell(11.18,5,$rowelemsub['AralPan'],1,0,'C');
			$pdf->Cell(11.18,5,$rowelemsub['ESP'],1,0,'C');
			$pdf->Cell(11.18,5,$rowelemsub['TLE'],1,0,'C');
			$pdf->Cell(11.18,5,$rowelemsub['MAPEH'],1,0,'C');
			$pdf->Cell(11.18,5,$rowelemsub['Mother_tongue'],1,0,'C');
			$pdf->Cell(11.18,5,$rowelemsub['RO_Thematic'],1,0,'C');
			$pdf->Cell(11.18,5,$rowelemsub['Project_Rush'],1,0,'C');
			$pdf->Cell(23,5,number_format($total,0),1,1,'C');
		}
	}else{
	$pdf->Cell(23,10,"GRADE LEVEL",1,0,'C');
	$pdf->Cell(25,10,"# OF LEARNERS",1,0,'C');
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->Multicell(130,5,"SECONDARY LEARNING AREAS",1,'C');
	$pdf->Cell(48,10,"",0,0);
	$pdf->Cell(10.83,5,'Eng',1,0,'C');
	$pdf->Cell(10.83,5,'Sci',1,0,'C');
	$pdf->Cell(10.83,5,'Math',1,0,'C');
	$pdf->Cell(10.83,5,'Fil',1,0,'C');
	$pdf->Cell(10.83,5,'Ar.Pan',1,0,'C');
	$pdf->Cell(10.83,5,'ESP',1,0,'C');
	$pdf->Cell(10.83,5,'TLE',1,0,'C');
	$pdf->Cell(10.83,5,'Music',1,0,'C');
	$pdf->Cell(10.83,5,'Arts',1,0,'C');
	$pdf->Cell(10.83,5,'P.E',1,0,'C');
	$pdf->Cell(10.83,5,'Health',1,0,'C');
	$pdf->Cell(10.83,5,'RO',1,0,'C');
	$pdf->SetXY($xPos+130,$yPos);
	$pdf->Cell(18,10,"TOTAL",1,1,'C');
	
	$total=$noOfLeaner=$totaleng=$totalscien=$totalMath=$totalFil=$subtotal=$totalRO=$totalPR=0;
	$totalAral=$totalEsp=$totaltle=$totalmusic=$totalarts=$totalpe=$totalhealth=$totalThematic=0;
		
		$mysecsubject=mysqli_query($con,"SELECT * FROM tbl_secondary_subject WHERE SchoolID ='".$_SESSION['SchoolID']."' AND WeekNo ='".$_SESSION['week']."' AND QuarterNo ='".$_SESSION['quarter']."' ORDER BY GradeLevel Asc");
		while($rowsecondsub=mysqli_fetch_array($mysecsubject))
		{
			$total=	$rowsecondsub['English'] + $rowsecondsub['Science'] + $rowsecondsub['Math'] + $rowsecondsub['Filipino'] + $rowsecondsub['AralPan'] + $rowsecondsub['ESP'] + $rowsecondsub['TLE'] + $rowsecondsub['Music'] + $rowsecondsub['Arts'] + $rowsecondsub['PE'] + $rowsecondsub['Health'] + $rowsecondsub['RO_Thematic'];
						
			$pdf->Cell(23,5,'Grade '.$rowsecondsub['GradeLevel'],1,0,'C');
			
			$pdf->Cell(25,5,$rowsecondsub['No_of_learner'],1,0,'C');
			$pdf->Cell(10.83,5,$rowsecondsub['English'],1,0,'C');
			$pdf->Cell(10.83,5,$rowsecondsub['Science'],1,0,'C');
			$pdf->Cell(10.83,5,$rowsecondsub['Math'],1,0,'C');
			$pdf->Cell(10.83,5,$rowsecondsub['Filipino'],1,0,'C');
			$pdf->Cell(10.83,5,$rowsecondsub['AralPan'],1,0,'C');
			$pdf->Cell(10.83,5,$rowsecondsub['ESP'],1,0,'C');
			$pdf->Cell(10.83,5,$rowsecondsub['TLE'],1,0,'C');
			$pdf->Cell(10.83,5,$rowsecondsub['Music'],1,0,'C');
			$pdf->Cell(10.83,5,$rowsecondsub['Arts'],1,0,'C');
			$pdf->Cell(10.83,5,$rowsecondsub['PE'],1,0,'C');
			$pdf->Cell(10.83,5,$rowsecondsub['Health'],1,0,'C');
			$pdf->Cell(10.83,5,$rowsecondsub['RO_Thematic'],1,0,'C');
			$pdf->Cell(18,5,number_format($total,0),1,1,'C');
		}
	$pdf->Cell(0,5,"**********Nothing follows**********",1,1,'C');
	$pdf->Cell(0,5,"",0,1,'C');
	
	//Senior high school information
	$pdf->Cell(23,10,"GRADE LEVEL",1,0,'C');
	$pdf->Cell(25,10,"# OF LEARNERS",1,0,'C');
	$pdf->Cell(100,10,"LEARNING AREAS",1,0,'C');
	$pdf->Cell(30,10,"SUBJECT TYPE",1,0,'C');
	$pdf->Cell(18,10,"TOTAL",1,1,'C');
	$myseniorsubject=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode =tbl_senior_sub_strand.StrandsubCode INNER JOIN tbl_senior_strand_type ON tbl_shs_report.Subject_type = tbl_senior_strand_type.StrandCode  WHERE tbl_shs_report.SchoolID ='".$_SESSION['SchoolID']."' AND tbl_shs_report.WeekNo ='".$_SESSION['week']."' AND tbl_shs_report.QuarterNo ='".$_SESSION['quarter']."' GROUP BY tbl_shs_report.SubCode ORDER BY tbl_shs_report.GradeLevel Asc");
		while($rowseniorsub=mysqli_fetch_array($myseniorsubject))
		{
			$pdf->Cell(23,5,$rowseniorsub['GradeLevel'],1,0,'C');
			$pdf->Cell(25,5,$rowseniorsub['No_of_learner'],1,0,'C');
			$pdf->Cell(100,5,$rowseniorsub['SubStrandDescription'],1,0,'C');
			$pdf->Cell(30,5,$rowseniorsub['StrandDescription'],1,0,'C');
			$pdf->Cell(18,5,$rowseniorsub['No_of_copies'],1,1,'C');	
		}
	
	}

	$gdata=mb_strimwidth($row['Emp_MName'],0,1);
	$pdf->Cell(0,5,"**********Nothing follows**********",1,1,'C');
	$pdf->Cell(0,10,"",0,1);
	$pdf->Cell(0,15,"Submitted by:",0,1);
	$pdf->Cell(30,5,"",0,0,'C');
	$pdf->Cell(40,5,$row['Emp_FName'].' '.$gdata.'. '.$row['Emp_LName'],0,1,'C');
	
	$pdf->Cell(30,5,"",0,0,'C');
	$pdf->Cell(40,5,"School Principal",0,1,'C');
	
	//Display the Output data
	$pdf->Output();
?>
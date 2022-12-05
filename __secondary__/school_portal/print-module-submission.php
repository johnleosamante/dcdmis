
<?php
session_start();
include_once("../../pcdmis/vendor/jquery/function.php");
require('../../pcdmis/code128.php');


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
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(0,5,'LRMS SUMMARY REPORT FOR  '.strtoupper($_SESSION['quarter'].' QUARTER - '.$_SESSION['week']),0,1,'C');
	
	
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,0,'',1,1);
	$pdf->Cell(60,5,'',0,0,'l');
	$pdf->Cell(0,5,date("F d, Y"),0,1,'R');
	$pdf->Cell(0,5,'',0,1);
	$result=mysqli_query($con,"SELECT * FROM tbl_school INNER JOIN tbl_employee ON tbl_school.Incharg_ID = tbl_employee.Emp_ID WHERE SchoolID='".$_SESSION['school_id']."' LIMIT 1");
	$row=mysqli_fetch_assoc($result);
	$pdf->Cell(0,5,strtoupper($row['SchoolName']),0,1);
	$pdf->Cell(0,5,$row['Address'],0,1);
	$pdf->Cell(0,5,'',0,1);
	$pdf->SetFont('Arial','',8);
	if ($row['School_Category']=='Elementary' AND  $_SESSION['SchoolType']=='Elementary')
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
	
	$subLearnerTotal=$subEng=$subScie=$subMath=$subFil=$subAral=$subESP=$subTLE=$MAPEH=$Mother_tongue=$RO_Thematic=$Project_Rush=$subTotal=0;	

	
		$mysubject=mysqli_query($con,"SELECT * FROM tbl_elementary_subject WHERE SchoolID ='".$_SESSION['school_id']."' AND WeekNo ='".$_SESSION['week']."' AND QuarterNo ='".$_SESSION['quarter']."' ORDER BY GradeLevel Asc");
		while($rowelemsub=mysqli_fetch_array($mysubject))
		{
			$total=	$rowelemsub['English'] + $rowelemsub['Science'] + $rowelemsub['Math'] + $rowelemsub['Filipino'] + $rowelemsub['AralPan'] + $rowelemsub['ESP'] + $rowelemsub['TLE'] + $rowelemsub['MAPEH'] + $rowelemsub['Mother_tongue']+$rowelemsub['Project_Rush']+$rowelemsub['RO_Thematic'];
				
			$pdf->Cell(25,5,$rowelemsub['GradeLevel'],1,0,'C');
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
			$subLearnerTotal=$subLearnerTotal+$rowelemsub['No_of_learner'];
			$subEng=$subEng+$rowelemsub['English'];
			$subScie=$subScie+$rowelemsub['Science'];
			$subMath=$subMath+$rowelemsub['Math'];
			$subFil=$subFil+$rowelemsub['Filipino'];
			$subAral=$subAral+$rowelemsub['AralPan'];
			$subESP=$subESP+$rowelemsub['ESP'];
			$subTLE=$subTLE+$rowelemsub['TLE'];
			$MAPEH=$MAPEH+$rowelemsub['MAPEH'];
			$Mother_tongue=$Mother_tongue+$rowelemsub['Mother_tongue'];
			$RO_Thematic=$RO_Thematic+$rowelemsub['RO_Thematic'];
			$Project_Rush=$Project_Rush+$rowelemsub['Project_Rush'];
			$subTotal=$subTotal+$total;
		}
		$pdf->Cell(25,5,"Total",1,0,'C');
	$pdf->Cell(25,5,number_format($subLearnerTotal,2),1,0,'C');
	$pdf->Cell(11.18,5,$subEng,1,0,'C');
	$pdf->Cell(11.18,5,$subScie,1,0,'C');
	$pdf->Cell(11.18,5,$subMath,1,0,'C');
	$pdf->Cell(11.18,5,$subFil,1,0,'C');
	$pdf->Cell(11.18,5,$subAral,1,0,'C');
	$pdf->Cell(11.18,5,$subESP,1,0,'C');
	$pdf->Cell(11.18,5,$subTLE,1,0,'C');
	$pdf->Cell(11.18,5,$MAPEH,1,0,'C');
	$pdf->Cell(11.18,5,$Mother_tongue,1,0,'C');
	$pdf->Cell(11.18,5,$RO_Thematic,1,0,'C');
	$pdf->Cell(11.18,5,$Project_Rush,1,0,'C');
	$pdf->Cell(23,5,number_format($subTotal,2),1,1,'C');
		
	}elseif ($_SESSION['Category']=='Secondary' AND  $_SESSION['SchoolType']=='Integrated'){
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
	$subLearnerTotal=$subEng=$subScie=$subMath=$subFil=$subAral=$subESP=$subTLE=$subMusic=$subArts=$subPE=$subHealth=$subRO=$subTotal=0;	
		$mysecsubject=mysqli_query($con,"SELECT * FROM tbl_secondary_subject WHERE SchoolID ='".$_SESSION['school_id']."' AND WeekNo ='".$_SESSION['week']."' AND QuarterNo ='".$_SESSION['quarter']."' ORDER BY GradeLevel Asc");
		while($rowsecondsub=mysqli_fetch_array($mysecsubject))
		{
			$total=	$rowsecondsub['English'] + $rowsecondsub['Science'] + $rowsecondsub['Math'] + $rowsecondsub['Filipino'] + $rowsecondsub['AralPan'] + $rowsecondsub['ESP'] + $rowsecondsub['TLE'] + $rowsecondsub['Music'] + $rowsecondsub['Arts'] + $rowsecondsub['PE'] + $rowsecondsub['Health'] + $rowsecondsub['RO_Thematic'];
				
			$pdf->Cell(23,5,$rowsecondsub['GradeLevel'],1,0,'C');
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
			
			$subLearnerTotal=$subLearnerTotal+$rowsecondsub['No_of_learner'];
			$subEng=$subEng+$rowsecondsub['English'];
			$subScie=$subScie+$rowsecondsub['Science'];
			$subMath=$subMath+$rowsecondsub['Math'];
			$subFil=$subFil+$rowsecondsub['Filipino'];
			$subAral=$subAral+$rowsecondsub['AralPan'];
			$subESP=$subESP+$rowsecondsub['ESP'];
			$subTLE=$subTLE+$rowsecondsub['TLE'];
			$subMusic=$subMusic+$rowsecondsub['Music'];
			$subArts=$subArts+$rowsecondsub['Arts'];
			$subPE=$subPE+$rowsecondsub['PE'];
			$subHealth=$subHealth+$rowsecondsub['Health'];
			$subRO=$subRO+$rowsecondsub['RO_Thematic'];
			$subTotal=$subTotal+$total;
		}
	$pdf->Cell(23,5,"Total",1,0,'C');
	$pdf->Cell(25,5,number_format($subLearnerTotal,2),1,0,'C');
	$pdf->Cell(10.83,5,$subEng,1,0,'C');
	$pdf->Cell(10.83,5,$subScie,1,0,'C');
	$pdf->Cell(10.83,5,$subMath,1,0,'C');
	$pdf->Cell(10.83,5,$subFil,1,0,'C');
	$pdf->Cell(10.83,5,$subAral,1,0,'C');
	$pdf->Cell(10.83,5,$subESP,1,0,'C');
	$pdf->Cell(10.83,5,$subTLE,1,0,'C');
	$pdf->Cell(10.83,5,$subMusic,1,0,'C');
	$pdf->Cell(10.83,5,$subArts,1,0,'C');
	$pdf->Cell(10.83,5,$subPE,1,0,'C');
	$pdf->Cell(10.83,5,$subHealth,1,0,'C');
	$pdf->Cell(10.83,5,$subRO,1,0,'C');
	$pdf->Cell(18,5,$subTotal,1,1,'C');
	$pdf->Cell(0,5,"**********Nothing follows**********",1,1,'C');
	$pdf->Cell(0,5,"",0,1,'C');
	
	$totalLearner=$totalModule=0;
	//Senior high school information
	$pdf->Cell(23,10,"GRADE LEVEL",1,0,'C');
	$pdf->Cell(25,10,"# OF LEARNERS",1,0,'C');
	$pdf->Cell(90,10,"LEARNING AREAS",1,0,'C');
	$pdf->Cell(33,10,"SUBJECT TYPE",1,0,'C');
	$pdf->Cell(25,10,"# OF MODULE",1,1,'C');
	$myseniorsubject=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode =tbl_senior_sub_strand.StrandsubCode INNER JOIN tbl_senior_strand_type ON tbl_shs_report.Subject_type = tbl_senior_strand_type.StrandCode  WHERE tbl_shs_report.SchoolID ='".$_SESSION['school_id']."' AND tbl_shs_report.WeekNo ='".$_SESSION['week']."' AND tbl_shs_report.QuarterNo ='".$_SESSION['quarter']."' GROUP BY tbl_shs_report.SubCode ORDER BY tbl_shs_report.GradeLevel Asc");
		while($rowseniorsub=mysqli_fetch_array($myseniorsubject))
		{
			$pdf->Cell(23,5,$rowseniorsub['GradeLevel'],1,0,'C');
			$pdf->Cell(25,5,$rowseniorsub['No_of_learner'],1,0,'C');
			$pdf->Cell(90,5,$rowseniorsub['LearningAreas'],1,0);
			$pdf->Cell(33,5,$rowseniorsub['StrandDescription'],1,0,'C');
			$pdf->Cell(25,5,$rowseniorsub['No_of_copies'],1,1,'C');	
			$totalLearner=$totalLearner+$rowseniorsub['No_of_learner'];
			$totalModule=$totalModule+$rowseniorsub['No_of_copies'];
		}
	
	$pdf->Cell(23,5,"Total",1,0,'C');
	$pdf->Cell(25,5,number_format($totalLearner,2),1,0,'C');
	$pdf->Cell(90,5,"**********Nothing follows**********",1,0,'C');
	$pdf->Cell(33,5,"Total",1,0,'C');
	$pdf->Cell(25,5,number_format($totalModule,2),1,1,'C');
	
	}elseif ($_SESSION['Category']=='Secondary' AND  $_SESSION['SchoolType']=='Junior'){
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
	$subLearnerTotal=$subEng=$subScie=$subMath=$subFil=$subAral=$subESP=$subTLE=$subMusic=$subArts=$subPE=$subHealth=$subRO=$subTotal=0;	
		$mysecsubject=mysqli_query($con,"SELECT * FROM tbl_secondary_subject WHERE SchoolID ='".$_SESSION['school_id']."' AND WeekNo ='".$_SESSION['week']."' AND QuarterNo ='".$_SESSION['quarter']."' ORDER BY GradeLevel Asc");
		while($rowsecondsub=mysqli_fetch_array($mysecsubject))
		{
			$total=	$rowsecondsub['English'] + $rowsecondsub['Science'] + $rowsecondsub['Math'] + $rowsecondsub['Filipino'] + $rowsecondsub['AralPan'] + $rowsecondsub['ESP'] + $rowsecondsub['TLE'] + $rowsecondsub['Music'] + $rowsecondsub['Arts'] + $rowsecondsub['PE'] + $rowsecondsub['Health'] + $rowsecondsub['RO_Thematic'];
				
			$pdf->Cell(23,5,$rowsecondsub['GradeLevel'],1,0,'C');
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
			
			$subLearnerTotal=$subLearnerTotal+$rowsecondsub['No_of_learner'];
			$subEng=$subEng+$rowsecondsub['English'];
			$subScie=$subScie+$rowsecondsub['Science'];
			$subMath=$subMath+$rowsecondsub['Math'];
			$subFil=$subFil+$rowsecondsub['Filipino'];
			$subAral=$subAral+$rowsecondsub['AralPan'];
			$subESP=$subESP+$rowsecondsub['ESP'];
			$subTLE=$subTLE+$rowsecondsub['TLE'];
			$subMusic=$subMusic+$rowsecondsub['Music'];
			$subArts=$subArts+$rowsecondsub['Arts'];
			$subPE=$subPE+$rowsecondsub['PE'];
			$subHealth=$subHealth+$rowsecondsub['Health'];
			$subRO=$subRO+$rowsecondsub['RO_Thematic'];
			$subTotal=$subTotal+$total;
		}
	$pdf->Cell(23,5,"Total",1,0,'C');
	$pdf->Cell(25,5,number_format($subLearnerTotal,2),1,0,'C');
	$pdf->Cell(10.83,5,$subEng,1,0,'C');
	$pdf->Cell(10.83,5,$subScie,1,0,'C');
	$pdf->Cell(10.83,5,$subMath,1,0,'C');
	$pdf->Cell(10.83,5,$subFil,1,0,'C');
	$pdf->Cell(10.83,5,$subAral,1,0,'C');
	$pdf->Cell(10.83,5,$subESP,1,0,'C');
	$pdf->Cell(10.83,5,$subTLE,1,0,'C');
	$pdf->Cell(10.83,5,$subMusic,1,0,'C');
	$pdf->Cell(10.83,5,$subArts,1,0,'C');
	$pdf->Cell(10.83,5,$subPE,1,0,'C');
	$pdf->Cell(10.83,5,$subHealth,1,0,'C');
	$pdf->Cell(10.83,5,$subRO,1,0,'C');
	$pdf->Cell(18,5,$subTotal,1,1,'C');
	$pdf->Cell(0,5,"**********Nothing follows**********",1,1,'C');
	$pdf->Cell(0,5,"",0,1,'C');
	}elseif ($_SESSION['Category']=='Secondary' AND  $_SESSION['SchoolType']=='Senior'){
	$totalLearner=$totalModule=0;
	//Senior high school information
	$pdf->Cell(23,10,"GRADE LEVEL",1,0,'C');
	$pdf->Cell(25,10,"# OF LEARNERS",1,0,'C');
	$pdf->Cell(90,10,"LEARNING AREAS",1,0,'C');
	$pdf->Cell(33,10,"SUBJECT TYPE",1,0,'C');
	$pdf->Cell(25,10,"# OF MODULE",1,1,'C');
	$myseniorsubject=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode =tbl_senior_sub_strand.StrandsubCode INNER JOIN tbl_senior_strand_type ON tbl_shs_report.Subject_type = tbl_senior_strand_type.StrandCode  WHERE tbl_shs_report.SchoolID ='".$_SESSION['school_id']."' AND tbl_shs_report.WeekNo ='".$_SESSION['week']."' AND tbl_shs_report.QuarterNo ='".$_SESSION['quarter']."' GROUP BY tbl_shs_report.SubCode ORDER BY tbl_shs_report.GradeLevel Asc");
		while($rowseniorsub=mysqli_fetch_array($myseniorsubject))
		{
			$pdf->Cell(23,5,$rowseniorsub['GradeLevel'],1,0,'C');
			$pdf->Cell(25,5,$rowseniorsub['No_of_learner'],1,0,'C');
			$pdf->Cell(90,5,$rowseniorsub['SubStrandDescription'],1,0);
			$pdf->Cell(33,5,$rowseniorsub['StrandDescription'],1,0,'C');
			$pdf->Cell(25,5,$rowseniorsub['No_of_copies'],1,1,'C');	
			$totalLearner=$totalLearner+$rowseniorsub['No_of_learner'];
			$totalModule=$totalModule+$rowseniorsub['No_of_copies'];
		}
	
	$pdf->Cell(23,5,"Total",1,0,'C');
	$pdf->Cell(25,5,number_format($totalLearner,2),1,0,'C');
	$pdf->Cell(90,5,"**********Nothing follows**********",1,0,'C');
	$pdf->Cell(33,5,"Total",1,0,'C');
	$pdf->Cell(25,5,number_format($totalModule,2),1,1,'C');
		
	}
	
	
	
	
	$gdata=mb_strimwidth($row['Emp_MName'],0,1);
	$pdf->Cell(0,10,"",0,1);
	$pdf->Cell(0,15,"Prepared by:",0,1);
	$pdf->Cell(30,5,"",0,0,'C');
	$pdf->Cell(40,5,$row['Emp_FName'].' '.$gdata.'. '.$row['Emp_LName'],0,1,'C');
	$pdf->Cell(30,5,"",0,0,'C');
	$pdf->Cell(40,5,"School Principal",0,1,'C');
		
	//Display the Output data
	$pdf->Output();
?>
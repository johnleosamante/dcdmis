
<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
require('../../pcdmis/code128.php');

if($_SESSION['Grade']==11 || $_SESSION['Grade']==12)
{
	$pdf=new PDF_Code128('P','mm','Letter');

}else{
	$pdf=new PDF_Code128('L','mm','Legal');
}
$img1='../../pcdmis/shs/h1.png';	
$img2='../../pcdmis/logo/logo.png';

//Add New Page
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();
if($_SESSION['Grade']==11 || $_SESSION['Grade']==12)
{
$pdf->Image($img1,165,10,20);
$pdf->Image($img2,30,10,20);
}else{
	
$pdf->Image($img1,218,10,20);
$pdf->Image($img2,115,10,20);
}



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
	
	if ($_SESSION['Grade']=='Kinder' || $_SESSION['Grade']=='1' || $_SESSION['Grade']=='2' || $_SESSION['Grade']=='3' || $_SESSION['Grade']=='4' || $_SESSION['Grade']=='5' || $_SESSION['Grade']=='6')
	{
	$pdf->Cell(0,10,'ELEMENTARY LEVEL',0,1);
	$pdf->Cell(27,5,'GRADE LEVEL: ',0,0);
	
	if ($_SESSION['Grade']=='Kinder')
	{
	$pdf->Cell(0,5,strtoupper($_SESSION['Grade']),0,1);
	}else{
	$pdf->Cell(0,5,'GRADE '.strtoupper($_SESSION['Grade']),0,1);
	}
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(10,10,'#',1,0,'C');	
	$pdf->Cell(70,10,'NAME OF SCHOOL',1,0);	
	
	$pdf->Cell(18,10,'English',1,0,'C');
	$pdf->Cell(18,10,'Science',1,0,'C');
	$pdf->Cell(18,10,'Math',1,0,'C');
	$pdf->Cell(18,10,'Filipino',1,0,'C');
	$pdf->Cell(18,10,'Aral. Pan',1,0,'C');
	$pdf->Cell(18,10,'E.S.P',1,0,'C');
	$pdf->Cell(18,10,'EPP',1,0,'C');
	$pdf->Cell(18,10,'MAPEH',1,0,'C');
	$pdf->Cell(28,10,'Mother Tongue',1,0,'C');
	$pdf->Cell(28,10,'RO Thematic',1,0,'C');
	$pdf->Cell(28,10,'Project Rush',1,0,'C');
	$pdf->Cell(28,10,'Total',1,1,'C');
	
	$no=$ElemenTotal=0;
	$totEng=$totScie=$totMath=$totFil=$totAral=$totESP=$totMapeh=$totMT=$totRO=$totPR=$totSub=$totTLE=0;
	$elemenschool=mysqli_query($con,"SELECt * FROM tbl_elementary_subject INNER JOIN tbl_school ON tbl_elementary_subject.SchoolID = tbl_school.SchoolID  WHERE tbl_elementary_subject.GradeLevel='".$_SESSION['Grade']."' AND tbl_elementary_subject.WeekNo='".$_SESSION['week']."' AND tbl_elementary_subject.QuarterNo='".$_SESSION['quarter']."' GROUP BY tbl_elementary_subject.SchoolID");
		while($elemenrow=mysqli_fetch_array($elemenschool))
			{
				$no++;
				$ElemenTotal=$elemenrow['English']+$elemenrow['Science']+$elemenrow['Math']+$elemenrow['Filipino']+$elemenrow['AralPan']+$elemenrow['ESP']+$elemenrow['TLE']+$elemenrow['MAPEH']+$elemenrow['Mother_tongue']+$elemenrow['RO_Thematic']+$elemenrow['Project_Rush'];
				$pdf->Cell(10,5,$no,1,0,'C');	
				$pdf->Cell(70,5,$elemenrow['SchoolName'],1,0);	
				$pdf->Cell(18,5,$elemenrow['English'],1,0,'C');
				$pdf->Cell(18,5,$elemenrow['Science'],1,0,'C');
				$pdf->Cell(18,5,$elemenrow['Math'],1,0,'C');
				$pdf->Cell(18,5,$elemenrow['Filipino'],1,0,'C');
				$pdf->Cell(18,5,$elemenrow['AralPan'],1,0,'C');
				$pdf->Cell(18,5,$elemenrow['ESP'],1,0,'C');
				$pdf->Cell(18,5,$elemenrow['TLE'],1,0,'C');
				$pdf->Cell(18,5,$elemenrow['MAPEH'],1,0,'C');
				$pdf->Cell(28,5,$elemenrow['Mother_tongue'],1,0,'C');
				$pdf->Cell(28,5,$elemenrow['RO_Thematic'],1,0,'C');
				$pdf->Cell(28,5,$elemenrow['Project_Rush'],1,0,'C');
				$pdf->Cell(28,5,number_format($ElemenTotal,1),1,1,'C');						      
			}
			$totEng=$totEng+$elemenrow['English'];
			$totScie=$totScie+$elemenrow['Science'];
			$totMath=$totMath+$elemenrow['Math'];
			$totFil=$totFil+$elemenrow['Filipino'];
			$totAral=$totAral+$elemenrow['AralPan'];	
			$totESP=$totESP+$elemenrow['ESP'];
			$totTLE=$totTLE+$elemenrow['TLE'];
			$totMapeh=$totMapeh+$elemenrow['MAPEH'];	
			$totMT	=$totMT+$elemenrow['Mother_tongue'];
			$totRO=$totRO+$elemenrow['RO_Thematic'];
			$totPR=$totPR+$elemenrow['Project_Rush'];
			$totSub	=$totSub+$ElemenTotal;						
			
				
				$pdf->Cell(80,5,"Total",1,0,'C');	
				$pdf->Cell(18,5,$totEng,1,0,'C');
				$pdf->Cell(18,5,$totScie,1,0,'C');
				$pdf->Cell(18,5,$totMath,1,0,'C');
				$pdf->Cell(18,5,$totFil,1,0,'C');
				$pdf->Cell(18,5,$totAral,1,0,'C');
				$pdf->Cell(18,5,$totESP,1,0,'C');
				$pdf->Cell(18,5,$totTLE,1,0,'C');
				$pdf->Cell(18,5,$totMapeh,1,0,'C');
				$pdf->Cell(28,5,$totMT,1,0,'C');
				$pdf->Cell(28,5,$totRO,1,0,'C');
				$pdf->Cell(28,5,$totPR,1,0,'C');
				$pdf->Cell(28,5,number_format($totSub,1),1,1,'C');		
	
	
	
	
	
	
	}elseif ($_SESSION['Grade']=='7' || $_SESSION['Grade']=='8' || $_SESSION['Grade']=='9' || $_SESSION['Grade']=='10')
	{
	$pdf->Cell(0,10,'JUNIOR HIGH SCHOOL LEVEL',0,1);
	$pdf->Cell(27,5,'GRADE LEVEL: ',0,0);
	$pdf->Cell(0,5,'GRADE '.strtoupper($_SESSION['Grade']),0,1);
		
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(10,10,'#',1,0,'C');	
	$pdf->Cell(70,10,'NAME OF SCHOOL',1,0);	
	$pdf->Cell(15,10,'English',1,0,'C');
	$pdf->Cell(15,10,'Science',1,0,'C');
	$pdf->Cell(15,10,'Math',1,0,'C');
	$pdf->Cell(15,10,'Filipino',1,0,'C');
	$pdf->Cell(15,10,'Aral. Pan',1,0,'C');
	$pdf->Cell(15,10,'E.S.P',1,0,'C');
	$pdf->Cell(15,10,'T.L.E',1,0,'C');
	$pdf->Cell(15,10,'Music',1,0,'C');
	$pdf->Cell(15,10,'Arts',1,0,'C');
	$pdf->Cell(15,10,'P.E',1,0,'C');
	$pdf->Cell(15,10,'Health',1,0,'C');
	$pdf->Cell(22,10,'RO Thematic',1,0,'C');
	$pdf->Cell(17,10,'Elective 1',1,0,'C');
	$pdf->Cell(17,10,'Elective 2',1,0,'C');
	$pdf->Cell(17,10,'Elective 3',1,0,'C');
	$pdf->Cell(17,10,'Total',1,1,'C');
	
	$no=$SecondTotal=0;
	$totElec1=$totElec2=$totElec3=$totEng=$totScie=$totMath=$totFil=$totAral=$totESP=$totMapeh=$totArts=$totPE=$totHealth=$totSub=$totTLE=$totRO=0;
									
		$secondschool=mysqli_query($con,"SELECt * FROM tbl_secondary_subject INNER JOIN tbl_school ON tbl_secondary_subject.SchoolID = tbl_school.SchoolID  WHERE tbl_secondary_subject.GradeLevel='".$_SESSION['Grade']."' AND WeekNo='".$_SESSION['week']."' AND QuarterNo='".$_SESSION['quarter']."' GROUP BY tbl_secondary_subject.SchoolID");
									
			while($secondrow=mysqli_fetch_array($secondschool))
				{
					$no++;
					$SecondTotal=$secondrow['English']+$secondrow['Science']+$secondrow['Math']+$secondrow['Filipino']+$secondrow['AralPan']+$secondrow['ESP']+$secondrow['TLE']+$secondrow['Music']+$secondrow['Arts']+$secondrow['PE']+$secondrow['Health']+$secondrow['RO_Thematic']+$secondrow['Elective1']+$secondrow['Elective2']+$secondrow['Elective3'];
				
				$pdf->Cell(10,5,$no,1,0,'C');	
				$pdf->Cell(70,5,$secondrow['SchoolName'],1,0);	
				$pdf->Cell(15,5,$secondrow['English'],1,0,'C');
				$pdf->Cell(15,5,$secondrow['Science'],1,0,'C');
				$pdf->Cell(15,5,$secondrow['Math'],1,0,'C');
				$pdf->Cell(15,5,$secondrow['Filipino'],1,0,'C');
				$pdf->Cell(15,5,$secondrow['AralPan'],1,0,'C');
				$pdf->Cell(15,5,$secondrow['ESP'],1,0,'C');
				$pdf->Cell(15,5,$secondrow['TLE'],1,0,'C');
				$pdf->Cell(15,5,$secondrow['Music'],1,0,'C');
				$pdf->Cell(15,5,$secondrow['Arts'],1,0,'C');
				$pdf->Cell(15,5,$secondrow['PE'],1,0,'C');
				$pdf->Cell(15,5,$secondrow['Health'],1,0,'C');
				$pdf->Cell(22,5,$secondrow['RO_Thematic'],1,0,'C');
				$pdf->Cell(17,5,$secondrow['Elective1'],1,0,'C');
				$pdf->Cell(17,5,$secondrow['Elective2'],1,0,'C');
				$pdf->Cell(17,5,$secondrow['Elective3'],1,0,'C');
				$pdf->Cell(17,5,number_format($SecondTotal,1),1,1,'C');
				
				
				
				}
	
	$totEng=$totEng+$secondrow['English'];
	$totScie=$totScie+$secondrow['Science'];
	$totMath=$totMath+$secondrow['Math'];
	$totFil=$totFil+$secondrow['Filipino'];
	$totAral=$totAral+$secondrow['AralPan'];	
    $totESP=$totESP+$secondrow['ESP'];
	$totTLE=$totTLE+$secondrow['TLE'];
	$totMapeh=$totMapeh+$secondrow['Music'];	
	$totArts=$totArts+$secondrow['Arts'];
	$totPE=$totPE+$secondrow['PE'];
	$totHealth=$totHealth+$secondrow['Health'];
	$totRO=$totRO+$secondrow['RO_Thematic'];
	$totElec1=$totElec1+$secondrow['Elective1'];
	$totElec2=$totElec2+$secondrow['Elective2'];
	$totElec3=$totElec3+$secondrow['Elective3'];
	$totSub	=$totSub+$SecondTotal;
	

	$pdf->Cell(80,5,'TOTAL',1,0);	
	$pdf->Cell(15,5,$totEng,1,0,'C');
	$pdf->Cell(15,5,$totScie,1,0,'C');
	$pdf->Cell(15,5,$totMath,1,0,'C');
	$pdf->Cell(15,5,$totFil,1,0,'C');
	$pdf->Cell(15,5,$totAral,1,0,'C');
	$pdf->Cell(15,5, $totESP,1,0,'C');
	$pdf->Cell(15,5,$totTLE,1,0,'C');
	$pdf->Cell(15,5,$totMapeh,1,0,'C');
	$pdf->Cell(15,5,$totArts,1,0,'C');
	$pdf->Cell(15,5,$totPE,1,0,'C');
	$pdf->Cell(15,5,$totHealth,1,0,'C');
	$pdf->Cell(22,5,$totRO,1,0,'C');
	$pdf->Cell(17,5,$totElec1,1,0,'C');
	$pdf->Cell(17,5,$totElec2,1,0,'C');
	$pdf->Cell(17,5,$totElec3,1,0,'C');
	$pdf->Cell(17,5,$totSub,1,1,'C');
	
	
	
	}elseif ($_SESSION['Grade']=='11' || $_SESSION['Grade']=='12')
	{
		
	$myschool=mysqli_query($con,"SELECT * FROM tbl_qualification WHERE tbl_qualification.SpCode='".$_SESSION['SpCode']."' LIMIT 1");
	$rowschool=mysqli_fetch_assoc($myschool);
	$pdf->Cell(0,10,'SENIOR HIGH SCHOOL LEVEL',0,1);
	$pdf->Cell(27,5,'GRADE LEVEL: ',0,0);
	$pdf->Cell(0,5,'GRADE '.strtoupper($_SESSION['Grade']),0,1);
	$pdf->Cell(0,5,'QUALIFICATION : '.strtoupper($rowschool['Description']),0,1);
	$pdf->Cell(0,5,'STRAND: '.strtoupper($rowschool['Strand']),0,1);
	$pdf->Cell(0,10,'',0,1);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(15,10,'#',1,0,'C');	
	$pdf->Cell(120,10,'NAME OF SCHOOL',1,0);	
	$pdf->Cell(30,10,'# OF LEARNER',1,0,'C');	
	$pdf->Cell(30,10,'# OF MODULE',1,1,'C');	
	
				$TotalSubLearner=$TotalSubModules=$no=0;
				$mydata=mysqli_query($con,"SELECT * FROM tbl_qualification_by_school INNER JOIN tbl_qualification ON tbl_qualification_by_school.QualCode = tbl_qualification.SpCode INNER JOIN tbl_school ON tbl_qualification_by_school.SchoolID = tbl_school.SchoolID  WHERE tbl_qualification.Strand='".$rowschool['Strand']."' AND tbl_qualification.Grade='".$_SESSION['Grade']."' AND tbl_qualification_by_school.QualCode ='".$_SESSION['SpCode']."'");
					while($rowschooldata=mysqli_fetch_array($mydata))
						{
							$no++;
							$myLearner=$mymodule=0;
							$mydatabyschool=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode = tbl_senior_sub_strand.StrandsubCode  WHERE tbl_shs_report.SpecCode='".$rowschooldata['SpCode']."' AND tbl_shs_report.QuarterNo='".$_SESSION['quarter']."' AND tbl_shs_report.WeekNo='".$_SESSION['week']."' AND tbl_shs_report.SchoolID='".$rowschooldata['SchoolID']."'");
							while($datarow=mysqli_fetch_array($mydatabyschool))
							{
								$myLearner=$myLearner+$datarow['No_of_learner'];
								$mymodule=$mymodule+$datarow['No_of_copies'];
							}
							
							$TotalSubLearner=$TotalSubLearner+$myLearner;
							$TotalSubModules=$TotalSubModules+$mymodule;
							
						$pdf->Cell(15,5,$no,1,0,'C');	
						$pdf->Cell(120,5,$rowschooldata['SchoolName'],1,0);	
						$pdf->Cell(30,5,number_format($myLearner,2),1,0,'C');	
						$pdf->Cell(30,5,number_format($mymodule,2),1,1,'C');
					}
						$pdf->Cell(135,5,'TOTAL:',1,0,'C');	
						$pdf->Cell(30,5,number_format($TotalSubLearner,2),1,0,'C');	
						$pdf->Cell(30,5,number_format($TotalSubModules,2),1,1,'C');
					
	}
	
	
	
	
	

	$pdf->Cell(0,5,"",0,1);
	$pdf->Cell(0,10,"Prepared by:",0,1);
	$pdf->Cell(30,5,"",0,0,'C');
	$pdf->Cell(40,5,$_SESSION['prepared'],0,1,'C');
	
		
	//Display the Output data
	$pdf->Output();
?>
<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
ini_set('upload_max_filesize', '50M');
ini_set('post_max_size', '50M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 300);
ini_set('memory_limit', '1024M');
header('content-type:text/html;charset=utf-8');
require("../pcdmis/fpdf.php"); 

$img1='../pcdmis/shs/h1.png';	
$img2='../pcdmis/logo/logo.png';	

if ($_SESSION['Grade']=='11' ||$_SESSION['Grade']=='12')
{	
if ($_SESSION['Sem']=='First Semester')
{
  $repre=mysqli_query($con,"SELECT * FROM first_semester Inner Join tbl_student ON tbl_student.lrn = first_semester.lrn INNER JOIN tbl_qualification ON first_semester.SpCode = tbl_qualification.SpCode INNER JOIN tbl_section ON first_semester.SecCode =tbl_section.SecCode WHERE first_semester.school_year =  '".$_SESSION['year']."' AND tbl_section.SchoolID='".$_SESSION['SchoolID']."'");	
}elseif ($_SESSION['Sem']=='Second Semester')
{
	$repre=mysqli_query($con,"SELECT * FROM second_semester Inner Join tbl_student ON tbl_student.lrn = second_semester.lrn INNER JOIN tbl_qualification ON second_semester.SpCode = tbl_qualification.SpCode INNER JOIN tbl_section ON second_semester.SecCode =tbl_section.SecCode WHERE second_semester.school_year =  '".$_SESSION['year']."' AND tbl_section.SchoolID='".$_SESSION['SchoolID']."'");
}
}else{
	$repre=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn =tbl_student.lrn INNER JOIN tbl_section ON tbl_learners.SecCode =tbl_section.SecCode  WHERE  tbl_section.SchoolID='".$_SESSION['SchoolID']."' AND tbl_learners.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' ORDER BY tbl_student.Lname Asc");	
					
}
$data=mysqli_fetch_assoc($repre);	
$img3=$data['Picture'];	

//Send data to PDF
		$sem="Semester: ".$_SESSION['Sem'];
		$sy="School Year: ".$_SESSION['sy'];
		
		$name='Name: '.$data['Lname'].', '.$data['FName'].' '.$data['MName'];
		$Section="Grade & Section: ".$data['Grade'].' '.$data['SecDesc'];
		if ($_SESSION['Grade']=='11' ||$_SESSION['Grade']=='12')
		{
		$program="Specialization: ".$data['Description'];
		}
		

 	//New PDF File		 
		$pdf =new FPDF();
	
	//Add New Page
		$pdf->AddPage();
	//Set Font  10	
		$pdf->SetFont('Arial','B',8);
	// Logo
	$pdf->Image($img1,165,10,20);
	$pdf->Image($img2,20,10,20);
	//$pdf->Image($img3,165,50,30);
	//Data
	$pdf->Cell(0,5,'Republic of the Philippines',0,1,'C');
	$pdf->Cell(0,5,'DEPARTMENT OF EDUCATION',0,1,'C');
	$pdf->Cell(0,5,'Division of Pagadian City',0,1,'C');
	$pdf->Cell(0,5,strtoupper($_SESSION['SchoolName']),0,1,'C');
	$pdf->Cell(0,5,strtoupper($_SESSION['SchoolAddress']),0,1,'C');
	$pdf->Cell(0,0,'',1,1,'C');
	$pdf->Cell(0,5,'',0,1,'C');
	
	if ($_SESSION['Grade']==11 || $_SESSION['Grade']==12)
	{
	$subject=mysqli_query($con,"SELECT * FROM tbl_senior_sub_strand INNER JOIN class_program ON tbl_senior_sub_strand.StrandsubCode = class_program.SubNo WHERE tbl_senior_sub_strand.StrandsubCode='".$_SESSION['SubCode']."' AND class_program.SchoolID ='".$_SESSION['SchoolID']."' LIMIT 1");
	}elseif ($_SESSION['Grade']>=7 AND $_SESSION['Grade']<=10){
	$subject=mysqli_query($con,"SELECT * FROM tbl_jhs_subject INNER JOIN class_program ON tbl_jhs_subject.SubNo = class_program.SubNo WHERE tbl_jhs_subject.SubNo='".$_SESSION['SubCode']."' AND class_program.SchoolID ='".$_SESSION['SchoolID']."'LIMIT 1");
	}else{
											 
		$subject=mysqli_query($con,"SELECT * FROM tbl_element_subject INNER JOIN class_program ON tbl_element_subject.SubNo = class_program.SubNo WHERE tbl_element_subject.SubNo='".$_SESSION['SubCode']."' AND class_program.SchoolID ='".$_SESSION['SchoolID']."' LIMIT 1");
	}
	$rowdata=mysqli_fetch_assoc($subject);	
		//Get the time and day
		$load=mysqli_query($con,"SELECT * FROM tbl_subject_load INNER JOIN tbl_section ON tbl_subject_load.SecCode=tbl_section.SecCode WHERE tbl_subject_load.Emp_ID='".$_SESSION['EmpID']."' AND tbl_subject_load.School_Year='".$_SESSION['year']."'  AND tbl_subject_load.GradeLevel='".$_SESSION['Grade']."' AND tbl_subject_load.SubCode='".$_SESSION['SubCode']."' AND tbl_subject_load.SecCode ='".$_SESSION['SecCode']."'LIMIT 1");

		$rowsubject=mysqli_fetch_assoc($load);	
		if ($_SESSION['Grade']=='Kinder')
		{
			$grade=	$_SESSION['Grade'];
		}else{
			$grade=	'GRADE '.$_SESSION['Grade'];
		}
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(40,5,'LEARNING AREAS: ',0,0);	
	$pdf->Cell(0,5,$rowdata['LearningAreas'].' '.$_SESSION['Grade'],0,1);	
	$pdf->Cell(40,5,'TIME & DAY : ',0,0);	
	$pdf->Cell(0,5,$rowdata['SecTime'].' '.$rowdata['SecDay'],0,1);	
	$pdf->Cell(40,5,'GRADE & SECTION: ',0,0);	
	$pdf->Cell(0,5,$grade.' - '.$rowsubject['SecDesc'],0,1);	
	$pdf->Cell(40,5,'SUBJECT TEACHER: ',0,0);	
	$pdf->Cell(0,5, $_SESSION['TeacherName'],0,1);	
	$pdf->Cell(40,5,'ACTIVITY: ',0,0);	
	$pdf->Cell(0,5,strtoupper($_SESSION['ActType']),0,1);	
	
	
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->Cell(10,10,'#',1,0,'C');	
	$pdf->Cell(50,10,'DATE/TIME SUBMITTED',1,0,'C');	
	$pdf->Cell(100,10,'LEARNER\'S NAME',1,0,'C');	
	$pdf->Cell(30,10,'SCORE/ITEM',1,1,'C');	
	
	$no=0;
			if ($_SESSION['Grade']=='11' || $_SESSION['Grade']=='12')
							{
								if ($_SESSION['Sem']=='First Semester')
								{
									$myinfo=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn=tbl_student.lrn INNER JOIN tbl_school ON first_semester.SchoolID = tbl_school.SchoolID WHERE first_semester.school_year='".$_SESSION['year']."' AND first_semester.SecCode='".$_SESSION['SecCode']."' AND first_semester.Grade='".$_SESSION['Grade']."' AND first_semester.SchoolID='".$_SESSION['SchoolID']."' GROUP BY tbl_student.lrn ORDER BY Lname Asc");
									
								}elseif ($_SESSION['Sem']=='Second Semester')
								{
									$myinfo=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn=tbl_student.lrn INNER JOIN tbl_school ON second_semester.SchoolID = tbl_school.SchoolID WHERE second_semester.school_year='".$_SESSION['year']."' AND second_semester.SecCode='".$_SESSION['SecCode']."' AND second_semester.Grade='".$_SESSION['Grade']."' AND second_semester.SchoolID='".$_SESSION['SchoolID']."' GROUP BY tbl_student.lrn ORDER BY Lname Asc");
								}
							}else{
								$myinfo=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn=tbl_student.lrn INNER JOIN tbl_school ON tbl_learners.SchoolID = tbl_school.SchoolID INNER JOIN tbl_registration ON tbl_learners.lrn=tbl_registration.lrn WHERE tbl_learners.school_year='".$_SESSION['year']."' AND tbl_learners.SecCode='".$_SESSION['SecCode']."' AND tbl_registration.Grade='".$_SESSION['Grade']."' AND tbl_learners.SchoolID='".$_SESSION['SchoolID']."' GROUP BY tbl_student.lrn");

							}	
								
									$no=0;
									while($row=mysqli_fetch_array($myinfo))
									{
										$no++;
										$myscore=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score WHERE tbl_activity_learner_score.SubCode='".$_SESSION['SubCode']."' AND tbl_activity_learner_score.lrn='".$row['lrn']."' AND tbl_activity_learner_score.Activity_Code='".$_SESSION['ActivityCode']."' LIMIT 1");
										$rowscore=mysqli_fetch_assoc($myscore);
										
										$Middle=mb_strimwidth($row['MName'],0,1);
										$pdf->Cell(10,5,$no,1,0,'C');
										//$pdf->Cell(50,5,$dateanswer['Date_answer'],1,0,'C');
										$pdf->Cell(100,5,$row['FName'].' '.$Middle.'. '.$row['Lname'],1,0);
										$pdf->Cell(30,5,$rowscore['Score'],1,1,'C');
										$Middle="";
									
												
							         }
	
		
			
			
			
			
			
			
			$pdf->Cell(0,5,'********************************NOTHING FOLLOWS**********************************',1,1,'C');
			
			$pdf->Cell(0,10,'',0,1,'C');
			$pdf->Cell(0,10,'Prepared by: ',0,1);	
			
			$pdf->Cell(30,5,'',0,0,'C');	
			$pdf->Cell(30,5,$_SESSION['TeacherName'],0,1,'C');	
			$pdf->Cell(30,5,'',0,0,'C');	
			$pdf->Cell(30,5,"Subject Teacher",0,1,'C');	
		//Display the Output data
	$pdf->Output();
?>
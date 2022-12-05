<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
header('content-type:text/html;charset=utf-8');
require("../pcdmis/fpdf.php"); 

$img1='../pcdmis/shs/h1.png';	
$img2='../pcdmis/logo/logo.png';	

if ($_SESSION['Grade']=='11' ||$_SESSION['Grade']=='12')
{	
if ($_SESSION['Sem']=='First Semester')
{
  $repre=mysqli_query($con,"SELECT * FROM first_semester Inner Join tbl_student ON tbl_student.lrn = first_semester.lrn INNER JOIN tbl_qualification ON first_semester.SpCode = tbl_qualification.SpCode INNER JOIN tbl_section ON first_semester.SecCode =tbl_section.SecCode WHERE first_semester.school_year =  '".$_SESSION['year']."' AND  first_semester.lrn='".$_SESSION['lrn']."'");	
}elseif ($_SESSION['Sem']=='Second Semester')
{
	$repre=mysqli_query($con,"SELECT * FROM second_semester Inner Join tbl_student ON tbl_student.lrn = second_semester.lrn INNER JOIN tbl_qualification ON second_semester.SpCode = tbl_qualification.SpCode INNER JOIN tbl_section ON second_semester.SecCode =tbl_section.SecCode WHERE second_semester.school_year =  '".$_SESSION['year']."' AND  second_semester.lrn='".$_SESSION['lrn']."'");
}
}else{
	$repre=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn =tbl_student.lrn INNER JOIN tbl_section ON tbl_learners.SecCode =tbl_section.SecCode  WHERE tbl_learners.lrn = '".$_SESSION['lrn']."' AND tbl_section.SchoolID='".$_SESSION['school_id']."' AND tbl_learners.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND tbl_student.lrn ='".$_SESSION['lrn']."' ORDER BY tbl_student.Lname Asc");	
					
}
$data=mysqli_fetch_assoc($repre);	
$img3=$data['Picture'];	

//Send data to PDF
		$sem="Semester: ".$_SESSION['Sem'];
		$sy="School Year: ".$_SESSION['sy'];
		$lrn="LRN: ".$_SESSION['lrn'];
		$name='Name: '.$data['Lname'].', '.$data['FName'].' '.$data['MName'];
		$Section="Grade & Section: ".$data['Grade'].' '.$data['SecDesc'];
		if ($_SESSION['Grade']=='11' ||$_SESSION['Grade']=='12')
		{
		$program="Specialization: ".$data['Description'];
		}
		//Set Class Adviser
		$red=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_section ON tbl_section.Emp_ID=tbl_employee.Emp_ID WHERE tbl_section.SecCode =  '".$data['SecCode']."' ORDER BY tbl_section.Emp_ID");
        $rteach=mysqli_fetch_assoc($red); 
        //Signature
		//Prepared by Class Adviser
		$pre="Prepared by:";
		$addvic=$rteach['Emp_LName'].' '.$rteach['Emp_FName'].' '.$rteach['Emp_MName'];		
		$add="Class Adviser";
		//LIS Coordinator
		$lis3="Check by:";
		$lis1="_________________";
		$lis2="LIS Coordinator";
		
		//Noted by
		$not="Noted by:";
		$eva="__________________";
		$nme="School Registrar";
		//Approved by
		$App="Approved by:";
		$AUG="___________________ ";
		$prin="Secondary School Principal";

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
	$pdf->Cell(0,2,'',0,1,'C');
	
		
		//Heading
		$pdf->Cell(0,5,'STUDENT STUDYLOAD',0,1,'C');
		$pdf->Cell(0,5,$sem,0,1,'C');
		$pdf->Cell(0,5,$sy,0,1,'C');
		$pdf->Cell(0,10,"",0,1,'C');
		$pdf->Cell(0,5,$lrn,0,1);
		$pdf->Cell(0,5,$name,0,1);
		$pdf->Cell(0,5,$Section,0,1);
		if ($_SESSION['Grade']=='11' ||$_SESSION['Grade']=='12')
		{
		$pdf->Cell(0,5,$program,0,1);
		}	
		//Set Header Data
			$pdf->Cell(10,10,'#',1,0,'C');  
			$pdf->Cell(90,10,'Learner Areas',1);  
			$pdf->Cell(20,10,'Time',1,0,'C');  
			$pdf->Cell(20,10,'Day',1,0,'C');  
			$pdf->Cell(20,10,'Room',1,0,'C');  
			$pdf->Cell(35,10,'Teacher',1,1,'C');  
			
		//SQL Query data
		if ($_SESSION['Grade']==11 || $_SESSION['Grade']==12)
			{
				$mysubject=mysqli_query($con,"SELECT * FROM tbl_shs_tor INNER JOIN tbl_senior_sub_strand ON tbl_shs_tor.SubNo = tbl_senior_sub_strand.StrandsubCode INNER JOIN class_program on tbl_shs_tor.SubNo = class_program.SubNo INNER JOIN tbl_section ON tbl_shs_tor.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID =tbl_employee.Emp_ID WHERE tbl_shs_tor.lrn='".$_SESSION['lrn']."' AND tbl_shs_tor.SemCode='".$_SESSION['Sem']."' AND tbl_shs_tor.SYCode='".$_SESSION['year']."' AND class_program.Semester='".$_SESSION['Sem']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['school_id']."' AND tbl_shs_tor.SecCode='".$_SESSION['SecCode']."' AND tbl_shs_tor.GradeNo='".$_SESSION['Grade']."' GROUP BY class_program.SubNo");
			}
			elseif ($_SESSION['Grade']>=7 AND $_SESSION['Grade']<=10){
				$mysubject=mysqli_query($con,"SELECT * FROM junior_tor INNER JOIN class_program on junior_tor.SubNo = class_program.SubNo INNER JOIN tbl_jhs_subject ON junior_tor.SubNo = tbl_jhs_subject.SubNo INNER JOIN tbl_section ON junior_tor.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID =tbl_employee.Emp_ID WHERE junior_tor.lrn='".$_SESSION['lrn']."'  AND junior_tor.SYCode='".$_SESSION['year']."'  AND junior_tor.SecCode='".$_SESSION['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['school_id']."' AND junior_tor.GradeNo='".$_SESSION['Grade']."' GROUP BY class_program.SubNo");
			}
			elseif ($_SESSION['Grade']>=1 AND $_SESSION['Grade']<=6){
				$mysubject=mysqli_query($con,"SELECT * FROM junior_tor INNER JOIN class_program on junior_tor.SubNo = class_program.SubNo INNER JOIN tbl_element_subject ON junior_tor.SubNo = tbl_element_subject.SubNo INNER JOIN tbl_section ON junior_tor.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID =tbl_employee.Emp_ID WHERE junior_tor.lrn='".$_SESSION['lrn']."'  AND junior_tor.SYCode='".$_SESSION['year']."'  AND junior_tor.SecCode='".$_SESSION['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['school_id']."' AND junior_tor.GradeNo='".$_SESSION['Grade']."' GROUP BY class_program.SubNo");
			}
		//Record Found
		$tot="No. of record found: ".mysqli_num_rows($mysubject);	
		
		
		$no=0;
		//Loop Data and Send to PDF File
		while($row=mysqli_fetch_array($mysubject))
		{
			$no++;
			
			$teacher=$row['Emp_LName'];
			$pdf->Cell(10,6,$no,1,0,'C');  
			$pdf->Cell(90,6,$row['LearningAreas'],1,0);  
			$pdf->Cell(20,6,$row['SecTime'],1,0,'C');  
			$pdf->Cell(20,6,$row['SecDay'],1,0,'C');  
			$pdf->Cell(20,6,$data['SecDesc'],1,0,'C');  
			$pdf->Cell(35,6,$teacher,1,1);  
		}
		$pdf->Cell(40,6,$tot,0,1); 
		//Prepared by:
		$pdf->Cell(0,15,$pre,0,1); 
		$pdf->Cell(0,4,$addvic,0,1); 
		$pdf->Cell(0,5,$add,0,1); 
		
		//LIS Coordinator
		$pdf->Cell(0,15,$lis3,0,1); 
		$pdf->Cell(0,5,$lis1,0,1); 
		$pdf->Cell(0,5,$lis2,0,1); 
		
		//Noted by:
		$pdf->Cell(0,15,$not,0,1); 
		$pdf->Cell(0,4,$eva,0,1); 
		$pdf->Cell(0,5,$nme,0,1); 
		
		//Approved by:
		$pdf->Cell(0,15,$App,0,1); 
		$pdf->Cell(0,4,$AUG,0,1); 
		$pdf->Cell(0,5,$prin,0,1); 
		
		//Display the Output data
	$pdf->Output();
?>
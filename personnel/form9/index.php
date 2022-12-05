<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
header('content-type:text/html;charset=utf-8');
require("../../pcdmis/code128.php"); 


//Logo Pic
	$img1=$_SESSION['schoolLogo'];
	$img2='../../pcdmis/logo/logo.png';	
	$img3='../../pcdmis/logo/school_days.png';	
	$img4='../../pcdmis/logo/values.png';	
	$img5='../../pcdmis/logo/signature.png';	

//New PDF File		 
	$pdf=new PDF_Code128('L','mm','A4');
	
	
	//Add New Page
		$pdf->AddPage();
	//Set Font  10	
		$pdf->SetFont('Arial','B',8);
		$pdf->Image($img1,250,20,20);
		$pdf->Image($img2,155,20,20);
		$pdf->Image($img3,10,28,125);

		$total1=$total=0;
		
		//Number of days of students
		$day_pres=mysqli_query($con,"SELECT * FROM tbl_days_present WHERE LRN ='".$_SESSION['lrn']."' AND School_Year='".$_SESSION['year']."' LIMIT 1");
		$data3=mysqli_fetch_assoc($day_pres);
		$total1=$data3['Jun']+$data3['Jul']+$data3['Aug']+$data3['Sept']+$data3['Oct']+$data3['Nov']+$data3['Dece']+$data3['Jan']+$data3['Feb']+$data3['Mar']+$data3['April'];
		
	
		//Number of days in school
		$result_day=mysqli_query($con,"SELECT * FROM tbl_school_days WHERE School_Year ='".$_SESSION['year']."'")or die ("Error Number of School Days");
		$day=mysqli_fetch_assoc($result_day);
		$total=$day['Jun']+$day['Jul']+$day['Aug']+$day['Sept']+$day['Oct']+$day['Nov']+$day['Dec']+$day['Jan']+$day['Feb']+$day['Mar']+$day['April'];
	    
		$day1=$day['Jun']-$data3['Jun'];
	    $day2=$day['Jul']-$data3['Jul'];
	    $day3=$day['Aug']-$data3['Aug'];
	    $day4=$day['Sept']-$data3['Sept'];
	    $day5=$day['Oct']-$data3['Oct'];
	    $day6=$day['Nov']-$data3['Nov'];
	    $day7=$day['Dec']-$data3['Dece'];
	    $day8=$day['Jan']-$data3['Jan'];
	    $day9=$day['Feb']-$data3['Feb'];
	    $day10=$day['Mar']-$data3['Mar'];
	    $day11=$day['April']-$data3['April'];
		$total11=$total-$total1;
	
	
	//Set Font  10	
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(140,5,'',0,0,'C');
		$pdf->Cell(40,5,'DepEd FORM 9',1,1,'C');
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(0,3,'',0,1,'C');
		$pdf->Cell(127,5,'REPORT ON ATTENDANCE',0,0,'C');
		$pdf->Cell(150,5,'Republic of the Philippines',0,1,'C');
		$pdf->Cell(127,5,'',0,0,'C');
		$pdf->Cell(150,5,'Department of Education',0,1,'C');
		$pdf->Cell(127,5,'',0,0,'C');
		$pdf->Cell(150,5,'Region IX, Zamboanga Peninsula',0,1,'C');
		$pdf->Cell(127,5,'',0,0,'C');
		$pdf->Cell(150,5,'Pagadian City Division',0,1,'C');
		$pdf->Cell(0,3,'',0,1,'C');
		$pdf->Cell(17,5,'',0,0,'C');
		$pdf->Cell(9,5,$day['Jun'],0,0,'C');
		$pdf->Cell(9,5,$day['Jul'],0,0,'C');
		$pdf->Cell(8,5,$day['Aug'],0,0,'C');
		$pdf->Cell(8,5,$day['Sept'],0,0,'C');
		$pdf->Cell(9,5,$day['Oct'],0,0,'C');
		$pdf->Cell(8,5,$day['Nov'],0,0,'C');
		$pdf->Cell(8,5,$day['Dec'],0,0,'C');
		$pdf->Cell(8,5,$day['Jan'],0,0,'C');
		$pdf->Cell(8,5,$day['Feb'],0,0,'C');
		$pdf->Cell(9,5,$day['Mar'],0,0,'C');
		$pdf->Cell(7,5,$day['April'],0,0,'C');
		$pdf->Cell(15,5,$total,0,0,'C');
		$pdf->Cell(10,5,"",0,0,'C');
		
		$pdf->Cell(120,5,strtoupper($_SESSION['SchoolName']),0,1,'C');
		$pdf->Cell(127,5,'',0,0,'C');
		$pdf->Cell(150,5,strtoupper($_SESSION['SchoolAddress']),0,1,'C');
		$pdf->Cell(0,5,'',0,1,'C');
		$pdf->Cell(17,5,'',0,0,'C');
		$pdf->Cell(9,5,$data3['Jun'],0,0,'C');
		$pdf->Cell(9,5,$data3['Jul'],0,0,'C');
		$pdf->Cell(8,5,$data3['Aug'],0,0,'C');
		$pdf->Cell(8,5,$data3['Sept'],0,0,'C');
		$pdf->Cell(9,5,$data3['Oct'],0,0,'C');
		$pdf->Cell(8,5,$data3['Nov'],0,0,'C');
		$pdf->Cell(8,5,$data3['Dece'],0,0,'C');
		$pdf->Cell(8,5,$data3['Jan'],0,0,'C');
		$pdf->Cell(8,5,$data3['Feb'],0,0,'C');
		$pdf->Cell(9,5,$data3['Mar'],0,0,'C');
		$pdf->Cell(7,5,$data3['April'],0,0,'C');
		$pdf->Cell(15,5,$total1,0,0,'C');
		$pdf->Cell(10,5,"",0,0,'C');
		$pdf->Cell(115,5,'LRN:',0,0,'R');
		$pdf->SetFont('Arial','U',11);
		$pdf->Cell(35,5,$_SESSION['lrn'],0,1,'L');
		
		//student name
		$studInfo=mysqli_query($con,"SELECT UCASE(Lname) AS Lname,UCASE(FName) AS FName,UCASE(MName) AS MName,UCASE(Gender) AS Gender  FROM tbl_student WHERE tbl_student.lrn ='".$_SESSION['lrn']."' LIMIT 1");
		$studFullName=mysqli_fetch_assoc($studInfo);
		$LastName=$studFullName['Lname'];
		$FirstName=$studFullName['FName'];
		$MiddleName=$studFullName['MName'];
		$FullName=$LastName.', '.$FirstName.' '.$MiddleName;
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(0,2,'',0,1,'C');
		$pdf->Cell(140,6,'',0,0,'C');
		$pdf->Cell(20,6,'Name:',0,0,'L');
		$pdf->SetFont('Arial','U',11);
		$pdf->Cell(115,6,$FullName,0,1,'L');
		
		//Next Data
		$pdf->SetFont('Arial','',11);
		
		$pdf->Cell(17,5,'',0,0,'C');
		$pdf->Cell(9,5,$day1,0,0,'C');
		$pdf->Cell(9,5,$day2,0,0,'C');
		$pdf->Cell(8,5,$day3,0,0,'C');
		$pdf->Cell(8,5,$day4,0,0,'C');
		$pdf->Cell(9,5,$day5,0,0,'C');
		$pdf->Cell(8,5,$day6,0,0,'C');
		$pdf->Cell(8,5,$day7,0,0,'C');
		$pdf->Cell(8,5,$day8,0,0,'C');
		$pdf->Cell(8,5,$day9,0,0,'C');
		$pdf->Cell(9,5,$day10,0,0,'C');
		$pdf->Cell(7,5,$day11,0,0,'C');
		$pdf->Cell(15,5,$total11,0,0,'C');
		$pdf->Cell(17,5,'',0,0,'C');
		$pdf->Cell(20,6,'Age:',0,0,'L');
		$pdf->SetFont('Arial','U',11);
		$pdf->Cell(55,6,"15",0,0,'L');
		$pdf->SetFont('Arial','',11);
		
		//Next Data
		$pdf->Cell(20,6,'Sex:',0,0,'L');
		$pdf->SetFont('Arial','U',11);
		$pdf->Cell(55,6,$studFullName['Gender'],0,1,'L');
		$pdf->SetFont('Arial','',11);
		
		//Next Data
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(140,6,'',0,0,'C');
		$pdf->Cell(20,6,'Grade:',0,0,'L');
		$pdf->SetFont('Arial','U',11);
		$pdf->Cell(55,6,$_SESSION['Grade_Level'],0,0,'L');
		$pdf->SetFont('Arial','',11);
		
		//Next Data
		$pdf->Cell(20,6,'Section:',0,0,'L');
		$pdf->SetFont('Arial','U',11);
		$pdf->Cell(55,6,$_SESSION['SecName'],0,1,'L');
		$pdf->SetFont('Arial','',11);
		
		//Next data
		$pdf->Cell(140,6,'',0,0,'C');
		$pdf->Cell(30,6,'School Year:',0,0,'L');
		$pdf->SetFont('Arial','U',11);
		$pdf->Cell(115,6,$_SESSION['sy'],0,1,'L');
		$pdf->SetFont('Arial','',11);
		//Next data
		$pdf->Cell(140,5,'',0,0,'C');
		$pdf->Cell(30,5,'Track/Strand:',0,0,'L');
		$pdf->SetFont('Arial','U',11);
		$pdf->Cell(115,5,"",0,1,'L');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(0,2,'',0,1,'C');
		$pdf->Cell(140,5,'',0,0,'C');
		$pdf->Cell(30,5,'Dear Parent:',0,1,'L');
		$pdf->Cell(0,1,'',0,1,'C');
		$pdf->Cell(140,5,'',0,0,'C');
		$pdf->Cell(135,5,' This report card shows the ability and progress your child has made in  ',0,1,'R'); 
        $pdf->Cell(140,5,'',0,0,'C');
		$pdf->Cell(145,5,'the different learning areas as well as his/her core values.',0,1,'L');
		$pdf->Cell(140,5,'',0,0,'C');
		$pdf->Cell(135,5,'The school welcomes you, should you desire to know more about your ',0,1,'R');
		$pdf->Cell(140,5,'',0,0,'C');
		$pdf->Cell(155,5,'childs progress.',0,1,'L');
	
		//Set Adviser
		$pdf->Cell(0,3,'',0,1,'C');
		$pdf->Cell(210,5,'PARENT/GUARDIANS SIGNATURE',0,0,'L');
		$pdf->Cell(50,5,$_SESSION['TeacherName'],0,1,'C');
		$pdf->Cell(210,5,'',10,0,'C');
		$pdf->Cell(50,5,'Adviser',0,1,'C');
		$myprincipal=mysqli_query($con,"SELECT * FROM tbl_school INNER JOIN tbl_employee ON tbl_school.Incharg_ID = tbl_employee.Emp_ID WHERE tbl_school.SchoolID='".$_SESSION['SchoolID']."' LIMIT 1");
		$rowprin=mysqli_fetch_assoc($myprincipal);
		$gdata=mb_strimwidth($rowprin['Emp_MName'],0,1);
		$Principal=$rowprin['Emp_FName'].' '.$gdata.'. '.$rowprin['Emp_LName'];
		//Principal
		$pdf->Cell(140,5,'1st Quarter: ____________________________________________',0,0,'L');
		//$pdf->Image($img5,153,126,30);
		$pdf->Cell(150,5,$Principal,0,1,'L');
		$pdf->Cell(143,5,'',0,0,'L');
		$pdf->Cell(150,5,'      Principal',0,1,'L');
		$pdf->Cell(140,5,'2nd Quarter: ____________________________________________',0,0,'L');
		$pdf->Cell(150,5,'Certificate of Transfer',0,1,'C');
		
		//Next Data
		$pdf->Cell(140,5,'',0,0,'C');
		$pdf->Cell(80,5,'Admitted to Grade: _______________',0,0,'L');
		$pdf->Cell(80,5,'Section: ______________',0,1,'L');
		$pdf->Cell(140,5,'3rd Quarter: ____________________________________________',0,0,'L');
		$pdf->Cell(150,5,'Eligibility for Admission to Grade: ______________________________',0,1,'L');
		$pdf->Cell(140,5,'',0,0,'L');
		$pdf->Cell(150,5,'Approved:',0,1,'L');
		$pdf->Cell(155,5,'4th Quarter: ____________________________________________',0,0,'L');
		$pdf->Cell(70,5,$Principal,0,0,'L');
		$pdf->Cell(50,5,$_SESSION['TeacherName'],0,1,'C');
		$pdf->Cell(145,5,'',0,0,'L');
		$pdf->Cell(55,5,'Principal',0,0,'C');
		$pdf->Cell(55,5,'Adviser',0,1,'R');
		//Generate Barcode
		$code=$_SESSION['lrn'];
		$pdf->Code128(10,180,$code,50,15);
		
		
		//Cancelled
		$pdf->Cell(140,5,'',0,0,'L');
		$pdf->Cell(150,5,'Cancellation of Eligibility to Transfer',0,1,'C');
		$pdf->Cell(140,5,'',0,0,'L');
		$pdf->Cell(150,5,'Admitted in:  _________________                                              
		__________________',0,1,'L');
		$pdf->Cell(140,5,'',0,0,'L');
		$pdf->Cell(150,5,'Date:  _________________                                                          
		           Principal',0,1,'L');
		
		$pdf->Cell(0,2,'',0,1,'L');
	
			   
	   $pdf->Image($img4,150,10,130);
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(130,5,"REPORT ON LEARNING PROGRESS AND ACHIEVEMENT",0,1,'C');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(80,5,"First Semester",0,1);
		$pdf->Cell(80,3,'',0,1);
		//Core Subject
		
			          if ($_SESSION['Grade_Level']==11 || $_SESSION['Grade_Level']==12)
							{
							$pdf->Cell(80,10,"Subjects",1,0);
								$xPos=$pdf->GetX();
								$yPos=$pdf->GetY();
								$pdf->Multicell(20,5,"Quarter",1,'C');
								$pdf->Cell(80,10,"",0,0);
								$pdf->Cell(10,5,"1",1,0,'C');
								$pdf->Cell(10,5,"2",1,0,'C');
								$pdf->SetXY($xPos+20,$yPos);
								$pdf->Multicell(20,5,"FINAL GRADE",1,'C');
								$pdf->SetXY($xPos+20,$yPos);
								$pdf->Cell(10,10,'',0,1);
								$pdf->SetFont('Arial','',8.5);
								$no=$total=0;
								$remark="";	
								$mysubject=mysqli_query($con,"SELECT * FROM tbl_shs_tor INNER JOIN tbl_senior_sub_strand ON tbl_shs_tor.SubNo = tbl_senior_sub_strand.StrandsubCode INNER JOIN class_program on tbl_shs_tor.SubNo = class_program.SubNo INNER JOIN tbl_section ON tbl_shs_tor.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID =tbl_employee.Emp_ID WHERE tbl_shs_tor.lrn='".$_SESSION['lrn']."' AND tbl_shs_tor.SemCode='".$_SESSION['Sem']."' AND tbl_shs_tor.SYCode='".$_SESSION['year']."' AND class_program.Semester='".$_SESSION['Sem']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['SchoolID']."' AND tbl_shs_tor.SecCode='".$_SESSION['CurrentCode']."' AND tbl_shs_tor.GradeNo='".$_SESSION['Grade_Level']."' AND class_program.Grade='".$_SESSION['Grade_Level']."' AND class_program.SecCode='".$_SESSION['CurrentCode']."' GROUP BY class_program.SubNo ORDER BY LearningAreas Asc");
							
							$no=0;							
							while($subrow=mysqli_fetch_array($mysubject))
							{
							$no++;	
							$total= (number_format($subrow['FGrade'],0)+number_format($subrow['FGrade'],0))/4;
								if ($total>=75)
								{
									$remark='Passed';
								}else{
									$remark='Failed';
								}
								$no++; 
							
							$pdf->Cell(80,5,$subrow['LearningAreas'],1,0,'L');	
							$pdf->Cell(10,5,$subrow['FGrade'],1,0,'C');	
							$pdf->Cell(10,5,$subrow['FGrade'],1,0,'C');	
							$pdf->Cell(20,5,number_format($total,0),1,1,'C');		
						
							}
							
							}else{
							$pdf->Cell(80,10,"Learning Areas",1,0);
							$xPos=$pdf->GetX();
							$yPos=$pdf->GetY();
							$pdf->Multicell(40,5,"Quarter",1,'C');
							$pdf->Cell(80,10,"",0,0);
							$pdf->Cell(10,5,"1",1,0,'C');
							$pdf->Cell(10,5,"2",1,0,'C');
							$pdf->Cell(10,5,"3",1,0,'C');
							$pdf->Cell(10,5,"4",1,0,'C');
							$pdf->SetXY($xPos+40,$yPos);
							$pdf->Multicell(20,5,"FINAL GRADE",1,'C');
							$pdf->SetXY($xPos+20,$yPos);
							$pdf->Cell(10,10,'',0,1);
							$pdf->SetFont('Arial','',8.5);
							$no=$total=$average=$sum=0;
							$remark="";
							if ($_SESSION['Grade_Level']>=7 AND $_SESSION['Grade_Level']<=10){
								$mysubject=mysqli_query($con,"SELECT * FROM junior_tor INNER JOIN class_program on junior_tor.SubNo = class_program.SubNo INNER JOIN tbl_jhs_subject ON junior_tor.SubNo = tbl_jhs_subject.SubNo INNER JOIN tbl_section ON junior_tor.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID =tbl_employee.Emp_ID WHERE junior_tor.lrn='".$_SESSION['lrn']."'  AND junior_tor.SYCode='".$_SESSION['year']."'  AND junior_tor.SecCode='".$_SESSION['CurrentCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['SchoolID']."' AND junior_tor.GradeNo='".$_SESSION['Grade_Level']."' AND class_program.Grade='".$_SESSION['Grade_Level']."' AND class_program.SecCode='".$_SESSION['CurrentCode']."' GROUP BY class_program.SubNo ORDER BY tbl_jhs_subject.SequenceNo Asc");
							}
							else{
								$mysubject=mysqli_query($con,"SELECT * FROM junior_tor INNER JOIN class_program on junior_tor.SubNo = class_program.SubNo INNER JOIN tbl_element_subject ON junior_tor.SubNo = tbl_element_subject.SubNo INNER JOIN tbl_section ON junior_tor.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID =tbl_employee.Emp_ID WHERE junior_tor.lrn='".$_SESSION['lrn']."'  AND junior_tor.SYCode='".$_SESSION['year']."'  AND junior_tor.SecCode='".$_SESSION['CurrentCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['SchoolID']."' AND junior_tor.GradeNo='".$_SESSION['Grade_Level']."' AND class_program.Grade='".$_SESSION['Grade_Level']."' AND class_program.SecCode='".$_SESSION['CurrentCode']."' GROUP BY class_program.SubNo ORDER BY tbl_element_subject.SequenceNo Asc");
							}
							
							$no=0;							
							while($subrow=mysqli_fetch_array($mysubject))
							{
							$no++;	
							$total= (number_format($subrow['First_Grade'],0)+number_format($subrow['Second_Grade'],0)+number_format($subrow['Third_Grade'],0)+number_format($subrow['Fourth_Grade'],0))/4;
								if ($total>=75)
								{
									$remark='Passed';
								}else{
									$remark='Failed';
								}
								$no++; 
							
							$pdf->Cell(80,5,$subrow['LearningAreas'],1,0,'L');	
							$pdf->Cell(10,5,$subrow['First_Grade'],1,0,'C');	
							$pdf->Cell(10,5,$subrow['Second_Grade'],1,0,'C');	
							$pdf->Cell(10,5,$subrow['Third_Grade'],1,0,'C');	
							$pdf->Cell(10,5,$subrow['Fourth_Grade'],1,0,'C');	
							$pdf->Cell(20,5,number_format($total,0),1,1,'C');		
							$sum=$sum+$total;	
						
							}
							$mymapeh=mysqli_query($con,"SELECT * FROM tbl_mapeh_break ORDER BY Sequence Asc");
							while($rowmap=mysqli_fetch_array($mymapeh))
							{
								$pdf->Cell(80,5,$rowmap['LearningAreas'],1,0);
								$pdf->Cell(10,5,"",1,0,'C');	
								$pdf->Cell(10,5,"",1,0,'C');	
								$pdf->Cell(10,5,"",1,0,'C');	
								$pdf->Cell(10,5,"",1,0,'C');	
								$pdf->Cell(20,5,"",1,1,'C');	
															
							}
							$average=$sum/8;
							$pdf->Cell(80,5,"",1,0);
							$pdf->Cell(40,5,"General Average:",1,0,'C');
							$pdf->Cell(20,5,number_format($average,0),1,1,'C');
							
							}
					
		
		//Display the Output data
	$pdf->Output();
?>
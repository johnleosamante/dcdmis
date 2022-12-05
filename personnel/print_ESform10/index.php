<?php
session_start();
include_once("../../pcdmis/vendor/jquery/function.php");
		

		//Statis Data
		$Parent="Parent or Guardian:";
		$INFO="LEARNER'S INFORMATION";
		$ENRO="ELIGIBILITY FOR SHS ENROLMENT";
		$occupation="Occupation:";
		$Address="Address of Parent or Guardian:";
		$Junior="Elementary High School Completed:";
		$YGrad="Year:";
		$GWA="Gen. Ave.:";
		$School="School: ";
		$Semester="Semester:";
		$Section="Section:";
		$SY="School Year:";
		$day=date("d");
		$month=date("M");
		$dyear=date("Y");

	
	//echo mysqli_num_rows($student_data);
	$data1=mysqli_query($con,"SELECT UCASE(Lname) AS Lname,UCASE(FName) as FName,UCASE(MName) as MName FROM tbl_student WHERE lrn ='".$_SESSION['lrn']."'");
	$data2=mysqli_fetch_assoc($data1);
	$LastName=$data2['Lname'];
	$FirstName=$data2['FName'];
	$MiddleName=$data2['MName'];
	$fullName=$LastName.' '.$FirstName.' '.$MiddleName;
	
//All Data 
$query=mysqli_query($con,"SELECT * FROM tbl_student WHERE lrn ='".$_SESSION['lrn']."' LIMIT 1");
$row=mysqli_fetch_assoc($query);
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

	require("../../pcdmis/fpdf.php");
	$img2='../../pcdmis/shs/h1.png';	
	$img1='../../pcdmis/shs/logo.png';	
		
	    
 	//New PDF File		 
		$pdf =new FPDF('P','mm','Legal');
	
	//Add New Page
		$pdf->AddPage();
	
	// Logo
	$pdf->Image($img1,165,10,30);
	$pdf->Image($img2,30,10,20);
	
 
	//Data
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'SF10-ES',0,1,'L');
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(0,4,'Republic of the Philippines',0,1,'C');
	$pdf->Cell(0,4,'Department of Education',0,1,'C');
	$pdf->Cell(0,5,'',0,1);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'Learner Permanent Record for Elementary School (SF10-ES)',0,1,'C');
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(0,3,'',0,1);
	$pdf->SetFont('Arial','',9);
	$pdf->SetFillColor(210,208,208);
	$pdf->Cell(0,6,$INFO,0,1,'C',true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(0,2,'',0,1);
	$pdf->Cell(50,5,"LAST NAME:  ".$LastName,0,0,'L');
	$pdf->Cell(50,5,"FIRST NAME:  ".$FirstName,0,0,'L');
	$pdf->Cell(50,5,"NAME EXT. (Jr,I,II):  ",0,0,'L');
	$pdf->Cell(50,5,"MIDDLE NAME:  ".$MiddleName,0,1,'L');
	$pdf->Cell(80,5,"Learner Reference Number (LRN): ".$_SESSION['lrn'],0,0,'L');
	$pdf->Cell(60,5,"Birthdate (mm/dd/yyyy):  ".$row['Birthdate'],0,0,'L');
	$pdf->Cell(30,5,"Sex: ".$row['Gender'],0,1,'L');
	$pdf->Cell(0,2,'',0,1);
	$pdf->SetFont('Arial','',9);
	$pdf->SetFillColor(210,208,208);
	$pdf->Cell(0,7,$ENRO,0,1,'C',true);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(0,1,'',0,1,'C');
	
	//Educational Background
	
	
	$pdf->Cell(5,5,'/',1,0,'C');
	$pdf->Cell(70,5,'Elementary School Completer*',0,0,'L');
	$pdf->Cell(45,5,'General Average:________',0,0,'L');
	$pdf->Cell(35,5,'Citation (if Any):________',0,1,'L');
		
	
	//School from
								
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(90,5,'Name of Elementary School: _________________________________',0,0,'L');
	$pdf->Cell(40,5,'School ID:_________________ ',0,0,'L');
	$pdf->Cell(70,5,'School Address:____________________________ ',0,1,'L');
	
	//PEPT
	$pdf->Cell(0,5,'Other Credential Presented',0,1,'L');
	$pdf->Cell(5,5,'',1,0,'C');
	$pdf->Cell(55,5,'PEPT Passer Rating:_________',0,0,'L');
	$pdf->Cell(5,5,'',1,0,'C');
	$pdf->Cell(53,5,'ALS A&E Passer Rating:___________',0,0,'L');
	
	$pdf->Cell(5,5,'',1,0,'C');
	$pdf->Cell(33,5,'Others (Pls. Specify):___________________',0,1,'L');
	$pdf->Cell(90,5,'Date of Examination/Assessment (MM/DD/YYYY):_________________',0,0,'L');
	$pdf->Cell(50,5,'Name and Address of Community Learning Center:________________________',0,1,'L');
	
		
	//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ Learner school inormation
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(210,208,208);
	$pdf->Cell(0,5,"SCHOLASTIC RECORD",0,1,'C',true);
    $pdf->Cell(0,2,'',0,1,'C');
    $pdf->Cell(70,5,'School:_____________________________________',0,0);
    $pdf->Cell(30,5,'School ID:__________',0,0);
    $pdf->Cell(40,5,'District:____________',0,0);
    $pdf->Cell(35,5,'Division:_________________',0,0);
    $pdf->Cell(20,5,'Region:_______',0,1);
	
    $pdf->Cell(40,5,'Classified as Grade:___________',0,0);
    $pdf->Cell(30,5,'Section:__________',0,0);
    $pdf->Cell(35,5,'School Year:____________',0,0);
    $pdf->Cell(65,5,'Name of Adviser/Teacher:_________________',0,0);
    $pdf->Cell(20,5,'Signature:_______',0,1);
	
	//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ learner grade information
		
	//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ Grade 11- First Semester Grades information
	$pdf->Cell(0,1,'',0,1,'C');
	$pdf->Cell(80,10,"LEARNING AREAS",1,0);
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->Multicell(60,5,"QUARTER",1,'C');
	$pdf->Cell(80,10,"",0,0);
	$pdf->Cell(15,5,"1",1,0,'C');	
	$pdf->Cell(15,5,"2",1,0,'C');	
	$pdf->Cell(15,5,"3",1,0,'C');	
	$pdf->Cell(15,5,"4",1,1,'C');
	
	$pdf->SetXY($xPos+60,$yPos);
	$pdf->Multicell(20,5,"FINAL RATING",1,'C');
	$pdf->SetXY($xPos+80,$yPos);
	$pdf->Cell(10,10,'',0,1);
	$pdf->SetXY($xPos+80,$yPos);
	$pdf->Multicell(35,10,"REMARKS",1,'C');
	$pdf->SetFont('Arial','',9);
	//Subject Query -n first Grade Level
	$mysubject=mysqli_query($con,"SELECT * FROM tbl_element_subject ORDER BY SequenceNo Asc");
	while($row=mysqli_fetch_array($mysubject))
	{
		$pdf->Cell(80,5,$row['LearningAreas'],1,0);
		$pdf->Cell(15,5,"",1,0,'C');
		$pdf->Cell(15,5,"",1,0,'C');
		$pdf->Cell(15,5,"",1,0,'C');
		$pdf->Cell(15,5,"",1,0,'C');
		$pdf->Cell(20,5,"",1,0,'C');
		$pdf->Cell(35,5,"",1,1,'C');
	}
	$mymapeh=mysqli_query($con,"SELECT * FROM tbl_mapeh_break ORDER BY Sequence Asc");
	while($rowmap=mysqli_fetch_array($mymapeh))
	{
		$pdf->Cell(80,5,$rowmap['LearningAreas'],1,0);
		$pdf->Cell(15,5,"",1,0,'C');
		$pdf->Cell(15,5,"",1,0,'C');
		$pdf->Cell(15,5,"",1,0,'C');
		$pdf->Cell(15,5,"",1,0,'C');
		$pdf->Cell(20,5,"",1,0,'C');
		$pdf->Cell(35,5,"",1,1,'C');
		
	}
		$pdf->Cell(80,5,"",1,0);
		$pdf->Cell(60,5,"General Average:",1,0,'C');
		$pdf->Cell(20,5,"",1,0,'C');
		$pdf->Cell(35,5,"",1,1,'C');
		
	
	$pdf->SetFillColor(210,208,208);
	$pdf->Cell(0,1,"",0,1,'C',true);
	$pdf->SetFont('Arial','',8);
	
	
	//Subject Query -n next Grade Level
	$pdf->Cell(0,5,'Remedial Classes Conducted from (mm/dd/yyyy)___________________to (mm/dd/yyyy)________________________',0,1);
	$pdf->Cell(0,2,"",0,1,'C');
	$pdf->Cell(70,5,"Learning Areas",1,0);
	$pdf->Cell(25,5,"Final Rating",1,0,'C');
	$pdf->Cell(35,5,"Remedial Class Mark",1,0,'C');
	$pdf->Cell(35,5,"Recomputed Final Grade",1,0,'C');
	$pdf->Cell(30,5,"Remarks",1,1,'C');

	$pdf->Cell(70,5,"",1,0);
	$pdf->Cell(25,5,"",1,0,'C');
	$pdf->Cell(35,5,"",1,0,'C');
	$pdf->Cell(35,5,"",1,0,'C');
	$pdf->Cell(30,5,"",1,1,'C');
	$pdf->Cell(70,5,"",1,0);
	$pdf->Cell(25,5,"",1,0,'C');
	$pdf->Cell(35,5,"",1,0,'C');
	$pdf->Cell(35,5,"",1,0,'C');
	$pdf->Cell(30,5,"",1,1,'C');
	$pdf->Cell(0,2,"",0,1,'C');
	
	$pdf->Cell(70,5,'School:_____________________________________',0,0);
    $pdf->Cell(30,5,'School ID:__________',0,0);
    $pdf->Cell(40,5,'District:____________',0,0);
    $pdf->Cell(35,5,'Division:_________________',0,0);
    $pdf->Cell(20,5,'Region:_______',0,1);
	
    $pdf->Cell(40,5,'Classified as Grade:___________',0,0);
    $pdf->Cell(30,5,'Section:__________',0,0);
    $pdf->Cell(35,5,'School Year:____________',0,0);
    $pdf->Cell(65,5,'Name of Adviser/Teacher:_________________',0,0);
    $pdf->Cell(20,5,'Signature:_______',0,1);
	$pdf->Cell(0,2,"",0,1,'C');
	$pdf->Cell(80,10,"LEARNING AREAS",1,0);
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->Multicell(60,5,"QUARTER",1,'C');
	$pdf->Cell(80,10,"",0,0);
	$pdf->Cell(15,5,"1",1,0,'C');	
	$pdf->Cell(15,5,"2",1,0,'C');	
	$pdf->Cell(15,5,"3",1,0,'C');	
	$pdf->Cell(15,5,"4",1,1,'C');
	
	$pdf->SetXY($xPos+60,$yPos);
	$pdf->Multicell(20,5,"FINAL RATING",1,'C');
	$pdf->SetXY($xPos+80,$yPos);
	$pdf->Cell(10,10,'',0,1);
	$pdf->SetXY($xPos+80,$yPos);
	$pdf->Multicell(35,10,"REMARKS",1,'C');
	$mysubject=mysqli_query($con,"SELECT * FROM tbl_element_subject ORDER BY SequenceNo Asc");
	while($row=mysqli_fetch_array($mysubject))
	{
		$pdf->Cell(80,5,$row['LearningAreas'],1,0);
		$pdf->Cell(15,5,"",1,0,'C');
		$pdf->Cell(15,5,"",1,0,'C');
		$pdf->Cell(15,5,"",1,0,'C');
		$pdf->Cell(15,5,"",1,0,'C');
		$pdf->Cell(20,5,"",1,0,'C');
		$pdf->Cell(35,5,"",1,1,'C');
	}
	$mymapeh=mysqli_query($con,"SELECT * FROM tbl_mapeh_break ORDER BY Sequence Asc");
	while($rowmap=mysqli_fetch_array($mymapeh))
	{
		$pdf->Cell(80,4,$rowmap['LearningAreas'],1,0);
		$pdf->Cell(15,4,"",1,0,'C');
		$pdf->Cell(15,4,"",1,0,'C');
		$pdf->Cell(15,4,"",1,0,'C');
		$pdf->Cell(15,4,"",1,0,'C');
		$pdf->Cell(20,4,"",1,0,'C');
		$pdf->Cell(35,4,"",1,1,'C');
		
	}
		$pdf->Cell(80,4,"",1,0);
		$pdf->Cell(60,4,"General Average:",1,0,'C');
		$pdf->Cell(20,4,"",1,0,'C');
		$pdf->Cell(35,4,"",1,1,'C');
		$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(210,208,208);
	$pdf->Cell(0,1,"",0,1,'C',true);
	$pdf->Cell(0,4,'Remedial Classes Conducted from (mm/dd/yyyy)___________________to (mm/dd/yyyy)________________________',0,1);
	$pdf->Cell(0,2,"",0,1,'C');
	$pdf->Cell(70,4,"Learning Areas",1,0);
	$pdf->Cell(25,4,"Final Rating",1,0,'C');
	$pdf->Cell(35,4,"Remedial Class Mark",1,0,'C');
	$pdf->Cell(35,4,"Recomputed Final Grade",1,0,'C');
	$pdf->Cell(30,4,"Remarks",1,1,'C');

	$pdf->Cell(70,4,"",1,0);
	$pdf->Cell(25,4,"",1,0,'C');
	$pdf->Cell(35,4,"",1,0,'C');
	$pdf->Cell(35,4,"",1,0,'C');
	$pdf->Cell(30,4,"",1,1,'C');
	$pdf->Cell(70,4,"",1,0);
	$pdf->Cell(25,4,"",1,0,'C');
	$pdf->Cell(35,4,"",1,0,'C');
	$pdf->Cell(35,4,"",1,0,'C');
	$pdf->Cell(30,4,"",1,1,'C');
		
	$pdf->SetFillColor(210,208,208);
	$pdf->Cell(0,4,"CERTIFICATION",0,1,'C',true);
	
	$pdf->Write(4,"I CERTIFY that this is a true record of________________________ with LRN___________ and that he/she is eligible for admission to Grade_______ Name of School:__________________________________ School ID:______________ Last School Year Attended:_______________",0,1);
	$pdf->Cell(0,12,"",0,1,'C');
	$pdf->Cell(0,5,"Date                                             Signature of Principal/School Head over Printed Name                                           (Affix School Seal Here)",0,1);




     //Next Page
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(70,5,'School:_____________________________________',0,0);
    $pdf->Cell(30,5,'School ID:__________',0,0);
    $pdf->Cell(40,5,'District:____________',0,0);
    $pdf->Cell(35,5,'Division:_________________',0,0);
    $pdf->Cell(20,5,'Region:_______',0,1);
	
    $pdf->Cell(40,5,'Classified as Grade:___________',0,0);
    $pdf->Cell(30,5,'Section:__________',0,0);
    $pdf->Cell(35,5,'School Year:____________',0,0);
    $pdf->Cell(65,5,'Name of Adviser/Teacher:_________________',0,0);
    $pdf->Cell(20,5,'Signature:_______',0,1);
	$pdf->Cell(0,2,"",0,1,'C');
	$pdf->Cell(80,10,"LEARNING AREAS",1,0);
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->Multicell(60,5,"QUARTER",1,'C');
	$pdf->Cell(80,10,"",0,0);
	$pdf->Cell(15,5,"1",1,0,'C');	
	$pdf->Cell(15,5,"2",1,0,'C');	
	$pdf->Cell(15,5,"3",1,0,'C');	
	$pdf->Cell(15,5,"4",1,1,'C');
	
	$pdf->SetXY($xPos+60,$yPos);
	$pdf->Multicell(20,5,"FINAL RATING",1,'C');
	$pdf->SetXY($xPos+80,$yPos);
	$pdf->Cell(10,10,'',0,1);
	$pdf->SetXY($xPos+80,$yPos);
	$pdf->Multicell(35,10,"REMARKS",1,'C');
	$mysubject=mysqli_query($con,"SELECT * FROM tbl_element_subject ORDER BY SequenceNo Asc");
	while($row=mysqli_fetch_array($mysubject))
	{
		$pdf->Cell(80,4,$row['LearningAreas'],1,0);
		$pdf->Cell(15,4,"",1,0,'C');
		$pdf->Cell(15,4,"",1,0,'C');
		$pdf->Cell(15,4,"",1,0,'C');
		$pdf->Cell(15,4,"",1,0,'C');
		$pdf->Cell(20,4,"",1,0,'C');
		$pdf->Cell(35,4,"",1,1,'C');
	}
	$mymapeh=mysqli_query($con,"SELECT * FROM tbl_mapeh_break ORDER BY Sequence Asc");
	while($rowmap=mysqli_fetch_array($mymapeh))
	{
		$pdf->Cell(80,4,$rowmap['LearningAreas'],1,0);
		$pdf->Cell(15,4,"",1,0,'C');
		$pdf->Cell(15,4,"",1,0,'C');
		$pdf->Cell(15,4,"",1,0,'C');
		$pdf->Cell(15,4,"",1,0,'C');
		$pdf->Cell(20,4,"",1,0,'C');
		$pdf->Cell(35,4,"",1,1,'C');
		
	}
		$pdf->Cell(80,4,"",1,0);
		$pdf->Cell(60,4,"General Average:",1,0,'C');
		$pdf->Cell(20,4,"",1,0,'C');
		$pdf->Cell(35,4,"",1,1,'C');
		
     $pdf->SetFillColor(210,208,208);
	$pdf->Cell(0,1,"",0,1,'C',true);
	$pdf->Cell(0,4,'Remedial Classes Conducted from (mm/dd/yyyy)___________________to (mm/dd/yyyy)________________________',0,1);
	$pdf->Cell(0,2,"",0,1,'C');
	$pdf->Cell(70,4,"Learning Areas",1,0);
	$pdf->Cell(25,4,"Final Rating",1,0,'C');
	$pdf->Cell(35,4,"Remedial Class Mark",1,0,'C');
	$pdf->Cell(35,4,"Recomputed Final Grade",1,0,'C');
	$pdf->Cell(30,4,"Remarks",1,1,'C');

	$pdf->Cell(70,4,"",1,0);
	$pdf->Cell(25,4,"",1,0,'C');
	$pdf->Cell(35,4,"",1,0,'C');
	$pdf->Cell(35,4,"",1,0,'C');
	$pdf->Cell(30,4,"",1,1,'C');
	$pdf->Cell(70,4,"",1,0);
	$pdf->Cell(25,4,"",1,0,'C');
	$pdf->Cell(35,4,"",1,0,'C');
	$pdf->Cell(35,4,"",1,0,'C');
	$pdf->Cell(30,4,"",1,1,'C');
	
	
	$pdf->Cell(70,4,'School:_____________________________________',0,0);
    $pdf->Cell(30,4,'School ID:__________',0,0);
    $pdf->Cell(40,4,'District:____________',0,0);
    $pdf->Cell(35,4,'Division:_________________',0,0);
    $pdf->Cell(20,4,'Region:_______',0,1);
	
    $pdf->Cell(40,4,'Classified as Grade:___________',0,0);
    $pdf->Cell(30,4,'Section:__________',0,0);
    $pdf->Cell(35,4,'School Year:____________',0,0);
    $pdf->Cell(65,4,'Name of Adviser/Teacher:_________________',0,0);
    $pdf->Cell(20,4,'Signature:_______',0,1);
	$pdf->Cell(0,1,"",0,1,'C');
	$pdf->Cell(80,10,"LEARNING AREAS",1,0);
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->Multicell(60,4,"QUARTER",1,'C');
	$pdf->Cell(80,10,"",0,0);
	$pdf->Cell(15,4,"1",1,0,'C');	
	$pdf->Cell(15,4,"2",1,0,'C');	
	$pdf->Cell(15,4,"3",1,0,'C');	
	$pdf->Cell(15,4,"4",1,1,'C');
	
	$pdf->SetXY($xPos+60,$yPos);
	$pdf->Multicell(20,4,"FINAL RATING",1,'C');
	$pdf->SetXY($xPos+80,$yPos);
	$pdf->Cell(10,10,'',0,1);
	$pdf->SetXY($xPos+80,$yPos);
	$pdf->Multicell(35,10,"REMARKS",1,'C');
	$mysubject=mysqli_query($con,"SELECT * FROM tbl_element_subject ORDER BY SequenceNo Asc");
	while($row=mysqli_fetch_array($mysubject))
	{
		$pdf->Cell(80,4,$row['LearningAreas'],1,0);
		$pdf->Cell(15,4,"",1,0,'C');
		$pdf->Cell(15,4,"",1,0,'C');
		$pdf->Cell(15,4,"",1,0,'C');
		$pdf->Cell(15,4,"",1,0,'C');
		$pdf->Cell(20,4,"",1,0,'C');
		$pdf->Cell(35,4,"",1,1,'C');
	}
	$mymapeh=mysqli_query($con,"SELECT * FROM tbl_mapeh_break ORDER BY Sequence Asc");
	while($rowmap=mysqli_fetch_array($mymapeh))
	{
		$pdf->Cell(80,4,$rowmap['LearningAreas'],1,0);
		$pdf->Cell(15,4,"",1,0,'C');
		$pdf->Cell(15,4,"",1,0,'C');
		$pdf->Cell(15,4,"",1,0,'C');
		$pdf->Cell(15,4,"",1,0,'C');
		$pdf->Cell(20,4,"",1,0,'C');
		$pdf->Cell(35,4,"",1,1,'C');
		
	}
		$pdf->Cell(80,5,"",1,0);
		$pdf->Cell(60,5,"General Average:",1,0,'C');
		$pdf->Cell(20,5,"",1,0,'C');
		$pdf->Cell(35,5,"",1,1,'C');
		$pdf->SetFillColor(210,208,208);
		$pdf->Cell(0,1,"",0,1,'C',true);
	
	//Subject Query -n next Grade Level
	$pdf->Cell(0,5,'Remedial Classes Conducted from (mm/dd/yyyy)___________________to (mm/dd/yyyy)________________________',0,1);
	$pdf->Cell(0,2,"",0,1,'C');
	$pdf->Cell(70,5,"Learning Areas",1,0);
	$pdf->Cell(25,5,"Final Rating",1,0,'C');
	$pdf->Cell(35,5,"Remedial Class Mark",1,0,'C');
	$pdf->Cell(35,5,"Recomputed Final Grade",1,0,'C');
	$pdf->Cell(30,5,"Remarks",1,1,'C');

	$pdf->Cell(70,5,"",1,0);
	$pdf->Cell(25,5,"",1,0,'C');
	$pdf->Cell(35,5,"",1,0,'C');
	$pdf->Cell(35,5,"",1,0,'C');
	$pdf->Cell(30,5,"",1,1,'C');
	$pdf->Cell(70,5,"",1,0);
	$pdf->Cell(25,5,"",1,0,'C');
	$pdf->Cell(35,5,"",1,0,'C');
	$pdf->Cell(35,5,"",1,0,'C');
	$pdf->Cell(30,5,"",1,1,'C');
	$pdf->Cell(0,2,"",0,1,'C');
	
	$pdf->Cell(70,5,'School:_____________________________________',0,0);
    $pdf->Cell(30,5,'School ID:__________',0,0);
    $pdf->Cell(40,5,'District:____________',0,0);
    $pdf->Cell(35,5,'Division:_________________',0,0);
    $pdf->Cell(20,5,'Region:_______',0,1);
	
    $pdf->Cell(40,5,'Classified as Grade:___________',0,0);
    $pdf->Cell(30,5,'Section:__________',0,0);
    $pdf->Cell(35,5,'School Year:____________',0,0);
    $pdf->Cell(65,5,'Name of Adviser/Teacher:_________________',0,0);
    $pdf->Cell(20,5,'Signature:_______',0,1);
	$pdf->Cell(0,2,"",0,1,'C');
	$pdf->Cell(80,10,"LEARNING AREAS",1,0);
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->Multicell(60,5,"QUARTER",1,'C');
	$pdf->Cell(80,10,"",0,0);
	$pdf->Cell(15,5,"1",1,0,'C');	
	$pdf->Cell(15,5,"2",1,0,'C');	
	$pdf->Cell(15,5,"3",1,0,'C');	
	$pdf->Cell(15,5,"4",1,1,'C');
	
	$pdf->SetXY($xPos+60,$yPos);
	$pdf->Multicell(20,5,"FINAL RATING",1,'C');
	$pdf->SetXY($xPos+80,$yPos);
	$pdf->Cell(10,10,'',0,1);
	$pdf->SetXY($xPos+80,$yPos);
	$pdf->Multicell(35,10,"REMARKS",1,'C');
	$mysubject=mysqli_query($con,"SELECT * FROM tbl_element_subject ORDER BY SequenceNo Asc");
	while($row=mysqli_fetch_array($mysubject))
	{
		$pdf->Cell(80,5,$row['LearningAreas'],1,0);
		$pdf->Cell(15,5,"",1,0,'C');
		$pdf->Cell(15,5,"",1,0,'C');
		$pdf->Cell(15,5,"",1,0,'C');
		$pdf->Cell(15,5,"",1,0,'C');
		$pdf->Cell(20,5,"",1,0,'C');
		$pdf->Cell(35,5,"",1,1,'C');
	}
	$mymapeh=mysqli_query($con,"SELECT * FROM tbl_mapeh_break ORDER BY Sequence Asc");
	while($rowmap=mysqli_fetch_array($mymapeh))
	{
		$pdf->Cell(80,4,$rowmap['LearningAreas'],1,0);
		$pdf->Cell(15,4,"",1,0,'C');
		$pdf->Cell(15,4,"",1,0,'C');
		$pdf->Cell(15,4,"",1,0,'C');
		$pdf->Cell(15,4,"",1,0,'C');
		$pdf->Cell(20,4,"",1,0,'C');
		$pdf->Cell(35,4,"",1,1,'C');
		
	}
		$pdf->Cell(80,4,"",1,0);
		$pdf->Cell(60,4,"General Average:",1,0,'C');
		$pdf->Cell(20,4,"",1,0,'C');
		$pdf->Cell(35,4,"",1,1,'C');
	
	$pdf->Cell(0,5,'Remedial Classes Conducted from (mm/dd/yyyy)___________________to (mm/dd/yyyy)________________________',0,1);
	$pdf->Cell(0,2,"",0,1,'C');
	$pdf->Cell(70,5,"Learning Areas",1,0);
	$pdf->Cell(25,5,"Final Rating",1,0,'C');
	$pdf->Cell(35,5,"Remedial Class Mark",1,0,'C');
	$pdf->Cell(35,5,"Recomputed Final Grade",1,0,'C');
	$pdf->Cell(30,5,"Remarks",1,1,'C');

	$pdf->Cell(70,5,"",1,0);
	$pdf->Cell(25,5,"",1,0,'C');
	$pdf->Cell(35,5,"",1,0,'C');
	$pdf->Cell(35,5,"",1,0,'C');
	$pdf->Cell(30,5,"",1,1,'C');
	$pdf->Cell(70,5,"",1,0);
	$pdf->Cell(25,5,"",1,0,'C');
	$pdf->Cell(35,5,"",1,0,'C');
	$pdf->Cell(35,5,"",1,0,'C');
	$pdf->Cell(30,5,"",1,1,'C');
	$pdf->Cell(0,2,"",0,1,'C');
	$pdf->Cell(0,4,"For Transfer Out / ES Completer Only",0,1);
	
	$pdf->SetFillColor(210,208,208);
	$pdf->Cell(0,4,"CERTIFICATION",0,1,'C',true);
	
	$pdf->Write(4,"I CERTIFY that this is a true record of________________________ with LRN___________ and that he/she is eligible for admission to Grade_______ Name of School:__________________________________ School ID:______________ Last School Year Attended:_______________",0,1);
	$pdf->Cell(0,12,"",0,1,'C');
	$pdf->Cell(0,5,"Date                                             Signature of Principal/School Head over Printed Name                                           (Affix School Seal Here)",0,1);


	
	//Display the Output data
	$pdf->Output();
?>
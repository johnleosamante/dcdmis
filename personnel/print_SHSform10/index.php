<?php
session_start();
include_once("../../../pcdmis/vendor/jquery/function.php");
		

		//Statis Data
		$Parent="Parent or Guardian:";
		$INFO="LEARNER'S INFORMATION";
		$ENRO="ELIGIBILITY FOR SHS ENROLMENT";
		$occupation="Occupation:";
		$Address="Address of Parent or Guardian:";
		$Junior="Junior High School Completed:";
		$YGrad="Year:";
		$GWA="Gen. Ave.:";
		$School="School: ";
		$Semester="Semester:";
		$Section="Section:";
		$SY="School Year:";
		$day=date("d");
		$month=date("M");
		$dyear=date("Y");

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

	require("../../../pcdmis/fpdf.php");
	$img2='../../../pcdmis/shs/h1.png';	
	$img1='../../../pcdmis/shs/logo.png';	
		
	    
 	//New PDF File		 
		$pdf =new FPDF('P','mm','Legal');
	
	//Add New Page
		$pdf->AddPage();
	//Set Font  10	
		$pdf->SetFont('Arial','',9);
		//$pdf->SetFont('','U');
	// Logo
	$pdf->Image($img1,165,10,30);
	$pdf->Image($img2,30,10,20);
	
	 //All Data 
	$query=mysqli_query($con,"SELECT * FROM tbl_student WHERE lrn ='".$_SESSION['lrn']."' LIMIT 1");
	$data=mysqli_fetch_assoc($query);
	//echo mysqli_num_rows($student_data);
	$data1=mysqli_query($con,"SELECT UCASE(Lname) AS Lname,UCASE(FName) as FName,UCASE(MName) as MName FROM tbl_student WHERE lrn ='".$_SESSION['lrn']."'");
	$data2=mysqli_fetch_assoc($data1);
	$LastName=$data2['Lname'];
	$FirstName=$data2['FName'];
	$MiddleName=$data2['MName'];

	$fullName=$LastName.' '.$FirstName.' '.$MiddleName;
	$eligible=$data['ELigibility'];
	//Data
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'SF10-SHS',0,1,'R');
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(0,4,'REPUBLIC OF THE PHILIPPINES',0,1,'C');
	$pdf->Cell(0,4,'DEPARTMENT OF EDUCATION',0,1,'C');
	$pdf->Cell(0,5,'',0,1);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'SENIOR HIGH SCHOOL STUDENT PERMANENT RECORD',0,1,'C');
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(0,3,'',0,1);
	$pdf->SetFont('Arial','',9);
	$pdf->SetFillColor(210,208,208);
	$pdf->Cell(0,6,$INFO,0,1,'C',true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(0,2,'',0,1);
	$pdf->Cell(50,5,"LAST NAME:  ".$LastName,0,0,'L');
	$pdf->Cell(50,5,"FIRST NAME:  ".$FirstName,0,0,'L');
	$pdf->Cell(50,5,"MIDDLE NAME:  ".$MiddleName,0,1,'L');
	$pdf->Cell(50,5,"LRN: ".$_SESSION['lrn'],0,0,'L');
	$pdf->Cell(50,5,"Birtdate: ".$data['Birthdate'],0,0,'L');
	$pdf->Cell(30,5,"Sex: ".$data['Gender'],0,0,'L');
	$pdf->Cell(40,5,"Date of SHS Admission: August 3, 2019",0,1,'L');
	$pdf->Cell(0,2,'',0,1);
	$pdf->SetFont('Arial','',9);
	$pdf->SetFillColor(210,208,208);
	$pdf->Cell(0,7,$ENRO,0,1,'C',true);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(0,1,'',0,1,'C');
	
	//Educational Background
	
	if ($eligible=='High School Completer')
	{
	$pdf->Cell(5,5,'/',1,0,'C');
	$pdf->Cell(40,5,'High School Completer*',0,0,'L');
	$pdf->Cell(35,5,'Gen. Ave:'.$data['GWA'],0,0,'L');
	$pdf->Cell(5,5,'',1,0,'C');
	$pdf->Cell(50,5,'Junior High School Completer*',0,0,'L');
	$pdf->Cell(35,5,'Gen. Ave: __________',0,1,'L');
	}elseif ($eligible=='Junior High School Completer')
	{
	$pdf->Cell(5,5,'',1,0,'C');
	$pdf->Cell(40,5,'High School Completer*',0,0,'L');
	$pdf->Cell(35,5,'Gen. Ave:________',0,0,'L');
	$pdf->Cell(5,5,'/',1,0,'C');
	$pdf->Cell(50,5,'Junior High School Completer*',0,0,'L');
	$pdf->Cell(35,5,'Gen. Ave: '.$data['GWA'],0,1,'L');
	}
	
	//School from
								
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(45,5,'Date of Completion: '.$data['YGradudate'],0,0,'L');
	$pdf->Cell(90,5,'Name of School: ',0,0,'L');
	$pdf->Cell(90,5,'School Address: ',0,1,'L');
	
	//PEPT
	$pdf->Cell(5,5,'',1,0,'C');
	$pdf->Cell(25,5,'PEPT Passer**',0,0,'L');
	$pdf->Cell(30,5,'Rating: :_________',0,0,'L');
	$pdf->Cell(5,5,'',1,0,'C');
	$pdf->Cell(33,5,'ALS A&E Passer***',0,0,'L');
	$pdf->Cell(30,5,'Rating: :_________',0,0,'L');
	$pdf->Cell(5,5,'',1,0,'C');
	$pdf->Cell(33,5,'Others (Pls. Specify):___________________',0,1,'L');
	$pdf->Cell(90,5,'Date of Examination/Assessment (MM/DD/YYYY):_________________',0,0,'L');
	$pdf->Cell(50,5,'Name and Address of Community Learning Center:________________________',0,1,'L');
	$pdf->Cell(0,5,'*High School Completer are students who graduated from secondary school under the old curriculum',0,1,'L');
	$pdf->Cell(120,5,'***ALS A&E - Alternative Learning System Accreditation and Equivalency Test for JHS',0,0,'L');
	$pdf->Cell(0,5,'**PEPT - Philippine Educational Placement Test for JHS',0,1,'L');
		
	//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ Grade 11- First Semester information
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(210,208,208);
	$pdf->Cell(0,5,"SCHOLASTIC RECORD",0,1,'C',true);
  
	
	
	//@@####@@@@##############@@@certification
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->Cell(130,5,'Certified by:',0,0,'L');
	$pdf->Cell(0,5,'Place School Seal Here:',0,1,'L');
	//@@####@@@@##############@@@Siganatories
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->Cell(50,5,$_SESSION['Principal'],0,0,'C');
	$pdf->Cell(50,5,'Date:',0,1,'C');
	$pdf->Cell(50,5,'Signature of School Head over Printed Name',0,1,'C');
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(20,5,'NOTE:',0,1);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(10,5,'',0,0);
	$pdf->Cell(115,5,' This permanent record or a photocopy of this permanent record that bears the',0,0);
	$pdf->Cell(.5,5,'',1,1);
	$pdf->Cell(125,5,'seal of the school and the original signature in ink of the School Head shall be considered',0,0);
	$pdf->Cell(.5,5,'',1,1);	
	$pdf->Cell(125,5,'valid for all legal purposes. Any erasure or alteration made on this copy  should be validated by ',0,0);
	$pdf->Cell(.5,5,'',1,1);
	$pdf->Cell(125,5,'the School Head. If the student transfers to another school, the originating school should produce',0,0);
	$pdf->Cell(.5,5,'',1,1);
	$pdf->Cell(125,5,'one (1) certified true copy of this permanent record for safekeeping. The receiving school shall ',0,0);
	$pdf->Cell(.5,5,'',1,1);
	$pdf->Cell(125,5,'continue filling up the original form.Upon graduation, the school from which the student graduated ',0,0);
	$pdf->Cell(.5,5,'',1,1);
	$pdf->Cell(125,5,'should keep the original form and produce one (1) certified true copy for the Division Office.',0,0);
	$pdf->Cell(.5,5,'',1,1);
	
	
	
	//Display the Output data
	$pdf->Output();
?>
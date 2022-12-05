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
	
 
	//Data
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'SF10-JHS',0,1,'L');
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(0,4,'Republic of the Philippines',0,1,'C');
	$pdf->Cell(0,4,'Department of Education',0,1,'C');
	$pdf->Cell(0,5,'',0,1);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'Learner Permanent Record for Junior High School (SF10-JHS)',0,1,'C');
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(0,3,'',0,1);
	$pdf->SetFont('Arial','',9);
	$pdf->SetFillColor(210,208,208);
	$pdf->Cell(0,6,$INFO,0,1,'C',true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(0,2,'',0,1);
	$pdf->Cell(50,5,"LAST NAME:  ",0,0,'L');
	$pdf->Cell(50,5,"FIRST NAME:  ",0,0,'L');
	$pdf->Cell(50,5,"NAME EXT. (Jr,I,II):  ",0,0,'L');
	$pdf->Cell(50,5,"MIDDLE NAME:  ",0,1,'L');
	$pdf->Cell(80,5,"Learner Reference Number (LRN): ".$_SESSION['lrn'],0,0,'L');
	$pdf->Cell(50,5,"Birtdate: ",0,0,'L');
	$pdf->Cell(30,5,"Sex: ",0,1,'L');
	$pdf->Cell(0,2,'',0,1);
	$pdf->SetFont('Arial','',9);
	$pdf->SetFillColor(210,208,208);
	$pdf->Cell(0,7,$ENRO,0,1,'C',true);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(0,1,'',0,1,'C');
	
	//Educational Background
	
	
	$pdf->Cell(5,5,'',1,0,'C');
	$pdf->Cell(40,5,'High School Completer*',0,0,'L');
	$pdf->Cell(35,5,'Gen. Ave:________',0,0,'L');
	$pdf->Cell(5,5,'/',1,0,'C');
	$pdf->Cell(50,5,'Junior High School Completer*',0,0,'L');
	$pdf->Cell(35,5,'Gen. Ave: ',0,1,'L');
	
	
	//School from
								
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(45,5,'Date of Completion: ',0,0,'L');
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
  
	
	
	//Display the Output data
	$pdf->Output();
?>
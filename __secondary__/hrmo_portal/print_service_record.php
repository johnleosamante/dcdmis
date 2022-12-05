<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");

	//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
	
	require("../../pcdmis/fpdf.php");
	$img1='../../pcdmis/logo/logo.png';	
	$img2='../../pcdmis/logo/deped.png';		   
 	//New PDF File		 
		$pdf =new FPDF('P','mm','A4');
	
	//Add New Page
		$pdf->AliasNbPages('{pages}');
		$pdf->AddPage();
	
	//Set Font  10	
	$pdf->Image($img1,165,10,20);
	$pdf->Image($img2,30,10,20);
		
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'Republic of the Philippines',0,1,'C');
	$pdf->Cell(0,5,'Department of Education',0,1,'C');
	$pdf->Cell(0,5,'Region IX, Zamboanga Peninsula',0,1,'C');
	$pdf->Cell(0,5,'DIVISION OF PAGADIAN CITY',0,1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,5,'Pagadian City',0,1,'C');
	$pdf->Cell(0,5,'',0,1);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(0,5,'SERVICE RECORD',0,1,'C');
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(0,5,'(To be accomplish by Employeer)',0,1,'C');
	$pdf->Cell(0,5,'',0,1);
	$pdf->SetFont('Arial','',9);
	
	//Name of the Employeer
	$pdf->Cell(30,5,'NAME:',0,0);
	$pdf->Cell(35,5,$_SESSION['surname'],0,0,'C');
	$pdf->Cell(30,5,$_SESSION['given'],0,0,'C');
	$pdf->Cell(30,5,$_SESSION['middle'],0,0,'C');
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(60,5,'If married woman, given also full maiden name',0,1,'R');
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(30,5,'',0,0,'C');
	$pdf->Cell(35,5,'(Surname)',0,0,'C');
	$pdf->Cell(30,5,'(Given)',0,0,'C');
	$pdf->Cell(30,5,'(M.I)',0,0,'C');
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(60,5,'(Date herein should be checked from birth of baptismal)',0,1,'R');
	
	//Birthdate of the Employeer
	$pdf->Cell(123,5,'',0,0);
	$pdf->Cell(60,5,'certificates or some other reliable documents.)',0,1,'L');
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(30,5,'BIRTH:',0,0);
	$pdf->Cell(35,5,$_SESSION['birth'],0,0,'C');
	$pdf->Cell(80,5,$_SESSION['place'],0,1,'C');
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(30,5,'',0,0,'C');
	$pdf->Cell(35,5,'(Date)',0,0,'C');
	$pdf->Cell(80,5,'(Place)',0,1,'C');
	
	//Certification
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(0,5,'',0,1);
	$pdf->Cell(0,5,'         This is certify that the employee name herein above actually rendered servicess in this office as shown ',0,1,'R');
	$pdf->Cell(0,5,'by the service record below each line is supported by appointment and the other papers actually issued by this office and ',0,1);
	$pdf->Cell(0,5,'approved by the authorities concerned. ',0,1);
	
	//Data Records
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(0,5,'',0,1);
	$pdf->Cell(30,5,'SERVICE RECORDS',1,0,'C');
	$pdf->Cell(60,5,'RECORDS OF APPOINTMENT',1,0,'C');
	$pdf->Cell(50,5,'OFFICE ENTITY / DIV',1,0,'C');
	$pdf->Cell(30,5,'V/L ABSENCES W/O PAY',1,0,'C');
	$pdf->Cell(20,5,'SEPARATION',1,1,'C');
	//NEXT LINE
	$pdf->Cell(15,5,'FROM',1,0,'C');
	$pdf->Cell(15,5,'TO',1,0,'C');
	$pdf->Cell(20,5,'DISIGNATION',1,0,'C');
	$pdf->Cell(20,5,'STATUS',1,0,'C');
	$pdf->Cell(20,5,'SALARY',1,0,'C');
	$pdf->Cell(35,5,'STN/PLACE OF ASSIGNMENT',1,0,'C');
	$pdf->Cell(15,5,'BRANCH',1,0,'C');
	$pdf->Cell(30,5,'CES W/O PAY',1,0,'C');
	$pdf->Cell(20,5,'',1,1,'C');
	
	//DATA QUERY
	$result=mysqli_query($con,"SELECT * FROM tbl_service_records WHERE tbl_service_records.Emp_ID='".$_SESSION['SR']."'");
		while($row=mysqli_fetch_array($result))
			{
				$pdf->Cell(15,5,$row['date_from'],1,0,'C');
				$pdf->Cell(15,5,$row['date_to'],1,0,'C');
				$pdf->Cell(20,5,$row['position'],1,0,'C');
				$pdf->Cell(20,5,$row['work_status'],1,0,'C');
				$pdf->Cell(20,5,$row['salary'],1,0,'C');
				$pdf->Cell(35,5,$row['station'],1,0,'C');
				$pdf->Cell(15,5,$row['branch'],1,0,'C');
				$pdf->Cell(30,5,$row['pay_status'],1,0);
				$pdf->Cell(20,5,$row['separation'],1,1,'C');
			}
			$pdf->Cell(0,5,'xxxxxxxxxxxxxxxxxxxxxxx nothing follows xxxxxxxxxxxxxxxxxxxxxxx',1,1,'C');
	//STATEMENT
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->Cell(0,5,'Issued in compliance with Executive Order No. 54 dated August 10, 1954 and in accordance with Circular No. 58 dated August 10, 1954 of the system.',0,1);
	
	//cerified by
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->Cell(0,5,'CERTIFIED CORRECT',0,1,'C');
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->Cell(60,5,date('M d, Y'),0,0,'C');
	$pdf->Cell(120,5,'CARLOS M. FUERZAS, JR.',0,1,'R');
	$pdf->Cell(60,5,'Date',0,0,'C');
	$pdf->Cell(120,5,'Administrative Officer V',0,1,'R');
	//Display the Output data
	$pdf->Output();
?>
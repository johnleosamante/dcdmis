<?php
session_start();
include("../vendor/jquery/function.php");
$result=mysqli_query($con,"SELECT * FROM tbl_employee WHERE Emp_ID='".$_SESSION['EmpID']."'");
$row=mysqli_fetch_assoc($result);
	//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
	
	require("../fpdf.php");
	$img1=$row['Picture'];	
		   
 	//New PDF File		 
		$pdf =new FPDF('P','mm','Legal');
	
	//Add New Page
		$pdf->AliasNbPages('{pages}');
		$pdf->AddPage();
	
	//Set Font  10	
	
		
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(0,4,'CS Form No. 212',0,1);
	$pdf->SetFont('Arial','i',8);
	$pdf->Cell(0,4,'Revised 2017',0,1);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(0,5,'PERSONAL DATA SHEET',0,1,'C');
	$pdf->Cell(0,5,'',0,1);
	$pdf->SetFont('Arial','i',7);
	$pdf->Cell(0,3,'WARNING: Any misinterpretation made in the Personal Data Sheet and the Work Experience Sheet shall cause the filing of administrative/criminal case/s ',0,1);
	$pdf->Cell(0,3,'against the person concerned.',0,1);
	$pdf->Cell(0,3,'READ THE ATTACHED GUIDE TO FILLING OUT THE PERSONAL DATA SHEET (PDS) BEFORE ACCOMPLISHING THE PDS FORM.',0,1);
	$pdf->SetFont('Arial','i',6);
	$pdf->Cell(141,3,'Print legibly. Tick appropriate boxes ( ) and use separate sheet if necessary. Indicate N/A if not applicable.  DO NOT ABBREVIATE.',0,0);
	$pdf->Cell(15,4,'1. CS ID No.',1,0);
	$pdf->Cell(40,4,' (Do not fill up. For CSC use only)',1,1,'R');
	$pdf->SetFont('Arial','',8);
	
	$pdf->SetFillColor(210,208,208);
	
	//Personal information data
	$pdf->Cell(0,6,'I. PERSONAL INFORMATION',1,1,'L',true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(5,6,'2.',0,0,'C',true);
	$pdf->Cell(25,6,'SURNAME ',0,0,'L',true);
	$pdf->Cell(165.9,6,$row['Emp_LName'],1,1);
	
	$pdf->Cell(5,6,'',0,0,'C',true);
	$pdf->Cell(25,6,'FIRST NAME ',0,0,'L',true);
	$pdf->Cell(105,6,$row['Emp_FName'],1,0);
	$pdf->Cell(61,6,'NAME EXTENSION (JR., SR) - '.$row['Emp_Extension'],1,1,'L',true);
	$pdf->Cell(5,6,'',0,0,'C',true);
	$pdf->Cell(25,6,'MIDDLE NAME',0,0,'L',true);
	$pdf->Cell(165.9,6,$row['Emp_MName'],1,1);
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->Cell(5,10,'3.',0,0,'C',true);
	$pdf->Multicell(25,5,'DATE OF BIRTH (mm/dd/yyyy) ',0,'C',true);
	$pdf->SetXY($xPos+30,$yPos);
	$pdf->Cell(50,10,$row['Emp_Month'].'/'.$row['Emp_Day'].'/'.$row['Emp_Year'],1,0);
	
	$pdf->Cell(5,10,'16.',0,0,'C',true);
	$pdf->Cell(25,10,'CITIZENSHIP',0,0,'L',true);
	$pdf->Cell(50,10,$row['Emp_Citizen'],1,1);
	 
	$pdf->Cell(5,6,'4.',0,0,'C',true);
	$pdf->Cell(25,6,'PLACE OF BIRTH ',0,0,'L',true);
	$pdf->Cell(50,6,$row['Emp_place_of_birth'],1,1);
	
	$pdf->Cell(5,6,'5.',0,0,'C',true);
	$pdf->Cell(25,6,'SEX ',0,0,'L',true);
	$pdf->Cell(50,6,$row['Emp_Sex'],1,1);
	
	
	
	
	$pdf->Cell(5,6,'6.',0,0,'C',true);
	$pdf->Cell(25,6,'CIVIL STATUS ',0,0,'L',true);
	$pdf->Cell(50,6,$row['Emp_CS'],1,1);
	
	$pdf->Cell(5,6,'7.',0,0,'C',true);
	$pdf->Cell(25,6,'HEIGHT (m)',0,0,'L',true);
	$pdf->Cell(50,6,$row['Emp_Height'],1,1);
	
	$pdf->Cell(5,6,'8.',0,0,'C',true);
	$pdf->Cell(25,6,'WEIGHT (kg)',0,0,'L',true);
	$pdf->Cell(50,6,$row['Emp_Weight'],1,1);
	
	$pdf->Cell(5,6,'9.',0,0,'C',true);
	$pdf->Cell(25,6,'BLOOD TYPE',0,0,'L',true);
	$pdf->Cell(50,6,$row['Emp_Blood_type'],1,1);
	
	$pdf->Cell(5,6,'10.',0,0,'C',true);
	$pdf->Cell(25,6,'GSIS ID NO.',0,0,'L',true);
	$pdf->Cell(50,6,'',1,1);
	
	$pdf->Cell(5,6,'11.',0,0,'C',true);
	$pdf->Cell(25,6,'PAG-IBIG ID NO.',0,0,'L',true);
	$pdf->Cell(50,6,'',1,1);
	
	$pdf->Cell(5,6,'12.',0,0,'C',true);
	$pdf->Cell(25,6,'PHILHEALTH NO.',0,0,'L',true);
	$pdf->Cell(50,6,'',1,1);
	
	$pdf->Cell(5,6,'13.',0,0,'C',true);
	$pdf->Cell(25,6,'SSS NO.',0,0,'L',true);
	$pdf->Cell(50,6,'',1,1);
	
	$pdf->Cell(5,6,'14.',0,0,'C',true);
	$pdf->Cell(25,6,'TIN NO.',0,0,'L',true);
	$pdf->Cell(50,6,$row['Emp_TIN'],1,1);
	
	$pdf->SetFont('Arial','',5);
	$pdf->Cell(5,6,'15.',0,0,'C',true);
	$pdf->Cell(25,6,'AGENCY EMPLOYEE NO.',0,0,'L',true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(50,6,'',1,1);
	
	//Family Background data
	$pdf->Cell(0,6,'II. FAMILY BACKGROUND',1,1,'L',true);
	$family=mysqli_query("SELECT * FROM family_background WHERE family_background.Emp_ID='".$_SESSION['EmpID']."' AND family_background.Relation='Wife' LIMIT 1");
	$mydata=mysqli_fetch_assoc($family);
	
	$pdf->Cell(5,6,'22.',0,0,'C',true);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(25,6,"SPOUSE'S SURNAME ",0,0,'L',true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(76,6,$mydata['Family_Name'],1,0);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(55,6,'23. NAME of CHILDREN  (Write full name and list all)',1,0,'L',true);
	$pdf->Cell(35,6,'DATE OF BIRTH (mm/dd/yyyy)',1,1,'C',true);
	$myson=mysqli_query("SELECT * FROM family_background WHERE family_background.Emp_ID='".$_SESSION['EmpID']."' AND family_background.Relation<>'Wife'");
	$mysonrow=mysqli_fetch_assoc($myson);
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(5,6,'',0,0,'C',true);
	$pdf->Cell(25,6,'FIRST NAME ',0,0,'L',true);
	$pdf->Cell(46,6,$mydata['First_Name'],1,0);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(30,6,'NAME EXTENSION (JR., SR)',1,0,'L',true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(55,6,$mysonrow['Family_Name'].', '.$mysonrow['First_Name'],1,0,'L');
	$pdf->Cell(35,6,$mysonrow['Birthdate'],1,1,'C');	
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(5,6,'',0,0,'C',true);
	$pdf->Cell(25,6,'MIDDLE NAME ',0,0,'L',true);
	$pdf->Cell(76,6,$mydata['Middle_Name'],1,0);
	$pdf->Cell(55,6,'CADUYAC, MATT IZAC',1,0,'L');
	$pdf->Cell(35,6,'2015-08-23',1,1,'C');
	
	$pdf->Cell(5,6,'',0,0,'C',true);
	$pdf->Cell(25,6,'OCCUPATION ',0,0,'L',true);
	$pdf->Cell(76,6,'',1,0);
	$pdf->Cell(55,6,'',1,0,'L');
	$pdf->Cell(35,6,'',1,1,'C');
	
	
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(5,12,'',0,0,'C',true);
	$pdf->Multicell(25,6,'EMPLOYER / BUSINESS NAME ',0,'L',true);
	$pdf->SetXY($xPos+30,$yPos);
	$pdf->Cell(76,12,'',1,0);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(55,12,'',1,0,'L');
	$pdf->Cell(35,12,'',1,1,'C');
	
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(5,6,'',0,0,'C',true);
	$pdf->Cell(25,6,'BUSINESS ADDRESS',0,0,'L',true);
	$pdf->Cell(76,6,'',1,0);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(55,6,'',1,0,'L');
	$pdf->Cell(35,6,'',1,1,'C');
	
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(5,6,'',0,0,'C',true);
	$pdf->Cell(25,6,'TELEPHONE NO.',0,0,'L',true);
	$pdf->Cell(76,6,'',1,0);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(55,6,'',1,0,'L');
	$pdf->Cell(35,6,'',1,1,'C');
	
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(5,6,'24',0,0,'C',true);
	$pdf->Cell(25,6,"FATHER'S SURNAME",0,0,'L',true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(76,6,'',1,0);
	$pdf->Cell(55,6,'',1,0,'L');
	$pdf->Cell(35,6,'',1,1,'C');
	
	
	$pdf->Cell(5,6,'',0,0,'C',true);
	$pdf->Cell(25,6,"FIRST NAME",0,0,'L',true);
	$pdf->Cell(76,6,'',1,0);
	$pdf->Cell(55,6,'',1,0,'L');
	$pdf->Cell(35,6,'',1,1,'C');
	
	
	$pdf->Cell(5,6,'',0,0,'C',true);
	$pdf->Cell(25,6,"MIDDLE NAME",0,0,'L',true);
	$pdf->Cell(76,6,'',1,0);
	$pdf->Cell(55,6,'',1,0,'L');
	$pdf->Cell(35,6,'',1,1,'C');
	
	$pdf->SetFont('Arial','',5);
	$pdf->Cell(5,6,'25',0,0,'C',true);
	$pdf->Cell(25,6,"MOTHER'S MAIDEN NAME",0,0,'L',true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(76,6,'',1,0);
	$pdf->Cell(55,6,'',1,0,'L');
	$pdf->Cell(35,6,'',1,1,'C');
	
	$pdf->Cell(5,6,'',0,0,'C',true);
	$pdf->Cell(25,6,"FIRST NAME",0,0,'L',true);
	$pdf->Cell(76,6,'',1,0);
	$pdf->Cell(55,6,'',1,0,'L');
	$pdf->Cell(35,6,'',1,1,'C');
	
	
	$pdf->Cell(5,6,'',0,0,'C',true);
	$pdf->Cell(25,6,"MIDDLE NAME",0,0,'L',true);
	$pdf->Cell(76,6,'',1,0);
	$pdf->SetFont('Arial','I',6);
	$pdf->Cell(90,6,'(Continue on separate sheet if necessary)',1,1,'L',TRUE);
	
	//EDUCATION Background data
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,6,'III. EDUCATIONAL BACKGROUND',1,1,'L',true);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(20,15,'26. LEVEL ',1,0,'C',true);
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->Multicell(40,15,'NAME OF SCHOOL (Write in full)',1,'C',true);
	$pdf->SetXY($xPos+40,$yPos);
	$pdf->Multicell(45,7.5,'BASIC EDUCATION / DEGREE / COURSE (Write in full)',1,'C',true);
	$pdf->SetXY($xPos+85,$yPos);
	$pdf->Multicell(30,5,'PERIOD OF ATTENDANCE',1,'C',true);
	$pdf->Cell(105,15,"",0,0);
	$pdf->Cell(15,10,"FROM",1,0,'C',true);
	$pdf->Cell(15,10,"TO",1,1,'C',true);
	$pdf->SetXY($xPos+115,$yPos);
	$pdf->Multicell(20,5,"HIGHEST LEVEL / UNITS EARNED (if not graduated)",1,'C',true);
	$pdf->SetXY($xPos+135,$yPos);
	$pdf->cell(20,15,"YEAR GRADUATED",1,0,'C',true);
	$pdf->Multicell(21,3.8,"SCHOLARSHIP/ ACADEMIC HONORS RECEIVED",1,'C',true);
	$pdf->SetFont('Arial','',7);
	
	$myeduc=mysqli_query("SELECT * FROM educational_background WHERE educational_background.Emp_ID ='".$_SESSION['EmpID']."' ORDER BY educational_background.From Desc LIMIT 5");
	while($Myrow=mysqli_fetch_array($myeduc))
		{
		$pdf->cell(20,10,$Myrow['Level'],1,0,'C');	
		$pdf->cell(40,10,$Myrow['Name_of_School'],1,0,'C');	
		$pdf->cell(45,10,$Myrow['Course'],1,0,'C');	
		$pdf->cell(15,10,$Myrow['From'],1,0,'C');	
		$pdf->cell(15,10,$Myrow['To'],1,0,'C');	
		$pdf->cell(20,10,$Myrow['Highest_Level'],1,0,'C');	
		$pdf->cell(20,10,$Myrow['Year_Graduated'],1,0,'C');	
		$pdf->cell(21,10,$Myrow['Honor_Recieved'],1,1,'C');	
		}
		
		$educ=mysqli_num_rows($myeduc);
		while ($educ<=5)
		{
		$pdf->cell(20,10,'',1,0,'C');	
		$pdf->cell(40,10,'',1,0,'C');	
		$pdf->cell(45,10,'',1,0,'C');	
		$pdf->cell(15,10,'',1,0,'C');	
		$pdf->cell(15,10,'',1,0,'C');	
		$pdf->cell(20,10,'',1,0,'C');	
		$pdf->cell(20,10,'',1,0,'C');	
		$pdf->cell(21,10,'',1,1,'C');
			$educ++;	
		}
	
	//sIGNATURE AND DATE
	$pdf->Cell(0,6,'',1,1,'C',true);
	$pdf->Cell(40,6,'SIGNATURE',1,0,'C',true);
	$pdf->Cell(50,6,'',1,0,'L');
	$pdf->Cell(20,6,'DATE',1,0,'C',TRUE);
	$pdf->Cell(30,6,date("m/d/Y"),1,0,'C');
	$pdf->SetFont('Arial','I',6);
	$pdf->Cell(56,6,'CS FORM 212 (Revised 2017), Page 1 of 4',1,1,'L');
	
	//IV.  CIVIL SERVICE ELIGIBILITY
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,6,'IV.  CIVIL SERVICE ELIGIBILITY',1,1,'L',true);
	$pdf->SetFont('Arial','',6);
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->Multicell(60,5,"27. CAREER SERVICE/ RA 1080 (BOARD / BAR) UNDER SPECIAL LAWS / CES / CSEE BARANGAY ELIGIBILITY / DRIVER'S LICENSE ",1,'C',true);
	$pdf->SetXY($xPos+60,$yPos);
	$pdf->Multicell(20,7.5,'RATING (If Applicable)',1,'C',true);
	$pdf->SetXY($xPos+80,$yPos);
	$pdf->Multicell(20,5,'DATE OF EXAMINATION / CONFERMENT',1,'C',true);
	$pdf->SetXY($xPos+100,$yPos);
	$pdf->Cell(50,15,'PLACE OF EXAMINATION / CONFERMENT',1,0,'C',true);
	$pdf->SetXY($xPos+150,$yPos);
	$pdf->Multicell(46,5,'LICENSE (if applicable)',1,'C',true);
	$pdf->Cell(150,15,"",0,0);
	$pdf->Cell(23,10,"FROM",1,0,'C',true);
	$pdf->Cell(23,10,"TO",1,1,'C',true);
	$pdf->SetFont('Arial','',7);
	//getting data
	$myservice=mysqli_query("SELECT * FROM civil_service WHERE civil_service.Emp_ID ='".$_SESSION['EmpID']."' LIMIT 10");
	while($Myserve=mysqli_fetch_array($myservice))
		{
		$pdf->cell(60,10,$Myserve['Carrer_Service'],1,0,'C');	
		$pdf->cell(20,10,$Myserve['Rating'],1,0,'C');	
		$pdf->cell(20,10,$Myserve['Date_of_Examination'],1,0,'C');	
		$pdf->cell(50,10,$Myserve['Place_of_Examination'],1,0,'C');	
		$pdf->cell(23,10,$Myserve['Number_of_Hour'],1,0,'C');	
		$pdf->cell(23,10,$Myserve['Date_of_Validity'],1,1,'C');	
			
		}
		$w = mysqli_num_rows($myservice);
 
		while($w <= 9) {
		$pdf->cell(60,10,'',1,0,'C');	
		$pdf->cell(20,10,'',1,0,'C');	
		$pdf->cell(20,10,'',1,0,'C');	
		$pdf->cell(50,10,'',1,0,'C');	
		$pdf->cell(23,10,'',1,0,'C');	
		$pdf->cell(23,10,'',1,1,'C');
		 $w++;
		}
	$pdf->SetFont('Arial','i',6);
	$pdf->Cell(0,6,'(Continue on separate sheet if necessary)',1,1,'C',true);
	
	//V.  WORK EXPERIENCE 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,6,'V. WORK EXPERIENCE ',1,1,'L',true);
	$pdf->SetFont('Arial','i',7);
	$pdf->Cell(0,6,'(Include private employment.  Start from your recent work) Description of duties should be indicated in the attached Work Experience sheet.',1,1,'L',true);
	$pdf->SetFont('Arial','',6);
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->Multicell(30,3.5,"28. INCLUSIVE DATES (mm/dd/yyyy)",1,'C',true);
	$pdf->Cell(15,7,"FROM",1,0,'C',true);
	$pdf->Cell(15,7,"TO",1,1,'C',true);
	$pdf->SetXY($xPos+30,$yPos);
	$pdf->Multicell(30,7,"POSITION TITLE (Write in full / Do not abbreviate)",1,'C',true);
	$pdf->SetXY($xPos+60,$yPos);
	$pdf->Multicell(50,7,"DEPARTMENT / AGENCY / OFFICE / COMPANY (Write in full/Do not abbreviate)",1,'C',true);
	$pdf->SetXY($xPos+110,$yPos);
	$pdf->Multicell(20,7,"MONTHLY SALARY",1,'C',true);
	$pdf->SetXY($xPos+130,$yPos);
	$pdf->Multicell(30,4.7,"SALARY/ JOB/ PAY GRADE (if applicable)& STEP  (Format '00-0')/ INCREMENT",1,'C',true);
	$pdf->SetXY($xPos+160,$yPos);
	$pdf->Multicell(20,7,"STATUS OF APPOINTMENT",1,'C',true);
	$pdf->SetXY($xPos+180,$yPos);
	$pdf->Multicell(16,4.7,"GOV'T SERVICE       (Y/ N)",1,'C',true);
	
	$pdf->SetFont('Arial','',7);
	//getting data
	$mywork=mysqli_query("SELECT * FROM work_experience WHERE work_experience.Emp_ID ='".$_SESSION['EmpID']."'  ORDER BY work_experience.From Desc LIMIT 15");
	while($MyRow=mysqli_fetch_array($mywork))
		{
		$pdf->cell(15,10,$MyRow['From'],1,0,'C');	
		$pdf->cell(15,10,$MyRow['To'],1,0,'C');	
		$pdf->cell(30,10,$MyRow['Position_Title'],1,0,'C');	
		$pdf->cell(50,10,$MyRow['Organization'],1,0,'C');	
		$pdf->cell(20,10,number_format($MyRow['Monthly_Salary'],2),1,0,'C');	
		$pdf->cell(30,10,$MyRow['Salary_Grade'],1,0,'C');	
		$pdf->cell(20,10,$MyRow['Job_Status'],1,0,'C');	
		$pdf->cell(16,10,$MyRow['Goverment'],1,1,'C');	
			
		}
		$x = mysqli_num_rows($mywork);
 
		while($x <= 14) {
		 $pdf->cell(15,10,'',1,0,'C');	
		$pdf->cell(15,10,'',1,0,'C');	
		$pdf->cell(30,10,'',1,0,'C');	
		$pdf->cell(50,10,'',1,0,'C');	
		$pdf->cell(20,10,'',1,0,'C');	
		$pdf->cell(30,10,'',1,0,'C');	
		$pdf->cell(20,10,'',1,0,'C');	
		$pdf->cell(16,10,'',1,1,'C');
		  $x++;
		} 

				
		
	$pdf->SetFont('Arial','i',6);
	$pdf->Cell(0,6,'(Continue on separate sheet if necessary)',1,1,'C',true);
	
	//sIGNATURE AND DATE
	$pdf->Cell(0,6,'',1,1,'C',true);
	$pdf->Cell(40,6,'SIGNATURE',1,0,'C',true);
	$pdf->Cell(50,6,'',1,0,'L');
	$pdf->Cell(20,6,'DATE',1,0,'C',TRUE);
	$pdf->Cell(30,6,date("m/d/Y"),1,0,'C');
	$pdf->SetFont('Arial','I',6);
	$pdf->Cell(56,6,'CS FORM 212 (Revised 2017), Page 2 of 4',1,1,'L');
	
	
	//VI. VOLUNTARY WORK OR INVOLVEMENT IN CIVIC / NON-GOVERNMENT / PEOPLE / VOLUNTARY ORGANIZATION/S
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,6,'VI. VOLUNTARY WORK OR INVOLVEMENT IN CIVIC / NON-GOVERNMENT / PEOPLE / VOLUNTARY ORGANIZATION/S',1,1,'L',true);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(80,14,"29. NAME & ADDRESS OF ORGANIZATION  (Write in full)",1,0,'L',true);
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->Multicell(30,3.5,"INCLUSIVE DATES (mm/dd/yyyy)",1,'C',true);
	$pdf->Cell(80,14,"",0,0);
	$pdf->Cell(15,7,"FROM",1,0,'C',true);
	$pdf->Cell(15,7,"TO",1,0,'C',true);
	$pdf->SetXY($xPos+30,$yPos);
	$pdf->Cell(30,14,"NUMBER OF HOURS",1,0,'C',true);
	$pdf->Cell(56,14,"POSITION / NATURE OF WORK",1,1,'C',true);
	
	$pdf->SetFont('Arial','',7);
	$myvolunt=mysqli_query("SELECT * FROM voluntary_work WHERE voluntary_work.Emp_ID ='".$_SESSION['EmpID']."'  ORDER BY voluntary_work.From Desc LIMIT 5");
	while($Mytary=mysqli_fetch_array($myvolunt))
		{
			$pdf->Cell(80,10,$Mytary['Name_of_Organization'],1,0);
			$pdf->Cell(15,10,$Mytary['From'],1,0);
			$pdf->Cell(15,10,$Mytary['To'],1,0);
			$pdf->Cell(30,10,$Mytary['Number_of_Hour'],1,0,'C');
			$pdf->Cell(56,10,$Mytary['Position'],1,1);
		}
	
	$vol = mysqli_num_rows($myvolunt);
 
		while($vol <= 5) {
			//Next
			$pdf->Cell(80,10,'',1,0);
			$pdf->Cell(15,10,'',1,0);
			$pdf->Cell(15,10,'',1,0);
			$pdf->Cell(30,10,'',1,0);
			$pdf->Cell(56,10,'',1,1);
			$vol++;
		}
	
	$pdf->SetFont('Arial','i',6);
	$pdf->Cell(0,6,'(Continue on separate sheet if necessary)',1,1,'C',true);
	
	//VII.  LEARNING AND DEVELOPMENT (L&D) INTERVENTIONS/TRAINING PROGRAMS ATTENDED
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,6,'VII.  LEARNING AND DEVELOPMENT (L&D) INTERVENTIONS/TRAINING PROGRAMS ATTENDED',1,1,'L',true);
	$pdf->SetFont('Arial','i',6);
	$pdf->Cell(0,6,'(Start from the most recent L&D/training program and include only the relevant L&D/training taken for the last five (5) years for Division Chief/Executive/Managerial positions)',1,1,'L',true);
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->Multicell(70,7,"30. TITLE OF LEARNING AND DEVELOPMENT INTERVENTIONS / TRAINING PROGRAMS (Write in full)",1,'C',true);
	$pdf->SetXY($xPos+70,$yPos);
	$pdf->Multicell(30,7,"INCLUSIVE DATES OF ATTENDANCE (mm/dd/yyyy)",1,'C',true);
	$pdf->SetXY($xPos+100,$yPos);
	$pdf->Multicell(30,14,"NUMBER OF HOURS",1,'C',true);
	$pdf->SetXY($xPos+130,$yPos);
	$pdf->Multicell(39,7,"Type of LD ( Managerial/ Supervisory/ Technical/ etc) ",1,'C',true);
	$pdf->SetXY($xPos+169,$yPos);
	$pdf->Multicell(27,4.6,"CONDUCTED / SPONSORED BY               (Write in full) ",1,'C',true);
	
	$pdf->SetFont('Arial','',7);
	$mylearn=mysqli_query("SELECT * FROM learning_and_development WHERE learning_and_development.Emp_ID ='".$_SESSION['EmpID']."'  ORDER BY learning_and_development.From Desc LIMIT 9");
	while($Mylear=mysqli_fetch_array($mylearn))
		{
			$pdf->Cell(70,10,$Mylear['Title_of_Training'],1,0);
			$pdf->Cell(15,10,$Mylear['From'],1,0);
			$pdf->Cell(15,10,$Mylear['To'],1,0);
			$pdf->Cell(30,10,$Mylear['Number_of_Hours'],1,0,'C');
			$pdf->Cell(39,10,$Mylear['Managerial'],1,0);
			$pdf->Cell(27,10,$Mylear['Conducted'],1,1);	
		}
	
	$learn = mysqli_num_rows($mylearn);
 
		while($learn <= 9) {
			//Next
			$pdf->Cell(70,10,'',1,0);
			$pdf->Cell(15,10,'',1,0);
			$pdf->Cell(15,10,'',1,0);
			$pdf->Cell(30,10,'',1,0);
			$pdf->Cell(39,10,'',1,0);
			$pdf->Cell(27,10,'',1,1);
			$learn++;
		}
	
	//VIII.  OTHER INFORMATION
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,6,'VIII.  OTHER INFORMATION',1,1,'L',true);
	$pdf->SetFont('Arial','',7);
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->Cell(70,10,'31. SPECIAL SKILLS and HOBBIES',1,0,'C',true);
	$pdf->Multicell(70,5,'32. NON-ACADEMIC DISTINCTIONS / RECOGNITION (Write in full)',1,'C',true);
	$pdf->SetXY($xPos+140,$yPos);
	$pdf->Multicell(56,5,'33. MEMBERSHIP IN ASSOCIATION / ORGANIZATION (Write in full)',1,'C',true);
	
	$myother=mysqli_query("SELECT * FROM other_information WHERE other_information.Emp_ID ='".$_SESSION['EmpID']."' LIMIT 6");
	while($Myther=mysqli_fetch_array($myother))
		{
			$pdf->Cell(70,10,$Myther['Special_Skills'],1,0);
			$pdf->Cell(70,10,$Myther['Recognation'],1,0);
			$pdf->Cell(56,10,$Myther['Organization'],1,1);	
		}
	
	$other = mysqli_num_rows($myother);
 
		while($other <= 6) {
			
			$pdf->Cell(70,10,'',1,0);
			$pdf->Cell(70,10,'',1,0);
			$pdf->Cell(56,10,'',1,1);
			$other++;
		}
	$pdf->SetFont('Arial','i',6);
	$pdf->Cell(0,6,'(Continue on separate sheet if necessary)',1,1,'C',true);
	
	//sIGNATURE AND DATE
	$pdf->Cell(0,6,'',1,1,'C',true);
	$pdf->Cell(40,6,'SIGNATURE',1,0,'C',true);
	$pdf->Cell(50,6,'',1,0,'L');
	$pdf->Cell(20,6,'DATE',1,0,'C',TRUE);
	$pdf->Cell(30,6,date("m/d/Y"),1,0,'C');
	$pdf->SetFont('Arial','I',6);
	$pdf->Cell(56,6,'CS FORM 212 (Revised 2017), Page 3 of 4',1,1,'L');
	
	
	//questioners
	$pdf->Cell(0,6,'',0,1);
	$pdf->SetFont('Arial','',8);
	
	$pdf->Multicell(140,7,'24. Are you related by consanguinity or affinity to the appointing or recommending authority, or to the chief of bureau or office or to the person who has immediate supervision over you in the Office, Bureau or Department where you will be apppointed,  
	a. within the third degree? 
	b. within the fourth degree (for Local Government Unit - Career Employees)?',1,'L',true);
	
	
	$pdf->Multicell(140,7,'35. a. Have you ever been found guilty of any administrative offense? 
							      b. Have you been criminally charged before any court?',1,'L',true);	
	$pdf->Multicell(140,7,'36. Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?',1,'L',true);	
	$pdf->Multicell(140,7,'37. Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?',1,'L',true);	
	$pdf->Multicell(140,7,'38. a. Have you ever been a candidate in a national or local election held within the last year (except Barangay election)?
	b. Have you resigned from the government service during the three (3)-month period before the last election to promote/actively campaign for a national or local candidate?',1,'L',true);	
	
	$pdf->Multicell(140,7,'39. Have you acquired the status of an immigrant or permanent resident of another country?',1,'L',true);	
	$pdf->Multicell(140,7,"40. Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items: 
	a. Are you a member of any indigenous group?
	b. Are you a person with disability?
	c. Are you a solo parent?",1,'L',true);	
	
	
	//REFERENCES
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(140,10,'41. REFERENCES (Person not related by consanguinity or affinity to applicant /appointee)',1,1,'L',true);
	
	$pdf->Cell(50,10,'NAME',1,0,'C',true);
	$pdf->Cell(60,10,'ADDRESS',1,0,'C',true);
	$pdf->Cell(30,10,'TEL. NO.',1,1,'C',true);
	
	$myreference=mysqli_query("SELECT * FROM reference WHERE reference.Emp_ID ='".$_SESSION['EmpID']."' LIMIT 3");
	while($Myref=mysqli_fetch_array($myreference))
		{
		$pdf->Cell(50,10,$Myref['Name'],1,0,'C');
		$pdf->Cell(60,10,$Myref['Address'],1,0,'C');
		$pdf->Cell(30,10,$Myref['Tel_No'],1,1,'C');	
		}
		$ref=mysqli_num_rows($myreference);
		while ($ref <= 2)
		{
			$pdf->Cell(50,10,'',1,0,'C');
			$pdf->Cell(60,10,'',1,0,'C');
			$pdf->Cell(30,10,'',1,1,'C');	
			$ref++;
		}
	
	$pdf->Multicell(140,5,'42. I declare under oath that I have personally accomplished this Personal Data Sheet which is a true, correct and complete statement pursuant to the provisions of pertinent laws, rules and regulations of the Republic of the Philippines. I authorize the agency head / authorized representative to verify/validate the contents stated herein. I  agree that any misrepresentation made in this document and its attachments shall cause the filing of administrative/criminal case/s against me.',1,1,'L',true);
	$pdf->Cell(0,3,'',0,1,'C');
	$pdf->SetFont('Arial','i',6);
	$pdf->Image($img1,155,175,40);
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->Multicell(65,3.3,"Government Issued ID (i.e.Passport, GSIS, SSS, PRC, Driver's License, etc.) PLEASE INDICATE ID Number and Date of Issuance",1,'L',true);
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(65,10,"Government Issued ID: ",1,1,'L');
	$pdf->Cell(65,10,"ID/License/Passport No.:  ",1,1,'L');
	$pdf->Cell(65,10,"Date/Place of Issuance:  ",1,1,'L');
	$pdf->SetXY($xPos+70,$yPos);
	$pdf->Multicell(70,23,'',1);
	$pdf->Cell(70,10,"",0,0,'L');
	$pdf->Cell(70,5,'Signature (Sign inside the box)',1,1,'C',true);
	$pdf->Cell(70,10,"",0,0,'L');
	$pdf->Cell(70,7,'',1,1,'C');
	$pdf->Cell(70,10,"",0,0,'L');
	$pdf->Cell(70,5,'Date Accomplished',1,1,'C',true);
	
	$pdf->SetXY($xPos+145,$yPos);
	$pdf->Multicell(40,35,'',1);
	$pdf->Cell(145,10,"",0,0,'L');
	$pdf->Cell(40,5,'Right Thumbmark',1,1,'C',true);
	$pdf->Cell(0,3,'',0,1,'C');
	$pdf->Multicell(195,40,'',1);
	$pdf->SetFont('Arial','i',7);
	$pdf->SetXY($xPos,$yPos+45);
	$pdf->Multicell(195,2.5,'SUBSCRIBED AND SWORN to before me this __________________________________, affiant exhibiting his/her validly issued government ID as indicated above.',0);
	$pdf->SetXY($xPos,$yPos+55);
	$pdf->Cell(73,5,'',0,0,'C');
	$pdf->Multicell(60,20,'',1);
	$pdf->Cell(73,5,'',0,0,'C');
	$pdf->Cell(60,5,'Person Administering Oath',1,1,'C',true);
	
	$pdf->SetFont('Arial','i',6);
	$pdf->Cell(0,5," ",0,1,'L');
	$pdf->Cell(0,5,"CS FORM 212 (Revised 2017),  Page 4 of 4  ",1,1,'R');
	
	
	
	
	//Display the Output data
	$pdf->Output();
?>
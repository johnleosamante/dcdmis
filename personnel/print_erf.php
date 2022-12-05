<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
$result=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN psipop ON tbl_employee.Emp_TIN=psipop.TIN INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code WHERE tbl_employee.Emp_ID='".$_SESSION['EmpID']."'");
$row=mysqli_fetch_assoc($result);

require('../code128.php');
$pdf=new PDF_Code128('P','mm','Legal');
//set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';
    include "qrlib.php";    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    $finame = $PNG_TEMP_DIR.$_SESSION['EmpID'].'.png';
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    $matrixPointSize = 5;
   $_REQUEST['data']=$_SESSION['TCode'];
    if (isset($_REQUEST['data'])) {        
        // user data
        $finame = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_REQUEST['data'], $finame, $errorCorrectionLevel, $matrixPointSize, 2);    
    } else {    
        QRcode::png('PHP QR Code :)', $finame, $errorCorrectionLevel, $matrixPointSize, 2);    
    }    




$img1='../shs/h1.png';	
$img2='../shs/deped.png';
$img3=$PNG_WEB_DIR.basename($finame);

//Add New Page
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();
$pdf->SetFont('Arial','',10);

//Display Images
$pdf->Image($img1,165,10,30);
$pdf->Image($img2,30,10,20);
$pdf->Image($img3,10,320,23);

//Header Information
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'Republic of the Philippines',0,1,'C');
	$pdf->Cell(0,5,'Department of Education',0,1,'C');
	$pdf->Cell(0,5,'Region IX, Zamboanga Peninsula',0,1,'C');
	$pdf->Cell(0,5,'DIVISION OF PAGADIAN CITY',0,1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,5,'Pagadian City',0,1,'C');
	$pdf->Cell(0,5,'',0,1);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(0,5,'EQUIVALENT RECORD FORM',0,1,'C');
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(0,5,'(Submit in Five Copies)',0,1,'C');
	$pdf->Cell(0,5,'',0,1);
	$pdf->SetFont('Arial','',9);
	
	//Name of the Employeer
	$pdf->Cell(10,5,'NAME:_______________________________________',0,0);
	$pdf->Cell(25,5,$row['Emp_LName'],0,0,'C');
	$pdf->Cell(25,5,$row['Emp_FName'],0,0,'C');
	$pdf->Cell(25,5,$row['Emp_MName'],0,0,'C');
	$pdf->Cell(30,5,'Date of Birth: _____________________',0,0,'L');
	$pdf->Cell(40,5,$row['Emp_Month'].'/'.$row['Emp_Day'].'/'.$row['Emp_Year'],0,0,'L');
	$pdf->Cell(20,5,'Gender: _____________',0,0,'L');
	$pdf->Cell(15,5,$row['Emp_Sex'],0,1,'L');
	
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(10,3,'',0,0,'C');
	$pdf->Cell(25,3,'(Surname)',0,0,'C');
	$pdf->Cell(20,3,'(Given)',0,0,'C');
	$pdf->Cell(20,3,'(M.I)',0,1,'C');
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(0,3,'',0,1,'C');
	$pdf->Cell(22,5,'Employee No.: '.$row['Emp_ID'],0,0,'L');
	$pdf->Cell(40,5,'______________',0,0,'L');
	$pdf->Cell(30,5,'',0,0,'C');
	$pdf->Cell(37,5,'Authorized Position Title: '.$row['Job_description'],0,0,'L');
	$pdf->Cell(50,5,'___________________________',0,1,'L');
	
	$pdf->Cell(0,3,'',0,1,'C');
	$pdf->Cell(15,5,'Item No.:   '.$row['Item_Number'],0,0,'L');
	$pdf->Cell(55,5,'_______________________________',0,0,'C');
	$pdf->Cell(10,5,'',0,0,'C');
	$pdf->Cell(21,5,'Salary Grade:    '.$row['Salary_Grade'],0,0,'L');
	$pdf->Cell(10,5,'____',0,0,'L');
	
	$pdf->Cell(38,5,'Authorized Annual Salary:  '.number_format($row['Autorized'],2),0,0,'L');
	$pdf->Cell(30,5,'_____________',0,1,'L');
	
	$pdf->Cell(0,3,'',0,1,'C');
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(30,5,'I. Educational Attainment ',0,1,'L');
	$pdf->Cell(0,2,'',0,1,'C');
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->Multicell(40,5,'Masters Degree  
	(write in full with specialization)',1,'C');
	$pdf->SetXY($xPos+40,$yPos);
	$pdf->Multicell(40,5,'Completed/ 
	Units Earned 
	(if not completed)',1,'C');
	$pdf->SetXY($xPos+80,$yPos);
	$pdf->Multicell(50,15,'Name of School',1,'C');
	$pdf->SetXY($xPos+130,$yPos);
	$pdf->Multicell(30,15,'Year Completed',1,'C');
	$pdf->SetXY($xPos+160,$yPos);
	$pdf->Multicell(30,15,'Equivalent',1,'C');
	$pdf->SetFont('Arial','',9);
	//Educational data
	
	$edu=mysqli_query($con,"SELECT * FROM educational_background WHERE educational_background.Emp_ID='".$_SESSION['EmpID']."' AND educational_background.Level ='Masteral' ORDER BY Year_Graduated Desc");
	while($myedu=mysqli_fetch_array($edu))
	{
	$pdf->Cell(40,5,$myedu['Course'],1,0,'C');
	$pdf->Cell(40,5,$myedu['Highest_Level'],1,0,'C');
	$pdf->Cell(50,5,$myedu['Name_of_School'],1,0,'C');
	$pdf->Cell(30,5,$myedu['Year_Graduated'],1,0,'C');
	$pdf->Cell(30,5,'',1,1,'C');
	}
	
	$x=mysqli_num_rows($edu);
	while($x<=2)
	{
	$pdf->Cell(40,5,'',1,0,'C');
	$pdf->Cell(40,5,'',1,0,'C');
	$pdf->Cell(50,5,'',1,0,'C');
	$pdf->Cell(30,5,'',1,0,'C');
	$pdf->Cell(30,5,'',1,1,'C');
	$x++;
	}
	$no_of_year=mysqli_query($con,"SELECT * FROM tbl_deployment_history WHERE tbl_deployment_history.Emp_ID='".$_SESSION['EmpID']."' LIMIT 1");
	$ydata=mysqli_fetch_assoc($no_of_year);
	$pdf->Cell(0,3,'',0,1,'C');
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(30,10,'II. Years of Teaching Experience: ________________ ',0,1,'L');
	$pdf->Cell(30,5,'',0,0,'L');
	$pdf->Cell(30,5,'Private: _____________________',0,1,'L');
	$pdf->Cell(30,5,'',0,0,'L');
	$pdf->Cell(20,5,'Public: ______________________',0,0,'L');
	$pdf->Cell(30,5,$ydata['No_of_years'].' Years',0,1,'L');
	
	
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(30,10,'III. Trainings Attended ',0,1,'L');
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->Cell(70,10,'Title',1,0,'C');
	$pdf->Multicell(40,5,'Inclusive Date',1,'C');
	$pdf->Cell(70,5,'',0,0,'C');
	$pdf->Cell(20,5,'From',1,0,'C');
	$pdf->Cell(20,5,'To',1,0,'C');
	$pdf->SetXY($xPos+110,$yPos);
	$pdf->Cell(30,10,'Number of Hours',1,0,'C');
	$pdf->Cell(60,10,'Sponsoring Agency',1,1,'C');
	$pdf->SetFont('Arial','',9);
	//My trainings
	$training=mysqli_query($con,"SELECT * FROM learning_and_development WHERE learning_and_development.Emp_ID='".$_SESSION['EmpID']."' LIMIT 3");
	while($mytrain=mysqli_fetch_array($training))
	{
	$pdf->Cell(70,5,$mytrain['Title_of_Training'],1,0,'C');
	$pdf->Cell(20,5,$mytrain['From'],1,0,'C');
	$pdf->Cell(20,5,$mytrain['To'],1,0,'C');
	$pdf->Cell(30,5,$mytrain['Number_of_Hours'],1,0,'C');
	$pdf->Cell(60,5,$mytrain['Conducted'],1,1,'C');	
	}
	$y=mysqli_num_rows($training);
	while($y<=2)
	{
	$pdf->Cell(70,5,'',1,0,'C');
	$pdf->Cell(20,5,'',1,0,'C');
	$pdf->Cell(20,5,'',1,0,'C');
	$pdf->Cell(30,5,'',1,0,'C');
	$pdf->Cell(60,5,'',1,1,'C');
	$y++; 
	}
	$pdf->Cell(0,3,'',0,1,'C');
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(0,5,'IV. For Head Teacher Position and Other Related Teaching Position ',0,1,'L');
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(30,5,'Years of Experience in Present Position',0,1,'L');
	$pdf->Cell(0,3,'',0,1,'C');
	$pdf->SetFont('Arial','B',9);
	$ipcr=mysqli_query($con,"SELECT * FROM tbl_ipcrf_rating WHERE tbl_ipcrf_rating.Emp_ID='".$_SESSION['EmpID']."' ORDER BY School_Year Desc LIMIT 1");
	$ripcr=mysqli_fetch_assoc($ipcr);
	$pdf->Cell(50,5,'V. Latest Performance Rating: _________',0,0,'L');
	$pdf->Cell(30,5,$ripcr['Rating'],0,1,'L');
	$pdf->Cell(140,5,'',0,0,'L');
	$pdf->Cell(30,5,'_____________________',0,1,'C');
	$pdf->Cell(140,5,'',0,0,'L');
	$pdf->Cell(30,5,"(Teacher's Signature)",0,1,'C');
	
	$pdf->Cell(0,3,'',0,1,'C');
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(40,5,'VI. School Division Action',0,0,'L');
	$pdf->SetFont('Arial','i',9);
	$pdf->Cell(55,5,'(For Schools Division Evaluator Only) ',0,1,'C');
	
	$pdf->Cell(40,10,'Classification',1,0,'C');
	$pdf->Cell(30,10,'Date Processed',1,0,'C');
	$pdf->Cell(35,10,'Range Assignment',1,0,'C');
	$pdf->Cell(25,10,'Salary Grade',1,0,'C');
	$pdf->Cell(30,10,'Salary Schedule',1,0,'C');
	$pdf->Cell(30,10,'Remarks',1,1,'C');
	
	$z=1;
	 
	 while($z <= 2)
		{
			$pdf->Cell(40,5,'',1,0,'C');
			$pdf->Cell(30,5,'',1,0,'C');
			$pdf->Cell(35,5,'',1,0,'C');
			$pdf->Cell(25,5,'',1,0,'C');
			$pdf->Cell(30,5,'',1,0,'C');
			$pdf->Cell(30,5,'',1,1,'C');
			$z++;
		}
	$sigAO=mysqli_query($con,"SELECT * FROM tbl_deped_official WHERE signature_position='AO' LIMIT 1");
	$rsig=mysqli_fetch_assoc($sigAO);	
	$pdf->Cell(0,3,'',0,1,'C');
	$pdf->Cell(30,5,'Certified Correct: ',0,0,'C');
	$pdf->Cell(80,5,'',0,0,'C');
	$pdf->Cell(40,5,'Recommending Approval:  ',0,1,'C');
	
	$pdf->Cell(0,4,'',0,1,'C');
	$pdf->Cell(10,5,'________________________________ ',0,0,'L');
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(40,5,$rsig['signature_name'],0,0,'L');
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(70,5,'',0,0,'C');
	$SDS=mysqli_query($con,"SELECT * FROM tbl_deped_official WHERE signature_position='SDS' LIMIT 1");
	$rsigSDS=mysqli_fetch_assoc($SDS);
	$pdf->Cell(10,5,'_________________________________ ',0,0,'L');
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(40,5,$rsigSDS['signature_name'],0,1,'C');
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(60,5,'AO IV-Personnel ',0,0,'C');
	$pdf->Cell(50,5,'',0,0,'C');
	$pdf->Cell(80,5,'Schools Division Superintendent',0,1,'C');
	$pdf->Cell(60,5,'School Division Evaluator ',0,1,'C');
	
	
	$pdf->Cell(0,3,'',0,1,'C');
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(0,5,'VII. DepEd Regional Office Action',0,1,'L');
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(80,5,'Classification: ______________________',0,0,'L');
	$pdf->Cell(90,5,'Post Audited Assignment: ______________________',0,1,'R');
	$pdf->Cell(80,5,'Date Processed:_____________________',0,0,'L');
	$pdf->Cell(90,5,'Salary Grade: ______________________',0,1,'R');
	$pdf->Cell(80,5,'',0,0,'L');
	$pdf->Cell(90,5,'Salary Schedule: ______________________',0,1,'R');
	$pdf->Cell(80,5,'',0,0,'L');
	$pdf->Cell(90,5,'Remarks: ______________________',0,1,'R');
	$pdf->Cell(0,3,'',0,1,'C');
	$pdf->Cell(80,5,'',0,0,'L');
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(80,5,'Approved',0,1,'C');
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->Cell(60,5,'_____________________ ',0,0,'C');
	$pdf->Cell(60,5,'',0,0,'C');
	$RD=mysqli_query($con,"SELECT * FROM tbl_deped_official WHERE signature_position='RD' LIMIT 1");
	$rsigRD=mysqli_fetch_assoc($RD);
	$pdf->Cell(5,5,'_________________________________ ',0,0,'L');
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(50,5,$rsigRD['signature_name'],0,1,'C');
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(60,5,'Evaluator',0,0,'C');
	$pdf->Cell(60,5,'',0,0,'C');
	$pdf->Cell(60,5,'OIC-Assistance Regional Director',0,1,'C');
	
	$pdf->Cell(0,5,'',0,1,'C');
//Generate Barcode
//$code=$_SESSION['TCode'];
//$code=$_SESSION['EmpID'];
//$pdf->Code128(10,315,$code,50,15);
//$pdf->SetXY(10,330);
//$pdf->Write(5,'TRK #: '.$code);

$pdf->Cell(0,10,'',0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,10,'CHECKLIST OF REQUIREMENTS',0,1,'C');
$pdf->Cell(0,10,'',0,1);
$pdf->Cell(5,5,'',1,0,'C');
$pdf->Cell(0,5,' Personal Data Sheets - 3 Copies (Authenticated) ',0,1,'L');
$pdf->Cell(5,5,'',1,0,'C');
$pdf->Cell(0,5,' Performance Ratings for the last 3 school years - 3 copies (authenticated)  ',0,1,'L');
$pdf->Cell(5,5,'',1,0,'C');
$pdf->Cell(0,5,' Latest approved appoinment - 3 copies (authenticated)',0,1,'L');
$pdf->Cell(5,5,'',1,0,'C');
$pdf->Cell(0,5,' Latest Payslip - 1 Copies (Authenticated)',0,1,'L');
$pdf->Cell(5,5,'',1,0,'C');
$pdf->Cell(0,5,' PRC License - 1 Copy (Authenticated)',0,1,'L');
$pdf->Cell(5,5,'',1,0,'C');
$pdf->Cell(0,5,' Certificates / trainings - 1 copy (authenticated) ',0,1,'L');
$pdf->Cell(5,5,'',1,0,'C');
$pdf->Cell(0,5,' Permit to Study - 1 Copy each (authenticated)  ',0,1,'L');
$pdf->Cell(5,5,'',1,0,'C');
$pdf->Cell(0,5,' Sworn Statement - 1 copy (original) ',0,1,'L');
$pdf->Cell(0,15,'',0,1,'L');
$pdf->Cell(0,5,'Noted:',0,1,'L');
$pdf->Cell(20,5,'',0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->multicell(0,5,"after you complied all requirements listed, pass all documents to the records section for Evaluation and Assessment in HRMO Department and don't forget the control number for tracking the status..",0);

//View Output
$pdf->Output();
?>

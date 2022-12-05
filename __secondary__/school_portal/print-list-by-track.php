<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
foreach ($_GET as $key => $data)
{
$link=$_GET[$key]=base64_decode(urldecode($data));
	
}
		require("../../pcdmis/fpdf.php"); 
   //Images
	$img1='../../pcdmis/shs/h1.png';	
	$img2='../../pcdmis/logo/logo.png';	
 	//New PDF File		 
		$pdf =new FPDF('P','mm','Legal');
	//Add New Page
		$pdf->AliasNbPages('{pages}');
		$pdf->AddPage();
		
	$pdf->Image($img1,40,10,20);
	$pdf->Image($img2,155,10,15);
	//Set Font  10	
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'Republic of the Philippines',0,1,'C');
	$pdf->Cell(0,5,'Department of Education',0,1,'C');
	$pdf->Cell(0,5,'Region IX, Zamboanga Peninsula',0,1,'C');
	$pdf->Cell(0,5,'DIVISION OF PAGADIAN CITY',0,1,'C');
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->Cell(0,4,$_SESSION['SchoolName'],0,1,'C');
	$pdf->Cell(0,4,$_SESSION['Address'],0,1,'C');
	$pdf->Cell(0,3,'',0,1,'C');
	$pdf->SetFont('Arial','i',10);
	$pdf->Cell(15,4,'Grade: ',0,0,'L');
	$pdf->Cell(0,4,$_GET['Grade'],0,1,'L');
	$qual=mysqli_query($con,"SELECT * FROM tbl_qualification_by_school INNER JOIN tbl_qualification ON tbl_qualification_by_school.QualCode =tbl_qualification.SpCode WHERE tbl_qualification_by_school.SchoolID='".$_SESSION['school_id']."' AND tbl_qualification.Grade ='".$_GET['Grade']."' AND tbl_qualification_by_school.QualSem ='".$link."' AND tbl_qualification.SpCode='".$_GET['Code']."' LIMIT 1");
										
	$data=mysqli_fetch_assoc($qual);
	$pdf->Cell(0,4,'Strand: '.$data['Description'],0,1,'L');
	
	
	$pdf->Cell(0,3,'',0,1,'C');
	$pdf->SetFont('Arial','',10);
	
	$pdf->Cell(23,5,'LRN',1,0,'C');
	$pdf->Cell(30,5,'Last Name',1,0,'C');
	$pdf->Cell(30,5,'First Name',1,0,'C');
	$pdf->Cell(30,5,'Middle Name',1,0,'C');
	$pdf->Cell(15,5,'Sex',1,0,'C');
	$pdf->Cell(70,5,'Address',1,1,'C');
	//Display data from database
	$pdf->SetFont('Arial','',8);
	if ($_SESSION['Sem']=='First Semester')
	{
	$myinfo=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn = tbl_student.lrn WHERE first_semester.Grade='".$_GET['Grade']."' AND first_semester.school_year='".$_SESSION['year']."' AND first_semester.SchoolID='".$_SESSION['school_id']."' AND first_semester.SpCode='".$_GET['Code']."' GROUP BY tbl_student.lrn ORDER BY tbl_student.Lname Asc");
	}elseif ($_SESSION['Sem']=='Second Semester')
	{
	$myinfo=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn = tbl_student.lrn WHERE second_semester.Grade='".$_GET['Grade']."' AND second_semester.school_year='".$_SESSION['year']."' AND second_semester.SchoolID='".$_SESSION['school_id']."' AND second_semester.SpCode='".$_GET['Code']."' GROUP BY tbl_student.lrn ORDER BY tbl_student.Lname Asc");
	}
	while($row=mysqli_fetch_array($myinfo))
		{
			$pdf->Cell(23,5,$row['lrn'],1,0,'C');
			$pdf->Cell(30,5,utf8_encode($row['Lname']),1,0,'L');
			$pdf->Cell(30,5,utf8_encode($row['FName']),1,0,'L');
			$pdf->Cell(30,5,utf8_encode($row['MName']),1,0,'L');
			$pdf->Cell(15,5,$row['Gender'],1,0,'L');
			$pdf->Cell(70,5,$row['Home_Address'],1,1,'L');
		}
	$pdf->Cell(0,5,'Total Number: '.mysqli_num_rows($myinfo),0,1,'L');
	$pdf->Cell(0,5,' ',0,1,'L');
	$pdf->Cell(30,5,'System Generated: ',0,0,'L');
	$pdf->Cell(65,5,date("l").', '. date("F d, Y"),0,1,'L');
		
	//Display the Output data
	$pdf->Output();
?>
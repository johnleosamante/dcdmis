
<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");

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
	$pdf->Image($img2,155,10,20);
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
	$pdf->SetFont('Arial','',10);
	$sy=$_SESSION['currentYS'] + 1;
	$pdf->Cell(0,5,'LIST OF CANDIDATES FOR SCHOOL YEAR '.$_SESSION['currentYS'].'-'.$sy,0,1,'C');
	$pdf->Cell(0,3,'',0,1,'C');
	
	//Get data from database
	$pdf->Cell(10,5,'#',1,0,'C');
	$pdf->Cell(80,5,'Candidate Name',1,0);
	$pdf->Cell(40,5,'Grade Level',1,0,'C');
	$pdf->Cell(60,5,'Position',1,1,'C');
	
								 
	
	//President information
	$no=0;
	$result1=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$_SESSION['year']."' AND tbl_ssg_officer.Position='PRESIDENT' AND tbl_ssg_officer.Status='WIN'");
	while($rowdata1=mysqli_fetch_array($result1))
	{
		$no++;
		$pdf->Cell(10,5,$no,1,0,'C');
		$pdf->Cell(80,5,$rowdata1['Lname'].', '.$rowdata1['FName'],1,0);
		$pdf->Cell(40,5,'Grade '.$rowdata1['GradeLevel'],1,0,'C');
		$pdf->Cell(60,5,$rowdata1['Position'],1,1,'C');
	}
	 //Vice President
	 $result2=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$_SESSION['year']."' AND tbl_ssg_officer.Position='VICE PRESIDENT' AND tbl_ssg_officer.Status='WIN'");
	 while($rowdata2=mysqli_fetch_array($result2))
		  {
		   $no++;
		   $pdf->Cell(10,5,$no,1,0,'C');
		   $pdf->Cell(80,5,$rowdata2['Lname'].', '.$rowdata2['FName'],1,0);
		   $pdf->Cell(40,5,'Grade '.$rowdata2['GradeLevel'],1,0,'C');
		   $pdf->Cell(60,5,$rowdata2['Position'],1,1,'C');
		  }
	//SECRETARY	  
	$result3=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$_SESSION['year']."' AND tbl_ssg_officer.Position='SECRETARY' AND tbl_ssg_officer.Status='WIN'");
	while($rowdata3=mysqli_fetch_array($result3))
    {
		   $no++;
		   $pdf->Cell(10,5,$no,1,0,'C');
		   $pdf->Cell(80,5,$rowdata3['Lname'].', '.$rowdata3['FName'],1,0);
		   $pdf->Cell(40,5,'Grade '.$rowdata3['GradeLevel'],1,0,'C');
		   $pdf->Cell(60,5,$rowdata3['Position'],1,1,'C');
		  }  
		  
		  
	//TREASURER
	 $result4=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$_SESSION['year']."' AND tbl_ssg_officer.Position='TREASURER' AND tbl_ssg_officer.Status='WIN'");
	 while($rowdata4=mysqli_fetch_array($result4))
		  {
		   $no++;
		   $pdf->Cell(10,5,$no,1,0,'C');
		   $pdf->Cell(80,5,$rowdata4['Lname'].', '.$rowdata4['FName'],1,0);
		   $pdf->Cell(40,5,'Grade '.$rowdata4['GradeLevel'],1,0,'C');
		   $pdf->Cell(60,5,$rowdata4['Position'],1,1,'C');
		  }  
		  
	  
	//AUDITOR
	 $result5=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$_SESSION['year']."' AND tbl_ssg_officer.Position='AUDITOR' AND tbl_ssg_officer.Status='WIN'");
	 while($rowdata5=mysqli_fetch_array($result5))
		  {
		   $no++;
		   $pdf->Cell(10,5,$no,1,0,'C');
		   $pdf->Cell(80,5,$rowdata5['Lname'].', '.$rowdata5['FName'],1,0);
		   $pdf->Cell(40,5,'Grade '.$rowdata5['GradeLevel'],1,0,'C');
		   $pdf->Cell(60,5,$rowdata5['Position'],1,1,'C');
		  }  
		  
	  
	//PIO
	 $result6=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$_SESSION['year']."' AND tbl_ssg_officer.Position='PIO' AND tbl_ssg_officer.Status='WIN'");
	 while($rowdata6=mysqli_fetch_array($result6))
		  {
		   $no++;
		   $pdf->Cell(10,5,$no,1,0,'C');
		   $pdf->Cell(80,5,$rowdata6['Lname'].', '.$rowdata6['FName'],1,0);
		   $pdf->Cell(40,5,'Grade '.$rowdata6['GradeLevel'],1,0,'C');
		   $pdf->Cell(60,5,$rowdata6['Position'],1,1,'C');
		  }  
		  
	  
	//BUSINESS MANAGER
	 $result7=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$_SESSION['year']."' AND tbl_ssg_officer.Position='BUSINESS MANAGER' AND tbl_ssg_officer.Status='WIN'");
	 while($rowdata7=mysqli_fetch_array($result7))
		  {
		   $no++;
		   $pdf->Cell(10,5,$no,1,0,'C');
		   $pdf->Cell(80,5,$rowdata7['Lname'].', '.$rowdata7['FName'],1,0);
		   $pdf->Cell(40,5,'Grade '.$rowdata7['GradeLevel'],1,0,'C');
		   $pdf->Cell(60,5,$rowdata7['Position'],1,1,'C');
		  }  
	//PEACE OFFICER
	 $result8=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$_SESSION['year']."' AND tbl_ssg_officer.Position='PEACE OFFICER' AND tbl_ssg_officer.Status='WIN'");
	 while($rowdata8=mysqli_fetch_array($result8))
		  {
		   $no++;
		   $pdf->Cell(10,5,$no,1,0,'C');
		   $pdf->Cell(80,5,$rowdata8['Lname'].', '.$rowdata8['FName'],1,0);
		   $pdf->Cell(40,5,'Grade '.$rowdata8['GradeLevel'],1,0,'C');
		   $pdf->Cell(60,5,$rowdata8['Position'],1,1,'C');
		  }  
		  		  
//REPRESENTATIVE
	 $result9=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$_SESSION['year']."' AND tbl_ssg_officer.Position='REPRESENTATIVE' AND tbl_ssg_officer.Status='WIN'");
	 while($rowdata9=mysqli_fetch_array($result9))
		  {
		   $no++;
		   $pdf->Cell(10,5,$no,1,0,'C');
		   $pdf->Cell(80,5,$rowdata9['Lname'].', '.$rowdata9['FName'],1,0);
		   $pdf->Cell(40,5,'Grade '.$rowdata9['GradeLevel'],1,0,'C');
		   $pdf->Cell(60,5,$rowdata9['Position'],1,1,'C');
		  }  
		  		  				  
		  
	$pdf->Cell(0,5,'****************Nothing follows****************',0,1,'C');	  
	$pdf->Cell(0,3,'',0,1,'C');
	$pdf->Cell(30,5,'System Generated: ',0,0,'L');
	$pdf->Cell(65,5,date("l").', '. date("F d, Y"),0,1,'L');
	$pdf->Cell(0,10,'',0,1,'C');
	$pdf->Cell(0,5,'Prepared by: ',0,1);
	$pdf->Cell(30,5,' ',0,0);
	$pdf->Cell(0,5,$_SESSION['currentAdviser'],0,1);
	$pdf->Cell(30,5,' ',0,0);
	$pdf->Cell(0,5,'SSG Adviser',0,1);
	
	//Display the Output data
	$pdf->Output();
?>
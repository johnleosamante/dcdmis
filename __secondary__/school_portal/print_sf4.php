
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
	
	$pdf->Cell(0,5,'',0,1,'L');
	$pdf->Cell(10,10,'#',1,0,'C');
	$pdf->Cell(50,10,'Grade & Section Name',1,0);
	$pdf->Cell(60,10,"Class Adviser",1,0,'C');
	$pdf->Cell(25,10,"Male",1,0,'C');
	$pdf->Cell(25,10,"Female",1,0,'C');
	$pdf->Cell(25,10,"Total",1,1,'C');
		
	$tot=$totm=$totf=0;
		if ($_SESSION['Category']=='Elementary')
			{
			   $no=$total=0;
				$datereg=mysqli_query($con,"SELECT * FROM tbl_section INNER JOIN tbl_employee ON tbl_section.Emp_ID = tbl_employee.Emp_ID WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND tbl_section.School_Year ='".$_SESSION['year']."'  ORDER BY tbl_section.Grade Asc");
					while($row=mysqli_fetch_array($datereg))
						{
							$no++;
							$pdf->Cell(10,10,$no,1,0,'C');
							if ($row['Grade']=='Kinder')
								{
								  $pdf->Cell(50,10,$row['Grade'].' - '.$row['SecDesc'],1,0);				
								}else{
								 $pdf->Cell(50,10,'Grade '.$row['Grade'].' - '.$row['SecDesc'],1,0);	
								}
							$male=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn=tbl_student.lrn WHERE tbl_learners.SecCode='".$row['SecCode']."' AND tbl_student.Gender='Male' AND tbl_learners.Grade='".$row['Grade']."' AND tbl_learners.SchoolID='".$_SESSION['school_id']."'");
							$female=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn=tbl_student.lrn WHERE tbl_learners.SecCode='".$row['SecCode']."' AND tbl_student.Gender='Female' AND tbl_learners.Grade='".$row['Grade']."' AND tbl_learners.SchoolID='".$_SESSION['school_id']."'");
							$total=mysqli_num_rows($male)+mysqli_num_rows($female);
							$pdf->Cell(60,10,$row['Emp_LName'].', '.$row['Emp_FName'],1,0,'C');
							$pdf->Cell(25,10,mysqli_num_rows($male),1,0,'C');
							$pdf->Cell(25,10,mysqli_num_rows($female),1,0,'C');
							$pdf->Cell(25,10,$total,1,1,'C');
						}
			}elseif ($_SESSION['Category']=='Secondary')
				{
				    $no=$total=$MaleNo=$FemaleNo=0;
						$datereg=mysqli_query($con,"SELECT * FROM tbl_section INNER JOIN tbl_employee ON tbl_section.Emp_ID = tbl_employee.Emp_ID WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND tbl_section.School_Year ='".$_SESSION['year']."'  ORDER BY tbl_section.Grade Asc");
							while($row=mysqli_fetch_array($datereg))
								{
									$no++;
									if ($row['Grade']=='11' || $row['Grade']=='12')
									{
										if ($_SESSION['Sem']=='First Semester')
											{
											   $male=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn=tbl_student.lrn WHERE first_semester.SecCode='".$row['SecCode']."' AND tbl_student.Gender='Male' AND first_semester.Grade='".$row['Grade']."' AND first_semester.SchoolID='".$_SESSION['school_id']."'");
											   $female=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn=tbl_student.lrn WHERE first_semester.SecCode='".$row['SecCode']."' AND tbl_student.Gender='Female' AND first_semester.Grade='".$row['Grade']."' AND first_semester.SchoolID='".$_SESSION['school_id']."'");														
											}elseif ($_SESSION['Sem']=='Second Semester')
											{
												$male=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn=tbl_student.lrn WHERE second_semester.SecCode='".$row['SecCode']."' AND tbl_student.Gender='Male' AND second_semester.Grade='".$row['Grade']."' AND second_semester.SchoolID='".$_SESSION['school_id']."'");
												$female=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn=tbl_student.lrn WHERE second_semester.SecCode='".$row['SecCode']."' AND tbl_student.Gender='Female' AND second_semester.Grade='".$row['Grade']."' AND second_semester.SchoolID='".$_SESSION['school_id']."'");														
														
											}
									}else{
											$male=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn=tbl_student.lrn WHERE tbl_learners.SecCode='".$row['SecCode']."' AND tbl_student.Gender='Male' AND tbl_learners.Grade='".$row['Grade']."' AND tbl_learners.SchoolID='".$_SESSION['school_id']."'");
											$female=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn=tbl_student.lrn WHERE tbl_learners.SecCode='".$row['SecCode']."' AND tbl_student.Gender='Female' AND tbl_learners.Grade='".$row['Grade']."' AND tbl_learners.SchoolID='".$_SESSION['school_id']."'");
										}
											if (mysqli_num_rows($male)<>0)
												{
												   $MaleNo=mysqli_num_rows($male);
												}
											if (mysqli_num_rows($female)<>0)
												{
												$FemaleNo=mysqli_num_rows($female);
												}
												
							            $pdf->Cell(10,10,$no,1,0,'C');
										$pdf->Cell(50,10,'Grade '.$row['Grade'].' - '.$row['SecDesc'],1,0);			
										$pdf->Cell(60,10,$row['Emp_LName'].', '.$row['Emp_FName'],1,0,'C');
										$pdf->Cell(25,10,$MaleNo,1,0,'C');
										$pdf->Cell(25,10,$FemaleNo,1,0,'C');
										$pdf->Cell(25,10,$total,1,1,'C');
									
								}
				}
	
	$pdf->Cell(0,10,'***************************Nothing follows**************************************',1,1,'C');
	$pdf->Cell(0,3,'',0,1,'C');
	$pdf->Cell(30,5,'System Generated: ',0,0,'L');
	$pdf->Cell(65,5,date("l").', '. date("F d, Y"),0,1,'L');
		
	//Display the Output data
	$pdf->Output();
?>
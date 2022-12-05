
<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
require('../../pcdmis/code128.php');


$pdf=new PDF_Code128('L','mm','Legal');


$img1='../../pcdmis/shs/h1.png';	
$img2='../../pcdmis/logo/logo.png';
//Add New Page
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();
$pdf->Image($img1,218,10,20);
$pdf->Image($img2,115,10,20);



	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'Republic of the Philippines',0,1,'C');
	$pdf->Cell(0,5,'Department of Education',0,1,'C');
	$pdf->Cell(0,5,'Region IX, Zamboanga Peninsula',0,1,'C');
	$pdf->Cell(0,5,'DIVISION OF PAGADIAN CITY',0,1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,5,'Pagadian City',0,1,'C');
	$pdf->Cell(0,3,'',0,1);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(0,5,'LRMS SUMMARY REPORT FOR  '.strtoupper($_SESSION['quarter'].' QUARTER - '.$_SESSION['week']),0,1,'C');
	
	
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,0,'',1,1);
	$pdf->Cell(60,5,'',0,0,'l');
	$pdf->Cell(0,5,date("F d, Y"),0,1,'R');
	
	//elementary level
	$pdf->Cell(0,10,'ELEMENTARY SCHOOL LIST OF SUBJECTS',0,1);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(10,7,'#',1,0,'C');
	$pdf->Cell(28,7,'Grade Level',1,0,'C');
	$pdf->Cell(20,7,'English',1,0,'C');
	$pdf->Cell(20,7,'Science',1,0,'C');
	$pdf->Cell(20,7,'Math',1,0,'C');
	$pdf->Cell(20,7,'Filipino',1,0,'C');
	$pdf->Cell(20,7,'Aral. Pan',1,0,'C');
	$pdf->Cell(20,7,'E.S.P',1,0,'C');
	$pdf->Cell(20,7,'EPP',1,0,'C');
	$pdf->Cell(20,7,'MAPEH',1,0,'C');
	$pdf->Cell(30,7,'Mother Tongue',1,0,'C');
	$pdf->Cell(30,7,'RO Thematic',1,0,'C');
	$pdf->Cell(30,7,'Project Rush',1,0,'C');
	$pdf->Cell(30,7,'Total',1,1,'C');
	
	   $TotEng=$TotScie=$TotMath=$TotFil=$TotAral=$TotESP=$TotTLE=$TotMAPEH=$TotMT=$Total=$TotPR=$TotRO=0;
	    $KinEng=$KinScie =$KinMath=$KinFil=$KinAral=$KinESP=$KinTLE=$KinMAPEH=$KinMT=$KinRO=$KinTotal=$KinPR=0;
									 
		//All Kinder data						
		 $mydata=mysqli_query($con,"SELECT * FROM tbl_elementary_subject WHERE GradeLevel='Kinder' AND WeekNo='".$_SESSION['week']."' AND QuarterNo='".$_SESSION['quarter']."'");

			 while($kinderrow=mysqli_fetch_array($mydata))
					{
						$KinEng = $KinEng + $kinderrow['English'];  
						$KinScie = $KinScie + $kinderrow['Science'];  
						$KinMath = $KinMath + $kinderrow['Math'];  
						$KinFil = $KinFil + $kinderrow['Filipino'];  
						$KinAral = $KinAral + $kinderrow['AralPan'];  
						$KinESP = $KinESP + $kinderrow['ESP'];  
						$KinTLE = $KinTLE + $kinderrow['TLE'];  
						$KinMAPEH = $KinMAPEH + $kinderrow['MAPEH'];  
						$KinMT = $KinMT + $kinderrow['Mother_tongue'];  
						$KinRO = $KinRO + $kinderrow['RO_Thematic'];  
						$KinPR = $KinPR + $kinderrow['Project_Rush'];  
					}
					  $KinTotal=$KinEng+$KinScie+$KinMath+$KinFil+$KinAral+$KinESP+$KinTLE+$KinMAPEH+$KinMT+$KinRO+$KinPR;
									
	$pdf->Cell(10,7,'1',1,0,'C');
	$pdf->Cell(28,7,'Kinder',1,0,'C');
	$pdf->Cell(20,7,number_format($KinEng,0),1,0,'C');
	$pdf->Cell(20,7,number_format($KinScie,0),1,0,'C');
	$pdf->Cell(20,7,number_format($KinMath,0),1,0,'C');
	$pdf->Cell(20,7,number_format($KinFil,0),1,0,'C');
	$pdf->Cell(20,7,number_format($KinAral,0),1,0,'C');
	$pdf->Cell(20,7,number_format($KinESP,0),1,0,'C');
	$pdf->Cell(20,7,number_format($KinTLE,0),1,0,'C');
	$pdf->Cell(20,7,number_format($KinMAPEH,0),1,0,'C');
	$pdf->Cell(30,7,number_format($KinMT,0),1,0,'C');
	$pdf->Cell(30,7,number_format($KinRO,0),1,0,'C');
	$pdf->Cell(30,7,number_format($KinPR,0),1,0,'C');
	$pdf->Cell(30,7,number_format($KinTotal,0),1,1,'C');
	
	//All Grade 1 data						
		 $G1Eng=$G1Scie=$G1Math=$G1Fil=$G1Aral=$G1ESP=$G1TLE=$G1MAPEH=$G1MT=$G1RO=$G1Total=$G1PR=0;
					$myG1=mysqli_query($con,"SELECT * FROM tbl_elementary_subject WHERE GradeLevel='1' AND WeekNo='".$_SESSION['week']."' AND QuarterNo='".$_SESSION['quarter']."'");
									  while($G1row=mysqli_fetch_array($myG1))
									  {
										$G1Eng = $G1Eng + $G1row['English'];  
										$G1Scie = $G1Scie + $G1row['Science'];  
										$G1Math = $G1Math + $G1row['Math'];  
										$G1Fil = $G1Fil + $G1row['Filipino'];  
										$G1Aral = $G1Aral + $G1row['AralPan'];  
										$G1ESP = $G1ESP + $G1row['ESP'];  
										$G1TLE = $G1TLE + $G1row['TLE'];  
										$G1MAPEH = $G1MAPEH + $G1row['MAPEH'];  
										$G1MT = $G1MT + $G1row['Mother_tongue'];  
										$G1RO = $G1RO + $G1row['RO_Thematic'];  
										$G1PR = $G1PR + $G1row['Project_Rush'];  
									  }
									  $G1Total=$G1Eng+$G1Scie+$G1Math+$G1Fil+$G1Aral+$G1ESP+$G1TLE+$G1MAPEH+$G1MT+$G1RO+$G1PR;
										$KinTotal=$KinEng+$KinScie+$KinMath+$KinFil+$KinAral+$KinESP+$KinTLE+$KinMAPEH+$KinMT+$KinRO+$KinPR;
									
	$pdf->Cell(10,7,'2',1,0,'C');
	$pdf->Cell(28,7,'Grade 1',1,0,'C');
	$pdf->Cell(20,7,number_format($G1Eng,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G1Scie,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G1Math,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G1Fil,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G1Aral,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G1ESP,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G1TLE,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G1MAPEH,0),1,0,'C');
	$pdf->Cell(30,7,number_format($G1MT,0),1,0,'C');
	$pdf->Cell(30,7,number_format($G1RO,0),1,0,'C');
	$pdf->Cell(30,7,number_format($G1PR,0),1,0,'C');
	$pdf->Cell(30,7,number_format($G1Total,0),1,1,'C');
	
	//Grade 2 data 
	 $G2Eng=$G2Scie=$G2Math=$G2Fil=$G2Aral=$G2ESP=$G2TLE=$G2MAPEH=$G2MT=$G2Total=$G2RO=$G2PR=0;
		$myG2=mysqli_query($con,"SELECT * FROM tbl_elementary_subject WHERE GradeLevel='2' AND WeekNo='".$_SESSION['week']."' AND QuarterNo='".$_SESSION['quarter']."'");
			while($G2row=mysqli_fetch_array($myG2))
				{
					$G2Eng = $G2Eng + $G2row['English'];  
					$G2Scie = $G2Scie + $G2row['Science'];  
					$G2Math = $G2Math + $G2row['Math'];  
					$G2Fil = $G2Fil + $G2row['Filipino'];  
					$G2Aral = $G2Aral + $G2row['AralPan'];  
					$G2ESP = $G2ESP + $G2row['ESP'];  
					$G2TLE = $G2TLE + $G2row['TLE'];  
					$G2MAPEH = $G2MAPEH + $G2row['MAPEH'];  
					$G2MT = $G2MT + $G2row['Mother_tongue'];  
					$G2RO = $G2RO + $G2row['RO_Thematic'];  
					$G2PR = $G2PR + $G2row['Project_Rush'];  
			 }
			$G2Total=$G2Eng+$G2Scie+$G2Math+$G2Fil+$G2Aral+$G2ESP+$G2TLE+$G2MAPEH+$G2MT+$G2RO+$G2PR;
										
	
	$pdf->Cell(10,7,'3',1,0,'C');
	$pdf->Cell(28,7,'Grade 2',1,0,'C');
	$pdf->Cell(20,7,number_format($G2Eng,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G2Scie,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G2Math,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G2Fil,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G2Aral,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G2ESP,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G2TLE,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G2MAPEH,0),1,0,'C');
	$pdf->Cell(30,7,number_format($G2MT,0),1,0,'C');
	$pdf->Cell(30,7,number_format($G2RO,0),1,0,'C');
	$pdf->Cell(30,7,number_format($G2PR,0),1,0,'C');
	$pdf->Cell(30,7,number_format($G2Total,0),1,1,'C');
	
	
	//Grade 3
	
	 $G3Eng=$G3Scie=$G3Math=$G3Fil=$G3Aral=$G3ESP=$G3TLE=$G3MAPEH=$G3MT=$G3RO=$G3Total=$G3PR=0;
		 $myG3=mysqli_query($con,"SELECT * FROM tbl_elementary_subject WHERE GradeLevel='3' AND WeekNo='".$_SESSION['week']."' AND QuarterNo='".$_SESSION['quarter']."'");
			 while($G3row=mysqli_fetch_array($myG3))
					{
						$G3Eng = $G3Eng + $G3row['English'];  
						$G3Scie = $G3Scie + $G3row['Science'];  
						$G3Math = $G3Math + $G3row['Math'];  
						$G3Fil = $G3Fil + $G3row['Filipino'];  
						$G3Aral = $G3Aral + $G3row['AralPan'];  
						$G3ESP = $G3ESP + $G3row['ESP'];  
						$G3TLE = $G3TLE + $G3row['TLE'];  
						$G3MAPEH = $G3MAPEH + $G3row['MAPEH'];  
						$G3MT = $G3MT + $G3row['Mother_tongue'];  
						$G3RO = $G3RO + $G3row['RO_Thematic'];  
						$G3PR = $G3PR + $G3row['Project_Rush'];  
					}
		 $G3Total=$G3Eng+$G3Scie+$G3Math+$G3Fil+$G3Aral+$G3ESP+$G3TLE+$G3MAPEH+$G3MT+$G3RO+$G3PR;
										
	
	$pdf->Cell(10,7,'4',1,0,'C');
	$pdf->Cell(28,7,'Grade 3',1,0,'C');
	$pdf->Cell(20,7,number_format($G3Eng,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G3Scie,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G3Math,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G3Fil,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G3Aral,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G3ESP,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G3TLE,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G3MAPEH,0),1,0,'C');
	$pdf->Cell(30,7,number_format($G3MT,0),1,0,'C');
	$pdf->Cell(30,7,number_format($G3RO,0),1,0,'C');
	$pdf->Cell(30,7,number_format($G3PR,0),1,0,'C');
	$pdf->Cell(30,7,number_format($G3Total,0),1,1,'C');
	
	
	//Grade 4
	
	$G4Eng=$G4Scie=$G4Math=$G4Fil=$G4Aral=$G4ESP=$G4TLE=$G4MAPEH=$G4MT=$G4RO=$G4Total=$G4PR=0;
											  $myG4=mysqli_query($con,"SELECT * FROM tbl_elementary_subject WHERE GradeLevel='4' AND WeekNo='".$_SESSION['week']."' AND QuarterNo='".$_SESSION['quarter']."'");
											  while($G4row=mysqli_fetch_array($myG4))
											  {
												$G4Eng = $G4Eng + $G4row['English'];  
												$G4Scie = $G4Scie + $G4row['Science'];  
												$G4Math = $G4Math + $G4row['Math'];  
												$G4Fil = $G4Fil + $G4row['Filipino'];  
												$G4Aral = $G4Aral + $G4row['AralPan'];  
												$G4ESP = $G4ESP + $G4row['ESP'];  
												$G4TLE = $G4TLE + $G4row['TLE'];  
												$G4MAPEH = $G4MAPEH + $G4row['MAPEH'];  
												$G4MT = $G4MT + $G4row['Mother_tongue'];  
												$G4RO = $G4RO + $G4row['RO_Thematic']; 
												$G4PR = $G4PR + $G4row['Project_Rush'];  												
											  }
											  $G4Total=$G4Eng+$G4Scie+$G4Math+$G4Fil+$G4Aral+$G4ESP+$G4TLE+$G4MAPEH+$G4MT+$G4RO+$G4PR;
										
	
	$pdf->Cell(10,7,'5',1,0,'C');
	$pdf->Cell(28,7,'Grade 4',1,0,'C');
	$pdf->Cell(20,7,number_format($G4Eng,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G4Scie,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G4Math,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G4Fil,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G4Aral,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G4ESP,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G4TLE,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G4MAPEH,0),1,0,'C');
	$pdf->Cell(30,7,number_format($G4MT,0),1,0,'C');
	$pdf->Cell(30,7,number_format($G4RO,0),1,0,'C');
	$pdf->Cell(30,7,number_format($G4PR,0),1,0,'C');
	$pdf->Cell(30,7,number_format($G4Total,0),1,1,'C');
	
	
	//Grade 5
	
	 $G5Eng=$G5Scie=$G5Math=$G5Fil=$G5Aral=$G5ESP=$G5TLE=$G5MAPEH=$G5MT=$G5Total=$G5RO=$G5PR=0;
											  $myG5=mysqli_query($con,"SELECT * FROM tbl_elementary_subject WHERE GradeLevel='5' AND WeekNo='".$_SESSION['week']."' AND QuarterNo='".$_SESSION['quarter']."'");
											  while($G5row=mysqli_fetch_array($myG5))
											  {
												$G5Eng = $G5Eng + $G5row['English'];  
												$G5Scie = $G5Scie + $G5row['Science'];  
												$G5Math = $G5Math + $G5row['Math'];  
												$G5Fil = $G5Fil + $G5row['Filipino'];  
												$G5Aral = $G5Aral + $G5row['AralPan'];  
												$G5ESP = $G5ESP + $G5row['ESP'];  
												$G5TLE = $G5TLE + $G5row['TLE'];  
												$G5MAPEH = $G4MAPEH + $G5row['MAPEH'];  
												$G5MT = $G5MT + $G5row['Mother_tongue'];  
												$G5RO = $G5RO + $G5row['RO_Thematic'];  
												$G5PR = $G5PR + $G2row['Project_Rush'];  
											  }
											  $G5Total=$G5Eng+$G5Scie+$G5Math+$G5Fil+$G5Aral+$G5ESP+$G5TLE+$G5MAPEH+$G5MT+$G5RO+$G5PR;
											 
										
	
	$pdf->Cell(10,7,'6',1,0,'C');
	$pdf->Cell(28,7,'Grade 5',1,0,'C');
	$pdf->Cell(20,7,number_format($G5Eng,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G5Scie,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G5Math,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G5Fil,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G5Aral,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G5ESP,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G5TLE,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G5MAPEH,0),1,0,'C');
	$pdf->Cell(30,7,number_format($G5MT,0),1,0,'C');
	$pdf->Cell(30,7,number_format($G5RO,0),1,0,'C');
	$pdf->Cell(30,7,number_format($G5PR,0),1,0,'C');
	$pdf->Cell(30,7,number_format($G5Total,0),1,1,'C');
	
	
	//Grade 6
	
	
	 $G6Eng=$G6Scie=$G6Math=$G6Fil=$G6Aral=$G6ESP=$G6TLE=$G6MAPEH=$G6MT=$G6RO=$G6Total=$G6PR=0;
											  $myG6=mysqli_query($con,"SELECT * FROM tbl_elementary_subject WHERE GradeLevel='6' AND WeekNo='".$_SESSION['week']."' AND QuarterNo='".$_SESSION['quarter']."'");
											  while($G6row=mysqli_fetch_array($myG6))
											  {
												$G6Eng = $G6Eng + $G6row['English'];  
												$G6Scie = $G6Scie + $G6row['Science'];  
												$G6Math = $G6Math + $G6row['Math'];  
												$G6Fil = $G6Fil + $G6row['Filipino'];  
												$G6Aral = $G6Aral + $G6row['AralPan'];  
												$G6ESP = $G6ESP + $G6row['ESP'];  
												$G6TLE = $G6TLE + $G6row['TLE'];  
												$G6MAPEH = $G6MAPEH + $G6row['MAPEH'];  
												$G6MT = $G6MT + $G6row['Mother_tongue'];  
												$G6RO = $G6RO + $G6row['RO_Thematic'];  
												$G6PR = $G6PR + $G6row['Project_Rush'];  
											  }
											  $G6Total=$G6Eng+$G6Scie+$G6Math+$G6Fil+$G6Aral+$G6ESP+$G6TLE+$G6MAPEH+$G6MT+$G6RO+$G6PR;
											
										
	
	$pdf->Cell(10,7,'7',1,0,'C');
	$pdf->Cell(28,7,'Grade 6',1,0,'C');
	$pdf->Cell(20,7,number_format($G6Eng,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G6Scie,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G6Math,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G6Fil,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G6Aral,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G6ESP,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G6TLE,0),1,0,'C');
	$pdf->Cell(20,7,number_format($G6MAPEH,0),1,0,'C');
	$pdf->Cell(30,7,number_format($G6MT,0),1,0,'C');
	$pdf->Cell(30,7,number_format($G6RO,0),1,0,'C');
	$pdf->Cell(30,7,number_format($G6PR,0),1,0,'C');
	$pdf->Cell(30,7,number_format($G6Total,0),1,1,'C');
	
	
	//Total 
		$TotEng=$KinEng+$G1Eng+$G2Eng+$G3Eng+$G4Eng+$G5Eng+$G6Eng;
		$TotScie=$KinScie+$G1Scie+$G2Scie+$G3Scie+$G4Scie+$G5Scie+$G6Scie;
		$TotMath=$KinMath+$G1Math+$G2Math+$G3Math+$G4Math+$G5Math+$G6Math;
		$TotFil=$KinFil+$G1Fil+$G2Fil+$G3Fil+$G4Fil+$G5Fil+$G6Fil;
		$TotAral=$KinAral+$G1Aral+$G2Aral+$G3Aral+$G4Aral+$G5Aral+$G6Aral;
	    $TotESP=$KinESP+$G1ESP+$G2ESP+$G3ESP+$G4ESP+$G5ESP+$G6ESP;
	    $TotTLE=$KinTLE+$G1TLE+$G2TLE+$G3TLE+$G4TLE+$G5TLE+$G6TLE;
		$TotMAPEH=$KinMAPEH+$G1MAPEH+$G2MAPEH+$G3MAPEH+$G4MAPEH+$G5MAPEH+$G6MAPEH;
		$TotMT=$KinMT+$G1MT+$G2MT+$G3MT+$G4MT+$G5MT+$G6MT;
		$TotRO=$KinRO+$G1RO+$G2RO+$G3RO+$G4RO+$G5RO+$G6RO;
		$TotPR=$KinPR+$G1PR+$G2PR+$G3PR+$G4PR+$G5PR+$G6PR;
											  
		$Total=$TotEng+$TotScie+$TotMath+$TotFil+$TotAral+$TotESP+$TotTLE+$TotMAPEH+$TotMT+$TotPR+$TotRO;
		
	
	$pdf->Cell(38,7,'Total',1,0,'C');
	$pdf->Cell(20,7,number_format($TotEng,0),1,0,'C');
	$pdf->Cell(20,7,number_format($TotScie,0),1,0,'C');
	$pdf->Cell(20,7,number_format($TotMath,0),1,0,'C');
	$pdf->Cell(20,7,number_format($TotFil,0),1,0,'C');
	$pdf->Cell(20,7,number_format($TotAral,0),1,0,'C');
	$pdf->Cell(20,7,number_format($TotESP,0),1,0,'C');
	$pdf->Cell(20,7,number_format($TotTLE,0),1,0,'C');
	$pdf->Cell(20,7,number_format($TotMAPEH,0),1,0,'C');
	$pdf->Cell(30,7,number_format($TotMT,0),1,0,'C');
	$pdf->Cell(30,7,number_format($G6RO,0),1,0,'C');
	$pdf->Cell(30,7,number_format($TotPR,0),1,0,'C');
	$pdf->Cell(30,7,number_format($Total,0),1,1,'C');								

	//secondary level
	$pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,15,'',0,1,'C');
	$pdf->Cell(0,10,'JUNIOR HIGH SCHOOL LIST OF SUBJECTS',0,1);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(10,7,'#',1,0,'C');
	$pdf->Cell(25,7,'Grade Level',1,0,'C');
	$pdf->Cell(18,7,'English',1,0,'C');
	$pdf->Cell(18,7,'Science',1,0,'C');
	$pdf->Cell(18,7,'Math',1,0,'C');
	$pdf->Cell(18,7,'Filipino',1,0,'C');
	$pdf->Cell(18,7,'Aral. Pan',1,0,'C');
	$pdf->Cell(18,7,'E.S.P',1,0,'C');
	$pdf->Cell(18,7,'T.L.E',1,0,'C');
	$pdf->Cell(18,7,'Music',1,0,'C');
	$pdf->Cell(18,7,'Arts',1,0,'C');
	$pdf->Cell(18,7,'P.E',1,0,'C');
	$pdf->Cell(18,7,'Health',1,0,'C');
	$pdf->Cell(23,7,'RO Thematic',1,0,'C');
	$pdf->Cell(20,7,'Elective 1',1,0,'C');
	$pdf->Cell(20,7,'Elective 2',1,0,'C');
	$pdf->Cell(20,7,'Elective 3',1,0,'C');
	$pdf->Cell(20,7,'Total',1,1,'C');
	
	//GRADE 7
											$G7Eng=$G7Scie=$G7Math=$G7Fil=$G7Aral=$G7ESP=$G7TLE=$G7MUSIC=$G7ARTS=$G7PE=$G7HEALTH=$G7THEMATIC=$G7ELECTIVE1=$G7ELECTIVE2=$G7ELECTIVE3=$G7Total=0;
											  
											  $myG7=mysqli_query($con,"SELECT * FROM tbl_secondary_subject WHERE GradeLevel='7' AND WeekNo='".$_SESSION['week']."' AND QuarterNo='".$_SESSION['quarter']."'");
											  
											  while($G7row=mysqli_fetch_array($myG7))
											  {
												$G7Eng = $G7Eng + $G7row['English'];  
												$G7Scie = $G7Scie + $G7row['Science'];  
												$G7Math = $G7Math + $G7row['Math'];  
												$G7Fil = $G7Fil + $G7row['Filipino'];  
												$G7Aral = $G7Aral + $G7row['AralPan'];  
												$G7ESP = $G7ESP + $G7row['ESP'];  
												$G7TLE = $G7TLE + $G7row['TLE'];  
												$G7MUSIC = $G7MUSIC + $G7row['Music'];  
												$G7ARTS = $G7ARTS + $G7row['Arts'];  
												$G7PE = $G7PE + $G7row['PE'];  
												$G7HEALTH = $G7HEALTH + $G7row['Health'];  
												$G7THEMATIC = $G7THEMATIC + $G7row['RO_Thematic'];  
												$G7ELECTIVE1 = $G7ELECTIVE1 + $G7row['Elective1'];  
												$G7ELECTIVE2 = $G7ELECTIVE2 + $G7row['Elective2'];  
												$G7ELECTIVE3 = $G7ELECTIVE3 + $G7row['Elective3'];  
											  }
											  $G7Total=$G7Eng+$G7Scie+$G7Math+$G7Fil+$G7Aral+$G7ESP+$G7TLE+$G7MUSIC+$G7ARTS+$G7PE+$G7HEALTH+$G7THEMATIC+$G7ELECTIVE1+$G7ELECTIVE3+$G7ELECTIVE3;
											
	
	$pdf->Cell(10,7,'1',1,0,'C');
	$pdf->Cell(25,7,'Grade 7',1,0,'C');
	$pdf->Cell(18,7,number_format($G7Eng),1,0,'C');
	$pdf->Cell(18,7,number_format($G7Scie),1,0,'C');
	$pdf->Cell(18,7,number_format($G7Math),1,0,'C');
	$pdf->Cell(18,7,number_format($G7Fil),1,0,'C');
	$pdf->Cell(18,7,number_format($G7Aral),1,0,'C');
	$pdf->Cell(18,7,number_format($G7ESP),1,0,'C');
	$pdf->Cell(18,7,number_format($G7TLE),1,0,'C');
	$pdf->Cell(18,7,number_format($G7MUSIC),1,0,'C');
	$pdf->Cell(18,7,number_format($G7ARTS),1,0,'C');
	$pdf->Cell(18,7,number_format($G7PE),1,0,'C');
	$pdf->Cell(18,7,number_format($G7HEALTH),1,0,'C');
	$pdf->Cell(23,7,number_format($G7THEMATIC),1,0,'C');
	$pdf->Cell(20,7,number_format($G7ELECTIVE1),1,0,'C');
	$pdf->Cell(20,7,number_format($G7ELECTIVE2),1,0,'C');
	$pdf->Cell(20,7,number_format($G7ELECTIVE3),1,0,'C');
	$pdf->Cell(20,7,number_format($G7Total),1,1,'C');
	
	//GRADE 8
											$G8Eng=$G8Scie=$G8Math=$G8Fil=$G8Aral=$G8ESP=$G8TLE=$G8MUSIC=$G8ARTS=$G8PE=$G8HEALTH=$G8THEMATIC=$G8Total=$G8ELECTIVE1=$G8ELECTIVE2=$G8ELECTIVE3=0;
											  $myG8=mysqli_query($con,"SELECT * FROM tbl_secondary_subject WHERE GradeLevel='8' AND WeekNo='".$_SESSION['week']."' AND QuarterNo='".$_SESSION['quarter']."'");
											  while($G8row=mysqli_fetch_array($myG8))
											  {
												$G8Eng = $G8Eng + $G8row['English'];  
												$G8Scie = $G8Scie + $G8row['Science'];  
												$G8Math = $G8Math + $G8row['Math'];  
												$G8Fil = $G8Fil + $G8row['Filipino'];  
												$G8Aral = $G8Aral + $G8row['AralPan'];  
												$G8ESP = $G8ESP + $G8row['ESP'];  
												$G8TLE = $G8TLE + $G8row['TLE'];  
												$G8MUSIC = $G8MUSIC + $G8row['Music'];  
												$G8ARTS = $G8ARTS + $G8row['Arts'];  
												$G8PE = $G8PE + $G8row['PE'];  
												$G8HEALTH = $G8HEALTH + $G8row['Health'];  
												$G8THEMATIC = $G8THEMATIC + $G8row['RO_Thematic'];  
												$G8ELECTIVE1 = $G8ELECTIVE1 + $G8row['Elective1'];  
												$G8ELECTIVE2 = $G8ELECTIVE2 + $G8row['Elective2'];  
												$G8ELECTIVE3 = $G8ELECTIVE3 + $G8row['Elective3'];  
											  }
											  $G8Total=$G8Eng+$G8Scie+$G8Math+$G8Fil+$G8Aral+$G8ESP+$G8TLE+$G8MUSIC+$G8ARTS+$G8PE+$G8HEALTH+$G8THEMATIC+$G8ELECTIVE1+$G8ELECTIVE2+$G8ELECTIVE3;
											
	$pdf->Cell(10,7,'2',1,0,'C');
	$pdf->Cell(25,7,'Grade 8',1,0,'C');
	$pdf->Cell(18,7,number_format($G8Eng),1,0,'C');
	$pdf->Cell(18,7,number_format($G8Scie),1,0,'C');
	$pdf->Cell(18,7,number_format($G8Math),1,0,'C');
	$pdf->Cell(18,7,number_format($G8Fil),1,0,'C');
	$pdf->Cell(18,7,number_format($G8Aral),1,0,'C');
	$pdf->Cell(18,7,number_format($G8ESP),1,0,'C');
	$pdf->Cell(18,7,number_format($G8TLE),1,0,'C');
	$pdf->Cell(18,7,number_format($G8MUSIC),1,0,'C');
	$pdf->Cell(18,7,number_format($G8ARTS),1,0,'C');
	$pdf->Cell(18,7,number_format($G8PE),1,0,'C');
	$pdf->Cell(18,7,number_format($G8HEALTH),1,0,'C');
	$pdf->Cell(23,7,number_format($G8THEMATIC),1,0,'C');
	$pdf->Cell(20,7,number_format($G8ELECTIVE1),1,0,'C');
	$pdf->Cell(20,7,number_format($G8ELECTIVE2),1,0,'C');
	$pdf->Cell(20,7,number_format($G8ELECTIVE3),1,0,'C');
	$pdf->Cell(20,7,number_format($G8Total),1,1,'C');
	
	
	//GRADE 9
											  
											$G9Eng=$G9Scie=$G9Math=$G9Fil=$G9Aral=$G9ESP=$G9TLE=$G9MUSIC=$G9ARTS=$G9PE=$G9HEALTH=$G9THEMATIC=$G9Total=$G9ELECTIVE1=$G9ELECTIVE2=$G9ELECTIVE3=0;
											  $myG9=mysqli_query($con,"SELECT * FROM tbl_secondary_subject WHERE GradeLevel='9' AND WeekNo='".$_SESSION['week']."' AND QuarterNo='".$_SESSION['quarter']."'");
											  while($G9row=mysqli_fetch_array($myG9))
											  {
												$G9Eng = $G9Eng + $G9row['English'];  
												$G9Scie = $G9Scie + $G9row['Science'];  
												$G9Math = $G9Math + $G9row['Math'];  
												$G9Fil = $G9Fil + $G9row['Filipino'];  
												$G9Aral = $G9Aral + $G9row['AralPan'];  
												$G9ESP = $G9ESP + $G9row['ESP'];  
												$G9TLE = $G9TLE + $G9row['TLE'];  
												$G9MUSIC = $G9MUSIC + $G9row['Music'];  
												$G9ARTS = $G9ARTS + $G9row['Arts'];  
												$G9PE = $G9PE + $G9row['PE'];  
												$G9HEALTH = $G9HEALTH + $G9row['Health'];  
												$G9THEMATIC = $G9THEMATIC + $G9row['RO_Thematic']; 
												
												$G9ELECTIVE1 = $G9ELECTIVE1 + $G9row['Elective1'];  
												$G9ELECTIVE2 = $G9ELECTIVE2 + $G9row['Elective2'];  
												$G9ELECTIVE3 = $G9ELECTIVE3 + $G9row['Elective3'];  
											  }
											  $G9Total=$G9Eng+$G9Scie+$G9Math+$G9Fil+$G9Aral+$G9ESP+$G9TLE+$G9MUSIC+$G9ARTS+$G9PE+$G9HEALTH+$G9THEMATIC+$G9ELECTIVE2+$G9ELECTIVE3+$G9ELECTIVE1;
										
	
	$pdf->Cell(10,7,'3',1,0,'C');
	$pdf->Cell(25,7,'Grade 9',1,0,'C');
	$pdf->Cell(18,7,number_format($G9Eng),1,0,'C');
	$pdf->Cell(18,7,number_format($G9Scie),1,0,'C');
	$pdf->Cell(18,7,number_format($G9Math),1,0,'C');
	$pdf->Cell(18,7,number_format($G9Fil),1,0,'C');
	$pdf->Cell(18,7,number_format($G9Aral),1,0,'C');
	$pdf->Cell(18,7,number_format($G9ESP),1,0,'C');
	$pdf->Cell(18,7,number_format($G9TLE),1,0,'C');
	$pdf->Cell(18,7,number_format($G9MUSIC),1,0,'C');
	$pdf->Cell(18,7,number_format($G9ARTS),1,0,'C');
	$pdf->Cell(18,7,number_format($G9PE),1,0,'C');
	$pdf->Cell(18,7,number_format($G9HEALTH),1,0,'C');
	$pdf->Cell(23,7,number_format($G9THEMATIC),1,0,'C');
	$pdf->Cell(20,7,number_format($G9ELECTIVE1),1,0,'C');
	$pdf->Cell(20,7,number_format($G9ELECTIVE2),1,0,'C');
	$pdf->Cell(20,7,number_format($G9ELECTIVE3),1,0,'C');
	$pdf->Cell(20,7,number_format($G9Total),1,1,'C');
	
	
	//GRADE 10
				$G10Eng=$G10Scie=$G10Math=$G10Fil=$G10Aral=$G10ESP=$G10TLE=$G10MUSIC=$G10ARTS=$G10PE=$G10HEALTH=$G10THEMATIC=$G10ELECTIVE1=$G10ELECTIVE2=$G10ELECTIVE3=$G10Total=0;
					$myG10=mysqli_query($con,"SELECT * FROM tbl_secondary_subject WHERE GradeLevel='10' AND WeekNo='".$_SESSION['week']."' AND QuarterNo='".$_SESSION['quarter']."'");
					  while($G10row=mysqli_fetch_array($myG10))
						  {
							$G10Eng = $G10Eng + $G10row['English'];  
							$G10Scie = $G10Scie + $G10row['Science'];  
							$G10Math = $G10Math + $G10row['Math'];  
							$G10Fil = $G10Fil + $G10row['Filipino'];  
							$G10Aral = $G10Aral + $G10row['AralPan'];  
							$G10ESP = $G10ESP + $G10row['ESP'];  
							$G10TLE = $G10TLE + $G10row['TLE'];  
							$G10MUSIC = $G10MUSIC + $G10row['Music'];  
							$G10ARTS = $G10ARTS + $G10row['Arts'];  
							$G10PE = $G10PE + $G10row['PE'];  
							$G10HEALTH = $G10HEALTH + $G10row['Health'];  
							$G10THEMATIC = $G10THEMATIC + $G10row['RO_Thematic'];  
							$G10ELECTIVE1 = $G10ELECTIVE1 + $G10row['Elective1'];  
							$G10ELECTIVE2 = $G10ELECTIVE2 + $G10row['Elective2'];  
							$G10ELECTIVE3 = $G10ELECTIVE3 + $G10row['Elective3'];  
						  }
					$G10Total=$G10Eng+$G10Scie+$G10Math+$G10Fil+$G10Aral+$G10ESP+$G10TLE+$G10MUSIC+$G10ARTS+$G10PE+$G10HEALTH+$G10THEMATIC+$G10ELECTIVE1+$G10ELECTIVE2+$G10ELECTIVE3;
											
	
	$pdf->Cell(10,7,'4',1,0,'C');
	$pdf->Cell(25,7,'Grade 10',1,0,'C');
	$pdf->Cell(18,7,number_format($G10Eng),1,0,'C');
	$pdf->Cell(18,7,number_format($G10Scie),1,0,'C');
	$pdf->Cell(18,7,number_format($G10Math),1,0,'C');
	$pdf->Cell(18,7,number_format($G10Fil),1,0,'C');
	$pdf->Cell(18,7,number_format($G10Aral),1,0,'C');
	$pdf->Cell(18,7,number_format($G10ESP),1,0,'C');
	$pdf->Cell(18,7,number_format($G10TLE),1,0,'C');
	$pdf->Cell(18,7,number_format($G10MUSIC),1,0,'C');
	$pdf->Cell(18,7,number_format($G10ARTS),1,0,'C');
	$pdf->Cell(18,7,number_format($G10PE),1,0,'C');
	$pdf->Cell(18,7,number_format($G10HEALTH),1,0,'C');
	$pdf->Cell(23,7,number_format($G10THEMATIC),1,0,'C');
	$pdf->Cell(20,7,number_format($G10ELECTIVE1),1,0,'C');
	$pdf->Cell(20,7,number_format($G10ELECTIVE2),1,0,'C');
	$pdf->Cell(20,7,number_format($G10ELECTIVE3),1,0,'C');
	$pdf->Cell(20,7,number_format($G10Total),1,1,'C');
	
	
	

	//senior high school level
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,'',0,1);
	$pdf->Cell(0,10,'SENIOR HIGH SCHOOL LIST OF STRAND',0,1);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(165,7,'GRADE 11 ACADEMIC TRACK',1,1,'C');
	$pdf->Cell(10,7,'#',1,0,'C');
	$pdf->Cell(95,7,'STRAND / TRACK',1,0,'C');
	$pdf->Cell(30,7,'# OF LEARNER',1,0,'C');
	$pdf->Cell(30,7,'# OF MODULE',1,1,'C');
	$pdf->SetFont('Arial','',10);
	
	$no=0;
	$result=mysqli_query($con,"SELECT * FROM tbl_qualification WHERE Grade='11' AND Strand='ACADEMIC' ORDER BY Description Asc");
		while($row=mysqli_fetch_array($result))
		{
			$no++;	
			$totLearner=$totModule=0;
			$mydatabyschool=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode = tbl_senior_sub_strand.StrandsubCode  WHERE tbl_shs_report.SpecCode='".$row['SpCode']."' AND tbl_shs_report.QuarterNo='".$_SESSION['quarter']."' AND tbl_shs_report.WeekNo='".$_SESSION['week']."' AND tbl_shs_report.GradeLevel='".$row['Grade']."'");
				while($datarow=mysqli_fetch_array($mydatabyschool))
					{
						$totLearner=$totLearner+$datarow['No_of_learner'];
						$totModule=$totModule+$datarow['No_of_copies'];
					}	
			$pdf->Cell(10,5,$no,1,0,'C');
			$pdf->Cell(95,5,$row['Description'],1,0);
			$pdf->Cell(30,5,$totLearner,1,0,'C');
			$pdf->Cell(30,5,$totModule,1,1,'C');
		}
	$pdf->Cell(165,6,'GRADE 11 TECHVOC TRACK',1,1,'C');
		$no=0;
	$result=mysqli_query($con,"SELECT * FROM tbl_qualification WHERE Grade='11' AND Strand='TECHVOC' ORDER BY Description Asc");
		while($row=mysqli_fetch_array($result))
		{
			$no++;	
			$totLearner=$totModule=0;
			$mydatabyschool=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode = tbl_senior_sub_strand.StrandsubCode  WHERE tbl_shs_report.SpecCode='".$row['SpCode']."' AND tbl_shs_report.QuarterNo='".$_SESSION['quarter']."' AND tbl_shs_report.WeekNo='".$_SESSION['week']."' AND tbl_shs_report.GradeLevel='".$row['Grade']."'");
				while($datarow=mysqli_fetch_array($mydatabyschool))
					{
						$totLearner=$totLearner+$datarow['No_of_learner'];
						$totModule=$totModule+$datarow['No_of_copies'];
					}	
			$pdf->Cell(10,5,$no,1,0,'C');
			$pdf->Cell(95,5,$row['Description'],1,0);
			$pdf->Cell(30,5,$totLearner,1,0,'C');
			$pdf->Cell(30,5,$totModule,1,1,'C');
		}
		
	$pdf->Cell(0,10,"",0,1);
	$pdf->Cell(0,15,"Prepared by:",0,1);
	$pdf->Cell(30,5,"",0,0,'C');
	$pdf->Cell(40,5,$_SESSION['prepared'],0,1,'C');
	
		
	//Display the Output data
	$pdf->Output();
?>
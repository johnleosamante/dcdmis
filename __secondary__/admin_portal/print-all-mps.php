
<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
require('../pcdmis/code128.php');

$pdf=new PDF_Code128('P','mm','Legal');

//set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';
    include "../pcdmis/qrlib.php";    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    $finame = $PNG_TEMP_DIR."Subject ALL".'.png';
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    $matrixPointSize = 5;
   $_REQUEST['data']="SUBJECT ALL";
    if (isset($_REQUEST['data'])) {        
        // user data
        $finame = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_REQUEST['data'], $finame, $errorCorrectionLevel, $matrixPointSize, 2);    
    } else {    
        QRcode::png('PHP QR Code :)', $finame, $errorCorrectionLevel, $matrixPointSize, 2);    
    }    


$subjectAll=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_subject WHERE  Exam_Status='".$_SESSION['rat_status']."'");	
while($rowAll=mysqli_fetch_array($subjectAll))
{	

$img1='../pcdmis/shs/h1.png';	
$img2='../pcdmis/logo/logo.png';
$img3=$PNG_WEB_DIR.basename($finame);
$img4='../pcdmis/shs/offices.png';	

//Add New Page
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();
$pdf->Image($img1,165,10,20);
$pdf->Image($img2,30,10,20);


	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'Republic of the Philippines',0,1,'C');
	$pdf->Cell(0,5,'Department of Education',0,1,'C');
	$pdf->Cell(0,5,'Region IX, Zamboanga Peninsula',0,1,'C');
	$pdf->Cell(0,5,'DIVISION OF DIPOLOG CITY',0,1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,5,'Dipolog City',0,1,'C');
	$pdf->Cell(0,3,'',0,1);
	$pdf->SetFont('Arial','B',14);
	$pdf->SetFillColor(210,208,208);
	$pdf->Cell(0,8,"TEST ITEM MASTERY LEVEL",1,1,'C',true);
	
	
	//Query for subject
	$subject=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_subject WHERE RATSubCode ='".$rowAll['RATSubCode']."' LIMIT 1");
	$rowsub=mysqli_fetch_assoc($subject);
	
	//Variable
	$no=$total=$percent=$TotalPercent=$SubPercent=$SubTotal= $Totallearner=0; 
	$remarkdata="";
	
	//Query for Learner
	$learner=mysqli_query($con,"SELECT * FROM tbl_assessment_rat WHERE tbl_assessment_rat.YLevel='".$rowAll['Grade_Level']."' AND tbl_assessment_rat.ExamStatus='DONE'");
	$Totallearner=mysqli_num_rows($learner);
	
	$pdf->SetFont('Arial','',10);
	//Query learning Areas
	$pdf->Cell(0,3,'',0,1);
	$pdf->Cell(33,5,"LEARNING AREA: ",0,0);
	$pdf->Cell(60,5,strtoupper($rowsub['Learning_Areas']).' '.$rowAll['Grade_Level'],0,1);
	//List of Learner
	$pdf->Cell(0,2,'',0,1);
	$pdf->Cell(45,5,"TOTAL # OF EXAMINEES: ",0,0);
	$pdf->Cell(30,5,$Totallearner,0,1);
	//Total Items
	$pdf->Cell(45,5,"TOTAL # OF ITEMS:",0,0);
	$pdf->Cell(33,5,$rowsub['No_of_Items'],0,1);
	
	$pdf->Cell(0,2,'',0,1);
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->multiCell(15,8.3,"Test Item No.",1,'C');
	$pdf->SetXY($xPos+15,$yPos);
	$pdf->multiCell(85,25,"Learning Competencies",1,'C');
	$pdf->SetXY($xPos+100,$yPos);
	$pdf->multiCell(45,5,"Total # of Examinees with correct responses",1,'C');
	$pdf->SetXY($xPos+100,$yPos+10);
	$pdf->multiCell(25,15,"Total",1,'C');
	$pdf->SetXY($xPos+125,$yPos+10);
	$pdf->multiCell(20,15,"%",1,'C');
	$pdf->SetXY($xPos+145,$yPos);
	$pdf->multiCell(53,5,"Interpretations *Mastered *Closely Approximating Mastery *Moving Towards Mastery *Average *Low *Very Low *Absolutely No Mastery",1,'C');
	
	//Getting data from database
	$pdf->SetFont('Arial','',8);
	$myQA=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_questionaires WHERE SubCode='".$rowAll['RATSubCode']."' ORDER BY QNumber Asc");
	while ($row=mysqli_fetch_array($myQA))
	{
		$percent=number_format(($row['NoOfCorrect']/$Totallearner)*100,0);
			if ($percent>=96 AND $percent<=100)
				{
				  $remarkdata='MASTERED';
				}elseif ($percent>=86 AND $percent<=95)
				{
					$remarkdata='CLOSELY APPROXIMATING MASTERY';
				}elseif ($percent>=66 AND $percent<=85)
				{
				  $remarkdata='MOVING TOWARDS MASTERY';
				}elseif ($percent>=35 AND $percent<=65)
				{
				$remarkdata='AVERAGE';
				}elseif ($percent>=15 AND $percent<=34)
				{
					$remarkdata='LOW';
				}elseif ($percent>=5 AND $percent<=14)
				{
					$remarkdata='VERY LOW';
				}elseif ($percent>=0 AND $percent<=4)
				{
				$remarkdata='ABSOLUTELY NO MASTERY';
				}
				
	$pdf->Cell(15,10,$row['QNumber'],1,0,'C');	
    $xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	//$pdf->multiCell(85,5,$row['Questionnairs'],1);	
	$pdf->multiCell(85,10,"",1);	
	$pdf->SetXY($xPos+85,$yPos);
	$pdf->cell(25,10,$row['NoOfCorrect'],1,0,'C');
	//$pdf->SetXY($xPos+110,$yPos);
	$pdf->cell(20,10,number_format($percent,0).'%',1,0,'C');
	//$pdf->SetXY($xPos+130,$yPos);
	$pdf->cell(53,10,$remarkdata,1,1,'C');
	
	$total=$total+$row['NoOfCorrect'];
	$SubPercent=$SubPercent+$percent;
		
	}
	$SubTotal=$Totallearner * $rowsub['No_of_Items'];
									if ($SubTotal<>0)
									{
										$TotalPercent= ($total/$SubTotal)*100;
									}
									if ($TotalPercent>=96 AND $TotalPercent<=100)
											{
												$remarkdata='MASTERED';
											}elseif ($TotalPercent>=86 AND $TotalPercent<=95)
											{
												$remarkdata='CLOSELY APPROXIMATING MASTERY';
											}elseif ($TotalPercent>=66 AND $TotalPercent<=85)
											{
												$remarkdata='MOVING TOWARDS MASTERY';
											}elseif ($TotalPercent>=35 AND $TotalPercent<=65)
											{
												$remarkdata='AVERAGE';
											}elseif ($TotalPercent>=15 AND $TotalPercent<=34)
											{
												$remarkdata='LOW';
											}elseif ($TotalPercent>=5 AND $TotalPercent<=14)
											{
												$remarkdata='VERY LOW';
											}elseif ($TotalPercent>=0 AND $TotalPercent<=4)
											{
												$remarkdata='ABSOLUTELY NO MASTERY';
											}	
											
	$mainscore=$mps=0;
	
	$pdf->Cell(100,10,"TOTAL",1,0,'C');
	$pdf->Cell(25,10,$total,1,0,'C');
	$pdf->Cell(20,10,number_format($TotalPercent,2).'%',1,0,'C');
	$pdf->Cell(53,10,$remarkdata,1,1,'C');
	$pdf->Cell(0,5,"",0,1,'C');
	$pdf->Cell(0,5,"MEAN PERCENTAGE SCORE",0,1,'C');
	$pdf->Cell(15,5,"No",1,0,'C');
	$pdf->Cell(30,5,"Grade Level",1,0,'C');
	$pdf->Cell(30,5,"No. of Students",1,0,'C');
	$pdf->Cell(30,5,"No. of Items",1,0,'C');
	$pdf->Cell(30,5,"Total Scores",1,0,'C');
	$pdf->Cell(30,5,"Mean Score",1,0,'C');
	$pdf->Cell(30,5,"MPS",1,1,'C');
	
	//Put data
	$mainscore=$total/$Totallearner;
	$mps=($mainscore/$rowsub['No_of_Items'])*100;
	$pdf->Cell(15,5,"1",1,0,'C');
	$pdf->Cell(30,5,'Grade '.$rowAll['Grade_Level'],1,0,'C');
	$pdf->Cell(30,5,$Totallearner,1,0,'C');
	$pdf->Cell(30,5,$rowsub['No_of_Items'],1,0,'C');
	$pdf->Cell(30,5,number_format($total,0),1,0,'C');
	$pdf->Cell(30,5,number_format($mainscore,1),1,0,'C');
	$pdf->Cell(30,5,number_format($mps,1).'%',1,0,'C');
	
	//Prepared by the Teacher
	$pdf->Cell(0,10,'',0,1);
	$pdf->Cell(0,10,'Prepared by:',0,1);
	$pdf->Cell(30,5,'JOSE MARI M. APILAN',0,1);
	$pdf->Cell(40,5,"Information Technology Officer",0,1);
	$pdf->Cell(0,10,'',0,1);
	$pdf->Cell(0,5,'************************************Nothing follows*****************************************************',0,1,'C');
}	
	//Display the Output data
	$pdf->Output();
?>
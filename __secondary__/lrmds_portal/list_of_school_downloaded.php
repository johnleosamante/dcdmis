
<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
require('../../pcdmis/code128.php');


$pdf=new PDF_Code128('P','mm','Legal');


$img1='../../pcdmis/shs/h1.png';	
$img2='../../pcdmis/logo/logo.png';

//Add New Page
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();
$pdf->Image($img1,148,10,20);
$pdf->Image($img2,50,10,20);



	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'Republic of the Philippines',0,1,'C');
	$pdf->Cell(0,5,'Department of Education',0,1,'C');
	$pdf->Cell(0,5,'Region IX, Zamboanga Peninsula',0,1,'C');
	$pdf->Cell(0,5,'DIVISION OF PAGADIAN CITY',0,1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,5,'Pagadian City',0,1,'C');
	$pdf->Cell(0,3,'',0,1);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(0,5,"LRMS SUMMARY REPORT",0,1,'C');
	
	
	
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,0,'',1,1);
	$pdf->Cell(60,5,'',0,0,'l');
	$pdf->Cell(0,5,date("F d, Y"),0,1,'R');
	$pdf->Cell(0,5,'',0,1);
	$pdf->SetFont('Arial','',10);
	$mysubject=mysqli_query($con,"SELECT * FROM tbl_list_of_modules WHERE No ='".$_GET['id']."' LIMIT 1");
	$myrow=mysqli_fetch_assoc($mysubject);
	$pdf->Cell(30,5,'Subjects:',0,0,'L');
	$pdf->Cell(30,5,$myrow['Filename'],0,1,'L');
	$pdf->Cell(30,5,'Grade Level:',0,0,'L');
	if ($myrow['Grade_Level']=='Kinder')
	{
		$pdf->Cell(30,5,$myrow['Grade_Level'],0,1,'L');
	}else{
		$pdf->Cell(30,5,'Grade '.$myrow['Grade_Level'],0,1,'L');
	}
	$pdf->Cell(0,5,'',0,1,'L');
	
	$pdf->Cell(0,5,'List of schools downloaded',0,1,'L');
	$pdf->Cell(10,5,'#',1,0,'C');
	$pdf->Cell(35,5,'Date Downloaded',1,0,'L');
	$pdf->Cell(50,5,'Personnel',1,0,'L');
	$pdf->Cell(0,5,'Station',1,1,'L');
	$no=0;
	$myschool=mysqli_query($con,"SELECT * FROM tbl_download_history INNER JOIN tbl_employee ON tbl_download_history.DownloadedBy=tbl_employee.Emp_ID INNER JOIN tbl_school ON tbl_download_history.SchoolID =tbl_school.SchoolID WHERE ModuleDownloaded='".$_GET['id']."'ORDER BY DownloadedDate Asc");
	while($myrow=mysqli_fetch_array($myschool))
	{
		$no++;
		$pdf->Cell(10,5,$no,1,0,'C');
		$pdf->Cell(35,5,$myrow['DownloadedDate'],1,0,'L');
		$pdf->Cell(50,5,$myrow['Emp_LName'].', '.$myrow['Emp_FName'],1,0,'L');
		$pdf->Cell(0,5,$myrow['SchoolName'],1,1,'L');	
	}
	
	
	
	$pdf->Cell(0,10,"-------------Nothing follows--------------",1,1,'C');
		
	$pdf->Cell(0,10,"",0,1);
	$pdf->Cell(0,15,"Prepared by:",0,1);
	$pdf->Cell(30,5,"",0,0,'C');
	$pdf->Cell(40,5,$_SESSION['prepared'],0,1,'C');
	
		
	//Display the Output data
	$pdf->Output();
?>
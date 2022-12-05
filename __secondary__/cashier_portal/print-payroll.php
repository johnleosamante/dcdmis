
<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
require('../../pcdmis/code128.php');
$pdf=new PDF_Code128('P','mm','Letter');

//Add New Page
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();

   
	$pdf->SetFont('helvetica','',10);
	$pdf->Cell(0,5,'DEPARTMENT OF EDUCATION, PAGADIAN CITY',0,1,'C');
	$pdf->Cell(0,5,'Payroll Prooflist for '.date('F d, Y'),0,1,'C');
	$pdf->Cell(0,5,'',0,1,'C');
	
	//Header
	$pdf->Cell(0,5,'=============================================================================================',0,1);
	$pdf->Cell(0,5,'Account Number                                                                 N A M E                                    
	                                 Amount',0,1);
	$pdf->Cell(0,5,'=============================================================================================',0,1);
	$netpay=$totalDed=0;
	$result=mysqli_query($con,"SELECT * FROM tbl_payroll_salary INNER JOIN tbl_employee ON tbl_payroll_salary.Emp_ID=tbl_employee.Emp_ID WHERE tbl_payroll_salary.Transaction_code='".$_SESSION['code']."' ORDER BY tbl_employee.Emp_LName Asc");
	while ($row=mysqli_fetch_array($result))
	{
		
	$MName=mb_strimwidth($row['Emp_MName'],0,1);
	$pdf->Cell(50,5,$row['Emp_DBP_Account'],0,0);	
	$pdf->Cell(90,5,strtoupper($row['Emp_FName'].' '.$MName.'. '.$row['Emp_LName']),0,0);	
	$totalDed=$row['Emp_GSIS']+$row['Emp_Philhealth']+$row['Emp_Philhealth']+$row['Emp_Pagibig'];
	$netpay=$row['Gross_income']-$totalDed;
	$pdf->Cell(50,5,number_format($netpay,2),0,1,'R');	
		
	}
		
		
		
	
	//Display the Output data
	$pdf->Output();
?>
<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
require('../pcdmis/code128.php');

if ($_SESSION['uid']=="")
{
	header('location:http://'.$_SERVER['HTTP_HOST']);
}
header('content-type:text/html;charset=utf-8');
date_default_timezone_set("Asia/Manila");
$img1='../pcdmis/shs/h1.png';	
$img2='../pcdmis/logo/logo.png';


 	//New PDF File		 
	 $pdf=new PDF_Code128('P','mm','Letter');
	
	//Add New Page
		$pdf->AddPage();
	//Set Font  10	
		$pdf->SetFont('Arial','',12);
	$pdf->Image($img1,150,10,20);
    $pdf->Image($img2,50,10,20);
	//Data
	    $borrowersdata=mysqli_query($con,"SELECT * FROM tbl_provedent_loan INNER JOIN tbl_employee ON tbl_provedent_loan.Emp_ID=tbl_employee.Emp_ID WHERE tbl_provedent_loan.Emp_ID ='".$_SESSION['borrowersid']."' AND tbl_provedent_loan.AccountNo='".$_SESSION['AccountNo']."' LIMIT 1");
		$rowborrower=mysqli_fetch_assoc($borrowersdata);
		$interest=$TotalLoan=$loanterm=$int=0;
		$int=$rowborrower['InterestRate']/100;
		$loanterm=$rowborrower['Loan_Term']/12;
		$interest=$rowborrower['Amount_Loan']*$int*$loanterm;
		$TotalLoan=$rowborrower['Amount_Loan']+$interest;
			
			
	$pdf->Cell(0,5,'Republic of the Philippines',0,1,'C');
	$pdf->Cell(0,5,'Department of Education',0,1,'C');
	$pdf->Cell(0,5,'Region IX, Zamboanga Peninsula',0,1,'C');
	$pdf->Cell(0,5,'DIVISION OF DIPOLOG CITY',0,1,'C');
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(0,5,'Dipolog City',0,1,'C');
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(0,5,'STATEMENT OF ACCOUNT',0,1,'C');
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->Cell(35,5,'Account Number:',0,0,'L');
	$pdf->Cell(70,5,$_SESSION['AccountNo'],0,1,'R');
	$pdf->Cell(35,5,'Barrowers Name:',0,0,'L');
	$pdf->Cell(70,5,$rowborrower['Emp_LName'].', '.$rowborrower['Emp_FName'].' '.$rowborrower['Emp_MName'],0,1,'R');
	$pdf->Cell(35,5,'Loan Type:',0,0,'L');
	$pdf->Cell(70,5,$rowborrower['Loan_Type'],0,1,'R');
	$pdf->Cell(35,5,'Principal Amount:',0,0,'L');
	$pdf->Cell(70,5,number_format($rowborrower['Amount_Loan'],2),0,1,'R');
	$pdf->Cell(35,5,'Loan Term:',0,0,'L');
	$pdf->Cell(70,5,$rowborrower['Loan_Term'].' Months',0,1,'R');
	$pdf->Cell(35,5,'Interest Rate:',0,0,'L');
	$pdf->Cell(70,5,$rowborrower['InterestRate'].' %',0,1,'R');
	$pdf->Cell(35,5,'Interest Amount:',0,0,'L');
	$pdf->Cell(70,5,number_format($interest,2),0,1,'R');
	$pdf->Cell(35,5,'Total Amount:',0,0,'L');
	$pdf->Cell(70,5,number_format($TotalLoan,2),0,1,'R');
	$date = date('M j\, Y', strtotime($rowborrower['Date_Loan']));	
	$pdf->Cell(35,5,'Date Loan:',0,0,'L');
	$pdf->Cell(70,5,$date,0,1,'R');
	$pdf->Cell(0,2,'',0,1,'C');
		
		
		
	$pdf->Cell(0,5,'',0,1,'C');	
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(21,7,'OR No',1,0,'C');	
	$pdf->Cell(22,7,'Date paid',1,0,'C');	
	$pdf->Cell(22,7,'Amount paid',1,0,'C');	
	$pdf->Cell(22,7,'Interest',1,0,'C');	
	$pdf->Cell(22,7,'Capital',1,0,'C');	
	$pdf->Cell(22,7,'Balance',1,0,'C');	
	$pdf->Cell(45,7,'Teller',1,0,'C');	
	$pdf->Cell(20,7,'Remark',1,1,'C');	
	
	//Payment History
	 $remark="";
	$mypayment=mysqli_query($con,"SELECT * FROM tbl_loan_payment INNER JOIN tbl_employee ON tbl_loan_payment.Teller=tbl_employee.Emp_ID WHERE tbl_loan_payment.AccountNo ='".$_SESSION['AccountNo']."'AND tbl_loan_payment.PersonnelNo='".$_SESSION['borrowersid']."'");
	 while($rowpay=mysqli_fetch_array($mypayment))
		{
			  if ($rowpay['Amount_Balance']<>0)
				{
				   $remark="Not Paid"; 
				}else{
					$remark="Paid"; 
				}
			$pdf->Cell(21,5,$rowpay['ORNo'],1,0,'C');	
			$pdf->Cell(22,5,$rowpay['Date_Paid'],1,0,'C');	
			$pdf->Cell(22,5,number_format($rowpay['Amount_Paid'],2),1,0,'C');	
			$pdf->Cell(22,5,number_format($rowpay['Interest'],2),1,0,'C');	
			$pdf->Cell(22,5,number_format($rowpay['Capital'],2),1,0,'C');	
			$pdf->Cell(22,5,number_format($rowpay['Amount_Balance'],2),1,0,'C');	
			$pdf->Cell(45,5,$rowpay['Emp_LName'].', '.$rowpay['Emp_FName'],1,0,'C');	
			$pdf->Cell(20,5,$remark,1,1,'C');	
		}
	
	$pdf->Cell(0,5,'***********Nothing Follow***********',1,1,'C');	
	$pdf->Cell(0,5,'',0,1,'C');	
	$pdf->Cell(0,5,'System Generated: '. date("l, F d, Y").' @ '.date("H:i:sa"),0,1,'L');	
	$pdf->Cell(0,5,'',0,1,'C');	
	$pdf->Cell(0,5,'Prepared by: ',0,1);	
	//Display the Output data
	$pdf->Output();
?>
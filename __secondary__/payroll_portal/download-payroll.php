<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");

header('Content-type: text/plain');
header('Content-Disposition: attachment; filename="ADA'.date('m, Y').'.txt"');

$result1=mysqli_query($con,"SELECT * FROM tbl_payroll_salary INNER JOIN tbl_employee ON tbl_payroll_salary.Emp_ID=tbl_employee.Emp_ID WHERE tbl_payroll_salary.Transaction_code='".$_SESSION['code']."' ORDER BY tbl_employee.Emp_LName Asc");
$DedTotal=$NetPay=$total=0;
while($row=mysqli_fetch_array($result1))
	{
		$DedTotal=$row['Emp_GSIS']+$row['Emp_Pagibig']+$row['Emp_Philhealth'];
		$NetPay=$row['Gross_income']-$DedTotal;
		$total=$total+$NetPay;
	}	
$string="840832042608DEPARTMENT OF EDUCATION, PAGADIAN CITY                         ".$total."\n";
echo $string;
$DedTotal=$NetPay=$total=0;
$result=mysqli_query($con,"SELECT * FROM tbl_payroll_salary INNER JOIN tbl_employee ON tbl_payroll_salary.Emp_ID=tbl_employee.Emp_ID WHERE tbl_payroll_salary.Transaction_code='".$_SESSION['code']."' ORDER BY tbl_employee.Emp_LName Asc");
	while($row=mysqli_fetch_array($result))
	{
		$DedTotal=$row['Emp_GSIS']+$row['Emp_Pagibig']+$row['Emp_Philhealth'];
		$NetPay=$row['Gross_income']-$DedTotal;
		
		$MName=mb_strimwidth($row['Emp_MName'],0,1);
		echo $row['Emp_DBP_Account'];
		echo $row['Emp_FName'].' '.$MName.'. '.$row['Emp_LName'];
		echo ''.$NetPay."\n";
	}

?>


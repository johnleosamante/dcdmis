<?php
$_SESSION['AccountNo']=$_GET['accountno'];
if (isset($_POST['payment']))
{
 mysqli_query($con,"INSERT INTO tbl_loan_payment VALUES('".date("ydms")."','".$_POST['datepaid']."','".$_POST['paymentfor']."','".$_POST['AmountPaid']."','".$_POST['interest']."','".$_POST['capital']."','".$_POST['Balance']."','".$_SESSION['uid']."','".$_GET['accountno']."','".$_SESSION['borrowersid']."')");	
 mysqli_query($con,"UPDATE tbl_provedent_loan SET LoanBalance='".$_POST['Balance']."' WHERE AccountNo='".$_GET['accountno']."' AND Emp_ID='".$_SESSION['borrowersid']."' LIMIT 1");
 if (mysqli_affected_rows($con)==1)
 {
	 ?>
			<script type="text/javascript">
						$(document).ready(function(){						
							$('#access').modal({
								show: 'true'
							}); 				
						});
					</script>
	<?php   
 }
}
?>

<script>
 function calculate()
 {
	var  a = parseFloat(document.getElementById("amountpaid").value);
	var  b = parseFloat(document.getElementById("getbalance").value);
	var  c = parseFloat(document.getElementById("interest").value);
	var d = b - a;
	document.getElementById("balance").value=d + c;
	document.getElementById("capital").value=a-c;
 }
</script>

<style>
	th,td,label{
		text-transform:uppercase;
		text-align:center;
	}
	
	</style>
	<?php
						$borrowersdata=mysqli_query($con,"SELECT * FROM tbl_provedent_loan INNER JOIN tbl_employee ON tbl_provedent_loan.Emp_ID=tbl_employee.Emp_ID WHERE tbl_provedent_loan.Emp_ID ='".$_SESSION['borrowersid']."' AND tbl_provedent_loan.AccountNo='".$_GET['accountno']."' LIMIT 1");
						$rowborrower=mysqli_fetch_assoc($borrowersdata);
						$interest=$TotalLoan=$loanterm=$int=$TotalInt=0;
						$int=$rowborrower['InterestRate']/100;
						$loanterm=$rowborrower['Loan_Term'];
						$interest=$rowborrower['LoanBalance']*0.005;
						$TotalInt=$interest*$loanterm;
						$TotalLoan=($rowborrower['Amount_Loan']+$TotalInt);
						$year=$rowborrower['Loan_Term']/12;
						
												
						//Maturity date
						$getmonths=mb_strimwidth($rowborrower['Date_Loan'],5,2)+1;
						
						$getmonth=mb_strimwidth($rowborrower['Date_Loan'],5,2)+1;
						$getday=mb_strimwidth($rowborrower['Date_Loan'],8,2);
						$getyear=mb_strimwidth($rowborrower['Date_Loan'],0,4);
						$gdate=$getyear.'-'.$getmonth.'-'.$getday;
							if ($getmonths>12)
								{
									$getmon=number_format($getmonths-12,0);
									$getyear++;
									$maturedate=$getyear.'-'.$getmon.'-'.$getday;
								}else{
									$maturedate=$getyear.'-'.$getmonths.'-'.$getday;
							}
							
						
						
						echo '<div class="panel-heading">
		
				
										<img src="../../../pcdmis/images/'.$rowborrower['Picture'].'" style="width:220px;height:200px;border-radius:50%;float:right;">
										<label style="width:15%;">Barrowers Name: </label> <label>'.$rowborrower['Emp_LName'].', '.$rowborrower['Emp_FName'].'</label><br/>
										<label style="width:15%;">Loan Type:</label><label> '.$rowborrower['Loan_Type'].'</label><br/>
										<label style="width:15%;">Principal Amount:</label><label> '.number_format($rowborrower['Amount_Loan'],2).'</label><br/>
										<label style="width:15%;">Loan Balance:</label><label> '.number_format($rowborrower['LoanBalance'],2).'</label><br/>
										<label style="width:15%;">Loan Term:</label><label>'.$rowborrower['Loan_Term'].' Months</label><br/>
										<label style="width:15%;">Interest Rate:</label><label>'.$rowborrower['InterestRate'].'%</label><br/>
										<label style="width:15%;">Interest Amount:</label><label>'.number_format($interest,2).' - Per Month</label><br/>
										<label style="width:15%;">Total Interest:</label><label>'.number_format($TotalInt,2).' - with in <i>('.$year.')</i> years</label><br/>
										<label style="width:15%;">Total Amount Loan:</label><label>'.number_format($TotalLoan,2).' - with in <i>('.$year.')</i> years</label><br/>
										<br/>
										</div>
		
		<a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&No='.urlencode(base64_encode($_SESSION['borrowersid'])).'&v='.urlencode(base64_encode("provident_account")).'" style="float:right;padding:4px;margin:4px;" class="btn btn-secondary">Back</a>';
		?>
		<a href="#mypayment" style="float:right;padding:4px;margin:4px;" class="btn btn-success" data-toggle="modal">Payment</a>
		<a href="print_statement.php" style="float:right;padding:4px;margin:4px;" class="btn btn-info" target="_blank">Statement of Account</a>
			    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                            <tr>
								<th style="text-align:center;">OR No.</th>
									<th>Date Paid</th>
										<th>Payment for</th>
											<th style="text-align:center;">Amount Paid</th>
											<th style="text-align:center;">Interest</th>
											<th style="text-align:center;">Capital</th>
											<th style="text-align:center;">Balance</th>
									    <th>Teller</th>
									<th style="text-align:center;">Remark</th>										
							</tr>	
                     </thead>
                        <tbody>	
						<?php
						  $remark="";
						   $mypayment=mysqli_query($con,"SELECT * FROM tbl_loan_payment INNER JOIN tbl_employee ON tbl_loan_payment.PersonnelNo=tbl_employee.Emp_ID WHERE tbl_loan_payment.AccountNo ='".$_GET['accountno']."'AND tbl_loan_payment.PersonnelNo='".$_SESSION['borrowersid']."'");
							while($rowpay=mysqli_fetch_array($mypayment))
							{
								if ($rowpay['Amount_Balance']<>0)
								{
								 $remark="Not Paid"; 
								}else{
								  $remark="Paid"; 
								}
							  echo '<tr>
										<td>'.$rowpay['ORNo'].'</td>
										<td>'.$rowpay['Date_Paid'].'</td>
										<td>'.$rowpay['Payment_For'].'</td>
										<td>'.number_format($rowpay['Amount_Paid'],2).'</td>
										<td>'.number_format($rowpay['Interest'],2).'</td>
										<td>'.number_format($rowpay['Capital'],2).'</td>
										<td>'.number_format($rowpay['Amount_Balance'],2).'</td>
										<td>'.$rowpay['Emp_LName'].', '.$rowpay['Emp_FName'].'</td>
										<td>'.$remark.'</td>
									</tr>';	
							}
						?>	
						</tbody>
                </table>								
		

<!-- Modal for Re-assign-->
   <div class="panel-body">
                            
                 <!-- Modal -->
     <div class="modal fade" id="mypayment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
     <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header">
         
          <h3 class="modal-title"><center>New Payment</center></h3>
		 
        </div>
		  <form action="" Method="POST" enctype="multipart/form-data">
			<div class="modal-body">
		     <label>Date Paid:</label>
			 <input type="date" name="datepaid" value="<?php echo date("Y-m-d");?>" class="form-control">
			  <label>Payment for:</label>
			  <select name="paymentfor" class="form-control" required>
			    <option value="Interest with Capital">Interest with Capital</option>
			    <option value="Interest only">Interest only</option>
			     </select>
			   <label>Amount Paid:</label>
			 <input type="text" name="AmountPaid" class="form-control" id="amountpaid" placeholder="Amount Paid" onkeyup="calculate(this.value);">
			 <input type="hidden" class="form-control" id="getbalance" value="<?php echo $rowborrower['LoanBalance'];?>">
			 <input type="hidden" name="Balance" class="form-control" id="balance">
			 <input type="hidden" name="capital" class="form-control" id="capital">
			 <input type="hidden"  name="interest" class="form-control" id="interest" value="<?php echo $interest;?>">
			</div>
			 <div class="modal-footer">
			  <input type="submit" name="payment" value="SAVE" class="btn btn-primary">
			   <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
			  </div>
			  </form>
			  
		 </div>
		 </div>
		</div>
	</div>
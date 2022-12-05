<style>
	th,td,label{
		text-transform:uppercase;
		
	}
	
	</style>
	<?php
								$borrowersdata=mysqli_query($con,"SELECT * FROM tbl_provedent_loan INNER JOIN tbl_employee ON tbl_provedent_loan.Emp_ID=tbl_employee.Emp_ID WHERE tbl_provedent_loan.Emp_ID ='".$_SESSION['borrowersid']."' AND tbl_provedent_loan.AccountNo='".$_GET['accountno']."' LIMIT 1");
						$rowborrower=mysqli_fetch_assoc($borrowersdata);
						$interest=$TotalLoan=$loanterm=$int=0;
						$int=$rowborrower['InterestRate']/100;
						$loanterm=$rowborrower['Loan_Term']/12;
						$interest=$rowborrower['Amount_Loan']*$int*$loanterm;
						$TotalLoan=$rowborrower['Amount_Loan']+$interest;
						echo '<div class="panel-heading">
		
				
										<img src="../images/user.png" style="width:220px;height:200px;border-radius:50%;float:right;">
										<label style="width:15%;">Barrowers Name: </label> <label>'.$rowborrower['Emp_LName'].', '.$rowborrower['Emp_FName'].'</label><br/>
										<label style="width:15%;">Loan Type:</label><label> '.$rowborrower['Loan_Type'].'</label><br/>
										<input type="hidden" name="loanamount" id="loanamount" value="'.$rowborrower['Amount_Loan'].'"class="form-control" >
										<label style="width:15%;">Principal Amount:</label><label> '.number_format($rowborrower['Amount_Loan'],2).'</label><br/>
										<label style="width:15%;">Loan Term:</label><label>'.$rowborrower['Loan_Term'].' Months</label><br/>
										<label style="width:15%;">Interest Rate:</label><label>'.$rowborrower['InterestRate'].'%</label><br/>
										<label style="width:15%;">Interest Amount:</label><label>'.number_format($interest,2).'</label><br/>
										<label style="width:15%;">Total Amount:</label><label>'.number_format($TotalLoan,2).'</label><br/>
										<label style="width:15%;">Cut off Date:</label><label>&nbsp;</label><br/>
										<label style="width:15%;">Maturity Date:</label><label>&nbsp;</label><br/>
			
        </div>';
	?>	
		<a href="#mypayment" style="float:right;" class="btn btn-success" data-toggle="modal">Payment</a>
			    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                            <tr>
								<th style="text-align:center;">#</th>
									<th>Date Paid</th>
										<th>Payment for</th>
											<th>Widraw Amount</th>
												<th style="text-align:center;">Amount Paid</th>
												<th style="text-align:center;">Change</th>
											<th style="text-align:center;">Balance</th>
										<th style="text-align:center;">Remark</th>
									<th>Teller</th>
								<th></th>
													
							</tr>	
                     </thead>
                        <tbody>	
						<?php
						 
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
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>New Payment</center></h3>
		 
        </div>
		  <form action="" Method="POST" enctype="multipart/form-data">
			<div class="modal-body">
		     
			</div>
			 <div class="modal-footer">
			  <input type="submit" name="payment" value="SAVE" class="btn btn-success">
			  </div>
			  </form>
			  
		 </div>
		 </div>
		</div>
	</div>
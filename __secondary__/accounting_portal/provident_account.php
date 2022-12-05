<style>
	th,td,label{
		text-transform:uppercase;
		text-align:center;
	}
	
	</style>
	<?php
		
						$borrowersdata=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code WHERE tbl_employee.Emp_ID ='".$_GET['No']."' LIMIT 1");
						$rowborrower=mysqli_fetch_assoc($borrowersdata);
				?>
		<div class="panel-heading">
		<a href="#newloan" style="float:right;" class="btn btn-success" data-toggle="modal">Add New Loan</a>
			
			<label>Borrower's Name:  </label> <label> <?php echo $rowborrower['Emp_LName'].', '.$rowborrower['Emp_FName'];?></label><br/>
			<label>Sex: </label> <label> <?php echo $rowborrower['Emp_Sex'];?></label><br/>
			<label>Address: </label> <label> <?php echo $rowborrower['Emp_Address'];?></label><br/>
			<label>Station: </label> <label> <?php echo $rowborrower['SchoolName'];?></label><br/>
			<label>Contact #: </label><label> <?php echo $rowborrower['Emp_Cell_No'];?></label>
			<?php
			if (isset($_POST['add']))
			{
				mysqli_query($con,"INSERT INTO tbl_provedent_loan VALUES('".date("Ymds")."','".date("Y-m-d")."','".$_POST['loan_term']."','".$_POST['amount']."','".$_POST['purpose']."','".$_POST['interest']."','".$_POST['amount']."','".$_GET['No']."')");
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
        </div>	
			    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                                    <tr>
                                        <th width="5%" style="text-align:center;">#</th>
                                        <th width="10%">Account Number</th>
                                        <th width="10%">Date Loan</th>
                                        <th width="10%">Amount Loan</th>
                                        <th width="10%">Loan Purpose</th>
                                        <th width="10%">Interest Rate</th>
                                        <th width="10%">Loan Term</th>
                                        <th width="10%">Balance</th>
                                        <th width="10%">Remark</th>
                                        <th width="7%"></th>
                                    </tr>
                     </thead>
                        <tbody>	
						<?php
						$_SESSION['borrowersid']=$_GET['No'];
						 $no=$balance=$total=0;
						 $remark="";
                          $myloan=mysqli_query($con,"SELECT * FROM tbl_provedent_loan WHERE Emp_ID='".$_GET['No']."'");
						  while($rowloan=mysqli_fetch_array($myloan))
						  {
							  $no++;
							  $balance=$rowloan['LoanBalance'];
							  if ($balance<>0)
							  {
								 $remark="Not Paid"; 
							  }else{
								  $remark="Paid"; 
							  }
						  echo '<tr>
                                <td style="text-align:center;">'.$no.'</td>
                                  <td style="text-align:center;">'.$rowloan['AccountNo'].'</td>
                                   <td style="text-align:center;">'.$rowloan['Date_Loan'].'</td>
                                    <td style="text-align:center;">'.number_format($rowloan['Amount_Loan'],2).'</td>
                                     <td style="text-align:center;">'.$rowloan['Loan_Type'].'</td>
                                    <td style="text-align:center;">'.$rowloan['InterestRate'].' %</td>
                                   <td style="text-align:center;">'.$rowloan['Loan_Term'].'</td>
                                  <td style="text-align:center;">'.number_format($balance,2).'</td>
                                 <td style="text-align:center;">'.$remark.'</td>
                                <td style="text-align:center;"><a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&accountno='.urlencode(base64_encode($rowloan['AccountNo'])).'&v='.urlencode(base64_encode("loan_ledger")).'">LEDGER</a></td>
                            </tr>';
						  }
						?>	
						</tbody>
                </table>								
		

<!-- Modal for Re-assign-->
   <div class="panel-body">
                            
                 <!-- Modal -->
     <div class="modal fade" id="newloan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
     <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header">
          
          <h3 class="modal-title"><center>New Loan</center></h3>
		 
        </div>
		  <form action="" Method="POST" enctype="multipart/form-data">
			<div class="modal-body">
		      <label>Date Loan:</label>
		     <input type="date" value="<?php echo date("Y-m-d");?>" class="form-control">
			  <label>Loan Purpose:</label>
			  <select name="purpose" class="form-control" required>
				<option value="">--select--</option>
				<option value="MPL (Multipurpose Loan)">MPL (Multipurpose Loan)</option>
				<option value="Additional Loan">Additional Loan</option>
			  </select>
			  <label>Loan Amount:</label>
			  <input type="number" name="amount" class="form-control" required>
			  <label>Loan Term:</label>
			  <select name="loan_term" class="form-control" required>
				<option value="">--select--</option>
				<option value="12">12 Months</option>
				<option value="24">24 Months</option>
				<option value="36">36 Months</option>
				<option value="48">48 Months</option>
				<option value="60">60 Months</option>
			  </select>
			  <label>Interest Rate:</label>
			   <input type="number" name="interest" value="6" class="form-control" required>
			   
			</div>
			 <div class="modal-footer">
			  <input type="submit" name="add" value="SAVE" class="btn btn-success">
			  <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
			  </div>
			  </form>
			  
		 </div>
		 </div>
		</div>
	</div>
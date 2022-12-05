	
	
		 <label style="padding:4px;">Transaction Flow</label><br/>
	
	<table width="100%" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th style="text-align:center;">Sequence No.</th>
					<th>Destination Section</th>
					<th width="5%"></th>
				</tr>	
			</thead>
			<tbody>
				<tr>
					<td style="text-align:center;">1</td>
					<td> 
					 <input type="text" value="RECORD" class="form-control" disabled>
					</td>
					<td>
						
					</td>
				</tr>
				<?php
					session_start();
					include("../vendor/jquery/function.php");
									
					$no=1;
						$destination=mysqli_query($con,"SELECT * FROM tbl_transaction_flow WHERE tbl_transaction_flow.SchoolID ='".$_SESSION['school_id']."'");
							while($row=mysqli_fetch_array($destination))
								{
									$no++;
										echo '<tr>
										<td style="text-align:center;">'.$no.'</td>
										<td> 
										  '.$row['Destination_section'].'
										</td>
										<td>
											
										</td>
									</tr>
									';
								}
							$_SESSION['SequenceNo']=$no+1;	
						?>

				
			</tbody>
		 </table>
		 
		    <form action="insert.php" id="frmBox" method="POST" onsubmit="return formSubmit();">
		 <table width="100%" class="table table-striped table-bordered table-hover">
		 <thead>
		  <tr>
					<th colspan="2"> 
					<select name="section" id="section" class="form-control">
						 <option value="">--Select--</option>
						 <option value="OSDS">OSDS</option>
						 <option value="ASDS">ASDS</option>
						 <option value="SGOD">SGOD</option>
						 <option value="PSDS">PSDS</option>	
						 <option value="HRMO">HRMO</option>
						 <option value="LEGAL">LEGAL</option>
						 <option value="LRMDS">LRMDS</option>
						 <option value="SUPPLY">SUPPLY</option>
						 <option value="BUDGET">BUDGET</option>
						 <option value="PHYSICAL FACILITIES">PHYSICAL FACILITIES</option>
						 <option value="ACCOUNTING">ACCOUNTING</option>
						 <option value="CASHIER">CASHIER</option>
						 <option value="ITO">ITO</option>
						 
					</select>
					</td>
					<td width="5%">
						<button class="btn btn-default" type="submit" onclick="formSubmit()">
							Add
						</button>
						<input type="hidden" id="success">
					</td>
				</tr>
				</thead>
				</table>
				
		 
		</form>
		
		
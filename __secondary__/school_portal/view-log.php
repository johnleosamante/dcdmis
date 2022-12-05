<style>
th,td{
	text-transform:uppercase;
}
</style>  
<div class="row">
                <div class="col-lg-12">
                    <h3></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>      
        <div class="col-lg-12">
                    <div class="panel panel-default">
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <?php
							
							$str=sha1("Pagadian City Division Data Management Information System");
							
							$mystatus=mysqli_query($con,"SELECT * FROM tbl_transactions WHERE  TransCode='". $_SESSION['TransCode']."' AND Trans_Stats <>'Done' LIMIT 1");
							$row=mysqli_fetch_assoc($mystatus);
										
										
						echo'<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("Transactions")).'" class="btn btn-secondary" style="float:right;">Back</a>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						
						      <table width="100%">
								<tr><td style="width:18%;">TRANSACTION CODE:</td><td>'.$row['TransCode'].'</td></tr>
								<tr><td style="width:18%;">TITLE:</td><td>'.$row['Title'].'</td></tr>	
								<tr><td style="width:18%;">DATE/TIME CREATED:</td><td>'.$row['Date_time'].'</td></tr>	
								<tr><td style="width:18%;">FROM:</td><td>'.$row['Trans_from'].'</td></tr>	
								<tr><td style="width:18%;">CURRENT STATUS:</td><td>'.$row['Trans_Stats'].'</td></tr></table>';	
										
						 ?>
						 <a href="print_transaction_logs.php" style="float:right;padding:4px;margin:4px;" class="btn btn-warning" target="_blank">Print</a>
						 <a href="#viewattached" style="float:right;padding:4px;margin:4px;" class="btn btn-info" data-toggle="modal">VIEW ATTACHED FILE</a>
						 
						 <hr/>
						 
						 <h4>Transactions Logs</h4>
						 <table width="100%" class="table table-striped table-bordered table-hover" >
				<thead>
					<tr>
						<th rowspan="2" width="7%" style="text-align:center;">#</th>
						<th rowspan="2">Date / Time Received</th>
						<th rowspan="2">Received by</th>
						<th colspan="2" width="40%" style="text-align:center;"> Offices</th>
						<th rowspan="2" width="15%">Status</th>
					</tr>
				<tr>
					<th width="20%" style="text-align:center;">From</th>
					<th width="20%" style="text-align:center;">To</th>
				</tr>					
				</thead>
											
					<tbody>
						<?php
						
						$no=0;
						$data=mysqli_query($con,"SELECT * FROM tbl_transactions_log INNER JOIN tbl_employee ON tbl_transactions_log.Recieved_by = tbl_employee.Emp_ID WHERE tbl_transactions_log.Transaction_code='". $_SESSION['TransCode']."'");
						 while($row=mysqli_fetch_array($data))
						 {
							 $no++;
							 echo '<tr>
										<td style="text-align:center;">'.$no.'</td>
										<td>'.$row['Date_recieved'].'</td>
										<td>'.$row['Emp_LName'].', '.$row['Emp_FName'].'</td>
										<td style="text-align:center;">'.$row['From_office'].'</td>
										<td style="text-align:center;">'.$row['Forwarded_to'].'</td>
										<td>'.$row['Trans_status'].'</td>
									</tr>';
						 }
						?>	
						
					</tbody>
	</table>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
           					
							
							
	  <div class="panel-body">
                            
                 <!-- Modal -->
     <div class="modal fade" id="viewattached" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
     <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header">
         
          <h3 class="modal-title"><center>Files Information</center></h3>
		 
        </div>
        <div class="modal-body">
		<?php
		$mystatus1=mysqli_query($con,"SELECT * FROM tbl_transactions WHERE  TransCode='".$_SESSION['TransCode']."' LIMIT 1");
		$row1=mysqli_fetch_assoc($mystatus1);
		echo '<iframe src="'.$row1['Attachfile'].'" frameborder="0" width="100%" height="450"></iframe>';
		
		?>
		</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
			</div>
			   </form>
			   
		</div>
		
      

		</div></div></div>
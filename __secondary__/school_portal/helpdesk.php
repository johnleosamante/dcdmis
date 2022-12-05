		 					
	            <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 <a href="#query" data-toggle="modal" class="btn btn-success" style="float:right;">New Request</a>
							<h4>HelpDesk Corner History</h4>
							<?php
							date_default_timezone_set("Asia/Manila");
							$dateposted = date("Y-m-d H:i:s");
							if (isset($_POST['submit_query']))
							{
							mysqli_query($con,"INSERT INTO tbl_school_query VALUES('".$_POST['ticketNo']."','".$_POST['message']."','".$dateposted."','".$_SESSION['uid']."','".$_SESSION['school_id']."','Pending','".$_POST['request']."','NEW')");
							if (mysqli_affected_rows($con)==1)
							{
							$Err = "Transaction Successfully Saved";
									echo '<script type="text/javascript">
										$(document).ready(function(){						
										$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
										
										});</script>
										';	
								echo '<div class="alert alert-success">'.$Err.'</div>';
							}}
							
							?>			
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
													
							<label style="width:100%;padding:4px;margin-left:auto;margin-right:auto;">
                            <?php
							$tot=$totm=$totf=0;
							
								echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            
										<thead>
										
											<tr>
												<th style="width:5%;">#</th>
												<th style="width:15%;">Ticket No</th>
												<th>Query information</th>
												<th style="text-align:center;width:15%;">Date Time Created</th>
												<th width="15%">Request for</th>
												<th style="text-align:center;width:10%;">Status</th>
												<th style="width:7%;"></th>
											</tr>	
											
										</thead>
										<tbody>';
										$no=0;
										$result=mysqli_query($con,"SELECT * FROM tbl_school_query WHERE SchoolID='".$_SESSION['school_id']."'");
										while($rowreq=mysqli_fetch_array($result))
										{
											$no++;
											echo '<tr>
												<td>'.$no.'</td>
												<td>'.$rowreq['TicketNo'].'</td>
												<td>'.$rowreq['Messages'].'</td>
												<td>'.$rowreq['date_posted'].'</td>
												<td>'.$rowreq['requestfor'].'</td>
												<td>'.$rowreq['Status'].'</td>
												<td><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&id='.urlencode(base64_encode($rowreq['TicketNo'])).'&v='.urlencode(base64_encode("reply")).'">View</a></td>
											</tr>';
										}
										echo '</tbody>
									</table>';
						
							
							
							?></label>
							
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
           
	<style>
	input{
		cursor:pointer;
	}
	</style>


 
 <!--Query-->
  <!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="query" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
		
	<div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload()">&times;</button>
		  <h3 class="modal-title">PCDMIS - HelpDesk Corner</h3>
        </div>
		<form action="" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		<label>Ticket Number</label>
		<?php
		echo '<input type="text" value="'.$_SESSION['school_id'].date("yds").'"  class="form-control" disabled>';
		echo '<input type="hidden" name="ticketNo" value="'.$_SESSION['school_id'].date("yds").'">';
		?>
		
		<label>Type of Query</label>	
		<select name="TQuery" class="form-control">
		 <option value="">--select--</option>
		 <option value="Query">Query</option>
		 <option value="Technical Assistance">Technical Assistance</option>
		</select>
		<label>Questions</label>	
		<textarea class="form-control" rows="8" name="message" required></textarea>	
		<label>Request for</label>
			<div class="form-group">
					<label class="checkbox-inline">
                         <input type="radio"  name="request" value="LIS Concerns" required > LIS Concerns
                    </label>
                    
                    <label class="checkbox-inline">
                         <input type="radio"  name="request" value="EBEIS Concerns" required > EBEIS Concerns
                    </label>
                    <label class="checkbox-inline">
                         <input type="radio"  name="request" value="DEPED Account" required > DEPED Account
                    </label>
					      
            </div>
			
			<div class="form-group">
					<label class="checkbox-inline">
                         <input type="radio"  name="request" value="PCDMIS Account" required > PCDMIS Concerns
						</label>  
                    
                    <label class="checkbox-inline">
                         <input type="radio"  name="request" value="LRMDS Concerns" required > LRMDS Concerns
                    </label>
                    <label class="checkbox-inline">
                         <input type="radio"  name="request" value="MICROSOFT 365 Account" required > MICROSOFT 365 Account
                    </label>
				
		</div>
		
		<div class="form-group">
					<label class="checkbox-inline">
                         <input type="radio"  name="request" value="Technical Assisstance" required > Technical Assisstance
						</label>  
                    
                    <label class="checkbox-inline">
                         <input type="radio"  name="request" value="Internet Services" required > Internet Services
                    </label>
                      
            </div>
		<div class="modal-footer">
		<input type="submit" name="submit_query" Value="SUBMIT" class="btn btn-primary">
		</div>
		</form>
	</div></div>
   </div>
</div>
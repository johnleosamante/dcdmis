<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
?>
  <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload()">&times;</button>
          <h3 class="modal-title"><center>ERF Log and Status</center></h3>
		 
        </div>
        <div class="modal-body">
		<label>Transaction Code</label>
		<input type="text" class="form-control" value="<?php echo $_SESSION['TCode']; ?>" disabled>
		<label>Application For</label>
		<input type="text" class="form-control" value="Teacher III" disabled><hr/>
   <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%" style="text-align:center;">#</th>	
                                        <th width="10%">Date</th>
                                        <th width="15%">Recieved by</th>
                                        <th width="10%">Action</th>
                                        <th width="15%">Position</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>	
								<?php
								$no=0;
								$result=mysqli_query($con,"SELECT * FROM tbl_application_log WHERE tbl_application_log.Transaction_number='".$_SESSION['TCode']."'")or die("Error log");
								while($row=mysqli_fetch_array($result))
								{
									$no++;
								echo '<tr>
										<td style="text-align:center;">'.$no.'</td>
										<td>'.$row['Date_recieved'].'</td>
										<td>'.$row['Recieved_by'].'</td>
										<td>'.$row['Action'].'</td>
										<td>'.$row['Forwarded_to'].'</td>
										
										
									</tr>';
								}
								?>
								</tbody>
                            </table>
		
		</div>
		
		
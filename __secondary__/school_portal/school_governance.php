 <script type="text/javascript">
		$(document).ready(function(){						
			setInterval(function(){
				$("#candidate").load("list_of_candidates.php")
							
				},100);
							
		});</script>
		
		
<?php
if (isset($_POST['SetSched']))
{
	mysqli_query($con,"INSERT INTO tbl_ssg_schedule VALUES('".date("ydms")."','".$_SESSION['year']."','".$_POST['adviser']."','".$_POST['elecdate']."','Close','".$_SESSION['school_id']."')");
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

  	 

          <div class="row">
                <div class="col-lg-12">
                    <h3></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>	
			<div class="col-lg-12">
                    <div class="panel panel-default">
					
                        <!-- /.panel-heading -->
                       
						      <div class="panel-heading">
							  <a href="#myssg" class="btn btn-primary" data-toggle="modal" style="float:right;margin:4px;padding:4px;">New Set Officer</a>
								<h3 style="padding:4px;margin:4px;">List of SSG Officer</h3>
							  
							  </div>
							    <div class="panel-body">
								 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%" style="text-align:center;">#</th>
                                        <th width="20%">SCHOOL YEAR</th>
                                        <th >ADVISER</th>
                                        <th width="14%">DATE OF ELECTION</th>
                                        <th width="14%">STATUS</th>
                                        <th width="5%"></th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
								  $result=mysqli_query($con,"SELECT * FROM tbl_ssg_schedule  INNER JOIN tbl_school_year ON tbl_ssg_schedule.SSGBatch=tbl_school_year.SYCode INNER JOIN tbl_employee ON tbl_ssg_schedule.SSGAdviser = tbl_employee.Emp_ID WHERE tbl_ssg_schedule.SchoolID='".$_SESSION['school_id']."'");
								  while($rowdata=mysqli_fetch_array($result))
								  {
									  $no++;
									  echo '<tr>
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$rowdata['SchoolYear'].'</td>
											<td>'.$rowdata['Emp_LName'].', '.$rowdata['Emp_FName'].'</td>
											<td>'.$rowdata['Date_of_election'].'</td>
											<td>'.$rowdata['Election_Status'].'</td>
											<td style="text-align:center;"><a href="view_list_of_candidate.php?status='.urlencode(base64_encode($rowdata['Election_Status'])).'&code='.urlencode(base64_encode($rowdata['SSGBatch'])).'" data-toggle="modal" data-target="#mycandidates"> <i class="fa fa-desktop"></i></a></td>
                                     </tr>';
								  }
								?>
                                </tbody>
								</table>
								
								</div>
					        </div>
					     </div>
						 				
                       
				
				
			<!-- Modal for Re-assign-->
    <div class="panel-body">
                            
                <!-- Modal -->
         <div class="modal fade" id="myssg" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
  			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
						
						<h3 class="modal-title"><center>SET SSG ELECTION DAY</center></h3>
					</div>
					<form action="" Method="POST" enctype="multipart/form-data">
				<div class="modal-body">
		         
				 <label>SSG Batch #:</label>
				 <input type="text"  class="form-control" value="<?php echo 'SSG Batch S.Y'.$_SESSION['sy'];?>" disabled>
				 <label>Adviser:</label>
				 <select name="adviser" class="form-control" required>
				 <option value="">--select--</option>
				 <?php
				   $adviser=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID WHERE tbl_station.Emp_Station ='".$_SESSION['school_id']."' ORDER BY tbl_employee.Emp_LName Asc");
				   while($rowad=mysqli_fetch_array($adviser))
				   {
					   echo ' <option value="'.$rowad['Emp_ID'].'">'.$rowad['Emp_FName'].' '.$rowad['Emp_LName'].'</option>';
				   }
				 ?>
				 </select>
				  <label>Date of Election:</label>
				<input type="date" name="elecdate" class="form-control" placeholder="Election Day" required>
				 
				</div>
				<div class="modal-footer">
					<input type="submit" name="SetSched" value="SAVE" class="btn btn-primary">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				 </form>
		    </div>
		</div>
	  </div>
	</div>
			  	
	               
				
				
			<!-- Modal for Aspirant Candidates-->
    <div class="panel-body">
                            
                <!-- Modal -->
         <div class="modal fade" id="mycandidates" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
  			<!-- Modal content-->
			<div class="modal-content">
				
		    </div>
		</div>
	  </div>
	</div>
			  	
	
<h2>DEPED EMAIL ACCOUNT INFORMATION</h2><hr/>
<?php
if (isset($_POST['send']))
{
	$query=mysqli_query($con,"SELECT * FROM tbl_deped_reset_account WHERE DateRequest='".date("Y-m-d")."' AND Remarks='".$_POST['purpose']."' AND SchoolID='".$_SESSION[GetSiteAlias() . '_SchoolID']."' AND Emp_ID='".$_SESSION[GetSiteAlias() . '_EmpID']."'");
	if (mysqli_num_rows($query)==0)
	{
	 mysqli_query($con,"INSERT INTO tbl_deped_reset_account  VALUES('".date("ydmis")."','".date("Y-m-d")."','".$_SESSION[GetSiteAlias() . '_EmpID']."','".$_POST['EmailAdd']."','".$_SESSION[GetSiteAlias() . '_SchoolID']."','".$_POST['ContactNo']."','".$_POST['purpose']."')");
	}
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
	<div class="col-lg-3">
<form action="" method="POST" enctype="multipart/form-data">
   <div class="panel-body">
    <label>Name:</label><input type="text" class="form-control" value="<?php echo $_SESSION[GetSiteAlias() . '_TeacherName']; ?>"disabled>
	<label>DepEd Emai:</label><input type="email" class="form-control" name="EmailAdd" required>
	<label>Contact No:</label><input type="number" class="form-control" name="ContactNo" required>
	<label>Purpose:</label>
	<select class="form-control" name="purpose" required>
		<option value="">--select--</option>
		<option value="New Account">New Account</option>
		<option value="Reset Account">Reset Account</option>
	</select>
   <hr/>
    <input type="submit" name="send" value="SENT" class="btn btn-primary">
   </div>
 </form> 
  </div>
  
  <div class="col-lg-9">
   <h4>REQUEST HISTORY</h4><hr/>
  <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
		<thead>
			<tr>
				<th style="text-align:center;">Ticket #</th>
				<th>Date Requested</th>
				<th>DepEd Email</th>
				<th>School Assigned</th>
				<th>Contact No.</th>
				<th>Status</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php
		$no=0;
		$myhistory=mysqli_query($con,"SELECT * FROM tbl_deped_reset_account INNER JOIN tbl_school ON tbl_deped_reset_account.SchoolID = tbl_school.SchoolID WHERE tbl_deped_reset_account.Emp_ID='".$_SESSION[GetSiteAlias() . '_EmpID']."'");
		while($rowhist=mysqli_fetch_array($myhistory))
		{
			echo '<tr>
					
					<td>'.$rowhist['TicketNo'].'</td>
					<td>'.$rowhist['DateRequest'].'</td>
					<td>'.$rowhist['depedemail'].'</td>
					<td>'.$rowhist['SchoolName'].'</td>
					<td>'.$rowhist['ContactNo'].'</td>
					<td>'.$rowhist['Remarks'].'</td>
					<td><a href="view_account_info.php?id='.$rowhist['TicketNo'].'" data-toggle="modal" data-target="#viewinfo"><i class="fa fa-desktop fa"></i></a></td>
				  </tr>';
		}
		?>
		</tbody>
		
	</table>
  </div>
  
  
  	 
						 <div class="panel-body">
                            
                            <!-- Modal -->
							 <div class="panel-body">
                            
                           <!-- Modal -->
							  <div class="modal fade" id="viewinfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
							 <div class="modal-dialog">
    
                                    <div class="modal-content">
										
										
										
										
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                        </div>
                        </div>
                        <!-- .panel-body -->
						

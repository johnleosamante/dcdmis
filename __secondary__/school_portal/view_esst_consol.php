<?php
$_SESSION['No']=$_GET['No'];
$myyear=mysqli_query($con,"SELECT * FROM tbl_ipcrf_upload WHERE No='".$_GET['No']."' LIMIT 1");
$rowyear=mysqli_fetch_assoc($myyear);
if (isset($_POST['submit']))
{
	$query=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated WHERE Emp_ID='".$_POST['PName']."' AND ReportNo ='".$_GET['No']."'");
	if (mysqli_num_rows($query)==0)
	{
		mysqli_query($con,"UPDATE tbl_station SET Emp_Position ='".$_POST['position']."' WHERE Emp_ID='".$_POST['PName']."' LIMIT 1");
		mysqli_query($con,"INSERT INTO tbl_ipcrf_consolidated VALUES(NULL,'".$_POST['PName']."','".$_POST['rating']."','".$_POST['remarks']."','".$_POST['position']."','".$_SESSION['school_id']."','".$rowyear['Year']."','".$_GET['No']."')");
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
	<div class="col-lg-12">
	  <h1></h1>
	</div>
<div class="col-lg-12">
                    <div class="panel panel-default">
					
                        <div class="panel-heading">
						
						<a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd942&year=MjAyMg%3D%3D&v=ZXNhdA%3D%3D" class="btn btn-secondary" style="float:right;margin:4px;padding:4px;">Back</a>
					<a href="#myPersonnel" class="btn btn-primary" data-toggle="modal" style="float:right;margin:4px;padding:4px;">ADD PERSONNEL RATING</a>
					<h3>LIST OF CONSOLIDATED REPORT</h3>
					</div>
                        <div class="panel-body">
						
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%" style="text-align:center;">#</th>
                                        <th>PERSONNEL NAME</th>
                                        <th width="15%">POSITION</th>
                                        <th width="10%" style="text-align:center;">RATING</th>
                                        <th width="15%" style="text-align:center;">REMARKS</th>
                                        <th width="7%"></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
								  $result=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated INNER JOIN tbl_employee ON tbl_ipcrf_consolidated.Emp_ID = tbl_employee.Emp_ID INNER JOIN tbl_job ON tbl_ipcrf_consolidated.Position=tbl_job.Job_code WHERE tbl_ipcrf_consolidated.ReportNo='".$_GET['No']."'");
								  while($row=mysqli_fetch_array($result))
								  {
									  $no++;
									 echo '<tr>
												<td style="text-align:center;">'.$no.'</td>
												<td>'.$row['Emp_LName'].', '.$row['Emp_FName'].'</td>
												<td>'.$row['Job_description'].'</td>
												<td style="text-align:center;">'.$row['RatingScore'].'</td>
												<td style="text-align:center;">'.$row['RatingAdjective'].'</td>
												<td><a style="cursor:pointer;" onclick="delete_me(id)" id="'.$row['No'].'">DELETE</a></td>
											</tr>'; 
								  }
								?>
                                </tbody>
                            </table>
                            
                        </div>
                        </div>
                        </div>
                    
					<script>
					function delete_me(id)
					{
						if (confirm("Are you sure you want to delete this information?"))
						{
							alert("Successfully Deleted.");
							window.location.href="delete_rating.php?id="+id;
						}
					}
					</script>
					
					
					
  <div class="panel-body">

    <!-- Modal -->
      <div class="modal fade" id="myPersonnel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
           <div class="modal-dialog">
     <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
         
		  <h4 class="modal-title"><center>ADD RESULT</center></h4>
        </div>
         <form enctype="multipart/form-data" method="post" role="form" action="">
		  <div class="modal-body">
		   <label>Personnel Name:</label>
		   <select name="PName" class="form-control" required>
		   <option value="">--select--</option>
		   <?php
		   $myper=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID WHERE tbl_station.Emp_Station='".$_SESSION['school_id']."' ORDER BY tbl_employee.Emp_LName Asc");
		   while($rowper=mysqli_fetch_array($myper))
		   {
			   echo '<option value="'.$rowper['Emp_ID'].'">'.$rowper['Emp_LName'].', '.$rowper['Emp_FName'].'</option>';
		   }
		   ?>
		   </select>
		   <label>Position:</label>
		    <select name="position" class="form-control" required>
		    <option value="">--select--</option>
			<?php
			$mypost=mysqli_query($con,"SELECT * FROM tbl_job ORDER BY Job_description Asc");
			while($rowpost=mysqli_fetch_array($mypost))
			{
				echo '<option value="'.$rowpost['Job_code'].'">'.$rowpost['Job_description'].'</option>';
			}
			?>
		   </select>
		   <label>Rating:</label>
		   <input type="text" name="rating" class="form-control">
		   <label>Remarks:</label>
		    <select name="remarks" class="form-control" required>
		      <option value="">--select--</option>
		      <option value="OUTSTANDING">OUTSTANDING</option>
		      <option value="VERY SATISFACTORY">VERY SATISFACTORY</option>
		      <option value="SATISFACTORY">SATISFACTORY</option>
		      <option value="UNSATISFACTORY">UNSATISFACTORY</option>
		      <option value="POOR">POOR</option>
		   </select>
		 </div>
		  <div class="modal-footer">
		 <input type="submit" name="submit" class="btn btn-primary" value="SAVE" id="btnEnable">
		  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		 </div>
		 </form>
		
		
	   </div>
		 </div>
	 	  </div>
			 </div>					
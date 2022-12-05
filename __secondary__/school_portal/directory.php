<div class="row">
                <div class="col-lg-12">
                    <h3></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div> 
                 <div class="col-lg-12">
				 <?php
				 if (isset($_POST['submit_file']))
				 {
					 date_default_timezone_set("Asia/Manila");
					 $dateposted = date("Y-m-d H:i:s");				 
					mysqli_query($con,"INSERT INTO wp_directory VALUES(NULL,'".$_POST['department']."','".$_POST['Head_of_Office']."','".$_SESSION['school_id']."')");
					if (mysqli_affected_rows($con)==1)
					 {
						 $Err = "School Directory Successfully Saved";
									echo '<script type="text/javascript">
										$(document).ready(function(){						
										$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
										
										});</script>
										';	
								echo '<div class="alert alert-success">'.$Err.'</div>';
						 
					 }
				 }
				 ?>
                    <div class="panel panel-default">
					
                         <div class="panel-heading">
						 <?php
						  echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("website")).'" style="float:right;" class="btn btn-secondary">Back</a>';
						 	?>
							<a style="float:right;cursor:pointer;" class="btn btn-primary" onclick="addfile()">Add</a>
							   <h4>SCHOOL DIRECTORY</h4>
						   </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
						
							<thead>
								<tr>
								   <th style="width:7%;text-align:center;">#</th>
								   <th width="15%">Department</th>
								   <th>Head Office</th>
								   <th width="15%">Designation</th>
								   <th width="15%">Contact info</th>
								   <th style="width:5%;text-align:center;"></th>
								 </tr>  
							</thead>
							<tbody>	
							 <?php
							 $no=0;
								$mymessage=mysqli_query($con,"SELECT * FROM wp_directory INNER JOIN tbl_employee ON wp_directory.Head_office = tbl_employee.Emp_ID INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code WHERE wp_directory.SchoolID='".$_SESSION['school_id']."'");
								while ($row=mysqli_fetch_assoc($mymessage))
								{
								$no++;
								 echo '<tr>
											<td>'.$no.'</td>
											<td>'.$row['Department'].'</td>
											<td>'.$row['Emp_LName'].', '.$row['Emp_FName'].'</td>
											<td>'.$row['Job_description'].'</td>
											<td>'.$row['Emp_Cell_No'].'</td>
											<td style="text-align:center;"><a href="" data-toggle="modal" data-target="#updates_file">EDIT</a></td>
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
			
		<script>
			function addfile()
			{
			  $('#add_file').modal({
				show: 'true'
			}); 	
			}			
		</script>
		
    <!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="add_file" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Add New Directory</h4>
			</div>
			<form action="" method="POST" enctype="multipart/form-data">
			<div class="modal-body">
		 		<label>Department</label>
				<select name="department" class="form-control" required>
				 <option value="">--select--</option>
				 <option value="English">English</option>
				 <option value="Science">Science</option>
				 <option value="Mathematics">Mathematics</option>
				 
				</select>
		 		<label>Head of office</label>
				<select name="Head_of_Office" class="form-control">
				<option value="">--select--</option>
				<?php
				$head=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE  tbl_station.Emp_Station='".$_SESSION['school_id']."' ORDER BY tbl_employee.Emp_LName Asc");
				while($rowhead=mysqli_fetch_array($head)){
					echo '	<option value="'.$rowhead['Emp_ID'].'">'.$rowhead['Emp_LName'].', '.$rowhead['Emp_FName'].'</option>';
				}
				?>
				</select>
							
		</div>
            <div class="modal-footer">                           
			<input type="submit" name="submit_file" value="SUBMIT" style="cursor:pointer;" class="btn btn-primary">
			</div>
			</form>	
                                       

	</div></div>
	</div>
  </div>
 	
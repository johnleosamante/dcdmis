
	<style>
	th{
		text-transform:uppercase;
	}
	</style>

            <!-- /.row -->
            <div class="row">
                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						  	<h4> DAILTY TIME RECORD SUMMARY INFORMATION</h4>
							<?php
							$_SESSION['per_id']=$_GET['code'];
							if (isset($_POST['update']))
							{
								mysqli_query($con,"UPDATE tbl_station SET Office='".$_POST['office']."' WHERE Emp_ID='".$_GET['code']."' LIMIT 1");
									if (mysqli_affected_rows($con)==1)
									{
									$Err = "Office successfully updated!";
											echo '<script type="text/javascript">
												$(document).ready(function(){						
												$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
												
												});</script>
												';	
										echo '<div class="alert alert-success">'.$Err.'</div>';
									} 
							}
							?>
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<form action="print-dtr.php?url=%278ea8355b2e55b6c656245ba15d7fffb3aa1841b9%27" method="POST">
						<?php
						
						
						 $emp_info=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code WHERE tbl_employee.Emp_ID='".$_GET['code']."'"); 
						 $data=mysqli_fetch_assoc($emp_info);
						
						echo '<b>';
						echo '<img src="../../pcdmis/'.$data['Picture'].'" style="width:200px;height:200px;border-radius:5em;" align="right">';
						echo '<p>Employee ID: '.$_GET['code'].'</p>';
						echo '<p>Employee Name: '.$data['Emp_LName'].', '.$data['Emp_FName'].' '.$data['Emp_MName'].'</p>';
						echo '<p>Current Station: '.$data['SchoolName'].'</p>';
						echo  '<p>Birthdate: '.$data['Emp_Month'].'/'.$data['Emp_Day'].'/'.$data['Emp_Year'].'</p>';
						echo  '<p>Contact No.: '.$data['Emp_Cell_No'].'</p>';
						echo  '<p>Position: '.$data['Job_description'].'</p>';
						echo  '<p>Office: '.$data['Office'].' Section <a href="#updateoffice" data-toggle="modal">Edit</a></p><hr/>';
						?>
                            <label>From</label>
                            <input type="date" name="date_from" class="form-control">
							<label>To</label>
                            <input type="date" name="date_to" class="form-control"><hr>
							<input type="submit" name="search" value="Search" class="btn btn-primary">
							</form>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            

						 <div class="panel-body">
                            
                            <!-- Modal -->
                            <div class="modal fade" id="updateoffice" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog">
                                    <div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.reload()">&times;</button>
										<h4 class="modal-title" id="myModalLabel">UPDATE OFFICE</h4>
										</div>

										<div class="modal-body">
											<form enctype="multipart/form-data" method="post" role="form" action="">
													<div class="form-group">
													<select name="office" class="form-control">
													<option value="">--select--</option>
													<?php
													 $myoffice=mysqli_query($con,"SELECT * FROM tbl_office ORDER BY Office_Name Asc");
													 while ($row=mysqli_fetch_array($myoffice))
													 {
														 echo '<option value="'.$row['Office_Name'].'">'.$row['Office_Name'].'</option>'; 
													 }
													?>
													</select>
													</div>
													<button type="submit" class="btn btn-default" name="update" value="UPDATE">UPDATE</button>
												</form>	
															
											</div>	
																
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                        </div>
                        <!-- .panel-body -->
						
		
							
					
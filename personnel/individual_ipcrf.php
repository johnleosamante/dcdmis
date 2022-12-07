	<?php
		if (isset($_POST['AddScore']))
		{
			$query=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated WHERE Emp_ID='".$_SESSION['EmpID']."' AND SchoolYear='".$_POST['sy']."'");
			if(mysqli_num_rows($query)==0)
			{
				mysqli_query($con,"UPDATE tbl_station SET Emp_Position='".$_POST['position']."' WHERE Emp_ID='".$_SESSION['EmpID']."' LIMIT 1");
				mysqli_query($con,"INSERT INTO tbl_ipcrf_consolidated (Emp_ID,RatingScore,RatingAdjective,Position,SchoolID,SchoolYear)VALUES('".$_SESSION['EmpID']."','".$_POST['rating']."','".$_POST['remarks']."','".$_POST['position']."','".$_SESSION['SchoolID']."','".$_POST['sy']."')") or die ("Hello");
			  if(mysqli_affected_rows($con)==1)
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
		}
	?>	
				<div class="col-lg-12">
				
					
						          <div class="panel panel-default">
                                    <div class="panel-heading">
									<a href="" class="btn btn-success" target="_blank" style="float:right;padding:10px;margin:10px;">Print Preview</a>
									<h4>INDIVIDUAL PERFORMANCE COMMITMENT AND REVIEW FORM (IPCRF)</h4>				 
                                     </div>
								<div class="panel-body">									
									<!-- /.panel-heading -->
									<div class="col-lg-9">	
									
									
								<div class="panel-body" style="overflow-x:auto;">
									
									  <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th width="5%" style="text-align:center;" rowspan="2">#</th>
												<th style="text-align:center;">Station </th>
												<th width="10%"  style="text-align:center;">School Year </th>
												<th width="20%"  style="text-align:center;">Position </th>
												<th width="15%"  style="text-align:center;">Rating</th>
												<th width="15%"  style="text-align:center;">Remarks</th>
												
											</tr>
																	
											</thead>
											<tbody>
												<?php
												$no=0;
												$result=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated INNER JOIN tbl_school_year ON tbl_ipcrf_consolidated.SchoolYear = tbl_school_year.SYCode INNER JOIN tbl_job ON tbl_ipcrf_consolidated.Position=tbl_job.Job_code INNER JOIN tbl_school ON tbl_ipcrf_consolidated.SchoolID =tbl_school.SchoolID  WHERE tbl_ipcrf_consolidated.Emp_ID='".$_SESSION['EmpID']."'");
												while($rowdata=mysqli_fetch_array($result))
												{
													$no++;
													echo '<tr>
														    <td>'.$no.'</td>
														    <td style="text-align:center;">'.$rowdata['SchoolName'].'</td>
														    <td style="text-align:center;">'.$rowdata['SchoolYear'].'</td>
														    <td style="text-align:center;">'.$rowdata['Job_description'].'</td>
														    <td style="text-align:center;">'.$rowdata['RatingScore'].'</td>
														    <td style="text-align:center;">'.$rowdata['RatingAdjective'].'</td>
														  </tr>';
												}
													
												?>
									
										  </tbody>
										</table>		
							
								</div>
                        <!-- /.panel-body -->
                   
							</div>
					
					<div class="col-lg-3">	
					     <form action="" Method="POST" enctype="multipart/form-data">
								Position:
									<select name="position" class="form-control" required>
									  <option value="">--Select--</option>
									  <?php
									   $myjob=mysqli_query($con,"SELECT * FROM tbl_job ORDER BY Job_description Asc");
									   while($rowjob=mysqli_fetch_array($myjob))
									   {
										   echo ' <option value="'.$rowjob['Job_code'].'">'.$rowjob['Job_description'].'</option>';
									   }
									  ?>
									</select>								
							    Rating: <input type="text" name="rating" class="form-control" required>
								Remarks <select name="remarks" class="form-control" required>
										<option value="">--Select--</option>
										<option value="OUTSTANDING">OUTSTANDING</option>
										<option value="VERY SATISFACTORY">VERY SATISFACTORY</option>
										<option value="SATISFACTORY">SATISFACTORY</option>
										<option value="UNSATISFACTORY">UNSATISFACTORY</option>
										<option value="POOR">POOR</option>
										</select>
								School Year:<select name="sy" class="form-control" required>
									  <option value="">--Select--</option>
									  <?php
									   $myyear=mysqli_query($con,"SELECT * FROM tbl_school_year ORDER BY SYCode Desc");
									   while($rowyear=mysqli_fetch_array($myyear))
									   {
										   echo ' <option value="'.$rowyear['SYCode'].'">'.$rowyear['SchoolYear'].'</option>';
									   }
									  ?>
									</select>
									<hr/>
										  
							<input type="submit" name="AddScore" value="SAVE" class="btn btn-primary">		      
									
					</form>
						
					 </div>
					
                    <!-- /.panel -->
                </div>
              </div>
            </div>
				 
         
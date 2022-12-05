<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" onclick="window.location.reload()">&times;</button>
			 <h4 class="modal-title">UPDATE MY WORK EXPERIENCE </h4>
		</div>
	<div class="modal-body">
		<form action="Method="POST">
		  <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
										<tr>
											<th width="20%" colspan="2">Inclusive Dates</th>
											<th width="10%" rowspan="2">Position Title</th>
											<th width="25%" rowspan="2">Department / Agency / Office / Company <br/>
																	    (Write in full do not abbreviate)</th>
											<th width="10%" rowspan="2">Monthly Salary</th>
											<th width="15%" rowspan="2">Salary / job / Pay Grade (if applicable)& step (Format "00-0") Increment</th>
											<th width="10%" rowspan="2">Status of Appointment</th>
											<th width="10%" rowspan="2">Government service (Y/N)</th>
											
										</tr>
										<tr>
											<th>From</th>
											<th>To</th>
										</tr>
										</thead>
										<tbody>
										<?php
										session_start();
										include("../pcdmis/vendor/jquery/function.php");
										foreach ($_GET as $key => $data)
											{
											$id=$_GET[$key]=base64_decode(urldecode($data));
												
											}
										$_SESSION['No']=$id;
										$result3=mysqli_query($con,"SELECT * FROM work_experience WHERE Emp_ID='".$_SESSION['EmpID']."' AND No='".$id."'ORDER BY work_experience.From Desc")or die ("teacher profile Work Experience Error");
											while($row3=mysqli_fetch_array($result3))
											{
											echo '<tr>
												<td style="text-align:center;"><input type="text" name="EFrom" value="'.$row3['From'].'" class="form-control"></td>
												<td style="text-align:center;"><input type="text" name="ETo" value="'.$row3['To'].'" class="form-control"></td>
												<td style="text-align:center;"><input type="text" name="EPost" value="'.$row3['Position_Title'].'" class="form-control"></td>
												<td style="text-align:center;"><input type="text" name="EOrg" value="'.$row3['Organization'].'" class="form-control"></td>
												<td style="text-align:center;"><input type="text" name="ESal" value="'.$row3['Monthly_Salary'].'" class="form-control"></td>
												<td style="text-align:center;"><input type="text" name="EGarde" value="'.$row3['Salary_Grade'].'" class="form-control"></td>
												<td style="text-align:center;"><input type="text" name="EStatus" value="'.$row3['Job_Status'].'" class="form-control"></td>
												<td style="text-align:center;"><input type="text" name="EGov" value="'.$row3['Goverment'].'" class="form-control"></td>
												</tr>';	
											}
										?>
									</tbody>
								</table>			
										<input type="submit" name="update_work_experience" value="Update" class="btn btn-primary">
										</form>
							
								  </div>
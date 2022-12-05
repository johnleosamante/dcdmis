<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" onclick="window.location.reload()">&times;</button>
			 <h4 class="modal-title">UPDATE MY EDUCATIONAL BACKGROUND </h4>
		</div>
	<div class="modal-body">
		<form action="" Method="POST" enctype="multipart/form-data">
		 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
										<tr>
											<th width="10%" rowspan="2">Level</th>
											<th width="20%" rowspan="2">Name of School <br/> (Write in Full)</th>
											<th width="20%" rowspan="2">Basic Education / Degree / Course <br/> (Write in Full)</th>
											<th width="20%" colspan="2">Period of Attendance</th>
											<th width="15%" rowspan="2">Highest Level / Units Earned <br/> (If not Graduated)</th>
											<th width="10%" rowspan="2">Year Graduated</th>
											<th width="10%" rowspan="2">SCHOLARSHIP/ ACADEMIC HONORS RECEIVED</th>
											
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
										$result=mysqli_query($con,"SELECT * FROM educational_background WHERE Emp_ID='".$_SESSION['EmpID']."' AND No='".$id."'") or die ("View Profile Family Background Error");
											while($row=mysqli_fetch_array($result))
											{
											echo '<tr><td style="text-align:center;"><input name="ELevel" type="text" class="form-control" value="'.$row['Level'].'"></td>
													  <td style="text-align:center;"><input name="ESchool" type="text" class="form-control" value="'.$row['Name_of_School'].'"></td>
													  <td style="text-align:center;"><input name="ECourse" type="text" class="form-control" value="'.$row['Course'].'"></td>
													  <td style="text-align:center;"><input name="EFrom" type="text" class="form-control" value="'.$row['From'].'"></td>
													  <td style="text-align:center;"><input name="ETo" type="text" class="form-control" value="'.$row['To'].'"></td>
													  <td style="text-align:center;"><input name="EHighest" type="text" class="form-control" value="'.$row['Highest_Level'].'"></td>
													  <td style="text-align:center;"><input name="EGraduated" type="text" class="form-control" value="'.$row['Year_Graduated'].'"></td>
													  <td style="text-align:center;"><input name="EHonor" type="text" class="form-control" value="'.$row['Honor_Recieved'].'"></td>
												  </tr>';	
											}
										?>
										
									</tbody>
								</table>		
										<input type="submit" name="update_education" value="Update" class="btn btn-primary">
										</form>
							
								  </div>
<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" onclick="window.location.reload()">&times;</button>
			 <h4 class="modal-title">UPDATE MY TRAINING </h4>
		</div>
	<div class="modal-body">
		<form action="" Method="POST">
		 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
										<tr>
											<th width="25%" rowspan="2">Title Learning and Development Interventions / Training programs <br/>(write in full)</th>
											<th width="30%" colspan="2">Inclusive Dates <br/>(mm/dd/yyyy)</th>
											<th width="10%" rowspan="2">Number of hours</th>
											<th width="15%" rowspan="2">Type of LD (Managerial / Supervisor / Technical / etc)</th>
											<th width="20%" rowspan="2">Conducted / Sponsored by<br/>(Write in Full) </th>
											
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
										$result5=mysqli_query($con,"SELECT * FROM learning_and_development WHERE Emp_ID='".$_SESSION['EmpID']."' AND No='".$id."'")or die ("Teacher Profile Voluntary Work Error");
											while ($row5=mysqli_fetch_array($result5))
											{
												echo	'<tr>
															<td style="text-align:center;"><input type="text" name="TTraining" value="'.$row5['Title_of_Training'].'" class="form-control"></td>
															<td style="text-align:center;"><input type="text" name="TFrom" value="'.$row5['From'].'" class="form-control"></td>
															<td style="text-align:center;"><input type="text" name="TTo" value="'.$row5['To'].'" class="form-control"></td>
															<td style="text-align:center;"><input type="text" name="THour" value="'.$row5['Number_of_Hours'].'" class="form-control"></td>
															<td style="text-align:center;"><input type="text" name="TManage" value="'.$row5['Managerial'].'" class="form-control"></td>
															<td style="text-align:center;"><input type="text" name="TConduct" value="'.$row5['Conducted'].'" class="form-control"></td>
															</tr>';
											}	
										
										?>
									</tbody>
								</table>		
										<input type="submit" name="update_LAD" value="Update" class="btn btn-primary">
										</form>
							
								  </div>
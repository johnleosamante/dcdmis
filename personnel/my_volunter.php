<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" onclick="window.location.reload()">&times;</button>
			 <h4 class="modal-title">UPDATE MY VOLUNTER </h4>
		</div>
	<div class="modal-body">
		<form action="" Method="POST">
		  <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
										<tr>
											<th width="20%" rowspan="2">Name & address of organization <br/>(write in full)</th>
											<th width="30%" colspan="2">Inclusive Dates <br/>(mm/dd/yyyy)</th>
											<th width="10%" rowspan="2">Number of hours</th>
											<th width="20%" rowspan="2">Position / Nature of work</th>
											
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
										$result4=mysqli_query($con,"SELECT * FROM voluntary_work WHERE Emp_ID='".$_SESSION['EmpID']."' AND No='".$id."'")or die ("Teacher Profile Voluntary Work Error");
											while ($row4=mysqli_fetch_array($result4))
											{
											echo '<tr>
													<td style="text-align:center;"><input type"text" name="NOrg" Value="'.$row4['Name_of_Organization'].'" class="form-control"></td>
													<td style="text-align:center;"><input type"text" name="NFrom" Value="'.$row4['From'].'" class="form-control"></td>
													<td style="text-align:center;"><input type"text" name="NTo" Value="'.$row4['To'].'" class="form-control"></td>
													<td style="text-align:center;"><input type"text" name="NHour" Value="'.$row4['Number_of_Hour'].'" class="form-control"></td>
													<td style="text-align:center;"><input type"text" name="NPos" Value="'.$row4['Position'].'" class="form-control"></td>
														  </tr>';
											}
										?>
									</tbody>
								</table>		
										<input type="submit" name="update_voluntary" value="Update" class="btn btn-primary">
										</form>
							
								  </div>
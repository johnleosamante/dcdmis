<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" onclick="window.location.reload()">&times;</button>
			 <h4 class="modal-title">UPDATE MY FAMILY BACKGROUND </h4>
		</div>
	<div class="modal-body">
		<form action="" Method="POST" enctype="multipart/form-data">
		 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
										<tr>
											<th width="20%">Family Name</th>
											<th width="30%">First Name</th>
											<th width="30%">Middle Name</th>
											<th width="10%">Birthdate</th>
											<th width="10%">Relation</th>
											
											
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
										$result1=mysqli_query($con,"SELECT * FROM  	family_background  WHERE  	family_background.Emp_ID='".$_SESSION['EmpID']."' AND  	family_background.No ='".$id."'") or die ("View Profile Family Background Error");
											while($row1=mysqli_fetch_array($result1))
											{
											echo '<tr><td style="text-align:center;"><input type="text" name="Lname" class="form-control" value="'.$row1['Family_Name'].'"></td>
													  <td style="text-align:center;"><input type="text" name="Fname" class="form-control" value="'.$row1['First_Name'].'"></td>
													  <td style="text-align:center;"><input type="text" name="Mname" class="form-control" value="'.$row1['Middle_Name'].'"></td>
													  <td style="text-align:center;"><input type="date" name="Bdate" class="form-control" value="'.$row1['Birthdate'].'"></td>
													  <td style="text-align:center;"><input type="text" name="Relate" class="form-control" value="'.$row1['Relation'].'"></td>
													  
												  </tr>';	
											}
				
										?>
									</tbody>
								</table>			
										<input type="submit" name="update_family" value="Update" class="btn btn-primary">
										</form>
							
								  </div>
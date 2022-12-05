<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" onclick="window.location.reload()">&times;</button>
			 <h4 class="modal-title">UPDATE REFERENCES </h4>
		</div>
	<div class="modal-body">
		<form action="" Method="POST">
		<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
			<thead>
			<tr>
				<th width="20%">Government Issued ID</th>
					<th width="30%">ID/License/Passport No</th>
							<th width="30%">Date/Place of Issuance  </th>
											
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
									$myrefre=mysqli_query($con,"SELECT * FROM reference WHERE Emp_ID='".$_SESSION['EmpID']."' AND No='".$id."' ")or die ("Teacher Profile Voluntary Work Error");
										while($rowref=mysqli_fetch_array($myrefre))
											{
											echo '<tr><td style="text-align:center;"><input type="text" name="RefName" value="'.$rowref['Name'].'" class="form-control"></td>
													  <td style="text-align:center;"><input type="text" name="RefAddress" value="'.$rowref['Address'].'" class="form-control"></td>
													  <td style="text-align:center;"><input type="text" name="RefContact" value="'.$rowref['Tel_No'].'" class="form-control"></td>
													  
												  </tr>';	
											}
				
										?>
										
									</tbody>
									
								</table>	
										<input type="submit" name="update_reference" value="Update" class="btn btn-primary">
										</form>
							
								  </div>
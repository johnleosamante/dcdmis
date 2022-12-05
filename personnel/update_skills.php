<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" onclick="window.location.reload()">&times;</button>
				<h4 class="modal-title">Update Other Information</h4>
		</div>
			<div class="modal-body">
				<form enctype="multipart/form-data" method="post" role="form" action="">
				<div class="form-group">
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
										<tr>
											<th width="30%">SPECIAL SKILLS and HOBBIES</th>
											<th width="40%">NON-ACADEMIC DISTINCTIONS / RECOGNITION <br/> (Write in full)</th>
											<th width="30%">MEMBERSHIP IN ASSOCIATION/ORGANIZATION   <br/>(Write in full)</th>
											
											
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
										$result6=mysqli_query($con,"SELECT * FROM other_information WHERE other_information.Emp_ID='".$_SESSION['EmpID']."' AND other_information.No='".$id."'")or die ("Teacher other info Error");
											while ($row6=mysqli_fetch_array($result6))
											{
												echo	'<tr>
															<td style="text-align:center;"><input type="text" name="myspecial" class="form-control" value="'.$row6['Special_Skills'].'"></td>
															<td style="text-align:center;"><input type="text" name="myrecog" class="form-control" value="'.$row6['Recognation'].'"></td>
															<td style="text-align:center;"><input type="text" name="myorg" class="form-control" value="'.$row6['Organization'].'"></td>
															
														</tr>';
											}	
										
										?>
									</tbody>
								</table>		
					</div>
					<button type="submit" class="btn btn-primary" name="update_other" value="SAVE">UPDATE</button>
				</form>
																
				</div>
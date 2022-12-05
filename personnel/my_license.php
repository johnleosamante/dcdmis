<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" onclick="window.location.reload()">&times;</button>
			 <h4 class="modal-title">UPDATE LICENSE </h4>
		</div>
	<div class="modal-body">
		<form action="" Method="POST" enctype="multipart/form-data">
		<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
										<tr>
											<th width="20%" rowspan="2">Career Services / RA 1080 (BOARD / BAR) Underspecial Laws / CES / CSEE Barangay Eligibility/ Drivers License</th>
											<th width="15%" rowspan="2">Rating (if Applicable)</th>
											<th width="25%" rowspan="2">Date of Examinition Conferment</th>
											<th width="15%" rowspan="2">Place of Examinition / Conferment</th>
											<th width="25%" colspan="2">License(if Applicable)</th>
											
										</tr>
										<tr>
											<th>Number</th>
											<th>Date of Validity</th>
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
										$result2=mysqli_query($con,"SELECT * FROM civil_service WHERE Emp_ID='".$_SESSION['EmpID']."' AND No ='".$id."'")or die ("Teacher Profile Elegibility Error");
											while($row2=mysqli_fetch_array($result2))
											{
											echo '<tr>
												<td style="text-align:center;"><input type="text" name="WCareer" value="'.$row2['Carrer_Service'].'" class="form-control"></td>
												<td style="text-align:center;"><input type="text" name="WRating" value="'.$row2['Rating'].'" class="form-control"></td>
												<td style="text-align:center;"><input type="date" name="WDate" value="'.$row2['Date_of_Examination'].'" class="form-control"></td>
												<td style="text-align:center;"><input type="text" name="WPlace" value="'.$row2['Place_of_Examination'].'" class="form-control"></td>
												<td style="text-align:center;"><input type="text" name="WNHour" value="'.$row2['Number_of_Hour'].'" class="form-control"></td>
												<td style="text-align:center;"><input type="date" name="WValidity" value="'.$row2['Date_of_Validity'].'" class="form-control"></td>
												</tr>';
											}
										?>
										
									</tbody>
								</table>		
						<input type="submit" name="update_licence" value="Update" class="btn btn-primary">
					</form>
					</div>
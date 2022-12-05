<style>
	th {
		text-transform: uppercase;
	}
</style>

<?php
if (isset($_POST['save'])) {
	$age = date('Y') - $_POST['Year'];

	$emapData1 = $_POST['Employee_ID'];
	$emapData2 = $_POST['LName'];
	$emapData3 = $_POST['FName'];
	$emapData4 = $_POST['MName'];
	$emapData5 = $_POST['extension'];
	$emapData6 = $_POST['month'];
	$emapData7 = $_POST['day'];
	$emapData8 = $_POST['Year'];
	$emapData9 = "";
	$emapData10 = $_POST['sex'];
	$emapData11 = "";
	$emapData12 = $_POST['civil_status'];
	$emapData13 = "";
	$emapData14 = "";
	$emapData15 = "";
	$emapData16 = "";
	$emapData17 = "";
	$emapData18 = $_POST['email'];
	$emapData19 = "../images/user.png";
	$emapData20 = $_POST['TIN'];
	$emapData21 = "Active";



	//psipop
	$emapData29 = $_POST['ItemNo'];
	$emapData30 = $_POST['AutoSal'];
	$emapData31 = $_POST['Actual'];
	$emapData32 = $_POST['stepno'];
	$emapData33 = "";
	$emapData34 = "";
	$emapData35 = "";
	$emapData36 = "";
	$emapData37 = $_POST['TIN'];
	$emapData38 = $_POST['job_status'];
	$emapData39 = $_POST['DOA'];
	$emapData40 = $_POST['elegibility'];
	$stat = mb_strimwidth($_POST['DOA'], 0, 4);
	$noOfYears = date('Y') - $stat;
	$sql = "INSERT into tbl_employee values ('$emapData1','$emapData2','$emapData3','$emapData4','$emapData5','$emapData6','$emapData7','$emapData8','$emapData9','$emapData10','$emapData11','$emapData12','$emapData13','$emapData14','$emapData15','$emapData16','$emapData17','$emapData18','$emapData19','$emapData20','$emapData21','-','','')";
	mysqli_query($con, $sql) or die("Error Employee");

	mysqli_query($con, "INSERT into tbl_station values(NULL,'" . $_POST['DOA'] . "','" . $_POST['position'] . "','" . $_POST['school'] . "','" . $_POST['Category'] . "','" . $_POST['office'] . "','$age','" . $_POST['Employee_ID'] . "')") or die("Error Station");


	//$sql = "INSERT into psipop values (NULL,'$emapData29','$emapData30','$emapData31','$emapData32','$emapData33','$emapData34','$emapData35','$emapData36','$emapData37','$emapData38','$emapData39','$emapData40')";
	//mysqli_query($con,$sql)or die ("Error Psipop");

	//mysqli_query($con,"INSERT INTO tbl_deployment_history VALUES(NULL,'".$_POST['DOA']."','".$_POST['school']."','".$_POST['position']."','$noOfYears','".$_POST['Employee_ID']."')")or die ("Error deploment History");
	//mysqli_query($con,"INSERT INTO tbl_step_increment VALUES(NULL,'".$stat."','".$_POST['stepno']."','0','".$_POST['Employee_ID']."')")or die ("Step Error");					
	if (mysqli_affected_rows($con) == 1) {
?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#access').modal({
					show: 'true'
				});
			});
		</script>


<?php
	}
} elseif (isset($_POST['update'])) {
	mysqli_query($con, "UPDATE tbl_employee SET Emp_Status='" . $_POST['remark'] . "' WHERE Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1");

	if (mysqli_affected_rows($con) == 1) {
		$Err = "Employee Successfully Removed";
		echo '<script type="text/javascript">
										$(document).ready(function(){						
										$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
										
										});</script>
										';
		echo '<div class="alert alert-success">' . $Err . '</div>';
	}
}


?>


<div class="panel panel-default">
	<div class="panel-heading">
		<a href="#myPersonnel" class="btn btn-primary" data-toggle="modal" style="float:right;">New Personnel</a>
		<a href="print_deped_email.php" class="btn btn-primary" style="float:right;" target="_blank">Print DepEd Email</a>
		<h4>Personnel Masterlist</h4>

	</div>

	<!-- /.panel-heading -->
	<div class="panel-body">
		<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
			<thead>
				<tr>
					<th width="5%">#</th>
					<th width="15%">Last Name</th>
					<th width="14%">First Name</th>
					<th width="14%">Middle Name</th>
					<th width="5%">Extension</th>
					<th width="10%">Sex</th>
					<th width="15%">Station</th>
					<th width="15%">Position</th>
					<th width="15%">BDate</th>
					<th width="7%"></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 0;
				$myinfo = mysqli_query($con, "SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID =tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE tbl_employee.Emp_Status ='Active' ORDER BY Emp_LName Asc");
				while ($row = mysqli_fetch_array($myinfo)) {
					$no = $no + 1;
					echo '<tr class="gradeA">
											<td style="text-align:center;">' . $no . '</td>
											<td>' . $row['Emp_LName'] . '</td>
											<td>' . $row['Emp_FName'] . '</td>
											<td>' . $row['Emp_MName'] . '</td>
											<td style="text-align:center;">' . $row['Emp_Extension'] . '</td>
											<td style="text-align:center;">' . $row['Emp_Sex'] . '</td>
											<td>' . $row['Abraviate'] . '</td>
											<td>' . $row['Job_description'] . '</td>
											<td>' . $row['Emp_Month'] . '/' . $row['Emp_Day'] . '/' . $row['Emp_Year'] . '</td>
											<td class="dropdown">
													
															<a class="dropdown-toggle" data-toggle="dropdown" href="#">
																<i class="fa fa-gear fa-fw"></i> <i class="fa fa-caret-down"></i>
															</a>
															<ul class="dropdown-menu dropdown-user">';

					echo '
															<li><a href="./?' . $str . '7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&code=' . urlencode(base64_encode($row['Emp_ID'])) . '&v=' . urlencode(base64_encode("mydate")) . '"target="_blank" ><i class="fa fa-home  fa-fw"></i> My DTR</a>
																</li>
																<li><a href="my_deployment.php?id=' . $row['Emp_ID'] . '"" data-toggle="modal" data-target="#myupdate"><i class="fa fa-home  fa-fw"></i> Deployment</a>
																</li>
																<li><a href="newaccount.php?id=' . $row['Emp_ID'] . '" data-toggle="modal" data-target="#myupdate"><i class="fa fa-male  fa-fw"></i> Account</a>
																</li>
																<li><a href="delete-record.php?id=' . $row['Emp_ID'] . '" data-toggle="modal" data-target="#myupdate"><i class="fa fa-male  fa-fw"></i> Removed</a>
																</li>';


					echo '</ul>
															
														
													</td>
                                        </tr>';
				}
				?>
			</tbody>
		</table>


	</div>
	<!-- /.panel-body -->
</div>
<!-- /.panel -->
</div>


<style>
	.modal-footer {
		background-color: #f9f9f9;
	}

	.deploy {
		width: 800px;
		height: auto;
		margin-top: 50px;
		margin-left: auto;
		margin-right: auto;
	}

	.loginbox {
		width: 1000px;
		height: auto;
		margin-top: 10px;
		margin-left: auto;
		margin-right: auto;
	}

	@media only screen and (max-width: 760px),
	(min-device-width: 768px) and (max-device-width: 1024px) {
		.loginbox {
			width: 100%;
			height: auto;
			margin-top: 100px;
			margin-left: auto;
			margin-right: auto;
		}

		.deploy {
			width: 100%;
			height: auto;
			margin-top: 50px;
			margin-left: auto;
			margin-right: auto;
		}
	}
</style>


<!-- Modal for Re-assign-->
<div class="panel-body">

	<!-- Modal -->
	<div class="modal fade" id="myupdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">


			<!-- Modal content-->
			<div class="modal-content">



			</div>
		</div>
	</div>
</div>





<!-- Modal -->
<div class="panel-body">

	<!-- Modal -->
	<div class="modal fade" id="myPersonnel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="loginbox">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>

					<h4 class="modal-title">
						<center>NEW EMPLOYEES</center>
					</h4>
					<form enctype="multipart/form-data" method="post" role="form" action="">

				</div>
				<div class="modal-body">

					<div class="form-group">
						<!--Begin-->
						<div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="panel panel-default">
									<div class="panel-heading">
										Personal Information
									</div>
									<div class="panel-body">
										<dl class="dl-horizontal">
											<table width="100%">
												<tr>
													<th colspan="2" style="text-align:left;">
														<label>Employe ID:</label>
													</th>
												</tr>
												<tr>
													<th colspan="2" style="text-align:left;">
														<?php
														//$query=mysqli_query($con,"SELECT * FROM tbl_employee");
														$tempID = date('Y') . date("ms");
														echo '<input type="text" name="Employee_ID" value="' . $tempID . '" class="form-control" required>';
														?>
													</th>
												</tr>
												<tr>
													<th colspan="2" style="text-align:left;">
														<label>LAST NAME:</label>
													</th>
												</tr>
												<tr>
													<th colspan="2" style="text-align:left;">
														<input type="text" name="LName" placeholder="LAST NAME" class="form-control" required>
													</th>
												</tr>
												<tr>
													<th style="text-align:left;">
														<label>FIRST NAME:</label>
													</th>
													<th>
														<label>EXTENSION:</label>
													</th>
												</tr>
												<tr>
													<th>
														<input type="text" name="FName" placeholder="FIRST NAME" class="form-control">
													</th>
													<th>
														<select name="extension" class="form-control" style="float:right;">
															<option value="">--Extension--</option>
															<option value="JR">JR</option>
															<option value="SR">SR</option>
														</select>
													</th>
												</tr>
												<tr>
													<th style="text-align:left;">
														<label>MIDDLE NAME:</label>
													</th>
													<th>
														<label>SEX:</label>
													</th>
												</tr>
												<tr>
													<th>
														<input type="text" name="MName" placeholder="MIDDLE NAME" class="form-control" required>
													</th>
													<th>
														<select name="sex" class="form-control" required>
															<option value="">--Sex--</option>
															<option value="Male">Male</option>
															<option value="Female">Female</option>

														</select>
													</th>
												</tr>
												<tr>
													<th style="text-align:left;">
														<label>BIRTHDATE:</label>
													</th>
												</tr>
											</table>
											<table width="100%">
												<tr>
													<dd>
														<td>
															<select name="month" class="form-control" required>
																<option value="">--Month--</option>
																<option value="1">January</option>
																<option value="2">February</option>
																<option value="3">March</option>
																<option value="4">April</option>
																<option value="5">May</option>
																<option value="6">June</option>
																<option value="7">July</option>
																<option value="8">August</option>
																<option value="9">September</option>
																<option value="10">October</option>
																<option value="11">November</option>
																<option value="12">December</option>
															</select>
														</td>
														<td>
															<select name="day" class="form-control" required>
																<option value="">--Day--</option>
																<option value="1">1</option>
																<option value="2">2</option>
																<option value="3">3</option>
																<option value="4">4</option>
																<option value="5">5</option>
																<option value="6">6</option>
																<option value="7">7</option>
																<option value="8">8</option>
																<option value="9">9</option>
																<option value="10">10</option>
																<option value="11">11</option>
																<option value="12">12</option>
																<option value="13">13</option>
																<option value="14">14</option>
																<option value="15">15</option>
																<option value="16">16</option>
																<option value="17">17</option>
																<option value="18">18</option>
																<option value="19">19</option>
																<option value="20">20</option>
																<option value="21">21</option>
																<option value="22">22</option>
																<option value="23">23</option>
																<option value="24">24</option>
																<option value="25">25</option>
																<option value="26">26</option>
																<option value="27">27</option>
																<option value="28">28</option>
																<option value="29">29</option>
																<option value="30">30</option>
																<option value="31">31</option>
															</select>
														</td>
														<td>
															<input type="text" name="Year" class="form-control" placeholder="Year" required>
														</td>
													</dd>
												</tr>
											</table>
											<table width="100%">
												<tr>
													<th style="width:60%;text-align:left;">
														<label>EMAIL ADDRESS:</label>
													</th width="50%">
													<th><label>CIVIL STATUS:</label></th>
												</tr>
												<tr>
													<th width="60%">
														<input type="email" name="email" class="form-control" placeholder="DepEd Email Account" required>
													</th>
													<th>
														<select name="civil_status" class="form-control" required>
															<option value="">--Select--</option>
															<option value="Single">Single</option>
															<option value="Married">Married</option>
															<option value="Widow">Widow</option>
															<option value="Separated">Separated</option>

														</select>
													</th>
												</tr>
											</table>
										</dl>
									</div>
								</div>

							</div>



							<div class="col-lg-6 col-md-6">
								<div class="panel panel-default">

									<div class="panel-body">
										<dl class="dl-horizontal">
											<label>ITEM NUMBER:</label>
											<input type="text" name="ItemNo" class="form-control" placeholder="Enter Item Number" required>
											<table width="100%">
												<tr>
													<th>
														<label>AUTORIZED SALARY:</label>
													</th>
													<th>
														<label>ACTUAL SALARY:</label>
													</th>
													<th>
														<label>STEP:</label>
													</th>
												</tr>
												<tr>
													<th>
														<input type="text" name="AutoSal" class="form-control" placeholder="Autorized salary" required>
													</th>
													<th>
														<input type="text" name="Actual" class="form-control" placeholder="Actual salary" required>
													</th>
													<th>
														<input type="text" name="stepno" class="form-control" placeholder="Enter Step #" required>
													</th>
												</tr>
											</table>
											<table width="100%">
												<tr>
													<th>
														<label>DATE OF APPOINTMENT:</label>
													</th>
													<th>
														<label>ELEGIBILITY:</label>
													</th>
												</tr>
												<tr>
													<th>
														<input type="date" name="DOA" class="form-control" placeholder="Date of Appointment" required>
													</th>
													<th>
														<input type="text" name="elegibility" class="form-control" placeholder="Eligibility" required>
													</th>
												</tr>
											</table>
											<table width="100%">
												<tr>
													<th>
														<label>POSITION:</label>
													</th>
													<th>
														<label>JOB STATUS:</label>
													</th>
												</tr>
												<tr>
													<th>
														<select name="position" class="form-control" required>
															<option value="">--Select--</option>
															<?php
															$data = mysqli_query($con, "SELECT * FROM tbl_job") or die("Error Job");
															while ($row = mysqli_fetch_array($data)) {
																echo '<option value="' . $row['Job_code'] . '">' . $row['Job_description'] . '</option>';
															}
															?>
														</select>
													</th>
													<th>
														<select name="job_status" class="form-control" required>
															<option value="">--Select--</option>
															<option value="Permanent">Permanent</option>
															<option value="Provisional">Provisional</option>
															<option value="Job Order">Job Order</option>

														</select>
													</th>
												</tr>

											</table>
											<label>SCHOOL:</label>
											<select name="school" class="form-control">
												<option value="">--Select--</option>
												<?php
												$data = mysqli_query($con, "SELECT * FROM tbl_school") or die("Error School");
												while ($row = mysqli_fetch_array($data)) {
													echo '<option value="' . $row['SchoolID'] . '">' . $row['SchoolName'] . '</option>';
												}
												?>
											</select>

											<table width="100%">
												<tr>
													<dd>
														<td width="35%"><label>CATEGORY:</label></td>
														<td width="30%"><label>OFFICE:</label></td>
												</tr>
												<tr>
													<td>
														<select name="Category" class="form-control" required>
															<option value="">--Category--</option>
															<option value="Principal">Principal</option>
															<option value="Staff">Staff</option>
															<option value="Supervisor">Supervisor</option>
															<option value="Teacher">Teacher</option>

														</select>
													</td>
													<td>
														<select name="office" class="form-control" required>
															<option value="">--Office--</option>
															<?php
															$data = mysqli_query($con, "SELECT * FROM tbl_office") or die("Error School");
															while ($row = mysqli_fetch_array($data)) {
																echo '<option value="' . $row['Office_Name'] . '">' . $row['Office_Name'] . '</option>';
															}
															?>

														</select>
													</td>

												</tr>
												<tr>
													<label>TIN:</label>
													<input type="text" name="TIN" class="form-control" placeholder="Tax Indentification Number" required>

												</tr>
											</table>

										</dl>
									</div>


								</div>
							</div>
						</div>
						<input type="submit" class="btn btn-primary" name="save" value="SUBMIT">
					</div>

					</form>


					<!--End-->
				</div>
			</div>


		</div>
	</div>
</div>
<!--End Supervisor-->
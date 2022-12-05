<?php
$_SESSION['EmpID']=$_GET['id'];
$result=mysqli_query($con,"SELECT * FROM tbl_employee WHERE Emp_ID ='".$_SESSION['EmpID']."' LIMIT 1");
$row=mysqli_fetch_assoc($result);

if ($row['Emp_Month']=="1"){$month='Jan';}elseif ($row['Emp_Month']=="2"){$month='Feb';}elseif ($row['Emp_Month']=="3"){$month='March';}
elseif ($row['Emp_Month']=="4"){$month='April';}elseif ($row['Emp_Month']=="5"){$month='May';}elseif ($row['Emp_Month']=="6"){$month='June';
}elseif ($row['Emp_Month']=="7"){	$month='July';}elseif ($row['Emp_Month']=="8"){$month='Aug';}elseif ($row['Emp_Month']=="9"){$month='Sept';}
elseif ($row['Emp_Month']=="10"){$month='Oct';}elseif ($row['Emp_Month']=="11"){$month='Nov';}elseif ($row['Emp_Month']=="12"){$month='Dec';}

$_SESSION['Last_Name']=$row['Emp_LName'];
$_SESSION['First_Name']=$row['Emp_FName'];
$_SESSION['Middle_Name']=$row['Emp_MName'];
$_SESSION['Birthdate']=$month.' '.$row['Emp_Day'].', '.$row['Emp_Year'];
$_SESSION['Place_of_Birth']=$row['Emp_place_of_birth'];
$_SESSION['Citizen']=$row['Emp_Citizen'];
$_SESSION['Civil_Status']=$row['Emp_CS'];
$_SESSION['Gender']=$row['Emp_Sex'];
$_SESSION['Address']=$row['Emp_Address'];
$_SESSION['Height']=$row['Emp_Height'];
$_SESSION['Weight']=$row['Emp_Weight'];
$_SESSION['Blood']=$row['Emp_Blood_type'];
$_SESSION['Picture']=$row['Picture'];
$_SESSION['Cell_No']=$row['Emp_Cell_No'];
$_SESSION['Month']=$row['Emp_Month'];
$_SESSION['Day']=$row['Emp_Day'];
$_SESSION['Year']=$row['Emp_Year'];

?>

<style>
th{
	text-align:center;
}
</style>

<script>
	var loadFile = function(event) {
    var output = document.getElementById('pic');
    output.src = URL.createObjectURL(event.target.files[0]);
	};
	</script>
	
	<div class="row">
                <div class="col-lg-12">
                    <h3></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>			 
                
                    <div class="panel panel-default">
					      <h1>PERSONAL DATA SHEET</h1>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active">
									<a href="#home" data-toggle="tab">Personal Information</a>
                                </li>
                                <li>
									<a href="#family-background" data-toggle="tab">Family Background</a>
                                </li>
                                <li>
									<a href="#education-background" data-toggle="tab">Educational Background</a>
                                </li>
                                <li>
									<a href="#eligibility-background" data-toggle="tab">Civil Service Eligibility</a>
                                </li>
								 <li>
									<a href="#experience-background" data-toggle="tab">Work Experience</a>
                                </li>
								 <li>
									<a href="#voluntary-background" data-toggle="tab">Voluntary Work</a>
                                </li>
								 <li>
									<a href="#learning-background" data-toggle="tab">Learning and Development</a>
                                </li>
								 <li>
									<a href="#others-background" data-toggle="tab">Other Information</a>
                                </li>
								 <li>
									<a href="#questioners-background" data-toggle="tab">Questionairs</a>
                                </li>
								 <li>
									<a href="#reference-background" data-toggle="tab">References</a>
                                </li>
								
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="home">
								<h4>I. Personal Information</h4>
                                  <?php
									echo '<table>
											<tr>
											<th rowspan="6">';
											if ($row['Picture']=="")
											{
												echo '<img src="../../pcdmis/images/user.png" width="200" height="250"   style="padding:4px;margin:4px;border-radius:10px;" id="pic" align="left">';
											}else{
												echo '<img src="../../pcdmis/images/'.$_SESSION['Picture'].'" width="200" height="250"   style="padding:4px;margin:4px;border-radius:10px;" id="pic" align="left">';
												
											}
											echo'</th>
										</tr>
										
										
										<tr><th style="text-align:left;">NAME: '.utf8_encode($_SESSION['Last_Name'].', '.$_SESSION['First_Name'].' '.$_SESSION['Middle_Name']).'</th></tr>
										<tr><th style="text-align:left;">BIRTHDATE: '.$_SESSION['Birthdate'].'</th></tr>
										<tr><th  style="text-align:left;">CIVIL STATUS: '.$_SESSION['Civil_Status'].'</th></tr>
										<tr><th  style="text-align:left;">SEX: '.$_SESSION['Gender'].'</th></tr>
										<tr><th  style="text-align:left;">CONTACT NO: '.$_SESSION['Cell_No'].'</th></tr>	
										
										
								</table>';
								?>
										  
																							
								
								
								
								
								
								
								 <?php
								 echo '<table>
									<tr><td width="15%" style="padding:4px;">SURNAME</td>
									<td style="border:doted black;">'.$_SESSION['Last_Name'].'</td>
									<td style="padding:4px;">FIRST NAME</td>
									<td>'.$_SESSION['First_Name'].'</td>
									<td style="padding:4px;">MIDDLE NAME</td>
									<td>'.$_SESSION['Middle_Name'].'</td></tr>
									<tr><td width="15%" style="padding:4px;">DATE OF BIRTH<br/>(mm/dd/yyyy)</td>
										<td>'.$_SESSION['Birthdate'].'</td>
										<td style="padding:4px;">CITIZENSHIP</td>
									<td>'.$_SESSION['Citizen'].'</td>
									<td style="padding:4px;">CIVIL STATUS:</td>
									<td>'.$_SESSION['Civil_Status'].'</td>
									</tr>
									<tr><td style="padding:4px;">PLACE OF BIRTH:</td>
									<td>'.$_SESSION['Place_of_Birth'].'</td>
									<td style="padding:4px;">HEIGHT (m):</td>
									<td style="padding:4px;">'.$_SESSION['Height'].'</td>
									<td style="padding:4px;">SEX:</td>
									<td style="padding:4px;">'.$_SESSION['Gender'].'</td>
									</tr>
									<tr><td style="padding:4px;">RESIDENTIAL ADDRESS:</td>
									<td colspan="1">'.$_SESSION['Address'].'</td>
									<td style="padding:4px;">WEIGHT (kg):</td>
									<td style="padding:4px;">'.$_SESSION['Weight'].'</td>
									<td style="padding:4px;">BLOOD TYPE:</td>
									<td style="padding:4px;">'.$_SESSION['Blood'].'</td>
									</tr>
								</table>';
								 ?>
							</div>
						
	
														
							
							
							
							
							
                                <div class="tab-pane fade" id="family-background">
								
                                    <h4>II. Family Background</h4>
									<div style="overflow-x:auto;width:100%;">
										 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
										<tr>
											<th width="20%">Family Name</th>
											<th width="20%">First Name</th>
											<th width="20%">Middle Name</th>
											<th width="10%">Birthdate</th>
											<th width="10%">Relation</th>
											
											
										</tr>
										
										</thead>
										<tbody>
										<?php
										$result1=mysqli_query($con,"SELECT * FROM family_background WHERE Emp_ID='".$_SESSION['EmpID']."'");
											while($row1=mysqli_fetch_array($result1))
											{
											echo '<tr><td style="text-align:center;">'.$row1['Family_Name'].'</td>
													  <td style="text-align:center;">'.$row1['First_Name'].'</td>
													  <td style="text-align:center;">'.$row1['Middle_Name'].'</td>
													  <td style="text-align:center;">'.$row1['Birthdate'].'</td>
													  <td style="text-align:center;">'.$row1['Relation'].'</td>
														
												  </tr>';	
											}
				
										?>
									</tbody>
								</table>		
									</div>
								</div>
								
								
								
								
								
								
								
                                <div class="tab-pane fade" id="education-background">
							
                                    <h4>III. Educational Background</h4>
									<div style="overflow-x:auto;width:100%;">
                                  <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
										<tr>
											<th width="10%" rowspan="2">Level</th>
											<th width="20%" rowspan="2">Name of School <br/> (Write in Full)</th>
											<th width="20%" rowspan="2">Basic Education / Degree / Course <br/> (Write in Full)</th>
											<th width="15%" colspan="2">Period of Attendance</th>
											<th width="10%" rowspan="2">Highest Level / Units Earned <br/> (If not Graduated)</th>
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
										$result2=mysqli_query($con,"SELECT * FROM educational_background WHERE Emp_ID='".$_SESSION['EmpID']."'");
											while($row2=mysqli_fetch_array($result2))
											{
											echo '<tr><td style="text-align:center;">'.$row2['Level'].'</td>
													  <td style="text-align:center;">'.$row2['Name_of_School'].'</td>
													  <td style="text-align:center;">'.$row2['Course'].'</td>
													  <td style="text-align:center;">'.$row2['From'].'</td>
													  <td style="text-align:center;">'.$row2['To'].'</td>
													  <td style="text-align:center;">'.$row2['Highest_Level'].'</td>
													  <td style="text-align:center;">'.$row2['Year_Graduated'].'</td>
													  <td style="text-align:center;">'.$row2['Honor_Recieved'].'</td>
													  
													  
												  </tr>';	
											}
										?>
										
									</tbody>
								</table>		
								</div></div>
                                <div class="tab-pane fade" id="eligibility-background">
								
                                   <h4>IV. Civil Service Eligibility </h4>
								   <div style="overflow-x:auto;width:100%;">
                                  <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
										<tr>
											<th width="25%" rowspan="2">Career Services / RA 1080 (BOARD / BAR) Underspecial Laws / CES / CSEE Barangay Eligibility/ Drivers License</th>
											<th width="15%" rowspan="2">Rating (if Applicable)</th>
											<th width="15%" rowspan="2">Date of Examinition Conferment</th>
											<th width="15%" rowspan="2">Place of Examinition / Conferment</th>
											<th width="20%" colspan="2">License(if Applicable)</th>
											
										</tr>
										<tr>
											<th>Number</th>
											<th>Date of Validity</th>
										</tr>
										</thead>
										<tbody>
										<?php
										$result3=mysqli_query($con,"SELECT * FROM civil_service WHERE Emp_ID='".$_SESSION['EmpID']."'");
											while($row3=mysqli_fetch_array($result3))
											{
											echo '<tr>
												<td style="text-align:center;">'.$row3['Carrer_Service'].'</td>
												<td style="text-align:center;">'.$row3['Rating'].'</td>
												<td style="text-align:center;">'.$row3['Date_of_Examination'].'</td>
												<td style="text-align:center;">'.$row3['Place_of_Examination'].'</td>
												<td style="text-align:center;">'.$row3['Number_of_Hour'].'</td>
												<td style="text-align:center;">'.$row3['Date_of_Validity'].'</td>
											
												
											
											</tr>';
											}
										?>
										
									</tbody>
								</table>		
							   </div>
								</div>
								<div class="tab-pane fade" id="experience-background">
								
                                   
                                   <h4>V. Work Experience (include private employee start from your recent work) description of duties should be indicated in then attached Work Experience sheet</h4>
                                 <div style="overflow-x:auto;">
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
										$result4=mysqli_query($con,"SELECT * FROM work_experience WHERE Emp_ID='".$_SESSION['EmpID']."' ORDER BY work_experience.From Desc");
											while($row4=mysqli_fetch_array($result4))
											{
											echo '<tr>
												<td style="text-align:center;">'.$row4['From'].'</td>
												<td style="text-align:center;">'.$row4['To'].'</td>
												<td style="text-align:center;">'.$row4['Position_Title'].'</td>
												<td style="text-align:center;">'.$row4['Organization'].'</td>
												<td style="text-align:center;">'.$row4['Monthly_Salary'].'</td>
												<td style="text-align:center;">'.$row4['Salary_Grade'].'</td>
												<td style="text-align:center;">'.$row4['Job_Status'].'</td>
												<td style="text-align:center;">'.$row4['Goverment'].'</td>
												
											
											
												</tr>';	
											}
										?>
									</tbody>
								</table>		
							   </div>
							   </div>
							   
								<div class="tab-pane fade" id="voluntary-background">
								
                                     <h4>VI.  Voluntary Work or Involvement in Civic / Non-Government / People / Voluntary Organization</h4>
                                  <div style="overflow-x:auto;">
								  <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
										<tr>
											<th width="30%" rowspan="2">Name & address of organization <br/>(write in full)</th>
											<th width="10%" colspan="2">Inclusive Dates <br/>(mm/dd/yyyy)</th>
											<th width="10%" rowspan="2">Number of hours</th>
											<th width="30%" rowspan="2">Position / Nature of work</th>
											
										</tr>
										<tr>
											<th>From</th>
											<th>To</th>
										</tr>
										</thead>
										<tbody>
										<?php
										$result5=mysqli_query($con,"SELECT * FROM voluntary_work WHERE Emp_ID='".$_SESSION['EmpID']."'");
											while ($row5=mysqli_fetch_array($result5))
											{
											echo '<tr>
													<td style="text-align:center;">'.$row5['Name_of_Organization'].'</td>
													<td style="text-align:center;">'.$row5['From'].'</td>
													<td style="text-align:center;">'.$row5['To'].'</td>
													<td style="text-align:center;">'.$row5['Number_of_Hour'].'</td>
													<td style="text-align:center;">'.$row5['Position'].'</td>
													 

												 </tr>';
											}
										?>
									</tbody>
								</table>		
							   </div>
							   </div>
							   
								<div class="tab-pane fade" id="learning-background">
									
                                    <h4>VII. Learning and Development (L&D)Interventions/ Training programs attended</h4>
                                   <div style="overflow-x:auto;width:100%;">
								   <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
										<tr>
											<th width="30%" rowspan="2">Title Learning and Development Interventions / Training programs <br/>(write in full)</th>
											<th width="10%" colspan="2">Inclusive Dates <br/>(mm/dd/yyyy)</th>
											<th width="10%" rowspan="2">Number of hours</th>
											<th width="25%" rowspan="2">Type of LD (Managerial / Supervisor / Technical / etc)</th>
											<th width="25%" rowspan="2">Conducted / Sponsored by<br/>(Write in Full) </th>
											
										</tr>
										<tr>
											<th>From</th>
											<th>To</th>
										</tr>
										</thead>
										<tbody>
										<?php
										$result6=mysqli_query($con,"SELECT * FROM learning_and_development WHERE Emp_ID='".$_SESSION['EmpID']."'");
											while ($row6=mysqli_fetch_array($result6))
											{
												echo	'<tr>
															<td style="text-align:center;">'.$row6['Title_of_Training'].'</td>
															<td style="text-align:center;">'.$row6['From'].'</td>
															<td style="text-align:center;">'.$row6['To'].'</td>
															<td style="text-align:center;">'.$row6['Number_of_Hours'].'</td>
															<td style="text-align:center;">'.$row6['Managerial'].'</td>
															<td style="text-align:center;">'.$row6['Conducted'].'</td>

														

														
														</tr>';
											}	
										
										?>
									</tbody>
								</table>		
								</div>
								</div>
								
								
								<div class="tab-pane fade" id="others-background">
									
                                    <h4>VIII.  OTHER INFORMATION</h4>
                                   <div style="overflow-x:auto;width:100%;">
								   <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
										<tr>
											<th width="30%">SPECIAL SKILLS and HOBBIES</th>
											<th width="30%">NON-ACADEMIC DISTINCTIONS / RECOGNITION <br/> (Write in full)</th>
											<th width="30%">MEMBERSHIP IN ASSOCIATION/ORGANIZATION   <br/>(Write in full)</th>
											
											
										</tr>
										
										</thead>
										<tbody>
										<?php
										$result7=mysqli_query($con,"SELECT * FROM other_information WHERE other_information.Emp_ID='".$_SESSION['EmpID']."'");
											while ($row7=mysqli_fetch_array($result7))
											{
												echo	'<tr>
															<td style="text-align:center;">'.$row7['Special_Skills'].'</td>
															<td style="text-align:center;">'.$row7['Recognation'].'</td>
															<td style="text-align:center;">'.$row7['Organization'].'</td>
															
															
														</tr>';
											}	
										
										?>
									</tbody>
								</table>		
								</div>
								</div>
								
								
								<div class="tab-pane fade" id="questioners-background">
								 
								<h4>Questionairs</h4>
								<div style="overflow-x:auto;width:100%;">
								   <table width="100%" class="table table-striped table-bordered table-hover" >
						<tr>
						<td>
							<p> <b style="padding:8px;">36.</b> Are you related by sanguinity or affinity to any of the following: <br/><br/>
							a. Within the third degree (by National Government Employees): 
							appointing authority, recommending authority, chief of office/bureau/department of person who has immediate supervision over you in the Office, Bureau or Department where you will be appointed?<br/><br/><br/><br/><br/>
							b. Within the fourth degree (for Local Government Employees): appointing authority or recommending authority where you will be appointed?</p>
						</td>
						<td width="20%" >
							<br/><br/>
							<?php
							$myone=mysqli_query($con,"SELECT * FROM tbl_questioner WHERE Question='one' AND Emp_ID='".$_SESSION['EmpID']."'LIMIT 1");
							$rone=mysqli_fetch_assoc($myone);
					    if ($rone['Answer']=='Yes')
						{
							echo '<input type="radio" name="one" value="Yes" checked required><label style="padding:10px;">YES</label>
							<input type="radio" name="one"  value="No"  required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="one_details" value="'.$rone['Details'].'" class="form-control"></label>';
						
						}elseif ($rone['Answer']=='No')
						{
							echo '<input type="radio" name="one" value="Yes"  required><label style="padding:10px;">YES</label>
							<input type="radio" name="one"  value="No"  checked required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="one_details" class="form-control"></label>';
						}else{
							echo '<input type="radio" name="one" value="Yes"  required><label style="padding:10px;">YES</label>
							<input type="radio" name="one"  value="No"   required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="one_details" class="form-control"></label>';
						}	
							echo '<hr/>';
							$mytwo=mysqli_query($con,"SELECT * FROM tbl_questioner WHERE Question='two' AND Emp_ID='".$_SESSION['EmpID']."'limit 1");
							$rtwo=mysqli_fetch_assoc($mytwo);
							if ($rtwo['Answer']=='Yes')
							{
						echo '<input type="radio" name="two" value="Yes" checked required><label style="padding:10px;">YES</label>
							<input type="radio" name="two" value="No" required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="two_details" value="'.$rtwo['Details'].'" class="form-control"></label>';
							}elseif($rtwo['Answer']=='No')
							{
							echo '<input type="radio" name="two" value="Yes"  required><label style="padding:10px;">YES</label>
							<input type="radio" name="two" value="No" checked required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="two_details" class="form-control"></label>';
							
							}else{
								echo '<input type="radio" name="two" value="Yes"  required><label style="padding:10px;">YES</label>
							<input type="radio" name="two" value="No"  required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="two_details" class="form-control"></label>';
							
							}
							?>
						</td>
						
					</tr>
					
					<tr>
						<td>
							<p> <b style="padding:8px;">37. </b> a. Have you been formally charged?</p><br/><br/><br/><br/><hr/>
								 <p style="padding:8px;">b. Have you been guilty of any administrative offense?</p>
						</td>
						<td width="20%">
							<?php
							$mythree=mysqli_query($con,"SELECT * FROM tbl_questioner WHERE Question='three' AND Emp_ID='".$_SESSION['EmpID']."'limit 1");
							$rthree=mysqli_fetch_assoc($mythree);
							if ($rthree['Answer']=='Yes')
							{
						echo '<input type="radio" name="three" value="Yes" checked required><label style="padding:10px;">YES</label>
							<input type="radio" name="three" value="No" required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="three_details" value="'.$rthree['Details'].'" class="form-control"></label>';
							}elseif($rthree['Answer']=='No')
							{
							echo '<input type="radio" name="three" value="Yes" required><label style="padding:10px;">YES</label>
							<input type="radio" name="three" value="No" checked required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="three_details" class="form-control"></label>';	
							}else{
								echo '<input type="radio" name="three" value="Yes" required><label style="padding:10px;">YES</label>
							<input type="radio" name="three" value="No"  required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="three_details" class="form-control"></label>';	
							
								
							}
							echo '<hr>';
							
							$myfour=mysqli_query($con,"SELECT * FROM tbl_questioner WHERE Question='four' AND Emp_ID='".$_SESSION['EmpID']."'limit 1");
							$rfour=mysqli_fetch_assoc($myfour);
							if ($rfour['Answer']=='Yes')
							{
							echo '<input type="radio" name="four" value="Yes" checked required><label style="padding:10px;">YES</label>
							<input type="radio" name="four" value="No" required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="four_details" value="'.$rfour['Details'].'" class="form-control"></label>';
							}elseif ($rfour['Answer']=='No')
							{
							echo '<input type="radio" name="four" value="Yes"  required><label style="padding:10px;">YES</label>
							<input type="radio" name="four" value="No" checked required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="four_details" class="form-control"></label>';
							}else{
								echo '<input type="radio" name="four" value="Yes"  required><label style="padding:10px;">YES</label>
							<input type="radio" name="four" value="No"  required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="four_details" class="form-control"></label>';
							
							}
							?>
							</td>
						
					</tr>
					<tr>
						<td>
							38. Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?
						</td>
						<th width="20%">
						<?php
							$myfive=mysqli_query($con,"SELECT * FROM tbl_questioner WHERE Question='five' AND Emp_ID='".$_SESSION['EmpID']."'limit 1");
							$rfive=mysqli_fetch_assoc($myfive);
							if ($rfive['Answer']=='Yes')
							{
							echo '<input type="radio" name="five" value="Yes" checked required><label style="padding:10px;">YES</label>
							<input type="radio" name="five" value="No" required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="five_details" value="'.$rfive['Details'].'" class="form-control"></label>';
							}elseif ($rfive['Answer']=='No')
							{
							echo '<input type="radio" name="five" value="Yes" required><label style="padding:10px;">YES</label>
							<input type="radio" name="five" value="No" checked required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="five_details" class="form-control"></label>';
							}else{
								echo '<input type="radio" name="five" value="Yes" required><label style="padding:10px;">YES</label>
							<input type="radio" name="five" value="No"  required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="five_details" class="form-control"></label>';
							
							}
							?>
							
							
							
						</th>
						
					</tr>
					<tr>
						<td>
							39. Have you ever been separated from the service in any of the following modes: resignation retirement, dropped from the rolls, dismissal, termination, end of term, finished contract, AWOL or phased out, in the public or private sector? <br/><br/><br/>
							
						</td>
						<td width="20%">
							<br/><br/>
							<?php
							$mysix=mysqli_query($con,"SELECT * FROM tbl_questioner WHERE Question='six' AND Emp_ID='".$_SESSION['EmpID']."'limit 1");
							$rsix=mysqli_fetch_assoc($mysix);
							if ($rsix['Answer']=='Yes')
							{
							echo '<input type="radio" name="six" value="Yes" checked required><label style="padding:10px;">YES</label>
							<input type="radio" name="six" value="No" required ><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="six_details" value="'.$rsix['Details'].'" class="form-control"></label>';
							}elseif ($rsix['Answer']=='No')
							{
							echo '<input type="radio" name="six" value="Yes"  required><label style="padding:10px;">YES</label>
							<input type="radio" name="six" value="No" checked required ><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="six_details" class="form-control"></label>';
							}else{
								echo '<input type="radio" name="six" value="Yes"  required><label style="padding:10px;">YES</label>
							<input type="radio" name="six" value="No"  required ><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="six_details" class="form-control"></label>';
							
							}
							
							?>
						</td>
						
					</tr>
					
					
					
					
					
					<tr>
						<td>
							40. Have you ever been a candidate in a national or local election (except Barangay election)? <br/><br/><br/>
							
						</td>
						<td width="20%">
							<br/><br/>
							
							<?php
							$myeight=mysqli_query($con,"SELECT * FROM tbl_questioner WHERE Question='seven' AND Emp_ID='".$_SESSION['EmpID']."'limit 1");
							$reight=mysqli_fetch_assoc($myeight);
							if ($reight['Answer']=='Yes')
							{
							echo '<input type="radio" name="seven" value="Yes" checked required><label style="padding:10px;">YES</label>
							<input type="radio" name="seven" value="No" required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="seven_details" value="'.$reight['Details'].'"class="form-control"></label>';
							}elseif ($reight['Answer']=='No')
							{
							echo '<input type="radio" name="seven" value="Yes"  required><label style="padding:10px;">YES</label>
							<input type="radio" name="seven" value="No" checked required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="seven_details" class="form-control"></label>';
							}else{
								echo '<input type="radio" name="seven" value="Yes"  required><label style="padding:10px;">YES</label>
							<input type="radio" name="seven" value="No"  required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="seven_details" class="form-control"></label>';
						
							}
							
							
							?>
						</td>
						
					</tr>
					<tr>
						<td>
							41. Pursuant to (a) indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); and © Solo Parents Welfare Act of 2000 (RA 8972); please answer the following items: <br/><br/><br/>
							a. Are you a member of any indigenous group?<br/><br/><br/>
							b. Are you differently abled?<br/><br/><br/>
							c. Are you a solo parent?<br/><br/><br/>
						</th>
						<td width="20%">
							<?php
							$myten=mysqli_query($con,"SELECT * FROM tbl_questioner WHERE Question='eight' AND Emp_ID='".$_SESSION['EmpID']."'limit 1");
							$rten=mysqli_fetch_assoc($myten);
							if ($rten['Answer']=='Yes')
							{
							echo '<input type="radio" name="eight" value="Yes" checked required><label style="padding:10px;">YES</label>
							<input type="radio" name="eight" value="No" required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name=" eight_details" value="'.$rten['Details'].'" class="form-control"></label>';
							}elseif ($rten['Answer']=='No')
							{
							echo '<input type="radio" name="eight" value="Yes" required><label style="padding:10px;">YES</label>
							<input type="radio" name="eight" value="No" checked required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name=" eight_details" class="form-control"></label>';
							}else{
								echo '<input type="radio" name="eight" value="Yes" required><label style="padding:10px;">YES</label>
							<input type="radio" name="eight" value="No"  required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="eight_details" class="form-control"></label>';
							
							}
							
							
							echo '<br/></hr/>';
							
							$myeleven=mysqli_query($con,"SELECT * FROM tbl_questioner WHERE Question='nine' AND Emp_ID='".$_SESSION['EmpID']."'limit 1");
							$releven=mysqli_fetch_assoc($myeleven);
							if ($releven['Answer']=='Yes')
							{
							echo '<input type="radio" name="nine" value="Yes" checked required><label style="padding:10px;">YES</label>
							<input type="radio" name="nine" value="No" required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="nine_details" value="'.$releven['Details'].'" class="form-control"></label>';
							}elseif ($releven['Answer']=='No')
							{
							echo '<input type="radio" name="nine" value="Yes" required><label style="padding:10px;">YES</label>
							<input type="radio" name="nine" value="No" checked required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="nine_details" class="form-control"></label>';
							}else{
								echo '<input type="radio" name="nine" value="Yes" required><label style="padding:10px;">YES</label>
							<input type="radio" name="nine" value="No"  required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="nine_details" class="form-control"></label>';
							
							}
							echo '<br/></hr/>';
							
							$mytweve=mysqli_query($con,"SELECT * FROM tbl_questioner WHERE Question='ten' AND Emp_ID='".$_SESSION['EmpID']."'limit 1");
							$rtweve=mysqli_fetch_assoc($mytweve);
							if ($rtweve['Answer']=='Yes')
							{
							echo '<input type="radio" name="ten" value="Yes" checked required><label style="padding:10px;">YES</label>
							<input type="radio" name="ten"  value="No"  required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="ten_details" value="'.$rtweve['Details'].'" class="form-control"></label>';
							}elseif ($rtweve['Answer']=='No')
							{
							echo '<input type="radio" name="ten" value="Yes" required><label style="padding:10px;">YES</label>
							<input type="radio" name="ten"  value="No" checked required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="ten_details" class="form-control"></label>';
							}else{
								echo '<input type="radio" name="ten" value="Yes" required><label style="padding:10px;">YES</label>
							<input type="radio" name="ten"  value="No"  required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="ten_details" class="form-control"></label>';
							
							}
							?>
						</td>
						
					</tr>
					
									</table>
								 
								</div>
								
								</div>
								
								<div class="tab-pane fade" id="reference-background">
                                  
                                    <h4>
                                     42. References (Person not related by consanguinity or afinity to applicant / appointee) </h4> 
											<div style="overflow-x:auto;width:100%;">	
										<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
										<tr>
											<th width="30%">Name</th>
											<th width="30%">Address</th>
											<th width="10%">Contact Number</th>
											
										</tr>
										
										</thead>
										<tbody>
										<?php
										$result8=mysqli_query($con,"SELECT * FROM reference WHERE Emp_ID='".$_SESSION['EmpID']."'");
											while ($row8=mysqli_fetch_array($result8))
											{
											echo '<tr>
													<td style="text-align:center;">'.$row8['Name'].'</td>
													<td style="text-align:center;">'.$row8['Address'].'</td>
													<td style="text-align:center;">'.$row8['Tel_No'].'</td>
													
														
													</tr>';
											}
										?>
									</tbody>
								</table>		
											</div>
							   </div>
							   
							   
							   
							 
							   
							   
							   
							
			 
							   
							   
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                  

 <?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
foreach ($_GET as $key => $data)
{
$url=$_GET[$key]=base64_decode(urldecode($data));
	
}
 $getres=mysqli_query($con,"SELECT * FROM tbl_ssg_schedule  INNER JOIN tbl_school_year ON tbl_ssg_schedule.SSGBatch=tbl_school_year.SYCode INNER JOIN tbl_employee ON tbl_ssg_schedule.SSGAdviser = tbl_employee.Emp_ID WHERE tbl_ssg_schedule.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_schedule.SSGBatch='".$url."' LIMIT 1");
$rowre=mysqli_fetch_assoc($getres);
$middle=mb_strimwidth($rowre['Emp_MName'],0,1);
$_SESSION['currentAdviser']=$rowre['Emp_FName'].' '.$middle.'. '.$rowre['Emp_LName'];
$_SESSION['currentYS']=$url;
$sy=$url+1;
?>
     <div class="modal-header">
						<h3 class="modal-title"><center>LIST OF CANDIDATES FOR SCHOOL YEAR <br/><?php echo $url .'-'.$sy; ?></center></h3>
					</div>
				<div class="modal-body">
				<?php
				if ($_GET['status']<>'DONE')
				{
				  echo '<div id="candidate"></div>';	
				}else{
		      echo '<table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>Candidate Name</th>
										 <th width="15%">Grade Level</th>
                                        <th width="35%">Position</th>
                                      </tr>
                                </thead>
                                <tbody>';
								
								$no=0;
								  $result1=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$url."' AND tbl_ssg_officer.Position='PRESIDENT' AND tbl_ssg_officer.Status='WIN'");
								  while($rowdata1=mysqli_fetch_array($result1))
								  {
									  $no++;
									  echo '<tr>
											<td>'.$no.'</td>
											<td>'.$rowdata1['Lname'].', '.$rowdata1['FName'].'</td>
											<td> Grade '.$rowdata1['GradeLevel'].'</td>
											<td>'.$rowdata1['Position'].'</td>
											
										</tr>';
								  }
								
								
								  $result2=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$url."' AND tbl_ssg_officer.Position='VICE PRESIDENT' AND tbl_ssg_officer.Status='WIN'");
								  while($rowdata2=mysqli_fetch_array($result2))
								  {
									  $no++;
									  echo '<tr>
											<td>'.$no.'</td>
											<td>'.$rowdata2['Lname'].', '.$rowdata2['FName'].'</td>
											<td> Grade '.$rowdata2['GradeLevel'].'</td>
											<td>'.$rowdata2['Position'].'</td>
											
										</tr>';
								  }
								
								  $result3=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$url."' AND tbl_ssg_officer.Position='SECRETARY' AND tbl_ssg_officer.Status='WIN'");
								  while($rowdata3=mysqli_fetch_array($result3))
								  {
									  $no++;
									  echo '<tr>
											<td>'.$no.'</td>
											<td>'.$rowdata3['Lname'].', '.$rowdata3['FName'].'</td>
											<td> Grade '.$rowdata3['GradeLevel'].'</td>
											<td>'.$rowdata3['Position'].'</td>
											
										</tr>';
								  }
								
								
								  $result4=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$url."' AND tbl_ssg_officer.Position='TREASURER' AND tbl_ssg_officer.Status='WIN'");
								  while($rowdata4=mysqli_fetch_array($result4))
								  {
									  $no++;
									  echo '<tr>
											<td>'.$no.'</td>
											<td>'.$rowdata4['Lname'].', '.$rowdata4['FName'].'</td>
											<td> Grade '.$rowdata4['GradeLevel'].'</td>
											<td>'.$rowdata4['Position'].'</td>
											
										</tr>';
								  }
								
								
								  $result5=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$url."' AND tbl_ssg_officer.Position='AUDITOR' AND tbl_ssg_officer.Status='WIN'");
								  while($rowdata5=mysqli_fetch_array($result5))
								  {
									  $no++;
									  echo '<tr>
											<td>'.$no.'</td>
											<td>'.$rowdata5['Lname'].', '.$rowdata5['FName'].'</td>
											<td> Grade '.$rowdata5['GradeLevel'].'</td>
											<td>'.$rowdata5['Position'].'</td>
											
										</tr>';
								  }
								
								
								  $result6=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$url."' AND tbl_ssg_officer.Position='PIO' AND tbl_ssg_officer.Status='WIN'");
								  while($rowdata6=mysqli_fetch_array($result6))
								  {
									  $no++;
									  echo '<tr>
											<td>'.$no.'</td>
											<td>'.$rowdata6['Lname'].', '.$rowdata6['FName'].'</td>
											<td> Grade '.$rowdata6['GradeLevel'].'</td>
											<td>'.$rowdata6['Position'].'</td>
											
										</tr>';
								  }
								
								
								  $result7=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$url."' AND tbl_ssg_officer.Position='BUSINESS MANAGER' AND tbl_ssg_officer.Status='WIN'");
								  while($rowdata7=mysqli_fetch_array($result7))
								  {
									  $no++;
									  echo '<tr>
											<td>'.$no.'</td>
											<td>'.$rowdata7['Lname'].', '.$rowdata7['FName'].'</td>
											<td>Grade '.$rowdata7['GradeLevel'].'</td>
											<td>'.$rowdata7['Position'].'</td>
											
										</tr>';
								  }
								
								
								  $result8=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$url."' AND tbl_ssg_officer.Position='PEACE OFFICER' AND tbl_ssg_officer.Status='WIN'");
								  while($rowdata8=mysqli_fetch_array($result8))
								  {
									  $no++;
									  echo '<tr>
											<td>'.$no.'</td>
											<td>'.$rowdata8['Lname'].', '.$rowdata8['FName'].'</td>
											<td>Grade '.$rowdata8['GradeLevel'].'</td>
											<td>'.$rowdata8['Position'].'</td>
											
										</tr>';
								  }
								
								
								  $result9=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$url."' AND tbl_ssg_officer.Position='REPRESENTATIVE' AND tbl_ssg_officer.Status='WIN'");
								  while($rowdata9=mysqli_fetch_array($result9))
								  {
									  $no++;
									  echo '<tr>
											<td>'.$no.'</td>
											<td>'.$rowdata9['Lname'].', '.$rowdata9['FName'].'</td>
											<td>Grade '.$rowdata9['GradeLevel'].'</td>
											<td>'.$rowdata9['Position'].'</td>
											
										</tr>';
								  }
								
								echo '</tbody>
								</table>';
					}
								?>
				</div>
				<div class="modal-footer">
				<?php
				if ($_GET['status']=='Close')
				{
					echo '<a href="" class="btn btn-info" target="_blank">SSG Election is currently '.$_GET['status'].'</a>';
				}elseif ($_GET['status']=='Open')
				{
					echo '<a href="" class="btn btn-info" target="_blank">SSG Election is currently  '.$_GET['status'].'</a>';
				}else{
					echo '<a href="print_lis_of_candidates.php" class="btn btn-primary" target="_blank">Print Preview</a>';
				}
				?>	
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
				</div> </form>
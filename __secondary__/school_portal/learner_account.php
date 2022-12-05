			<style>
		th,td	{text-transform:uppercase;}
			</style>
			
			<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                  <thead>
                       <tr>
                            <th width="5%">#</th>
                                <th width="15%">Last Name</th>
                                    <th width="14%">First Name</th>
                                        <th width="14%">Middle Name</th>
                                      <th width="15%">Username</th>
                                <th width="5%"></th>
                                      
                        </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
								$password="";
								$result=mysqli_query($con,"SELECT * FROM tbl_student_user INNER JOIN tbl_student ON tbl_student_user.lrn =tbl_student.lrn INNER JOIN tbl_registration ON tbl_student_user.lrn = tbl_registration.lrn WHERE tbl_student_user.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' ORDER BY tbl_student.Lname Asc");
								while ($row=mysqli_fetch_array($result))
								{
									$no++;
									$password=mb_strimwidth($row['lrn'],6,6);
									echo '<tr>
										<td>'.$no.'</td>
											<td>'.$row['Lname'].'</td>
											  <td>'.$row['FName'].'</td>
												<td>'.$row['MName'].'</td>
											   <td>'.$row['username'].'</td>
											<td><a href="reset_learner.php?username='.$row['Lname'].'&password='.$_SESSION['school_id'].'">Reset</a></td>
												  
									</tr>';
								}
								?>
								
								</tbody>
								</table>
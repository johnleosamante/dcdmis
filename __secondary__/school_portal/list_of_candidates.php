<?php
session_start();
include_once("../../pcdmis/vendor/jquery/function.php");
?>
	 <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>Candidate Name</th>
                                        <th width="20%">Position</th>
                                        <th width="20%">Party</th>
                                        <th width="14%">Score</th>
                                        <th width="10%">Rank</th>
                                                                               
                                    </tr>
                                </thead>
                                <tbody>
								 <th colspan="6" style="text-align:center;">LIST OF PRESIDENT</th>
								<?php
								 $no=$rank=$rows = 0;
								 $last_score = false;
								  $result=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$_SESSION['year']."' AND tbl_ssg_officer.Position='PRESIDENT' ORDER BY tbl_ssg_officer.Score Desc");
								  while($rowdata=mysqli_fetch_array($result))
								  {
									  $no++;
																	
									  echo '<tr>
											<td>'.$no.'</td>
											<td>'.$rowdata['Lname'].', '.$rowdata['FName'].'</td>
											<td>'.$rowdata['Position'].'</td>
											<td>'.$rowdata['Party'].'</td>
											<td style="text-align:center;">'.$rowdata['Score'].'</td>';
											 $rows++;
											if( $last_score!= $rowdata['Score'] ){
											  $last_score = $rowdata['Score'];
											  $rank = $rows;
											}
											echo '<td style="text-align:center;">'.$rank.'</td>
										</tr>';
								  }
								?>
								 <tr> <th colspan="6" style="text-align:center;">LIST OF VICE PRESIDENT</th></tr>
								 <?php
								 $no=$rank=$rows = 0;
								 $last_score = false;
								  $result=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$_SESSION['year']."' AND tbl_ssg_officer.Position='VICE PRESIDENT' ORDER BY tbl_ssg_officer.Score Desc");
								  while($rowdata=mysqli_fetch_array($result))
								  {
									  $no++;
									  echo '<tr>
											<td>'.$no.'</td>
											<td>'.$rowdata['Lname'].', '.$rowdata['FName'].'</td>
											<td>'.$rowdata['Position'].'</td>
											<td>'.$rowdata['Party'].'</td>
											<td style="text-align:center;">'.$rowdata['Score'].'</td>';
											 $rows++;
											if( $last_score!= $rowdata['Score'] ){
											  $last_score = $rowdata['Score'];
											  $rank = $rows;
											}
											echo '<td style="text-align:center;">'.$rank.'</td>
										</tr>';
								  }
								?>
								  <tr><th colspan="6" style="text-align:center;">LIST OF SECRETARY</th> </tr>
								  <?php
								 $no=$rank=$rows = 0;
								 $last_score = false;
								  $result=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$_SESSION['year']."' AND tbl_ssg_officer.Position='SECRETARY' ORDER BY tbl_ssg_officer.Score Desc");
								  while($rowdata=mysqli_fetch_array($result))
								  {
									  $no++;
									  echo '<tr>
											<td>'.$no.'</td>
											<td>'.$rowdata['Lname'].', '.$rowdata['FName'].'</td>
											<td>'.$rowdata['Position'].'</td>
											<td>'.$rowdata['Party'].'</td>
											<td style="text-align:center;">'.$rowdata['Score'].'</td>';
											 $rows++;
											if( $last_score!= $rowdata['Score'] ){
											  $last_score = $rowdata['Score'];
											  $rank = $rows;
											}
											echo '<td style="text-align:center;">'.$rank.'</td>
										</tr>';
								  }
								?>
								 <tr> <th colspan="6" style="text-align:center;">LIST OF TREASURER</th> </tr>
								  <?php
								 $no=$rank=$rows = 0;
								 $last_score = false;
								  $result=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$_SESSION['year']."' AND tbl_ssg_officer.Position='TREASURER' ORDER BY tbl_ssg_officer.Score Desc");
								  while($rowdata=mysqli_fetch_array($result))
								  {
									  $no++;
									  echo '<tr>
											<td>'.$no.'</td>
											<td>'.$rowdata['Lname'].', '.$rowdata['FName'].'</td>
											<td>'.$rowdata['Position'].'</td>
											<td>'.$rowdata['Party'].'</td>
											<td style="text-align:center;">'.$rowdata['Score'].'</td>';
											 $rows++;
											if( $last_score!= $rowdata['Score'] ){
											  $last_score = $rowdata['Score'];
											  $rank = $rows;
											}
											echo '<td style="text-align:center;">'.$rank.'</td>
										</tr>';
								  }
								?>
								  <tr><th colspan="6" style="text-align:center;">LIST OF AUDITOR</th> </tr>
								  <?php
								 $no=$rank=$rows = 0;
								 $last_score = false;
								  $result=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$_SESSION['year']."' AND tbl_ssg_officer.Position='AUDITOR' ORDER BY tbl_ssg_officer.Score Desc");
								  while($rowdata=mysqli_fetch_array($result))
								  {
									  $no++;
									  echo '<tr>
											<td>'.$no.'</td>
											<td>'.$rowdata['Lname'].', '.$rowdata['FName'].'</td>
											<td>'.$rowdata['Position'].'</td>
											<td>'.$rowdata['Party'].'</td>
											<td style="text-align:center;">'.$rowdata['Score'].'</td>';
											 $rows++;
											if( $last_score!= $rowdata['Score'] ){
											  $last_score = $rowdata['Score'];
											  $rank = $rows;
											}
											echo '<td style="text-align:center;">'.$rank.'</td>
										</tr>';
								  }
								?>
								  <tr><th colspan="6" style="text-align:center;">LIST OF PIO</th> </tr>
								  <?php
								 $no=$rank=$rows = 0;
								 $last_score = false;
								  $result=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$_SESSION['year']."' AND tbl_ssg_officer.Position='PIO' ORDER BY tbl_ssg_officer.Score Desc");
								  while($rowdata=mysqli_fetch_array($result))
								  {
									  $no++;
									  echo '<tr>
											<td>'.$no.'</td>
											<td>'.$rowdata['Lname'].', '.$rowdata['FName'].'</td>
											<td>'.$rowdata['Position'].'</td>
											<td>'.$rowdata['Party'].'</td>
											<td style="text-align:center;">'.$rowdata['Score'].'</td>';
											 $rows++;
											if( $last_score!= $rowdata['Score'] ){
											  $last_score = $rowdata['Score'];
											  $rank = $rows;
											}
											echo '<td style="text-align:center;">'.$rank.'</td>
										</tr>';
								  }
								?>
								 <tr> <th colspan="6" style="text-align:center;">LIST OF BUSINESS MANAGER</th> </tr>
								 <?php
								 $no=$rank=$rows = 0;
								 $last_score = false;
								  $result=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$_SESSION['year']."' AND tbl_ssg_officer.Position='BUSINESS MANAGER' ORDER BY tbl_ssg_officer.Score Desc");
								  while($rowdata=mysqli_fetch_array($result))
								  {
									  $no++;
									  echo '<tr>
											<td>'.$no.'</td>
											<td>'.$rowdata['Lname'].', '.$rowdata['FName'].'</td>
											<td>'.$rowdata['Position'].'</td>
											<td>'.$rowdata['Party'].'</td>
											<td style="text-align:center;">'.$rowdata['Score'].'</td>';
											 $rows++;
											if( $last_score!= $rowdata['Score'] ){
											  $last_score = $rowdata['Score'];
											  $rank = $rows;
											}
											echo '<td style="text-align:center;">'.$rank.'</td>
										</tr>';
								  }
								?>
								 <tr><th colspan="6" style="text-align:center;">LIST OF PEACE OFFICER</th> </tr>
								 <?php
								 $no=$rank=$rows = 0;
								 $last_score = false;
								  $result=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$_SESSION['year']."' AND tbl_ssg_officer.Position='PEACE OFFICER' ORDER BY tbl_ssg_officer.Score Desc");
								  while($rowdata=mysqli_fetch_array($result))
								  {
									  $no++;
									  echo '<tr>
											<td>'.$no.'</td>
											<td>'.$rowdata['Lname'].', '.$rowdata['FName'].'</td>
											<td>'.$rowdata['Position'].'</td>
											<td>'.$rowdata['Party'].'</td>
											<td style="text-align:center;">'.$rowdata['Score'].'</td>';
											 $rows++;
											if( $last_score!= $rowdata['Score'] ){
											  $last_score = $rowdata['Score'];
											  $rank = $rows;
											}
											echo '<td style="text-align:center;">'.$rank.'</td>
										</tr>';
								  }
								?>
								 <tr><th colspan="6" style="text-align:center;">LIST OF REPRESENTATIVE</th> </tr>
								 <?php
								 $no=$rank=$rows = 0;
								 $last_score = false;
								  $result=mysqli_query($con,"SELECT * FROM tbl_ssg_officer  INNER JOIN  tbl_student ON tbl_ssg_officer.lrn = tbl_student.lrn WHERE tbl_ssg_officer.SchoolID='".$_SESSION['school_id']."' AND tbl_ssg_officer.Year='".$_SESSION['year']."' AND tbl_ssg_officer.Position='REPRESENTATIVE' ORDER BY tbl_ssg_officer.Score Desc");
								  while($rowdata=mysqli_fetch_array($result))
								  {
									  $no++;
									  echo '<tr>
											<td>'.$no.'</td>
											<td>'.$rowdata['Lname'].', '.$rowdata['FName'].'</td>
											<td>'.$rowdata['Position'].'</td>
											<td>'.$rowdata['Party'].'</td>
											<td style="text-align:center;">'.$rowdata['Score'].'</td>';
											 $rows++;
											if( $last_score!= $rowdata['Score'] ){
											  $last_score = $rowdata['Score'];
											  $rank = $rows;
											}
											echo '<td style="text-align:center;">'.$rank.'</td>
										</tr>';
								  }
								?>
								</tbody>
								</table>
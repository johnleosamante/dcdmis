<?php
echo '<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th rowspan="2" width="5%">#</th>
									<th rowspan="2">Learning Areas</th>
									<th colspan="2" style="text-align:center;">Quarter</th>
									<th rowspan="2" style="text-align:center;width:15%;">Final Rating</th>
									<th rowspan="2" style="text-align:center;width:15%;">Remarks</th>
									
								</tr>
								<tr>
									<th style="text-align:center;">1</th>
									<th style="text-align:center;">2</th>
									
								
									
								</tr>
							</thead>
							<tbody>';
							$no=0;
							$mysubject=mysqli_query($con,"SELECT * FROM tbl_shs_tor INNER JOIN tbl_senior_sub_strand ON tbl_shs_tor.SubNo = tbl_senior_sub_strand.StrandsubCode INNER JOIN class_program on tbl_shs_tor.SubNo = class_program.SubNo INNER JOIN tbl_section ON tbl_shs_tor.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID =tbl_employee.Emp_ID WHERE tbl_shs_tor.lrn='".$_SESSION['lrn']."' AND tbl_shs_tor.SemCode='".$_SESSION['Sem']."' AND tbl_shs_tor.SYCode='".$_SESSION['year']."' AND class_program.Semester='".$_SESSION['Sem']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['school_id']."' AND tbl_shs_tor.SecCode='".$_SESSION['SecCode']."' AND tbl_shs_tor.GradeNo='".$_SESSION['Grade']."' AND class_program.Grade='".$_SESSION['Grade']."' AND class_program.SecCode = '".$_SESSION['SecCode']."' GROUP BY class_program.SubNo ORDER BY LearningAreas Asc");
							
							while($row=mysqli_fetch_array($mysubject))
							{
									$no++;
							echo '<tr>
									<td style="text-align:center;">'.$no.'</td>
									<td>'.$row['LearningAreas'].'</td>
									<td style="text-align:center;"></td>
									<td style="text-align:center;"></td>
									<td style="text-align:center;"></td>
									<td style="text-align:center;">Passed</td>
									
								</tr>';
							}
						echo '</tbody>
						</table>';
						
?>
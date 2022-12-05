<?php
echo '<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th rowspan="2" width="5%">#</th>
									<th rowspan="2">Learning Areas</th>
									<th colspan="4" style="text-align:center;width:30%;">Quarter</th>
									<th rowspan="2" style="text-align:center;width:15%;">Final Rating</th>
									<th rowspan="2" style="text-align:center;width:15%;">Remarks</th>
									
								</tr>
								<tr>
									<th style="text-align:center;">1</th>
									<th style="text-align:center;">2</th>
									<th style="text-align:center;">3</th>
									<th style="text-align:center;">4</th>
								
									
								</tr>
							</thead>
							<tbody>';
							$no=0;
							$mysubject=mysqli_query($con,"SELECT * FROM junior_tor INNER JOIN class_program on junior_tor.SubNo = class_program.SubNo INNER JOIN tbl_element_subject ON junior_tor.SubNo = tbl_element_subject.SubNo INNER JOIN tbl_section ON junior_tor.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID =tbl_employee.Emp_ID WHERE junior_tor.lrn='".$_SESSION['lrn']."'  AND junior_tor.SYCode='".$_SESSION['year']."'  AND junior_tor.SecCode='".$_SESSION['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['school_id']."' AND junior_tor.GradeNo='".$_SESSION['Grade']."' AND class_program.Grade='".$_SESSION['Grade']."' AND class_program.SecCode = '".$_SESSION['SecCode']."' GROUP BY class_program.SubNo ORDER BY SequenceNo Asc");
						
							while($row=mysqli_fetch_array($mysubject))
							{
									$no++;
							echo '<tr>
									<td style="text-align:center;">'.$no.'</td>
									<td>'.$row['LearningAreas'].'</td>
									<td style="text-align:center;"></td>
									<td style="text-align:center;"></td>
									<td style="text-align:center;"></td>
									<td style="text-align:center;"></td>
									<td style="text-align:center;"></td>
									<td style="text-align:center;"></td>
									
								</tr>';
							}
								$mymapeh=mysqli_query($con,"SELECT * FROM tbl_mapeh_break ORDER BY Sequence Asc");
								while($rowmap=mysqli_fetch_array($mymapeh))
								{
								$no++;
							echo '<tr>
									<td style="text-align:center;">'.$no.'</td>
									<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$rowmap['LearningAreas'].'</td>
									<td style="text-align:center;"></td>
									<td style="text-align:center;"></td>
									<td style="text-align:center;"></td>
									<td style="text-align:center;"></td>
									<td style="text-align:center;"></td>
									<td style="text-align:center;"></td>
									
								</tr>';	
								}
						echo '</tbody>
						</table>';
						
?>
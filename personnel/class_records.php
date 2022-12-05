<style>
td{
	text-transform:uppercase;
}
</style>
<?php
$result=mysqli_query($con,"SELECT * FROM tbl_section WHERE Emp_ID='".$_SESSION['EmpID']."' LIMIT 1");
$rowdata=mysqli_fetch_assoc($result);

if(mysqli_num_rows($result)==1)
{	
	
	echo '<div class="col-lg-12">
			    <div class="panel panel-default">
                    <div class="panel-heading">
						<h4>Subject Load</h4>			
					  </div>
					  <div class="panel-body">
					   <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th style="text-align:center;width:5%;" rowspan="2">#</th>
									<th rowspan="2">Learning Areas</th>
									<th colspan="3" style="text-align:center;width:40%;">Schedules</th>
									<th width="5%" rowspan="2"></th>
								</tr>				
								<tr>
									<th style="text-align:center;">Time</th>
									<th style="text-align:center;">Day</th>
									<th style="text-align:center;">Room</th>
								</tr>
								
							</thead>
							<tbody>';
							$no=0;
							
								$load=mysqli_query($con,"SELECT * FROM tbl_subject_load INNER JOIN tbl_section ON tbl_subject_load.SecCode=tbl_section.SecCode WHERE tbl_subject_load.Emp_ID='".$_SESSION['EmpID']."' AND tbl_subject_load.School_Year='".$_SESSION['year']."'");
								
								while($rowsubject=mysqli_fetch_array($load))	
								{
									$no++;
									echo '<tr>
											<td style="text-align:center;">'.$no.'</td>';	
											if ($rowsubject['Grade']==11 || $rowsubject['Grade']==12)
											{
											 $subject=mysqli_query($con,"SELECT * FROM tbl_senior_sub_strand INNER JOIN class_program ON tbl_senior_sub_strand.StrandsubCode = class_program.SubNo WHERE tbl_senior_sub_strand.StrandsubCode='".$rowsubject['SubCode']."' AND class_program.SchoolID ='".$_SESSION['SchoolID']."' AND class_program.SecCode='".$rowsubject['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.Grade='".$rowsubject['GradeLevel']."' LIMIT 1");
											}elseif ($rowsubject['Grade']>=7 AND $rowsubject['Grade']<=10){
											 $subject=mysqli_query($con,"SELECT * FROM tbl_jhs_subject INNER JOIN class_program ON tbl_jhs_subject.SubNo = class_program.SubNo WHERE tbl_jhs_subject.SubNo='".$rowsubject['SubCode']."' AND class_program.SchoolID ='".$_SESSION['SchoolID']."' AND class_program.SecCode='".$rowsubject['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.Grade='".$rowsubject['GradeLevel']."' LIMIT 1");
											}else{
											 
											 $subject=mysqli_query($con,"SELECT * FROM tbl_element_subject INNER JOIN class_program ON tbl_element_subject.SubNo = class_program.SubNo WHERE tbl_element_subject.SubNo='".$rowsubject['SubCode']."' AND class_program.SchoolID ='".$_SESSION['SchoolID']."' AND class_program.SecCode='".$rowsubject['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.Grade='".$rowsubject['GradeLevel']."' LIMIT 1");
											}
											
											$rowdata=mysqli_fetch_assoc($subject);	
											
										 echo '<td>'.$rowdata['LearningAreas'].'</td>';
									  echo '<td style="text-align:center;">'.$rowdata['SecTime'].'</td>	
											<td style="text-align:center;">'.$rowdata['SecDay'].'</td>';
											if ($rowsubject['Grade']=='Kinder')
											{
											echo '<td style="text-align:center;">'.$rowsubject['Grade'].'-'.$rowsubject['SecDesc'].'</td>';
											}else{
											echo '<td style="text-align:center;">Grade '.$rowsubject['Grade'].'-'.$rowsubject['SecDesc'].'</td>';	
											}
											
											
											echo '<td style="text-align:center;"><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Grade='.urlencode(base64_encode($rowsubject['Grade'])).'&SubNo='.urlencode(base64_encode($rowsubject['SubCode'])).'&SecCode='.urlencode(base64_encode($rowsubject['SecCode'])).'&v='.urlencode(base64_encode("class_list")).'">VIEW</a></td>	
											</tr>';
								}
					echo '</tbody>
					  </table>
				
					  </div>
				</div>
			</div>
			';
}else{
	echo '<div class="col-lg-12">
			    <div class="panel panel-default">
                    <div class="panel-heading">
						<h4>Subject Load</h4>			
					  </div>
					  <div class="panel-body">
					  <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th style="text-align:center;width:5%;" rowspan="2">#</th>
									<th rowspan="2">Learning Areas</th>
									<th colspan="3" style="text-align:center;width:40%;">Schedules</th>
									<th width="5%" rowspan="2"></th>
								</tr>				
								<tr>
									<th style="text-align:center;">Time</th>
									<th style="text-align:center;">Day</th>
									<th style="text-align:center;">Room</th>
								</tr>
								
							</thead>
							<tbody>';
							$no=0;
								$load=mysqli_query($con,"SELECT * FROM tbl_subject_load INNER JOIN tbl_section ON tbl_subject_load.SecCode=tbl_section.SecCode WHERE tbl_subject_load.Emp_ID='".$_SESSION['EmpID']."' AND tbl_subject_load.School_Year='".$_SESSION['year']."'");
								
								while($rowsubject=mysqli_fetch_array($load))	
								{
									$no++;
									echo '<tr>
											<td style="text-align:center;">'.$no.'</td>';	
											if ($rowsubject['Grade']==11 || $rowsubject['Grade']==12)
											{
											 $subject=mysqli_query($con,"SELECT * FROM tbl_senior_sub_strand INNER JOIN class_program ON tbl_senior_sub_strand.StrandsubCode = class_program.SubNo WHERE tbl_senior_sub_strand.StrandsubCode='".$rowsubject['SubCode']."' AND class_program.SchoolID ='".$_SESSION['SchoolID']."' AND class_program.SecCode='".$rowsubject['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.Grade='".$rowsubject['GradeLevel']."' LIMIT 1");
											}elseif ($rowsubject['Grade']>=7 AND $rowsubject['Grade']<=10){
											 $subject=mysqli_query($con,"SELECT * FROM tbl_jhs_subject INNER JOIN class_program ON tbl_jhs_subject.SubNo = class_program.SubNo WHERE tbl_jhs_subject.SubNo='".$rowsubject['SubCode']."' AND class_program.SchoolID ='".$_SESSION['SchoolID']."' AND class_program.SecCode='".$rowsubject['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.Grade='".$rowsubject['GradeLevel']."' LIMIT 1");
											}else{
											 
											 $subject=mysqli_query($con,"SELECT * FROM tbl_element_subject INNER JOIN class_program ON tbl_element_subject.SubNo = class_program.SubNo WHERE tbl_element_subject.SubNo='".$rowsubject['SubCode']."' AND class_program.SchoolID ='".$_SESSION['SchoolID']."' AND class_program.SecCode='".$rowsubject['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.Grade='".$rowsubject['GradeLevel']."' LIMIT 1");
											}
											
											$rowdata=mysqli_fetch_assoc($subject);	
											
										 echo '<td>'.$rowdata['LearningAreas'].'</td>';
									  echo '<td style="text-align:center;">'.$rowdata['SecTime'].'</td>	
											<td style="text-align:center;">'.$rowdata['SecDay'].'</td>';
											if ($rowsubject['Grade']=='Kinder')
											{
											echo '<td style="text-align:center;">'.$rowsubject['Grade'].'-'.$rowsubject['SecDesc'].'</td>';
											}else{
											echo '<td style="text-align:center;">Grade '.$rowsubject['Grade'].'-'.$rowsubject['SecDesc'].'</td>';	
											}
											
											
											echo '<td style="text-align:center;"><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Grade='.urlencode(base64_encode($rowsubject['Grade'])).'&SubNo='.urlencode(base64_encode($rowsubject['SubCode'])).'&SecCode='.urlencode(base64_encode($rowsubject['SecCode'])).'&v='.urlencode(base64_encode("class_list")).'">VIEW</a></td>	
											</tr>';
								}
					echo '</tbody>
					  </table>
				
					  </div>
				</div>
			</div>';
}
?>
		
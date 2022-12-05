<a href="#seniorreport" class="btn btn-primary" data-toggle="modal" style="float:right;">Add new report</a><br/>
													
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
  <thead>
		<tr>
			<th colspan="8">CORE SUBJECT CENTRALLY DEVELOPED SLM</th>
																
		</tr>	
		<tr>
			<th width="30%" style="text-align:center;" rowspan="2">LEARNING AREAS </th>
			<th width="10%" style="text-align:center;" rowspan="2">WEEK # </th>
			<th width="10%" colspan="2">GRADE 11</th>
			<th width="10%" colspan="2">GRADE 12</th>
			<th width="7%" rowspan="2"></th>
																
		</tr>
		<tr>
			<th># of Learners</th>
			<th># of Distributed</th>
			<th># of Learners</th>
			<th># of Distributed</th>
		</tr>
												
	</thead>
	<tbody>
	<?php	
		//Grade11
		$g11total=$g12Total=$g11Learner=$g12Learner=0;
		$grade11core=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode=tbl_senior_sub_strand.StrandsubCode WHERE tbl_shs_report.SchoolID='".$_SESSION['school_id']."' AND tbl_shs_report.GradeLevel='11' AND tbl_shs_report.Developedby='Central' AND tbl_shs_report.Subject_type='12345' AND tbl_shs_report.QuarterNo ='".$_SESSION['quarter']."' AND tbl_shs_report.WeekNo='".$_SESSION['week']."' ");
		while($g11rowcore=mysqli_fetch_array($grade11core))
			{
				$g11total=$g11total+$g11rowcore['No_of_copies'];
				$g11Learner=$g11Learner+$g11rowcore['No_of_learner'];
				echo '<tr>
						<td>'.$g11rowcore['SubStrandDescription'].'</td>
						<td>'.$g11rowcore['WeekNo'].'</td>
						<td>'.$g11rowcore['No_of_learner'].'</td>
						<td>'.$g11rowcore['No_of_copies'].'</td>
						<td>0</td>
						<td>0</td>
						<td>
						<a href="update-senior.php?id='.$g11rowcore['SubNo'].'" data-target="#updatereport" data-toggle="modal" title="Edit" class="btn btn-primary" style="margin:4px;padding:4px;"><i class="fa fa-edit fa-fw"></i></a>
						&nbsp;|&nbsp;<a href="" class="btn btn-warning" style="margin:4px;padding:4px;"><i class="fa fa-trash-o fa-fw"></i></a>
						
						</td>			
					</tr>';	
			}
			
			//Grade12
			$grade12core=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode=tbl_senior_sub_strand.StrandsubCode WHERE tbl_shs_report.SchoolID='".$_SESSION['school_id']."' AND tbl_shs_report.GradeLevel='12' AND tbl_shs_report.Developedby='Central' AND tbl_shs_report.Subject_type='12345' AND tbl_shs_report.QuarterNo ='".$_SESSION['quarter']."' AND tbl_shs_report.WeekNo='".$_SESSION['week']."' ORDER BY tbl_shs_report.WeekNo Asc");
				while($g12rowcore=mysqli_fetch_array($grade12core))
				{
				$g12Total=$g12Total+$g12rowcore['No_of_copies'];
				$g12Learner=$g12Learner+$g12rowcore['No_of_learner'];
				echo '<tr>
					<td>'.$g12rowcore['SubStrandDescription'].'</td>
					<td>'.$g12rowcore['WeekNo'].'</td>
					<td>0</td>
					<td>0</td>
					<td>'.$g12rowcore['No_of_learner'].'</td>
					<td>'.$g12rowcore['No_of_copies'].'</td>
											
					<td>
					   <a href="update-senior.php?id='.$g12rowcore['SubNo'].'"data-target="#updatereport" data-toggle="modal" title="Edit" class="btn btn-primary" style="margin:4px;padding:4px;"><i class="fa fa-edit fa-fw"></i></a>&nbsp;|&nbsp;<a href="" class="btn btn-warning" style="margin:4px;padding:4px;"><i class="fa fa-trash-o fa-fw"></i></a>
						</td>			
																
					</tr>';	
					}
					echo '<tr>
						<th colspan="2">Total:</th>
						<td>'.$g11Learner.'</td>
						<td>'.$g11total.'</td>
						<td>'.$g12Learner.'</td>
						<td>'.$g12Total.'</td>
					</tr>
					</tbody>
					</table>';
?>	
													
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
  <thead>
		<tr>
			<th colspan="8">APPLIED SUBJECT CENTRALLY DEVELOPED SLM</th>
																
		</tr>	
		<tr>
			<th width="30%" style="text-align:center;" rowspan="2">LEARNING AREAS </th>
			<th width="10%" style="text-align:center;" rowspan="2">WEEK # </th>
			<th width="10%" colspan="2">GRADE 11</th>
			<th width="10%" colspan="2">GRADE 12</th>
			<th width="7%" rowspan="2"></th>
																
		</tr>
		<tr>
			<th># of Learners</th>
			<th># of Distributed</th>
			<th># of Learners</th>
			<th># of Distributed</th>
		</tr>
												
	</thead>
	<tbody>
	<?php	
		//Grade11
		$g11total=$g12Total=$g11Learner=$g12Learner=0;
		$grade11core=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode=tbl_senior_sub_strand.StrandsubCode WHERE tbl_shs_report.SchoolID='".$_SESSION['school_id']."' AND tbl_shs_report.GradeLevel='11' AND tbl_shs_report.Developedby='Central' AND tbl_shs_report.Subject_type='12346' AND tbl_shs_report.QuarterNo ='".$_SESSION['quarter']."' AND tbl_shs_report.WeekNo='".$_SESSION['week']."' ");
		while($g11rowcore=mysqli_fetch_array($grade11core))
			{
				$g11total=$g11total+$g11rowcore['No_of_copies'];
				$g11Learner=$g11Learner+$g11rowcore['No_of_learner'];
				echo '<tr>
						<td>'.$g11rowcore['SubStrandDescription'].'</td>
						<td>'.$g11rowcore['WeekNo'].'</td>
						<td>'.$g11rowcore['No_of_learner'].'</td>
						<td>'.$g11rowcore['No_of_copies'].'</td>
						<td>0</td>
						<td>0</td>
						<td>
					   <a href="update-senior.php?id='.$g12rowcore['SubNo'].'" data-target="#updatereport" data-toggle="modal" title="Edit"class="btn btn-primary" style="margin:4px;padding:4px;"><i class="fa fa-edit fa-fw"></i></a>&nbsp;|&nbsp;<a href="">D</a>
						</td>	
						</tr>';	
			}
			
			//Grade12
			$grade12core=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode=tbl_senior_sub_strand.StrandsubCode WHERE tbl_shs_report.SchoolID='".$_SESSION['school_id']."' AND tbl_shs_report.GradeLevel='12' AND tbl_shs_report.Developedby='Central' AND tbl_shs_report.Subject_type='12346' AND tbl_shs_report.QuarterNo ='".$_SESSION['quarter']."' AND tbl_shs_report.WeekNo='".$_SESSION['week']."' ORDER BY tbl_shs_report.WeekNo Asc");
				while($g12rowcore=mysqli_fetch_array($grade12core))
				{
				$g12Total=$g12Total+$g12rowcore['No_of_copies'];
				$g12Learner=$g12Learner+$g12rowcore['No_of_learner'];
				echo '<tr>
					<td>'.$g12rowcore['SubStrandDescription'].'</td>
					<td>'.$g12rowcore['WeekNo'].'</td>
					<td>0</td>
					<td>0</td>
					<td>'.$g12rowcore['No_of_learner'].'</td>
					<td>'.$g12rowcore['No_of_copies'].'</td>
											
					<td>
					   <a href="update-senior.php?id='.$g12rowcore['SubNo'].'" data-target="#updatereport" data-toggle="modal" title="Edit"class="btn btn-primary" style="margin:4px;padding:4px;"><i class="fa fa-edit fa-fw"></i></a>&nbsp;|&nbsp;<a href="">D</a>
						</td>			
																
					</tr>';	
					}
					echo '<tr>
						<th colspan="2">Total:</th>
						<td>'.$g11Learner.'</td>
						<td>'.$g11total.'</td>
						<td>'.$g12Learner.'</td>
						<td>'.$g12Total.'</td>
					</tr>
					</tbody>
					</table>';
?>					

													
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
  <thead>
		<tr>
			<th colspan="8">SPECIALIZED SUBJECT CENTRALLY DEVELOPED SLM</th>
																
		</tr>	
		<tr>
			<th width="30%" style="text-align:center;" rowspan="2">LEARNING AREAS </th>
			<th width="10%" style="text-align:center;" rowspan="2">WEEK # </th>
			<th width="10%" colspan="2">GRADE 11</th>
			<th width="10%" colspan="2">GRADE 12</th>
			<th width="7%" rowspan="2"></th>
																
		</tr>
		<tr>
			<th># of Learners</th>
			<th># of Distributed</th>
			<th># of Learners</th>
			<th># of Distributed</th>
		</tr>
												
	</thead>
	<tbody>
	<?php	
		//Grade11
		$g11total=$g12Total=$g11Learner=$g12Learner=0;
		$grade11core=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode=tbl_senior_sub_strand.StrandsubCode WHERE tbl_shs_report.SchoolID='".$_SESSION['school_id']."' AND tbl_shs_report.GradeLevel='11' AND tbl_shs_report.Developedby='Central' AND tbl_shs_report.Subject_type='12347' AND tbl_shs_report.QuarterNo ='".$_SESSION['quarter']."' AND tbl_shs_report.WeekNo='".$_SESSION['week']."' ");
		while($g11rowcore=mysqli_fetch_array($grade11core))
			{
				$g11total=$g11total+$g11rowcore['No_of_copies'];
				$g11Learner=$g11Learner+$g11rowcore['No_of_learner'];
				echo '<tr>
						<td>'.$g11rowcore['SubStrandDescription'].'</td>
						<td>'.$g11rowcore['WeekNo'].'</td>
						<td>'.$g11rowcore['No_of_learner'].'</td>
						<td>'.$g11rowcore['No_of_copies'].'</td>
						<td>0</td>
						<td>0</td>
						<td>
					   <a href="update-senior.php?=id'.$g12rowcore['SubNo'].'"data-target="#updatereport" data-toggle="modal" title="Edit"class="btn btn-primary" style="margin:4px;padding:4px;"><i class="fa fa-edit fa-fw"></i></a>&nbsp;|&nbsp;<a href="">D</a>
						</td>	</tr>';	
			}
			
			//Grade12
			$grade12core=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode=tbl_senior_sub_strand.StrandsubCode WHERE tbl_shs_report.SchoolID='".$_SESSION['school_id']."' AND tbl_shs_report.GradeLevel='12' AND tbl_shs_report.Developedby='Central' AND tbl_shs_report.Subject_type='12347' AND tbl_shs_report.QuarterNo ='".$_SESSION['quarter']."' AND tbl_shs_report.WeekNo='".$_SESSION['week']."' ORDER BY tbl_shs_report.WeekNo Asc");
				while($g12rowcore=mysqli_fetch_array($grade12core))
				{
				$g12Total=$g12Total+$g12rowcore['No_of_copies'];
				$g12Learner=$g12Learner+$g12rowcore['No_of_learner'];
				echo '<tr>
					<td>'.$g12rowcore['SubStrandDescription'].'</td>
					<td>'.$g12rowcore['WeekNo'].'</td>
					<td>0</td>
					<td>0</td>
					<td>'.$g12rowcore['No_of_learner'].'</td>
					<td>'.$g12rowcore['No_of_copies'].'</td>
											
					<td>
					   <a href="update-senior.php?id='.$g12rowcore['SubNo'].'"data-target="#updatereport" data-toggle="modal" title="Edit"class="btn btn-primary" style="margin:4px;padding:4px;"><i class="fa fa-edit fa-fw"></i></a>&nbsp;|&nbsp;<a href="">D</a>
						</td>				
																
					</tr>';	
					}
					echo '<tr>
						<th colspan="2">Total:</th>
						<td>'.$g11Learner.'</td>
						<td>'.$g11total.'</td>
						<td>'.$g12Learner.'</td>
						<td>'.$g12Total.'</td>
					</tr>
					</tbody>
					</table>';
?>					
	<!--Locally developed-->

													
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
  <thead>
		<tr>
			<th colspan="8">CORE SUBJECT LOCALLY DEVELOPED SLM</th>
																
		</tr>	
		<tr>
			<th width="30%" style="text-align:center;" rowspan="2">LEARNING AREAS </th>
			<th width="10%" style="text-align:center;" rowspan="2">WEEK # </th>
			<th width="10%" colspan="2">GRADE 11</th>
			<th width="10%" colspan="2">GRADE 12</th>
			<th width="7%" rowspan="2"></th>
																
		</tr>
		<tr>
			<th># of Learners</th>
			<th># of Distributed</th>
			<th># of Learners</th>
			<th># of Distributed</th>
		</tr>
												
	</thead>
	<tbody>
	<?php	
		//Grade11
		$g11total=$g12Total=$g11Learner=$g12Learner=0;
		$grade11core=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode=tbl_senior_sub_strand.StrandsubCode WHERE tbl_shs_report.SchoolID='".$_SESSION['school_id']."' AND tbl_shs_report.GradeLevel='11' AND tbl_shs_report.Developedby='Local' AND tbl_shs_report.Subject_type='12345' AND tbl_shs_report.QuarterNo ='".$_SESSION['quarter']."' AND tbl_shs_report.WeekNo='".$_SESSION['week']."' ");
		while($g11rowcore=mysqli_fetch_array($grade11core))
			{
				$g11total=$g11total+$g11rowcore['No_of_copies'];
				$g11Learner=$g11Learner+$g11rowcore['No_of_learner'];
				echo '<tr>
						<td>'.$g11rowcore['SubStrandDescription'].'</td>
						<td>'.$g11rowcore['WeekNo'].'</td>
						<td>'.$g11rowcore['No_of_learner'].'</td>
						<td>'.$g11rowcore['No_of_copies'].'</td>
						<td>0</td>
						<td>0</td>
						<td>
					   <a href="update-senior.php?id='.$g12rowcore['SubNo'].'"data-target="#updatereport" data-toggle="modal" title="Edit"class="btn btn-primary" style="margin:4px;padding:4px;"><i class="fa fa-edit fa-fw"></i></a>&nbsp;|&nbsp;<a href="">D</a>
						</td>	</tr>';	
			}
			
			//Grade12
			$grade12core=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode=tbl_senior_sub_strand.StrandsubCode WHERE tbl_shs_report.SchoolID='".$_SESSION['school_id']."' AND tbl_shs_report.GradeLevel='12' AND tbl_shs_report.Developedby='Local' AND tbl_shs_report.Subject_type='12345' AND tbl_shs_report.QuarterNo ='".$_SESSION['quarter']."' AND tbl_shs_report.WeekNo='".$_SESSION['week']."' ORDER BY tbl_shs_report.WeekNo Asc");
				while($g12rowcore=mysqli_fetch_array($grade12core))
				{
				$g12Total=$g12Total+$g12rowcore['No_of_copies'];
				$g12Learner=$g12Learner+$g12rowcore['No_of_learner'];
				echo '<tr>
					<td>'.$g12rowcore['SubStrandDescription'].'</td>
					<td>'.$g12rowcore['WeekNo'].'</td>
					<td>0</td>
					<td>0</td>
					<td>'.$g12rowcore['No_of_learner'].'</td>
					<td>'.$g12rowcore['No_of_copies'].'</td>
											
					<td>
					   <a href="update-senior.php?id='.$g12rowcore['SubNo'].'data-target="#updatereport" data-toggle="modal" title="Edit"class="btn btn-primary" style="margin:4px;padding:4px;"><i class="fa fa-edit fa-fw"></i></a>&nbsp;|&nbsp;<a href="">D</a>
						</td>				
																
					</tr>';	
					}
					echo '<tr>
						<th colspan="2">Total:</th>
						<td>'.$g11Learner.'</td>
						<td>'.$g11total.'</td>
						<td>'.$g12Learner.'</td>
						<td>'.$g12Total.'</td>
					</tr>
					</tbody>
					</table>';
?>	
													
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
  <thead>
		<tr>
			<th colspan="8">APPLIED SUBJECT LOCALLY DEVELOPED SLM</th>
																
		</tr>	
		<tr>
			<th width="30%" style="text-align:center;" rowspan="2">LEARNING AREAS </th>
			<th width="10%" style="text-align:center;" rowspan="2">WEEK # </th>
			<th width="10%" colspan="2">GRADE 11</th>
			<th width="10%" colspan="2">GRADE 12</th>
			<th width="7%" rowspan="2"></th>
																
		</tr>
		<tr>
			<th># of Learners</th>
			<th># of Distributed</th>
			<th># of Learners</th>
			<th># of Distributed</th>
		</tr>
												
	</thead>
	<tbody>
	<?php	
		//Grade11
		$g11total=$g12Total=$g11Learner=$g12Learner=0;
		$grade11core=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode=tbl_senior_sub_strand.StrandsubCode WHERE tbl_shs_report.SchoolID='".$_SESSION['school_id']."' AND tbl_shs_report.GradeLevel='11' AND tbl_shs_report.Developedby='Local' AND tbl_shs_report.Subject_type='12346' AND tbl_shs_report.QuarterNo ='".$_SESSION['quarter']."' AND tbl_shs_report.WeekNo='".$_SESSION['week']."' ");
		while($g11rowcore=mysqli_fetch_array($grade11core))
			{
				$g11total=$g11total+$g11rowcore['No_of_copies'];
				$g11Learner=$g11Learner+$g11rowcore['No_of_learner'];
				echo '<tr>
						<td>'.$g11rowcore['SubStrandDescription'].'</td>
						<td>'.$g11rowcore['WeekNo'].'</td>
						<td>'.$g11rowcore['No_of_learner'].'</td>
						<td>'.$g11rowcore['No_of_copies'].'</td>
						<td>0</td>
						<td>0</td>
						<td>
					   <a href="update-senior.php?id='.$g12rowcore['SubNo'].'"data-target="#updatereport" data-toggle="modal" title="Edit"class="btn btn-primary" style="margin:4px;padding:4px;"><i class="fa fa-edit fa-fw"></i></a>&nbsp;|&nbsp;<a href="">D</a>
						</td>	</tr>';	
			}
			
			//Grade12
			$grade12core=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode=tbl_senior_sub_strand.StrandsubCode WHERE tbl_shs_report.SchoolID='".$_SESSION['school_id']."' AND tbl_shs_report.GradeLevel='12' AND tbl_shs_report.Developedby='Local' AND tbl_shs_report.Subject_type='12346' AND tbl_shs_report.QuarterNo ='".$_SESSION['quarter']."' AND tbl_shs_report.WeekNo='".$_SESSION['week']."' ORDER BY tbl_shs_report.WeekNo Asc");
				while($g12rowcore=mysqli_fetch_array($grade12core))
				{
				$g12Total=$g12Total+$g12rowcore['No_of_copies'];
				$g12Learner=$g12Learner+$g12rowcore['No_of_learner'];
				echo '<tr>
					<td>'.$g12rowcore['SubStrandDescription'].'</td>
					<td>'.$g12rowcore['WeekNo'].'</td>
					<td>0</td>
					<td>0</td>
					<td>'.$g12rowcore['No_of_learner'].'</td>
					<td>'.$g12rowcore['No_of_copies'].'</td>
											
					<td>
					   <a href="update-senior.php?id='.$g12rowcore['SubNo'].'"data-target="#updatereport" data-toggle="modal" title="Edit"class="btn btn-primary" style="margin:4px;padding:4px;"><i class="fa fa-edit fa-fw"></i></a>&nbsp;|&nbsp;<a href="">D</a>
						</td>				
																
					</tr>';	
					}
					echo '<tr>
						<th colspan="2">Total:</th>
						<td>'.$g11Learner.'</td>
						<td>'.$g11total.'</td>
						<td>'.$g12Learner.'</td>
						<td>'.$g12Total.'</td>
					</tr>
					</tbody>
					</table>';
?>					

													
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
  <thead>
		<tr>
			<th colspan="8">SPECIALIZED SUBJECT LOCALLY DEVELOPED SLM</th>
																
		</tr>	
		<tr>
			<th width="30%" style="text-align:center;" rowspan="2">LEARNING AREAS </th>
			<th width="10%" style="text-align:center;" rowspan="2">WEEK # </th>
			<th width="10%" colspan="2">GRADE 11</th>
			<th width="10%" colspan="2">GRADE 12</th>
			<th width="7%" rowspan="2"></th>
																
		</tr>
		<tr>
			<th># of Learners</th>
			<th># of Distributed</th>
			<th># of Learners</th>
			<th># of Distributed</th>
		</tr>
												
	</thead>
	<tbody>
	<?php	
		//Grade11
		$g11total=$g12Total=$g11Learner=$g12Learner=0;
		$grade11core=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode=tbl_senior_sub_strand.StrandsubCode WHERE tbl_shs_report.SchoolID='".$_SESSION['school_id']."' AND tbl_shs_report.GradeLevel='11' AND tbl_shs_report.Developedby='Local' AND tbl_shs_report.Subject_type='12347' AND tbl_shs_report.QuarterNo ='".$_SESSION['quarter']."' AND tbl_shs_report.WeekNo='".$_SESSION['week']."' ");
		while($g11rowcore=mysqli_fetch_array($grade11core))
			{
				$g11total=$g11total+$g11rowcore['No_of_copies'];
				$g11Learner=$g11Learner+$g11rowcore['No_of_learner'];
				echo '<tr>
						<td>'.$g11rowcore['SubStrandDescription'].'</td>
						<td>'.$g11rowcore['WeekNo'].'</td>
						<td>'.$g11rowcore['No_of_learner'].'</td>
						<td>'.$g11rowcore['No_of_copies'].'</td>
						<td>0</td>
						<td>0</td>
						<td>
					   <a href="update-senior.php?id='.$g12rowcore['SubNo'].'"data-target="#updatereport" data-toggle="modal" title="Edit"class="btn btn-primary" style="margin:4px;padding:4px;"><i class="fa fa-edit fa-fw"></i></a>&nbsp;|&nbsp;<a href="">D</a>
						</td>	</tr>';	
			}
			
			//Grade12
			$grade12core=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode=tbl_senior_sub_strand.StrandsubCode WHERE tbl_shs_report.SchoolID='".$_SESSION['school_id']."' AND tbl_shs_report.GradeLevel='12' AND tbl_shs_report.Developedby='Local' AND tbl_shs_report.Subject_type='12347' AND tbl_shs_report.QuarterNo ='".$_SESSION['quarter']."' AND tbl_shs_report.WeekNo='".$_SESSION['week']."' ORDER BY tbl_shs_report.WeekNo Asc");
				while($g12rowcore=mysqli_fetch_array($grade12core))
				{
				$g12Total=$g12Total+$g12rowcore['No_of_copies'];
				$g12Learner=$g12Learner+$g12rowcore['No_of_learner'];
				echo '<tr>
					<td>'.$g12rowcore['SubStrandDescription'].'</td>
					<td>'.$g12rowcore['WeekNo'].'</td>
					<td>0</td>
					<td>0</td>
					<td>'.$g12rowcore['No_of_learner'].'</td>
					<td>'.$g12rowcore['No_of_copies'].'</td>
											
					<td>
					   <a href="update-senior.php?id='.$g12rowcore['SubNo'].'" data-target="#updatereport" data-toggle="modal" title="Edit"class="btn btn-primary" style="margin:4px;padding:4px;"><i class="fa fa-edit fa-fw"></i></a>&nbsp;|&nbsp;<a href="">D</a>
						</td>				
																
					</tr>';	
					}
					echo '<tr>
						<th colspan="2">Total:</th>
						<td>'.$g11Learner.'</td>
						<td>'.$g11total.'</td>
						<td>'.$g12Learner.'</td>
						<td>'.$g12Total.'</td>
					</tr>
					</tbody>
					</table>';
?>					
																																			

<!--<a href="#seniorreport" class="btn btn-primary" data-toggle="modal" style="float:right;">Add new Strand/Track</a><br/>-->
<h4 style="text-transform:uppercase;width:100%;">List of Strand</h4>
<div class="col-lg-6">
<h4 style="text-align:center;text-transform:uppercase;width:100%;">Grade 11 Qualification offering</h4>
<table width="100%" class="table table-striped table-bordered table-hover">
  <thead>
		
		<tr>
			<th width="5%" style="text-align:center;" >#</th>
			<th width="40%" style="text-align:center;" >Qualification</th>
		    <th width="10%"># of Learner</th>
		    <th width="10%"># of Module</th>
		    <th width="5%"></th>
																
		</tr>
												
	</thead>
	<tbody>
		<?php
		$no=0;
		
		$result=mysqli_query($con,"SELECT * FROM tbl_qualification_by_school INNER JOIN tbl_qualification ON tbl_qualification_by_school.QualCode=tbl_qualification.SpCode WHERE tbl_qualification.Grade='11' AND tbl_qualification_by_school.SchoolID='".$_SESSION['school_id']."' AND tbl_qualification_by_school.QualSem ='".$_SESSION['Sem']."'ORDER BY tbl_qualification.Strand Asc");	
		
		while($row=mysqli_fetch_array($result))
		{
			$no++;
			$totLearner=$totModule=0;
			if ($_SESSION['Sem']=='First Semester')
				{
				$learner=mysqli_query($con,"SELECT * FROM first_semester WHERE SpCode='".$row['QualCode']."' AND SchoolID='".$_SESSION['school_id']."' AND school_year='".$_SESSION['year']."' AND Grade='11'");	
				}elseif ($_SESSION['Sem']=='Second Semester'){
				$learner=mysqli_query($con,"SELECT * FROM second_semester WHERE SpCode='".$row['QualCode']."' AND SchoolID='".$_SESSION['school_id']."' AND school_year='".$_SESSION['year']."' AND Grade='11'");
				}	
				$module=mysqli_query($con,"SELECt * FROM tbl_shs_report WHERE tbl_shs_report.SchoolID='".$_SESSION['school_id']."'  AND tbl_shs_report.WeekNo='".$_SESSION['week']."' AND tbl_shs_report.QuarterNo='".$_SESSION['quarter']."' AND tbl_shs_report.SpecCode='".$row['QualCode']."' ");
													
				while($no_of_module=mysqli_fetch_assoc($module))
			{
				$totModule=$totModule+$no_of_module['No_of_copies'];
				//$totLearner=$totLearner+$no_of_module['No_of_learner'];
			}
			echo '<tr>
			<td style="text-align:center;" >'.$no.'</td>
			<td>'.$row['Description'].'</td>
		    <td style="text-align:center;">';
			if (mysqli_num_rows($learner)==0)
			{
				echo 'Please Enroll your Learners.';
			}else{
					echo mysqli_num_rows($learner);
			}
			echo '</td>
		    <td style="text-align:center;">'.$totModule.'</td>
		    <td style="text-align:center;"> 
			<a href="./?'.$link.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&g='.urlencode(base64_encode($row['Grade'])).'&code='.urlencode(base64_encode($row['SpCode'])).'&v='.urlencode(base64_encode("view_qualification")).'" class="btn btn-primary" style="margin:4px;padding:4px;"><i class="fa fa-desktop fa-fw"></i></a> 
			
			</td>
																
		</tr>';
		}
	   
		?>
	</tbody>
	</table>
	</div>
	
<div class="col-lg-6">
<h4 style="text-align:center;text-transform:uppercase;width:100%;">Grade 12 Qualification offering</h4>
<table width="100%" class="table table-striped table-bordered table-hover">
  <thead>
		
		<tr>
			<th width="5%" style="text-align:center;" >#</th>
			<th width="40%" style="text-align:center;" >Qualification</th>
		    <th width="10%"># of Learner</th>
		    <th width="10%"># of Module</th>
		    <th width="5%"></th>
																
		</tr>
												
	</thead>
	<tbody>
		<?php
		$no=0;
		$result=mysqli_query($con,"SELECT * FROM tbl_qualification_by_school INNER JOIN tbl_qualification ON tbl_qualification_by_school.QualCode=tbl_qualification.SpCode WHERE tbl_qualification.Grade='12' AND tbl_qualification_by_school.SchoolID='".$_SESSION['school_id']."' AND tbl_qualification_by_school.QualSem ='".$_SESSION['Sem']."' ORDER BY Strand Asc");
		while($row=mysqli_fetch_array($result))
		{
			$no++;
			$totLearner=$totModule=0;
			if ($_SESSION['Sem']=='First Semester')
				{
				$learner=mysqli_query($con,"SELECT * FROM first_semester WHERE SpCode='".$row['QualCode']."' AND SchoolID='".$_SESSION['school_id']."' AND school_year='".$_SESSION['year']."' AND Grade='12'");	
				}elseif ($_SESSION['Sem']=='Second Semester'){
				$learner=mysqli_query($con,"SELECT * FROM second_semester WHERE SpCode='".$row['QualCode']."' AND SchoolID='".$_SESSION['school_id']."' AND school_year='".$_SESSION['year']."' AND Grade='12'");
				}	
			$module=mysqli_query($con,"SELECt * FROM tbl_shs_report WHERE tbl_shs_report.SpecCode='".$row['QualCode']."' AND tbl_shs_report.SchoolID='".$_SESSION['school_id']."'  AND tbl_shs_report.WeekNo='".$_SESSION['week']."' AND tbl_shs_report.QuarterNo='".$_SESSION['quarter']."'");
			while($no_of_module=mysqli_fetch_assoc($module))
			{
				$totModule=$totModule+$no_of_module['No_of_copies'];
				$totLearner=$totLearner+$no_of_module['No_of_learner'];
			}			
			echo '<tr>
			<td style="text-align:center;" >'.$no.'</td>
			<td>'.$row['Description'].'</td>
		    <td style="text-align:center;">';
			if (mysqli_num_rows($learner)==0)
			{
				echo 'Please Enroll your Learners.';
			}else{
					echo mysqli_num_rows($learner);
			}
			echo '</td>
		    <td style="text-align:center;">'.$totModule.'</td>
		    <td style="text-align:center;"> 
			<a href="./?'.$link.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&g='.urlencode(base64_encode($row['Grade'])).'&code='.urlencode(base64_encode($row['SpCode'])).'&v='.urlencode(base64_encode("view_qualification")).'"class="btn btn-primary" style="margin:4px;padding:4px;"><i class="fa fa-desktop fa-fw"></i></a> 
		
																
		</tr>';
		}
	   
		?>
	</tbody>
	</table>
	</div>
	
	
 <script>
	
		function delete_date(id)
		{
			if(confirm("Are you sure you want to deleted?"))
			{
				window.location.href='delete_strand.php?id='+id;
			}
		}
	
	
	</script>   	